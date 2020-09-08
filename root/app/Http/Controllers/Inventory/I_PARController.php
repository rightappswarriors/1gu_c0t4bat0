<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class I_PARController extends Controller
{
    private $stk_trns_type = "H";
    private $module = "Property Acknowledgment Receipt";

    public function view()
    {  
        $data = Inventory::getPAR();

        return view('inventory.par.par', compact('data'));
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
            $toolbar = ['link'=>'#','desc'=>'Create','icon'=>'none','st'=>true];

            return view('inventory.par.par-entry', compact('stock_loc', 'branch', 'disp_items', 'itemunit', 'costcenter', 'vat', 'isnew', 'x08', 'are_users', 'are_position', 'toolbar'));
        }
        else if($request->isMethod('post'))
        {
           $datetime = Carbon::now();
           $flag = "true";

            $table = 'rssys.rechdr';
            $tableln = "rssys.reclne";

            $getCode = Core::getm99One('parr_code');
            $code = $getCode->parr_code;
            $invoicedt = $request->invoicedt;
            // $stock_loc = $request->costcenter;
            // $branch = $request->branch;
            $par = $request->par;
            $reference = $request->reference;
            $costcenter = $request->costcenter;
            // $receivedfrom = $request->receivedfrom;
            $receivedby = $request->receivedby;
            $issuedto = $request->issuedto;
            // $receivedfromdesig = $request->receivedfromdesig;
            $receivedbydesig = $request->receivedbydesig;
            $issuedtodesig = $request->issuedtodesig;

            //$stk_ref = $this->stk_trns_type."#".$code;

            // Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedfrom);
            Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedby);
            Inventory::checkIfExistInsert('rssys.are_users', 'name', $issuedto);

            // Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedfromdesig);
            Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedbydesig);
            Inventory::checkIfExistInsert('rssys.are_position', 'name', $issuedtodesig);
            
            $data = ['rec_num' => $code,  
                     '_reference' => $reference, 
                     'trnx_date' => $invoicedt, 
                     // 'whs_code' => $stock_loc, 
                     'purc_ord' => $par,
                     'trn_type' => $this->stk_trns_type, 
                     'cc_code' => $costcenter, 
                     'recipient' => strtoupper(Session::get('_user')['id']),
                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString(),
                     'are_receivedby' => $receivedby,
                     // 'are_receivedfrom' => $receivedfrom,
                     'are_issuedto' => $issuedto,
                     'are_receivebydesig' => $receivedbydesig,
                     // 'are_receivedfromdesig' => $receivedfromdesig,
                     'are_issuedtodesig' => $issuedtodesig
                     // 'branch' => $branch
                    ];

            $insertHeader = Core::insertTable($table, $data, $this->module);

            if($insertHeader == 'true')
            {
                $updateM99 = Core::updatem99('parr_code', Inventory::get_nextincrementwithchar($code));

                if($updateM99 == 'true')
                {
                  foreach($request->tbl_itemlist as $tb)
                  {
                      $data2 = ['rec_num' => $code, 
                                'ln_num' => $tb[0], 
                                'part_no' => $tb[2], 
                                // 'serial_no' => $tb[3], 
                                // 'tag_no' => $tb[4], 
                                'item_code' => $tb[1], 
                                'item_desc' => $tb[5], 
                                'recv_qty' => $tb[6], 
                                'issued_qty' => $tb[6], 
                                'unit' => $tb[7],
                                'price' => $tb[9],
                                'ln_amnt' => $tb[10],
                                'ir_date' => $tb[11]];

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

    public function edit(Request $request, $code)
    {
      if($request->isMethod('get')) // for entry
      {
          $isnew = false;
          $stock_loc = Core::getAll('rssys.whouse');
          $branch = Core::getAll('rssys.branch');
          $itemunit = Core::getAll('rssys.itmunit');
          $costcenter = Core::getAll('rssys.m08');
          $vat = Core::getAll('rssys.vat');
    
          $disp_items = Inventory::getItemSearch();
    
          $rechdr = Inventory::getPARHeader($code);
          $reclne = Inventory::getPARLine($code);

          $x08 = Core::getAll('rssys.x08');
          $are_users = Core::getAll('rssys.are_users');
          $are_position = Core::getAll('rssys.are_position');
          $toolbar = ['link'=>'#','desc'=>'Update','icon'=>'none','st'=>true];
    
          return view('inventory.par.par-entry', compact('rechdr', 'reclne', 'stock_loc', 'branch', 'itemunit', 'costcenter', 'vat', 'disp_items', 'isnew', 'x08', 'are_users', 'are_position', 'toolbar'));
      }
      elseif($request->isMethod('post'))
      {
          $datetime = Carbon::now();
          $flag = "true";

          $table = 'rssys.rechdr';
          $tableln = "rssys.reclne";

          $code = $code;
          $invoicedt = $request->invoicedt;
          // $stock_loc = $request->stock_loc;
          // $branch = $request->branch;
          $reference = $request->reference;
          $costcenter = $request->costcenter;
          // $ris_no = $request->ris_no;
          // $sai_no = $request->sai_no;
          //$stk_ref = $this->stk_trns_type."#".$code;
          $par = $request->par;
          // $receivedfrom = $request->receivedfrom;
          $receivedby = $request->receivedby;
          $issuedto = $request->issuedto;
          // $receivedfromdesig = $request->receivedfromdesig;
          $receivedbydesig = $request->receivedbydesig;
          $issuedtodesig = $request->issuedtodesig;

          // Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedfrom);
          Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedby);
          Inventory::checkIfExistInsert('rssys.are_users', 'name', $issuedto);

          // Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedfromdesig);
          Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedbydesig);
          Inventory::checkIfExistInsert('rssys.are_position', 'name', $issuedtodesig);
            
          $data = ['_reference' => $reference, 
                   'trnx_date' => $invoicedt, 
                   // 'whs_code' => $stock_loc, 
                   'cc_code' => $costcenter, 
                   // 'ris_no' => $ris_no, 
                   // 'sai_no' => $sai_no, 
                   'recipient' => strtoupper(Session::get('_user')['id']),
                   't_date' => $datetime->toDateString(),
                   't_time' => $datetime->toTimeString(),
                   'are_receivedby' => $receivedby,
                   // 'are_receivedfrom' => $receivedfrom,
                   'are_issuedto' => $issuedto,
                   'are_receivebydesig' => $receivedbydesig,
                   // 'are_receivedfromdesig' => $receivedfromdesig,
                   'are_issuedtodesig' => $issuedtodesig
                   // 'branch' => $branch
                  ];

          $updHeader = Core::updateTable($table, 'rec_num', $code, $data, $this->module);

          if($updHeader == 'true')
          {
              $del_dataln = [['rec_num', '=', $code]];
              //$del_datastkcrd = [['reference', '=', $stk_ref]];

              Core::deleteTableMultiWhere($tableln, $del_dataln, $this->module);
              //Core::deleteTableMultiWhere('rssys.stkcrd', $del_datastkcrd, $this->module);

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
                          'ln_amnt' => $tb[10],
                          'ir_date' => $tb[11]];  

                $insertLine = Core::insertTable($tableln, $data2, $this->module);                 

                if($insertLine == 'true')
                {
                  $flag = 'true';
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

                    //  if(Inventory::saveToStkcrd($stkcrd))
                    //  {

                    //  }
                    //  else
                    //  {
                    //    $flag = 'false';
                    //    break;
                    //  }          
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

          return $flag;   
      } 
    }

    public function approve($code)
    {
      $table = "rssys.rechdr";
      $col = "rec_num";
      $flag = 'false';

      $data = ['are_status' => 'true'];

      if(Core::updateTable($table, 'rec_num', $code, $data, $this->module))
      {
        $flag = 'true';
      }

      return $flag;
    }

    public function print($code)
    {
      $par = Inventory::print_par($code);
      $par_header = Inventory::print_parheader($code);

      return view('inventory.par.par-print', compact('par', 'par_header'));
    }

    public function cancel($code)
    {
      $table = "rssys.rechdr";
      $col = "rec_num";
      $flag = 'true';

      $cancelARE = Inventory::cancelPAR($code, $table, $col, $this->module);

      if($cancelARE != 'true')
      {
        return $cancelARE;
      }

      return $flag;
    }
}