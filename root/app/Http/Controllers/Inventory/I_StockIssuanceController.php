<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class I_StockIssuanceController extends Controller
{
    private $stk_trns_type = "I";
    private $module = "Stock Issuance";

    public function view()
    {
        $data = Inventory::getStockIssuance();

        return view('inventory.stockissuance', compact('data'));
    }

    public function add(Request $request)
    {
        if($request->isMethod('get')) // for entry
        {
            $stock_loc = Core::getAll('rssys.whouse');
            $branch = Core::getAll('rssys.branch');
            $itemunit = Core::getAll('rssys.itmunit');
            $costcenter = Core::getAll('rssys.m08');
            $subcostcenter = Core::getAll('rssys.subctr');

            $disp_items = Inventory::getItemSearch();

            return view('inventory.stockissuance-create', compact('stock_loc', 'branch', 'disp_items', 'itemunit', 'costcenter', 'subcostcenter'));
        }
        else if($request->isMethod('post')) // store entry
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
            $reference = $request->reference;
            $stk_ref = $this->stk_trns_type."#".$code;
            
            $data = ['rec_num' => $code, 
                     '_reference' => $reference, 
                     'trnx_date' => $invoicedt, 
                     'whs_code' => $stock_loc, 
                     'trn_type' => $this->stk_trns_type, 
                     'recipient' => strtoupper(Session::get('_user')['id']),
                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString(),
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
                              'ln_amnt' => $tb[8],
                              'notes' => $tb[9],
                              'cnt_code' => $tb[10], 
                              'scc_code' => $tb[12]];

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

    public function edit(Request $request, $rec_num)
    {

      if($request->isMethod('get')) // for entry
      {
          $stock_loc = Core::getAll('rssys.whouse');
          $branch = Core::getAll('rssys.branch');
          $itemunit = Core::getAll('rssys.itmunit');
          $costcenter = Core::getAll('rssys.m08');
          $subcostcenter = Core::getAll('rssys.subctr');
    
          $disp_items = Inventory::getItemSearch();
    
          $rechdr = Inventory::getStockIssuanceHeader($rec_num);
          $reclne = Inventory::getStockIssuanceLine($rec_num);
          $grandtotal = Inventory::getTotalAmtSI($rec_num);
    
          return view('inventory.stockissuance-edit', compact('rechdr', 'reclne', 'stock_loc', 'branch', 'itemunit', 'costcenter', 'subcostcenter', 'disp_items', 'grandtotal'));
      }
      elseif($request->isMethod('post'))
      {
          $datetime = Carbon::now();
          $flag = "false";

          $table = 'rssys.rechdr';
          $tableln = "rssys.reclne";

          $code = $rec_num;
          $invoicedt = $request->invoicedt;
          $stock_loc = $request->stock_loc;
          $branch = $request->branch;
          $reference = $request->reference;
          $stk_ref = $this->stk_trns_type."#".$code;
            
          $data = ['_reference' => $reference, 
                   'trnx_date' => $invoicedt, 
                   'whs_code' => $stock_loc, 
                   'trn_type' => $this->stk_trns_type, 
                   'recipient' => strtoupper(Session::get('_user')['id']),
                   't_date' => $datetime->toDateString(),
                   't_time' => $datetime->toTimeString(),
                   'branch' => $branch
                  ];

          if(Core::updateTable($table, 'rec_num', $code, $data, $this->module) == true)
          {
              $del_dataln = [['rec_num', '=', $code]];
              $del_datastkcrd = [['reference', '=', $stk_ref]];

              Core::deleteTableMultiWhere($tableln, $del_dataln, $this->module);
              Core::deleteTableMultiWhere('rssys.stkcrd', $del_datastkcrd, $this->module);

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
                          'ln_amnt' => $tb[8],
                          'notes' => $tb[9],
                          'cnt_code' => $tb[10], 
                          'scc_code' => $tb[12]];          

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

      if(Inventory::cancelStockIssuance($code, $stk_ref, $table, $col, $this->module))
      {
        $flag = 'true';
      }

      return $flag;
    }
}