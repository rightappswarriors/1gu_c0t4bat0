<?php

namespace App\Http\Controllers\Budget\LBP;


use Mail;
use Session;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Storage;
use FunctionsAccountingControllers;

class bl_lbp extends Controller {

	public function __redirect(Request $request, $form_no) {
		$tbls = [
			'8' => 'lbp0802',
			'9' => 'lbp0903',
		]; $tbl2 = $tbls[$form_no];

		$arrRet = [
			'form_no' => $form_no,
			'appDet' => DB::select("SELECT *, fund.fdesc, sector.secdesc, COALESCE($tbl2.appro_amnt, 0.00) AS appro_amnt FROM rssys.lbp0801 LEFT JOIN rssys.fund ON lbp0801.fid = fund.fid LEFT JOIN (SELECT b_num, SUM(appro_amnt) AS appro_amnt FROM rssys.$tbl2 GROUP BY b_num) $tbl2 ON $tbl2.b_num = lbp0801.b_num LEFT JOIN rssys.sector ON sector.secid = lbp0801.secid LEFT JOIN rssys.function ON function.funcid::text = lbp0801.funcid WHERE form_no = '$form_no'"),
		];
		return view('budget.lbp.lbp_view', $arrRet);
	}

	public function __entry(Request $request, $form_no) { // function for new Entry in LBP Form(s)
		$message = ""; $url = [
			'8' => 'budget.lbp.lbp_entry',
			'9' => 'budget.lbp.lbp_entry_9',
		];
		if($request->isMethod('post')) {
			switch($form_no) {
				case '8':
					$message = self::saveForLBP8($request, $form_no);
					break;
				case '9':
					$message = self::saveForLBP9($request, $form_no);
					break;
			}
		}
		$arrRet = [
			'appDet' => NULL,
			'form_no' => $form_no,
			'function' => DB::table(DB::raw('rssys.function'))->where([['active', true]])->get(),
			'years' => DB::select("SELECT DISTINCT rssys.x03.fy FROM rssys.x03 ORDER BY rssys.x03.fy ASC"),
			'funds' => DB::table(DB::raw('rssys.fund'))->get(),
			'sector' => DB::table(DB::raw('rssys.sector'))->get(),
			'office' => DB::table(DB::raw('rssys.m08'))->get(),
			'ppa' => DB::select("SELECT * FROM rssys.ppasubgrp ORDER BY seq"),
			'getData' => DB::select("SELECT *, fund.fdesc, (COALESCE(lbp0802.appro_amnt, 0.00) - COALESCE(_all.appro_amnt1, 0.00)) AS appro_amnt FROM rssys.lbp0801 LEFT JOIN rssys.fund ON lbp0801.fid = fund.fid LEFT JOIN (SELECT b_num, SUM(appro_amnt) AS appro_amnt FROM rssys.lbp0802 GROUP BY b_num) lbp0802 ON lbp0802.b_num = lbp0801.b_num LEFT JOIN (SELECT lbp0801.lbp08_b_num::integer AS b_num, SUM(_all.appro_amnt1) AS appro_amnt1 FROM rssys.lbp0801 LEFT JOIN (SELECT b_num, SUM(appro_amnt) AS appro_amnt1 FROM rssys.lbp0903 GROUP BY b_num) _all ON lbp0801.b_num = _all.b_num GROUP BY lbp0801.lbp08_b_num) _all ON lbp0801.b_num = _all.b_num WHERE form_no = '8'"),
			'account' => DB::table(DB::raw('rssys.m04'))->get(),
			'message' => $message,
		];
		return view($url[$form_no], $arrRet);
	}

	public static function saveForLBP8(Request $request, $form_no) { // function for saving LBP Form #8
		$sysdate = Carbon::now()->toDateString(); $systime = Carbon::now()->toTimeString(); $user = strtoupper(FunctionsAccountingControllers::getSession("_user", "id"));
		$arrData = [['fy', 'fid'], ['seq_desc', 'form_where', 'check_table', 'check_funds', 'check_ppa', 'check_fy', 'check_mo_from', 'check_mo_to', 'at_code', 'appro_amnt', 'group_m']];
        $validate = [[[], []], [[], []]];
        $makeHash = [[], []];
        $haveAdd = [['sysdate'=>$sysdate, 'systime'=>$sysdatetime, 'user_id'=>$user, 'form_no'=>$form_no], []];
        $arrCheck = [[], []];
        $sMail = [[], []];
        $tbl = ['rssys.lbp0801', 'rssys.lbp0802'];
        $count = 'seq_desc';
        $getFirstLayer = [[], ['rssys.lbp0801', [['fy', $request->fy], ['fid', $request->fid], ['sysdate', $sysdate], ['systime', $systime], ['user_id', $user]], ['b_num', 'desc'], 'b_num']]; // [['fy', $request->fy], ['fid', $request->fid], ['sysdate', $sysdate], ['systime', $systime], ['user_id', $user]]
        $autoInc = 'seq_num';
        return self::saveWith2Layers($request, $arrData, $validate, $makeHash, $haveAdd, $arrCheck, $sMail, $tbl, $count, $getFirstLayer, $autoInc);
	}

