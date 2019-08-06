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
    		$sql = 'SELECT f.fdesc as fund, ft.funcid, ft.funcdesc as function, m8.cc_code as office_code, m8.cc_desc as office FROM rssys.bgtps01 bt1 LEFT JOIN rssys.fund f ON bt1.fid = f.fid LEFT JOIN rssys.function ft ON bt1.funcid = ft.funcid LEFT JOIN rssys.m08 m8 ON bt1.cc_code = m8.cc_code WHERE bt1.b_num = \''.$code.'\' LIMIT 1';

    		return DB::select(DB::raw($sql))[0];
    	}
    	catch (\Exception $e) {
			return $e->getMessage();
		}
    }

    public static function printApproPPA($code)
    {
    	try
    	{
    		$sql = 'SELECT ps.*, SUM(bt.appro_amnt) as total_amt FROM rssys.bgtps02 bt LEFT JOIN rssys.ppasubgrp ps ON bt.grpid = ps.subgrpid WHERE bt.b_num = \''.$code.'\' GROUP BY ps.subgrpid ORDER BY ps.seq';

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

    public static function getX03()
    {
        try
        {
            $sql = 'SELECT DISTINCT(fy) FROM rssys.x03 ORDER BY fy';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function loadDataFromApproHeader($fy)
    {
        try
        {
            $sql = 'SELECT fy, b_num, cc_code, fid, secid, funcid FROM rssys.bgtps01 WHERE fy = \''.$fy.'\' ORDER BY CAST(b_num as integer)';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function loadDataFromApproLine($b_num)
    {
        try
        {
            $sql = 'SELECT b_num, seq_num, at_code, appro_amnt, grpid FROM rssys.bgtps02 WHERE b_num = \''.$b_num.'\' ORDER BY CAST(seq_num as integer)';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function loadDataFromObligHeader()
    {
        try
        {
            $sql = 'SELECT SUBSTRING(CAST(t_date as text),0,5) as fy, cc_code, fid, secid, funcid, obr_pk, t_date FROM rssys.obrhdr ORDER BY obr_pk';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function loadDataFromObligLine($obr_pk)
    {
        try
        {
            $sql = 'SELECT obr_code, seq_num, at_code, amount, fpp FROM rssys.obrlne WHERE obr_code = \''.$obr_pk.'\' ORDER BY CAST(seq_num as integer)';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getAtCCCodeAppro()
    {
        try
        {
            $sql = 'SELECT bt2.at_code, bt1.cc_code FROM rssys.bgtps02 bt2 LEFT JOIN rssys.bgtps01 bt1 ON bt2.b_num = bt1.b_num GROUP BY bt2.at_code, bt1.cc_code ORDER BY at_code';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getFund()
    {
        try
        {
            $sql = 'SELECT * FROM rssys.fund WHERE active = true';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getAmtAppro($fy, $at_code, $cc_code)
    {
        try
        {
            $sql = 'SELECT appro_amnt FROM rssys.bgtps02 bt2 LEFT JOIN rssys.bgtps01 bt1 ON bt2.b_num = bt1.b_num WHERE bt2.at_code = \''.$at_code.'\' AND bt1.cc_code = \''.$cc_code.'\' AND bt1.fy = \''.$fy.'\' ORDER BY bt1.b_num';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getDataManualAppro($fy, $at_code, $cc_code)
    {
        try
        {
            $sql = 'SELECT bt1.fy, bt1.fid, bt1.secid, bt1.funcid, bt1.b_num, bt2.at_code, bt2.appro_amnt, bt2.grpid FROM rssys.bgtps02 bt2 LEFT JOIN rssys.bgtps01 bt1 ON bt2.b_num = bt1.b_num WHERE bt2.at_code = \''.$at_code.'\' AND bt1.cc_code = \''.$cc_code.'\' AND bt1.fy = \''.$fy.'\' ORDER BY bt1.b_num';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function get_AllotHeader()
    {
        try
        {
            $sql = 'SELECT fy, b_num, m8.cc_desc as office, f.fdesc as fund, s.secdesc as sector, ft.funcdesc as function, bt1.type FROM rssys.bgt01 bt1 LEFT JOIN rssys.m08 m8 ON bt1.cc_code = m8.cc_code LEFT JOIN rssys.fund f ON bt1.fid = f.fid LEFT JOIN rssys.sector s ON bt1.secid = s.secid LEFT JOIN rssys.function ft ON bt1.funcid  = ft.funcid ORDER BY b_num';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function printAllotHdr($code)
    {
        try
        {
            $sql = 'SELECT f.fdesc as fund, ft.funcid, ft.funcdesc as function, m8.cc_code as office_code, m8.cc_desc as office, bt1.type FROM rssys.bgt01 bt1 LEFT JOIN rssys.fund f ON bt1.fid = f.fid LEFT JOIN rssys.function ft ON bt1.funcid = ft.funcid LEFT JOIN rssys.m08 m8 ON bt1.cc_code = m8.cc_code WHERE bt1.b_num = \''.$code.'\' LIMIT 1';

            return DB::select(DB::raw($sql))[0];
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function printAllotLine($code)
    {
        try
        {
            //$sql = 'SELECT * FROM rssys.bgt02 WHERE b_num = \''.$code.'\' ORDER BY CAST(seq_num as integer)';

            $sql = 'SELECT bt2.*, m4.at_desc FROM rssys.bgt02 bt2 LEFT JOIN rssys.m04 m4 ON bt2.at_code = m4.at_code WHERE b_num = \''.$code.'\' ORDER BY CAST(seq_num as integer)';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function printAllotPPA($code)
    {
        try
        {
            $sql = 'SELECT ps.*, SUM(bt.appro_amnt) as total_approamt, SUM(bt.allot_amnt) as total_allotamt, SUM(bt.oblig_amnt) as total_obligamt FROM rssys.bgt02 bt LEFT JOIN rssys.ppasubgrp ps ON bt.grpid = ps.subgrpid WHERE bt.b_num = \''.$code.'\' GROUP BY ps.subgrpid ORDER BY ps.seq';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
