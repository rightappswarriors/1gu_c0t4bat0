<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use Carbon\Carbon;
class c_users extends Controller
{
	public function __construct()
    {

    	$sql = "SELECT a.*,b.* FROM rssys.x08 a LEFT JOIN rssys.x07 b ON a.grp_id = b.grp_id WHERE a.grp_id <> '001'";
        $this->users = Core::sql($sql);
        $sql2 = "SELECT * FROM rssys.x07 WHERE grp_id <>'001' ";
        $this->x07 = Core::sql($sql2);
        $sql3 = "SELECT cc_code, cc_desc FROM rssys.m08 WHERE active = TRUE";
        $this->m08 = Core::sql($sql3);
        // $this->
    }
    public function view() // TO VIEW USERS MODULE
    {
    	// return dd($this->m08);
        return view('setting.setting_user', ['users' => $this->users, 'group_rights' => $this->x07, 'offices' => $this->m08]);
    	// return view('report.budget.report_budget_saob', ['fund'=> $this->fund, 'x03' => $this->x03, 'sector' => $this->sector, 'budget_period' => $this->budget_period]);
    }
    public function add(Request $r) // TO ADD NEW USER MODULE
    {
        // return dd($r->all());
        $data = [
                    'uid' => strtoupper($r->txt_id),
                    'opr_name' => $r->txt_name,
                    'pwd' => $r->txt_pass1,
                    'grp_id' => $r->txt_grp,
                    'cc_code' => $r->txt_office,
                ];
        // return dd(Core::insertTable('rssys.x08', $data, 'User'));
        if (Core::insertTable('rssys.x08', $data, 'User'))
        {
        //     Core::updatem99('fid' , Core::get_nextincrementlimitchar($fid->fid, 8));
            return back();
        }
        return back();
    }
    public function update(Request $r) // TO UPDATE EXISTING USER MODULE
    {
        // return dd($r->all());
        $data = [
                    'opr_name' => $r->txt_name,
                    'pwd' => $r->txt_pass1,
                    'grp_id' => $r->txt_grp,
                    'cc_code' => $r->txt_office,
                ];
        if (Core::updateTable('rssys.x08', 'uid', $r->txt_id, $data, 'User'))
        {
             return back();
        }
        return back();
    }
}