	public static function saveForLBP9(Request $request, $form_no) { // function for saving LBP Form #9
		$sysdate = Carbon::now()->toDateString(); $systime = Carbon::now()->toTimeString(); $user = strtoupper(FunctionsAccountingControllers::getSession("_user", "id"));
		$arrData = [['fy', 't_desc', 'lbp08_b_num'], ['cc_code', 'fid', 'secid']];
        $validate = [[[], []], [[], []]];
        $makeHash = [[], []];
        $haveAdd = [['sysdate'=>$sysdate, 'systime'=>$systime, 'user_id'=>$user, 'form_no'=>$form_no], ['fy'=>$request->fy, 'sysdate'=>$sysdate, 'systime'=>$systime, 'user_id'=>$user]];
        $arrCheck = [[], []];
        $sMail = [[], []];
        $tbl = ['rssys.lbp0801', 'rssys.lbp0902'];
        $getPKFrom1stLayer = [[], ['rssys.lbp0801', [['fy', $request->fy], ['fid', $request->fid], ['sysdate', $sysdate], ['systime', $systime], ['user_id', $user]], ['b_num', 'desc'], 'b_num']]; // ['fy', $request->fy], ['sysdate', $sysdate], ['systime', $systime], ['user_id', $user]
        $arrData1 = ['seq_desc', 'grpid', 'at_code', 'appro_amnt'];
		$validate1 = [[], []]; $makeHash1 = []; $haveAdd1 = []; $arrCheck1 = []; $sMail1 = []; $tbl1 = 'rssys.lbp0903';
		$autoInc = 'seq_num';
		$getPKFrom2ndLayer = ['rssys.lbp0902', ['fy', 'sysdate', 'systime', 'user_id', 'cc_code', 'fid', 'secid'], ['b_num', 'desc'], ['b_num', 'b_num1']]; // [['fy', $request->fy], ['sysdate', $sysdate], ['systime', $systime], ['user_id', $user], ['cc_code', $request->cc_code[$j]], ['fid', $request->fid[$j]], ['secid', $request->secid[$j]]]
		$count = 'cc_code';
		$count1 = ['appro_amnt', 'cc_code'];
		dd($request->all());
		return self::saveWith3Layers($request, $arrData, $validate, $makeHash, $haveAdd, $arrCheck, $sMail, $tbl, $count, $getPKFrom1stLayer, $arrData1, $validate1, $makeHash1, $haveAdd1, $arrCheck1, $sMail1, $tbl1, $count1, $autoInc, $getPKFrom2ndLayer);
	}

	public static function saveWith2Layers(Request $request, $arrData, $validate, $makeHash, $haveAdd, $arrCheck, $sMail, $tbl, $countFirst, $getFirstLayer, $autoInc) { // function for saving files with 2 layers (2 tables, in easier term)
		$n_b_num = "";
        $count = [1, count($request->$countFirst)]; $stat = [];
        for($i = 0; $i < count($tbl); $i++) {
        	for($j = 0; $j < $count[$i]; $j++) {
        		if($count[$i] > 1) { $haveAdd[$i][$autoInc] = $j + 1; }
	        	$newRequest = new \stdClass(); foreach($arrData[$i] AS $someData) { $newRequest->$someData = (($i == 1) ? $request->$someData[$j] : $request->$someData); } foreach($haveAdd[$i] AS $hKey => $hValue) { $newRequest->$hKey = $hValue; } $whereFirst = [];
        		if($count[$i] > 1) {
        			$b_num = [];
        			if(count($getFirstLayer[$i]) > 2) { $b_num = DB::table(DB::raw($getFirstLayer[$i][0]))->where($getFirstLayer[$i][1])->orderBy($getFirstLayer[$i][2][0], $getFirstLayer[$i][2][1])->first(); }
        			if(isset($b_num)) { $s_b_num = $getFirstLayer[$i][3]; $haveAdd[$i][$s_b_num] = $b_num->$s_b_num; $n_b_num = $b_num->$s_b_num; }
        		} 
	        	$boolStat = FunctionsAccountingControllers::fInsData($newRequest, $arrData[$i], $arrCheck[$i], $makeHash[$i], $haveAdd[$i], $sMail[$i], $validate[$i], $tbl[$i]);
	        	array_push($stat, $boolStat);
	        }
	    }
	    foreach($stat AS $sEach) { if($sEach == true) {} else { return json_encode($sEach); break; } }
	    return true;
	}

