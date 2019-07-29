<?php

namespace App\Http\Controllers\Report\Budget;

use Mail;
use Session;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use FunctionsAccountingControllers;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Storage;

class c_lbp extends Controller {

    public function __lbp(Request $request, $formNumber, $otherDetails = null) {
        if(isset($formNumber) && is_numeric($formNumber)){

        	//configuration of data to return

        	switch ($formNumber) {
        		case 8:
        			if(isset($otherDetails)){
        				$arrToReturn = [];
        				$arrTransType = ['newrevenue','actualcollection','savings','realignment','reversion'];
	        			$rawData = DB::table('rssys.lbp0801')
                                    ->join('rssys.lbp0802','rssys.lbp0801.b_num','rssys.lbp0802.b_num')
                                    ->join('rssys.fund','rssys.lbp0801.fid','rssys.fund.fid')
                                    ->orderBy('rssys.lbp0802.seq_num','ASC')
                                    ->where('rssys.lbp0801.fy',$otherDetails)
                                    ->select('rssys.lbp0802.*', 'rssys.lbp0801.fy', 'rssys.fund.fdesc');
                        $totalSales = $rawData->sum('appro_amnt');
                        $arrDBData = $rawData->get();
	        			if(count($arrDBData) > 0){
	        				foreach ($arrDBData as $key) {
	        					if(in_array($key->form_where, $arrTransType)){
	        						$arrToReturn[$arrTransType[array_search($key->form_where, $arrTransType)]][] = $key;
                                    $arrToReturn[$arrTransType[array_search($key->form_where, $arrTransType)]]['total'] = (isset ($arrToReturn[$arrTransType[array_search($key->form_where, $arrTransType)]]['total']) ? $arrToReturn[$arrTransType[array_search($key->form_where, $arrTransType)]]['total'] + $key->appro_amnt : $key->appro_amnt);
	        					}
	        				}
                            $arrToReturn['otherDetails']['prov'] = 'Guihulngan City';
                            $arrToReturn['otherDetails']['fy'] = $arrDBData[0]->fy;
                            $arrToReturn['otherDetails']['fund'] = $arrDBData[0]->fdesc;
                            $arrToReturn['otherDetails']['total'] = number_format($totalSales,2);
                            // dd($arrToReturn);
                            return view('report.lbp.form_8',$arrToReturn);
	        			}
        			}
        			break;
        		
        		default:
        			return abort(404);
        			break;
        	}
        }
        //kay wala ko kabaw unsay return nila so 404 sa.
        return abort(404);
    }
}
