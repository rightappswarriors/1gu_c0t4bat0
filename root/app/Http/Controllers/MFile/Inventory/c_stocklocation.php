<?php

namespace App\Http\Controllers\MFile\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;

class c_stocklocation extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M2000006";
        $sqlWhouse = "SELECT * FROM rssys.whouse WHERE active = TRUE";
        $this->whouse = Core::sql($sqlWhouse);
    }
    public function view() // TO VIEW STOCK LOCATION MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        return view('masterfile.inventory.masterfile-inventory_stock_locations', ['whouse' => $this->whouse]);
    }

    public function add(Request $r) // TO ADD NEW STOCK LOCATION MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $whs_code = Core::getm99One('whs_code');
        $data = [
                    'whs_code' => $whs_code->whs_code,
                    'whs_desc' => $r->txt_name,
                    'branch' => '001',
                ];
        // return dd(Core::insertTable('rssys.whouse', $data, 'Stock Location'));
        if (Core::insertTable('rssys.whouse', $data, 'Stock Location'))
        {
            Core::updatem99('whs_code' , Core::get_nextincrementlimitchar($whs_code->whs_code, 3));
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING STOCK LOCATION MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	$data = [
                    'whs_desc' => $r->txt_name,
                    'branch' => '001',
                ];
    	if (Core::updateTable('rssys.whouse', 'whs_code', $r->txt_id, $data, 'Stock Location'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING STOCK LOCATION MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $data=['active'=> false];
    	if (Core::updateTable('rssys.whouse', 'whs_code', $r->txt_id, $data, 'Stock Location'))
        {
             return back();
        }
        return back();
    }
}
