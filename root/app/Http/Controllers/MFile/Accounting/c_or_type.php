<?php

namespace App\Http\Controllers\MFile\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use DB;
use Session;

class c_or_type extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M1000014";
        $SQLOrtypes = "SELECT * FROM rssys.or_types WHERE active = TRUE";
        $this->or_types = DB::select($SQLOrtypes);
    }
    public function view() // TO VIEW OR TYPE MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        // $fund = Core::getAll("rssys.fund");
        // $m10 = Core::getAll("rssys.m10");
        // $tableToJoin = ['clm'=>'rssys.m04.sl', 'data' => 'Y'];
        // $m04 = Core::getWithPara("rssys.m04", $tableToJoin);
        // $data = array($this->fund);
        return view('masterfile.accounting.masterfile-accounting_or_types', ['or_types' => $this->or_types]);
    }

    public function add(Request $r) // TO ADD NEW OR TYPE MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
        $data = [
                    'or_type' => $r->txt_id,
                    'or_code' => $r->txt_name,
                    'suggestiveORto' => $r->suggestive,
                    'hassef' => $r->hassef
                ];
        if (Core::insertTable('rssys.or_types', $data, 'OR Type'))
        {
        //     Core::updatem99('fid' , Core::get_nextincrementlimitchar($fid->fid, 8));
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING OR TYPE MODULE
    {
        $grp = Session::get('grp_ri');
            if($grp[$this->MOD_CODE]["upd"] != 'Y') {
               return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
            }
    	$data = [
                    'or_code' => $r->txt_name,
                    'suggestiveORto' => $r->suggestive,
                    'hassef' => $r->hassef
                ];
    	if (Core::updateTable('rssys.or_types', 'or_type', $r->txt_id, $data, 'OR Type'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING OR TYPE MODULE
    {
        $grp = Session::get('grp_ri');
            if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
               return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
            }
        $data = ['active' => FALSE];
    	if (Core::updateTable('rssys.or_types', 'or_type', $r->txt_id, $data, 'OR Type'))
        {
             return back();
        }
        return back();
    }
}
