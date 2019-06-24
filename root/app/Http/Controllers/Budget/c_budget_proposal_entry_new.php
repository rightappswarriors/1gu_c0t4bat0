<?php

namespace App\Http\Controllers\Budget;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use Carbon\Carbon;
class c_budget_proposal_entry_new extends Controller
{
	public function __construct()
    {
    	$sql = "SELECT DISTINCT rssys.x03.fy FROM rssys.x03 ORDER BY rssys.x03.fy ASC";
        $this->x03 = Core::sql($sql);
    	$this->fund = Core::getAll('rssys.fund');
        $this->budget_period  = Core::getAll('rssys.budget_period');
        $sql1 = "SELECT * FROM rssys.charge AS c
                 LEFT JOIN rssys.m04 AS m4 ON c.at_code = m4.at_code
                 ORDER BY c.chg_desc ASC";
        $this->charge = Core::sql($sql1);
    	$this->m08 = Core::getAll('rssys.m08');
    	$this->sector = Core::getAll('rssys.sector');
    	// $this->branch = Core::getAll('rssys.branch');
    	// $this->m04 = Core::getAll('rssys.m04');
    	$sql2 = 'SELECt * FROM rssys.ppasubgrp ORDER BY seq';
    	$this->ppa = Core::sql($sql2);
    }