	public static function saveWith3Layers(Request $request, $arrData, $validate, $makeHash, $haveAdd, $arrCheck, $sMail, $tbl, $countFirst, $getPKFrom1stLayer, $arrData1, $validate1, $makeHash1, $haveAdd1, $arrCheck1, $sMail1, $tbl1, $count1First, $autoInc, $getPKFrom2ndLayer) { // function for saving files with 3 layers (3 tables, in easier term)
		$n_b_num = ""; $stat = [];
        $count = [1, count($request->$countFirst)];
        for($i = 0; $i < count($tbl); $i++) {
        	for($j = 0; $j < $count[$i]; $j++) {
        		$newRequest = new \stdClass(); foreach($arrData[$i] AS $someData) { $newRequest->$someData = (($i == 1) ? $request->$someData[$j] : $request->$someData); } foreach($haveAdd[$i] AS $hKey => $hValue) { $newRequest->$hKey = $hValue; } $whereFirst = [];
	        	if(count($getPKFrom1stLayer[$i]) > 1) { foreach($getPKFrom1stLayer[$i][1] AS $justFirstLayer) { array_push($whereFirst, [$justFirstLayer, $newRequest->$justFirstLayer]); } }
	        	if($i == 1) {
	        		$b_num = [];
	        		if(count($getPKFrom1stLayer[$i]) > 2) { $b_num = DB::table(DB::raw($getPKFrom1stLayer[$i][0]))->where($whereFirst)->orderBy($getPKFrom1stLayer[$i][2][0], $getPKFrom1stLayer[$i][2][1])->first(); }
	        		if(isset($b_num)) { $s_b_num = $getPKFrom1stLayer[$i][3]; $haveAdd[$i][$s_b_num] = $b_num->$s_b_num; $n_b_num = $b_num->$s_b_num; } }
	        	$boolStat = FunctionsAccountingControllers::fInsData($newRequest, $arrData[$i], $arrCheck[$i], $makeHash[$i], $haveAdd[$i], $sMail[$i], $validate[$i], $tbl[$i]);
        		if($i == 1) {
        			$count1FirstFirst = $request->$count1First[0]; $count1FirstSecond = $request->$count1First[1];
					$count1 = count($count1FirstFirst[$count1FirstSecond[$j]]);
			        for($k = 0; $k < $count1; $k++) {
			        	$haveAdd1[$autoInc] = $k + 1;
			        	$newRequest1 = new \stdClass(); foreach($arrData1 AS $someData1) { $newRequest1->$someData1 = $request->$someData1[$request->cc_code[$j]][$k]; }  foreach($haveAdd1 AS $hKey1 => $hValue1) { $newRequest->$hKey1 = $hValue1; } $whereSecond = [];
			        	foreach($getPKFrom2ndLayer[1] AS $justSecondLayer) { array_push($whereSecond, [$justSecondLayer, $newRequest->$justSecondLayer]); }
			        	$b_num1 = DB::table(DB::raw($getPKFrom2ndLayer[0]))->where($whereSecond)->orderBy($getPKFrom2ndLayer[2][0], $getPKFrom2ndLayer[2][1])->first(); if(isset($b_num1)) { $haveAdd1[$getPKFrom2ndLayer[3][1]] = $b_num1->$getPKFrom2ndLayer[3][1]; $haveAdd1[$getPKFrom2ndLayer[3][0]] = $b_num1->$getPKFrom2ndLayer[3][0]; }

			        	$boolStat1 = FunctionsAccountingControllers::fInsData($newRequest1, $arrData1, $arrCheck1, $makeHash1, $haveAdd1, $sMail1, $validate1, $tbl1);
			        	array_push($stat, $boolStat1);
			        }
        		}
	        }
	    }
	    foreach($stat AS $sEach) { if($sEach == true) {} else { return json_encode($sEach); break; } }
	    return true;
	}

