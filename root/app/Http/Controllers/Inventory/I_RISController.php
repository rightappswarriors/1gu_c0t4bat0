<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class I_RISController extends Controller
{
    private $stk_trns_type = "R";
    private $module = "Requisition Issuance Slip";

    public function view()
    {  
        $data = Inventory::getRIS();

        return view('inventory.ris.ris', compact('data'));
    }

    public function view_02()
    {  
        $data = Inventory::getRIS();
        $dtfrm = date("Y-m-01");
        $dtto = date("Y-m-d");

        return view('inventory.ris.ris_02', compact('data', 'dtfrm', 'dtto'));
    }

    public function viewFilterDate($date)
    {
        $date = explode(",", $date);

        $dtfrm = $date[0];
        $dtto = $date[1];
        
        $data = Inventory::getRIS($dtfrm, $dtto);

        return $data;
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
            $isnew = true;
            $x08 = Core::getAll('rssys.x08');
            $are_users = Core::getAll('rssys.are_users');
            $are_position = Core::getAll('rssys.are_position');

            $sql = "SELECT i.item_code, COALESCE(SUM(st.qty_in),0.00) - COALESCE(SUM(st.qty_out),0.00) AS qty_onhand_su, i.part_no, i.serial_no, i.tag_no, i.cartype, i.item_desc, iu.unit_shortcode AS sale_unit, i.sales_unit_id, b.brd_name, i.brd_code, i.sell_pric AS regular, i.sc_price AS senior, i.bin_loc, i.unit_cost, ig.grp_desc, i.item_grp, st.whs_code, w.whs_desc, CASE WHEN st.branch IS NULL THEN i.branch ELSE st.branch END AS branchcode, CASE WHEN branch.name IS NULL THEN ibranch.name ELSE branch.name END AS branchname, COALESCE(c_name, 'None') AS c_name, i.active AS active FROM rssys.items  i LEFT JOIN rssys.itmunit iu ON i.sales_unit_id=iu.unit_id LEFT JOIN rssys.brand b ON i.brd_code=b.brd_code LEFT JOIN rssys.itmgrp ig ON ig.item_grp=i.item_grp LEFT JOIN rssys.stkcrd st ON st.item_code=i.item_code LEFT JOIN rssys.whouse w ON w.whs_code=st.whs_code LEFT JOIN rssys.branch ON w.branch=branch.code LEFT JOIN rssys.branch ibranch ON i.branch=ibranch.code LEFT JOIN rssys.m07 m7 ON m7.c_code = i.supl_code GROUP BY i.item_code, i.part_no, i.cartype, i.item_desc,iu.unit_shortcode, i.sales_unit_id, b.brd_name, i.brd_code, i.sell_pric, i.sc_price, i.bin_loc, i.unit_cost, ig.grp_desc, i.item_grp, st.whs_code, w.whs_desc, branchcode, branchname, c_name ORDER BY item_code";

            $disp_items = Core::sql($sql);

            return view('inventory.ris.ris-entry', compact('stock_loc', 'branch', 'disp_items', 'itemunit', 'costcenter', 'vat', 'isnew', 'x08', 'are_users', 'are_position'));
        }
        else if($request->isMethod('post'))
        {
            $datetime = Carbon::now();
            $flag = "false";

            $table = 'rssys.rechdr';
            $tableln = "rssys.reclne";

            $getCode = Core::getm99One('ris_code');
            $code = $getCode->ris_code;
            $invoicedt = $request->invoicedt;
            // $stock_loc = $request->costcenter;
            // $branch = $request->branch;
            $reference = $request->reference;
            $costcenter = $request->costcenter;
            $ris_no = $request->ris_no;
            $sai_no = $request->sai_no;
            //$stk_ref = $this->stk_trns_type."#".$code;

            $receivedfrom = $request->receivedfrom;
            $receivedfromdesig = $request->receivedfromdesig;
            Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedfrom);
            Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedfromdesig);

            $receivedby = $request->receivedby;
            $receivedbydesig = $request->receivedbydesig;
            Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedby);
            Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedbydesig);
            
            $data = ['rec_num' => $code,  
                     '_reference' => $reference, 
                     'trnx_date' => $invoicedt, 
                     // 'whs_code' => $stock_loc, 
                     'trn_type' => $this->stk_trns_type, 
                     'cc_code' => $costcenter, 
                     'ris_no' => $ris_no, 
                     'sai_no' => $sai_no, 
                     'recipient' => strtoupper(Session::get('_user')['id']),
                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString(),
                     'are_receivedfrom' => $receivedfrom,
                     'are_receivedfromdesig' => $receivedfromdesig,
                     'are_receivedby' => $receivedby,
                     'are_receivebydesig' => $receivedbydesig
                     // 'branch' => $branch
                    ];

            $insertRIShd = Core::insertTable($table, $data, $this->module);        

            if($insertRIShd == 'true')
            {
                Core::updatem99('ris_code', Inventory::get_nextincrementwithchar($code));

                foreach($request->tbl_itemlist as $tb)
                {
                    $data2 = ['rec_num' => $code, 
                              'ln_num' => $tb[0], 
                              'part_no' => $tb[2], 
                              'item_code' => $tb[1], 
                              'item_desc' => $tb[5], 
                              'recv_qty' => $tb[6], 
                              'issued_qty' => $tb[6], 
                              'unit' => $tb[7]
                            ];

                    if(Core::insertTable($tableln, $data2, $this->module))
                    {       
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
                return $insertRIShd;
            }

            return $flag;    
        
        }
    }

    public function add_02(Request $request)
    {
        if($request->isMethod('get'))
        {
            $stock_loc = Core::getAll('rssys.whouse');
            $branch = Core::getAll('rssys.branch');
            $itemunit = Core::getAll('rssys.itmunit');
            $costcenter = Core::getAll('rssys.m08');
            $vat = Core::getAll('rssys.vat');
            $isnew = true;
            $x08 = Core::getAll('rssys.x08');
            $are_users = Core::getAll('rssys.are_users');
            $are_position = Core::getAll('rssys.are_position');

            $stockin = Inventory::getStockIn();

            $dtfrm = date("Y-m-01");
            $dtto = date("Y-m-d");

            $sql = "SELECT i.item_code, COALESCE(SUM(st.qty_in),0.00) - COALESCE(SUM(st.qty_out),0.00) AS qty_onhand_su, i.part_no, i.serial_no, i.tag_no, i.cartype, i.item_desc, iu.unit_shortcode AS sale_unit, i.sales_unit_id, b.brd_name, i.brd_code, i.sell_pric AS regular, i.sc_price AS senior, i.bin_loc, i.unit_cost, ig.grp_desc, i.item_grp, st.whs_code, w.whs_desc, CASE WHEN st.branch IS NULL THEN i.branch ELSE st.branch END AS branchcode, CASE WHEN branch.name IS NULL THEN ibranch.name ELSE branch.name END AS branchname, COALESCE(c_name, 'None') AS c_name, i.active AS active FROM rssys.items  i LEFT JOIN rssys.itmunit iu ON i.sales_unit_id=iu.unit_id LEFT JOIN rssys.brand b ON i.brd_code=b.brd_code LEFT JOIN rssys.itmgrp ig ON ig.item_grp=i.item_grp LEFT JOIN rssys.stkcrd st ON st.item_code=i.item_code LEFT JOIN rssys.whouse w ON w.whs_code=st.whs_code LEFT JOIN rssys.branch ON w.branch=branch.code LEFT JOIN rssys.branch ibranch ON i.branch=ibranch.code LEFT JOIN rssys.m07 m7 ON m7.c_code = i.supl_code GROUP BY i.item_code, i.part_no, i.cartype, i.item_desc,iu.unit_shortcode, i.sales_unit_id, b.brd_name, i.brd_code, i.sell_pric, i.sc_price, i.bin_loc, i.unit_cost, ig.grp_desc, i.item_grp, st.whs_code, w.whs_desc, branchcode, branchname, c_name ORDER BY item_code";

            $disp_items = Core::sql($sql);

            $toolbar = ['link'=>'#','desc'=>'Create','icon'=>'none','st'=>true];

            return view('inventory.ris.ris-entry-02', compact('stock_loc', 'branch', 'disp_items', 'itemunit', 'costcenter', 'vat', 'isnew', 'x08', 'are_users', 'are_position', 'toolbar', 'stockin', 'dtfrm', 'dtto'));
        }
        else if($request->isMethod('post'))
        {
            $datetime = Carbon::now();
            $flag = "false";

            $table = 'rssys.rechdr';
            $tableln = "rssys.reclne";

            $getCode = Core::getm99One('ris_code');
            $code = $getCode->ris_code;
            $invoicedt = $request->invoicedt;
            // $stock_loc = $request->costcenter;
            // $branch = $request->branch;
            $reference = $request->reference;
            $costcenter = $request->costcenter;
            $ris_no = $request->ris_no;
            $sai_no = $request->sai_no;
            //$stk_ref = $this->stk_trns_type."#".$code;

            $receivedfrom = $request->receivedfrom;
            $receivedfromdesig = $request->receivedfromdesig;
            Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedfrom);
            Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedfromdesig);

            $receivedby = $request->receivedby;
            $receivedbydesig = $request->receivedbydesig;
            Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedby);
            Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedbydesig);

            $purcord = $request->purcord;
            
            $data = ['rec_num' => $code,  
                     '_reference' => $reference, 
                     'trnx_date' => $invoicedt, 
                     // 'whs_code' => $stock_loc, 
                     'trn_type' => $this->stk_trns_type, 
                     'cc_code' => $costcenter, 
                     'ris_no' => $ris_no, 
                     'sai_no' => $sai_no, 
                     'recipient' => strtoupper(Session::get('_user')['id']),
                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString(),
                     'are_receivedfrom' => $receivedfrom,
                     'are_receivedfromdesig' => $receivedfromdesig,
                     'are_receivedby' => $receivedby,
                     'are_receivebydesig' => $receivedbydesig,
                     'purc_ord' => $purcord
                     // 'branch' => $branch
                    ];

            $insertRIShd = Core::insertTable($table, $data, $this->module);        

            if($insertRIShd == 'true')
            {
                Core::updatem99('ris_code', Inventory::get_nextincrementwithchar($code));

                foreach($request->tbl_itemlist as $tb)
                {
                    $data2 = ['rec_num' => $code, 
                              'ln_num' => $tb[0], 
                              'part_no' => $tb[2], 
                              'item_code' => $tb[1], 
                              'item_desc' => $tb[5], 
                              'recv_qty' => $tb[6], 
                              'issued_qty' => $tb[6], 
                              'unit' => $tb[7],
                              'price' => $tb[9]
                            ];

                    if(Core::insertTable($tableln, $data2, $this->module))
                    {       
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
                return $insertRIShd;
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
    
          $rechdr = Inventory::getRISHeader($code);

          $reclne = Inventory::getRISLine($code);
          $grandtotal = Inventory::getTotalAmtRIS($code);

          $x08 = Core::getAll('rssys.x08');
          $are_users = Core::getAll('rssys.are_users');
          $are_position = Core::getAll('rssys.are_position');

    
          return view('inventory.ris.ris-entry', compact('rechdr', 'reclne', 'stock_loc', 'branch', 'itemunit', 'costcenter', 'vat', 'disp_items', 'grandtotal', 'isnew', 'x08', 'are_users', 'are_position'));
      }
      elseif($request->isMethod('post'))
      {
          $datetime = Carbon::now();
          $flag = "false";

          $table = 'rssys.rechdr';
          $tableln = "rssys.reclne";

          $code = $code;
          $invoicedt = $request->invoicedt;
          // $stock_loc = $request->stock_loc;
          // $branch = $request->branch;
          $reference = $request->reference;
          $costcenter = $request->costcenter;
          $ris_no = $request->ris_no;
          $sai_no = $request->sai_no;
          //$stk_ref = $this->stk_trns_type."#".$code;
          $receivedfrom = $request->receivedfrom;
          $receivedfromdesig = $request->receivedfromdesig;

          Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedfrom);
          Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedfromdesig);

          $receivedby = $request->receivedby;
          $receivedbydesig = $request->receivedbydesig;
          Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedby);
          Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedbydesig);
            
          $data = ['_reference' => $reference, 
                   'trnx_date' => $invoicedt, 
                   // 'whs_code' => $stock_loc, 
                   'cc_code' => $costcenter, 
                   'ris_no' => $ris_no, 
                   'sai_no' => $sai_no, 
                   'recipient' => strtoupper(Session::get('_user')['id']),
                   't_date' => $datetime->toDateString(),
                   't_time' => $datetime->toTimeString(),
                   'are_receivedfrom' => $receivedfrom,
                   'are_receivedfromdesig' => $receivedfromdesig,
                   'are_receivedby' => $receivedby,
                   'are_receivebydesig' => $receivedbydesig
                   // 'branch' => $branch
                  ];

          if(Core::updateTable($table, 'rec_num', $code, $data, $this->module) == true)
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
                          'item_code' => $tb[1], 
                          'item_desc' => $tb[5], 
                          'recv_qty' => $tb[6], 
                          'issued_qty' => $tb[6], 
                          'unit' => $tb[7]];          

                if(Core::insertTable($tableln, $data2, $this->module))
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

    public function edit_02(Request $request, $code)
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
    
          $rechdr = Inventory::getRISHeader($code);

          $reclne = Inventory::getRISLine($code);
          $grandtotal = Inventory::getTotalAmtRIS($code);

          $x08 = Core::getAll('rssys.x08');
          $are_users = Core::getAll('rssys.are_users');
          $are_position = Core::getAll('rssys.are_position');

          $stockin = Inventory::getStockIn();
          $toolbar = ['link'=>'#','desc'=>'Edit','icon'=>'none','st'=>true];

          $dtfrm = date("Y-m-01");
          $dtto = date("Y-m-d");
    
          return view('inventory.ris.ris-entry-02', compact('rechdr', 'reclne', 'stock_loc', 'branch', 'itemunit', 'costcenter', 'vat', 'disp_items', 'grandtotal', 'isnew', 'x08', 'are_users', 'are_position', 'stockin', 'toolbar', 'dtfrm', 'dtto'));
      }
      elseif($request->isMethod('post'))
      {
          $datetime = Carbon::now();
          $flag = "false";

          $table = 'rssys.rechdr';
          $tableln = "rssys.reclne";

          $code = $code;
          $invoicedt = $request->invoicedt;
          // $stock_loc = $request->stock_loc;
          // $branch = $request->branch;
          $reference = $request->reference;
          $costcenter = $request->costcenter;
          $ris_no = $request->ris_no;
          $sai_no = $request->sai_no;
          //$stk_ref = $this->stk_trns_type."#".$code;
          $receivedfrom = $request->receivedfrom;
          $receivedfromdesig = $request->receivedfromdesig;

          Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedfrom);
          Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedfromdesig);

          $receivedby = $request->receivedby;
          $receivedbydesig = $request->receivedbydesig;
          Inventory::checkIfExistInsert('rssys.are_users', 'name', $receivedby);
          Inventory::checkIfExistInsert('rssys.are_position', 'name', $receivedbydesig);

          $purcord = $request->purcord;
            
          $data = ['_reference' => $reference, 
                   'trnx_date' => $invoicedt, 
                   // 'whs_code' => $stock_loc, 
                   'cc_code' => $costcenter, 
                   'ris_no' => $ris_no, 
                   'sai_no' => $sai_no, 
                   'recipient' => strtoupper(Session::get('_user')['id']),
                   't_date' => $datetime->toDateString(),
                   't_time' => $datetime->toTimeString(),
                   'are_receivedfrom' => $receivedfrom,
                   'are_receivedfromdesig' => $receivedfromdesig,
                   'are_receivedby' => $receivedby,
                   'are_receivebydesig' => $receivedbydesig,
                   'purc_ord' => $purcord
                   // 'branch' => $branch
                  ];

          if(Core::updateTable($table, 'rec_num', $code, $data, $this->module) == true)
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
                          'item_code' => $tb[1], 
                          'item_desc' => $tb[5], 
                          'recv_qty' => $tb[6], 
                          'issued_qty' => $tb[6], 
                          'unit' => $tb[7],
                          'price' => $tb[9]
                        ];          

                if(Core::insertTable($tableln, $data2, $this->module))
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
      $rechdr = Inventory::printRISHeader($code);
      $reclne = Inventory::printRISLine($code); 


      return view('inventory.ris.ris-print', compact('rechdr', 'reclne'));
    }

    public function getDataFromStockIn($code)
    {
       $data = Inventory::getStockInLineFromRIS($code);

       return $data;
    }

    public function getDataSelectionStkin($date)
    {
        $date = explode(",", $date);

        $dtfrm = $date[0];
        $dtto = $date[1];
        
        $data = Inventory::getStockIn($dtfrm, $dtto);

        return $data;
    }
}