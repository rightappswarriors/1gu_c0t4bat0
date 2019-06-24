<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class I_StockTransferController extends Controller
{
    private $stk_trns_type = "T";
    private $module = "Stock Transfer";

    public function view()
    {
        $data = Inventory::getStockTransfer();

        return view('inventory.stocktransfer', compact('data'));
    }

    public function add(Request $request)
    {
        if($request->isMethod('get')) // for entry
        {
            $stock_loc = Core::getAll('rssys.whouse');
            $branch = Core::getAll('rssys.branch');
            $itemunit = Core::getAll('rssys.itmunit');

            $disp_items = Inventory::getItemSearch();

            return view('inventory.stocktransfer-create', compact('stock_loc', 'branch', 'disp_items', 'itemunit'));
        }
        else if($request->isMethod('post')) // store entry
        {
            $datetime = Carbon::now();
            $flag = "false";

            $table = 'rssys.rechdr';
            $tableln = "rssys.reclne";

            $getCode = Core::getm99One('trf_num');
            $code = $getCode->trf_num;
            $invoicedt = $request->invoicedt;
            $stock_locfrom = $request->stock_locfrom;
            $stock_locto = $request->stock_locto;
            $branch = $request->branch;
            $reference = $request->reference;
            $stk_ref = $this->stk_trns_type."#".$code;

            $data = ['rec_num' => $code, 
                     '_reference' => $reference, 
                     'trnx_date' => $invoicedt, 
                     'locationFrom' => $stock_locfrom,
                     'locationTo' => $stock_locto,  
                     'trn_type' => $this->stk_trns_type, 
                     'recipient' => strtoupper(Session::get('_user')['id']),
                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString(),
                     'branch' => $branch
                    ];

            if(Core::insertTable($table, $data, $this->module) == 'true')
            {
                Core::updatem99('trf_num', Core::get_nextincrementlimitchar($code, 8));

                foreach($request->tbl_itemlist as $tb)
                {
                    $data2 = ['rec_num' => $code, 
                              'ln_num' => $tb[0], 
                              'part_no' => $tb[1], 
                              'item_code' => $tb[2], 
                              'item_desc' => $tb[3], 
                              'recv_qty' => $tb[4], 
                              'receiving_qty' => $tb[4], 
                              'unit' => $tb[5], 
                              'price' => $tb[7], 
                              'ln_amnt' => $tb[8]];

                    if(Core::insertTable($tableln, $data2, $this->module))
                    {
                         // insert to stkcrd stock location from, qty out.
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
                                    'whs_code' => $stock_locfrom,
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
               
          $disp_items = Inventory::getItemSearch();
    
          $rechdr = Inventory::getStockTransferHeader($rec_num);
          $reclne = Inventory::getStockTransferLine($rec_num);
          $grandtotal = Inventory::getTotalAmtStockTransfer($rec_num);
    
          return view('inventory.stocktransfer-edit', compact('rechdr', 'reclne', 'stock_loc', 'branch', 'itemunit', 'disp_items', 'grandtotal'));
      }
      elseif($request->isMethod('post'))
      {
          $datetime = Carbon::now();
          $flag = "false";

          $table = 'rssys.rechdr';
          $tableln = "rssys.reclne";

          $code = $rec_num;
          $invoicedt = $request->invoicedt;
          $stock_locfrom = $request->stock_locfrom;
          $stock_locto = $request->stock_locto;
          $branch = $request->branch;
          $reference = $request->reference;
          $stk_ref = $this->stk_trns_type."#".$code;
            
          $data = ['rec_num' => $code, 
                   '_reference' => $reference, 
                   'trnx_date' => $invoicedt, 
                   'locationFrom' => $stock_locfrom,
                   'locationTo' => $stock_locto,  
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
                          'receiving_qty' => $tb[4],
                          'unit' => $tb[5], 
                          'price' => $tb[7], 
                          'ln_amnt' => $tb[8]];

                if(Core::insertTable($tableln, $data2, $this->module))
                {
                    // insert to stkcrd stock location from, qty out.
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
                               'whs_code' => $stock_locfrom,
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

    public function cancel($code)
    {
      $stk_ref = $this->stk_trns_type."#".$code;
      $table = "rssys.rechdr";
      $col = "rec_num";
      $flag = 'false';

      if(Inventory::cancelStockTransfer($code, $stk_ref, $table, $col, $this->module))
      {
        $flag = 'true';
      }

      return $flag;
    }
}