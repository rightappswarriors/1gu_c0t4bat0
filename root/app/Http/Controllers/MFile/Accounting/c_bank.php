<?php

namespace App\Http\Controllers\MFile\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;

class c_bank extends Controller
{
    public function __construct()
    {
        $SQLBank = "SELECT b_code, b_name FROM rssys.bank WHERE active = TRUE";
        $this->bank = Core::sql($SQLBank);
    }
    public function view()
    {

        return view('masterfile.accounting.masterfile-accounting_banks', ['bank' => $this->bank]);
    }

    public function add(Request $r)
    {
        // return dd($r);
        $data = [
                    'b_code' => strtoupper($r->txt_id),
                    'b_name' => $r->txt_name,
                ];
        // return dd(Core::insertTable('rssys.bank', $data, 'Bank'));
        if (Core::insertTable('rssys.bank', $data, 'Bank'))
        {
        //     Core::updatem99('fid' , Core::get_nextincrementlimitchar($fid->fid, 8));
            return back();
        }
        return back();
    }

    public function update(Request $r)
    {
    	$data = [
                    'b_name' => $r->txt_name,
                ];
    	if (Core::updateTable('rssys.bank', 'b_code', $r->txt_id, $data, 'Bank'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r)
    {
    	$data = [
                    'active' => FALSE,
                ];
        if (Core::updateTable('rssys.bank', 'b_code', $r->txt_id, $data, 'Bank'))
        {
             return back();
        }
        return back();
    }
}
