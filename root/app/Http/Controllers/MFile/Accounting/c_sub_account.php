<?php

namespace App\Http\Controllers\MFile\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use DB;
class c_sub_account extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M1000003";
        $this->m01 = Core::getAll("rssys.m01");
        $SQLM02 ="SELECT * FROM rssys.m02 m2 LEFT JOIN rssys.m01 m1 ON m2.mag_code = m1.mag_code WHERE m2.active = TRUE";
        $this->m02 = DB::select($SQLM02);
    }
    public function view() // TO VIEW SUB MAIN ACCOUNT MODULE
    {   
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
    	$data = array($this->m01, $this->m02);
        // return dd($data[1]);
    	return view('masterfile.accounting.masterfile-accounting_sub_account' ,compact('data'));
    }

    public function add(Request $r) // TO ADD NEW SUB MAIN ACCOUNT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $data = ['cmp_code' => $r->txt_id, 'cmp_desc' => $r->txt_name, 'mag_code' => $r->sel_type];
    	if (Core::insertTable('rssys.m02', $data, 'Sub Account'))
        {
    		return back();
    	}
    	return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING SUB MAIN ACCOUNT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $update = array('cmp_desc' => $r->txt_name, 'mag_code' => $r->sel_type);
        if (Core::updateTable('rssys.m02', 'cmp_code', $r->txt_id, $update, 'Sub Account')){
            return back();
        }
        return back();
    }
    public function delete(Request $r) // TO DELETE EXISTING SUB MAIN ACCOUNT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $update = array('active' => FALSE);
        if (Core::updateTable('rssys.m02', 'cmp_code', $r->txt_id, $update, 'Sub Account')){
            return back();
        }
        return back();
    }
}
