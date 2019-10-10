<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class I_WasteMaterialController extends Controller
{
    //private $stk_trns_type = "P";
    private $module = "Waste Material";

    public function view()
    {
        $data = Inventory::getWasteMaterial();

        return view('inventory.wastematerial.wastematerial', compact('data'));
    }

    public function add(Request $request)
    {
        if($request->isMethod('get'))
        {
            $stock_loc = Core::getAll('rssys.whouse');
            $itemunit = Core::getAll('rssys.itmunit');
            $costcenter = Core::getAll('rssys.m08');
            $x08 = Core::getAll('rssys.x08');
            $isnew = true;

            $disp_items = Inventory::getItemSearch();

            return view('inventory.wastematerial.wastematerial-entry', compact('stock_loc', 'disp_items', 'itemunit', 'costcenter', 'isnew', 'x08'));
        }
        else if($request->isMethod('post'))
        {
            $datetime = Carbon::now();
            $flag = "false";

            $table = 'rssys.wastematerialhdr';
            $tableln = "rssys.wastemateriallne";

            $getCode = Core::getm99One('wm_code');
            $code = $getCode->wm_code;
            $invoicedt = $request->invoicedt;
            $stock_loc = $request->stock_loc;
            $office = $request->office;
            $certifiedCorrect = $request->certifiedCorrect;
            $disposalApproved = $request->disposalApproved;
            //$stk_ref = $this->stk_trns_type."#".$code;
            
            $data = ['code' => $code, 
                     'trnx_date' => $invoicedt, 
                     'whs_code' => $stock_loc, 
                     'cc_code' => $office,
                     'certified_correct' => $certifiedCorrect,
                     'disposal_approved' => $disposalApproved,
                     'recipient' => strtoupper(Session::get('_user')['id']),
                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString()
                    ];

            if(Core::insertTable($table, $data, $this->module) == true)
            {
                Core::updatem99('wm_code', Core::get_nextincrementlimitchar($code, 8));

                foreach($request->tbl_itemlist as $tb)
                {
                    $data2 = ['code' => $code, 
                              'ln_num' => $tb[0],  
                              'item_code' => $tb[1], 
                              'item_desc' => $tb[5],
                              'qty' => $tb[6], 
                              'unit' => $tb[7], 
                              'price' => $tb[9], 
                              'or_no' => $tb[10]];

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
          $stock_loc = Core::getAll('rssys.whouse');
          $itemunit = Core::getAll('rssys.itmunit');
          $costcenter = Core::getAll('rssys.m08');
          $x08 = Core::getAll('rssys.x08');
          $isnew = true;

          $disp_items = Inventory::getItemSearch();
    
          $datahdr = Inventory::getWasteMaterialHeader($code);
          $datalne = Inventory::getWasteMaterialLine($code);
          $isnew = false;
    
          return view('inventory.wastematerial.wastematerial-entry', compact('stock_loc', 'disp_items', 'itemunit', 'costcenter', 'isnew', 'x08', 'datahdr', 'datalne'));
      }
      elseif($request->isMethod('post'))
      {
          $datetime = Carbon::now();
          $flag = "false";

          $table = 'rssys.wastematerialhdr';
          $tableln = "rssys.wastemateriallne";

          $code = $code;
          $invoicedt = $request->invoicedt;
          $stock_loc = $request->stock_loc;
          $office = $request->office;
          $certifiedCorrect = $request->certifiedCorrect;
          $disposalApproved = $request->disposalApproved;
          //$stk_ref = $this->stk_trns_type."#".$code;
            
          $data = ['trnx_date' => $invoicedt, 
                   'whs_code' => $stock_loc, 
                   'cc_code' => $office,
                   'certified_correct' => $certifiedCorrect,
                   'disposal_approved' => $disposalApproved,
                   'recipient' => strtoupper(Session::get('_user')['id']),
                   't_date' => $datetime->toDateString(),
                   't_time' => $datetime->toTimeString()
                  ];

          if(Core::updateTable($table, 'code', $code, $data, $this->module) == true)
          {
              $del_dataln = [['code', '=', $code]];

              Core::deleteTableMultiWhere($tableln, $del_dataln, $this->module);

              foreach($request->tbl_itemlist as $tb)
              {
                $data2 = ['code' => $code, 
                          'ln_num' => $tb[0],  
                          'item_code' => $tb[1], 
                          'item_desc' => $tb[5],
                          'qty' => $tb[6], 
                          'unit' => $tb[7], 
                          'price' => $tb[9], 
                          'or_no' => $tb[10]];

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
      $stk_ref = $code;
      $table = "rssys.wastematerialhdr";
      $col = "code";
      $flag = 'false';

      if(Inventory::cancelWasteMaterial($code, $stk_ref, $table, $col, $this->module))
      {
        $flag = 'true';
      }

      return $flag;
    }

    public function print($code)
    {
      $header = Inventory::printWasteMaterialHeader($code);
      $line = Inventory::printWasteMaterialLine($code);

      return view('inventory.wastematerial.wastematerial-print', compact('header', 'line'));
    }
}