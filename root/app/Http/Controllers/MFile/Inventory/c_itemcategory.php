<?php

namespace App\Http\Controllers\MFile\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use DB;
use Session;

class c_itemcategory extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M2000003";
        $sql2 = "SELECT at_code, at_desc FROM rssys.m04 WHERE active = TRUE";
        $sql3 = "SELECT ottyp, ot_desc FROM rssys.outlettyp";
        
        $this->m04 = Core::sql($sql2);
        $this->outlettyp = Core::sql($sql3);

    }
    public function view() // TO VIEW ITEM CATEGORY MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        $sql = "SELECT * FROM rssys.itmgrp AS itm
                LEFT JOIN rssys.outlettyp AS otl ON itm.grptype = otl.ottyp WHERE itm.active = TRUE
                ORDER BY itm.grp_desc
                ";
        $itmgrp = Core::sql($sql);
        // return dd($itmgrp[0]->acct_stks);
        if(count($itmgrp) > 0)
        {
            // SELECT at_desc FROM rssys.m04 WHERE at_code = '1-01-01-010'
            $sqltest = "SELECT at_desc FROM rssys.m04 WHERE at_code = '".$itmgrp[0]->acct_stks."'";

            // return $sqltest;
            // return dd(DB::table(DB::raw('rssys.m04'))->select('at_desc')->where('rssys.m04.at_code', '=', $itmgrp[0]->acct_stks)->first());
            for ($i=0; $i < count($itmgrp); $i++) { 
                // $this->itmgrp[$i]->acct_stks_desc = "";
                if($itmgrp[$i]->acct_stks != ''){
                    // $sqltest = "SELECT at_desc FROM rssys.m04 WHERE at_code = '".$itmgrp[$i]->acct_stks."'";
                    $temp = DB::table(DB::raw('rssys.m04'))->select('at_desc')->where('at_code', '=', $itmgrp[$i]->acct_stks)->first();
                    if($temp){
                        $itmgrp[$i]->acct_stks_desc = $temp->at_desc;
                    } else {
                        $itmgrp[$i]->acct_stks_desc = '';
                    }
                    // return Core::sql($sqltest);
                } else {
                    $itmgrp[$i]->acct_stks_desc = '';
                }

                if($itmgrp[$i]->acct_sales != ''){
                    // $sqltest = "SELECT at_desc FROM rssys.m04 WHERE at_code = '".$itmgrp[$i]->acct_stks."'";
                    $temp1 = DB::table(DB::raw('rssys.m04'))->select('at_desc')->where('at_code', '=', $itmgrp[$i]->acct_sales)->first();
                    if($temp1){
                        $itmgrp[$i]->acct_sales_desc = $temp1->at_desc;
                    } else {
                        $itmgrp[$i]->acct_sales_desc = '';
                    }
                    // return Core::sql($sqltest);
                } else {
                    $itmgrp[$i]->acct_sales_desc = '';
                }

                if($itmgrp[$i]->acct_cost != ''){
                    // $sqltest = "SELECT at_desc FROM rssys.m04 WHERE at_code = '".$itmgrp[$i]->acct_stks."'";
                    $temp2 = DB::table(DB::raw('rssys.m04'))->select('at_desc')->where('at_code', '=', $itmgrp[$i]->acct_cost)->first();
                    if($temp2){
                        $itmgrp[$i]->acct_cost_desc = $temp2->at_desc;
                    } else {
                        $itmgrp[$i]->acct_cost_desc = '';
                    }
                    // return Core::sql($sqltest);
                } else {
                    $itmgrp[$i]->acct_cost_desc = '';
                }


            }
        }
        // return dd($this->m04);
        return view('masterfile.inventory.masterfile-inventory_item_category', ['outlettyp' => $this->outlettyp, 'itmgrp' => $itmgrp, 'm04' => $this->m04]);
    }

    public function add(Request $r) // TO ADD NEW ITEM CATEGORY MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r->all());
        $data = [
                    'item_grp' => $r->txt_id,
                    'grp_desc' => $r->txt_name,
                    'acct_stks' => $r->sel_stock,
                    'acct_sales' => $r->sel_sale,
                    'acct_cost' => $r->sel_cost,
                    'next_num' => $r->txt_next,
                    'branch' => '001',
                    'grptype' => $r->sel_typ,
                ];
        // return dd(Core::insertTable('rssys.generic', $data, 'generic Name'));
        if (Core::insertTable('rssys.itmgrp', $data, 'Item Category'))
        {
        //     Core::updatem99('fid' , Core::get_nextincrementlimitchar($fid->fid, 8));
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING ITEM CATEGORY MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	$data = [
                    // 'item_grp' => $r->txt_id,
                    'grp_desc' => $r->txt_name,
                    'acct_stks' => $r->sel_stock,
                    'acct_sales' => $r->sel_sale,
                    'acct_cost' => $r->sel_cost,
                    'next_num' => $r->txt_next,
                    'branch' => '001',
                    'grptype' => $r->sel_typ,
                ];
    	if (Core::updateTable('rssys.itmgrp', 'item_grp', $r->txt_id, $data, 'Item Category'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING ITEM CATEGORY MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	$data = [
                    'active' => FALSE,
                ];
        if (Core::updateTable('rssys.itmgrp', 'item_grp', $r->txt_id, $data, 'Item Category'))
        {
             return back();
        }
        return back();
    }
}
