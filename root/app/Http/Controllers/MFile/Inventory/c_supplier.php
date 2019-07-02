<?php

namespace App\Http\Controllers\MFile\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use DB;

class c_supplier extends Controller
{
    public function __construct()
    {
        $this->MOD_CODE = "M2000008";
        $sql = "SELECT rssys.m07.c_code, rssys.m07.c_name, rssys.m07.c_addr2, rssys.m07.c_tel, rssys.m07.c_fax, rssys.m07.c_tin, rssys.m07.c_cntc, rssys.m07.at_code, rssys.m07.mp_code, rssys.m04.at_desc, rssys.m10.mp_desc
                FROM rssys.m07
                LEFT JOIN rssys.m04 ON rssys.m07.at_code = rssys.m04.at_code
                LEFT JOIN rssys.m10 ON rssys.m07.mp_code = rssys.m10.mp_code WHERE rssys.m07.active = TRUE";
                // ";
        $this->m07 = Core::sql($sql);
        $this->m10 = Core::sql("SELECT * FROM rssys.m10 WHERE active = TRUE");
        $tableToJoin = ['clm'=>'rssys.m04.sl', 'data' => 'Y'];
        $this->m04 = DB::table(DB::raw("rssys.m04"))->where([['sl', '=' , 'Y'], ['active', '=', TRUE]])->get(); //  Core::getWithPara("rssys.m04", $tableToJoin);
        // $this->m04 = Core::getAll('rssys.m04');
    }
    public function view() // TO VIEW SUPPLIER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
        }
        // return dd($this->m07);
        // $data = array($m07, $m10, $m04);
        return view('masterfile.inventory.masterfile-inventory_supplier', ['m07'=>$this->m07, 'm10'=>$this->m10, 'm04' => $this->m04]);
    }

    public function get() // TO GET SUPPLIER MODULE
    {
       return $data = Core::getAll("rssys.m07");
    }

    public function add(Request $r) // TO ADD NEW SUPPLIER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["add"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $c_code = Core::getm99One('c_code');
        // return dd($r);
        $data = [
                    //'c_code' => $c_code->c_code, *comment by: DAN due to the concern, not auto generate code
                    'c_code' => $r->txt_id,
                    'c_name' => $r->txt_name,
                    'c_addr2' => $r->txt_add,
                    'c_tel' => $r->txt_phn_num,
                    'c_fax' => $r->txt_fax_num,
                    'c_tin' => $r->txt_tin_num,
                    'c_cntc' => $r->txt_cnt_per,
                    'mp_code' => $r->sel_mop,
                    'at_code' => $r->sel_sub_led
                ];
        if (Core::insertTable('rssys.m07', $data, 'Account Creditors'))
        {
            //Core::updatem99('c_code' , Core::get_nextincrementlimitchar($c_code->c_code, 6)); *comment by: DAN due to the concern, not auto generate code
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING SUPPLIER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
    	$data = [
                    'c_name' => $r->txt_name,
                    'c_addr2' => $r->txt_add,
                    'c_tel' => $r->txt_phn_num,
                    'c_fax' => $r->txt_fax_num,
                    'c_tin' => $r->txt_tin_num,
                    'c_cntc' => $r->txt_cnt_per,
                    'mp_code' => $r->sel_mop,
                    'at_code' => $r->sel_sub_led
                ];
    	if (Core::updateTable('rssys.m07', 'c_code', $r->txt_id, $data, 'Account Creditors'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO DELETE EXISTING SUPPLIER MODULE
    {
        $grp = Session::get('grp_ri');
        if($grp[$this->MOD_CODE]["cancel"] != 'Y') {
           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
        }
        $data = ['active' => FALSE];
    	if (Core::updateTable('rssys.m07', 'c_code', $r->txt_id, $data, 'Account Creditors'))
        {
             return back();
        }
        return back();
    }
}
