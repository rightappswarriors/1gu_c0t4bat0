<?php

namespace App\Http\Controllers\MFile\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use DB;

class c_journal extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M1000006";
        $this->m05type = Core::getAll('rssys.m05type');
        $SQLM05 = "SELECT * FROM rssys.m05 m5 LEFT JOIN rssys.m05type m5t ON m5.j_type = m5t.code WHERE m5.active = TRUE";
        // $tableToJoin = [['tbl'=>'rssys.m05type', 'BLnk' => 'rssys.m05.j_type', 'ALnk' => 'rssys.m05type.code']];
        $this->m05 = DB::select($SQLM05);
    }
    public function view() // TO VIEW JOURNAL MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
    	// return dd($m05);
    	$data = array($this->m05type, $this->m05);
    	// dd($data[1]);
    	return view('masterfile.accounting.masterfile-accounting_journal', compact('data'));
    }

    public function add(Request $r) // TO ADD NEW JOURNAL MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
    	$data = ['j_code' => $r->txt_id, 'j_desc' => $r->txt_name, 'j_num' => $r->txt_nxt_rf_no, 'check_by' => (isset($r->txt_rv_by) ? $r->txt_rv_by : ''), 'noted_by' => (isset($r->txt_ntd_by) ? $r->txt_ntd_by : ''), 'approv_by' => (isset($r->txt_apd_by) ? $r->txt_apd_by : ''), 'j_type' => $r->sel_type];
    	if (Core::insertTable('rssys.m05', $data, 'Journal'))
        {
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING JOURNAL MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	$data = ['j_desc' => $r->txt_name, 'j_num' => $r->txt_nxt_rf_no, 'check_by' => (isset($r->txt_rv_by) ? $r->txt_rv_by : ''), 'noted_by' => (isset($r->txt_ntd_by) ? $r->txt_ntd_by : ''), 'approv_by' => (isset($r->txt_apd_by) ? $r->txt_apd_by : ''), 'j_type' => $r->sel_type];
    	if (Core::updateTable('rssys.m05', 'j_code', $r->txt_id, $data, 'Journal'))
        {
            return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING JOURNAL MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	$data = ['active' => FALSE];
        if (Core::updateTable('rssys.m05', 'j_code', $r->txt_id, $data, 'Journal'))
        {
            return back();
        }
        return back();
    }
}
