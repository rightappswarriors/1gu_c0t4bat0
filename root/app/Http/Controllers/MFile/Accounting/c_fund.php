<?php

namespace App\Http\Controllers\MFile\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use DB;
use Session;

class c_fund extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M1000001";
        $SQLfund = "SELECT * FROM rssys.fund WHERE active = true";
        $this->fund = DB::select($SQLfund);
        // $this->grp = Core::GetGroupRights();
        // return dd($this->grp);
    }
    public function view() // TO VIEW FUND MODULE
    {
        // $fund = Core::getAll("rssys.fund");
        // $m10 = Core::getAll("rssys.m10");
        // $tableToJoin = ['clm'=>'rssys.m04.sl', 'data' => 'Y'];
        // $m04 = Core::getWithPara("rssys.m04", $tableToJoin);
        $data = array($this->fund);
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        return view('masterfile.accounting.masterfile-accounting_funds', compact('data'));
    }

    public function add(Request $r) // TO ADD NEW FUND
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }

        $fid = Core::getm99One('fid');
        $data = [
                    'fid' => $fid->fid,
                    'fdesc' => $r->txt_name,
                ];
        if (Core::insertTable('rssys.fund', $data, 'Fund'))
        {
            Core::updatem99('fid' , Core::get_nextincrementlimitchar($fid->fid, 8));
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING FUND
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }

    	$data = [
                    'fdesc' => $r->txt_name,
                ];
    	if (Core::updateTable('rssys.fund', 'fid', $r->txt_id, $data, 'Fund'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO DELETE EXISTING FUND
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }

    	$data = [
                    'active' => FALSE,
                ];
        if (Core::updateTable('rssys.fund', 'fid', $r->txt_id, $data, 'Fund'))
        {
             return back();
        }
        return back();
    }
}
