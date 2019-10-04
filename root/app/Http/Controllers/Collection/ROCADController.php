<?php

namespace App\Http\Controllers\Collection;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Core;
use DB;

class ROCADController extends Controller
{

    private $currentDate;

    public function __construct(){  
        $this->currentDate = Date('Y-m-d');
    }
    //
    public function view(){
    	$arrRet = [
            'collectors'=>DB::select("SELECT DISTINCT x08.opr_name, x08.uid from rssys.or_issuance left join rssys.x08 on x08.uid = or_issuance.collector where t_date = '$this->currentDate' AND transid NOT IN (SELECT transid from rssys.or_issued where t_date = '$this->currentDate')"),
            '_bc'=>[
                    ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                    ['link'=>url("collection/ROCAD/"),'desc'=>'ROCAD','icon'=>'file-text','st'=>true]
                ],
            '_ch'=>"ROCAD"
        ];
    	return view('collection.ROCADview',$arrRet);
    }


    public function viewOR(Request $request, $uid){
    	if(DB::select("SELECT count(*) as counted from rssys.or_issuance left join rssys.x08 on x08.uid = or_issuance.collector where (t_date = '$this->currentDate' AND or_issuance.collector = '$uid' AND transid NOT IN (SELECT transid from rssys.or_issued where t_date = '$this->currentDate')) ")[0]->counted <= 0){
    		return abort(404);
    	}
    	if($request->isMethod('get')){
    	
	    	$arrRet = [
	    		'or_issued' => DB::select("SELECT transid, opr_name, or_code, or_no, or_no_to from rssys.or_issuance join rssys.x08 on x08.uid = or_issuance.collector join rssys.or_types on or_types.or_type = or_issuance.or_type where (t_date = '$this->currentDate' AND or_issuance.collector = '$uid' AND transid NOT IN (SELECT transid from rssys.or_issued where t_date = '$this->currentDate') ) "),
	    		'_ch'=>"OR Issued"
	    	];
	    	return view('collection.ROCADor',$arrRet);

    	}
    	if($request->isMethod('post')){
            try {
                 $toAddArr = [];
                if(count($request->amount) == count($request->transid) && count($request->transid) == count($request->or_to)){

                    for ($i=0; $i < count($request->amount); $i++) { 
                        array_push($toAddArr, ['transid' => $request->transid[$i], 'or_to' => $request->or_to[$i], 'amount' => str_replace( ',', '', $request->amount[$i] ), 't_date' => Date('Y-m-d'), 't_time' => Date('H:i:s')]);
                    }
                    if(DB::table('rssys.or_issued')->insert($toAddArr)){
                        return 'done';
                    }

                } else {
                    return 'Please check other fields for possible unanswered inputs';
                }
            } 
            catch (Exception $e) {
                return $e;           
            }
    	}

    }

    public function viewLiquidate(Request $request){
        $arrRet = [
            'collectors'=>DB::select("SELECT DISTINCT x08.opr_name, x08.uid FROM rssys.or_issued left join rssys.or_issuance on or_issued.transid = or_issuance.transid left join rssys.x08 on or_issuance.collector = x08.uid where or_issued.t_date = '$this->currentDate' AND or_issuance.collector not in (SELECT collector from rssys.liquidate where date = '$this->currentDate')"),
            '_bc'=>[
                    ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                    ['link'=>url("collection/Liquidating-officer"),'desc'=>'Liquidating Officer','icon'=>'file-text','st'=>true]
                ],
            '_ch'=>"Liquidate"
        ];
        return view('collection.liquidate',$arrRet);
    }

    public function liquidate(Request $request, $uid){
        if(DB::select("SELECT count(*) as counted from rssys.or_issuance left join rssys.x08 on x08.uid = or_issuance.collector where (t_date = '$this->currentDate' AND or_issuance.collector = '$uid' AND transid IN (SELECT transid from rssys.or_issued where t_date = '$this->currentDate')) ")[0]->counted <= 0){
            return abort(404);
        }

        if($request->isMethod('get')){
        
            $arrRet = [
                'det' => DB::select("SELECT sum(or_issued.amount::float) as total, x08.opr_name from rssys.or_issued left join rssys.or_issuance on or_issued.transid = or_issuance.transid left join rssys.x08 on x08.uid = or_issuance.collector where (or_issued.t_date = '$this->currentDate' AND rssys.or_issuance.collector = '$uid') group by opr_name"),
                '_ch'=>"Liquidate"
            ];
            return view('collection.liquidateUser',$arrRet);

        }
        if($request->isMethod('post')){
            try {
                if (Core::insertTable('rssys.liquidate', ['date' => $this->currentDate, 'time' => Date('H:i:s'), 'liquidatingofficer' => session()->get('_user')['id'], 'amountreceive' => str_replace( ',', '', $request->amount ), 'collector' => $uid], 'Liquidation'))
                {
                    return redirect('collection/Liquidating-officer');
                }
            } 
            catch (Exception $e) {
                return $e;           
            }
        }
    }

    public function viewToDiposit(Request $request){
        $arrRet = [
            'collectors'=>DB::select("SELECT x08.opr_name,liquidate.liquidateid from rssys.liquidate left join rssys.x08 on x08.uid = liquidate.collector where liquidateid NOT IN (SELECT liquidateid from rssys.deposittobank)"),
            '_bc'=>[
                    ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                    ['link'=>url("collection/Liquidating-officer"),'desc'=>'Liquidating Officer','icon'=>'file-text','st'=>true]
                ],
            '_ch'=>"Deposit to bank"
        ];
        return view('collection.readytodeposit',$arrRet);
    }

    public function deposittobank(Request $request, $liquidateid){
        if(DB::select("SELECT count(*) as counted from rssys.deposittobank where liquidateid = '$liquidateid'")[0]->counted >= 1 || DB::select("SELECT count(*) as counted from rssys.liquidate where liquidateid = '$liquidateid'")[0]->counted <= 0){
            return abort(404);
        }

        $data = DB::select("SELECT x08.uid, x08.opr_name, liquidate.amountreceive from rssys.liquidate left join rssys.x08 on x08.uid = liquidate.collector where liquidateid = '$liquidateid' AND liquidateid not in (SELECT liquidateid from rssys.deposittobank)");

        if($request->isMethod('get')){
        
            $arrRet = [
                'banks' => DB::table('rssys.bank')->select('b_code','b_name')->where('active',TRUE)->get(),
                'det' => $data,
                '_ch'=>"Liquidate"
            ];
            return view('collection.toDeposit',$arrRet);

        }
        if($request->isMethod('post')){
            try {
                if (Core::insertTable('rssys.deposittobank', ['b_code' => $request->bank, 'accountnumber' => $request->acct, 'collector' => $data[0]->uid ,'t_date' => $this->currentDate, 't_time' => Date('H:i:s'), 'uid' => session()->get('_user')['id'], 'amount' => str_replace( ',', '', $request->amount ), 'depositdate' => Date('Y-m-d',strtotime($request->dateDep)) , 'deposittime' => Date('H:i:s',strtotime($request->timeDep)), 'liquidateid' => $liquidateid], 'Deposit to bank'))
                {
                    return redirect('collection/Bank-Deposit');
                }
            } 
            catch (Exception $e) {
                return $e;           
            }
        }
    }



}