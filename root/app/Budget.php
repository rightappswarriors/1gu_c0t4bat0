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
			$sql = 'SELECT * FROM rssys.bgtps02 WHERE b_num = \''.$code.'\' ORDER BY CAST(seq_num as integer)';

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
    		$sql = "SELECT *, CASE WHEN at_desc IN (SELECT DISTINCT subppa FROM rssys.bgtps02 WHERE b_num = '".$code."' AND COALESCE(subppa, '') != '') THEN 'Y' ELSE 'N' END as isspa FROM rssys.bgtps02 WHERE b_num = '".$code."'";

    		return DB::select(DB::raw($sql));
    	}
    	catch (\Exception $e) {
			return $e->getMessage();
		}
    }

    public static function printApproHdrAll($fy, $fid)
    {
        try
        {
            $sql = 'SELECT bt1.b_num, f.fdesc as fund, ft.funcid, ft.funcdesc as function, m8.cc_code as office_code, m8.cc_desc as office FROM rssys.bgtps01 bt1 LEFT JOIN rssys.fund f ON bt1.fid = f.fid LEFT JOIN rssys.function ft ON bt1.funcid = ft.funcid LEFT JOIN rssys.m08 m8 ON bt1.cc_code = m8.cc_code WHERE bt1.fy = \''.$fy.'\' AND bt1.fid = \''.$fid.'\'';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function printApproLineAll($fy, $fid)
    {
        try
        {
            $sql = 'SELECT bgt2.b_num, bgt2.at_code, bgt2.at_desc, bgt2.appro_amnt, bgt2.grpid FROM rssys.bgtps02 bgt2 LEFT JOIN rssys.bgtps01 bgt1 ON bgt2.b_num = bgt1.b_num WHERE bgt1.fy = \''.$fy.'\' AND bgt1.fid = \''.$fid.'\' ORDER BY CAST(bgt2.seq_num as integer)';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function printApproFuncAll($fy, $fid)
    {
        try
        {
            $sql = 'SELECT b1.funcid, f.funcdesc FROM rssys.bgtps01 b1 LEFT JOIN rssys.function f ON b1.funcid = f.funcid WHERE b1.fy = \''.$fy.'\' AND b1.fid = \''.$fid.'\' GROUP BY b1.funcid, f.funcdesc ORDER BY b1.funcid';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function printApproPPAAll($fy, $fid)
    {
        try
        {
            $sql = 'SELECT bt2.grpid, ps.subgrpdesc, bt2.b_num FROM rssys.bgtps02 bt2 LEFT JOIN rssys.ppasubgrp ps ON bt2.grpid = ps.subgrpid LEFT JOIN rssys.bgtps01 bt1 ON bt2.b_num = bt1.b_num WHERE bt1.fy = \''.$fy.'\' AND bt1.fid = \''.$fid.'\' GROUP BY bt2.grpid, ps.seq, ps.subgrpdesc, bt2.b_num ORDER BY ps.seq';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function printApproAll($fy, $fid)
    {
        try
        {
            $sql = 'SELECT f.fdesc as fund, ft.funcid, ft.funcdesc as function, m8.cc_code as office_code, m8.cc_desc as office, bgt2.b_num, bgt2.seq_num, bgt2.at_code, bgt2.at_desc, bgt2.appro_amnt, bgt2.grpid as ppa_code, ps.subgrpdesc as ppa FROM rssys.bgtps02 bgt2 LEFT JOIN rssys.bgtps01 bgt1 ON bgt2.b_num = bgt1.b_num LEFT JOIN rssys.fund f ON bgt1.fid = f.fid LEFT JOIN rssys.function ft ON bgt1.funcid = ft.funcid LEFT JOIN rssys.m08 m8 ON bgt1.cc_code = m8.cc_code LEFT JOIN rssys.ppasubgrp ps ON bgt2.grpid = ps.subgrpid WHERE bgt1.fy = \''.$fy.'\' AND bgt1.fid = \''.$fid.'\' ORDER BY ft.funcid, m8.cc_code, ps.seq';

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

    public static function generateSAAOBHdr($fy, $fund)
    {
        try
        {
            $sql = 'SELECT hb.fund, hb.funcid, hb.function, hb.office_code, hb.office FROM ((SELECT f.fdesc as fund, ft.funcid, ft.funcdesc as function, m8.cc_code as office_code, m8.cc_desc as office FROM rssys.bgtps01 bt1 LEFT JOIN rssys.fund f ON bt1.fid = f.fid LEFT JOIN rssys.function ft ON bt1.funcid = ft.funcid LEFT JOIN rssys.m08 m8 ON bt1.cc_code = m8.cc_code WHERE bt1.fy = \''.$fy.'\' AND bt1.fid = \''.$fund.'\') UNION ALL (SELECT f.fdesc as fund, ft.funcid, ft.funcdesc as function, m8.cc_code as office_code, m8.cc_desc as office FROM rssys.bgt01 bt1 LEFT JOIN rssys.fund f ON bt1.fid = f.fid LEFT JOIN rssys.function ft ON bt1.funcid = ft.funcid LEFT JOIN rssys.m08 m8 ON bt1.cc_code = m8.cc_code WHERE bt1.fy = \''.$fy.'\' AND bt1.fid = \''.$fund.'\') UNION ALL (SELECT f.fdesc as fund, ft.funcid, ft.funcdesc as function, m8.cc_code as office_code, m8.cc_desc as office FROM rssys.obrhdr oh LEFT JOIN rssys.fund f ON oh.fid = f.fid LEFT JOIN rssys.function ft ON oh.funcid = ft.funcid LEFT JOIN rssys.m08 m8 ON oh.cc_code = m8.cc_code WHERE SUBSTRING(CAST(oh.t_date as text),0,5) = \''.$fy.'\' AND oh.fid = \''.$fund.'\')) as hb GROUP BY hb.fund, hb.funcid, hb.function, hb.office_code, hb.office ORDER BY office_code';

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function printSAAOBLine($fy, $fid, $mo1, $mo2)
    {
        try
        {
            // $sql = 'SELECT approln.b_num, approln.at_code, approln.at_desc, approln.appro_amnt, allot.allot_amnt, obl.amount as obr, approln.grpid FROM rssys.bgtps02 approln LEFT JOIN rssys.bgtps01 approhdr ON approln.b_num = approhdr.b_num LEFT JOIN rssys.bgt02 allot ON approln.at_code = allot.at_code LEFT JOIN rssys.obrlne obl ON approln.at_code = obl.at_code WHERE approhdr.fy = \''.$fy.'\' AND approhdr.fid = \''.$fid.'\' ORDER BY CAST(approln.seq_num as integer)';

            $sql = "SELECT approln.b_num, approln.at_code, approln.at_desc, approln.appro_amnt, CASE WHEN allot.allot_amnt isnull THEN 0.00 ELSE allot.allot_amnt END, CASE WHEN oblig.amount isnull THEN 0.00 ELSE oblig.amount END as obr, approln.grpid FROM rssys.bgtps02 approln LEFT JOIN rssys.bgtps01 approhd ON approln.b_num = approhd.b_num LEFT JOIN (SELECT * FROM rssys.bgt02 bgt2 LEFT JOIN rssys.bgt01 bgt1 ON bgt2.b_num = bgt1.b_num WHERE bgt1.fy = '".$fy."' AND bgt1.fid = '".$fid."' AND bgt1.mo1 = '".$mo1."' AND bgt1.mo2 = '".$mo2."') allot ON approln.at_code = allot.at_code LEFT JOIN (SELECT * FROM rssys.obrlne ob2 LEFT JOIN rssys.obrhdr ob1 ON CAST(ob2.obr_code as integer) = ob1.obr_pk WHERE EXTRACT(YEAR FROM ob1.t_date) = '".$fy."' AND ob1.fid = '".$fid."' AND EXTRACT(MONTH FROM t_date) BETWEEN '".$mo1."' AND '".$mo2."') as oblig ON approln.at_code = oblig.at_code WHERE approhd.fy = '".$fy."' AND approhd.fid = '".$fid."' AND approhd.cc_code != 'SPA' ORDER BY CAST(approln.seq_num as integer)";

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function printSAAOBSPALine($fy, $fid, $mo1, $mo2)
    {
        try
        {
            $sql = "SELECT approln.b_num, approln.at_code, approln.at_desc, approln.appro_amnt, CASE WHEN allot.allot_amnt isnull THEN 0.00 ELSE allot.allot_amnt END, CASE WHEN oblig.amount isnull THEN 0.00 ELSE oblig.amount END as obr, approln.grpid, CASE WHEN approln.at_desc IN (SELECT DISTINCT(subppa) FROM rssys.bgtps02 b2 LEFT JOIN rssys.bgtps01 b1 ON b2.b_num = b1.b_num WHERE b1.fy = '".$fy."' AND b1.fid = '".$fid."' AND b1.cc_code = 'SPA' AND COALESCE(b2.subppa, '') != '') THEN 'Y' ELSE 'N' END AS isspa FROM rssys.bgtps02 approln LEFT JOIN rssys.bgtps01 approhd ON approln.b_num = approhd.b_num LEFT JOIN (SELECT * FROM rssys.bgt02 bgt2 LEFT JOIN rssys.bgt01 bgt1 ON bgt2.b_num = bgt1.b_num WHERE bgt1.fy = '".$fy."' AND bgt1.fid = '".$fid."' AND bgt1.mo1 = '".$mo1."' AND bgt1.mo2 = '".$mo2."') allot ON approln.at_code = allot.at_code LEFT JOIN (SELECT * FROM rssys.obrlne ob2 LEFT JOIN rssys.obrhdr ob1 ON CAST(ob2.obr_code as integer) = ob1.obr_pk WHERE EXTRACT(YEAR FROM ob1.t_date) = '".$fy."' AND ob1.fid = '".$fid."' AND EXTRACT(MONTH FROM t_date) BETWEEN '".$mo1."' AND '".$mo2."') as oblig ON approln.at_code = oblig.at_code WHERE approhd.fy = '".$fy."' AND approhd.fid = '".$fid."' AND approhd.cc_code = 'SPA' ORDER BY CAST(approln.seq_num as integer)";

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /* 
     * Get description of fund using fid.
     */
    public static function printSAAOBGetFund($code)
    {
        try
        {
            $sql = 'SELECT * FROM rssys.fund WHERE fid = \''.$code.'\' LIMIT 1';

            return DB::select(DB::raw($sql))[0];
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /*
     * Get SAAOB Header.
     */
    public static function printSAAOBHdr($fy, $fid)
    {
        try
        {
            //$sql = 'SELECT bt1.b_num, f.fdesc as fund, ft.funcid, ft.funcdesc as function, m8.cc_code as office_code, m8.cc_desc as office FROM rssys.bgtps01 bt1 LEFT JOIN rssys.fund f ON bt1.fid = f.fid LEFT JOIN rssys.function ft ON bt1.funcid = ft.funcid LEFT JOIN rssys.m08 m8 ON bt1.cc_code = m8.cc_code WHERE bt1.fy = \''.$fy.'\' AND bt1.fid = \''.$fid.'\' ORDER BY office_code';

            $sql = "SELECT bt1.b_num, f.fdesc as fund, ft.funcid, ft.funcdesc as function, m8.cc_code as office_code, m8.cc_desc as office FROM rssys.bgtps01 bt1 LEFT JOIN rssys.fund f ON bt1.fid = f.fid LEFT JOIN rssys.function ft ON bt1.funcid = ft.funcid LEFT JOIN rssys.m08 m8 ON bt1.cc_code = m8.cc_code WHERE bt1.fy = '".$fy."' AND bt1.fid = '".$fid."' AND bt1.cc_code != 'SPA' ORDER BY office_code";

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function printSAAOBSPAHdr($fy, $fid)
    {
        try
        {
            $sql = "SELECT b1.secid, s.secdesc, b1.b_num FROM rssys.bgtps01 b1 LEFT JOIN rssys.sector s ON b1.secid = s.secid WHERE b1.fy = '".$fy."' AND b1.fid = '".$fid."' AND b1.cc_code = 'SPA'";

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /*
     * Get SAAOB Function.
     */
    public static function printSAAOBFunc($fy, $fid)
    {
        try
        {
            $sql = "SELECT b1.funcid, f.funcdesc FROM rssys.bgtps01 b1 LEFT JOIN rssys.function f ON b1.funcid = f.funcid WHERE b1.fy = '".$fy."' AND b1.fid = '".$fid."' AND b1.cc_code != 'SPA' GROUP BY b1.funcid, f.funcdesc ORDER BY b1.funcid";

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /*
     * Get SAAOB PPA.
     */
    public static function printSAAOBPPA($fy, $fid)
    {
        try
        {
            $sql = "SELECT bt2.grpid, ps.subgrpdesc, bt2.b_num FROM rssys.bgtps02 bt2 LEFT JOIN rssys.ppasubgrp ps ON bt2.grpid = ps.subgrpid LEFT JOIN rssys.bgtps01 bt1 ON bt2.b_num = bt1.b_num WHERE bt1.fy = '".$fy."' AND bt1.fid = '".$fid."' AND bt1.cc_code != 'SPA' GROUP BY bt2.grpid, ps.seq, ps.subgrpdesc, bt2.b_num ORDER BY ps.seq";

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function printSAAOBSPAPPA($fy, $fid)
    {
        try
        {
            $sql = "SELECT bt2.grpid, ps.subgrpdesc, bt2.b_num FROM rssys.bgtps02 bt2 LEFT JOIN rssys.ppasubgrp ps ON bt2.grpid = ps.subgrpid LEFT JOIN rssys.bgtps01 bt1 ON bt2.b_num = bt1.b_num WHERE bt1.fy = '".$fy."' AND bt1.fid = '".$fid."' AND bt1.cc_code = 'SPA' GROUP BY bt2.grpid, ps.seq, ps.subgrpdesc, bt2.b_num ORDER BY ps.seq";

            return DB::select(DB::raw($sql));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
