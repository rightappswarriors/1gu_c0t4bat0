<?php

namespace App\Http\Controllers\Budget;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use Carbon\Carbon;
use DB;
use App\Budget;

class c_budget_proposal_entry extends Controller
{
	public function __construct()
    {
    	$sql = "SELECT DISTINCT rssys.x03.fy FROM rssys.x03 ORDER BY rssys.x03.fy ASC";
        $this->x03 = Core::sql($sql);
    	$this->fund = Core::getAll('rssys.fund');
    	$this->m08 = Core::getAll('rssys.m08');
    	$this->sector = Core::getAll('rssys.sector');
    	$this->branch = Core::getAll('rssys.branch');
    	$this->m04 = Core::getAll('rssys.m04');
    	$sql = 'SELECt * FROM rssys.ppasubgrp ORDER BY seq';
    	$this->ppa = Core::sql($sql);
        $this->budget_period  = Core::getAll('rssys.budget_period');
        $this->func = Core::sql("SELECT * FROM rssys.function fn WHERE fn.active = TRUE");
    }

    public function view() // VIEW BUDGET APPROPRIATION MODULES
    {
    	$data = array($this->x03, $this->fund);
    	// return dd($data[0]);
    	return view('budget.budget_budget_proposal_entry', compact('data'));
    }
    public function getEntries(Request $r) // GET EXISTING BUDGET APPROPRIATION ENTRIES MODULES
    {
    	// $year = explode('-', $r->prd)[0];
        // $month = explode('-', $r->prd)[1];
    	$sql = "SELECT * FROM rssys.bgtps01
    			LEFT JOIN rssys.branch ON rssys.bgtps01.branch = rssys.branch.code
    			LEFT JOIN rssys.m08 ON rssys.bgtps01.cc_code = rssys.m08.cc_code
    			LEFT JOIN rssys.fund ON rssys.bgtps01.fid = rssys.fund.fid
    			LEFT JOIN rssys.sector ON rssys.bgtps01.secid = rssys.sector.secid
    			WHERE rssys.bgtps01.fy = '".$r->prd."'
    			ORDER BY rssys.bgtps01.b_num ASC";
                //  AND rssys.bgtps01.fid = '".$r->fid."'
    	$data = Core::sql($sql);
    	return $data;
        //AND rssys.bgtps01.mo = '0'
    }
    public function new($fy) // VIEW ADD NEW BUDGET APPROPRIATION ENTRY MODULES
    {
    	$sql = "SELECT * FROM rssys.x03 WHERE rssys.x03.fy = '".$fy."'"; // AND rssys.x03.mo = '".$mo."'
    	$d1 = Core::sql($sql);
    	// return dd(0, 1, 2, 3, 4, 5, 6, 7);
    	$data = array($this->x03, $this->fund, $this->m08, $this->sector, $this->branch, $fy, '', '', $this->m04, '', $this->ppa, $this->budget_period);
        $isnew = true;
    	// return dd($data[10]);
    	return view('budget.budget_budget_proposal_entry_new_new', compact('data', 'isnew'));
    }

    public function getFunctions(Request $r) // GET FUNCTIONS (FILTERED) MODULES
    {
        // return dd($r->all());
        $SQL = "SELECT * FROM rssys.function fn WHERE fn.secid = '".$r->id."' AND fn.active = TRUE";
        return DB::select($SQL);
    }

