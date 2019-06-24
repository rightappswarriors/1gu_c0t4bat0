<?php

namespace App\Http\Controllers\MFile\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;

class c_barangay extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "";
        $SQLBrand = "SELECT brgy_id, brgy_name FROM rssys.barangay WHERE active = TRUE";
        $this->brand = Core::sql($SQLBrand);
    }
    public function view() // TO VIEW BARANGAY MODULE
    {
        // $grp = Session::get('grp_ri');
        // if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
        //    return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        // }

        // $fund = Core::getAll("rssys.fund");
        // $m10 = Core::getAll("rssys.m10");
        // $tableToJoin = ['clm'=>'rssys.m04.sl', 'data' => 'Y'];
        // $m04 = Core::getWithPara("rssys.m04", $tableToJoin);
        // $data = array($this->fund);
        
        return view('masterfile.general.masterfile-general_barangay', ['brand' => $this->brand]);
    }

    public function add(Request $r) // TO ADD NEW BARANGAY MODULE
    {
        // $grp = Session::get('grp_ri');
        // if($grp[$this->MOD_CODE]["add"] != 'Y') {
        //    return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        // }

        // return dd($r);
        $data = [
                    'brgy_id' => strtoupper($r->txt_id),
                    'brgy_name' => strtoupper($r->txt_name),
                ];
        // return dd(Core::insertTable('rssys.barangay', $data, 'Brand Name'));
        if (Core::insertTable('rssys.barangay', $data, 'Brand Name'))
        {
        //     Core::updatem99('fid' , Core::get_nextincrementlimitchar($fid->fid, 8));
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING BARANGAY MODULE
    {
        // $grp = Session::get('grp_ri');
        // if($grp[$this->MOD_CODE]["upd"] != 'Y') {
        //    return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        // }


    	$data = [
                    'brgy_name' => strtoupper($r->txt_name),
                ];
    	if (Core::updateTable('rssys.barangay', 'brgy_id', strtoupper($r->txt_id), $data, 'Brand Name'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING BARANGAY MODULE
    {
        // $grp = Session::get('grp_ri');
        // if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
        //    return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        // }

        $data = ['active' => FALSE];
    	if (Core::updateTable('rssys.barangay', 'brgy_id', strtoupper($r->txt_id), $data, 'Brand Name'))
        {
             return back();
        }
        return back();
    }
}
