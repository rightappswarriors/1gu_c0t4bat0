<?php

namespace App\Http\Controllers\Collection;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use DB;

class c_tax_group extends Controller
{

    public function view()
    {
    	$arrRet = [
    		'tax_group' => DB::table('rssys.tax_group')->where('active',TRUE)->get()
    	];

        return view('masterfile.collection.masterfile-collection_tax_group',$arrRet);
    }

    public function add(Request $r)
    {
        $data = [
            'tax_desc' => $r->txt_name
        ];
        if (Core::insertTable('rssys.tax_group', $data, 'Tax Group'))
        {
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING OR TYPE MODULE
    {
    	$data = [
                    'tax_desc' => $r->txt_name,
                ];
    	if (Core::updateTable('rssys.tax_group', 'tax_id', $r->txt_id, $data, 'Tax Group'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING OR TYPE MODULE
    {
        $data = ['active' => FALSE];
    	if (Core::updateTable('rssys.tax_group', 'tax_id', $r->txt_id, $data, 'Tax Group'))
        {
             return back();
        }
        return back();
    }
}
