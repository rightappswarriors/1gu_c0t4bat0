<?php

namespace App\Http\Controllers\MFile\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use DB;

class c_main_account extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M1000002";
        $this->m00 = Core::getAll("rssys.m00");
        $tableToJoin = [['tbl'=>'rssys.m00', 'BLnk' => 'rssys.m01.accttype_code', 'ALnk' => 'rssys.m00.code']];
        $SQLM01 = "SELECT * FROM rssys.m01 LEFT JOIN rssys.m00 ON rssys.m01.accttype_code = rssys.m00.code WHERE rssys.m01.active = TRUE";
        $this->m01 = DB::select($SQLM01);
    }
    public function view() // TO VIEW MAIN ACCOUNT MODULE
    {
    	$data = array($this->m00, $this->m01);
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
    	return view('masterfile.accounting.masterfile-accounting_main_account', compact(['data']));
    }

    // Modified add function - Mhel Jan 09, 2019
    public function add(Request $r) // TO ADD NEW MAIN ACCOUNT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }

        $data = ['mag_code' => $r->txt_id, 'mag_desc' => strtoupper($r->txt_name), 'accttype_code' => $r->sel_type];
    	if (Core::insertTable('rssys.m01', $data, 'Main Account')) {
            return back();
        }

    	return back();
    }
    
    // Created Update function - Mhel Jan 09, 2019
    public function update(Request $r) // TO UPDATE EXISTING MAIN ACCOUNT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
        $update = ['mag_desc' => $r->txt_name, 'accttype_code' => $r->sel_type];
        // return dd(Core::updateTable('rssys.m01', 'mag_code', $r->txt_id, $update, 'Main Account'));
        if (Core::updateTable('rssys.m01', 'mag_code', $r->txt_id, $update, 'Main Account')) {
            return back();
        }
        return back();
    }

     // Created Update function - Mhel Jan 09, 2019
    public function delete(Request $r) // TO DELETE EXISTING MAIN ACCOUNT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
        $update = ['active' => FALSE];
        // return dd(Core::updateTable('rssys.m01', 'mag_code', $r->txt_id, $update, 'Main Account'));
        if (Core::updateTable('rssys.m01', 'mag_code', $r->txt_id, $update, 'Main Account')) {
            return back();
        }
        return back();
    }
}
