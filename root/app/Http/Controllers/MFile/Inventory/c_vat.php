<?php

namespace App\Http\Controllers\MFile\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;

class c_vat extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M2000011";
        $SQLVat = "SELECT vat_code, vat_desc, vat_type, vat_pct FROM  rssys.vat WHERE active = TRUE ORDER BY vat_desc ASC";
        $this->vat = Core::sql($SQLVat);
    }
    public function view() // TO VIEW VAT CODE MODULE
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
        // return dd($this->vat);
        return view('masterfile.inventory.masterfile-inventory_vat', ['vat' => $this->vat]);
    }

    public function add(Request $r) // TO ADD NEW VAT CODE MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        // return dd($r);
        $data = [
                    'vat_code' => $r->txt_id,
                    'vat_desc' => $r->txt_name,
                    'vat_type' => $r->sel_typ,
                    'vat_pct' => $r->txt_per,

                ];
        // return dd(Core::insertTable('rssys.vat', $data, 'Vat'));
        if (Core::insertTable('rssys.vat', $data, 'Vat'))
        {
        //     Core::updatem99('fid' , Core::get_nextincrementlimitchar($fid->fid, 8));
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING VAT CODE MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
    	$data = [
                    'vat_desc' => $r->txt_name,
                    'vat_type' => $r->sel_typ,
                    'vat_pct' => $r->txt_per,
                ];
    	if (Core::updateTable('rssys.vat', 'vat_code', $r->txt_id, $data, 'Vat'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING VAT CODE MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
    	$data = ['active' => FALSE];
        if (Core::updateTable('rssys.vat', 'vat_code', $r->txt_id, $data, 'Vat'))
        {
             return back();
        }
        return back();
    }
}
