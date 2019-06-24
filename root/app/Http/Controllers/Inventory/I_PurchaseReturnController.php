<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class I_PurchaseReturnController extends Controller
{
    private $stk_trns_type = "PR";
    private $module = "Purchase Return";

    public function view()
    {
        $data = Inventory::getPurchaseReturn();

        return view('inventory.purchasereturn', compact('data'));
    }

    public function add(Request $request)
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

            return view('inventory.purchasereturn-create', compact('supplier', 'stock_loc', 'branch','modeofpayment', 'disp_items', 'itemunit', 'costcenter', 'subcostcenter', 'vat'));
        }
        else if($request->isMethod('post')) // store entry
        {
            $datetime = Carbon::now();
            $flag = "false";

            $table = 'rssys.prethdr';
            $tableln = "rssys.pretlne";

            $getCode = Core::getm99One('pret_num');
            $code = $getCode->pret_num;
            $invoicedt = $request->invoicedt;
            $stock_loc = $request->stock_loc;
            $branch = $request->branch;
            $supl_code = $request->supl_code;
            $supl_name = $request->supl_name;
            $reference = $request->reference;
            //$termsofpayment = $request->termsofpayment;
            $stk_ref = $this->stk_trns_type."#".$code;
            
            $data = ['pret_num' => $code, 
                     'supl_code' => $supl_code, 
                     'supl_name' => $supl_name, 
                     'reference' => $reference, 
                     'trnx_date' => $invoicedt, 
                     'whs_code' => $stock_loc, 
                     // 'trn_type' => $this->stk_trns_type, 
                     'user_id' => strtoupper(Session::get('_user')['id']),
                     't_date' => $datetime->toDateString(),
                     't_time' => $datetime->toTimeString(),
                     // 'payment_term' => $termsofpayment,
                     'branch' => $branch
                    ];

            if(Core::insertTable($table, $data, $this->module) == true)
            {
                Core::updatem99('pret_num', Core::get_nextincrementlimitchar($code, 8));

                foreach($request->tbl_itemlist as $tb)
                {
                    $data2 = ['pret_num' => $code, 
                              'ln_num' => $tb[0], 
                              'part_no' => $tb[1], 
                              'item_code' => $tb[2], 
                              'item_desc' => $tb[3], 
                              'ret_qty' => $tb[4], 
                              'unit' => $tb[5], 
                              'price' => $tb[7], 
                              'discount' => $tb[8], 
                              'ln_amnt' => $tb[9],
                              'net_amnt' => $tb[10], 
                              'ln_vat' => $tb[11],
                              'ln_vatamt' => $tb[12]];

                    if(Core::insertTable($tableln, $data2, $this->module))
                    {
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
                                    'whs_code' => $stock_loc,
                                    'supl_code' => $supl_code,
                                    'supl_name' => $supl_name,
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
    
          $prethdr = Inventory::getPurchaseReturnHeader($code);
          $pretlne = Inventory::getPurchaseReturnLine($code);
          $grandtotal = Inventory::getTotalAmtPR($code);
    
          return view('inventory.purchasereturn-edit', compact('prethdr', 'pretlne', 'supplier', 'stock_loc', 'branch', 'modeofpayment', 'itemunit', 'costcenter', 'subcostcenter', 'vat', 'disp_items', 'grandtotal'));
      }
      elseif($request->isMethod('post'))
      {
          $datetime = Carbon::now();
          $flag = "false";

          $table = 'rssys.prethdr';
          $tableln = "rssys.pretlne";

          $code = $code;
          $invoicedt = $request->invoicedt;
          $stock_loc = $request->stock_loc;
          $branch = $request->branch;
          $supl_code = $request->supl_code;
          $supl_name = $request->supl_name;
          $reference = $request->reference;
          $stk_ref = $this->stk_trns_type."#".$code;
            
          $data = ['supl_code' => $supl_code, 
                   'supl_name' => $supl_name, 
                   'reference' => $reference, 
                   'trnx_date' => $invoicedt, 
                   'whs_code' => $stock_loc, 
                   'user_id' => strtoupper(Session::get('_user')['id']),
                   't_date' => $datetime->toDateString(),
                   't_time' => $datetime->toTimeString(),
                   'branch' => $branch
                  ];

          if(Core::updateTable($table, 'pret_num', $code, $data, $this->module) == true)
          {
              $del_dataln = [['pret_num', '=', $code]];
              $del_datastkcrd = [['reference', '=', $stk_ref]];

              Core::deleteTableMultiWhere($tableln, $del_dataln, 'PurchaseReturnlnDel');
              Core::deleteTableMultiWhere('rssys.stkcrd', $del_datastkcrd, 'StockCardDel');

              foreach($request->tbl_itemlist as $tb)
              {
                $data2 = ['pret_num' => $code, 
                          'ln_num' => $tb[0], 
                          'part_no' => $tb[1], 
                          'item_code' => $tb[2], 
                          'item_desc' => $tb[3], 
                          'ret_qty' => $tb[4], 
                          'unit' => $tb[5], 
                          'price' => $tb[7], 
                          'discount' => $tb[8], 
                          'ln_amnt' => $tb[9],
                          'net_amnt' => $tb[10], 
                          'ln_vat' => $tb[11],
                          'ln_vatamt' => $tb[12]];

                if(Core::insertTable($tableln, $data2, 'ReceivingPOln'))
                {
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
                               'whs_code' => $stock_loc,
                               'supl_code' => $supl_code,
                               'supl_name' => $supl_name,
                               'trn_type' => $this->stk_trns_type,
                               'branch' => $branch];

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
      $table = "rssys.prethdr";
      $col = "pret_num";
      $flag = 'false';

      if(Inventory::cancelPurchaseReturn($code, $stk_ref, $table, $col, $this->module))
      {
        $flag = 'true';
      }

      return $flag;
    }
}