	public function __edit(Request $request, $form_no, $b_num) { // function for editing files
		$message = ""; $url = [
			'8' => 'budget.lbp.lbp_entry',
			'9' => 'budget.lbp.lbp_entry_9',
		]; $sql = [
			'8' => "SELECT lbp0801.*, lbp0802.*, m04.at_desc FROM rssys.lbp0801 LEFT JOIN rssys.lbp0802 ON lbp0801.b_num = lbp0802.b_num LEFT JOIN rssys.m04 ON lbp0802.at_code = m04.at_code WHERE lbp0801.b_num = '$b_num' AND lbp0801.form_no = '$form_no'",
			'9' => "SELECT lbp0801.fy, lbp0801.t_desc, lbp0801.form_no, lbp0801.lbp08_b_num, lbp0902.cc_code, lbp0902.secid, lbp0902.fid, m08.cc_desc, lbp0903.*, ppasubgrp.subgrpdesc FROM rssys.lbp0801 LEFT JOIN rssys.lbp0902 ON lbp0801.b_num = lbp0902.b_num LEFT JOIN rssys.m08 ON lbp0902.cc_code = m08.cc_code LEFT JOIN rssys.lbp0903 ON (lbp0801.b_num = lbp0903.b_num AND lbp0902.b_num1 = lbp0903.b_num1) LEFT JOIN rssys.ppasubgrp ON ppasubgrp.subgrpid = lbp0903.grpid WHERE lbp0801.b_num = '$b_num' AND lbp0801.form_no = '$form_no'",
		];
		if($request->isMethod('post')) {
			dd($request->all());
		}
		$arrRet = [
			'appDet' => DB::select($sql[$form_no]),
			'form_no' => $form_no,
			'function' => DB::table(DB::raw('rssys.function'))->where([['active', true]])->get(),
			'years' => DB::select("SELECT DISTINCT rssys.x03.fy FROM rssys.x03 ORDER BY rssys.x03.fy ASC"),
			'funds' => DB::table(DB::raw('rssys.fund'))->get(),
			'sector' => DB::table(DB::raw('rssys.sector'))->get(),
			'office' => DB::table(DB::raw('rssys.m08'))->get(),
			'ppa' => DB::select("SELECT * FROM rssys.ppasubgrp ORDER BY seq"),
			'getData' => DB::select("SELECT *, fund.fdesc, (COALESCE(lbp0802.appro_amnt, 0.00) - COALESCE(_all.appro_amnt1, 0.00)) AS appro_amnt FROM rssys.lbp0801 LEFT JOIN rssys.fund ON lbp0801.fid = fund.fid LEFT JOIN (SELECT b_num, SUM(appro_amnt) AS appro_amnt FROM rssys.lbp0802 GROUP BY b_num) lbp0802 ON lbp0802.b_num = lbp0801.b_num LEFT JOIN (SELECT lbp0801.lbp08_b_num::integer AS b_num, SUM(_all.appro_amnt1) AS appro_amnt1 FROM rssys.lbp0801 LEFT JOIN (SELECT b_num, SUM(appro_amnt) AS appro_amnt1 FROM rssys.lbp0903 GROUP BY b_num) _all ON lbp0801.b_num = _all.b_num WHERE lbp0801.b_num != '$b_num' GROUP BY lbp0801.lbp08_b_num) _all ON lbp0801.b_num = _all.b_num WHERE form_no = '8'"),
			'account' => DB::table(DB::raw('rssys.m04'))->get(),
			'message' => $message,
		];
		if(count($arrRet['appDet']) < 1) {
			return back()->with('alert', ["Error", "error", "No form selected."]);
		}
		return view($url[$form_no], $arrRet);
	}

