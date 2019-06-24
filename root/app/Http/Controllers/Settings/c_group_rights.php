<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use DB;
use Session;
use Carbon\Carbon;
class c_group_rights extends Controller
{
	public function __construct()
    {
        $this->MOD_CODE = "S1000000";
        $this->trylangHehe = 'qwe';
    	// $sql = "SELECT a.*,b.* FROM rssys.x08 a LEFT JOIN rssys.x07 b ON a.grp_id = b.grp_id WHERE a.grp_id <> '001'";
        //    $this->users = Core::sql($sql);
        $sql2 = "SELECT * FROM rssys.x07";
        $this->x07 = Core::sql($sql2);
        // $this->
    }
    public function view() // TO VIEW GROUP RIGHTS MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
    	// return dd($this->x07);
        // ['users' => $this->users, 'group_rights' => $this->x07]
        return view('setting.setting_group_rights', ['group_rights' => $this->x07]);
    	// return view('report.budget.report_budget_saob', ['fund'=> $this->fund, 'x03' => $this->x03, 'sector' => $this->sector, 'budget_period' => $this->budget_period]);
    }
    public function edit($mod_id) // TO VIEW EXISTING GROUP RIGHTS MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        $data = DB::table('rssys.x06')
                                ->join('rssys.x05', 'rssys.x06.mod_id','=','rssys.x05.mod_id')
                                // ->join('rssys.x07', 'rssys.x06.grp_id', '=', 'rssys.x07.grp_id')'rssys.x07.*'
                                ->select('rssys.x06.*', 'rssys.x05.*')
                                ->distinct('mod_id')
                                ->where('rssys.x06.grp_id', '=', $mod_id)
                                ->orderBy('pla', 'ASC')
                                ->get();
                if ($data) {
                    for ($i=0; $i < count($data); $i++) 
                    { 
                        $temp = DB::table('rssys.x05')->where([['level', '=', '2'], ['plevel1', '=', $data[$i]->mod_id]])->get();
                        $data[$i]->hasLevel2 = (count($temp) != 0 ? 1 : null);

                        $temp = DB::table('rssys.x05')->where([['level', '=', '3'], ['plevel2', '=', $data[$i]->mod_id]])->get();
                        $data[$i]->hasLevel3 = (count($temp) != 0 ? 1 : null);
                    }
                }
        $data1 = DB::table('rssys.x07')->select('grp_id', 'grp_desc')->where('rssys.x07.grp_id', '=', $mod_id)->first();
        // return dd($data);
        return view('setting.setting_group_rights_new', ['gr_ri' => $data, 'grp' => $data1, 'mod_id' => $mod_id]);
    }
    // public function add(Request $r)
    // {
    //     // return dd($r->all());
    //     $data = [
    //                 'uid' => $r->txt_id,
    //                 'opr_name' => $r->txt_name,
    //                 'pwd' => $r->txt_pass1,
    //                 'grp_id' => $r->txt_grp
    //             ];
    //     // return dd(Core::insertTable('rssys.x08', $data, 'User'));
    //     if (Core::insertTable('rssys.x08', $data, 'User'))
    //     {
    //     //     Core::updatem99('fid' , Core::get_nextincrementlimitchar($fid->fid, 8));
    //         return back();
    //     }
    //     return back();
    // }
    public function update(Request $r) // TO UPDATE EXISTING GROUP RIGHTS MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        // return dd($r->all());
        for ($i=0; $i < count($r->mod); $i++) {
           $data = [
                'restrict' => isset($r->alw["'".$r->mod[$i]."'"]) ? 'Y' : 'N',
                'add' => isset($r->add["'".$r->mod[$i]."'"]) ? 'Y' : 'N',
                'upd' => isset($r->upd["'".$r->mod[$i]."'"]) ? 'Y' : 'N',
                'cancel' => isset($r->del["'".$r->mod[$i]."'"]) ? 'Y' : 'N',
                'print' => isset($r->prt["'".$r->mod[$i]."'"]) ? 'Y' : 'N',
            ];
           try {
               DB::table('rssys.x06')->where([['grp_id', $r->grp_id], ['mod_id', $r->mod[$i]]])->update($data);
           } catch (Exception $e) {
               return back;
           }
        }
        Core::alert(1, 'Successfully Modified Group Rights');
        return redirect('settings/group-rights');

    }
}