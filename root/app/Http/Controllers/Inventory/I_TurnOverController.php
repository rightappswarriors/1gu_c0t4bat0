<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class I_TurnOverController extends Controller
{
    private $stk_trns_type = "TO";
    private $module = "Turn Over";

    public function view()
    {  
        $data = Inventory::getTO();

        return view('inventory.turnover.turnover', compact('data'));
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

            $disp_items = Inventory::getTO();

            return view('inventory.turnover.turnover_entry', compact('stock_loc', 'branch', 'disp_items', 'itemunit', 'costcenter', 'vat', 'isnew', 'x08', 'are_users', 'are_position'));
        }
        else if($request->isMethod('post'))
        {
            $datetime = Carbon::now();
            $flag = "true";

            $table = 'rssys.rechdr';
            $tableln = "rssys.reclne";

            $getCode = Core::getm99One('to_code');
            $code = $getCode->to_code;
            $_reference = $request->_reference;
            $to_receivedby = $request->to_receivedby;
            $to_by = $request->to_by;
            $cc_code = $request->cc_code;
            $to_date = $request->to_date;                 
            $recipient = $request->recipient;
            $receivedbydesig = $request->receivedbydesig;
            Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedbydesig);
            

            $data = ['rec_num' => $code,
            		 '_reference' => $_reference,
            		 'to_receivedby' => $to_receivedby,
            		 'to_by' => $to_by,
                     'cc_code' => $cc_code,
                     'to_date' => $to_date,
                     'recipient' => strtoupper(Session::get('_user')['id']),
                     'trn_type' => $this->stk_trns_type,
                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString(),
                     'are_receivebydesig' => $receivedbydesig
                    ];

            $insertHeader = Core::insertTable($table, $data, $this->module);

            if($insertHeader == 'true')
            {
                $updateM99 = Core::updatem99 ('to_code', Core::get_nextincrementwithString($code, 6));

                if($updateM99 == 'true')
                {
                  foreach($request->tbl_itemlist as $tb)
                  {
                      $data2 = ['rec_num' => $code, 
                                'ln_num' => $tb[0],
                                'item_code' => $tb[1], 
                                'to_article' => $tb[2],
                                'recv_qty' => $tb[3],
                                'item_desc' => $tb[4], 
                                'notes' => $tb[5],
                                'unit' => ''
                               ];
        

                      $insertLine = Core::insertTable($tableln, $data2, $this->module);

                      if($insertLine == 'true')
                      {              
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
    
          $disp_items = Inventory::getTO();
    
          $rechdr = Inventory::getTOHeader($code);
          $reclne = Inventory::getTOLine($code);

          //dd($rechdr);

          $x08 = Core::getAll('rssys.x08');
          $are_users = Core::getAll('rssys.are_users');
          $are_position = Core::getAll('rssys.are_position'); 
          //$grandtotal = Inventory::getTotalAmtRIS($code);

    
          return view('inventory.turnover.turnover_entry', compact('rechdr', 'reclne', 'stock_loc', 'branch', 'itemunit', 'costcenter', 'vat', 'disp_items', 'isnew', 'x08', 'are_users', 'are_position'));
      }
      elseif($request->isMethod('post'))
      {
          $datetime = Carbon::now();
          $flag = "true";

          $table = 'rssys.rechdr';
          $tableln = "rssys.reclne";

          $code = $code;

          //$code = $getCode->to_code;
            $_reference = $request->_reference;
            $to_receivedby = $request->to_receivedby;
            $to_by = $request->to_by;
            $cc_code = $request->cc_code;
            $to_date = $request->to_date;                 
            $recipient = $request->recipient;

            $receivedbydesig = $request->receivedbydesig;
            Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedbydesig);
            
          $data = ['rec_num' => $code,
            		 '_reference' => $_reference,
            		 'to_receivedby' => $to_receivedby,
            		 'to_by' => $to_by,
                     'cc_code' => $cc_code,
                     'to_date' => $to_date,
                     'recipient' => strtoupper(Session::get('_user')['id']),
                     'trn_type' => $this->stk_trns_type,
                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString(),
                     'are_receivebydesig' => $receivedbydesig
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
                                'item_code' => $tb[1], 
                                'to_article' => $tb[2],
                                'recv_qty' => $tb[3],
                                'item_desc' => $tb[4], 
                                'notes' => $tb[5],
                                'unit' => ''
                            ];

                $insertLine = Core::insertTable($tableln, $data2, $this->module);                 

                if($insertLine == 'true')
                {
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
              return $updHeader;
          }

          return $flag;   
      } 
    }

    public function cancel($code)
    {
      $table = "rssys.rechdr";
      $col = "rec_num";
      $flag = 'true';

      $cancelTO = Inventory::cancelTO($code, $table, $col, $this->module);

      if($cancelTO != 'true')
      {
        return $cancelTO;
      }
  
      return $flag;
    }

    public function print($code)
    {
      	$rechdr = Inventory::printTOHeader($code);
        $reclne = Inventory::printTOLine($code);

      return view('inventory.turnover.turnover_print', compact('rechdr', 'reclne'));
    }

    // public function approve($code)
    // {
    //   $table = "rssys.rechdr";
    //   $col = "rec_num";
    //   $flag = 'false';

    //   $data = ['are_status' => 'true'];

    //   if(Core::updateTable($table, 'rec_num', $code, $data, $this->module))
    //   {
    //     $flag = 'true';
    //   }

    //   return $flag;
    // }

}