	public function __extra(Request $request) { // function for extra service(s) or request(s)
		$returnArr = json_encode([]); $returnStr = ""; $returnThisTry = [];
		foreach($request->all() AS $eachKey => $eachValue) { array_push($returnThisTry, $eachKey); }

		if(isset($request->check_table)) {
			$tbl1 = "rssys." . $request->check_table . "01"; $tbl2 = "rssys." . $request->check_table . "02";
			$sql1 = "SELECT b_num FROM $tbl1 WHERE fy = '$request->check_fy' AND fid = '$request->check_funds'";
			$sql2 = "SELECT at_code, SUM(appro_amnt) AS appro_amnt FROM $tbl2 WHERE b_num IN ($sql1) GROUP BY at_code";
			$sql3 = "SELECT b_num FROM rssys.bgt01 WHERE fy = '$request->check_fy' AND fid = '$request->check_funds'";
			if(!empty($request->check_mo_from) && !empty($request->check_mo_to)) { $insThis = " AND mo BETWEEN '$request->check_mo_from' AND '$request->check_mo_to'"; if($request->check_table == "bgt") { $sql1 .= $insThis; } $sql3 .= $insThis; }
			$superSql = FunctionsAccountingControllers::getAllApproAllotOblig($request->check_funds, $request->check_fy, $request->check_mo_from, $request->check_mo_to);
			$funds = ((isset($request->check_funds)) ? "AND fid = '$request->check_funds'" : ""); $ppa = ((isset($request->check_ppa)) ? "AND grpid = '$request->check_ppa'" : ""); $fy = ((isset($request->check_fy)) ? "fy = '$request->check_fy'" : "1=1");
			$sql = "SELECT _all.at_code, _all.new_at_desc AS at_desc, COALESCE(appro_amnt, 0.00) AS appro_amnt, COALESCE(allot_amnt, 0.00) AS allot_amnt, COALESCE(oblig_amnt, 0.00) AS oblig_amnt, COALESCE(lbp_amnt, 0.00) AS lbp_amnt FROM (SELECT _all.at_code, (CASE WHEN (_all.seq_desc IS NULL OR _all.seq_desc = '0') THEN m04.at_desc ELSE _all.seq_desc END) AS new_at_desc, SUM(appro_amnt) AS appro_amnt, SUM(allot_amnt) AS allot_amnt, SUM(oblig_amnt) AS oblig_amnt FROM ($superSql) _all LEFT JOIN rssys.m04 ON m04.at_code = _all.at_code WHERE 1=1 $ppa GROUP BY _all.at_code, new_at_desc) _all LEFT JOIN (SELECT at_code, SUM(appro_amnt) AS lbp_amnt FROM rssys.lbp0802 WHERE b_num IN (SELECT b_num FROM rssys.lbp0801 WHERE $fy $funds) $ppa GROUP BY at_code) lbp ON lbp.at_code = _all.at_code";
			//"SELECT appro.at_code, m04.at_desc, COALESCE(appro_amnt, 0.00) AS appro_amnt, COALESCE(obr_amnt, 0.00) AS obr_amnt, COALESCE(lbp_amnt, 0.00) AS lbp_amnt FROM ($sql2) appro LEFT JOIN (SELECT at_code, SUM(debit) AS obr_amnt FROM rssys.obrlne WHERE obr_code IN (SELECT obr_code FROM rssys.obrhdr WHERE b_num IN ($sql3)) GROUP BY at_code) obr ON appro.at_code = obr.at_code LEFT JOIN (SELECT at_code, SUM(appro_amnt) AS lbp_amnt FROM rssys.lbp0802 WHERE b_num IN (SELECT b_num FROM rssys.lbp0801 WHERE fy = '$request->check_fy' AND fid = '$request->check_funds') GROUP BY at_code) lbp ON lbp.at_code = appro.at_code LEFT JOIN rssys.m04 ON m04.at_code = appro.at_code";

			$returnArr = json_encode(DB::select($sql));
		}
		if(isset($request->fy) && isset($request->office)) {
			$sql = "SELECT fy, b_num, m08.cc_code, m08.cc_desc, fund.fid, fund.fdesc, sector.secid, sector.secdesc FROM rssys.bgt01 LEFT JOIN rssys.m08 ON m08.cc_code = bgt01.cc_code LEFT JOIN rssys.fund ON fund.fid = bgt01.fid LEFT JOIN rssys.sector ON sector.secid = bgt01.secid WHERE fy = '$request->fy' AND m08.cc_code = '$request->office'";

			$returnArr = json_encode(DB::select($sql));
		}
		if(isset($request->bgt_b_num)) {
			$getAllAllotOblig = FunctionsAccountingControllers::getAllAllotOblig();
			$sql = "SELECT SUM(appro_amnt) AS appro_amnt, SUM(allot_amnt) AS allot_amnt, SUM(oblig_amnt) AS oblig_amnt, _all.at_code, grpid, m04.at_desc FROM ($getAllAllotOblig WHERE b_num = '$request->bgt_b_num') _all LEFT JOIN rssys.m04 ON m04.at_code = _all.at_code GROUP BY _all.at_code, grpid, m04.at_desc";

			$returnArr = json_encode(DB::select($sql));
		}
		if(isset($request->year) && isset($request->fund) && isset($request->sector) && isset($request->office)) {
			$funcid = ((isset($request->functions)) ? "funcid = '$request->functions'" : "1=1");
			$getAll = FunctionsAccountingControllers::getSAOBReport($request->fund, $request->year);
			$sql = "SELECT * FROM ($getAll) _all WHERE secid = '$request->sector' AND $funcid AND cc_code = '$request->office'";

			$returnArr = json_encode(DB::select($sql));
		}
		return $returnArr;
	}
}
