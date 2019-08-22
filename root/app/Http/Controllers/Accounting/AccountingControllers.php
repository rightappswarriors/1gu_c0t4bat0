<?php

namespace App\Http\Controllers\Accounting;

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
use Core;
use Excel;
use OfficeExport;

class AccountingControllers extends Controller {
    public function __disbursement() {
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return redirect($retArr[0])->with($retArr[1], $retArr[2]);
        }
        $arrRet = [
            'disbType'=>DB::select("SELECT m5.j_code, m5.j_desc FROM rssys.m05 m5 WHERE m5.j_type='D'"),
            '_bc'=>[
                    ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                    ['link'=>url("accounting/disbursement"),'desc'=>'Disbursement Entry','icon'=>'file-text','st'=>true]
                ],
            '_ch'=>"Disbursement Entry"
        ];
        return view('accounting.disbursement', $arrRet);
    }
    public function __disbursementnew(Request $request, $j_code) {
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return redirect($retArr[0])->with($retArr[1], $retArr[2]);
        }
        $arrRet = [
            'disbType'=>DB::select("SELECT m5.j_code, m5.j_desc FROM rssys.m05 m5 WHERE m5.j_type='D' AND m5.j_code = '$j_code'"),
            'mop'=>DB::select("SELECT * FROM rssys.m04 WHERE payment = 'Y' AND dr_cr = 'C' ORDER BY at_desc ASC"),
            'pom'=>DB::select("SELECT * FROM rssys.m04 WHERE payment != 'Y' AND dr_cr = 'D' ORDER BY at_desc ASC"),
            'cc_code'=>DB::select("SELECT * FROM rssys.m08"),
            'collection'=>FunctionsAccountingControllers::getAllOBR(true),
            '_bc'=>[
                ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                ['link'=>url("accounting/disbursement/disbursement_new"),'desc'=>'New Disbursement Entry','icon'=>'file-text','st'=>true]
            ],
            '_ch'=>"Disbursement Entry"
        ];
        return view('accounting.disbursement_new', $arrRet);
    }
    public function __disbursementedit($j_code, $j_num) {
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return redirect($retArr[0])->with($retArr[1], $retArr[2]);
        }
        $arrRet = [
            'dbAll'=>FunctionsAccountingControllers::getDisbursementData([['j_code', $j_code], ['j_num', $j_num]]),
            'disbType'=>DB::select("SELECT m5.j_code, m5.j_desc FROM rssys.m05 m5 WHERE m5.j_type='D' AND m5.j_code = '$j_code'"),
            'mop'=>DB::select("SELECT * FROM rssys.m04 WHERE payment = 'Y' AND dr_cr = 'C' ORDER BY at_desc ASC"),
            'pom'=>DB::select("SELECT * FROM rssys.m04 WHERE payment != 'Y' AND dr_cr = 'D' ORDER BY at_desc ASC"),
            'cc_code'=>DB::select("SELECT * FROM rssys.m08"),
            'collection'=>FunctionsAccountingControllers::getAllOBR(true),
            '_bc'=>[
                ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                ['link'=>url("accounting/disbursement/disbursement_new"),'desc'=>'New Disbursement Entry','icon'=>'file-text','st'=>true]
            ],
            '_ch'=>"Disbursement Entry"
        ];
        // dd(FunctionsAccountingControllers::getDisbursementData([['j_code', $j_code], ['j_num', $j_num]]));
        return view('accounting.disbursement_new', $arrRet);
    }
    public function __obligation_request() {
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return redirect($retArr[0])->with($retArr[1], $retArr[2]);
        }
        $arrRet = [
            'collection'=>FunctionsAccountingControllers::getAllOBR(),
            '_bc'=>[
                    ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                    ['link'=>url("accounting/collection/obligation_request"),'desc'=>'Obligation Request','icon'=>'file-text','st'=>true]
                ],
            '_ch'=>"Obligation Entry"
        ];
        return view('accounting.obligation_request', $arrRet);
    }


    public function _obligation_admin (Request $request){
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return redirect($retArr[0])->with($retArr[1], $retArr[2]);
        }
        if($request->isMethod('get')){
            $arrRet = [
                'ppe'=>FunctionsAccountingControllers::getAllFrom(['rssys.ppasubgrp',[['active',TRUE]],['subgrpid','subgrpdesc']]),
                'funds'=>FunctionsAccountingControllers::getAllFrom(['rssys.fund',[['active',TRUE]]]),
                'cc_code'=>FunctionsAccountingControllers::getAllFrom(['rssys.m08',[['active',TRUE]],['cc_code','cc_desc']]),
                'data' => DB::select('select t_date,rssys.obrhdr.obr_code,payee,obrhdr.particulars,obr_pk from rssys.obrhdr inner join rssys.obrlne on rssys.obrhdr.obr_pk = rssys.obrlne.obr_code::integer inner join rssys.m08 on rssys.m08.cc_code = rssys.obrhdr.cc_code where (rssys.obrhdr.active = TRUE and rssys.m08.active = TRUE) order by obr_pk desc'),
                '_bc'=>[
                        ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false]
                    ],
                '_ch'=>"Admin Obligation Entry"
            ];
            return view('accounting.obligation_request', $arrRet);
        } else if($request->isMethod('post')){
            if(!empty(trim($request->subgrpid))){
                $extraDataForSecFun = DB::table('rssys.m08')->join('rssys.function','rssys.function.funcid','rssys.m08.funcid')->where([['m08.active',TRUE],['m08.cc_code',$request->subgrpid],['function.active',TRUE]])->first();
                }
                $arrFields = [
                    'obr_code' => $request->obr,
                    'payee' => $request->payee,
                    't_date' => Carbon::now()->toDateString(),
                    'particulars' => $request->particulars,
                    'user_id' => strtoupper(FunctionsAccountingControllers::getSession("_user", "id")),
                    // 'fpp' => $request->fpp,
                    'cc_code' => $request->subgrpid,
                    'fid' => $request->fund,
                    'secid' => ($extraDataForSecFun->secid ?? null),
                    'funcid' => ($extraDataForSecFun->funcid ?? null),
                    'active' => TRUE
                ];
                switch ($request->action) {
                   
                    case 'add':
                        if(DB::table('rssys.obrhdr')->insert($arrFields)){
                            return back();
                        } else {
                            return 'Unknown Error Occured. Please try to refresh page then click yes';
                        }
                        break;
                    case 'edit':
                        if(DB::table('rssys.obrhdr')->where('obr_pk',$request->obr)->update($arrFields)){
                            return back();
                        } else {
                            return 'Unknown Error Occured. Please try to refresh page then click yes';
                        }
                        break;
                    case 'delete':
                        if(DB::table('rssys.obrhdr')->where('obr_pk',$request->deleteobr)->update(['active' => FALSE])){
                            return back();
                        } else {
                            return 'Unknown Error Occured. Please try to refresh page then click yes';
                        }
                        break;
                    
                    default:
                        # code...
                        break;
                }
            
        }

    }


    public function _obligation_admin_operation (Request $request,$action,$obr_pk = null){
        $retArr = FunctionsAccountingControllers::checkSession(true);
        $obrlne = $obrhdr = null;
        $shouldCheck = false;
        switch (strtolower($action)) {
            case 'edit':
                if(isset($obr_pk)){
                    $shouldCheck = true;
                    $action = 'edit';
                }
                break;
            
            default:
                $shouldCheck = false;
                $action = 'add';
                break;
        }
        if($shouldCheck){
            if(count($retArr) > 0 || DB::table('rssys.obrhdr')->where([['obr_pk',$obr_pk],['active',TRUE]])->doesntExist()) {
                return abort(404);
            }

            $obrlne = DB::table('rssys.obrlne')->join('rssys.bgtps02','rssys.obrlne.at_code','rssys.bgtps02.at_code')->where([['rssys.obrlne.active',TRUE],['rssys.obrlne.obr_code',$obr_pk],['at_desc','<>',null]])->select('bgtps02.at_code','bgtps02.at_desc','rssys.obrlne.oid as id', 'rssys.obrlne.*')->distinct()->first();
            $obrhdr = json_encode( DB::select('select rssys.obrhdr.* from rssys.obrhdr inner join rssys.obrlne on rssys.obrhdr.obr_pk = rssys.obrlne.obr_code::integer inner join rssys.m08 on rssys.m08.cc_code = rssys.obrhdr.cc_code where (rssys.obrhdr.active = TRUE and rssys.m08.active = TRUE) order by obr_pk desc'));

        }
        if($request->isMethod('get')){
            $arrRet = [
                'ppe'=>FunctionsAccountingControllers::getAllFrom(['rssys.ppasubgrp',[['active',TRUE]],['subgrpid','subgrpdesc']]),
                'bgtps02'=>FunctionsAccountingControllers::getAllFrom(['rssys.bgtps02',[['at_desc','<>',null]],['at_code','at_desc'],true]),
                'cc_code'=>FunctionsAccountingControllers::getAllFrom(['rssys.m08',[['active',TRUE]],['cc_code','cc_desc']]),
                'obrhdr'=> $obrhdr,
                'data' => $obrlne,
                '_bc'=>[
                        ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false]
                    ],
                '_ch'=>"Admin Obligation Entry",
                // 'funds'=>FunctionsAccountingControllers::getAllFrom(['rssys.fund',[['active',TRUE]]]),
                'action' => $action
            ];
            return view('accounting.obligation_request_entry', $arrRet);
        } else if($request->isMethod('post')){
            switch (strtolower($request->action)) {
                case 'getobrlne':
                    return json_encode($obrlne);
                    break;

                case 'getobrhdr':
                    return $obrhdr;
                    break;

                case 'get-at_code':
                    $toReturn = [];
                    $getBasicFilter = DB::table('rssys.m08')->join('rssys.function','rssys.function.funcid','rssys.m08.funcid')->where([['m08.active',TRUE],['function.active',TRUE],['cc_code',$request->cc_code]])->select('cc_code','secid','function.funcid')->distinct()->first();
                    if(isset($getBasicFilter)){
                        $data = DB::table('rssys.bgtps01')->join('rssys.bgtps02','rssys.bgtps01.b_num','rssys.bgtps02.b_num')->where([['cc_code',$getBasicFilter->cc_code],['secid',$getBasicFilter->secid],['funcid',$getBasicFilter->funcid]])->select('at_code','at_desc')->get();
                        if(isset($data)){
                            foreach($data as $d){
                                $toReturn['results'][] = ['id' => $d->at_code,'text' => $d->at_desc];
                            }
                        }
                    }

                    return json_encode($toReturn);
                    break;


                case 'add':

                case 'edit':
                    if(isset($request->at_code) && isset($request->fpp) && isset($request->amount) && count($request->at_code) == count($request->fpp) && count($request->fpp) == count($request->amount) && isset($request->at_code)){
                        $extraData = [DB::table('rssys.m08')->join('rssys.function','rssys.function.funcid','rssys.m08.funcid')->where([['m08.active',TRUE],['m08.cc_code',$request->subgrpid],['function.active',TRUE]])->first(),DB::table('rssys.bgtps02')->join('rssys.bgtps01','rssys.bgtps01.b_num','rssys.bgtps01.b_num')->where('rssys.bgtps02.at_code',$request->at_code)->select('rssys.bgtps01.fid')->first()];
                        $arrObrhdrFields = [
                            'obr_code' => $request->obr,
                            'payee' => $request->payee,
                            't_date' => Carbon::now()->toDateString(),
                            'particulars' => $request->particulars,
                            'user_id' => strtoupper(FunctionsAccountingControllers::getSession("_user", "id")),
                            'cc_code' => $request->subgrpid,
                            'fid' => ($extraData[1]->fid ?? null),
                            'secid' => ($extraData[0]->secid ?? null),
                            'funcid' => ($extraData[0]->funcid ?? null),
                            'active' => TRUE
                        ];
                        $module = 'RAO Report Entry';
                        if($action == 'edit'){
                            $del = [['obr_code', '=', $obr_pk]];
                            Core::deleteTableMultiWhere('rssys.obrlne', $del, $module);
                            $flagForSubmit = Core::updateTable('rssys.obrhdr', 'obr_pk', $obr_pk, $arrObrhdrFields, $module);
                        } else if($action == 'add'){
                            $flagForSubmit = Core::insertTableGetlastId('rssys.obrhdr',$arrObrhdrFields);
                        }
                        if ($flagForSubmit){
                            for ($i=0; $i < count($request->at_code); $i++) { 
                                $seqnum = (!empty(DB::table('rssys.obrlne')->max('seq_num')) ? DB::table('rssys.obrlne')->max('seq_num') + 1 : 1 );
                                $arrObrlneFields = [
                                    'obr_code' => ($action == 'edit' ? $obr_pk : $flagForSubmit),
                                    'seq_num' => $seqnum,
                                    'at_code' => $request->at_code[$i],
                                    'amount' => str_replace(',', '', $request->amount[$i]),
                                    'fpp' => $request->fpp[$i],
                                    'active' => TRUE
                                ];

                                if (Core::insertTable('rssys.obrlne', $arrObrlneFields, null)) 
                                {
                                    $flag = 'true';
                                } 
                                else 
                                {
                                    return 'false';
                                }
                            }
                        }
                        else
                        {
                            $flag = 'false';
                        }
                        return $flag;

                    } else {
                        return 'Please check data for possible empty entries!';
                    }
                    break;
                
                default:
                    
                    break;
            }


        }

    }


    public function generateRaoReport($fpp = null,$cc_code = null, $date = null){
        if(isset($fpp) && isset($cc_code) && isset($date)){
            if(count(DB::SELECT("select * from rssys.obrhdr inner join rssys.obrlne on rssys.obrlne.obr_code::integer = rssys.obrhdr.obr_pk inner join rssys.ppasubgrp on rssys.ppasubgrp.subgrpid = rssys.obrlne.fpp inner join rssys.m08 on rssys.m08.cc_code = rssys.obrhdr.cc_code where (rssys.obrlne.fpp = '$fpp' and rssys.m08.cc_code = '$cc_code' and rssys.obrhdr.active = TRUE and rssys.obrlne.active = TRUE)"))){

                $arrID = $arr_atCode = $arrToReturn = $at_desc = $arr_bgtps = array();
                $runningRowSum = $runningColSum = $bgtps02 = 0.00;
                

                // $dataFromDB = DB::table('rssys.obrhdr')->join('rssys.obrlne','rssys.obrlne.obr_code','rssys.obrhdr.obr_code')->join('rssys.ppasubgrp','rssys.ppasubgrp.subgrpid','rssys.obrlne.fpp')->join('rssys.m04','rssys.m04.at_code','rssys.obrlne.at_code')->join('rssys.m08','rssys.m08.cc_code','rssys.obrhdr.cc_code')->where([['rssys.obrhdr.cc_code',$cc_code],['rssys.obrhdr.active',TRUE],['rssys.obrlne.active',TRUE],['m04.active',TRUE],['m08.active',TRUE],['ppasubgrp.active',TRUE]])->select('rssys.obrhdr.obr_pk','rssys.obrhdr.t_date','rssys.obrhdr.obr_code','rssys.obrhdr.particulars','rssys.obrlne.at_code','rssys.obrlne.amount','rssys.obrhdr.obr_code','m04.at_desc','m08.cc_desc','ppasubgrp.subgrpdesc')->orderBy('rssys.obrhdr.t_date','ASC')->distinct()->tosql();
                $dataFromDB = DB::select("select distinct rssys.obrhdr.obr_pk, rssys.obrhdr.t_date, rssys.obrhdr.obr_code, rssys.obrhdr.particulars, rssys.obrlne.at_code, rssys.obrlne.amount, rssys.obrhdr.obr_code, m04.at_desc, m08.cc_desc, ppasubgrp.subgrpdesc from rssys.obrhdr inner join rssys.obrlne on rssys.obrlne.obr_code::integer = rssys.obrhdr.obr_pk inner join rssys.ppasubgrp on rssys.ppasubgrp.subgrpid = rssys.obrlne.fpp inner join rssys.m04 on rssys.m04.at_code = rssys.obrlne.at_code inner join rssys.m08 on rssys.m08.cc_code = rssys.obrhdr.cc_code where (rssys.obrhdr.cc_code = '$cc_code' and rssys.obrhdr.active = TRUE and rssys.obrlne.active = TRUE and m04.active = TRUE and m08.active = TRUE and ppasubgrp.active = TRUE and date_part('year',rssys.obrhdr.t_date) = '$date') order by rssys.obrhdr.t_date asc");
                if(isset($dataFromDB)){
                    foreach ($dataFromDB as $key) {
                        if(!array_key_exists($key->at_code, $arr_bgtps)){
                            $arr_bgtps[$key->at_code] = [(DB::table('rssys.bgtps02')->where('rssys.bgtps02.at_code',$key->at_code)->sum('appro_amnt') ?? 0.00),$key->at_desc,$key->at_code];
                        }

                        $arrToReturn[$key->t_date][] = $key;
                    }
                }

                $arrRet = [
                    'cc_code' => $cc_code,
                    'data'=> $dataFromDB,
                    'headerDet' => $arr_bgtps,
                    'obrlne' => $arrToReturn
                ];
                return Excel::download(new OfficeExport('officeReport.raoreport',$arrRet), 'RAO-Report-'.$fpp.'-'.$cc_code.'-'.$date.'.xlsx');

                return view('accounting.raoreport', $arrRet);


            }
            return abort(404);
        } else {
            $subgrpid = $cc_code = $t_date = [];
            $query = DB::SELECT('select ppasubgrp.subgrpid, obrhdr.cc_code, obrhdr.t_date from rssys.obrhdr inner join rssys.obrlne on rssys.obrlne.obr_code::integer = rssys.obrhdr.obr_pk inner join rssys.ppasubgrp on rssys.ppasubgrp.subgrpid = rssys.obrlne.fpp inner join rssys.m08 on rssys.m08.cc_code = rssys.obrhdr.cc_code');
            if(isset($query)){
                foreach($query as $key => $val){
                    if(!in_array($val->subgrpid, $subgrpid)){
                        array_push($subgrpid, $val->subgrpid);
                    }
                    if(!in_array($val->cc_code, $cc_code)){
                        array_push($cc_code, $val->cc_code);
                    }
                    if(!in_array(Date('Y',strtotime($val->t_date)), $t_date)){
                        array_push($t_date, Date('Y',strtotime($val->t_date)));
                    }
                }
            }
            $arrRet = [
                'dataAll' => [$subgrpid,$cc_code,$t_date]
            ];
            return view('accounting.raopicker',$arrRet);
        }
    }


    public function __obr_new(Request $request) {
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return redirect($retArr[0])->with($retArr[1], $retArr[2]);
        }
        $arrRet = [
            'pom'=>DB::select("SELECT * FROM rssys.m04 WHERE payment != 'Y' AND dr_cr = 'D' ORDER BY at_desc ASC"),
            'allot'=>FunctionsAccountingControllers::getAllAllotment(),
            'cc_data'=>DB::table(DB::raw('rssys.m08'))->get(),
            '_bc'=>[
                    ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                    ['link'=>url("accounting/collection/obr_new"),'desc'=>'Obligation Request','icon'=>'file-text','st'=>true]
                ],
            '_ch'=>"Obligation Entry"
        ];
        // dd($arrRet);
        return view('accounting.obr_new', $arrRet);
    }
    public function __obr_view($obr_code) {
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return redirect($retArr[0])->with($retArr[1], $retArr[2]);
        }
        $arrRet = [
            'obr'=>FunctionsAccountingControllers::getAllOBR(false, [['obr_code', $obr_code]]),
            'pom'=>DB::select("SELECT * FROM rssys.m04 WHERE payment != 'Y' AND dr_cr = 'D' ORDER BY at_desc ASC"),
            'allot'=>FunctionsAccountingControllers::getAllAllotment([['obr_code', $obr_code]]),
            'cc_data'=>DB::table(DB::raw('rssys.m08'))->get(),
            '_bc'=>[
                    ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                    ['link'=>url("accounting/collection/".$obr_code.""),'desc'=>'Obligation Request','icon'=>'file-text','st'=>true]
                ],
            '_ch'=>"Obligation Entry"
        ];
        return view('accounting.obr_new', $arrRet);
    }
    public function __obr_edit($obr_code) {
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return redirect($retArr[0])->with($retArr[1], $retArr[2]);
        }
        $arrRet = [
            'obrEdit'=>FunctionsAccountingControllers::getAllOBR(false, [['obr_code', $obr_code]]),
            'pom'=>DB::select("SELECT * FROM rssys.m04 WHERE payment != 'Y' AND dr_cr = 'D' ORDER BY at_desc ASC"),
            'allot'=>FunctionsAccountingControllers::getAllAllotment(), // [['obr_code', $obr_code]]
            'cc_data'=>DB::table(DB::raw('rssys.m08'))->get(),
            '_bc'=>[
                    ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                    ['link'=>url("accounting/collection/".$obr_code.""),'desc'=>'Obligation Request','icon'=>'file-text','st'=>true]
                ],
            '_ch'=>"Obligation Entry"
        ];
        // dd($obr_code);
        return view('accounting.obr_new', $arrRet);
    }
    public function __check_issuance() {
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return redirect($retArr[0])->with($retArr[1], $retArr[2]);
        }
        $arrRet = [
            'tr01_check'=>FunctionsAccountingControllers::getAllCheck(),
            '_bc'=>[
                    ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                    ['link'=>url("accounting/disbursement/check_issuance"),'desc'=>'Check Issuance','icon'=>'file-text','st'=>true]
                ],
            '_ch'=>"Check Issuance"
        ];
        return view('accounting.check_issuance', $arrRet);
    }
    public function __check_issuance_new() {
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return redirect($retArr[0])->with($retArr[1], $retArr[2]);
        }
        $arrRet = [
            'tr01'=>FunctionsAccountingControllers::getDisbursementData([], ['j_code', ['CDJ', 'CV', 'CV2']]),
            '_bc'=>[
                    ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                    ['link'=>url("accounting/disbursement/check_issuance"),'desc'=>'Check Issuance','icon'=>'file-text','st'=>true]
                ],
            '_ch'=>"Check Issuance"
        ];
        // dd($arrRet);
        return view('accounting.check_issuance_new', $arrRet);
    }
    public function __saob($all) {
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return redirect($retArr[0])->with($retArr[1], $retArr[2]);
        }
        $data = explode('_', $all);
        // $sector = ((count($data) > 0) ? $data[0] : "");
        $funds = ((count($data) > 0) ? $data[0] : "");
        $budget = ((count($data) > 1) ? $data[1] : "");
        $mo_from = ((count($data) > 2) ? $data[2] : "");
        $mo_to = ((count($data) > 3) ? $data[3] : "");
        $allData = FunctionsAccountingControllers::getAllApproAllotOblig($funds, $budget, $mo_from, $mo_to);
        // return $allData;
        // Mhel Start
        // $date = Carbon::createFromDate($budget, 1, 1);
        // $endOfYear   = $date->copy()->endOfYear();
        // $dt = Carbon::parse($endOfYear)->format('F d, Y');
        // return $dt;
        // Mhel End
        // $secData = "SELECT _all.* FROM rssys.sector INNER JOIN ($allData) _all ON _all.secid = sector.secid WHERE sector.secid = '$sector' ORDER BY secdesc";
        $arrRet = [
            // 'AsOfDate' => $dt ,
            'saob'=>DB::select(FunctionsAccountingControllers::getSAOBReport($funds, $budget, $mo_from, $mo_to)),
            // 'sector'=>DB::select("SELECT DISTINCT secdesc FROM rssys.sector WHERE secid = '$sector' ORDER BY secdesc"),
            // 'm08'=>DB::select("SELECT DISTINCT cc_desc FROM rssys.m08 INNER JOIN ($secData) _all ON _all.cc_code = m08.cc_code ORDER BY cc_desc"),
            // 'ppasubgrp'=>DB::select("SELECT DISTINCT subgrpdesc FROM rssys.ppasubgrp INNER JOIN ($secData) _all ON _all.grpid = ppasubgrp.subgrpid ORDER BY subgrpdesc"),
            // 'm04'=>DB::select("SELECT DISTINCT at_desc FROM rssys.m04 INNER JOIN ($secData) _all ON _all.at_code = m04.at_code ORDER BY at_desc"),
            'b_period'=>[$budget, $mo_to],
            // 'b_period'=>DB::table(DB::raw('rssys.budget_period'))->where([['budget_code', $budget]])->first(),
            '_bc'=>[
                    ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                    ['link'=>url("reports/budget/saob"),'desc'=>'SAOB Report','icon'=>'file-text','st'=>true]
                ],
            '_ch'=>"SAOB Report"
        ];
        // dd($arrRet);
        return view('report.budget.sampletiti', $arrRet);
    }
    public function __check_release() {
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return redirect($retArr[0])->with($retArr[1], $retArr[2]);
        }
        $arrRet = [
            'tr01_check'=>FunctionsAccountingControllers::getAllCheck(),
            'isrelease'=>true,
            '_bc'=>[
                    ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                    ['link'=>url("accounting/disbursement/check_issuance"),'desc'=>'Check Issuance','icon'=>'file-text','st'=>true]
                ],
            '_ch'=>"Check Issuance"
        ];
        return view('accounting.check_issuance', $arrRet);
    }
    public function __obr_issuance() {
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return redirect($retArr[0])->with($retArr[1], $retArr[2]);
        }
        $arrRet = [
            'or_issuance'=>DB::select("SELECT or_issuance.*, or_types.or_code, x08.opr_name FROM rssys.or_issuance LEFT JOIN rssys.or_types ON or_issuance.or_type = or_types.or_type LEFT JOIN rssys.x08 ON x08.uid = or_issuance.collector"),
            'isrelease'=>true,
            'cashiers'=>DB::select("SELECT uid, opr_name FROM rssys.x08 WHERE rssys.x08.grp_id = '005'"),
            '_bc'=>[
                    ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                    ['link'=>url("accounting/collection/or_issuance"),'desc'=>'Issuance OR','icon'=>'file-text','st'=>true]
                ],
            '_ch'=>"Issuance OR"
        ];
        return view('accounting.issuance_or', $arrRet);
    }
    public function __obr_issuancenew(Request $request) {
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return redirect($retArr[0])->with($retArr[1], $retArr[2]);
        }
        $message = "";
        if($request->isMethod('post')) {
            // dd($request->all());
            $arrData = ['or_type', 'date_issued', 'or_no', 'or_no_to', 'collector'];
            $validate = [['or_type', 'or_no', 'or_no_to', 'collector'], ['or_type'=>'No type selected', 'or_no'=>'No OR No. (From) specified', 'or_no_to'=>'No OR No. (To) specified', 'collector'=>'No collector specified']];
            $makeHash = []; $haveAdd = ['t_date'=>Carbon::now()->toDateString(), 't_time'=>Carbon::now()->toTimeString(), 'user_id'=>strtoupper(FunctionsAccountingControllers::getSession("_user", "id"))]; $arrCheck = []; $sMail = [];
            $tbl = 'rssys.or_issuance';
            $returnThis = FunctionsAccountingControllers::fInsData($request->all(), $arrData, $arrCheck, $makeHash, $haveAdd, $sMail, $validate, $tbl);
            if($returnThis != true) {
                $message = $returnThis;
            } else {
                $message = "Successfully inserted data.";
            }
        }
        $arrRet = [
            'or_types'=>DB::table(DB::raw('rssys.or_types'))->get(),
            'isrelease'=>true,
            'cashiers'=>DB::select("SELECT uid, opr_name FROM rssys.x08 WHERE rssys.x08.grp_id = '005'"),
            '_bc'=>[
                ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                ['link'=>url("accounting/collection/or_issuance"),'desc'=>'Issuance OR','icon'=>'file-text','st'=>true]
            ],
            '_ch'=>"Issuance OR",
            'message'=>$message
        ];
        return view('accounting.issuance_or_new', $arrRet);
    }
    public function __obr_issuanceedit(Request $request, $transid) {
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return redirect($retArr[0])->with($retArr[1], $retArr[2]);
        }
        $message = "";
        if($request->isMethod('post')) {
            $arrData = ['or_type', 'date_issued', 'or_no', 'or_no_to', 'collector'];
            $validate = [['or_type', 'or_no', 'or_no_to', 'collector'], ['or_type'=>'No type selected', 'or_no'=>'No OR No. (From) specified', 'or_no_to'=>'No OR No. (To) specified', 'collector'=>'No collector specified']];
            $makeHash = []; $haveAdd = ['t_date'=>Carbon::now()->toDateString(), 't_time'=>Carbon::now()->toTimeString(), 'user_id'=>strtoupper(FunctionsAccountingControllers::getSession("_user", "id"))]; $arrCheck = []; $sMail = [];
            $tbl = 'rssys.or_issuance';
            // dd([$request->all(), $arrData]);
            $returnThis = FunctionsAccountingControllers::fUpdData($request->all(), $arrData, $arrCheck, $makeHash, $haveAdd, $sMail, $validate, $tbl, [['transid', $transid]]);
            if($returnThis != true) {
                $message = $returnThis;
            } else {
                $message = "Successfully inserted data.";
            }
        }
        $arrRet = [
            'or_issuance'=>DB::select("SELECT or_issuance.*, or_types.or_code, x08.opr_name FROM rssys.or_issuance LEFT JOIN rssys.or_types ON or_issuance.or_type = or_types.or_type LEFT JOIN rssys.x08 ON x08.uid = or_issuance.collector WHERE transid = '$transid'"),
            'or_types'=>DB::table(DB::raw('rssys.or_types'))->get(),
            'isrelease'=>true,
            'cashiers'=>DB::select("SELECT uid, opr_name FROM rssys.x08 WHERE rssys.x08.grp_id = '005'"),
            '_bc'=>[
                ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                ['link'=>url("accounting/collection/or_issuance"),'desc'=>'Issuance OR','icon'=>'file-text','st'=>true]
            ],
            '_ch'=>"Issuance OR",
            'message'=>$message
        ];
        return view('accounting.issuance_or_new', $arrRet);
    }

    public function __customQuery(Request $request, $customQuery) {
        $retArr = FunctionsAccountingControllers::checkSession(true);
        if(count($retArr) > 0) {
            return [];
        }
        if($request->isMethod('get')) {
            switch($customQuery) {
                case 'asdf':
                    return [];
                    break;
            }
        } else {
            switch($customQuery) {
                case 'getDisbursementRecords':
                    $jname = ((isset($request->jname)) ? $request->jname : "");
                    return json_encode(FunctionsAccountingControllers::getAllDisbursement($jname));
                    break;
                case 'getCollectionRecords':
                    $retArr = []; if(isset($request->obr_code)) { $retArr = FunctionsAccountingControllers::CollectionLinesWithTotal(['obr_code', $request->obr_code]); }
                    return json_encode($retArr); //getAllOBRLines
                    break;
                case 'getAllotLines':
                    $retArr = [];
                    if(isset($request->b_num) || isset($request->at_code)) {
                        $where = []; $where1 = [];
                        if(isset($request->b_num)) { array_push($where, ['b_num', $request->b_num]); array_push($where1, ['b_num', $request->b_num]); }
                        if(isset($request->at_code)) { array_push($where, ['at_code', $request->at_code]); }
                        $retArr = FunctionsAccountingControllers::getAllAllotmentLines($where); $obrLines = FunctionsAccountingControllers::getAllOBR(false, $where1);
                        foreach($retArr AS $retArrEach) { if(count($obrLines) > 0) { foreach($obrLines AS $obrLinesEach) { if(count($obrLinesEach[1]) > 0) { foreach($obrLinesEach[1] AS $obrLinesEachEach) {
                            if($retArrEach->seq_num == $obrLinesEachEach->seq_num && $retArrEach->at_code == $obrLinesEachEach->at_code) {
                                $retArrEach->allot_amnt1 = number_format((floatval($retArrEach->allot_amnt) - floatval($obrLinesEachEach->debit)), 2, '.', '');
                            }
                        } } } } }
                    }
                    return json_encode($retArr);
                    break;
                case 'insDisbursement':
                    $newStd = new \stdClass; $asdf = 'j_num'; $newStd->$asdf = $request->j_num;
                    $j_tbl = (($request->j_num != "") ? [$newStd] : DB::table(DB::raw('rssys.m05'))->where([['j_code', $request->j_code]])->get());
                    
                    if(count($j_tbl) > 0) {
                        $seq_num = 0;
                        $arrData = [['j_code', 't_desc', 'payee', 'empid', 'cc_code', 'obr_code'], ['j_code', 'at_code'], ['j_code', 'at_code', 'credit']]; //
                        $validate = [[['j_code', 'payee'], ['j_code'=>'No code specified', 'payee'=>'No payee specified']], [['j_code', 'at_code', 'debit'], ['j_code'=>'No code specified', 'at_code'=>'No accounting selected', 'debit'=>'No amount specified']], [['j_code', 'at_code', 'credit'], ['j_code'=>'No code specified', 'at_code'=>'No accounting selected', 'credit'=>'No amount specified']]]; //
                        $makeHash = [[], [], []]; //
                        $haveAdd = [['fy'=>date('Y'), 'mo'=>date('m'), 'j_num'=>$j_tbl[0]->j_num, 't_date'=>Carbon::now()->toDateString(), 'user_id'=>strtoupper(FunctionsAccountingControllers::getSession("_user", "id"))], ['j_num'=>$j_tbl[0]->j_num, 'seq_num'=>0, 'debit'=>0, 'credit'=>0], ['j_num'=>$j_tbl[0]->j_num, 'seq_num'=>0, 'seq_desc'=>'Disburesement#'.$j_tbl[0]->j_num, 'debit'=>0]]; //
                        $sMail = [[], [], []]; //
                        $arrCheck = [[], [], []]; //
                        $tbl = ['rssys.tr01', 'rssys.tr02', 'rssys.tr02']; //
                        $numCount = [1, ((isset($request->debit)) ? count($request->debit) : 0), 1]; //
                        $stat = [];
                        for($i = 0; $i < count($tbl); $i++) { DB::table(DB::raw($tbl[$i]))->where([['j_code', $request->j_code], ['j_num', $j_tbl[0]->j_num]])->delete(); for($j = 0; $j < $numCount[$i]; $j++) { if($i > 0) { if(isset($haveAdd[$i]['seq_num'])) { $seq_num++; $haveAdd[$i]['seq_num'] = $seq_num; } }
                            $arrSend = (($i == 1) ? ['j_code'=>$request->j_code, 'at_code'=>$request->at_code[$j]] : (($i == 2) ? ['j_code'=>$request->j_code, 'at_code'=>$request->at_code1, 'credit'=>$request->credit] : $request->all()));
                            $bolStat = FunctionsAccountingControllers::fInsData($arrSend, $arrData[$i], $arrCheck[$i], $makeHash[$i], $haveAdd[$i], $sMail[$i], $validate[$i], $tbl[$i]);
                            if(! in_array($bolStat, $stat)) {
                                $stat = [$bolStat];
                            }
                        } }
                        $statUpd = true; //foreach($stat AS $statEach) {if($statEach !== true) {$statUpd = false; } }
                        if($statUpd) {
                            DB::table(DB::raw('rssys.m05'))->where([['j_code', $request->j_code]])->update([
                                'j_num'=>FunctionsAccountingControllers::addNewIncrement($j_tbl[0]->j_num, 8)
                            ]);
                        }
                        return json_encode($stat);

                    } return json_encode(['No j_code selected.']);
                    break;
                case 'insOBR':
                    $obr_code = ((isset($request->obr_code)) ? $request->all() : DB::table(DB::raw('rssys.m99'))->first());
                    if(isset($obr_code)) {
                        $seq_num = 0;
                        $arrData = [['obr_ref', 'payee', 'particulars', 'rcenter', 'office', 'address', 'b_num'], ['seq_num', 'fpp', 'grp_id', 'at_code', 'debit']];
                        $validate = [[['j_code', 'payee', 'particulars', 'rcenter', 'office', 'address'], ['j_code'=>'No code specified', 'payee'=>'No payee specified', 'particulars'=>"No particulars.", 'rcenter'=>"No responsibility center.", 'office'=>"No office.", 'address'=>"No address."]], [[], []]];
                        $makeHash = [[], []];
                        $haveAdd = [['t_date'=>Carbon::now()->toDateString(), 'user_id'=>strtoupper(FunctionsAccountingControllers::getSession("_user", "id")), 'obr_code'=>FunctionsAccountingControllers::retColArr($obr_code, "obr_code")], ['credit'=>0, 'obr_code'=>FunctionsAccountingControllers::retColArr($obr_code, "obr_code")]]; //'seq_num'=>0, 
                        $sMail = [[], []];
                        $arrCheck = [[], []];
                        $tbl = ['rssys.obrhdr', 'rssys.obrlne']; $numCount = [1, ((isset($request->debit)) ? count($request->debit) : 0)];
                        $stat = []; $newstat = [];
                        for($i = 0; $i < count($tbl); $i++) { if(isset($request->obr_code)) { DB::table(DB::raw($tbl[$i]))->where([['obr_code', $request->obr_code]])->delete(); } for($j = 0; $j < $numCount[$i]; $j++) { $seq_num++;
                            /* if($i > 0) { if(isset($haveAdd[$i]['seq_num'])) { $haveAdd[$i]['seq_num'] = $seq_num; } } */
                            $arrSend = (($i == 1) ? ['seq_num'=>$request->seq_num[$j], 'fpp'=>$request->fpp[$j], 'grp_id'=>$request->grp_id[$j], 'at_code'=>$request->at_code[$j], 'debit'=>$request->debit[$j]] : $request->all());
                            $bolStat = FunctionsAccountingControllers::fInsData($arrSend, $arrData[$i], $arrCheck[$i], $makeHash[$i], $haveAdd[$i], $sMail[$i], $validate[$i], $tbl[$i]);
                            if(! in_array($bolStat, $stat)) {
                                array_push($stat, $bolStat);
                            }
                        } }
                        $statUpd = true; foreach($stat AS $statEach) {if($statEach !== true) {$statUpd = false; } }
                        if($statUpd) {
                            // if(isset($request->b_num)) { DB::table(DB::raw('rssys.bgt01'))->where([['b_num', $request->b_num]])->update([
                            //     'obr_code'=>FunctionsAccountingControllers::retColArr($obr_code, "obr_code")
                            // ]); }
                            if(! isset($request->obr_code)) {
                                DB::table(DB::raw('rssys.m99'))->update([
                                    'obr_code'=>FunctionsAccountingControllers::addNewIncrement(FunctionsAccountingControllers::retColArr($obr_code, "obr_code"), 8)
                                ]);
                            }
                        } else {
                            foreach($tbl AS $tblEach) {
                                DB::table(DB::raw($tblEach))->where([['obr_code', FunctionsAccountingControllers::retColArr($obr_code, "obr_code")]])->delete();
                            }
                        }
                        return json_encode($stat);

                    } return json_encode(['No j_code selected.']);
                    break;
                case 'fundavailable':
                    $arrData = ['fundavailable'];
                    $validate = [['fundavailable'], ['fundavailable'=>"No address."]];
                    $makeHash = []; $haveAdd = []; $arrCheck = []; $sMail = [];
                    $tbl = 'rssys.tr01'; 
                    $where = [['j_code', $request->j_code], ['j_num', $request->j_num]];
                    return json_encode(FunctionsAccountingControllers::fUpdData($request->all(), $arrData, $arrCheck, $makeHash, $haveAdd, $sMail, $validate, $tbl, $where));
                    break;
                case 'isreviewed':
                    $arrData = ['isreviewed'];
                    $validate = [['isreviewed'], ['isreviewed'=>"No address."]];
                    $makeHash = []; $haveAdd = []; $arrCheck = []; $sMail = [];
                    $tbl = 'rssys.tr01'; 
                    $where = [['j_code', $request->j_code], ['j_num', $request->j_num]];
                    return json_encode(FunctionsAccountingControllers::fUpdData($request->all(), $arrData, $arrCheck, $makeHash, $haveAdd, $sMail, $validate, $tbl, $where));
                    break;
                case 'insCheck':
                    $arrData = ['payee', 'j_code', 'j_num', 'chk_no', 'chk_bank', 'chk_date'];
                    $validate = [['payee', 'j_code', 'j_num', 'chk_no', 'chk_bank'], ['payee'=>'No payee', 'j_code'=>'No disbursement link', 'j_num'=>'No disbursement link', 'chk_no'=>'No check no.', 'chk_bank'=>'No bank name']];
                    $makeHash = []; $haveAdd = ['user_id'=>strtoupper(FunctionsAccountingControllers::getSession("_user", "id"))]; $arrCheck = []; $sMail = [];
                    $tbl = 'rssys.tr01_check'; 
                    return json_encode(FunctionsAccountingControllers::fInsData($request->all(), $arrData, $arrCheck, $makeHash, $haveAdd, $sMail, $validate, $tbl));
                    break;
                case 'upChk':
                    $arrData = ['receivedby', 'id', 'contact'];
                    $validate = [['receivedby', 'id', 'contact'], ['receivedby'=>'No received by', 'id'=>'No ID', 'contact'=>'No contact']];
                    $makeHash = []; $haveAdd = ['officer'=>strtoupper(FunctionsAccountingControllers::getSession("_user", "id")), 'r_date'=>Carbon::now()->toDateString(), 'r_time'=>Carbon::now()->toTimeString()]; $arrCheck = []; $sMail = [];
                    $tbl = 'rssys.tr01_check'; 
                    $where = [['chk_no', $request->chk_no]];
                    return json_encode(FunctionsAccountingControllers::fUpdData($request->all(), $arrData, $arrCheck, $makeHash, $haveAdd, $sMail, $validate, $tbl, $where));
                    break;
                case 'upPrinting':
                    $arrData = [];
                    $validate = [[], []];
                    $makeHash = []; $haveAdd = ['isprinted'=>true]; $arrCheck = []; $sMail = [];
                    $tbl = 'rssys.tr01_check'; 
                    $where = [['chk_no', $request->chk_no]];
                    FunctionsAccountingControllers::fUpdData($request->all(), $arrData, $arrCheck, $makeHash, $haveAdd, $sMail, $validate, $tbl, $where);
                    return json_encode(FunctionsAccountingControllers::getAllCheck($where));
                    break;
            }
        }
    }
}