    /* modify by: DAN 07/18/19
     */
    public function save(Request $r) // ADD NEW BUDGET APPROPRIATION ENTRY MODULES
    {
        $b_num = Core::getm99One('bgtps_bnum');
        $b_num = $b_num->bgtps_bnum;

        $dt = Carbon::now();
        $flag = 'false';
        $ln_num = 1;

        $checkDataAppro = [$r->fy, $r->cc_code, $r->fid, $r->secid, $r->funct];
        $checkApproIfExist = Budget::checkIfApproExist($checkDataAppro);

        if($checkApproIfExist['flag'] == 'false') // if not exist, create new
        {
            $insertIntoBgtps01 =
            [
                'fy' => $r->fy,
                'b_num' => $b_num,
                'user_id' => strtoupper(Session::get('_user')['id']),
                'branch' => '001',
                'cc_code' => $r->cc_code,
                'fid' => $r->fid,
                'secid' => $r->secid,
                'funcid' => $r->funct,
                'systime' => $dt->toTimeString(),
                'sysdate' => $dt->toDateString(),
                'finalized' => 'Y',
                'closed' => 'Y',
            ];

            if (Core::insertTable('rssys.bgtps01', $insertIntoBgtps01, 'Budget Proposal Entry')) 
            {
                Core::updatem99('bgtps_bnum', Core::get_nextincrementlimitchar($b_num, 8));
                $flag = 'true';
            }
        }
        else
        {
            $flag = 'true';
            $b_num = $checkApproIfExist['b_num'];
            $ln_num = $checkApproIfExist['ln_num'];
        }

        // insert line
        if($flag = 'true')
        {
          if (count($r->codes)) 
          {
              for ($i=0; $i < count($r->codes); $i++, $ln_num++) 
              {
                  $insertIntoBgtps02 =
                      [
                          'b_num' => $b_num,
                          'seq_num' => $ln_num,
                          'seq_desc' => $r->desc[$i],
                          'at_code' => $r->codes[$i],
                          'sl_code' => '',
                          'sl_name' => '',
                          'appro_amnt' => $r->amt[$i],
                          'grpid' => $r->subgrpid[$i],
                      ];
                  if (Core::insertTable('rssys.bgtps02', $insertIntoBgtps02, 'Budget Proposal Entry')) 
                  {
                    $flag = 'true';
                  } 
                  else 
                  {
                    return 'false';
                  }
              }
          }
        }

        return $flag;

    }


    /* src code of Mhel
     * comment by: DAN 07/18/19

    public function save(Request $r) // ADD NEW BUDGET APPROPRIATION ENTRY MODULES
    {
    	$b_num = Core::getm99One('bgtps_bnum');
        $dt = Carbon::now();
    	// return dd($dt->toTimeString());
    	$insertIntoBgtps01 =
    		[
    			'fy' => $r->fy,
    			// 'mo' => $r->mo,
    			'b_num' => $b_num->bgtps_bnum,
    			// 't_date' => '',
    			// 't_desc' => '',
    			'user_id' => strtoupper(Session::get('_user')['id']),
    			'branch' => '001',
    			'cc_code' => $r->cc_code,
    			'fid' => $r->fid,
    			'secid' => $r->secid,
                'funcid' => $r->funct,
                'systime' => $dt->toTimeString(),
                'sysdate' => $dt->toDateString(),
    			'finalized' => 'Y',
    			'closed' => 'Y',
    		];
            // return $insertIntoBgtps01;
            // return dd(Core::insertTable('rssys.bgtps01', $insertIntoBgtps01, 'Budget Proposal Entry'));
    	if (Core::insertTable('rssys.bgtps01', $insertIntoBgtps01, 'Budget Proposal Entry')) {
    		 Core::updatem99('bgtps_bnum', Core::get_nextincrementlimitchar($b_num->bgtps_bnum, 8));
    		if (count($r->codes)) {
    			for ($i=0, $j = 1; $i < count($r->codes); $i++, $j++) {
    				$insertIntoBgtps02 =
    					[
    						'b_num' => $b_num->bgtps_bnum,
    						'seq_num' => $j,
                            'seq_desc' => $r->desc[$i],
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
    */

    // public function getAllProposals()
    // {
    //     $sql = 'SELECT * FROM rssys.bgtps01 WHERE finalized = \'Y\' AND closed = \'N\'';
    //     return Core::sql($sql);
    // }

