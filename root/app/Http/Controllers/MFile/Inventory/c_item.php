<?php

namespace App\Http\Controllers\MFile\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;

class c_item extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M2000005";
        $itemgrpSQL = "SELECT item_grp, grp_desc FROM rssys.itmgrp WHERE active = TRUE ORDER BY grp_desc ASC";
        $this->itmgrp = Core::sql($itemgrpSQL);
        $brandSQL = "SELECT brd_code, brd_name FROM rssys.brand WHERE active = TRUE ORDER BY brd_name ASC";
        $this->brand = Core::sql($brandSQL);
        $genericSQL = "SELECT gen_code, gen_name FROM rssys.generic WHERE active = TRUE ORDER BY gen_name ASC";
        $this->generic = Core::sql($genericSQL);
        $itmunitSQL = "SELECT unit_id, unit_desc, unit_shortcode FROM rssys.itmunit  WHERE active = TRUE ORDER BY unit_desc ASC";
        $this->itmunit = Core::sql($itmunitSQL);
        $itemsSQL = "SELECT item_code, item_desc, item_class, sell_pric, markup, gp, reorder, max_level, bin_loc, brd_code, item_grp, sales_unit_id, purc_unit_id, fcp, ave_cost, gen_code, active, vat_exempt, unit_cost, tag_no, serial_no, part_no FROM rssys.items WHERE active = TRUE";
        $this->items = Core::sql($itemsSQL);
    }
    public function view() // TO VIEW ITEM MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        // return dd($this->items);
        return view('masterfile.inventory.masterfile-inventory_item', ['itemgrp' => $this->itmgrp, 'brand' => $this->brand, 'generic' => $this->generic, 'itmunit' => $this->itmunit, 'items' => $this->items]);
    }

    public function add(Request $r) // TO ADD NEW ITEM MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
        $item_code = Core::getm99One('item_code');
        // return $item_code->item_code;
        $data = [
                    'item_code' => $item_code->item_code,
                    'item_desc' => $r->txt_name,
                    'stk_item' => 'Y',
                    'item_class' => $r->sel_itm_class,
                    'unit_cost' => $r->itm_amt,
                    'sell_pric' => $r->itm_srp_pro, 
                    'markup' => $r->itm_mark_up,
                    'gp' => (floatval($r->itm_srp_pro) - floatval($r->itm_amt)),
                    'reorder' =>  $r->itm_reorder_lvl,
                    'max_level' => $r->itm_max_lvl,
                    'bin_loc' =>  $r->txt_rak_loc,
                    // 'req_lot' => ,
                    'brd_code' =>  $r->sel_brand,
                    'item_grp' => $r->sel_itmgrp,
                    'sales_unit_id' => $r->sel_itmunit,
                    'purc_unit_id' => $r->sel_purunit,
                    'sc_price' => 0.00,
                    'assembly' => 'N',
                    'qty_onhand' => '0.00',
                    'qty_onhand_su' => '0.00',
                    'fcp' => $r->itm_amt,
                    'ave_cost' => $r->itm_amt,
                    // 'ccode' => '',
                    'gen_code' =>  $r->sel_generic,
                    'branch' => '001',
                    // 'yearmodel' => '',
                    'tag_no' =>( $r->txt_tag_no != '' ? $r->txt_tag_no : null),
                    'serial_no' =>( $r->txt_ser_no != '' ? $r->txt_ser_no : null),
                    'part_no' =>( $r->txt_part_no != '' ? $r->txt_part_no : ''),
                    'active' => (($r->sel_status == 'T') ? TRUE : FALSE),
                    // 'wholesale_price' => $r->itm_whl_pri, // WALA SA TABLE
                    // 'partbrand' => $r->sel_brand,
                    // 'gp_rate' => $r->itm_gp_rate,
                    'vat_exempt' => (isset($r->txt_vat_exempt) ? 'Y' : 'N'),
                ];
        // return dd($data);
        // return dd(Core::insertTable('rssys.items', $data, 'Item'));
        if (Core::insertTable('rssys.items', $data, 'Item'))
        {
            Core::updatem99('item_code' , Core::get_nextincrementlimitchar($item_code->item_code, 10));
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING ITEM MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
    	$data = [
                    // 'item_code' => $item_code->item_code,
                    'item_desc' => $r->txt_name,
                    'stk_item' => 'Y',
                    'item_class' => $r->sel_itm_class,
                    'unit_cost' => $r->itm_amt,
                    'sell_pric' => $r->itm_srp_pro, 
                    'markup' => $r->itm_mark_up,
                    'gp' => (floatval($r->itm_srp_pro) - floatval($r->itm_amt)),
                    'reorder' =>  $r->itm_reorder_lvl,
                    'max_level' => $r->itm_max_lvl,
                    'bin_loc' =>  $r->txt_rak_loc,
                    // 'req_lot' => ,
                    'brd_code' =>  $r->sel_brand,
                    'item_grp' => $r->sel_itmgrp,
                    'sales_unit_id' => $r->sel_itmunit,
                    'purc_unit_id' => $r->sel_purunit,
                    'sc_price' => 0.00,
                    'assembly' => 'N',
                    'qty_onhand' => '0.00',
                    'qty_onhand_su' => '0.00',
                    'fcp' => $r->itm_amt,
                    'ave_cost' => $r->itm_amt,
                    // 'ccode' => '',
                    'gen_code' =>  $r->sel_generic,
                    'branch' => '001',
                    // 'yearmodel' => '',
                    'tag_no' =>($r->txt_tag_no != '' ? $r->txt_tag_no : null),
                    'serial_no' =>( $r->txt_ser_no != '' ? $r->txt_ser_no : null),
                    'part_no' =>($r->txt_part_no != '' ? $r->txt_part_no : ''),
                    'active' => (($r->sel_status == 'T') ? TRUE : FALSE),
                    // 'wholesale_price' => $r->itm_whl_pri, // WALA SA TABLE
                    // 'partbrand' => $r->sel_brand,
                    // 'gp_rate' => $r->itm_gp_rate,
                    'vat_exempt' => (isset($r->txt_vat_exempt) ? 'Y' : 'N'),
                ];
    	if (Core::updateTable('rssys.items', 'item_code', $r->txt_id, $data, 'Item'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING ITEM MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $data = ['active' => FALSE];
    	if (Core::updateTable('rssys.items', 'item_code', $r->txt_id, $data, 'Item'))
        {
             return back();
        }
        return back();
    }
}
