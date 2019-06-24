<?php

namespace App\Http\Controllers\Budget;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use Carbon\Carbon;
class c_budget_obligation_entry extends Controller
{
	public function __construct()
    {
    	$this->x03 = Core::getAll('rssys.x03');
    	$this->fund = Core::getAll('rssys.fund');
    	$this->m08 = Core::getAll('rssys.m08');
    	$this->sector = Core::getAll('rssys.sector');
    	$this->branch = Core::getAll('rssys.branch');
    	$this->m04 = Core::getAll('rssys.m04');
    	$sql = 'SELECT * FROM rssys.ppasubgrp ORDER BY seq';
    	$this->ppa = Core::sql($sql);
    }

    public function view()
    {
    	$data = array($this->x03, $this->fund);
    	// return dd($data[1]);
    	return view('budget.budget_budget_obligation_entry', compact('data'));
    }
    public function getEntries(Request $r)
    {
    	$year = explode('-', $r->prd)[0];
        $month = explode('-', $r->prd)[1];
    	$sql = "SELECT * FROM rssys.tr01
    			LEFT JOIN rssys.branch ON rssys.tr01.branch = rssys.branch.code 
    			LEFT JOIN rssys.m08 ON rssys.tr01.cc_code = rssys.m08.cc_code
    			LEFT JOIN rssys.fund ON rssys.tr01.fid = rssys.fund.fid
    			LEFT JOIN rssys.sector ON rssys.tr01.secid = rssys.sector.secid
    			WHERE rssys.tr01.fy = '".$year."' AND rssys.tr01.mo = '".$month."'
    			AND rssys.tr01.fid = '".$r->fid."'
    			ORDER BY rssys.tr01.j_num ASC";
    	$data = Core::sql($sql);
    	return $data;
    }
    public function new()
    {
        return view('budget.budget_budget_obligation_entry_new', ['ppasubgrp' => $this->ppa, 'm04' => $this->m04]);
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
    public function save(Request $r)
    {
    	$b_num = Core::getm99One('tr01_bnum');
        // return dd($b_num);
    	$insertIntoBgt01 =
    		[
    			'fy' => $r->fy,
    			'mo' => $r->mo,
                'j_code' => 'FUND',
    			'j_num' => $b_num->tr01_bnum,
    			't_date' => $r->t_date,
    			't_desc' => strtoupper($r->t_desc),
    			'user_id' => strtoupper(Session::get('_user')['id']),
    			'branch' => '001',
    			'cc_code' => $r->cc_code,
    			'fid' => $r->fid,
    			'secid' => $r->secid,
                'bgt01_bnum' => $r->bgtps_bnum
    			// 'finalized' => 'N',
    			// 'closed' => 'N',
    		];
            // return dd($insertIntoBgt01);
            // $dt = Carbon::now();
            // $UpdateIntoBgtps01 =
            // [
            //     'closed' => 'Y',
            //     'closed_date' => $dt->toDateString(),
            //     'closed_time' => $dt->toTimeString(),
            //     'closed_by' => strtoupper(Session::get('_user')['id']),
            // ];
            // if (Core::updateTable('rssys.bgtps01', 'b_num', $r->bgtps_bnum, $UpdateIntoBgtps01, 'Budget Proposal Entry'))
            // {
            // return Core::insertTable('rssys.tr01', $insertIntoBgt01, 'Budget Obligation Entry');
                if (Core::insertTable('rssys.tr01', $insertIntoBgt01, 'Budget Obligation Entry')) {
                    Core::updatem99('tr01_bnum', Core::get_nextincrementlimitchar($b_num->tr01_bnum, 8));
                 if (count($r->codes)) {
                     for ($i=0, $j = 1; $i < count($r->codes); $i++, $j++) {
                         $insertIntoBgt02 =
                             [
                                 'j_num' => $b_num->tr01_bnum,
                                 'j_code' => 'FUND',
                                 'seq_num' => $j,
                                 'at_code' => $r->codes[$i],
                                 'sl_code' => '',
                                 'sl_name' => '',
                                 'debit' => floatval($r->amt[$i]),
                                 'grp_id' => $r->subgrpid[$i],
                             ];
                             // return dd(Core::insertTable('rssys.tr02', $insertIntoBgt02, 'Budget Obligation Entry'));
                         if (Core::insertTable('rssys.tr02', $insertIntoBgt02, 'Budget Obligation Entry')) {
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
    public function edit($b_num)
    {
    	$sql1 = 'SELECT * FROM rssys.tr01
				LEFT JOIN rssys.branch ON rssys.tr01.branch = rssys.branch.code
				LEFT JOIN rssys.m08 ON rssys.tr01.cc_code = rssys.m08.cc_code
				LEFT JOIN rssys.fund ON rssys.tr01.fid = rssys.fund.fid
				LEFT JOIN rssys.sector ON rssys.tr01.secid = rssys.sector.secid
				WHERE rssys.tr01.j_num = \''.$b_num.'\'
    			';
    	$sql2 = 'SELECT * FROM rssys.tr02
    			LEFT JOIN rssys.m04 ON rssys.tr02.at_code = rssys.m04.at_code
    			LEFT JOIN rssys.ppasubgrp ON rssys.tr02.grp_id = rssys.ppasubgrp.subgrpid
    			WHERE rssys.tr02.j_num = \''.$b_num.'\'
    			ORDER BY rssys.tr02.seq_num ASC
    			';
        // $sql4 = 'SELECT * FROM rssys.bgt01
        //         LEFT JOIN rssys.branch ON rssys.bgt01.branch = rssys.branch.code
        //         LEFT JOIN rssys.m08 ON rssys.bgt01.cc_code = rssys.m08.cc_code
        //         LEFT JOIN rssys.fund ON rssys.bgt01.fid = rssys.fund.fid
        //         LEFT JOIN rssys.sector ON rssys.bgt01.secid = rssys.sector.secid
        //         WHERE rssys.bgt01.b_num = \''.$b_num.'\'
        //         ';
        
    	$d1 = Core::sql($sql1);
    	$d2 = Core::sql($sql2);
    	$sql3 = "SELECT * FROM rssys.x03 WHERE rssys.x03.fy = '".$d1[0]->fy."' AND rssys.x03.mo = '".$d1[0]->mo."'";
    	$d3 = Core::sql($sql3);
        $sql4 = 'SELECT * FROM rssys.bgt02
                LEFT JOIN rssys.m04 ON rssys.bgt02.at_code = rssys.m04.at_code
                LEFT JOIN rssys.ppasubgrp ON rssys.bgt02.grpid = rssys.ppasubgrp.subgrpid
                WHERE rssys.bgt02.b_num = \''.$d1[0]->bgt01_bnum.'\'
                ORDER BY rssys.bgt02.seq_num ASC
                ';
        $d4 = Core::sql($sql4);
    	// return dd($d2);
    	// $data = [$d1, $d2, $b_num];
    		///compact('data')
    	return view('budget.budget_budget_obligation_entry_view', ['fund'=> $this->fund, 'm08' => $this->m08, 'sector' => $this->sector, 'branch' => $this->branch, 'm04' => $this->m04, 'ppa' => $this->ppa, 'bgt01' => $d1[0], 'bgt02' => $d2, 'mo_desc' => $d3[0]->month_desc, 'bgt02_data'=>$d4]);
    }
    public function update(Request $r)
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
    public function getAllApprove()
    {
        $sql = 'SELECT * FROM rssys.bgt01';
        return Core::sql($sql);
    }
    public function getApproveEntries(Request $r)
    {
        $sql = 'SELECT * FROM rssys.bgt02
                LEFT JOIN rssys.m04 ON rssys.bgt02.at_code = rssys.m04.at_code
                LEFT JOIN rssys.ppasubgrp ON rssys.bgt02.grpid = rssys.ppasubgrp.subgrpid
                WHERE rssys.bgt02.b_num = \''.$r->b_num.'\'
                ORDER BY rssys.bgt02.seq_num ASC
                ';
        // $d = array('clm' =>  'b_num', 'data' => $r->b_num);
        return Core::sql($sql);
    }
    public function getApprove(Request $r)
    {
        $sql = 'SELECT * FROM rssys.bgt01
                LEFT JOIN rssys.branch ON rssys.bgt01.branch = rssys.branch.code
                LEFT JOIN rssys.m08 ON rssys.bgt01.cc_code = rssys.m08.cc_code
                LEFT JOIN rssys.fund ON rssys.bgt01.fid = rssys.fund.fid
                LEFT JOIN rssys.sector ON rssys.bgt01.secid = rssys.sector.secid
                WHERE rssys.bgt01.b_num = \''.$r->b_num.'\'
                ';
        $d1 = Core::sql($sql);
        $sql1 = "SELECT * FROM rssys.x03 WHERE rssys.x03.fy = '".$d1[0]->fy."' AND rssys.x03.mo = '".$d1[0]->mo."'";
        $d3 = Core::sql($sql1);
        $d1[0]->month_desc = $d3[0]->month_desc;
        return $d1;
    }
}