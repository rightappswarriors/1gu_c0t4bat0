<?php

namespace App\Http\Controllers\MFile\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
class c_modeofpayment extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M2000007";
        $sqlM10 = "SELECT m1.mp_code, m1.mp_desc, m1.mp_days, m1.at_code, m4.at_desc
                   FROM rssys.m10 m1 LEFT JOIN rssys.m04 m4 ON m1.at_code = m4.at_code WHERE m1.active = TRUE
                   ORDER BY m1.mp_desc ASC";
        $this->m10 = Core::sql($sqlM10);
        $sqlM04 = "SELECT at_code, at_desc FROM rssys.m04 WHERE rssys.m04.active = TRUE ORDER BY rssys.m04.at_desc ASC";
        $this->m04 = Core::sql($sqlM04);
    }
    public function view() // TO VIEW MODE OF PAYMENT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        // return dd($this->m10);
        return view('masterfile.inventory.masterfile-inventory_mode_of_payment', ['m10' => $this->m10, 'm04' => $this->m04]);
    }

    public function add(Request $r) // TO ADD NEW MODE OF PAYMENT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
        $data = [
                    'mp_code' => $r->txt_id,
                    'mp_desc' => $r->txt_name,
                    'mp_days' => $r->txt_days,
                    'at_code' => $r->sel_acct,
                ];
        // return dd(Core::insertTable('rssys.m10', $data, 'Mode of Payment'));
        if (Core::insertTable('rssys.m10', $data, 'Mode of Payment'))
        {
        //     Core::updatem99('fid' , Core::get_nextincrementlimitchar($fid->fid, 8));
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING MODE OF PAYMENT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	$data = [
                    // 'mp_code' => $r->txt_id,
                    'mp_desc' => $r->txt_name,
                    'mp_days' => $r->txt_days,
                    'at_code' => $r->sel_acct,
                ];
    	if (Core::updateTable('rssys.m10', 'mp_code', $r->txt_id, $data, 'Mode of Payment'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING MODE OF PAYMENT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $data = ['active' => FALSE];
    	if (Core::updateTable('rssys.m10', 'mp_code', $r->txt_id, $data, 'Mode of Payment'))
        {
             return back();
        }
        return back();
    }
}
