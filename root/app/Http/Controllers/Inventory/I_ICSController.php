<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class I_ICSController extends Controller
{
    private $stk_trns_type = "I";
    private $module = "Inventory Custodian Slip";

    public function view()
    {  
        $data = Inventory::getICS();

        return view('inventory.ics.ics', compact('data'));
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
            $isnew = true;

            $disp_items = Inventory::getItemSearch();

            $ris_approved = Inventory::getRISFromICS();

            return view('inventory.ics.ics-entry', compact('stock_loc', 'branch', 'disp_items', 'itemunit', 'costcenter', 'vat', 'x08', 'ris_approved', 'isnew'));
        }
        else if($request->isMethod('post'))
        {
            $datetime = Carbon::now();
            $flag = "false";

            $table = 'rssys.rechdr';
            $tableln = "rssys.reclne";

            $getCode = Core::getm99One('ics_code');
            $code = $getCode->ics_code;
            $invoicedt = $request->invoicedt;
            // $stock_loc = $request->stock_loc;
            // $branch = $request->branch;
            $reference = $request->reference;
            $costcenter = $request->costcenter;
            $ics_no = $request->ics_no;
            $personnel = $request->personnel;
            //$stk_ref = $this->stk_trns_type."#".$code;
            $purc_ord = $request->ris_code;
            
            $data = ['rec_num' => $code,  
                     '_reference' => $reference, 
                     'trnx_date' => $invoicedt, 
                     // 'whs_code' => $stock_loc, 
                     'trn_type' => $this->stk_trns_type, 
                     'cc_code' => $costcenter, 
                     'ics_no' => $ics_no, 
                     'personnel' => $personnel, 
                     'recipient' => strtoupper(Session::get('_user')['id']),
                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString(),
                     'purc_ord' => $purc_ord
                     // 'branch' => $branch
                    ];

            if(Core::insertTable($table, $data, $this->module) == true)
            {
                Core::updatem99('ics_code', Inventory::get_nextincrementwithchar($code));

                foreach($request->tbl_itemlist as $tb)
                {

                    $data2 = ['rec_num' => $code, 
                              'ln_num' => $tb[0],  
                              'item_code' => $tb[1], 
                              'part_no' => $tb[2], 
                              'item_desc' => $tb[5], 
                              'recv_qty' => $tb[6], 
                              // 'issued_qty' => $tb[4], 
                              'unit' => $tb[7] 
                              // 'price' => $tb[7], 
                              // 'discount' => $tb[8], 
                              // 'ln_amnt' => $tb[9],
                              // 'net_amnt' => $tb[10], 
                              // 'ln_vat' => $tb[11],
                              // 'ln_vatamt' => $tb[12]
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

                         // if(Inventory::saveToStkcrd($stkcrd))
                         // { }
                         // else
                         // {
                         //   $flag = 'false';
                         //   break;
                         // }          
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
          $isnew = false;
          $stock_loc = Core::getAll('rssys.whouse');
          $branch = Core::getAll('rssys.branch');
          $itemunit = Core::getAll('rssys.itmunit');
          $costcenter = Core::getAll('rssys.m08');
          $vat = Core::getAll('rssys.vat');
    
          $disp_items = Inventory::getItemSearch();
    
          $rechdr = Inventory::getICSHeader($code);
          $reclne = Inventory::getICSLine($code);
          //$grandtotal = Inventory::getTotalAmtRIS($code);
          $ris_approved = Inventory::getRISFromICS();
          $x08 = Core::getAll('rssys.x08');
    
          //return view('inventory.ris.ris-edit', compact('rechdr', 'reclne', 'stock_loc', 'branch', 'itemunit', 'costcenter', 'vat', 'disp_items', 'grandtotal'));

          return view('inventory.ics.ics-entry', compact('stock_loc', 'branch', 'disp_items', 'itemunit', 'costcenter', 'vat', 'x08', 'ris_approved', 'isnew', 'rechdr', 'reclne'));
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
          $reference = $request->reference;
          $costcenter = $request->costcenter;
          $ics_no = $request->ics_no;
          $personnel = $request->personnel;
          $purc_ord = $request->ris_no;
          //$stk_ref = $this->stk_trns_type."#".$code;
            
          $data = ['_reference' => $reference, 
                   'trnx_date' => $invoicedt, 
                   // 'whs_code' => $stock_loc, 
                   'cc_code' => $costcenter, 
                   'ics_no' => $ics_no, 
                   'personnel' => $personnel, 
                   'recipient' => strtoupper(Session::get('_user')['id']),
                   't_date' => $datetime->toDateString(),
                   't_time' => $datetime->toTimeString(),
                   'purc_ord' => $purc_ord
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
                              'item_code' => $tb[1], 
                              'part_no' => $tb[2], 
                              'item_desc' => $tb[5], 
                              'recv_qty' => $tb[6], 
                              // 'issued_qty' => $tb[4], 
                              'unit' => $tb[7] 
                              // 'price' => $tb[7], 
                              // 'discount' => $tb[8], 
                              // 'ln_amnt' => $tb[9],
                              // 'net_amnt' => $tb[10], 
                              // 'ln_vat' => $tb[11],
                              // 'ln_vatamt' => $tb[12]
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

      if(Inventory::cancelICS($code, $stk_ref, $table, $col, $this->module))
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

    public function getDataFromRIS($ris_code)
    {
       $ris_data = Inventory::getRISLineFromICS($ris_code);
       $cc_code = Inventory::getRISOffice($ris_code);

       $data = array($ris_data, $cc_code->cc_code);

       return $data;
    }
}