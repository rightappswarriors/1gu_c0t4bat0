<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use Carbon\Carbon;
use DB;

class disbursement_entry extends Controller
{
	public function __construct(){
		// $this->x03 = Core::getAll('x03',true);
	}

	 public function view() 
    {
    	$arrForFilter = [
    		'period' => Core::getAll('rssys.x03',['fy','month_desc'],[],true),
    		'journal' => Core::getAll('rssys.m05',['j_code','j_desc'],[['j_type','D']],true),
    		'branch' => Core::getAll('rssys.branch',['code','name'],[],true),
            'entryData' => DB::select("SELECT DISTINCT tr01.j_code, tr01.j_num, tr01.payee, tr01.t_desc, tr01.t_date, branch.name from rssys.tr01 
                                        join rssys.tr02 on tr02.j_num = tr01.j_num AND tr02.j_code = tr01.j_code 
                                        join rssys.m04 on m04.at_code = tr02.at_code 
                                        join rssys.branch on branch.code = tr01.branch 
                                        WHERE tr01.cancel = FALSE AND tr01.j_code IN (SELECT m5.j_code FROM rssys.m05 m5 WHERE m5.j_type='D')")
    	];
        return view('accounting.disbursement_entry',$arrForFilter);
    }
    public function entries(Request $request,$j_code) 
    {
    	if(isset($j_code)){
	    	if(!Core::isDataExistOn('rssys.m05',[['j_code',$j_code]])){
	    		return abort(404);
	    	}
	    	if($request->isMethod('get')){
		    	$arrRet = [
                    'action' => 'add',
		    		'journal' => Core::isDataExistOn('rssys.m05',[['j_code',$j_code]],true),
		    		'm04' => Core::getAll('rssys.m04',['at_code','at_desc','cib_acct'],[['active',TRUE],['payment','Y']],true),
		    		'm08' => Core::getAll('rssys.m08',['cc_code','cc_desc'],[['active',TRUE]],true),
		    		'm06' => Core::getAll('rssys.m06',['d_code','d_name'],[['active',TRUE]],true),
                    'subctr' => Core::getAll('rssys.subctr',['scc_code','scc_desc'],[['active',TRUE]],true),
                    'payee' => Core::getAll('rssys.payee','*',[],true),		    		
		    		'j_code' => $j_code,
		    		'branch' => DB::SELECT("SELECT code, name FROM rssys.branch")	
		    	];
		        return view('accounting.disbursement_entry_new',$arrRet);
	        } else {
                if($request->has('action')){
                    switch ($request->action) {
                        case 'getcib-acct':
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                }
            }
    	}
    	return abort(404);
    }

    public function edit($j_code,$j_num) 
    {   
        if(isset($j_code) && isset($j_num)){
            $joinedDis = DB::select("SELECT DISTINCT tr01.t_date, tr01.t_desc,tr01.branch,tr03.j_memo,m04.at_code as paythru,tr01.ck_num,tr01.ck_date,tr01.payee from rssys.tr01 join rssys.tr02 on tr02.j_num = tr01.j_num AND tr02.j_code = tr01.j_code left join rssys.tr03 on tr03.j_num = tr01.j_num AND tr03.j_code = tr01.j_code join rssys.m04 on m04.at_code = tr02.at_code join rssys.branch on branch.code = tr01.branch  WHERE (tr01.j_code = '$j_code' AND tr01.j_num = '$j_num' AND tr01.cancel = FALSE AND tr01.j_code IN (SELECT m5.j_code FROM rssys.m05 m5 WHERE m5.j_type='D'))");
            if(count($joinedDis) < 1){
                return abort(404);
            }
            try {

                $arrRet = [
                    'action' => 'edit',
                    'j_code' => $j_code,
                    'j_num' => $j_num,
                    'journal' => Core::isDataExistOn('rssys.m05',[['j_code',$j_code]],true),
                    'm04' => Core::getAll('rssys.m04',['at_code','at_desc','cib_acct'],[['active',TRUE],['payment','Y']],true),
                    'm08' => Core::getAll('rssys.m08',['cc_code','cc_desc'],[['active',TRUE]],true),
                    'm06' => Core::getAll('rssys.m06',['d_code','d_name'],[['active',TRUE]],true),
                    'subctr' => Core::getAll('rssys.subctr',['scc_code','scc_desc'],[['active',TRUE]],true),
                    'payee' => Core::getAll('rssys.payee','*',[],true),                   
                    'j_code' => $j_code,
                    'branch' => DB::SELECT("SELECT code, name FROM rssys.branch"),
                    'data' => [$joinedDis[0],DB::select("SELECT DISTINCT tr02.*, m04.at_desc from tr01 join tr02 on tr02.j_num = tr01.j_num AND tr02.j_code = tr01.j_code AND COALESCE(tr02.sl_code,'')<> '' join m04 on m04.at_code = tr02.at_code WHERE (tr01.cancel = FALSE AND tr01.j_code = '$j_code' AND tr01.j_num = '$j_num' AND tr01.j_code IN (SELECT m5.j_code FROM rssys.m05 m5 WHERE m5.j_type='D'))"),DB::select("SELECT DISTINCT tr02.*, m04.at_desc from tr01 join tr02 on tr02.j_num = tr01.j_num AND tr02.j_code = tr01.j_code AND tr02.sl_code = '' join m04 on m04.at_code = tr02.at_code WHERE (tr01.cancel = FALSE AND tr01.j_code = '$j_code' AND tr01.j_num = '$j_num' AND tr01.j_code IN (SELECT m5.j_code FROM rssys.m05 m5 WHERE m5.j_type='D'))")[0]]
                ];
                return view('accounting.disbursement_entry_new',$arrRet);
            } catch (Exception $e) {
                return $e;
            }
        }
        
        return abort(404);
    }


    public function cancel(Request $request){
        $module = 'Disbursement Entry';
        try {
             if(Core::addDTUAtoThis('tr01',[['j_code',$request->j_code],['j_num',$request->j_num]],$module)){
                Core::alert(1, 'Canceled  data in '.$module);
                return back();
            }
        } catch (Exception $e) {
            Core::alert(2, 'occured upon modiification of data in '.$module);
            return back()->with($e);
        }
       
    }


     public function save(Request $r, $j_code = null, $j_num = null)
     {   
        if(isset($r->at_codeLine) && isset($r->sl_code) && count($r->at_codeLine) == count($r->sl_code) && count($r->at_codeLine) == count($r->seq_desc)){
        	$var = (isset($j_code) && isset($j_num) ? $j_num : Core::get_nextincrementlimitchar(DB::select("SELECT MAX(j_num) FROM rssys.m05 WHERE j_code = '$r->j_code'")[0]->max,8));
        	$insertIntotr01 =
            [
                'fy' => Date('Y',strtotime($r->t_date)),
                'mo' => Date('n',strtotime($r->t_date)), 
                'j_code' => ($r->j_code ?? $j_code),
                'j_num' => $var, 
                't_date' => $r->t_date,
                't_desc' => $r->t_desc,
                'payee' => $r->payee,
                'ck_date' => $r->ck_date,
                'ck_num' => $r->ck_num,
                'branch' => $r->branch, 
                'user_id' => session()->get('_user')['id'],
                'systime' => date('H:i:s',strtotime('now')),
                'sysdate' => date('Y-m-d',strtotime('now')),
                'cancel' => FALSE
            ];
            $insertIntotr03 =
            [
                'j_code' => ($r->j_code ?? $j_code),
                'j_num' => $var,
                'j_memo' => $r->j_memo,
            ];
            if((isset($j_code) && isset($j_num) ? DB::table('rssys.tr01')->where([['j_code',$j_code],['j_num',$j_num]])->update($insertIntotr01) &&  DB::table('rssys.tr03')->where([['j_code',$j_code],['j_num',$j_num]])->update($insertIntotr03) : Core::insertTable('rssys.tr01', $insertIntotr01, 'Disbursement Entry') && Core::insertTable('rssys.tr03', $insertIntotr03, 'Disbursement Entry'))){
                if(!Core::isDataExistOn('rssys.payee',[['payee',$r->payee]])){
                    DB::table('rssys.payee')->insert(['payee' => $r->payee]);
                }

                if(!isset($j_code) && !isset($j_num)){
                    DB::table('rssys.m05')->update(['j_num' => $var]);
                }
                if(isset($j_code) && isset($j_num)){
                    Core::deleteTableMultiWhere('rssys.tr02',[['j_code',$j_code],['j_num',$j_num]],'Disbursement Entry');
                }
                $counter = 1;
                for ($i=0; $i < count($r->sl_code); $i++) {
                    $keysFortr02 =
                    [
                        'j_code',
                        'j_num',
                        'seq_num',
                        'at_code',
                        'sl_code',
                        'sl_name',
                        'cc_code',
                        'prj_code',
                        'debit',
                        'credit',
                        'invoice',
                        'seq_desc',
                        'rep_code',
                        'pay_code',
                        'or_code',
                        'or_lne'
                    ];

                    for ($j=0; $j < 2; $j++) { 
                        $valuesFortr02 = [
                            [
                                // first line
                                ($r->j_code ?? $j_code),
                                $var,
                                $counter,
                                $r->at_codeLine[$i],
                                $r->sl_code[$i],
                                (DB::table('rssys.m06')->where('d_code',$r->sl_code[$i])->select('d_name')->first()->d_name ?? null),
                                $r->cc_code[$i],
                                $r->scc_code[$i],
                                str_replace( ',', '', $r->amount[$i] ),
                                0.00,
                                $r->invoice[$i],
                                $r->seq_desc[$i],
                                '',
                                '',
                                NULL,
                                NULL
                            ],
                            [
                                // second line
                                ($r->j_code ?? $j_code),
                                $var,
                                $counter,
                                $r->at_codeLine[$i],
                                '',
                                '',
                                '',
                                '',
                                0.00,
                                str_replace( ',', '', $r->payAmount ),
                                '',
                                '',
                                '',
                                $r->at_code,
                                NULL,
                                NULL
                            ]   
                        ];
                        $counter++;
                        if (!Core::insertTable('rssys.tr02', array_combine($keysFortr02, $valuesFortr02[$j]), 'Collection Entry')) {
                            return 'ERROR';
                        } 
                    }
                }
                return 'success';

            }

            return $var;

        } else {
            return 'Please check Your Data for any unanswered entry';
           }
       }
}