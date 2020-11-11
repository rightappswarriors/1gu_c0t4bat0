<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Carbon\Carbon;

class Core extends Model
{
	public static function GetGroupRights()
	{
		if(Session::exists('grp_ri')){
			return Session::get('grp_ri');
		}
		return null;
	}
    // SQL
	public static function sql($sql)
	{	
		try {
			return DB::select(DB::raw($sql));
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	/* ---------- GET ----------*/
	// Get all data in a table
	public static function Get_Table($tbl_name)
	{
		try {
			return DB::table($tbl_name)->get();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	// Created Update function - Mhel Jan 10, 2019
	public static function getAll($table)
	{ 	// Table
		try 
		{
			if (isset($table)) {return DB::table(DB::raw($table))->get();}
		} 
		catch (Exception $e) 
		{
			// return $e->getMessage();
			return null;
		}
	}

	public static function isDataExistOn($table,$whereClause = [], $get = false){
    	/*
			whereClause = where Clause of query, in array form
			getAll($table,$select = '*',$whereClause = [],$distinct = null)
    	*/
    	if(isset($table) && !empty($whereClause)){
    		return ($get ? [DB::table($table)->where($whereClause)->exists(), self::getAll($table,'*',$whereClause,true)] : DB::table($table)->where($whereClause)->exists());
    	} else {
    		return 'Please check fields';
    	}
    }
    
	// Created Update function - Mhel Jan 10, 2019
	// Note: this is without WHERE option
	// SAMPLE for $tableToJoin = [['tbl'=>'rssys.m00', 'BLnk' => 'rssys.m01.accttype_code', 'ALnk' => 'rssys.m00.code']];
	public static function getAllLeftJoin($table, $tableToJoin = [])
	{
		try 
		{
			if (isset($table)) 
			{
				if (count($tableToJoin) > 0) 
				{
					$sql = 'SELECT * FROM '.$table;
					for ($i = 0; $i < count($tableToJoin); $i++) { 
						$sql = $sql.' LEFT JOIN '.$tableToJoin[$i]['tbl'].' ON '.$tableToJoin[$i]['BLnk'].' = '.$tableToJoin[$i]['ALnk'];
					}
					return DB::select(DB::raw($sql));
				}
			}
			return null;
		} 
		catch (Exception $e) 
		{
			return null;	
		}
	}
	// Created Update function - Mhel Jan 15, 2019
	// Note: this is with WHERE option
	public static function getWithPara($table, $cond = [])
	{
		try
		{
			if (!empty($table) && !empty($cond))
			{
				return DB::table(DB::raw($table))->where($cond['clm'], '=', $cond['data'])->get();
			} else {
				return null;
			}
		} catch (Exception $e) 
		{
			return null;
		}
	}
	// Created get function - Mhel Jan 22, 2019
	public static function getWithPara2($table, $cond = [])
	{
		try
		{
			if (!empty($table) && !empty($cond))
			{
				return DB::table(DB::raw($table))->where($cond['clm'], $cond['typ'], $cond['data'])->get();
			} else {
				return null;
			}
		} catch (Exception $e) 
		{
			return null;
		}
	}
	// Created get function One Column
	public static function getOneColumn($table, $clm, $cond)
	{
		try
		{
			if (!empty($table) && !empty($clm) && !empty($clm)) 
			{
				return DB::table(DB::raw($table))->where($cond)->select($clm)->first();
			}
			return null;
		}
		catch (Exception $e) 
		{
			return null;
		}
	}
	// Created Update function - Mhel Jan 15, 2019
	// Note: for m99, clm = column
	public static function getm99One($clm)
	{
		try
		{
			if (!empty($clm))
			{
				$data =  DB::table(DB::raw('rssys.m99'))->select('rssys.m99.'.$clm)->first();
				return $data;
			} else {
				return null;
			}
		}
		catch (Exception $e)
		{
			return null;
		}
	}
	// Created Update function - Reancy Jan 16, 2019
	public static function get_nextincrementlimitchar($val = "", $limit = 0) {
		/*
			The parameter "$val" is from getm99One and "$limit" is character limit.
			- By Paolo Feb 8, 2019
		*/
	   $newvalue = ""; $len = strlen($val); $vsplit = str_split($val);
	   if(count($vsplit) > 0) { foreach($vsplit AS $a => $b) {
	       $vsplit[$a] = intval($b);
	   } }
	   $newvalue = intval(join("", $vsplit)) + 1; $vsplit = str_split($newvalue);
	   $appstr = ""; $newlimit = $limit - count($vsplit);
	   if($newlimit > 0) { for($i = 0; $i < $newlimit; $i++) {
	       $appstr .= "0";
	   } }
	   $newvalue = $appstr . $newvalue;
	   return $newvalue;
	}
	/* ---------- GET ----------*/
	/* ---------- INSERT ---------------------------------------------------*/
	// Created Update function - Mhel Jan 10, 2019
	// 
	public static function insertTable($table, $data = [], $module = null)
	{	// Table, Data
		try 
		{
			if ($table!=null) {
				if (!empty($data)) {
					if (DB::table(DB::raw($table))->insert($data)) {
						if(isset($module)){
							Core::alert(1, 'addition of  data in '.$module);
						}
						return true;
					}
				}
			}
			Core::alert(2, 'occured upon addition of data in '.$module);
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Core::alert(0, '');
			return false;
		}
	}
	// Modified Insert function - Mhel Jan 10, 2019
	/* ---------- INSERT ---------------------------------------------------*/
	/* ---------- UPDATE ---------------------------------------------------*/
	// Created Update function - Mhel Jan 10, 2019
	public static function updateTable($table, $col, $id, $data = [], $module)
	{	// Table, Primary Key, ID, Data, Module
		try 
		{
			if (isset($table) && isset($col) && isset($id) ) 
			{
				if (!empty($data)) 
				{
					if (DB::table(DB::raw($table))->where($col, '=', $id)->update($data)) 
					{
						if (isset($module)) {
							Core::alert(1, 'modified  data in '.$module);
						}
						return true;
					}
				}
			}
			if (isset($module)) {
			Core::alert(2, 'occured upon modiification of data in '.$module);
			}
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Core::alert(0, '');
			return false;
		}
	}
	// Created Update function - Mhel Jan 16, 2019
	public static function updatem99($clm, $val)
	{
		try
		{
			//return DB::table(DB::raw('rssys.m99'))->update([$clm => $val]);

			if(DB::table(DB::raw('rssys.m99'))->update([$clm => $val]))
			{
				return true;
			}
			else
			{
				return false;
			}

		}
		catch (Exception $e) {
			Core::alert(0, '');
			return false;
		}
	}
	/* ---------- UPDATE ---------------------------------------------------*/
	/* ---------- DELETE ---------------------------------------------------*/
	// Created Delete function - Mhel Jan 10, 2019
	public static function deleteTable($table, $col, $id, $module)
	{	// Table, Primary Key, ID
		try 
		{
			if (isset($table) && isset($col) && isset($id)) 
			{
				if (DB::table(DB::raw($table))->where($col, '=', $id)->delete())
				{
					Core::alert(1, 'deleted  data in '.$module);
					return true;
				}
			}
			Core::alert(2, 'occured upon deletion of data in '.$module);
			return false;
		}
		catch (Exception $e)
		{
			Core::alert(0, '');
			return false;
		}
	}
	// Created Delete Function - Mhel Jan 22, 2019
	// Multiple Where
	public static function deleteTableMultiWhere($table, $data = [], $module)
	{
		try
		{
			if (isset($table) && isset($data) && isset($module))
			{
				if (DB::table(DB::raw($table))->where($data)->delete())
				{
					Core::alert(1, 'deleted  data in '.$module);
					return true;
				}
			}
			Core::alert(2, 'occured upon deletion of data in '.$module);
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Core::alert(0, '');
			return false;
		}
	}
	/* ---------- DELETE ---------------------------------------------------*/
	/* ---------- MISCELLANEOUS ---------------------------------------------------*/
	// Return Alert Tag by Paolo Jan 2019
	public static function alert($type, $msg)
	{
		switch ($type) {
			case 1:
				// Success
				$str = "Success";
				$color = "success";
				$temp = $msg;
				break;
			case 2:
				// Error
				$str = "Error";
				$color = "error";
				$temp = $msg;
				break;
			default: // Catch ERROR
				$str = "Error";
				$color = "error";
				$temp = 'has occured. Please contact the system administrator.';
				break;
		}
		/*$txt = '<div id="AlertDiv" class="alert alert-'.$color.'" id="alert" style="z-index:1000">
	        		<strong>'.$str.'!</strong> '.$temp.'<button type="button" class="close" data-dismiss="alert">&times;</button>
	     		</div><script>$(\'#AlertDiv\').fadeOut(5000);</script>';*/
	    // Session::flash('alert', $txt);
	    Session::flash('alert', [$str,$color,$temp]);
	    // return $txt;
	}
	// Return Date in Words
	public static function DateString($date)
	{
		$newD = Carbon::parse($date);
		return $newD->toFormattedDateString();
	}
	public static function convert_from_latin1_to_utf8_recursively($dat)
   {
      if (is_string($dat)) {
         return utf8_encode($dat);
      } elseif (is_array($dat)) {
         $ret = [];
         foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

         return $ret;
      } elseif (is_object($dat)) {
         foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

         return $dat;
      } else {
         return $dat;
      }
   }
	/* ---------- MISCELLANEOUS ---------------------------------------------------*/

	// added by Syrel, for returning last entry ID
	public static function insertTableGetlastId($table, $data = [], $module = null, $customReturn = false)
	{	// Table, Data
		try 
		{
			if ($table!=null) {
				if (!empty($data)) {
					$toReturnIfSuccess = DB::table(DB::raw($table))->insert($data);
					if ($toReturnIfSuccess) {
						if(isset($module)){
							Core::alert(1, 'addition of  data in '.$module);
						}
						return ($customReturn ? $data[$customReturn] : DB::getPdo()->lastInsertId());
					}
				}
			}
			Core::alert(2, 'occured upon addition of data in '.$module);
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Core::alert(0, '');
			return false;
		}
	}

	/** 
     * Increment code with string.
     * @param $val = string.
     * @param $limit = int.
     * note: return = string+numberOfInt ex. A00001
    */
	public static function get_nextincrementwithString($val, $limit)
    {
    	try
    	{
    	  preg_match("/([a-zA-Z]+)(\\d+)/", $val, $code);

          $codeInt = self::get_nextincrementlimitchar($code[2], $limit);
          $newCode = $code[1].$codeInt;
  
    	  return $newCode;
        }
        catch (\Exception $e)
        {
        	return $e->getMessage();
        }
    }

    public static function getBarangayName($code){
    	if(isset($code)){
    		// $test = substr($code, (array_count_values(str_split($code))['-'] <= 1 ? 0 : 3) ,2);
    		$test = (explode('-', $code)[1] ?? 0);
    		return (DB::table('rssys.barangay')->where('brgy_id',$test)->first()->brgy_name ?? 'Not Found');
    	}
    	return null;
    }

    protected static $moneyString = [ "first" => [ "0" => "", "1" => "One", "2" => "Two", "3" => "Three", "4" => "Four", "5" => "Five", "6" => "Six", "7" => "Seven", "8" => "Eight", "9" => "Nine" ], "second" => [ "10" => "Ten", "11" => "Eleven", "12" => "Twelve", "13" => "Thirteen", "14" => "Fourteen", "15" => "Fifteen", "16" => "Sixteen", "17" => "Seventeen", "18" => "Eighteen", "19" => "Nineteen", "20" => "Twenty", "30" => "Thirty", "40" => "Fourty", "50" => "Fifty", "60" => "Sixty", "70" => "Seventy", "80" => "Eighty", "90" => "Ninety" ], "every" => [ 3 => "Hundred" ], "count" => [ "", "Thousand", "Million", "Billion", "Trillion", "Quadrillion", "Quintillion", "Sextillion", "Septillion", "Octillion", "Nonillion", "Decillion", "Undecillion", "Duodecillion", "Tredecillion", "Quatttuor-decillion", "Quindecillion", "Sexdecillion", "Septen-decillion", "Octodecillion", "Novemdecillion", "Vigintillion", "Centillion" ] ];

    public static function moneyToString($money = "") 
    { 
    	try { 
    		   $sMoney = intval($money); 
    		   $mString = static::$moneyString; $retData = ""; 
    		   if(! empty($sMoney)) 
    		   { 
    		   		$nMoney = strrev($sMoney); 
    		   		$spMoney = str_split($nMoney, 3); 
    		   		for($i = 0; $i < count($spMoney); $i++) 
    		   		{ 
    		   			$thStr = strrev($spMoney[$i]); 
    		   			$mLen = strlen($thStr); 
    		   			$curStr = ""; 
    		   			switch($mLen) 
    		   			{ case 1: $curStr = $curStr . ' ' . $mString["first"][strval(substr($thStr, 0, 1))]; break; 
    		   			  case 2: if(isset($mString["second"][strval(substr($thStr, 0, 2))])) 
    		   			          { 
    		   			          	 $curStr = $curStr . ' ' . $mString["second"][strval(substr($thStr, 0, 2))]; 
    		   			          } 
    		   			          else 
    		   			          { 
    		   			          	 $curStr = $curStr . ' ' . $mString["second"][strval(intval(substr($thStr, 0, 1)) * 10)] . ' ' . $mString["first"][strval(substr($thStr, 1, 1))]; 
    		   			          } break; 
    		   			  case 3: if(isset($mString["every"][$mLen])) 
    		   			          { 
    		   			          	 $sStr = $mString["first"][strval(substr($thStr, 0, 1))]; 
    		   			          	 if(! empty($sStr)) 
    		   			          	 { $curStr = $curStr . ' ' . $sStr . ' ' . $mString["every"][$mLen]; } 
    		   			          } 
    		   			          if(isset($mString["second"][strval(substr($thStr, 1, 2))])) 
    		   			          { 
    		   			          	$curStr = $curStr . ' ' . $mString["second"][strval(substr($thStr, 1, 2))]; 
    		   			          } 
    		   			          else 
    		   			          { 
    		   			          	$curStr = $curStr . ' ' . ((isset($mString["second"][strval(intval(substr($thStr, 1, 1)) * 10)])) ? $mString["second"][strval(intval(substr($thStr, 1, 1)) * 10)] : ' ') . ' ' . ((isset($mString["first"][strval(substr($thStr, 2, 1))])) ? $mString["first"][strval(substr($thStr, 2, 1))] : ' '); 
    		   			          } 
    		   			          break; 
    		   			  default: break; 
    		   			} 
    		   			$retData = $curStr . ' ' . $mString["count"][$i] . $retData; 
    		        } 
    		   } 
    		   return trim($retData); 
        } catch (Exception $e) { return $e; } 
   }

}
