<?php

namespace App\Http\Controllers\MFile\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use DB;
use Session;

class c_sector extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M1000014";
        $SQLSectors = "SELECT * FROM rssys.sector WHERE active = TRUE";
        $this->sectors = DB::select($SQLSectors);
    }
    public function view() // TO VIEW SECTOR MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
       // return dd($this->sectors);
        return view('masterfile.accounting.masterfile-accounting_sectors', ['sectors' => $this->sectors]);
    }

    public function add(Request $r) // TO ADD NEW SECTOR MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
        $data = [
                    'secid' => $r->txt_id,
                    'secdesc' => $r->txt_name,
                ];
        if (Core::insertTable('rssys.sector', $data, 'Sector'))
        {
        //     Core::updatem99('fid' , Core::get_nextincrementlimitchar($fid->fid, 8));
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING SECTOR MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	$data = [
                    'secdesc' => $r->txt_name,
                ];
    	if (Core::updateTable('rssys.sector', 'secid', $r->txt_id, $data, 'Sector'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO DELETE EXISTING SECTOR MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $data = ['active' => FALSE];
    	if (Core::updateTable('rssys.sector', 'secid', $r->txt_id, $data, 'Sector'))
        {
             return back();
        }
        return back();
    }
}