    /* src code of Mhel
     * comment by: DAN 07/18/19

    public function edit($b_num) // VIEW EXISTING BUDGET APPROPRIATION ENTRY MODULES
    {
    	$sql1 = 'SELECT * FROM rssys.bgtps01
				LEFT JOIN rssys.branch ON rssys.bgtps01.branch = rssys.branch.code
				LEFT JOIN rssys.m08 ON rssys.bgtps01.cc_code = rssys.m08.cc_code
				LEFT JOIN rssys.fund ON rssys.bgtps01.fid = rssys.fund.fid
				LEFT JOIN rssys.sector ON rssys.bgtps01.secid = rssys.sector.secid
				WHERE rssys.bgtps01.b_num = \''.$b_num.'\'
    			';
    	$sql2 = 'SELECT * FROM rssys.bgtps02
    			LEFT JOIN rssys.m04 ON rssys.bgtps02.at_code = rssys.m04.at_code
    			LEFT JOIN rssys.ppasubgrp ON rssys.bgtps02.grpid = rssys.ppasubgrp.subgrpid
    			WHERE rssys.bgtps02.b_num = \''.$b_num.'\'
    			ORDER BY rssys.bgtps02.seq_num ASC
    			';
    	$d1 = Core::sql($sql1);
    	$d2 = Core::sql($sql2);
    	$sql3 = "SELECT * FROM rssys.x03 WHERE rssys.x03.fy = '".$d1[0]->fy."' AND rssys.x03.mo = '".$d1[0]->mo."'";
    	$d3 = Core::sql($sql3);
    	// return dd($d2);
    	// $data = [$d1, $d2, $b_num];
    		///compact('data')
    	return view('budget.budget_budget_proposal_entry_view', ['fund'=> $this->fund, 'm08' => $this->m08, 'sector' => $this->sector, 'branch' => $this->branch, 'm04' => $this->m04, 'ppa' => $this->ppa, 'bgt01' => $d1[0], 'bgt02' => $d2, 'fy' => $this->x03]);
        // , 'mo_desc' => $d3[0]->month_desc
    }
    */

    /* modify by: DAN 07/18/19
     */
    public function edit($b_num) // VIEW EXISTING BUDGET APPROPRIATION ENTRY MODULES
    {
        $isnew = false;
        $approHeader = Budget::get_approHeader($b_num);
        $approLine = Budget::get_approLine($b_num);
        $fy = $approHeader->fy;
        $data = array($this->x03, $this->fund, $this->m08, $this->sector, $this->branch, $fy, '', '', $this->m04, '', $this->ppa, $this->budget_period, $this->func);
        
        return view('budget.budget_budget_proposal_entry_new_new', compact('data', 'isnew', 'approHeader', 'approLine'));
    }

    /* modify by: DAN 07/19/19
     */
    public function update(Request $r) // UPDATE EXISTING BUDGET APPROPRIATION ENTRY MODULES
    {   
        $dt = Carbon::now();
        $flag = 'true';
            
        $insertIntoBgtps01 =
        [
            'fy' => $r->fy,
            'b_num' => $r->b_num,
            'user_id' => strtoupper(Session::get('_user')['id']),
            'branch' => '001',
            'cc_code' => $r->cc_code,
            'fid' => $r->fid,
            'secid' => $r->secid,
            'funcid' => $r->funct,
            'systime' => $dt->toTimeString(),
            'sysdate' => $dt->toDateString(),
            'finalized' => 'Y',
            'closed' => 'Y',
        ];
            
        $del = [['b_num', '=', $r->b_num]];
        Core::deleteTableMultiWhere('rssys.bgtps02', $del, 'Budget Proposal Entry' );
            
        if (Core::updateTable('rssys.bgtps01', 'b_num', $r->b_num, $insertIntoBgtps01, 'Budget Proposal Entry')) 
        {
            if (count($r->codes)) 
            {
                for ($i=0, $j = 1; $i < count($r->codes); $i++, $j++) 
                {
                    $insertIntoBgtps02 =
                    [
                        'b_num' => $r->b_num,
                        'seq_num' => $j,
                        'seq_desc' => $r->desc[$i],
                        'at_code' => $r->codes[$i],
                        'sl_code' => '',
                        'sl_name' => '',
                        'appro_amnt' => $r->amt[$i],
                        'grpid' => $r->subgrpid[$i],
                    ];

                    if (Core::insertTable('rssys.bgtps02', $insertIntoBgtps02, 'Budget Proposal Entry')) 
                    {
                        $flag = 'true';
                    } 
                    else 
                    {
                        return 'false';
                    }
                }
            }
        }
        else
        {
            $flag = 'false';
        }

        return $flag;
    }


