<?php

namespace App\Http\Controllers\MFile\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;

class c_genericname extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M2000002";
        $SQLGeneric = "SELECT gen_code, gen_name FROM rssys.generic WHERE active = TRUE";
        $this->generic = Core::sql($SQLGeneric);
    }
    public function view() // TO VIEW GENERIC NAME MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        return view('masterfile.inventory.masterfile-inventory_generic_names', ['generic' => $this->generic]);
    }

    public function add(Request $r) // TO ADD NEW GENERIC NAME MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
        $data = [
                    'gen_code' => $r->txt_id,
                    'gen_name' => $r->txt_name,
                ];
        // return dd(Core::insertTable('rssys.generic', $data, 'generic Name'));
        if (Core::insertTable('rssys.generic', $data, 'Generic Name'))
        {
        //     Core::updatem99('fid' , Core::get_nextincrementlimitchar($fid->fid, 8));
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING GENERIC NAME MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	$data = [
                    'gen_name' => $r->txt_name,
                ];
    	if (Core::updateTable('rssys.generic', 'gen_code', $r->txt_id, $data, 'Generic Name'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING GENERIC NAME MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	$data = [
                    'active' => FALSE,
                ];
        if (Core::updateTable('rssys.generic', 'gen_code', $r->txt_id, $data, 'Generic Name'))
        {
             return back();
        }
        return back();
    }
}
