<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Carbon\Carbon;
use Core;

class Budget extends Model
{
    public static function checkIfApproExist($data) // items with qty
    {
        try 
		{
			$flag = 'false';
			$b_num = '';
			$ln_num = '';
			$returnData = ['flag' => $flag, 'b_num' => $b_num, 'ln_num' => $ln_num];
			
			$checkifExist = DB::select(DB::raw('SELECT COUNT(*) FROM rssys.bgtps01 WHERE fy = \''.$data[0].'\' AND cc_code = \''.$data[1].'\' AND fid = \''.$data[2].'\' AND secid = \''.$data[3].'\' AND funcid = \''.$data[4].'\''))[0];

            if($checkifExist->count > 0)
            {
               $flag = 'true';
               $b_num = DB::select(DB::raw('SELECT b_num FROM rssys.bgtps01 WHERE fy = \''.$data[0].'\' AND cc_code = \''.$data[1].'\' AND fid = \''.$data[2].'\' AND secid = \''.$data[3].'\' AND funcid = \''.$data[4].'\' ORDER BY sysdate, systime LIMIT 1'))[0];
               $ln_num = DB::select(DB::raw('SELECT MAX(CAST(seq_num as INTEGER)) + 1 as seq_num FROM rssys.bgtps02 WHERE b_num = \''.$b_num->b_num.'\''))[0];

               $returnData = ['flag' => $flag, 'b_num' => $b_num->b_num, 'ln_num' => $ln_num->seq_num];
            }

			return $returnData;
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
    }

    public static function get_approHeader($code)
    {
    	try 
		{
			$sql = 'SELECT * FROM rssys.bgtps01 WHERE b_num = \''.$code.'\' LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
    }

    public static function get_approLine($code)
    {
    	try 
		{
			$sql = 'SELECT * FROM rssys.bgtps02 WHERE b_num = \''.$code.'\'';

			return DB::select(DB::raw($sql));
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
    }

    public static function get_AcctRemarks($code)
    {
    	try 
		{
			$sql = 'SELECT remarks FROM rssys.m04 WHERE at_code = \''.$code.'\' LIMIT 1';

			return DB::select(DB::raw($sql));
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
    }

    public static function get_AcctCode($at_desc)
    {
    	try 
		{
			$sql = 'SELECT at_code FROM rssys.m04 WHERE at_desc = \''.$at_desc.'\' LIMIT 1';

			return DB::select(DB::raw($sql));
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
    }

    public static function printApproHdr($code)
    {
    	try
    	{
    		$sql = 'SELECT f.fdesc as fund, ft.funcdesc as function, m8.cc_desc as office FROM rssys.bgtps01 bt1 LEFT JOIN rssys.fund f ON bt1.fid = f.fid LEFT JOIN rssys.function ft ON CAST(bt1.funcid as integer) = ft.funcid LEFT JOIN rssys.m08 m8 ON bt1.cc_code = m8.cc_code WHERE bt1.b_num = \''.$code.'\' LIMIT 1';

    		return DB::select(DB::raw($sql)[0]);
    	}
    	catch (\Exception $e) {
			return $e->getMessage();
		}
    }

    public static function printApproPPA($code)
    {
    	try
    	{
    		$sql = 'SELECT ps.* FROM rssys.bgtps02 bt LEFT JOIN rssys.ppasubgrp ps ON bt.grpid = ps.subgrpid WHERE bt.b_num = \''.$code.'\' GROUP BY ps.subgrpid';

    		return DB::select(DB::raw($sql));
    	}
    	catch (\Exception $e) {
			return $e->getMessage();
		}
    }

    public static function printApproLine($code)
    {
    	try
    	{
    		$sql = 'SELECT * FROM rssys.bgtps02 WHERE b_num = \''.$code.'\' ORDER BY CAST(seq_num as integer)';

    		return DB::select(DB::raw($sql));
    	}
    	catch (\Exception $e) {
			return $e->getMessage();
		}
    }
}
