<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use DB;
use Carbon\Carbon;
class c_groups extends Controller
{
	public function __construct()
    {

    	$sql = "SELECT grp_id, grp_desc FROM rssys.x07 WHERE grp_id <> '001'";
        $this->x07 = Core::sql($sql);
    }
    public function view() // TO VIEW GROUP MODULE
    {
         // return dd($this->x07);
        // ['users' => $this->users, 'group_rights' => $this->x07]
        return view('setting.setting_group_rights_groups', ['group_rights' => $this->x07]);
    	// return view('report.budget.report_budget_saob', ['fund'=> $this->fund, 'x03' => $this->x03, 'sector' => $this->sector, 'budget_period' => $this->budget_period]);
    }
    public function add(Request $r) // TO ADD NEW GROUP MODULE
    {
        // return dd($r->all());
        $data = [
                    'grp_id' => $r->txt_id,
                    'grp_desc' => strtoupper($r->txt_name)
                ];
        // return dd(Core::insertTable('rssys.x07', $data, 'Group'));
        if (Core::insertTable('rssys.x07', $data, 'Group'))
        {
            DB::insert("INSERT INTO rssys.x06 (grp_id, mod_id, restrict, add, upd, cancel, print)
                                SELECT COALESCE(?), mod_id, COALESCE('Y'), COALESCE('Y'), COALESCE('Y'), COALESCE('Y'), COALESCE('Y')
                                FROM rssys.x05", [$r->txt_id]);
        //     $data = DB::table('rssys.x07')->get();
        //     if($data)
        //     {
        //         for ($i=0; $i < count($data) ; $i++) 
        //         {
        //           try {
        //               DB::table('rssys.x06')->insert(['grp_id' => $data[$i]->grp_id, 'mod_id' => $r->txt_id, 'restrict' => 'Y', 'add' => 'Y', 'upd' => 'Y', 'cancel' => 'Y', 'print' => 'Y']);
        //           } catch (Exception $e) {
        //               return $e->getMessage();
        //           }
        //         }
        //     }
        //     return back();
        }
        return back();
    }
    public function update(Request $r) // TO UPDATE EXISTING GROUP MODULE
    { 
        // return dd($r->all());
        $data = [
                    'grp_id' => $r->txt_id,
                    'grp_desc' => strtoupper($r->txt_name)
                ];
        if (Core::updateTable('rssys.x07', 'grp_id', $r->txt_id, $data, 'Group'))
        {
             return back();
        }
        return back();
    }
    public function delete(Request $r)
    {

    }
    public function getAll(Request $r)
    {
        // return $r->all();
        if($r->mod_lvl == '1'){
            return DB::table(DB::raw('rssys.x05'))->where('level', $r->mod_lvl)->get();
        } else if($r->mod_lvl == '2'){
            // return $r->all();
            return DB::table(DB::raw('rssys.x05'))->where([['level', $r->mod_lvl], ['plevel1', $r->lvl_1]])->get();
        } else if($r->mod_lvl == '3'){
            return DB::table(DB::raw('rssys.x05'))->where([['level', $r->mod_lvl], ['plevel2', $r->lvl_2]])->get();
        }
    }
}