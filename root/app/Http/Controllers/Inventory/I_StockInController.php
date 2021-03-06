<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class I_StockInController extends Controller
{
    private $stk_trns_type = "P";
    private $module = "Stock In";

    public function view()
    {
        $data = Inventory::getStockIn();
        $dtfrm = date("Y-m-01");
        $dtto = date("Y-m-d");

        return view('inventory.stockin.stockin', compact('data', 'dtfrm', 'dtto'));
    }

    public function viewpo()
    {
        $data = Inventory::getStockIn();
        $dtfrm = date("Y-m-01");
        $dtto = date("Y-m-d");

        return view('inventory.stockin.po.stockin', compact('data', 'dtfrm', 'dtto'));
    }

    public function viewFilterDate($date)
    {
        $date = explode(",", $date);

        $dtfrm = $date[0];
        $dtto = $date[1];
        
        $data = Inventory::getStockIn($dtfrm, $dtto);

        return $data;
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
            $isnew = true;

            $disp_items = Inventory::getItemSearch();

            return view('inventory.stockin.stockin-entry', compact('supplier', 'stock_loc', 'branch','modeofpayment', 'disp_items', 'itemunit', 'costcenter', 'subcostcenter', 'vat', 'isnew'));
        }
        else if($request->isMethod('post'))
        {
            $datetime = Carbon::now();
            $flag = "true";

            $table = 'rssys.rechdr';
            $tableln = "rssys.reclne";

            $getCode = Core::getm99One('stockin_code');
            $code = $getCode->stockin_code;
            
            if(empty($code))
            {
              return 'code is null.';
            }

            $invoicedt = $request->invoicedt;
            $stock_loc = $request->stock_loc;
            $branch = $request->branch;
            $supl_code = $request->supl_code;
            $supl_name = $request->supl_name;
            $reference = $request->reference;
            $purc_code = $request->purc_code;
            $stk_ref = $this->stk_trns_type."#".$code;
            
            $data = ['rec_num' => $code, 
                     'purc_ord' => $purc_code,
                     'supl_code' => $supl_code, 
                     'supl_name' => $supl_name, 
                     '_reference' => $reference, 
                     'trnx_date' => $invoicedt, 
                     'whs_code' => $stock_loc, 
                     'trn_type' => $this->stk_trns_type, 
                     'recipient' => strtoupper(Session::get('_user')['id']),
                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString(),
                     'branch' => $branch
                    ];

            // check if po_no entered already exist
            $cond = "trn_type = 'P' AND (cancel != 'Y' OR cancel isnull OR cancel = '') AND purc_ord = '$purc_code'";
            $checkifDataExist = Inventory::checkIfDataExist($table, $cond);

            if($checkifDataExist) // check if po_no entered already exist
            {
               return 'PO No entered already exist.';
            }
            else
            {   
                $insertHeader = Core::insertTable($table, $data, $this->module);        
                
                if($insertHeader == 'true')
                {
                    $updateM99 = Core::updatem99('stockin_code', Inventory::get_nextincrementwithchar($code));
    
                    if($updateM99 == 'true')
                    {
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
                                    'ln_vatamt' => $tb[12]];
                          
                          $insertLine = Core::insertTable($tableln, $data2, $this->module);
    
                          if($insertLine == 'true')
                          {
                               $stk_qty_in = $tb[4];
                               $stk_qty_out = "0";
      
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
      
                               $insertStkcrd = Inventory::saveToStkcrd($stkcrd);
    
                               if($insertStkcrd == 'true')
                               {
                                 $flag = 'true'; 
                               }
                               else
                               {
                                 return $insertStkcrd;
                               }          
                          }
                          else
                          {
                              return $insertLine;
                          }          
                      }
                    }
                    else
                    {
                      return $updateM99;
                    }
                }
                else
                {
                  return $insertHeader;
                }
            }

            return $flag;    
        
        }
    }

    public function addpo(Request $request)
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
            $isnew = true;

            $disp_items = Inventory::getItemSearch();

            return view('inventory.stockin.po.stockin-entry', compact('supplier', 'stock_loc', 'branch','modeofpayment', 'disp_items', 'itemunit', 'costcenter', 'subcostcenter', 'vat', 'isnew'));
        }
        else if($request->isMethod('post'))
        {
            $datetime = Carbon::now();
            $flag = "true";

            $table = 'rssys.rechdr';
            $tableln = "rssys.reclne";

            $getCode = Core::getm99One('stockin_code');
            $code = $getCode->stockin_code;
            
            if(empty($code))
            {
              return 'code is null.';
            }

            $invoicedt = $request->invoicedt;
            $stock_loc = $request->stock_loc;
            $branch = $request->branch;
            $supl_code = $request->supl_code;
            $supl_name = $request->supl_name;
            $reference = $request->reference;
            $purc_code = $request->purc_code;
            $stk_ref = $this->stk_trns_type."#".$code;
            
            $data = ['rec_num' => $code, 
                     'purc_ord' => $purc_code,
                     'supl_code' => $supl_code, 
                     'supl_name' => $supl_name, 
                     '_reference' => $reference, 
                     'trnx_date' => $invoicedt, 
                     'whs_code' => $stock_loc, 
                     'trn_type' => $this->stk_trns_type, 
                     'recipient' => strtoupper(Session::get('_user')['id']),
                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString(),
                     'branch' => $branch
                    ];

            // check if po_no entered already exist
            $cond = "trn_type = 'P' AND (cancel != 'Y' OR cancel isnull OR cancel = '') AND purc_ord = '$purc_code'";
            $checkifDataExist = Inventory::checkIfDataExist($table, $cond);

            if($checkifDataExist) // check if po_no entered already exist
            {
               return 'PO No entered already exist.';
            }
            else
            {   
                $insertHeader = Core::insertTable($table, $data, $this->module);        
                
                if($insertHeader == 'true')
                {
                    $updateM99 = Core::updatem99('stockin_code', Inventory::get_nextincrementwithchar($code));
    
                    if($updateM99 == 'true')
                    {
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
                                    'ln_vatamt' => $tb[12]];
                          
                          $insertLine = Core::insertTable($tableln, $data2, $this->module);
    
                          if($insertLine == 'true')
                          {
                               $stk_qty_in = $tb[4];
                               $stk_qty_out = "0";
      
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
      
                               $insertStkcrd = Inventory::saveToStkcrd($stkcrd);
    
                               if($insertStkcrd == 'true')
                               {
                                 $flag = 'true'; 
                               }
                               else
                               {
                                 return $insertStkcrd;
                               }          
                          }
                          else
                          {
                              return $insertLine;
                          }          
                      }
                    }
                    else
                    {
                      return $updateM99;
                    }
                }
                else
                {
                  return $insertHeader;
                }
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
    
          $rechdr = Inventory::getStockInHeader($code);
          $reclne = Inventory::getStockInLine($code);
          $grandtotal = Inventory::getTotalAmtStockIn($code);
          $isnew = false;
    
          return view('inventory.stockin.stockin-entry', compact('rechdr', 'reclne', 'supplier', 'stock_loc', 'branch', 'modeofpayment', 'itemunit', 'costcenter', 'subcostcenter', 'vat', 'disp_items', 'grandtotal', 'isnew'));
      }
      elseif($request->isMethod('post'))
      {
          $datetime = Carbon::now();
          $flag = "true";

          $table = 'rssys.rechdr';
          $tableln = "rssys.reclne";

          $code = $code;
          $purc_code = $request->purc_code;
          $invoicedt = $request->invoicedt;
          $stock_loc = $request->stock_loc;
          $branch = $request->branch;
          $supl_code = $request->supl_code;
          $supl_name = $request->supl_name;
          $reference = $request->reference;
          $stk_ref = $this->stk_trns_type."#".$code;
            
          $data = ['purc_ord' => $purc_code,
                   'supl_code' => $supl_code, 
                   'supl_name' => $supl_name, 
                   '_reference' => $reference, 
                   'trnx_date' => $invoicedt, 
                   'whs_code' => $stock_loc, 
                   'recipient' => strtoupper(Session::get('_user')['id']),
                   't_date' => $datetime->toDateString(),
                   't_time' => $datetime->toTimeString(),
                   'branch' => $branch
                  ];

          // check if po_no entered already exist
          $cond = "trn_type = 'P' AND (cancel != 'Y' OR cancel isnull OR cancel = '') AND purc_ord = '$purc_code' AND rec_num != '$code'";
          $checkifDataExist = Inventory::checkIfDataExist($table, $cond);

          if($checkifDataExist) // check if po_no entered already exist
          {
             return 'PO No entered already exist.';
          }
          else
          { 
             $updHeader = Core::updateTable($table, 'rec_num', $code, $data, $this->module);
             
             if($updHeader == 'true')
             {
                 $del_dataln = [['rec_num', '=', $code]];
                 $del_datastkcrd = [['reference', '=', $stk_ref]];
   
                 $delLine = Core::deleteTableMultiWhere($tableln, $del_dataln, $this->module);
                 $delStkcrd = Core::deleteTableMultiWhere('rssys.stkcrd', $del_datastkcrd, $this->module);
   
                 
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
                             'ln_vatamt' => $tb[12]];
   
                   $insertLine = Core::insertTable($tableln, $data2, $this->module);
                   if($insertLine == 'true')
                   {
                       $stk_qty_in = $tb[4];
                       $stk_qty_out = "0";
   
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
   
                        $insertStkcrd = Inventory::saveToStkcrd($stkcrd);
                        if($insertStkcrd == 'true')
                        {
                          $flag = 'true';
                        }
                        else
                        {
                          return $insertStkcrd;
                        }          
                   }
                   else
                   {
                       return $insertLine;
                   }          
                 }
                 
             }
             else
             {
                 return $updHeader;
             }
           }

          return $flag;   
      } 
    }

    public function editpo(Request $request, $code)
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
    
          $rechdr = Inventory::getStockInHeader($code);
          $reclne = Inventory::getStockInLine($code);
          $grandtotal = Inventory::getTotalAmtStockIn($code);
          $isnew = false;
    
          return view('inventory.stockin.po.stockin-entry', compact('rechdr', 'reclne', 'supplier', 'stock_loc', 'branch', 'modeofpayment', 'itemunit', 'costcenter', 'subcostcenter', 'vat', 'disp_items', 'grandtotal', 'isnew'));
      }
      elseif($request->isMethod('post'))
      {
          $datetime = Carbon::now();
          $flag = "true";

          $table = 'rssys.rechdr';
          $tableln = "rssys.reclne";

          $code = $code;
          $purc_code = $request->purc_code;
          $invoicedt = $request->invoicedt;
          $stock_loc = $request->stock_loc;
          $branch = $request->branch;
          $supl_code = $request->supl_code;
          $supl_name = $request->supl_name;
          $reference = $request->reference;
          $stk_ref = $this->stk_trns_type."#".$code;
            
          $data = ['purc_ord' => $purc_code,
                   'supl_code' => $supl_code, 
                   'supl_name' => $supl_name, 
                   '_reference' => $reference, 
                   'trnx_date' => $invoicedt, 
                   'whs_code' => $stock_loc, 
                   'recipient' => strtoupper(Session::get('_user')['id']),
                   't_date' => $datetime->toDateString(),
                   't_time' => $datetime->toTimeString(),
                   'branch' => $branch
                  ];

          // check if po_no entered already exist
          $cond = "trn_type = 'P' AND (cancel != 'Y' OR cancel isnull OR cancel = '') AND purc_ord = '$purc_code' AND rec_num != '$code'";
          $checkifDataExist = Inventory::checkIfDataExist($table, $cond);

          if($checkifDataExist) // check if po_no entered already exist
          {
             return 'PO No entered already exist.';
          }
          else
          { 
             $updHeader = Core::updateTable($table, 'rec_num', $code, $data, $this->module);
             
             if($updHeader == 'true')
             {
                 $del_dataln = [['rec_num', '=', $code]];
                 $del_datastkcrd = [['reference', '=', $stk_ref]];
   
                 $delLine = Core::deleteTableMultiWhere($tableln, $del_dataln, $this->module);
                 $delStkcrd = Core::deleteTableMultiWhere('rssys.stkcrd', $del_datastkcrd, $this->module);
   
                 
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
                             'ln_vatamt' => $tb[12]];
   
                   $insertLine = Core::insertTable($tableln, $data2, $this->module);
                   if($insertLine == 'true')
                   {
                       $stk_qty_in = $tb[4];
                       $stk_qty_out = "0";
   
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
   
                        $insertStkcrd = Inventory::saveToStkcrd($stkcrd);
                        if($insertStkcrd == 'true')
                        {
                          $flag = 'true';
                        }
                        else
                        {
                          return $insertStkcrd;
                        }          
                   }
                   else
                   {
                       return $insertLine;
                   }          
                 }
                 
             }
             else
             {
                 return $updHeader;
             }
           }

          return $flag;   
      } 
    }

    public function cancel($code)
    {
      $stk_ref = $this->stk_trns_type."#".$code;
      $table = "rssys.rechdr";
      $col = "rec_num";
      $flag = 'true';

      $cancelStkIn = Inventory::cancelStockIn($code, $stk_ref, $table, $col, $this->module);

      if($cancelStkIn != 'true')
      {
        return $cancelStkIn;
      }

      return $flag;
    }

    public function print($code)
    {
      // $rechdr = Inventory::getReceivingPOHeader($code);
      // $reclne = Inventory::getReceivingPOLine($code);

      $rechdr = Inventory::getStockInHeaderPrint($code);
      $reclne = Inventory::getStockInLinePrint($code);
      $total = Inventory::getStockInLinePrintTOTAL($code);
        // dd($total[0]->total);
      return view('inventory.stockin.stockin_print', compact('rechdr', 'reclne', 'total'));
    }

    public function printpo($code)
    {
      $rechdr = Inventory::getStockInHeaderPrint($code);
      $reclne = Inventory::getStockInLinePrint($code);
      $total = Inventory::getStockInLinePrintTOTAL($code);

      $totalamtwords = Core::moneyToString($total->total);

      return view('inventory.stockin.po.stockin_print', compact('rechdr', 'reclne', 'total', 'totalamtwords'));
    }

    public function getitemdetails($code)
    {
      $itemdetails = Inventory::getItemDetails($code);

      $part_no = $itemdetails->part_no;
      $item_desc = $itemdetails->item_desc;
      $unit = $itemdetails->sales_unit_id;
      $cost = $itemdetails->unit_cost;

      $itemdetailsdata = [$part_no, $item_desc, $unit, $cost];

      return $itemdetailsdata;
    }
}