    public function view() // VIEW BUDGET PROPOSALS MODULE
    {
    	// $data = array($this->x03, $this->fund);
    	// return dd($this->x03);
    	return view('budget.budget_budget_proposal_entry_new', ['x03'=>$this->x03, 'fund' => $this->fund, 'budget_period' => $this->budget_period]);
    }
    public function getEntries(Request $r) // GET EXISTING BUDGET PROPOSALS MODULE
    {
    	// $year = explode('-', $r->prd)[0];
        // $month = explode('-', $r->prd)[1];
    	$sql = "SELECT * FROM rssys.bgtprop01
    			LEFT JOIN rssys.branch ON rssys.bgtprop01.branch = rssys.branch.code
    			LEFT JOIN rssys.m08 ON rssys.bgtprop01.cc_code = rssys.m08.cc_code
    			LEFT JOIN rssys.fund ON rssys.bgtprop01.fid = rssys.fund.fid
    			LEFT JOIN rssys.sector ON rssys.bgtprop01.secid = rssys.sector.secid
    			WHERE rssys.bgtprop01.fy = '".$r->prd."' AND rssys.bgtprop01.fid = '".$r->fid."'
    			ORDER BY rssys.bgtprop01.b_num ASC";
    	$data = Core::sql($sql);
    	return $data;
        //AND rssys.bgtps01.mo = '0'
    }
    public function new($fy, $fid) // VIEW NEW BUDGET PROPOSAL ENTRY MODULE
    {
    	$sql = "SELECT * FROM rssys.x03 WHERE rssys.x03.fy = '".$fy."'"; // AND rssys.x03.mo = '".$mo."'
    	$d1 = Core::sql($sql);
    	// return dd(0, 1, 2, 3, 4, 5, 6, 7);
    	// $data = array($this->x03, $this->fund, $this->m08, $this->sector, $this->branch, $fy, '', '', $this->m04, $fid, $this->ppa);
    	// return dd($this->ppa);
    	return view('budget.budget_budget_proposal_entry_new_new2', ['charge' => $this->charge, 'period' => $this->x03, 'budget' => $this->budget_period, 'fund' => $this->fund, 'm08' => $this->m08, 'sector' => $this->sector, 'fy' => $fy, 'fid' => $fid, 'ppa' => $this->ppa]);
    }
    public function save(Request $r) // ADD NEW BUDGET PROPOSAL ENTRY MODULE
    {
    	$b_num = Core::getm99One('bgtprop_bnum');
        $dt = Carbon::now();
    	// return dd($r);
    	$insertIntoBgtps01 =
    		[
    			'fy' => $r->fy,
    			// 'mo' => $r->mo,
    			'b_num' => $b_num->bgtprop_bnum,
    			't_date' => $r->t_date,
    			't_desc' => strtoupper($r->t_desc),
    			'user_id' => strtoupper(Session::get('_user')['id']),
    			'branch' => '001',
    			'cc_code' => $r->cc_code,
    			'fid' => $r->fid,
    			'secid' => $r->secid,
                'systime' => $dt->toTimeString(),
                'sysdate' => $dt->toDateString(),
                // 'budget_period' => $r->budget_period
    			// 'finalized' => 'Y',
    			// 'closed' => 'Y',
    		];
            // return dd(Core::insertTable('rssys.bgtprop01', $insertIntoBgtps01, 'Budget Proposal Entry'));
    	if (Core::insertTable('rssys.bgtprop01', $insertIntoBgtps01, 'Budget Proposal Entry')) {
    		 Core::updatem99('bgtprop_bnum', Core::get_nextincrementlimitchar($b_num->bgtprop_bnum, 8));
    		if (count($r->codes)) {
    			for ($i=0, $j = 1; $i < count($r->codes); $i++, $j++) {
    				$insertIntoBgtps02 =
    					[
    						'b_num' => $b_num->bgtprop_bnum,
    						'seq_num' => $j,
                            // 'seq_desc' => $r->desc[$i],
    						'at_code' => $r->at_code[$i],
    						'sl_code' => '',
    						'sl_name' => '',
    						'appro_amnt' => $r->amt[$i],
                            'chg_code' => $r->codes[$i],
    						'grpid' => $r->subgrpid[$i],
    					];
    				if (Core::insertTable('rssys.bgtprop02', $insertIntoBgtps02, 'Budget Proposal Entry')) {
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
    // public function getAllProposals()
    // {
    //     $sql = 'SELECT * FROM rssys.bgtps01 WHERE finalized = \'Y\' AND closed = \'N\'';
    //     return Core::sql($sql);
    // }
    public function edit($b_num) // VIEW EXISTING BUDGET PROPOSAL ENTRY MODULE
    {
    	$sql1 = 'SELECT * FROM rssys.bgtprop01
				LEFT JOIN rssys.branch ON rssys.bgtprop01.branch = rssys.branch.code
				LEFT JOIN rssys.m08 ON rssys.bgtprop01.cc_code = rssys.m08.cc_code
				LEFT JOIN rssys.fund ON rssys.bgtprop01.fid = rssys.fund.fid
				LEFT JOIN rssys.sector ON rssys.bgtprop01.secid = rssys.sector.secid
                -- LEFT JOIN rssys.budget_period ON rssys.bgtprop01.budget_period = rssys.budget_period.budget_code
				WHERE rssys.bgtprop01.b_num = \''.$b_num.'\'
    			';
    	$sql2 = 'SELECT b2.seq_num, b2.at_code, b2.appro_amnt, b2.grpid, b2.chg_code, c.chg_desc, m4.at_desc, b2.seq_desc
                FROM rssys.bgtprop02 b2
    			LEFT JOIN rssys.m04 m4 ON b2.at_code = m4.at_code
    			LEFT JOIN rssys.ppasubgrp sb ON b2.grpid = sb.subgrpid
                LEFT JOIN rssys.charge c ON b2.chg_code = c.chg_code
    			WHERE b2.b_num = \''.$b_num.'\'
    			ORDER BY b2.seq_num ASC
    			';
    	$d1 = Core::sql($sql1);
    	$d2 = Core::sql($sql2);
    // 	$sql3 = "SELECT * FROM rssys.x03 WHERE rssys.x03.fy = '".$d1[0]->fy."' AND rssys.x03.mo = '".$d1[0]->mo."'";
    // 	$d3 = Core::sql($sql3);
    	// return dd($d2);
    	// $data = [$d1, $d2, $b_num];
    		///compact('data')
    	return view('budget.budget_budget_proposal_entry_new_new2_view', ['fund'=> $this->fund, 'm08' => $this->m08, 'sector' => $this->sector, 'period' => $this->x03, 'budget' => $this->budget_period, 'bgtprop01' => $d1[0], 'bgtprop02' => $d2, 'charge' => $this->charge, 'ppa' => $this->ppa]);
        // , 'mo_desc' => $d3[0]->month_desc
    }
    public function update(Request $r) // UPDATE EXISTING BUDGET PROPOSAL ENTRY MODULE
    {
        // return $r;
        // if ($r->sel_mod == '0')
        // {
            $dt = Carbon::now();
            $insertIntoBgtps01 =
            [
                'fy' => $r->fy,
                // 'mo' => $r->mo,
                'b_num' => $r->b_num,
                't_date' => $r->t_date,
                't_desc' => strtoupper($r->t_desc),
                'user_id' => strtoupper(Session::get('_user')['id']),
                'branch' => '001',
                'cc_code' => $r->cc_code,
                'fid' => $r->fid,
                'secid' => $r->secid,
                'systime' => $dt->toTimeString(),
                'sysdate' => $dt->toDateString(),
                // 'budget_period' => $r->budget_period
                // 'finalized' => 'Y',
                // 'closed' => 'Y',
            ];
            // return $insertIntoBgtps01;
            // return count($r->codes);
            $del = [['b_num', '=', $r->b_num]];
            // return dd(Core::updateTable('rssys.bgtprop01', 'b_num', $r->b_num, $insertIntoBgtps01, 'Budget Proposal Entry'));
            Core::deleteTableMultiWhere('rssys.bgtprop02', $del, 'Budget Proposal Entry' );
            if (Core::updateTable('rssys.bgtprop01', 'b_num', $r->b_num, $insertIntoBgtps01, 'Budget Proposal Entry'))
            {
                if (count($r->codes) != 0) {
                    for ($i=0, $j = 1; $i < count($r->codes); $i++, $j++) {
                        $insertIntoBgtps02 =
                        [
                            'b_num' => $r->b_num,
                            'seq_num' => $j,
                            // 'seq_desc' => $r->desc[$i],
                            'at_code' => $r->at_code[$i],
                            'sl_code' => '',
                            'sl_name' => '',
                            'appro_amnt' => $r->amt[$i],
                            'chg_code' => $r->codes[$i],
                            'grpid' => $r->subgrpid[$i],
                        ];
                        if (Core::insertTable('rssys.bgtprop02', $insertIntoBgtps02, 'Budget Proposal Entry')) {
                        } else {
                            return 'ERROR';
                            break;
                        }
                    }
                    return 'DONE';
                }
            }
            return 'ERROR';
        // }
        // else if($r->sel_mod == '1')
        // {
        //     $dt = Carbon::now();
        //     $UpdateIntoBgtps01 =
        //     [
        //         'finalized' => 'Y',
        //         'finalized_date' => $dt->toDateString(),
        //         'finalized_time' => $dt->toTimeString(),
        //         'finalized_by' => strtoupper(Session::get('_user')['id']),
        //     ];
        //     // return Core::updateTable('rssys.bgtps01', 'b_num', $r->b_num, $UpdateIntoBgtps01, 'Budget Proposal Entry');
        //     if (Core::updateTable('rssys.bgtps01', 'b_num', $r->b_num, $UpdateIntoBgtps01, 'Budget Proposal Entry'))
        //     {
        //         return 'DONE';
        //     }
        //     return 'ERROR';
        // }
        // else if($r->sel_mod == '2')
        // {
        //     $dt = Carbon::now();
        //     $UpdateIntoBgtps01 =
        //     [
        //         'closed' => 'Y',
        //         'closed_date' => $dt->toDateString(),
        //         'closed_time' => $dt->toTimeString(),
        //         'closed_by' => strtoupper(Session::get('_user')['id']),
        //     ];
        //     // return $UpdateIntoBgtps01;
        //     // return Core::updateTable('rssys.bgtps01', 'b_num', $r->b_num, $UpdateIntoBgtps01, 'Budget Proposal Entry');
        //     if (Core::updateTable('rssys.bgtps01', 'b_num', $r->b_num, $UpdateIntoBgtps01, 'Budget Proposal Entry'))
        //     {
        //         return 'DONE';
        //     }
        //     return 'ERROR';
        // }
        //
    }
}