<?php

namespace App\Http\Controllers\Collection;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use Carbon\Carbon;

class c_bank_deposit extends Controller
{
    public function __construct()
    {
        $SQLBank = "SELECT b_code, b_name FROM rssys.bank";
        $this->bank = Core::sql($SQLBank);
        $SQLBankDep = "SELECT bd.bd_id, bd.bd_date, bd.b_code, b.b_name, bd.acc_num, bd.acc_name, bd.ref_num, bd.amount FROM rssys.bank_dep bd
            LEFT JOIN rssys.bank b ON bd.b_code = b.b_code";
        $this->bank_dep = Core::sql($SQLBankDep);
        if (count($this->bank_dep) > 0) {
                for ($i=0; $i < count($this->bank_dep); $i++)
                {
                    $this->bank_dep[$i]->bd_date_desc = Core::DateString($this->bank_dep[$i]->bd_date);
                }
            }
    }
    public function view()
    {
        // $fund = Core::getAll("rssys.fund");
        // $m10 = Core::getAll("rssys.m10");
        // $tableToJoin = ['clm'=>'rssys.m04.sl', 'data' => 'Y'];
        // $m04 = Core::getWithPara("rssys.m04", $tableToJoin);
        // $data = array($this->fund);
        // return dd($this->bank_dep);
        return view('collection.collection_bank_deposit', ['bank' => $this->bank, 'bank_dep' => $this->bank_dep]);
    }

    public function add(Request $r)
    {
        // return dd($r->all());
        $b_id = Core::getm99One('bd_id');
        // return dd($b_id);
        $dt = Carbon::now();
        $data = [
                    'bd_id' => $b_id->bd_id,
                    'bd_date' => $r->txt_date,
                    'b_code' => $r->txt_bnk,
                    'acc_num' => $r->txt_acct_num,
                    'acc_name' => $r->txt_acct_num_name,
                    'ref_num' => $r->txt_ref,
                    'amount' => floatval($r->txt_amt),
                    't_date' => $dt->toDateString(),
                    't_time' => $dt->toTimeString(),
                    'ip_add' => request()->ip(),
                    'user_id' =>strtoupper(Session::get('_user')['id']),
                ];
        if (Core::insertTable('rssys.bank_dep', $data, 'Bank Deposit'))
        {
            Core::updatem99('bd_id' , Core::get_nextincrementlimitchar($b_id->bd_id, 8));
            return back();
        }
        return back();
    }

    public function update(Request $r)
    {
        $data = [
                    'bd_id' => $r->txt_id,
                    'bd_date' => $r->txt_date,
                    'b_code' => $r->txt_bnk,
                    'acc_num' => $r->txt_acct_num,
                    'acc_name' => $r->txt_acct_num_name,
                    'ref_num' => $r->txt_ref,
                    'amount' => floatval($r->txt_amt),
                    // 't_date' => $dt->toDateString(),
                    // 't_time' => $dt->toTimeString(),
                    // 'ip_add' => request()->ip(),
                    // 'user_id' =>strtoupper(Session::get('_user')['id']),
                ];
        if (Core::updateTable('rssys.bank_dep', 'bd_id', $r->txt_id, $data, 'Bank Deposit'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r)
    {
        // $data = ['active' => FALSE];
        // if (Core::updateTable('rssys.fund', 'fid', $r->txt_id, $data, 'Fund'))
        // {
        //      return back();
        // }
        // return back();
        if (Core::deleteTable('rssys.bank_dep', 'bd_id', $r->txt_id, 'Bank Deposit')) {
            return back();
        }
        return back();
    }
}
