<?php

namespace App\Http\Controllers\Budget;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use Carbon\Carbon;
class c_budget_approved_entry extends Controller
{
	public function __construct()
    {
    	$sql1 = "SELECT DISTINCT rssys.x03.fy FROM rssys.x03 ORDER BY rssys.x03.fy ASC";
        $this->x03 = Core::sql($sql1);
    	$this->fund = Core::getAll('rssys.fund');
    	$this->m08 = Core::getAll('rssys.m08');
    	$this->sector = Core::getAll('rssys.sector');
    	$this->branch = Core::getAll('rssys.branch');
    	$this->m04 = Core::getAll('rssys.m04');
    	$sql = 'SELECt * FROM rssys.ppasubgrp ORDER BY seq';
    	$this->ppa = Core::sql($sql);
        $sql2 = "SELECT * FROM rssys.budget_period ORDER BY budgetfrom ASC";
        $this->budget_period  = Core::sql($sql2);
    }

    public function view() // VIEW BUDGET ALLOTMENT ENTRIES MODULES
    {
    	$data = array($this->x03, $this->fund, $this->budget_period);
    	// return dd($data[2]);
    	return view('budget.budget_budget_approved_entry', compact('data'));
    }
    public function getEntries(Request $r) // GET EXISTING BUDGET ALLOTMENT ENTRIES MODULES
    {
        // $sql = "SELECT m04.at_code, m04.at_desc, budget.appro_amnt, budget.allot_amnt, budget.deduct FROM rssys.m04 INNER JOIN (SELECT proposal.b_num, proposal.at_code, proposal.appro_amnt, appro.allot_amnt, (proposal.appro_amnt - appro.allot_amnt) AS deduct FROM (SELECT bgtps02.* FROM rssys.bgtps01 INNER JOIN (SELECT SUM(appro_amnt) AS appro_amnt, at_code, b_num FROM rssys.bgtps02 GROUP BY at_code, b_num) bgtps02 ON bgtps01.b_num = bgtps02.b_num WHERE bgtps01.b_num = '$r->fid') proposal LEFT JOIN (SELECT bgt02.* FROM rssys.bgt01 INNER JOIN (SELECT SUM(allot_amnt) AS allot_amnt, at_code, b_num FROM rssys.bgt02 GROUP BY at_code, b_num) bgt02 ON bgt01.b_num = bgt02.b_num) appro ON (appro.b_num = proposal.b_num AND appro.at_code = proposal.at_code)) budget ON budget.at_code = m04.at_code";
    	// $year = explode('-', $r->prd)[0];
        // $month = explode('-', $r->prd)[1];
        // return $r;
    	$sql = "SELECT * FROM rssys.bgt01
                LEFT JOIN rssys.branch ON rssys.bgt01.branch = rssys.branch.code
                LEFT JOIN rssys.m08 ON rssys.bgt01.cc_code = rssys.m08.cc_code
                LEFT JOIN rssys.fund ON rssys.bgt01.fid = rssys.fund.fid
                LEFT JOIN rssys.sector ON rssys.bgt01.secid = rssys.sector.secid
                WHERE rssys.bgt01.fy = '$r->fy' AND 
                rssys.bgt01.mo1 = '$r->dt_frm' AND rssys.bgt01.mo2 ='$r->dt_to'
                    ORDER BY rssys.bgt01.b_num ASC";
    	$data = Core::sql($sql);
    	return $data;
    }
    public function getEntries2(Request $r) // GET EXISTING BUDGET APPROPRIATION ENTRIES  MODULES
    {
        $sql = "SELECT * FROM rssys.bgtps01
                LEFT JOIN rssys.branch ON rssys.bgtps01.branch = rssys.branch.code
                LEFT JOIN rssys.m08 ON rssys.bgtps01.cc_code = rssys.m08.cc_code
                LEFT JOIN rssys.fund ON rssys.bgtps01.fid = rssys.fund.fid
                LEFT JOIN rssys.sector ON rssys.bgtps01.secid = rssys.sector.secid
                WHERE rssys.bgtps01.fy = '$r->fy'
                -- AND
                -- rssys.bgtps01.mo BETWEEN '$r->dt_frm' AND '$r->dt_to'
                    ORDER BY rssys.bgtps01.b_num ASC";
        $data = Core::sql($sql);
        return $data;
    }
    public function approve($fy, $frm, $to) // VIEW NEW BUDGET ALLOTMENT ENTRY MODULE
    {
        // return dd($this->ppa);
        return view('budget.budget_budget_approved_entry_new', ['ppa' => $this->ppa, 'budget_period' => $this->budget_period, 'x03' => $this->x03, 'm04' => $this->m04,  'fy' => $fy, 'dt_frm' => $frm, 'dt_to' => $to]);
    }
    // public function new($fy, $mo, $fid)
    // {
    // 	$sql = "SELECT * FROM rssys.x03 WHERE rssys.x03.fy = '".$fy."' AND rssys.x03.mo = '".$mo."'";
    // 	$d1 = Core::sql($sql);
    // 	// return dd(0, 1, 2, 3, 4, 5, 6, 7);
    // 	$data = array($this->x03, $this->fund, $this->m08, $this->sector, $this->branch, $fy, $mo, $d1[0]->month_desc, $this->m04, $fid, $this->ppa);
    // 	// return dd($data[10]);
    // 	return view('budget.budget_budget_proposal_entry_new', compact('data'));
    // }
    public function save(Request $r) // ADD NEW BUDGET ALLOTMENT ENTRY MODULE
    {
        // return ($r);
    	$b_num = Core::getm99One('bgt01_bnum');
        // return dd($b_num);
    	$insertIntoBgt01 =
    		[
    			'fy' => $r->fy,
    			'mo' => 1,
    			'b_num' => $b_num->bgt01_bnum,
    			't_date' => $r->t_date,
    			't_desc' => strtoupper($r->t_desc),
    			'user_id' => strtoupper(Session::get('_user')['id']),
    			'branch' => '001',
    			'cc_code' => $r->cc_code,
    			'fid' => $r->fid,
    			'secid' => $r->secid,
                'bgtps_bnum' => $r->bgtps_bnum,
                'budget_period' => $r->budget_period,
                // 'mo1' => $r->mo1,
                // 'mo2' => $r->mo2,
    			// 'finalized' => 'N',
    			// 'closed' => 'N',
    		];
            // return dd($insertIntoBgt01);
            $dt = Carbon::now();
            // $UpdateIntoBgtps01 =
            // [
            //     'closed' => 'Y',
            //     'closed_date' => $dt->toDateString(),
            //     'closed_time' => $dt->toTimeString(),
            //     'closed_by' => strtoupper(Session::get('_user')['id']),
            // ];
            // if (Core::updateTable('rssys.bgtps01', 'b_num', $r->bgtps_bnum, $UpdateIntoBgtps01, 'Budget Proposal Entry'))
            // {
            // return dd(Core::insertTable('rssys.bgt01', $insertIntoBgt01, 'Budget Approval Entry'));
                if (Core::insertTable('rssys.bgt01', $insertIntoBgt01, 'Budget Approval Entry')) {
                  Core::updatem99('bgt01_bnum', Core::get_nextincrementlimitchar($b_num->bgt01_bnum, 8));
                 if (count($r->codes)) {
                     for ($i=0, $j = 1; $i < count($r->codes); $i++, $j++) {
                         $insertIntoBgt02 =
                             [
                                 'b_num' => $b_num->bgt01_bnum,
                                 'seq_num' => $j,
                                 'at_code' => $r->codes[$i],
                                 'sl_code' => '',
                                 'sl_name' => '',
                                 'allot_amnt' => floatval($r->amt[$i]),
                                 'grpid' => $r->subgrpid[$i],
                             ];
                         if (Core::insertTable('rssys.bgt02', $insertIntoBgt02, 'Budget Approval Entry')) {
                         } else {
                             return 'ERROR';
                             break;
                         }
                     }
                     return 'DONE';
                 }
                }
            // }
    	return 'ERROR';
    }
    public function save2(Request $r) // ADD NEW BUDGET ALLOTMENT ENTRY 2 MODULE
    {
        // return ($r->secid[0][0]);
        // return ($r);
        for ($k=0; $k < count($r->bgtps_bnum) ; $k++)
        {
            $b_num = Core::getm99One('bgt01_bnum');
            $dt = Carbon::now();
            $insertIntoBgt01 =
            [
                'fy' => $r->fy,
                'b_num' => $b_num->bgt01_bnum,
                'user_id' => strtoupper(Session::get('_user')['id']),
                'branch' => '001',
                'cc_code' => $r->cc_code[$k],
                'fid' => $r->fid[$k],
                'secid' => $r->secid[$k],
                'bgtps_bnum' => $r->bgtps_bnum[$k],
                'systime' => $dt->toTimeString(),
                'sysdate' => $dt->toDateString(),
                'ref_num' => $r->ref_num[$k],
                'mo1' => $r->mo1,
                'mo2' => $r->mo2,
                // 'finalized' => 'N',
                // 'closed' => 'N',
            ];
            if (Core::insertTable('rssys.bgt01', $insertIntoBgt01, 'Budget Approval Entry'))
            {
                Core::updatem99('bgt01_bnum', Core::get_nextincrementlimitchar($b_num->bgt01_bnum, 8));
                if (count($r->codes[$k])) {
                    for ($i=0, $j = 1; $i < count($r->codes[$k]); $i++, $j++) {
                        $insertIntoBgt02 =
                            [
                                'b_num' => $b_num->bgt01_bnum,
                                'seq_num' => $j,
                                'at_code' => $r->codes[$k][$i],
                                'sl_code' => '',
                                'sl_name' => '',
                                'allot_amnt' => floatval($r->amt[$k][$i]),
                                'grpid' => $r->subgrpid[$k][$i],
                            ];
                        if (Core::insertTable('rssys.bgt02', $insertIntoBgt02, 'Budget Approval Entry')) {
                        } else {
                            return 'ERROR';
                            break;
                        }
                    // return 'DONE';
                    }
                }
            } else {
                return 'ERROR';
            }
            // return 'DONE';
        }
        return 'DONE';
    }
    public function edit($b_num) // VIEW EXISTING BUDGET ALLOTMENT ENTRY MODULE
    {
    	$sql1 = 'SELECT * FROM rssys.bgt01
				LEFT JOIN rssys.branch ON rssys.bgt01.branch = rssys.branch.code
				LEFT JOIN rssys.m08 ON rssys.bgt01.cc_code = rssys.m08.cc_code
				LEFT JOIN rssys.fund ON rssys.bgt01.fid = rssys.fund.fid
				LEFT JOIN rssys.sector ON rssys.bgt01.secid = rssys.sector.secid
                LEFT JOIN rssys.budget_period ON rssys.bgt01.budget_period = rssys.budget_period.budget_code
				WHERE rssys.bgt01.b_num = \''.$b_num.'\'
    			';
    	$sql2 = 'SELECT * FROM rssys.bgt02
    			LEFT JOIN rssys.m04 ON rssys.bgt02.at_code = rssys.m04.at_code
    			LEFT JOIN rssys.ppasubgrp ON rssys.bgt02.grpid = rssys.ppasubgrp.subgrpid
    			WHERE rssys.bgt02.b_num = \''.$b_num.'\'
    			ORDER BY rssys.bgt02.seq_num ASC
    			';
        // $sql4 = 'SELECT'
    	$d1 = Core::sql($sql1);
    	$d2 = Core::sql($sql2);
    	$sql3 = "SELECT * FROM rssys.x03 WHERE rssys.x03.fy = '".$d1[0]->fy."' AND rssys.x03.mo = '".$d1[0]->mo."'";
    	$d3 = Core::sql($sql3);
    	return view('budget.budget_budget_approved_entry_view', ['fund'=> $this->fund, 'm08' => $this->m08, 'sector' => $this->sector, 'branch' => $this->branch, 'm04' => $this->m04, 'ppa' => $this->ppa, 'bgt01' => $d1[0], 'bgt02' => $d2, 'mo_desc' => '', 'budget_period' => $this->budget_period]);
    }
    public function update(Request $r) // UPDATE EXISTING BUDGET ALLOTMENT ENTRY MODULE
    {
        if ($r->sel_mod == '0')
        {
            $insertIntoBgtps01 =
            [
                'fy' => $r->fy,
                'mo' => $r->mo,
                // 't_date' => $r->t_date,
                't_desc' => strtoupper($r->t_desc),
                'user_id' => strtoupper(Session::get('_user')['id']),
                'branch' => $r->brid,
                'cc_code' => $r->cc_code,
                'fid' => $r->fid,
                'secid' => $r->secid,
            ];
            // return $insertIntoBgtps01;
            $del = [['b_num', '=', $r->b_num]];
            Core::deleteTableMultiWhere('rssys.bgtps02', $del, 'Budget Proposal Entry' );
            if (Core::updateTable('rssys.bgtps01', 'b_num', $r->b_num, $insertIntoBgtps01, 'Budget Proposal Entry')) 
            {
                if (count($r->codes)) {
                    for ($i=0, $j = 1; $i < count($r->codes); $i++, $j++) {
                        $insertIntoBgtps02 =
                            [
                                'b_num' => $r->b_num,
                                'seq_num' => $j,
                                'at_code' => $r->codes[$i],
                                'sl_code' => '',
                                'sl_name' => '',
                                'appro_amnt' => $r->amt[$i],
                                'grpid' => $r->subgrpid[$i],
                            ];
                        if (Core::insertTable('rssys.bgtps02', $insertIntoBgtps02, 'Budget Proposal Entry')) {
                        } else {
                            return 'ERROR';
                            break;
                        }
                    }
                    return 'DONE';
                }
            }
            return 'ERROR';
        }
        else if($r->sel_mod == '1')
        {
            $dt = Carbon::now();
            $UpdateIntoBgtps01 =
            [
                'finalized' => 'Y',
                'finalized_date' => $dt->toDateString(),
                'finalized_time' => $dt->toTimeString(),
                'finalized_by' => strtoupper(Session::get('_user')['id']),
            ];
            // return Core::updateTable('rssys.bgtps01', 'b_num', $r->b_num, $UpdateIntoBgtps01, 'Budget Proposal Entry');
            if (Core::updateTable('rssys.bgtps01', 'b_num', $r->b_num, $UpdateIntoBgtps01, 'Budget Proposal Entry'))
            {
                return 'DONE';
            }
            return 'ERROR';
        }
        else if($r->sel_mod == '2')
        {
            $dt = Carbon::now();
            $UpdateIntoBgtps01 =
            [
                'closed' => 'Y',
                'closed_date' => $dt->toDateString(),
                'closed_time' => $dt->toTimeString(),
                'closed_by' => strtoupper(Session::get('_user')['id']),
            ];
            // return $UpdateIntoBgtps01;
            // return Core::updateTable('rssys.bgtps01', 'b_num', $r->b_num, $UpdateIntoBgtps01, 'Budget Proposal Entry');
            if (Core::updateTable('rssys.bgtps01', 'b_num', $r->b_num, $UpdateIntoBgtps01, 'Budget Proposal Entry'))
            {
                return 'DONE';
            }
            return 'ERROR';
        }
    }
    // public function getRemainingBalance(Request $r)
    // {
    //     $sql = "SELECT proposal.b_num, proposal.appro_amnt, appro.allot_amnt, (proposal.appro_amnt - appro.allot_amnt) AS deduct 
    //             FROM
    //                 (SELECT bgtps02.* FROM rssys.bgtps01 INNER JOIN (SELECT SUM(appro_amnt) AS appro_amnt, b_num FROM rssys.bgtps02 GROUP BY b_num) bgtps02 ON bgtps01.b_num = bgtps02.b_num WHERE bgtps01.b_num = '$r->b_num') proposal
    //             LEFT JOIN (SELECT bgt02.* FROM rssys.bgt01 INNER JOIN (SELECT SUM(allot_amnt) AS allot_amnt, b_num FROM rssys.bgt02 GROUP BY b_num) bgt02 ON bgt01.b_num = bgt02.b_num) appro ON appro.b_num = proposal.b_num";
    //     return Core::sql($sql);
    // }
    public function getAllProposals() // GET EXISTING BUDGET PROPOSALS HEADERS
    {
        $sql = 'SELECT * FROM rssys.bgtps01';
        return Core::sql($sql);
    }
    public function getAllProposalEntries(Request $r)  // GET EXISTING BUDGET PROPOSALS ENTRIES
    {
        $sql = "SELECT m04.at_code, at_desc, subgrpid, subgrpdesc, appro_amnt, allot_amnt, deduct FROM rssys.m04 INNER JOIN (SELECT proposal.b_num, proposal.at_code, proposal.grpid, proposal.appro_amnt, appro.allot_amnt, (proposal.appro_amnt - appro.allot_amnt) AS deduct FROM (SELECT bgtps02.* FROM rssys.bgtps01 INNER JOIN (SELECT SUM(appro_amnt) AS appro_amnt, at_code, grpid, b_num FROM rssys.bgtps02 GROUP BY at_code, grpid, b_num) bgtps02 ON bgtps01.b_num = bgtps02.b_num WHERE bgtps01.b_num = '$r->b_num') proposal LEFT JOIN (SELECT bgt02.* FROM rssys.bgt01 INNER JOIN (SELECT SUM(allot_amnt) AS allot_amnt, at_code, grpid, b_num FROM rssys.bgt02 GROUP BY at_code, grpid, b_num) bgt02 ON bgt01.b_num = bgt02.b_num) appro ON (appro.b_num = proposal.b_num AND appro.at_code = proposal.at_code AND appro.grpid = proposal.grpid)) budget ON budget.at_code = m04.at_code INNER JOIN rssys.ppasubgrp ON ppasubgrp.subgrpid = budget.grpid";
        // $d = array('clm' =>  'b_num', 'data' => $r->b_num);
        $d = Core::sql($sql);
        if(count($d) > 0){
            for ($i=0; $i < count($d); $i++) {
                $d[$i]->act_deduct = floatval(($d[$i]->allot_amnt == null) ? floatval($d[$i]->appro_amnt - 0) : floatval($d[$i]->appro_amnt - $d[$i]->allot_amnt));
            }
        }
        return $d;
    }
    public function getAllProposalEntries2(Request $r) // GET EXISTING BUDGET PROPOSALS  ENTRIES (FILTERED)
    {
        // return $r->b_num[];
        $allData = array();
        if(count($r->b_num) > 0)
        {
            for ($j=0; $j < count($r->b_num); $j++) {
                $leb_num = $r->b_num[$j];
                $sql = /* "SELECT m04.at_code, at_desc, subgrpid, subgrpdesc, appro_amnt, allot_amnt, deduct FROM rssys.m04 INNER JOIN (SELECT proposal.b_num, proposal.at_code, proposal.grpid, proposal.appro_amnt, appro.allot_amnt, (proposal.appro_amnt - appro.allot_amnt) AS deduct FROM (SELECT bgtps02.* FROM rssys.bgtps01 INNER JOIN (SELECT SUM(appro_amnt) AS appro_amnt, at_code, grpid, b_num FROM rssys.bgtps02 GROUP BY at_code, grpid, b_num) bgtps02 ON bgtps01.b_num = bgtps02.b_num WHERE bgtps01.b_num = '$leb_num') proposal LEFT JOIN (SELECT bgt02.* FROM rssys.bgt01 INNER JOIN (SELECT SUM(allot_amnt) AS allot_amnt, at_code, grpid, b_num FROM rssys.bgt02 GROUP BY at_code, grpid, b_num) bgt02 ON bgt01.b_num = bgt02.b_num WHERE rssys.bgt01.fy = '$r->fy') appro ON (appro.b_num = proposal.b_num AND appro.at_code = proposal.at_code AND appro.grpid = proposal.grpid)) budget ON budget.at_code = m04.at_code INNER JOIN rssys.ppasubgrp ON ppasubgrp.subgrpid = budget.grpid"; */ "SELECT m04.at_code, at_desc, subgrpid, subgrpdesc, appro_amnt, allot_amnt, deduct FROM rssys.m04 INNER JOIN (SELECT proposal.b_num, proposal.at_code, proposal.grpid, proposal.appro_amnt, appro.allot_amnt, (proposal.appro_amnt - appro.allot_amnt) AS deduct FROM (SELECT bgtps02.* FROM rssys.bgtps01 INNER JOIN (SELECT SUM(appro_amnt) AS appro_amnt, at_code, grpid, b_num FROM rssys.bgtps02 GROUP BY at_code, grpid, b_num) bgtps02 ON bgtps01.b_num = bgtps02.b_num WHERE bgtps01.b_num = '$leb_num') proposal LEFT JOIN (SELECT bgt02.* FROM rssys.bgt01 INNER JOIN (SELECT SUM(allot_amnt) AS allot_amnt, at_code, grpid, b_num FROM rssys.bgt02 GROUP BY at_code, grpid, b_num) bgt02 ON bgt01.b_num = bgt02.b_num WHERE rssys.bgt01.bgtps_bnum = '$leb_num') appro ON (appro.b_num = proposal.b_num AND appro.at_code = proposal.at_code AND appro.grpid = proposal.grpid)) budget ON budget.at_code = m04.at_code INNER JOIN rssys.ppasubgrp ON ppasubgrp.subgrpid = budget.grpid";
                // $d = array('clm' =>  'b_num', 'data' => $r->b_num);
                $d = Core::sql($sql);
                if(count($d) > 0){
                    for ($i=0; $i < count($d); $i++) {
                        $d[$i]->act_deduct = floatval(($d[$i]->allot_amnt == null) ? floatval($d[$i]->appro_amnt - 0) : floatval($d[$i]->appro_amnt - $d[$i]->allot_amnt));
                    }
                }
                array_push($allData ,$d);
            }
        }
        return $allData;

        // return response()->json([]);
    }
    public function getProposal(Request $r) // GET EXISTING BUDGET PROPOSALS  ENTRIES 2 (FILTERED)
    {
        $sql = 'SELECT * FROM rssys.bgtps01
                LEFT JOIN rssys.branch ON rssys.bgtps01.branch = rssys.branch.code
                LEFT JOIN rssys.m08 ON rssys.bgtps01.cc_code = rssys.m08.cc_code
                LEFT JOIN rssys.fund ON rssys.bgtps01.fid = rssys.fund.fid
                LEFT JOIN rssys.sector ON rssys.bgtps01.secid = rssys.sector.secid
                WHERE rssys.bgtps01.b_num = \''.$r->b_num.'\'
                ';
        $d1 = Core::sql($sql);
        $sql1 = "SELECT * FROM rssys.x03 WHERE rssys.x03.fy = '".$d1[0]->fy."' AND rssys.x03.mo = '".$d1[0]->mo."'";
        $d3 = Core::sql($sql1);
        // $d1[0]->month_desc = $d3[0]->month_desc;
        return $d1;
    }
}