<?php

namespace App\Http\Controllers\MFile\Miscellaneous;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use DB;


class bankController extends Controller
{


    public function view()
    {
    	$arrRet = [
    		'bank' => DB::table('rssys.bank')->where('active',TRUE)->get()
    	];

        return view('masterfile.miscellaneous.masterfile-miscellaneous-bank',$arrRet);
    }

    public function add(Request $r)
    {
        $data = [
            'b_name' => $r->txt_name,
            'b_code' => $r->txt_id
        ];
        if (Core::insertTable('rssys.bank', $data, 'Bank'))
        {
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING OR TYPE MODULE
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

    public function delete(Request $r) // TO REMOVE EXISTING OR TYPE MODULE
    {
        $data = ['active' => FALSE];
    	if (Core::updateTable('rssys.bank', 'b_code', $r->txt_id, $data, 'Bank'))
        {
             return back();
        }
        return back();
    }

}
