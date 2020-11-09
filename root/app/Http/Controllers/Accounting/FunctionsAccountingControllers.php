<?php

namespace App\Http\Controllers\Accounting;

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
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class FunctionsAccountingControllers extends Controller {
	protected static $sesUser;
    public static function setUser() { static::$sesUser = self::getSession("_user"); return static::$sesUser; }
    public static function getUser() { return ((isset(static::$sesUser)) ? static::$sesUser : self::setUser()); }
    public static function getAllTablesDataNow() {
    	$retArr = []; $table_names = DB::select("SELECT table_name, table_schema FROM information_schema.tables WHERE table_schema = 'rssys' AND table_catalog = 'rightapps_guihulngan' ORDER BY table_name"); 
    	foreach($table_names AS $each) {
    		$tschema = $each->table_schema.'.'.$each->table_name;
    		$retArr[$each->table_name] = DB::table(DB::raw($tschema))->get();
    	}
    	return $retArr;
    }
    public static function getSession($sesName = "", $col = "") {
    	$session = Session::get($sesName);
    	return ((isset($session)) ? ((! empty($col)) ? ((isset($session->$col)) ? $session->$col : ((isset($session[$col])) ? $session[$col] : "")) : $session) : []);
    }
    public static function checkSession($isSession = false) {
		$curSession = self::setUser();
		if($isSession) {
			if(!isset($curSession)) {
				return ['auth/_login', 'alert', ['Warning', 'warning', 'Login first!']];
			} else {
				return [];
			}
		} else {
			if(isset($curSession)) {
				return ['client1/home', 'alert', ['Warning', 'warning', 'Already logged in.']];
			} else {
				return [];
			}
		}
    }
	public static function sMailVerRetBool($location, $sData, $request) {
		return self::sMailSendRetBool($location, $sData, $request, 'Verify Email Account', 'doholrs@gmail.com', 'DOH Support');
	}
	public static function sMailSendRetBool($location, $sData, $request, $sSubject, $sFrom, $sName) {
		try {
			Mail::send($location, $sData, function($message) use ($request, $sSubject, $sFrom, $sName) {
	           	$message->to($request->text6, $request->text2)->subject($sSubject);
	           	$message->from($sFrom, $sName);
	        });
	        return true;
		} catch (Exception $e) {
			return false;
		}
	}
	public static function findColGC($col = "", $val = "", $tbl = "x08") {
		if(!empty($val) && !empty($col)) {
			return DB::table($tbl)->where([[$col, $val]])->get();
		}
		return [];
	}
	public static function getCol($tbl = "", $where = [], $col = "") {
		if(! empty($tbl)) {
			$return = DB::table(DB::raw($tbl));
			if(count($where) > 0) {
				$bool = true; foreach($where AS $whereEach) { if(! is_array($whereEach)) { $bool = false; } }
				if($bool) {
					$return = $return->where($where);
				}
			}
			if(! empty($col)) { $return = $return->select($col); }
			return $return->get();
		}
		return [];
	}
	public static function fSave($request, $arrData = [], $arrCM = [], $makeHash = [], $haveAdd = [], $sMail = [], $validate = [], $tbl = "") {
		if(isset($request)) {
			$arrSave = [];
			foreach($request AS $rKey => $rValue) {
				$cValue = $rValue;
				if(in_array($rKey, $arrData)) {
					if(count($arrCM) > 0) { if(is_array($arrCM[0]) && is_array($arrCM[1])) {
						if(in_array($rKey, $arrCM[0])) {
							$arrThis = self::findColGC($rKey, $rValue);
							if(count($arrThis) > 0) {
								return $arrCM[1][$rKey];
							}
						}
					} }
					if(in_array($rKey, $makeHash)) {
						$cValue = Hash::make($rValue);
					}
					if(count($validate) > 1) { if(is_array($validate[0])) {
						if(in_array($rKey, $validate[0])) {
							if(!isset($rValue)) { //empty($rValue) || 
								return $validate[1][$rKey];
							}
						}
					} }
					array_push($arrSave, $cValue);
				}
			}
			foreach($haveAdd AS $hKey => $hValue) {
				array_push($arrData, $hKey);
				array_push($arrSave, $hValue);
			}
			if(count($arrSave) == count($arrData)) {
				$insData = array_combine($arrData, $arrSave);
				if(count($sMail) > 0) {
					$dRequest = new \stdClass();
					$dRequest->text2 = $insData[$sMail[2][0]]; $dRequest->text6 = $insData[$sMail[2][1]];
					if(self::sMailVerRetBool($sMail[0], $sMail[1], $dRequest)) {
						return $insData;
					} else {
						return "Error on sending Email Request.";
					}
				} else {
					return $insData;
				}
			}
			return "Data provided is not enough. data: (".json_encode([$arrSave, $arrData]).")";
		}
		return "No data provided.";
	}
    public static function fInsData($request, $arrData = [], $arrCM = [], $makeHash = [], $haveAdd = [], $sMail = [], $validate = [], $tbl = "") {
		if(! empty($tbl)) {
			$insData = self::fSave($request, $arrData, $arrCM, $makeHash, $haveAdd, $sMail, $validate, $tbl);
			if(is_array($insData)) {
				$test = DB::table(DB::raw($tbl))->insert($insData);
				return true;
			}
			return $insData;
		}
		return "No table provided.";
	}
	public static function fUpdData($request, $arrData = [], $arrCM = [], $makeHash = [], $haveAdd = [], $sMail = [], $validate = [], $tbl = "", $where = []) {
		if(! empty($tbl)) {
			if(count($where) > 0) {
				$insData = self::fSave($request, $arrData, $arrCM, $makeHash, $haveAdd, $sMail, $validate, $tbl);

				if(is_array($insData)) {
					if(isset($request->seq_num)){
						dd($request->all());
					}
					DB::table(DB::raw($tbl))->where($where)->update($insData);
					return true;
				}
				return $insData;
			}
			return "No condition(s) provided.";
		}
		return "No table provided.";
	}
	public static function addNewIncrement($str = "", $length = 0, $pad_string = "0") {
		$nStr = intval((! empty($str)) ? $str : "") + 1;
		if($length > 0) { $nStr = str_pad($nStr, $length, $pad_string, STR_PAD_LEFT); }
		return $nStr;
	}
	public static function getTotalArr($arr = [], $col = "") {
		$retNum = 0;
		if(count($arr) > 0) { if(! empty($col)) { foreach($arr AS $each) {
			$eCol = ((isset($each->$col)) ? $each->$col : ((gettype($each) == "array") ? ((isset($each[$col])) ? $each[$col] : "") : ""));
			if(! empty($eCol)) {
				$retNum += $eCol;
			}
		} } }
 		return $retNum;
	}
	public static function CollectionLinesWithTotal($where = [], $isNull = true) {
		$retArr = [];
		$colLines = self::getAllOBR($isNull, [], $where);
		if(count($colLines) > 0) { for($i = 0; $i < count($colLines); $i++) {
			$thisTotal = 0; $budgetLines = self::getAllAllotment([['obr_code', $colLines[$i][0]->obr_code]]);
			$thisTotal += self::getTotalArr($colLines[$i][1], "debit");
			if(count($budgetLines) > 0) { foreach($budgetLines AS $bEach) {
				$thisTotal += self::getTotalArr($bEach[1], "allot_amnt");
			} }
			array_push($retArr, [$colLines[$i][0], ['thisTotal'=>$thisTotal]]);
		} }
		return $retArr;
	}
	public static function retColumnFromArr($arr = [], $col = "", $arrNum = 0) {
		$retArr = [];
		if(count($arr) > 0) { if(! empty($col)) { foreach($arr AS $each) {
			$newArr = ((isset($each[$arrNum])) ? $each[$arrNum] : $each);
			$eCol = ((isset($newArr->$col)) ? $newArr->$col : ((isset($newArr[$col])) ? $newArr[$col] : ""));
			if(! empty($eCol)) {
				array_push($retArr, $eCol);
			}
		} } }
		return $retArr;
	}

    // tables
    public static function getAllDisbursement($jname = "", $jnum = "") {
    	$WHERE = ((! empty($jname)) ? "t1.j_code='$jname'" : "t1.j_code IN (SELECT m5.j_code FROM rssys.m05 m5 WHERE m5.j_type='D')");
    	if(! empty($jnum)) { $WHERE = ((! empty($WHERE)) ? " AND " : "") . "t1.j_num = '$jnum'"; }
    	// $dateFrom = ((! empty($dateFrom)) ? $dateFrom : date('Y-m-d')); $dateTo = ((! empty($dateTo)) ? $dateTo : date('Y-m-d')); $uId = ((! empty($uId)) ? $uId : strtoupper(self::getSession("_user", "id")));
    	$sql = "SELECT t1.*, tc2.at_code, tc2.credit, t3.j_memo, m10.mp_desc,m04.at_desc FROM rssys.tr01 t1 LEFT JOIN (SELECT DISTINCT j_code, j_num, pay_code, at_code, credit FROM rssys.tr02 WHERE COALESCE(credit,0)>0  AND (SELECT COUNT(tr2.j_num) FROM rssys.tr02 tr2 WHERE COALESCE(credit,0)>0 AND tr2.j_num=tr02.j_num AND tr2.j_code=tr02.j_code)=1) tc2 ON tc2.j_num=t1.j_num AND tc2.j_code=t1.j_code LEFT JOIN rssys.tr03 t3 ON t3.j_num=t1.j_num AND t3.j_code=t1.j_code LEFT JOIN rssys.m10 m10 ON m10.mp_code=tc2.pay_code LEFT JOIN rssys.m04 m04 ON m04.at_code=tc2.at_code WHERE $WHERE ORDER BY t1.j_num DESC"; // AND tc2.j_num<>'' AND t1.t_date BETWEEN '$dateFrom' AND '$dateTo' AND (t1.cancel IS NULL OR t1.cancel = '') AND user_id = '$uId'
    	return DB::select($sql);
    }
    public static function getAllDisbursementNew($jCode) {
    	$sql = "SELECT t1.*, m04.at_desc, tc2.at_code, tc2.credit from rssys.tr01 t1
				LEFT JOIN (SELECT DISTINCT j_code, j_num, pay_code, at_code, credit FROM rssys.tr02) tc2 
					ON tc2.j_num=t1.j_num AND tc2.j_code=t1.j_code 
				LEFT JOIN (select distinct at_desc, at_code from rssys.m04) m04 
					ON m04.at_code=tc2.pay_code
				WHERE t1.j_code IN (SELECT m5.j_code FROM rssys.m05 m5 WHERE m5.j_type='D') and t1.j_code = '$jCode' ORDER BY t1.t_date DESC";

		return DB::select($sql);
    }
    public static function getDisbursementData($where = [], $whereIn = []) {
    	$retArr = []; $tr01 = DB::table(DB::raw('rssys.tr01'));
    	if(count($where)) { $tr01 = $tr01->where($where); }
    	if(count($whereIn)) { $tr01 = $tr01->whereIn($whereIn[0], $whereIn[1]); }
    	$tr01 = $tr01->get();
    	foreach($tr01 AS $tr01Each) {
    		$lines = self::getDisbursementLines([['j_code', $tr01Each->j_code], ['j_num', $tr01Each->j_num]]);
    		$colLines = self::retColumnFromArr(self::CollectionLinesWithTotal(['obr_code', self::retColumnFromArr(self::getAllOBR(true, [['j_code', $tr01Each->j_code], ['j_num', $tr01Each->j_num]]), "obr_code")], false), 'thisTotal', 1);
    		array_push($colLines, self::getTotalArr($lines, "debit"));
    		array_push($retArr, [$tr01Each, $lines, $colLines, ['credit'=>self::getTotalArr($lines, "credit")], self::getAllCheck([['j_code', $tr01Each->j_code], ['j_num', $tr01Each->j_num]])]);
    	}
    	return $retArr;
    }
    public static function getDisbursementLines($where = [], $whereIn = []) {
    	$tr02 = DB::table(DB::raw('rssys.tr02'));
    	if(count($where)) { $tr02 = $tr02->where($where); }
    	if(count($whereIn)) { $tr02 = $tr02->whereIn($whereIn[0], $whereIn[1]); }
    	$tr02 = $tr02->get();
    	return $tr02;
    }
    public static function getDisbursementLines2($j_code = "", $j_num = "") {
    	$sql = "SELECT t2.*, m4.at_desc, m8.cc_desc FROM rssys.tr02 t2 LEFT JOIN rssys.m04 m4 ON m4.at_code=t2.at_code LEFT JOIN rssys.m08 m8 ON m8.cc_code=t2.cc_code  WHERE (j_code, j_num) IN (('$j_code', '$j_num')) AND debit>0 ORDER BY seq_num ASC";
    	return DB::select($sql);
    }
    public static function getAllOBR($isNullJcode = false, $where1 = [], $whereIn = [], $dateFrom = "", $dateTo = "") {
    	$obrhdr = []; $retArr = []; $dateFrom = ((! empty($dateFrom)) ? $dateFrom : date('Y-m-d', strtotime('1753-01-01'))); $dateTo = ((! empty($dateTo)) ? $dateTo : date('Y-m-d'));
    	$where = []; if($isNullJcode) { array_push($where, ['j_code', null]); }
    	if(count($where1) > 0) { $where = $where1; }
    	$obrhdr = DB::table(DB::raw('rssys.obrhdr'));
    	if(count($where) > 0) { $obrhdr = $obrhdr->where($where); }
    	if(count($whereIn) > 0) { $obrhdr = $obrhdr->whereIn($whereIn[0], $whereIn[1]); }
    	$obrhdr1 = $obrhdr->whereBetween('t_date', [$dateFrom, $dateTo])->get();
    	foreach($obrhdr1 AS $each) {
    		array_push($retArr, [$each, self::getAllOBRLines([$each->obr_code])]);
    	}
    	return $retArr;
    }
    public static function getAllOBRLines($obr_codeIn = [], $where = []) {
    	$obrlne = DB::table(DB::raw('rssys.obrlne'));
    	if(count($obr_codeIn) > 0) { $obrlne = $obrlne->whereIn('obr_code', $obr_codeIn); }
    	return DB::table(DB::raw('rssys.obrlne'))->whereIn('obr_code', $obr_codeIn)->get();
    }
    public static function getAllAllotment($where = [], $whereIn = []) {
    	$retArr = []; $bgt01 = [];
    	$bgt01 = DB::table(DB::raw('rssys.bgt01'));
    	if(count($where) > 0) { $bgt01 = $bgt01->where($where); }
    	if(count($whereIn) > 0) { $bgt01 = $bgt01->whereIn($whereIn[0], $whereIn[1]); }
    	$bgt01 = $bgt01->get();
    	foreach($bgt01 AS $each) {
    		array_push($retArr, [$each, self::getAllAllotmentLines([], [$each->b_num])]);
    	}
    	return $retArr;
    }
    public static function getAllAllotmentLines($where = [], $whereIn = []) {
    	$bgt02 = DB::table(DB::raw('rssys.bgt02'));
    	if(count($where) > 0) { $bgt02 = $bgt02->where($where); }
    	if(count($whereIn) > 0) { $bgt02 = $bgt02->whereIn('b_num', $whereIn); }
    	return $bgt02->get();
    }
    public static function getSAOBReport($fid = "", $bid = "", $mo_from = "1", $mo_to = "12") {
    	$allData = self::getAllApproAllotOblig($fid, $bid, $mo_from, $mo_to);
    	$sql = "SELECT _all.funcid, _all.secid, cc_code, subgrpid, funcdesc, secdesc, cc_desc, subgrpdesc, at_desc, at_code, appro_amnt, allot_amnt, oblig_amnt FROM rssys.function RIGHT JOIN (SELECT sector.secid, funcid, cc_code, subgrpid, secdesc, cc_desc, subgrpdesc, at_desc, at_code, appro_amnt, allot_amnt, oblig_amnt FROM rssys.sector RIGHT JOIN (SELECT m08.cc_code, cc_desc, subgrpid, subgrpdesc, at_desc, at_code, appro_amnt, allot_amnt, oblig_amnt, secid, funcid FROM rssys.m08 RIGHT JOIN (SELECT ppasubgrp.subgrpid, subgrpdesc, at_desc, at_code, appro_amnt, allot_amnt, oblig_amnt, cc_code, secid, funcid FROM rssys.ppasubgrp RIGHT JOIN (SELECT at_desc, m04.at_code, appro_amnt, allot_amnt, oblig_amnt, cc_code, secid, funcid, grpid FROM rssys.m04 RIGHT JOIN ($allData) _all ON _all.at_code = m04.at_code) _all ON _all.grpid = ppasubgrp.subgrpid) _all ON _all.cc_code = m08.cc_code) _all ON _all.secid = sector.secid) _all ON function.funcid::text = _all.funcid ORDER BY secdesc, cc_desc, subgrpdesc, funcdesc, at_desc";
    	return $sql;
    }
    public static function getAllApproAllotOblig($fid = "", $bid = "", $mo_from = "0", $mo_to = "12") {
    	$mo = ((isset($mo_from) && isset($mo_to)) ? "mo BETWEEN '$mo_from' AND '$mo_to'" : "1=1");
    	$getAllAllotOblig = self::getAllAllotOblig();
    	$funds = ((isset($fid)) ? "fid = '$fid'" : "1=1"); $fy = ((isset($bid)) ? "fy = '$bid'" : "1=1");
    	return "SELECT *, NULL::text AS seq_desc FROM (SELECT SUM(appro_amnt) AS appro_amnt, SUM(allot_amnt) AS allot_amnt, SUM(oblig_amnt) AS oblig_amnt, secid, funcid, cc_code, at_code, grpid FROM (SELECT SUM(appro_amnt) AS appro_amnt, SUM(allot_amnt) AS allot_amnt, SUM(oblig_amnt) AS oblig_amnt, secid, funcid, cc_code, at_code, grpid, b_num, seq_desc FROM (SELECT * FROM (SELECT fy, mo, SUM(appro_amnt) AS appro_amnt, 0.00 AS allot_amnt, 0.00 AS oblig_amnt, secid, funcid, cc_code, at_code, grpid, bgtps01.b_num, fid, t_date, seq_desc FROM rssys.bgtps01 LEFT JOIN (SELECT SUM(appro_amnt) AS appro_amnt, b_num, at_code, grpid, seq_desc FROM rssys.bgtps02 GROUP BY b_num, at_code, grpid, seq_desc) bgtps02 ON bgtps01.b_num = bgtps02.b_num GROUP BY fy, mo, secid, funcid, cc_code, at_code, grpid, bgtps01.b_num, fid, t_date, seq_desc) bgtps UNION ALL ($getAllAllotOblig)) _all WHERE $funds AND $fy GROUP BY secid, funcid, cc_code, at_code, grpid, b_num, seq_desc) _all GROUP BY secid, funcid, cc_code, at_code, grpid) _all";
    	// WHERE $mo
    }
    public static function getAllAllotOblig() {
    	$allOblig = self::getOblig();
    	return "SELECT * FROM (SELECT * FROM (SELECT fy, mo, 0.00 AS appro_amnt, SUM(allot_amnt) AS allot_amnt, 0.00 AS oblig_amnt, secid, funcid, cc_code, at_code, grpid, bgt01.b_num, fid, t_date, seq_desc FROM rssys.bgt01 LEFT JOIN (SELECT SUM(allot_amnt) AS allot_amnt, b_num, at_code, grpid, seq_desc FROM rssys.bgt02 GROUP BY b_num, at_code, grpid, seq_desc) bgt02 ON bgt01.b_num = bgt02.b_num GROUP BY fy, mo, secid, funcid, cc_code, at_code, grpid, bgt01.b_num, fid, t_date, seq_desc) bgt UNION ALL SELECT * FROM ($allOblig) oblig)_all";
    }
    public static function getOblig() {
    	return "SELECT fy, mo, 0.00 AS appro_amnt, 0.00 AS allot_amnt, SUM(oblig_amnt) AS oblig_amnt, secid, funcid, office AS cc_code, obrlne.at_code, obrlne.grpid, obrhdr.b_num, fid, t_date, seq_desc FROM rssys.obrhdr INNER JOIN (SELECT SUM(debit) AS oblig_amnt, obr_code, obrlne.at_code, grp_id AS grpid, seq_num, seq_desc FROM rssys.obrlne GROUP BY obr_code, at_code, grp_id, seq_num) obrlne ON obrhdr.obr_code = obrlne.obr_code GROUP BY fy, mo, secid, funcid, cc_code, obrlne.at_code, obrlne.grpid, obrhdr.b_num, fid, t_date, seq_desc";
    }
    public static function getAllCheck($where = [], $whereIn = []) {
    	$tr01_check = DB::table(DB::raw('rssys.tr01_check'));
    	if(count($where) > 0) { $tr01_check = $tr01_check->where($where); }
    	if(count($whereIn) > 0) { $tr01_check = $tr01_check->whereIn($whereIn[0], $whereIn[1]); }
    	return $tr01_check->get();
    }
	public static function retColArr($arr = [], $col = "", $default = "") {
		return ((isset($arr) && isset($col)) ? ((gettype($arr) == "object") ? $arr->$col : ((gettype($arr == "array")) ? $arr[$col] : $default)) : $default);
	}
	public static function forSideBar() {
		$sql = "SELECT * FROM rssys.x05 ORDER BY pla, level ASC";
	}
	public static function x07x05tox06() {
		$x07 = DB::table(DB::raw('rssys.x07'))->get();
		$x05 = DB::table(DB::raw('rssys.x05'))->get();
		foreach($x07 AS $sEach) {
			foreach($x05 AS $fEach) {
				if(count(DB::table(DB::raw('rssys.x06'))->where([['grp_id', $sEach->grp_id], ['mod_id', $fEach->mod_id]])->get()) < 1) { DB::table(DB::raw('rssys.x06'))->insert([
						'grp_id'=>$sEach->grp_id,
						'mod_id'=>$fEach->mod_id,
						'restrict'=>'Y',
						'add'=>'Y',
						'upd'=>'Y',
						'cancel'=>'Y',
						'print'=>'Y'
					]);
				}
			}
		}
		return true;
	}
	public static function getTotalByColumn($arr = [], $col = "") {
		$retAmount = 0;
		if(count($arr)) { foreach($arr AS $each) { $eachAmount = self::retColArr($each, $col, 0); $retAmount += $eachAmount; } }
		return $retAmount;
	}

	public static function getAllFrom($arg){
		if(!empty($arg)){
			$toReturn = DB::table($arg[0]);
			if(isset($arg[1])){
				$toReturn = $toReturn->where($arg[1]);
			}
			if(isset($arg[2])){
				$toReturn = $toReturn->select($arg[2]);
			}
			if(isset($arg[3])){
				$toReturn = $toReturn->distinct();
			}
			return $toReturn->get();
		}
		return null;
	}
}