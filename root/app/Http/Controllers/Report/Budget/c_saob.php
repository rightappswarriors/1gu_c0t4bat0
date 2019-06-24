<?php

namespace App\Http\Controllers\Report\Budget;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use Carbon\Carbon;
class c_saob extends Controller
{
	public function __construct()
    {
    	$this->fund = Core::getAll('rssys.fund');
    	$this->m04 = Core::getAll('rssys.m04');
    	$sql = "SELECT DISTINCT fy FROM rssys.x03 ORDER BY rssys.x03.fy ASC";
        $this->x03 = Core::sql($sql);
        $this->sector = Core::getAll('rssys.sector');
        $this->budget_period = Core::getAll('rssys.budget_period');
        // $this->	
    }
    public function view()
    {
    	// return dd($this->fund);
    	return view('report.budget.report_budget_saob', ['fund'=> $this->fund, 'x03' => $this->x03, 'sector' => $this->sector, 'budget_period' => $this->budget_period]);
    }
    public function GenerateSaob($fy, $mo, $fid)
    {
    	$sql =
    		"
				SELECT bp1.fy,  bp1.mo, approved_bgt.fid, bp1.b_num,bp1.t_date, bp1.t_desc, bp1.cc_code, costcenter.cc_desc, ps.subgrpid, ps.subgrpdesc, bp2.at_code, m4.at_desc, approved_bgt.sl_code,approved_bgt.sl_name, bp2.appro_amnt, approved_bgt.allot_amnt, obligation.debit AS oblig_amnt

				FROM rssys.bgtps01 bp1

				LEFT JOIN rssys.bgtps02 bp2 ON bp1.b_num=bp2.b_num
				LEFT JOIN rssys.ppasubgrp ps ON bp2.grpid=ps.subgrpid
				LEFT JOIN rssys.m04 m4 ON m4.at_code=bp2.at_code
				LEFT JOIN rssys.m08 costcenter ON costcenter.cc_code=bp1.cc_code

				LEFT JOIN (
					SELECT DISTINCT b1.bgtps_bnum, b1.fid, b1.b_num, b1.fy, b1.mo, b2.at_code, m4.at_desc, b2.sl_code, b2.sl_name, allot_amnt
					FROM rssys.bgt01 b1
					LEFT JOIN rssys.bgt02 b2 ON b1.b_num=b2.b_num
					LEFT JOIN rssys.m04 m4 ON m4.at_code=b2.at_code
					WHERE b1.fy='$fy' AND b1.mo='$mo'
					ORDER BY b1.b_num, b2.at_code) approved_bgt
				ON (approved_bgt.at_code=bp2.at_code AND approved_bgt.bgtps_bnum=bp1.b_num)

				LEFT JOIN (
					SELECT t1.fid, t1.bgt01_bnum, t2.at_code, t2.debit
					FROM rssys.tr01 t1
					LEFT JOIN rssys.tr02 t2 ON t1.j_num=t2.j_num AND t1.j_code=t2.j_code
					LEFT JOIN rssys.m04 m4 ON m4.at_code=t2.at_code
					WHERE t1.fy='$fy' AND t1.mo='$mo'
					ORDER BY t1.j_code, t1.j_num, t2.at_code) obligation
				ON obligation.fid=bp1.fid AND obligation.bgt01_bnum=approved_bgt.bgtps_bnum

				WHERE approved_bgt.fid='$fid' AND approved_bgt.fy='$fy' AND approved_bgt.mo='$mo' AND bp1.fy='$fy' AND bp1.mo='$mo'
				ORDER BY approved_bgt.fid, bp1.b_num, ps.subgrpid, bp2.seq_num
    		";

    	// $sql1 = "SELECT * FROM rssys.bgtps01 WHERE rssys.bgtps01.fy='$fid'AND rssys.bgtps01.mo = '$mo'";
    	// return dd(Core::sql($sql));
    	return view('report.budget.report_budget_saob_view');
    }

    public function proposal_view(Request $r)
    {
    	return view('report.budget.report_budget_proposal', ['fund'=> $this->fund, 'x03' => $this->x03, 'sector' => $this->sector, 'budget_period' => $this->budget_period]);
    }
}