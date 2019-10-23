<?php

namespace App\Http\Controllers\Collection;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use DB;
use Session;

class c_tax_type extends Controller
{

    public function view()
    {
    	$arrRet = [
    		'tax_group' => DB::table('rssys.tax_group')->where('active',TRUE)->get(),
            'tax_type' => DB::table('rssys.tax_type')
            ->join('rssys.tax_group','tax_group.tax_id','tax_type.tax_id')
            ->join('rssys.or_types','or_types.or_code','tax_type.or_code')
            ->where([['tax_type.active',TRUE]])->get(),
            'or_types' => DB::table('rssys.or_types')->where('active',TRUE)->get(),
    	];
        return view('masterfile.collection.masterfile-collection_tax_type',$arrRet);
    }

    public function add(Request $r)
    {
        $data = [
            'tax_code' => $r->txt_code,
            'taxtype_desc' => $r->txt_name,
            'tax_id' => $r->tax_grp,
            'or_code' => $r->txt_taxtype_id
        ];
        if (Core::insertTable('rssys.tax_type', $data, 'Tax Type'))
        {
            return back();
        }
        return back();
    }

    public function update(Request $r) // TO UPDATE EXISTING OR TYPE MODULE
    {
    	$data = [
            'tax_code' => $r->txt_code,
            'taxtype_desc' => $r->txt_name,
            'tax_id' => $r->tax_grp,
            'or_code' => $r->txt_taxtype_id
        ];
    	if (Core::updateTable('rssys.tax_type', 'taxtype_id', $r->txt_id, $data, 'Tax Type'))
        {
             return back();
        }
        return back();
    }

    public function delete(Request $r) // TO REMOVE EXISTING OR TYPE MODULE
    {
        $data = ['active' => FALSE];
    	if (Core::updateTable('rssys.tax_type', 'taxtype_id', $r->txt_id, $data, 'Tax Type'))
        {
             return back();
        }
        return back();
    }
}
