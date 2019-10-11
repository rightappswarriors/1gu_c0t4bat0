<?php

namespace App\Http\Controllers\Collection;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use DB;

class c_real_class extends Controller
{

    public function view()
    {
    	$arrRet = [
    		'rp_class' => DB::table('rssys.rp_class')->where('active',TRUE)->get()
    	];

        return view('masterfile.collection.masterfile-collection_rp_class',$arrRet);
    }

    public function add(Request $r)
    {
        $data = [
            'rp_desc' => $r->txt_name
        ];
        if (Core::insertTable('rssys.rp_class', $data, 'Real Type Classification'))
        {
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING OR TYPE MODULE
    {
    	$data = [
                    'rp_desc' => $r->txt_name,
                ];
    	if (Core::updateTable('rssys.rp_class', 'rpid', $r->txt_id, $data, 'Real Type Classification'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING OR TYPE MODULE
    {
        $data = ['active' => FALSE];
    	if (Core::updateTable('rssys.rp_class', 'rpid', $r->txt_id, $data, 'Real Type Classification'))
        {
             return back();
        }
        return back();
    }
}