    /* src code of Mhel 07/19/19
     * comment by: DAN 07/19/19
     *
    public function update(Request $r) // UPDATE EXISTING BUDGET APPROPRIATION ENTRY MODULES
    {   
        $dt = Carbon::now();
        // if ($r->sel_mod == '0')
        // {
            // return dd($r);
            $insertIntoBgtps01 =
            [
                'fy' => $r->fy,
                // 'mo' => $r->mo,
                'b_num' => $r->b_num,
                // 't_date' => '',
                // 't_desc' => '',
                'user_id' => strtoupper(Session::get('_user')['id']),
                'branch' => '001',
                'cc_code' => $r->cc_code,
                'fid' => $r->fid,
                'secid' => $r->secid,
                'systime' => $dt->toTimeString(),
                'sysdate' => $dt->toDateString(),
                'finalized' => 'Y',
                'closed' => 'Y',
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
                                'seq_desc' => $r->desc[$i],
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
    */

    /* save and add more function
     * -DAN 07/19/19
     */
    public function saveaddmore(Request $r)
    {
        $b_num = Core::getm99One('bgtps_bnum');
        $b_num = $b_num->bgtps_bnum;

        $dt = Carbon::now();
        $flag = 'false';
        $ln_num = 1;

        $checkDataAppro = [$r->fy, $r->cc_code, $r->fid, $r->secid, $r->funct];
        $checkApproIfExist = Budget::checkIfApproExist($checkDataAppro);

        if($checkApproIfExist['flag'] == 'false') // if not exist, create new
        {
            $insertIntoBgtps01 =
            [
                'fy' => $r->fy,
                'b_num' => $b_num,
                'user_id' => strtoupper(Session::get('_user')['id']),
                'branch' => '001',
                'cc_code' => $r->cc_code,
                'fid' => $r->fid,
                'secid' => $r->secid,
                'funcid' => $r->funct,
                'systime' => $dt->toTimeString(),
                'sysdate' => $dt->toDateString(),
                'finalized' => 'Y',
                'closed' => 'Y',
            ];

            if (Core::insertTable('rssys.bgtps01', $insertIntoBgtps01, 'Budget Proposal Entry')) 
            {
                Core::updatem99('bgtps_bnum', Core::get_nextincrementlimitchar($b_num, 8));
                $flag = 'true';
            }
        }
        else
        {
            $flag = 'true';
            $b_num = $checkApproIfExist['b_num'];
            $ln_num = $checkApproIfExist['ln_num'];
        }

        // insert line
        if($flag = 'true')
        {
          if (count($r->codes)) 
          {
              for ($i=0; $i < count($r->codes); $i++, $ln_num++) 
              {
                  $insertIntoBgtps02 =
                      [
                          'b_num' => $b_num,
                          'seq_num' => $ln_num,
                          'seq_desc' => $r->desc[$i],
                          'at_code' => $r->codes[$i],
                          'sl_code' => '',
                          'sl_name' => '',
                          'appro_amnt' => $r->amt[$i],
                          'grpid' => $r->subgrpid[$i],
                      ];
                  if (Core::insertTable('rssys.bgtps02', $insertIntoBgtps02, 'Budget Proposal Entry')) 
                  {
                    $flag = 'true';
                  } 
                  else 
                  {
                    return 'false';
                  }
              }
          }
        }

        return $r->fy;
    }

    public function getAcctDesc($code)
    {
        $data = Budget::get_AcctRemarks($code);

        return $data->remarks;
    }
}