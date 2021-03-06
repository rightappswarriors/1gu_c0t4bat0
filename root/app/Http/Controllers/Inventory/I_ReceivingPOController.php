<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class I_ReceivingPOController extends Controller
{
    private $stk_trns_type = "P";
    private $module = "Receiving Purchase Order";

    public function view()
    {
        $data = Inventory::getReceivingPO();

        return view('inventory.receivingpo', compact('data'));
    }

    public function add(Request $request)
    {
        if($request->isMethod('get'))
        {
            $supplier = Core::getAll('rssys.m07');
            $stock_loc = Core::getAll('rssys.whouse');
            $branch = Core::getAll('rssys.branch');
            $modeofpayment = Core::getAll('rssys.m10');
            $itemunit = Core::getAll('rssys.itmunit');
            $costcenter = Core::getAll('rssys.m08');
            $subcostcenter = Core::getAll('rssys.subctr');
            $vat = Core::getAll('rssys.vat');

            $sql = "SELECT i.item_code, COALESCE(SUM(st.qty_in),0.00) - COALESCE(SUM(st.qty_out),0.00) AS qty_onhand_su, i.part_no, i.cartype, i.item_desc, iu.unit_shortcode AS sale_unit, i.sales_unit_id, b.brd_name, i.brd_code, i.sell_pric AS regular, i.sc_price AS senior, i.bin_loc, i.unit_cost, ig.grp_desc, i.item_grp, st.whs_code, w.whs_desc, CASE WHEN st.branch IS NULL THEN i.branch ELSE st.branch END AS branchcode, CASE WHEN branch.name IS NULL THEN ibranch.name ELSE branch.name END AS branchname, COALESCE(c_name, 'None') AS c_name, i.active AS active FROM rssys.items  i LEFT JOIN rssys.itmunit iu ON i.sales_unit_id=iu.unit_id LEFT JOIN rssys.brand b ON i.brd_code=b.brd_code LEFT JOIN rssys.itmgrp ig ON ig.item_grp=i.item_grp LEFT JOIN rssys.stkcrd st ON st.item_code=i.item_code LEFT JOIN rssys.whouse w ON w.whs_code=st.whs_code LEFT JOIN rssys.branch ON w.branch=branch.code LEFT JOIN rssys.branch ibranch ON i.branch=ibranch.code LEFT JOIN rssys.m07 m7 ON m7.c_code = i.supl_code GROUP BY i.item_code, i.part_no, i.cartype, i.item_desc,iu.unit_shortcode, i.sales_unit_id, b.brd_name, i.brd_code, i.sell_pric, i.sc_price, i.bin_loc, i.unit_cost, ig.grp_desc, i.item_grp, st.whs_code, w.whs_desc, branchcode, branchname, c_name ORDER BY item_code";

            $disp_items = Core::sql($sql);

            return view('inventory.receivingpo-create', compact('supplier', 'stock_loc', 'branch','modeofpayment', 'disp_items', 'itemunit', 'costcenter', 'subcostcenter', 'vat'));
        }
        else if($request->isMethod('post'))
        {
            $datetime = Carbon::now();
            $flag = "false";

            $table = 'rssys.rechdr';
            $tableln = "rssys.reclne";

            $getCode = Core::getm99One('rec_num');
            $code = $getCode->rec_num;
            $invoicedt = $request->invoicedt;
            $stock_loc = $request->stock_loc;
            $branch = $request->branch;
            $supl_code = $request->supl_code;
            $supl_name = $request->supl_name;
            $reference = $request->reference;
            $termsofpayment = $request->termsofpayment;
            $stk_ref = $this->stk_trns_type."#".$code;
            
            $data = ['rec_num' => $code, 
                     'supl_code' => $supl_code, 
                     'supl_name' => $supl_name, 
                     '_reference' => $reference, 
                     'trnx_date' => $invoicedt, 
                     'whs_code' => $stock_loc, 
                     'trn_type' => $this->stk_trns_type, 
                     'recipient' => strtoupper(Session::get('_user')['id']),
                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString(),
                     'payment_term' => $termsofpayment,
                     'branch' => $branch
                    ];

            if(Core::insertTable($table, $data, $this->module) == true)
            {
                Core::updatem99('rec_num', Core::get_nextincrementlimitchar($code, 8));

                foreach($request->tbl_itemlist as $tb)
                {
                    $data2 = ['rec_num' => $code, 
                              'ln_num' => $tb[0], 
                              'part_no' => $tb[1], 
                              'item_code' => $tb[2], 
                              'item_desc' => $tb[3], 
                              'recv_qty' => $tb[4], 
                              'unit' => $tb[5], 
                              'price' => $tb[7], 
                              'discount' => $tb[8], 
                              'ln_amnt' => $tb[9],
                              'net_amnt' => $tb[10], 
                              'ln_vat' => $tb[11],
                              'ln_vatamt' => $tb[12],
                              'cnt_code' => $tb[13],
                              'scc_code' => $tb[15]];

                    if(Core::insertTable($tableln, $data2, $this->module))
                    {
                         $stk_qty_in = "0";
                         $stk_qty_out = $tb[4];

                         $stkcrd = ['item_code' => $tb[2],
                                    'item_desc' => $tb[3],
                                    'unit' => $tb[5],
                                    'trnx_date' => $invoicedt,
                                    'reference' => $stk_ref,
                                    'qty_in' => $stk_qty_in,
                                    'qty_out' => $stk_qty_out,
                                    'fcp' => $tb[7],
                                    'price' => $tb[7],
                                    'whs_code' => $stock_loc,
                                    'supl_code' => $supl_code,
                                    'supl_name' => $supl_name,
                                    'trn_type' => $this->stk_trns_type,
                                    'branch' => $branch];

                         if(Inventory::saveToStkcrd($stkcrd))
                         { }
                         else
                         {
                           $flag = 'false';
                           break;
                         }          
                    }
                    else
                    {
                        $flag = 'false';
                        break;
                    }          
                }

                $flag = 'true';
            }
            else
            {
                $flag = 'false';
            }

            return $flag;    
        
        }
    }

    public function edit(Request $request, $code)
    {

      if($request->isMethod('get')) // for entry
      {
          $supplier = Core::getAll('rssys.m07');
          $stock_loc = Core::getAll('rssys.whouse');
          $branch = Core::getAll('rssys.branch');
          $modeofpayment = Core::getAll('rssys.m10');
          $itemunit = Core::getAll('rssys.itmunit');
          $costcenter = Core::getAll('rssys.m08');
          $subcostcenter = Core::getAll('rssys.subctr');
          $vat = Core::getAll('rssys.vat');
    
          $disp_items = Inventory::getItemSearch();
    
          $rechdr = Inventory::getReceivingPOHeader($code);
          $reclne = Inventory::getReceivingPOLine($code);
          $grandtotal = Inventory::getTotalAmtRPO($code);

    
          return view('inventory.receivingpo-edit', compact('rechdr', 'reclne', 'supplier', 'stock_loc', 'branch', 'modeofpayment', 'itemunit', 'costcenter', 'subcostcenter', 'vat', 'disp_items', 'grandtotal'));
      }
      elseif($request->isMethod('post'))
      {
          $datetime = Carbon::now();
          $flag = "false";

          $table = 'rssys.rechdr';
          $tableln = "rssys.reclne";

          $code = $code;
          $invoicedt = $request->invoicedt;
          $stock_loc = $request->stock_loc;
          $branch = $request->branch;
          $supl_code = $request->supl_code;
          $supl_name = $request->supl_name;
          $reference = $request->reference;
          $stk_ref = $this->stk_trns_type."#".$code;
          $termsofpayment = $request->termsofpayment;
            
          $data = ['supl_code' => $supl_code, 
                   'supl_name' => $supl_name, 
                   '_reference' => $reference, 
                   'trnx_date' => $invoicedt, 
                   'whs_code' => $stock_loc, 
                   'recipient' => strtoupper(Session::get('_user')['id']),
                   't_date' => $datetime->toDateString(),
                   't_time' => $datetime->toTimeString(),
                   'payment_term' => $termsofpayment,
                   'branch' => $branch
                  ];

          if(Core::updateTable($table, 'rec_num', $code, $data, $this->module) == true)
          {
              $del_dataln = [['rec_num', '=', $code]];
              $del_datastkcrd = [['reference', '=', $stk_ref]];

              Core::deleteTableMultiWhere($tableln, $del_dataln, $this->module);
              Core::deleteTableMultiWhere('rssys.stkcrd', $del_datastkcrd, 'StockCardDel');

              foreach($request->tbl_itemlist as $tb)
              {
                $data2 = ['rec_num' => $code, 
                          'ln_num' => $tb[0], 
                          'part_no' => $tb[1], 
                          'item_code' => $tb[2], 
                          'item_desc' => $tb[3], 
                          'recv_qty' => $tb[4], 
                          'unit' => $tb[5], 
                          'price' => $tb[7], 
                          'discount' => $tb[8], 
                          'ln_amnt' => $tb[9],
                          'net_amnt' => $tb[10], 
                          'ln_vat' => $tb[11],
                          'ln_vatamt' => $tb[12],
                          'cnt_code' => $tb[13],
                          'scc_code' => $tb[15]];

                if(Core::insertTable($tableln, $data2, $this->module))
                {
                    $stk_qty_in = "0";
                    $stk_qty_out = $tb[4];

                    $stkcrd = ['item_code' => $tb[2],
                               'item_desc' => $tb[3],
                               'unit' => $tb[5],
                               'trnx_date' => $invoicedt,
                               'reference' => $stk_ref,
                               'qty_in' => $stk_qty_in,
                               'qty_out' => $stk_qty_out,
                               'fcp' => $tb[7],
                               'price' => $tb[7],
                               'whs_code' => $stock_loc,
                               'supl_code' => $supl_code,
                               'supl_name' => $supl_name,
                               'trn_type' => $this->stk_trns_type,
                               'branch' => $branch];

                     if(Inventory::saveToStkcrd($stkcrd))
                     {

                     }
                     else
                     {
                       $flag = 'false';
                       break;
                     }          
                }
                else
                {
                    $flag = 'false';
                    break;
                }          
              }

              $flag = 'true';
          }
          else
          {
              $flag = 'false';
          }

          return $flag;   
      } 
    }

    public function cancel($code)
    {
      $stk_ref = $this->stk_trns_type."#".$code;
      $table = "rssys.rechdr";
      $col = "rec_num";
      $flag = 'false';

      if(Inventory::cancelReceivingPO($code, $stk_ref, $table, $col, $this->module))
      {
        $flag = 'true';
      }

      return $flag;
    }

    public function print($code)
    {
      $rechdr = Inventory::getReceivingPOHeader($code);
      $reclne = Inventory::getReceivingPOLine($code);

      return view('inventory.receivingpo-print', compact('rechdr', 'reclne'));
    }
}