<?php

namespace App\Http\Controllers\MFile\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use DB;
use Session;

class c_sub_cost_centers extends Controller
{
    //
    public function __construct()
    {
        $this->MOD_CODE = "M2000010";
        $tableToJoin = [['tbl'=>'rssys.m08', 'BLnk' => 'rssys.subctr.cc_code', 'ALnk' => 'rssys.m08.cc_code']];
        $SQLSubctr = "SELECT * FROM rssys.subctr sb LEFT JOIN rssys.m08 m8 ON sb.cc_code = m8.cc_code WHERE sb.active = TRUE ";
        $this->subctr = DB::select($SQLSubctr);
        $this->m08 = Core::getAll("rssys.m08");
    }
    public function view() // TO VIEW SUB COST CENTER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        return view('masterfile.inventory.masterfile-inventory_sub_cost_centers', ['subctr' => $this->subctr, 'm08' => $this->m08]);
    }

    public function add(Request $r) // TO ADD NEW SUB COST CENTER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
        $data = ['scc_code'=> $r->txt_id, 'scc_desc' => $r->txt_name, 'cc_code' => $r->sel_type];
        if (Core::insertTable('rssys.subctr', $data, 'Sub Cost Center'))
        {
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING SUB COST CENTER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
    	$data = ['scc_desc' => $r->txt_name, 'cc_code' => $r->sel_type];
    	if (Core::updateTable('rssys.subctr', 'scc_code', $r->txt_id, $data, 'Sub Cost Center'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING SUB COST CENTER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
    	$data = ['active' => FALSE];
        if (Core::updateTable('rssys.subctr', 'scc_code', $r->txt_id, $data, 'Sub Cost Center'))
        {
             return back();
        }
        return back();
    }
}
