<?php

namespace App\Http\Controllers\MFile\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;

class c_brandname extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M2000001";
        $SQLBrand = "SELECT brd_code, brd_name FROM rssys.brand WHERE active = TRUE";
        $this->brand = Core::sql($SQLBrand);
    }
    public function view() // TO VIEW FUNCTION MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        // $fund = Core::getAll("rssys.fund");
        // $m10 = Core::getAll("rssys.m10");
        // $tableToJoin = ['clm'=>'rssys.m04.sl', 'data' => 'Y'];
        // $m04 = Core::getWithPara("rssys.m04", $tableToJoin);
        // $data = array($this->fund);
        return view('masterfile.inventory.masterfile-inventory_brand_names', ['brand' => $this->brand]);
    }

    public function add(Request $r) // TO ADD NEW FUNCTION MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
        $data = [
                    'brd_code' => $r->txt_id,
                    'brd_name' => $r->txt_name,
                ];
        // return dd(Core::insertTable('rssys.brand', $data, 'Brand Name'));
        if (Core::insertTable('rssys.brand', $data, 'Brand Name'))
        {
        //     Core::updatem99('fid' , Core::get_nextincrementlimitchar($fid->fid, 8));
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
    	$data = [
                    'brd_name' => $r->txt_name,
                ];
    	if (Core::updateTable('rssys.brand', 'brd_code', $r->txt_id, $data, 'Brand Name'))
        {
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
        $data = ['active' => FALSE];
    	if (Core::updateTable('rssys.brand', 'brd_code', $r->txt_id, $data, 'Brand Name'))
        {
             return back();
        }
        return back();
    }
}
