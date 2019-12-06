<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class I_StockReleaseController extends Controller
{
    private $stk_trns_type = "SR";
    private $module = "Stock Release";

    public function view()
    {  
        $data = Inventory::getStockRelease();

        return view('inventory.stockrelease.stockrelease', compact('data'));
    }

    public function add(Request $request)
    {
        if($request->isMethod('get'))
        {
            $stock_loc = Core::getAll('rssys.whouse');
            $branch = Core::getAll('rssys.branch');
            $itemunit = Core::getAll('rssys.itmunit');
            $costcenter = Core::getAll('rssys.m08');
            $vat = Core::getAll('rssys.vat');
            $x08 = Core::getAll('rssys.x08');
            $are_position = Core::getAll('rssys.are_position');
            $isnew = true;

            $disp_items = Inventory::getItemSearch();

            return view('inventory.stockrelease.stockrelease-entry', compact('stock_loc', 'branch', 'disp_items', 'itemunit', 'costcenter', 'vat', 'isnew', 'x08', 'are_position'));
        }
        else if($request->isMethod('post'))
        {
            $datetime = Carbon::now();
            $flag = "false";

            $table = 'rssys.rechdr';
            $tableln = "rssys.reclne";

            $getCode = Core::getm99One('sr_code');
            $code = $getCode->sr_code;
            $invoicedt = $request->invoicedt;
            $stock_loc = $request->stock_loc;
            $reference = $request->reference;
            $costcenter = $request->costcenter;
            $ris_no = $request->ris_no;
            $sai_no = $request->sai_no;
            $personnel = $request->personnel;
            $designation = $request->receivedbydesig;
            $stk_ref = $this->stk_trns_type."#".$code;
            
            $data = ['rec_num' => $code,  
                     '_reference' => $reference, 
                     'trnx_date' => $invoicedt, 
                     'locationFrom' => $stock_loc, 
                     'trn_type' => $this->stk_trns_type, 
                     'cc_code' => $costcenter, 
                     'ris_no' => $ris_no, 
                     'sai_no' => $sai_no, 
                     'recipient' => strtoupper(Session::get('_user')['id']),
                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString(),
                     'personnel' => $personnel,
                     'approve' => 'true',
                     'are_receivebydesig' => $designation
                    ];        

            if(Core::insertTable($table, $data, $this->module) == true)
            {
                Core::updatem99('sr_code', Inventory::get_nextincrementwithchar($code));

                foreach($request->tbl_itemlist as $tb)
                {
                    $data2 = ['rec_num' => $code, 
                              'ln_num' => $tb[0], 
                              'part_no' => $tb[2], 
                              'item_code' => $tb[1], 
                              'item_desc' => $tb[5], 
                              'recv_qty' => $tb[6], 
                              'issued_qty' => $tb[7], 
                              'unit' => $tb[8]];

                    if(Core::insertTable($tableln, $data2, $this->module))
                    {
                         $stk_qty_in = "0";
                         $stk_qty_out = $tb[7];

                         $stkcrd = ['item_code' => $tb[1],
                                    'item_desc' => $tb[5],
                                    'unit' => $tb[8],
                                    'trnx_date' => $invoicedt,
                                    'reference' => $stk_ref,
                                    'qty_in' => $stk_qty_in,
                                    'qty_out' => $stk_qty_out,
                                    'fcp' => '0',
                                    'price' => '0',
                                    'whs_code' => $stock_loc,
                                    'trn_type' => $this->stk_trns_type];

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
          $stock_loc = Core::getAll('rssys.whouse');
          $branch = Core::getAll('rssys.branch');
          $itemunit = Core::getAll('rssys.itmunit');
          $costcenter = Core::getAll('rssys.m08');
          $vat = Core::getAll('rssys.vat');
          $x08 = Core::getAll('rssys.x08');
          $disp_items = Inventory::getItemSearch();
          $are_position = Core::getAll('rssys.are_position');
    
          $rechdr = Inventory::getStockReleaseHeader($code);
          $reclne = Inventory::getStockReleaseLine($code);
          $grandtotal = Inventory::getTotalAmtRIS($code);
          $isnew = false;

    
          return view('inventory.stockrelease.stockrelease-entry', compact('rechdr', 'reclne', 'stock_loc', 'branch', 'itemunit', 'costcenter', 'vat', 'disp_items', 'grandtotal', 'isnew', 'x08', 'are_position'));
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
          $personnel = $request->personnel;
          $designation = $request->receivedbydesig;
          $reference = $request->reference;
          $costcenter = $request->costcenter;
          $ris_no = $request->ris_no;
          $sai_no = $request->sai_no;
          $stk_ref = $this->stk_trns_type."#".$code;
            
          $data = ['_reference' => $reference, 
                   'trnx_date' => $invoicedt, 
                   'locationFrom' => $stock_loc, 
                   'cc_code' => $costcenter, 
                   'ris_no' => $ris_no, 
                   'sai_no' => $sai_no, 
                   'recipient' => strtoupper(Session::get('_user')['id']),
                   't_date' => $datetime->toDateString(),
                   't_time' => $datetime->toTimeString(),
                   'personnel' => $personnel,
                   'approve' => 'true',
                   'are_receivebydesig' => $designation
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
                          'part_no' => $tb[2], 
                          'item_code' => $tb[1], 
                          'item_desc' => $tb[5], 
                          'recv_qty' => $tb[6], 
                          'issued_qty' => $tb[7], 
                          'unit' => $tb[8]];

                if(Core::insertTable($tableln, $data2, $this->module))
                {
                    $stk_qty_in = "0";
                    $stk_qty_out = $tb[7];

                    $stkcrd = ['item_code' => $tb[1],
                               'item_desc' => $tb[5],
                               'unit' => $tb[8],
                               'trnx_date' => $invoicedt,
                               'reference' => $stk_ref,
                               'qty_in' => $stk_qty_in,
                               'qty_out' => $stk_qty_out,
                               'fcp' => '0',
                               'price' => '0',
                               'whs_code' => $stock_loc,
                               'trn_type' => $this->stk_trns_type];

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

      if(Inventory::cancelRIS($code, $stk_ref, $table, $col, $this->module))
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