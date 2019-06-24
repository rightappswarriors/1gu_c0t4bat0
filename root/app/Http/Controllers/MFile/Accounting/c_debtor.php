<?php

namespace App\Http\Controllers\MFile\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use DB;
use Session;

class c_debtor extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M1000007";
        $SQLM06 = "SELECT * FROM rssys.m06 WHERE active = TRUE";
        $this->m06 = DB::select($SQLM06);
        $this->m10 = Core::getAll("rssys.m10");
        $tableToJoin = ['clm'=>'rssys.m04.sl', 'data' => 'Y'];
        $this->m04 = Core::getWithPara("rssys.m04", $tableToJoin);
        $SQLBrgy = "SELECT * FROM rssys.barangay WHERE active = TRUE";
        $this->barangay = DB::select($SQLBrgy);
    }
    public function view() // TO VIEW CUSTOMER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }

        // return dd($this->barangay);
        return view('masterfile.accounting.masterfile-accounting_debtor', ['m06' => $this->m06, 'm10' => $this->m10, 'm04' => $this->m04, 'brgy' => $this->barangay]);
    }

    public function add(Request $r) // TO ADD NEW CUSTOMER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $d_code = Core::getm99One('d_code');
        $data = [
                    'd_code' => $d_code->d_code,
                    'd_name' => $r->txt_name,
                    'd_addr1' => $r->sel_brgy,
                    'd_addr2' => $r->txt_add,
                    'd_tel' => $r->txt_phn_num,
                    'd_fax' => $r->txt_fax_num,
                    'd_email' => $r->txt_email,
                    'd_tin' => $r->txt_tin_num,
                    'd_cntc' => $r->txt_cnt_per,
                    'd_cntc_no' => $r->txt_mob_num,
                    'limit' => $r->txt_crd_lmt,
                    'mp_code' => $r->sel_mop,
                    'at_code' => $r->sel_sub_led,
                    'remarks' => $r->txt_rmks,
                    'type' => $r->sel_type
                ];
        if (Core::insertTable('rssys.m06', $data, 'Account Debtors'))
        {
            Core::updatem99('d_code' , Core::get_nextincrementlimitchar($d_code->d_code, 6));
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING CUSTOMER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	$data = [
                    'd_name' => $r->txt_name,
                    'd_addr1' => $r->sel_brgy,
                    'd_addr2' => $r->txt_add,
                    'd_tel' => $r->txt_phn_num,
                    'd_fax' => $r->txt_fax_num,
                    'd_email' => $r->txt_email,
                    'd_tin' => $r->txt_tin_num,
                    'd_cntc' => $r->txt_cnt_per,
                    'd_cntc_no' => $r->txt_mob_num,
                    'limit' => $r->txt_crd_lmt,
                    'mp_code' => $r->sel_mop,
                    'at_code' => $r->sel_sub_led,
                    'remarks' => $r->txt_rmks,
                    'type' => $r->sel_type
                ];
    	if (Core::updateTable('rssys.m06', 'd_code', $r->txt_id, $data, 'Debtors'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING CUSTOMER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $data = ['active' => FALSE];
    	if (Core::updateTable('rssys.m06', 'd_code', $r->txt_id, $data, 'Debtors'))
        {
             return back();
        }
        return back();
    }
}
