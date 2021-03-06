<?php

namespace App\Http\Controllers\MFile\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use DB;
use Session;

class c_cost_center extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M1000009";
        $SQLM08 = "SELECT m8.cc_code, m8.cc_desc, m8.active, m8.funcid, f.funcdesc FROM rssys.m08 m8 LEFT JOIN rssys.function f ON m8.funcid = f.funcid WHERE m8.active = 'TRUE'";
        $this->m08 = DB::select($SQLM08);
        $SQLFUNC = "SELECT * FROM rssys.function WHERE active = TRUE";
        $this->func = DB::select($SQLFUNC);
    }
    public function view() // TO VIEW COST CENTER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        // $m08 = Core::getAll("rssys.m08");
        // $data = array($m08);
        return view('masterfile.accounting.masterfile-accounting_cost_centers', ['m08' => $this->m08, 'func' => $this->func]);
    }
    public function add(Request $r) // TO ADD NEW COST CENTER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $data = [
                'cc_code' => $r->txt_id,
                'cc_desc' => $r->txt_name,
                'funcid' => $r->func_type
            ];
        if (Core::insertTable('rssys.m08', $data, 'Cost Center'))
        {
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING COST CENTER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	$data = ['cc_desc' => $r->txt_name, 'funcid' => $r->func_type];
    	if (Core::updateTable('rssys.m08', 'cc_code', $r->txt_id, $data, 'Cost Center'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING COST CENTER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $data = ['active' => FALSE];
        if (Core::updateTable('rssys.m08', 'cc_code', $r->txt_id, $data, 'Cost Center'))
        {
             return back();
        }
        return back();
    }

    public function getupdate($code)
    {
        $SQL = "SELECT * FROM rssys.m08 WHERE cc_code = '".$code."'";
        return DB::select($SQL);
    }
}
