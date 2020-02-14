<?php

namespace App\Http\Controllers\MFile\Collection;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Core;
use Session;

class RPTPenaltiesController extends Controller
{
    //
	public function view(Request $request){
		if($request->isMethod('get')){
			$arrRet = [
				'data' => DB::table('rssys.rptpenalty')->get()
			];
			return view('masterfile.collection.masterfile-collection_RPTPenalty',$arrRet);
		}
	}

	public function add(Request $request)
    {
    	if(isset($request->action)){
    		return json_encode(DB::table('rssys.rptpenalty')->where('rptkey',$request->key)->first());
    	}
    	$data = [
            'year' => $request->year,
            'value' => json_encode($request->m)
        ];

        if (Core::insertTable('rssys.rptpenalty', $data, 'RPT Penalty'))
        {
            return back();
        }
        return back();
    }

    public function update(Request $request)
    {
    	$data = [
            'year' => $request->year,
            'value' => json_encode($request->m)
        ];

        if (Core::updateTable('rssys.rptpenalty', 'rptkey', $request->id , $data, 'RPT Penalty'))
        {
            return back();
        }
        return back();
    }

    public function delete(Request $request){
    	Core::deleteTable('rssys.rptpenalty','rptkey',$request->id,'RPT Penalty');
    	return back();
    }

}
