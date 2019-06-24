<?php

namespace App\Http\Controllers\MFile\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use DB;
use Session;

class c_account_group extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M1000004";
        $this->m01 = Core::getAll("rssys.m01");
        $tableToJoin = [['tbl'=>'rssys.m01', 'BLnk' => 'rssys.m02.mag_code', 'ALnk' => 'rssys.m01.mag_code']];
        $this->m02 = Core::getAllLeftJoin('rssys.m02', $tableToJoin);
        $SQLM03 = "SELECT * FROM rssys.m03 m3 
                    LEFT JOIN rssys.m02 m2 ON m3.cmp_code = m2.cmp_code
                    LEFT JOIN rssys.m01 m1 ON m2.mag_code = m1.mag_code
                    WHERE m3.active = TRUE";
        $this->m03 = DB::select($SQLM03);
        if (isset($this->m03)) {
            for ($i=0; $i < count($this->m03); $i++) { 
                $this->m03[$i]->dr_cr_desc = ($this->m03[$i]->dr_cr == 'D') ? "Debit" : "Credit";
            }
        }
    }
    public function view() // TO VIEW ACCOUNT GROUP MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
    	$data = array($this->m02, $this->m03);
        // return dd($data[1]);
    	return view('masterfile.accounting.masterfile-accounting_account_group', compact('data'));
    }

    public function add(Request $r) // TO ADD NEW ACCOUNT GROUP MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
       $data = ['acc_code' => $r->txt_id, 'acc_desc' => $r->txt_name, 'cmp_code' => $r->sel_type, 'dr_cr' => $r->sel_db];
       if (Core::insertTable('rssys.m03', $data, 'Account Group')) 
        {
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING ACCOUNT GROUP MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
        $data = ['acc_desc' => $r->txt_name, 'cmp_code' => $r->sel_type, 'dr_cr' => $r->sel_db];
        if (Core::updateTable('rssys.m03', 'acc_code', $r->txt_id, $data, 'Account Group')) 
        {
            return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING ACCOUNT GROUP MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
       $data = ['active' => FALSE];
        if (Core::updateTable('rssys.m03', 'acc_code', $r->txt_id, $data, 'Account Group')) 
        {
            return back();
        }
        return back();
    }

}
