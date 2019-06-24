<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use DB;
use Carbon\Carbon;
class c_modules extends Controller
{
	public function __construct()
    {

    	$sql1 = "SELECT cc_code, cc_desc FROM rssys.m08 WHERE active = TRUE";
        $this->m08 = Core::sql($sql1);
        $sql2 = "SELECT uid, opr_name FROM rssys.x08 WHERE grp_id <> '001'";
        $this->x08 = Core::sql($sql2);
    }
    public function view() // TO VIEW MODULE MODULE
    {
    	// return dd($this->x08);
        // ['users' => $this->users, 'group_rights' => $this->x07]
        return view('setting.setting_group_rights_modules', ['office' => $this->m08, 'users' => $this->x08]);
    	// return view('report.budget.report_budget_saob', ['fund'=> $this->fund, 'x03' => $this->x03, 'sector' => $this->sector, 'budget_period' => $this->budget_period]);
    }
    public function add(Request $r) // TO ADD NEW MODULE MODULE
    {
        // return dd($r->all());
        $data = [
                    'mod_id' => $r->txt_id,
                    'grp_desc' => $r->txt_name,
                    'path' => $r->txt_path,
                    'level' => $r->txt_level,
                    'plevel1' => ($r->txt_level == '2' || $r->txt_level == '3') ?  $r->txt_level_1 : null,
                    'plevel2' => ($r->txt_level == '3') ?  $r->txt_level_2 : null,
                    'cc_code' =>  (isset($r->txt_office) ? json_encode($r->txt_office) : null),
                    'uid' => (isset($r->txt_uid) ? json_encode($r->txt_uid) : null),
                ];
        // return dd(Core::insertTable('rssys.x08', $data, 'User'));
        if (Core::insertTable('rssys.x05', $data, 'Module'))
        {
            $data = DB::table('rssys.x07')->get();
            if($data)
            {
                for ($i=0; $i < count($data) ; $i++) 
                {
                  try {
                      DB::table('rssys.x06')->insert(['grp_id' => $data[$i]->grp_id, 'mod_id' => $r->txt_id, 'restrict' => 'Y', 'add' => 'Y', 'upd' => 'Y', 'cancel' => 'Y', 'print' => 'Y']);
                  } catch (Exception $e) {
                      return $e->getMessage();
                  }
                }
            }
            return back();
        }
        return back();
    } 
    public function update(Request $r) // TO UPDATE EXISTING MODULE MODULE
    {
        // return dd($r->all());
        $data = [
                    // 'mod_id' => $r->txt_id,
                    'grp_desc' => $r->txt_name,
                    'path' => $r->txt_path,
                    'level' => $r->txt_level,
                    'plevel1' => ($r->txt_level == '2' || $r->txt_level == '3') ?  $r->txt_level_1 : null,
                    'plevel2' => ($r->txt_level == '3') ?  $r->txt_level_2 : null,
                    'cc_code' => (isset($r->txt_office) ? json_encode($r->txt_office) : null),
                    'uid' => (isset($r->txt_uid) ? json_encode($r->txt_uid) : null),
                ];
        if (Core::updateTable('rssys.x05', 'mod_id', $r->txt_id, $data, 'Module'))
        {
             return back();
        }
        return back();
    }
    // public function delete(Request $r)
    // {

    // }
    public function getAll(Request $r) // GET ALL MODULEs MODULE
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