<?php

namespace App\Http\Controllers\MFile\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use DB;

class c_fpp extends Controller
{
    public function __construct()
    {   
        $this->MOD_CODE = "M1000001";
        $this->m00 = Core::getAll("rssys.ppasubgrp");
        $SQLfpp = "SELECT * FROM rssys.ppasubgrp WHERE active = TRUE";
        $this->ppasubgrp = DB::select($SQLfpp);
    }
    public function view() // TO VIEW FUNCTION MODULE
    {   
        $data = array(DB::table('rssys.ppasubgrp')->where('active',TRUE)->get(), $this->ppasubgrp);
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        return view('masterfile.accounting.masterfile-accounting_fpp', compact('data'));
    }

    public function add(Request $r) // TO ADD NEW MAIN ACCOUNT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }

        if(DB::table('rssys.ppasubgrp')->where('subgrpid',$r->txt_id)->doesntexist()){
            $data = ['subgrpid' => $r->txt_id, 'subgrpdesc' => $r->txt_name, 'seq' => $r->txt_seq, 'active'=>TRUE];
            if (Core::insertTable('rssys.ppasubgrp', $data, 'FPP')) {
                return back();
            }
        } else {
            Core::alert(2,'This ID is already exist!');
        }

        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING MAIN ACCOUNT MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        // return dd($r);
        $update = ['subgrpid' => $r->txt_id, 'subgrpdesc' => $r->txt_name, 'seq' => $r->txt_seq];
        if (Core::updateTable('rssys.ppasubgrp', 'subgrpid', $r->txt_id, $update, 'FPP')) 
        {
            return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING ACCOUNT GROUP MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
       $data = ['active' => FALSE];
        if (Core::updateTable('rssys.ppasubgrp', 'subgrpid', $r->txt_id, $data, 'FPP')) 
        {
            return back();
        }
        return back();
    }
    

}
