<?php

namespace App\Http\Controllers\MFile\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;

class c_itemunit extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M2000004";
        $SQLitmunit = "SELECT unit_id, unit_shortcode, unit_desc FROM  rssys.itmunit WHERE active = TRUE";
        $this->itmunit = Core::sql($SQLitmunit);
    }
    public function view() // TO VIEW ITEM UNIT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        // $fund = Core::getAll("rssys.fund");
        // $m10 = Core::getAll("rssys.m10");
        // $tableToJoin = ['clm'=>'rssys.m04.sl', 'data' => 'Y'];
        // $m04 = Core::getWithPara("rssys.m04", $tableToJoin);
        // $data = array($this->itmunit);
        // return dd($this->itmunit);
        return view('masterfile.inventory.masterfile-inventory_item_units', ['itmunit' => $this->itmunit]);
    }

    public function add(Request $r) // TO ADD NEW ITEM UNIT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
        $data = [
                    'unit_id' => $r->txt_id,
                    'unit_shortcode' => $r->txt_shrt,
                    'unit_desc' => $r->txt_name,
                ];
        // return dd(Core::insertTable('rssys.itmunit', $data, 'Item Unit'));
        if (Core::insertTable('rssys.itmunit', $data, 'Item Unit'))
        {
        //     Core::updatem99('fid' , Core::get_nextincrementlimitchar($fid->fid, 8));
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING ITEM UNIT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	$data = [
                    // 'unit_id' => $r->txt_id,
                    'unit_shortcode' => $r->txt_shrt,
                    'unit_desc' => $r->txt_name,
                ];
    	if (Core::updateTable('rssys.itmunit', 'unit_id', $r->txt_id, $data, 'Item Unit'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING ITEM UNIT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	$data = [
                    'active' => FALSE,
                ];
        if (Core::updateTable('rssys.itmunit', 'unit_id', $r->txt_id, $data, 'Item Unit'))
        {
             return back();
        }
        return back();
    }
}
