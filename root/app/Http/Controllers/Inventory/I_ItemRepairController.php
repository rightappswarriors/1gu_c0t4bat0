<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class I_ItemRepairController extends Controller
{
    private $stk_trns_type = "IR";
    private $module = "Item Repair";

    public function view()
    {  
        $data = Inventory::getARE();

        return view('inventory.itemrepair.itemrepair', compact('data'));
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
            $are_users = Core::getAll('rssys.are_users');
            $are_position = Core::getAll('rssys.are_position');
            $isnew = true;

            $disp_items = Inventory::getItemSearch();

            return view('inventory.itemrepair.itemrepair_entry', compact('stock_loc', 'branch', 'disp_items', 'itemunit', 'costcenter', 'vat', 'isnew', 'x08', 'are_users', 'are_position'));
        }
        else if($request->isMethod('post'))
        {
           $datetime = Carbon::now();
           $flag = "true";

            $table = 'rssys.rechdr';
            $tableln = "rssys.reclne";

            $getCode = Core::getm99One('ir_code');
            $code = $getCode->ir_code;
            $ir_model = $request->ir_model;
            $ir_unitserialno = $request->ir_unitserialno;
            $ir_engineserialno = $request->ir_engineserialno;
            $ir_plateno = $request->ir_plateno;
            $recipient = $request->recipient;
            $ir_designation = $request->ir_designation;
            $cc_code = $request->cc_code;
            $ir_dateofare = $request->ir_dateofare;
            
            $data = ['rec_num' => $code,
                     'ir_model' => $ir_model,
                     'ir_unitserialno' => $ir_unitserialno,
                     'ir_engineserialno' => $ir_engineserialno,
                     'ir_plateno' => $ir_plateno,
                     'recipient' => strtoupper(Session::get('_user')['id']),
                     'ir_designation' => $ir_designation,
                     'cc_code' => $cc_code,
                     'ir_dateofare' => $ir_dateofare,

                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString()
                    ];

            $insertHeader = Core::insertTable($table, $data, $this->module);

            if($insertHeader == 'true')
            {
                $updateM99 = Core::updatem99 ('ir_code', Inventory::get_nextincrementwithchar($code, 8));

                if($updateM99 == 'true')
                {
                  foreach($request->tbl_itemlist as $tb)
                  {
                      $data2 = ['rec_num' => $code, 
                                'ln_num' => $tb[0], 
                                'ir_joborder' => $tb[1], 
                                'ir_date' => $tb[2], 
                                'ir_prepost' => $tb[3], 
                                'ir_postdate' => $tb[4], 
                                'ir_invoice' => $tb[5], 
                                'ir_delvdate' => $tb[6], 
                                'ir_supplier' => $tb[7],
                                'recv_qty' => $tb[8],
                                'unit' => $tb[9],
                                'price' => $tb[10],
                                'ir_material' => $tb[11],
                                'notes' => $tb[12]];

                      $insertLine = Core::insertTable($tableln, $data2, $this->module);

                      if($insertLine == 'true')
                      {
                         // $stk_qty_in = $tb[4];
                         // $stk_qty_out = "0";

                         // $stkcrd = ['item_code' => $tb[2],
                         //            'item_desc' => $tb[3],
                         //            'unit' => $tb[5],
                         //            'trnx_date' => $invoicedt,
                         //            'reference' => $stk_ref,
                         //            'qty_in' => $stk_qty_in,
                         //            'qty_out' => $stk_qty_out,
                         //            'fcp' => $tb[7],
                         //            'price' => $tb[7],
                         //            'whs_code' => $stock_loc,
                         //            'supl_code' => $supl_code,
                         //            'supl_name' => $supl_name,
                         //            'trn_type' => $this->stk_trns_type,
                         //            'branch' => $branch];

                         // if(Inventory::saveToStkcrd($stkcrd))
                         // { }
                         // else
                         // {
                         //   $flag = 'false';
                         //   break;
                         // }          
                         $flag = 'true';
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

            return $flag;    
        
        }
    }

    // public function edit(Request $request, $code)
    // {
    //   if($request->isMethod('get')) // for entry
    //   {
    //       $isnew = false;
    //       $stock_loc = Core::getAll('rssys.whouse');
    //       $branch = Core::getAll('rssys.branch');
    //       $itemunit = Core::getAll('rssys.itmunit');
    //       $costcenter = Core::getAll('rssys.m08');
    //       $vat = Core::getAll('rssys.vat');
    
    //       $disp_items = Inventory::getItemSearch();
    
    //       $rechdr = Inventory::getAREHeader($code);
    //       $reclne = Inventory::getARELine($code);

    //       $x08 = Core::getAll('rssys.x08');
    //       $are_users = Core::getAll('rssys.are_users');
    //       $are_position = Core::getAll('rssys.are_position');
    //       //$grandtotal = Inventory::getTotalAmtRIS($code);

    
    //       return view('inventory.itemrepair.itemrepair_entry', compact('rechdr', 'reclne', 'stock_loc', 'branch', 'itemunit', 'costcenter', 'vat', 'disp_items', 'isnew', 'x08', 'are_users', 'are_position'));
    //   }
    //   elseif($request->isMethod('post'))
    //   {
    //       $datetime = Carbon::now();
    //       $flag = "true";

    //       $table = 'rssys.rechdr';
    //       $tableln = "rssys.reclne";

    //       $code = $code;
    //       $invoicedt = $request->invoicedt;
    //       // $stock_loc = $request->stock_loc;
    //       // $branch = $request->branch;
    //       $reference = $request->reference;
    //       $costcenter = $request->costcenter;
    //       // $ris_no = $request->ris_no;
    //       // $sai_no = $request->sai_no;
    //       //$stk_ref = $this->stk_trns_type."#".$code;
    //       $receivedfrom = $request->receivedfrom;
    //       $receivedby = $request->receivedby;
    //       $issuedto = $request->issuedto;
    //       $receivedfromdesig = $request->receivedfromdesig;
    //       $receivedbydesig = $request->receivedbydesig;
    //       $issuedtodesig = $request->issuedtodesig;

    //       // Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedfrom);
    //       // Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedby);
    //       // Inventory::checkIfExistInsert('rssys.are_users', 'name', $issuedto);

    //       // Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedfromdesig);
    //       // Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedbydesig);
    //       // Inventory::checkIfExistInsert('rssys.are_position', 'name', $issuedtodesig);
            
    //       $data = [


    //         '_reference' => $reference, 
    //                'trnx_date' => $invoicedt, 
    //                // 'whs_code' => $stock_loc, 
    //                'cc_code' => $costcenter, 
    //                // 'ris_no' => $ris_no, 
    //                // 'sai_no' => $sai_no, 
    //                'recipient' => strtoupper(Session::get('_user')['id']),
    //                't_date' => $datetime->toDateString(),
    //                't_time' => $datetime->toTimeString(),
    //                'are_receivedby' => $receivedby,
    //                'are_receivedfrom' => $receivedfrom,
    //                'are_issuedto' => $issuedto,
    //                'are_receivebydesig' => $receivedbydesig,
    //                'are_receivedfromdesig' => $receivedfromdesig,
    //                'are_issuedtodesig' => $issuedtodesig
    //                // 'branch' => $branch
    //               ];

    //       $updHeader = Core::updateTable($table, 'rec_num', $code, $data, $this->module);

    //       if($updHeader == 'true')
    //       {
    //           $del_dataln = [['rec_num', '=', $code]];
    //           //$del_datastkcrd = [['reference', '=', $stk_ref]];

    //           Core::deleteTableMultiWhere($tableln, $del_dataln, $this->module);
    //           //Core::deleteTableMultiWhere('rssys.stkcrd', $del_datastkcrd, $this->module);

    //           foreach($request->tbl_itemlist as $tb)
    //           {
    //             $data2 = ['rec_num' => $code, 
    //                       'ln_num' => $tb[0], 




    //                       'part_no' => $tb[2], 
    //                       'serial_no' => $tb[3], 
    //                       'tag_no' => $tb[4], 
    //                       'item_code' => $tb[1], 
    //                       'item_desc' => $tb[5], 
    //                       'recv_qty' => $tb[6], 
    //                       'issued_qty' => $tb[6], 
    //                       'unit' => $tb[7],
    //                       'price' => $tb[9],
    //                       'ln_amnt' => $tb[10]];  

    //             $insertLine = Core::insertTable($tableln, $data2, $this->module);                 

    //             if($insertLine == 'true')
    //             {
    //               $flag = 'true';
    //                 // $stk_qty_in = $tb[4];
    //                 // $stk_qty_out = "0";

    //                 // $stkcrd = ['item_code' => $tb[2],
    //                 //            'item_desc' => $tb[3],
    //                 //            'unit' => $tb[5],
    //                 //            'trnx_date' => $invoicedt,
    //                 //            'reference' => $stk_ref,
    //                 //            'qty_in' => $stk_qty_in,
    //                 //            'qty_out' => $stk_qty_out,
    //                 //            'fcp' => $tb[7],
    //                 //            'price' => $tb[7],
    //                 //            'whs_code' => $stock_loc,
    //                 //            'supl_code' => $supl_code,
    //                 //            'supl_name' => $supl_name,
    //                 //            'trn_type' => $this->stk_trns_type,
    //                 //            'branch' => $branch];

    //                 //  if(Inventory::saveToStkcrd($stkcrd))
    //                 //  {

    //                 //  }
    //                 //  else
    //                 //  {
    //                 //    $flag = 'false';
    //                 //    break;
    //                 //  }          
    //             }
    //             else
    //             {
    //                 return $insertLine;
    //             }          
    //           }
    //       }
    //       else
    //       {
    //           return $updHeader;
    //       }

    //       return $flag;   
    //   } 
    // }

   
}