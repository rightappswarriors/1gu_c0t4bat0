<?php

namespace App\Http\Controllers\MFile\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use DB;
class c_function extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M1000003";
        $SQLsector = "SELECT * FROM rssys.sector WHERE active = TRUE";
        $this->sector = DB::select($SQLsector);
        // $this->m01 = Core::getAll("rssys.m01");
        $SQLfunction ="SELECT * FROM rssys.function m2 LEFT JOIN rssys.sector m1 ON m2.secid = m1.secid WHERE m2.active = TRUE";
        $this->function = DB::select($SQLfunction);
    }
    public function view() // TO VIEW FUNCTION MODULE
    {   
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
    	$data = array($this->sector, $this->function);
        // return dd($this->function);
    	return view('masterfile.accounting.masterfile-accounting_function' ,compact('data'));
    }

    public function add(Request $r) // TO ADD NEW FUNCTION MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $data = ['funcid' => $r->txt_id, 'funcdesc' => $r->txt_name, 'secid' => $r->sel_type, 'active' => TRUE];
        // return dd(Core::insertTable('rssys.function', $data, 'Function'));
    	if (Core::insertTable('rssys.function', $data, 'Function'))
        {
    		return back();
    	}
    	return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING FUNCTION MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $update = array('funcdesc' => $r->txt_name, 'secid' => $r->sel_type);
        if (Core::updateTable('rssys.function', 'funcid', $r->txt_id, $update, 'Sub Account')){
            return back();
        }
        return back();
    }
    public function delete(Request $r) // TO REMOVE EXISTING FUNCTION MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $update = array('active' => FALSE);
        if (Core::updateTable('rssys.function', 'funcid', $r->txt_id, $update, 'Sub Account')){
            return back();
        }
        return back();
    }
}
