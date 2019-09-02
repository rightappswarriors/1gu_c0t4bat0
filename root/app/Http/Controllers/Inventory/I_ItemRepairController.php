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
    private $stk_trns_type = "A";
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

            $getCode = Core::getm99One('are_code');
            $code = $getCode->are_code;
            $invoicedt = $request->invoicedt;
            // $stock_loc = $request->costcenter;
            // $branch = $request->branch;
            $reference = $request->reference;
            $costcenter = $request->costcenter;
            $receivedfrom = $request->receivedfrom;
            $receivedby = $request->receivedby;
            $issuedto = $request->issuedto;
            $receivedfromdesig = $request->receivedfromdesig;
            $receivedbydesig = $request->receivedbydesig;
            $issuedtodesig = $request->issuedtodesig;

            //$stk_ref = $this->stk_trns_type."#".$code;

            Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedfrom);
            Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedby);
            Inventory::checkIfExistInsert('rssys.are_users', 'name', $issuedto);

            Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedfromdesig);
            Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedbydesig);
            Inventory::checkIfExistInsert('rssys.are_position', 'name', $issuedtodesig);
            
            $data = ['rec_num' => $code,  
                     '_reference' => $reference, 
                     'trnx_date' => $invoicedt, 
                     // 'whs_code' => $stock_loc, 
                     'trn_type' => $this->stk_trns_type, 
                     'cc_code' => $costcenter, 
                     'recipient' => strtoupper(Session::get('_user')['id']),
                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString(),
                     'are_receivedby' => $receivedby,
                     'are_receivedfrom' => $receivedfrom,
                     'are_issuedto' => $issuedto,
                     'are_receivebydesig' => $receivedbydesig,
                     'are_receivedfromdesig' => $receivedfromdesig,
                     'are_issuedtodesig' => $issuedtodesig
                     // 'branch' => $branch
                    ];

            $insertHeader = Core::insertTable($table, $data, $this->module);

            if($insertHeader == 'true')
            {
                $updateM99 = Core::updatem99('are_code', Inventory::get_nextincrementwithchar($code));

                if($updateM99 == 'true')
                {
                  foreach($request->tbl_itemlist as $tb)
                  {
                      $data2 = ['rec_num' => $code, 
                                'ln_num' => $tb[0], 
                                'part_no' => $tb[2], 
                                'serial_no' => $tb[3], 
                                'tag_no' => $tb[4], 
                                'item_code' => $tb[1], 
                                'item_desc' => $tb[5], 
                                'recv_qty' => $tb[6], 
                                'issued_qty' => $tb[6], 
                                'unit' => $tb[7],
                                'price' => $tb[9],
                                'ln_amnt' => $tb[10]];

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

   
}