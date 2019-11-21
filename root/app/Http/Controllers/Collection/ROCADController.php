<?php

namespace App\Http\Controllers\Collection;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Core;
use DB;
use Excel;
use OfficeExport;

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
                'or' => DB::select("SELECT taxtype_id, taxtype_desc, tax_desc from rssys.tax_group groups left join rssys.tax_type types on types.tax_id = groups.tax_id where groups.active = TRUE AND types.active = TRUE"),
	    		'_ch'=>"OR Issued"
	    	];
	    	return view('collection.ROCADor',$arrRet);

    	}
    	if($request->isMethod('post')){
            try {
                $toAddArr = $toDetaild = [];
                // dd($request->all());
                if(count($request->amount) == count($request->transid) && count($request->transid) == count($request->or_to)){
                    foreach ($request->transid as $key => $value) {
                       $toTotal = 0;
                       for ($i=0; $i < count($request->ors[$value]); $i++) { 
                           array_push($toDetaild, ['trans_id' => $value, 'or_to' => $request->or_to[$value][$i], 'amount' => str_replace( ',', '', $request->amount[$value][$i] ), 'or_type' => $request->ors[$value][$i], ]);
                           $toTotal += str_replace( ',', '', $request->amount[$value][$i] );
                       }
                        array_push($toAddArr, ['transid' => $value, 'or_to' => array_sum($request->or_to[$value]), 'amount' => $toTotal, 't_date' => Date('Y-m-d'), 't_time' => Date('H:i:s')]);
                    }


                    if(DB::table('rssys.or_issued')->insert($toAddArr) && DB::table('rssys.or_issued_detailed')->insert($toDetaild)){
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
            'collectors'=>DB::select("SELECT distinct x08.opr_name,liquidate.liquidateid from rssys.liquidate left join rssys.x08 on x08.uid = liquidate.collector where liquidateid NOT IN (SELECT liquidateid from rssys.deposittobank)"),
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


    public function rocardDailyUser(){
        $arrRet = [
            'collectors'=>DB::select("SELECT distinct x08.opr_name, x08.uid from rssys.deposittobank left join rssys.x08 on x08.uid = deposittobank.collector"),
            '_bc'=>[
                    ['link'=>'#','desc'=>'City Treasure','icon'=>'none','st'=>false],
                    ['link'=>url("collection/RocadDailyUser"),'desc'=>'Rocad Daily Report','icon'=>'file-text','st'=>true]
                ],
            '_ch'=>"ROCAD Daily Report"
        ];
        return view('report.collection.ROCADdailyuser',$arrRet);
    }

    public function abstractView(){
        return view('report.collection.abstractview');
    }

    public function abstractProcess(Request $request, $from, $to){
        $groupedTax = $groupData = $processedData = $processedHeaderDesc = [];
        $oldDesc = null;
        if(isset($from) && isset($to)){
            $data = DB::select("SELECT hd.*, lne.*, to_char(hd.trnx_date,'MM/DD/YYYY') as date from rssys.colhdr hd join rssys.collne2 lne on lne.or_code = hd.col_code join rssys.tax_type tax on tax.taxtype_id = lne.payment_id where tax.or_code NOT IN ('AF56') AND hd.trnx_date between '$from' and '$to'");
            $taxData = DB::select("SELECT * from rssys.tax_group join rssys.tax_type on tax_group.tax_id = tax_type.tax_id where tax_group.active = TRUE AND tax_type.active = TRUE GROUP BY tax_group.tax_desc, tax_group.active, tax_group.tax_id, tax_type.taxtype_id order by tax_group.tax_id ASC");
            if(count($data) <= 0 || count($taxData) <= 0){
                return abort(404);
            }
            $oldDesc = $taxData[0]->tax_desc;
            foreach ($taxData as $key => $value) {
                $groupedTax[$value->tax_id]['description'] = $value->tax_desc;
                $groupedTax[$value->tax_id][] = $value;
            }

            foreach ($data as $key) {
                $groupData[$key->date][$key->col_code][$key->payment_id][] = $key;
                $groupData[$key->date][$key->col_code]['total'] = (isset($groupData[$key->date][$key->col_code]['total']) ? $groupData[$key->date][$key->col_code]['total'] + $key->amount : $key->amount);
                $groupData[$key->date][$key->col_code][$key->payment_id]['total'] = (isset($groupData[$key->date][$key->col_code][$key->payment_id]['total']) ? $groupData[$key->date][$key->col_code][$key->payment_id]['total'] + $key->amount : $key->amount);
            }
            // dd([$groupedTax,$groupData]);

            $arrRet = [
                'groupedTax' => $groupedTax,
                'groupedData' => $groupData,
            ];
            // return Excel::download(new OfficeExport('officeReport.abstractreport',$arrRet), 'ABSTRACT-Report-'.$from.'-'.$to.'.xlsx');
            return view('report.collection.abstractProcess', $arrRet);
        }
        return abort(404);
    }

    public function dailycollectionView(){
        return view('report.collection.dailycollectionView');
    }


     public function dailycollectionProcess($date){
        if(isset($date)){
            $filteredAccord = [];
            $selectedDate = Date('m-d-Y',strtotime($date));
            $yesterdayOfSelectedDate = Date('m-d-Y',strtotime($date.'-1 day'));
            $unfilteredData = DB::select("SELECT 'today' as todayFlag,  f.or_type as ortype, SUM(d.amount::float) as today from rssys.deposittobank a join rssys.liquidate b on a.liquidateid = b.liquidateid join rssys.or_issuance c on b.collector = c.collector join rssys.or_issued d on c.transid = d.transid join rssys.x08 e on c.collector = e.uid join rssys.or_types f on c.or_type = f.or_type join rssys.x08 g on b.liquidatingofficer = g.uid join rssys.x08 h on h.uid = a.uid  where d.t_date = '$selectedDate' group by ortype UNION ALL SELECT 'yesterday' as yesterdayFlag, f.or_type as ortype, SUM(d.amount::float) as yesterday from rssys.deposittobank a  join rssys.liquidate b on a.liquidateid = b.liquidateid join rssys.or_issuance c on b.collector = c.collector join rssys.or_issued d on c.transid = d.transid join rssys.x08 e on c.collector = e.uid join rssys.or_types f on c.or_type = f.or_type join rssys.x08 g on b.liquidatingofficer = g.uid join rssys.x08 h on h.uid = a.uid  where d.t_date = '2019-10-08' group by ortype");
            $hereto = DB::select("SELECT e.opr_name as collector, SUM(a.amount::float) as depossitedamount from rssys.deposittobank a  join rssys.liquidate b on a.liquidateid = b.liquidateid join rssys.or_issuance c on b.collector = c.collector join rssys.or_issued d on c.transid = d.transid join rssys.x08 e on c.collector = e.uid join rssys.or_types f on c.or_type = f.or_type join rssys.x08 g on b.liquidatingofficer = g.uid join rssys.x08 h on h.uid = a.uid  where d.t_date = '$selectedDate' GROUP BY e.opr_name");
            $collection = DB::select("SELECT payment_desc, SUM(amount) as colamount from rssys.colhdr hd join rssys.collne2 lne on hd.col_code = lne.or_code where trnx_date = '$selectedDate' group by payment_desc");
            foreach ($unfilteredData as $key => $value) {
                if($value->ortype != 'AF56'){
                    $filteredAccord['General'][] = $value;
                }
                if($value->ortype == 'AF56'){
                    $filteredAccord['Land Tax (Basic)'][] = $value;
                    $filteredAccord['Land Tax (SEF)'][] = $value;
                }
            }

            $arrRet = [
                'allData' => [$filteredAccord],
                'selectedDate' => $date,
                'hereto' => $hereto,
                'collection' => $collection
            ];
            return view('report.collection.dailycollectionProcess',$arrRet);

        }
    }

    public function rocardDailyUserProcess(Request $request, $uid, $date){
        if(isset($uid) && isset($date)){
            $data = DB::select("SELECT f.or_type as ortype, f.hassef , g.opr_name as liquidatingofficer, h.opr_name as depositofficer, e.opr_name as collector, c.or_no issuedfrom, c.or_no_to issuedto, d.or_to as issueduntil, d.amount, a.amount as depossitedamount, b.amountreceive as liquidatereceived from rssys.deposittobank a  join rssys.liquidate b on a.liquidateid = b.liquidateid join rssys.or_issuance c on b.collector = c.collector join rssys.or_issued d on c.transid = d.transid join rssys.x08 e on c.collector = e.uid join rssys.or_types f on c.or_type = f.or_type join rssys.x08 g on b.liquidatingofficer = g.uid join rssys.x08 h on h.uid = a.uid  where e.uid = '$uid' AND (d.t_date = '$date' AND b.date = '$date' AND a.t_date = '$date') ");
            if(count($data) <= 0){
                abort(404);
            }
            $arrRet = [
                'data'=>$data,
                'date' => $date
            ];
            return view('report.collection.ROCADdailyperuser',$arrRet);
        }

    }

    public function RPTView(){
        $arrRet = [
            'forRPT' => true
        ];
        return view('report.collection.dailycollectionView',$arrRet);
    }

    public function RPTProcess(Request $request,$date){
        $arrPush = [];
        $yesterdayOfSelectedDate = Date('Y',strtotime($date.'-1 day'));
        $unfilteredData = DB::select("SELECT hdr.col_code, hdr.trnx_date as date, lne.payer as payer, lne.qtr as periodcoveredqtr, lne.year as periodcoveredyear, hdr.or_no, SUM(lne.amount), 'gross' as flag from rssys.colhdr hdr left join rssys.collne2 lne on hdr.col_code = lne.or_code where amount >= 0 AND hdr.trnx_date = '$date'  GROUP BY date, payer, periodcoveredqtr, periodcoveredyear, or_no, hdr.col_code UNION select hdr.col_code, hdr.trnx_date as date, lne.payer as payer, lne.qtr as periodcoveredqtr, lne.year as periodcoveredyear, hdr.or_no, SUM(lne.amount), 'discount' as flag from rssys.colhdr hdr left join rssys.collne2 lne on hdr.col_code = lne.or_code where amount < 0 AND hdr.trnx_date = '$date' GROUP BY date, payer, periodcoveredqtr, periodcoveredyear, or_no, hdr.col_code");
        if(count($unfilteredData) <= 0){
            return abort(404);
        }
        
        foreach ($unfilteredData as $key => $value) {
            $arrPush[$value->date][$value->periodcoveredqtr.$value->periodcoveredyear][] = [$value,DB::SELECT("SELECT SUM(lne.amount) from rssys.colhdr hdr left join rssys.collne2 lne on hdr.col_code = lne.or_code where amount < 0 AND to_char(trnx_date,'YYYY') < '2020' AND or_code ='$value->col_code' AND  year = '$value->periodcoveredyear' AND qtr = '$value->periodcoveredqtr' ")];
        }

        $arrRet = [
            'data' => $arrPush
        ];
        dd($arrRet);
        return view('report.collection.RPTCollection',$arrRet);

    }

    public function SOCView(){
        return view('report.collection.SOCView');
    }

    public function SOCProcess(Request $request, $from, $to){
        $users = $groupData = $processedData = $processedHeaderDesc = [];
        if(isset($from) && isset($to)){
            $data = DB::select("SELECT issued.t_date, users.opr_name, users.uid, SUM(issued.amount::float) from rssys.or_issued issued left join rssys.or_issuance issue on issued.transid = issue.transid left join rssys.x08 users on issue.collector = users.uid  where issued.t_date >= '$from' AND issued.t_date <=  '$to' GROUP BY issued.t_date, opr_name, users.uid");
            if(count($data) <= 0){
                return abort(404);
            }


            foreach ($data as $key => $value) {
                $users[$value->uid] = [$value->opr_name,$value->uid];
                $processedData[$value->t_date][] = $value;
            }

            $arrRet = [
                'users' => $users,
                'data' => $processedData,
                'dateFormatted' => [[Date('F',strtotime($from)),Date('Y',strtotime($from))],[Date('F',strtotime($to)), Date('Y',strtotime($to))]]
            ];


            return view('report.collection.SOCProcess', $arrRet);
        }
        return abort(404);
    }



}
