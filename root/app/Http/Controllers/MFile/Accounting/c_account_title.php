<?php

namespace App\Http\Controllers\MFile\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use DB;
use Session;

class c_account_title extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M1000005";
        $this->m03 = DB::select("SELECT * FROM rssys.m03 WHERE active = TRUE");
        $sql = "SELECT DISTINCT * FROM rssys.m04 LEFT JOIN rssys.m03 ON rssys.m04.acc_code = rssys.m03.acc_code
                WHERE rssys.m04.active = TRUE";
        // $tableToJoin = [['tbl'=>'rssys.m03', 'BLnk' => 'rssys.m04.acc_code', 'ALnk' => 'rssys.m03.acc_code']];
        // $this->m04 = Core::getAllLeftJoin("rssys.m04", $tableToJoin);
        $this->m04 = Core::sql($sql);
    }
    public function get(Request $r) // TO GET M04 DATA
    {
    	$tableToJoin = ['clm'=>'rssys.m04.sl', 'data' => 'Y'];
    	$m04 = Core::getWithPara("rssys.m04", $tableToJoin);
    	return $m04;
    }
	public function view() // TO VIEW ACCOUNT TITLE MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        // return dd($this->m04);
    	$data = array($this->m03, $this->m04);
    	return view('masterfile.accounting.masterfile-accounting_account_title', compact('data'));
    }

    public function add(Request $r) // TO ADD NEW ACCOUNT TITLE MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	// return dd($r);
    	$data = ['at_code' => $r->txt_id, 'at_desc' => $r->txt_name, 'bs_pl' => 'B', 'dr_cr' => $r->sel_db, 'sl' => (isset($r->sel_sl)? 'Y' : 'N'), 'cib_acct' => (isset($r->sel_cw)? 'Y' : 'N'), 'acc_code' => $r->sel_type , 'payment' => (isset($r->sel_py) ? 'Y' : 'N'), 'acro' => urlencode(urlencode($r->txt_acro))];
    	if (Core::insertTable('rssys.m04', $data, 'Account Title'))
        {
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING ACCOUNT TITLE MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	// 'at_code' => $r->txt_id,'
    	$data = ['at_desc' => $r->txt_name, 'bs_pl' => 'B', 'dr_cr' => $r->sel_db, 'sl' => (isset($r->sel_sl)? 'Y' : 'N'), 'cib_acct' => (isset($r->sel_cw) ? 'Y' : 'N'), 'acc_code' => $r->sel_type, 'payment' => (isset($r->sel_py) ? 'Y' : 'N'), 'acro' => urlencode($r->txt_acro)];
    	// return dd($data['dr_']);
    	if (Core::updateTable('rssys.m04', 'at_code', $r->txt_id, $data, 'Account Title')) 
        {
            return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING ACCOUNT TITLE MODULE
    {
        $grp = Session::get('grp_ri');
        // return dd($grp[$this->MOD_CODE]);
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	$data = ['active' => FALSE];
        if (Core::updateTable('rssys.m04', 'at_code', $r->txt_id, $data, 'Account Title')) 
        {
            return back();
        }
        return back();
    }
}
