<?php

namespace App\Http\Controllers\Budget;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use Carbon\Carbon;
use DB;
use App\Budget;

class B_AllotmentController extends Controller
{
	public function view()
    {
        $financialyear = Budget::getX03();
        $manual = Budget::getAtCCCodeAppro();
        $fund = Budget::getFund();
        $allotment = Budget::get_AllotHeader();

        return view('budget.allotment.budget_allotment', compact('financialyear', 'manual', 'fund', 'allotment'));
    }

    public function loaddatafromappro(Request $r)
    {
        $fy = $r->fy;
        $from_mo = $r->from_mo;
        $to_mo = $r->to_mo;
        $noMo = ($to_mo - $from_mo) + 1;
        $flag = 'true';
        $type = 'A';

        $Header = Budget::loadDataFromApproHeader($fy);

        foreach($Header as $h)
        {
            $b_num = Core::getm99One('bgt01_bnum');

            $data = [ 'fy'         => $h->fy,
                      'b_num'      => $b_num->bgt01_bnum,
                      'cc_code'    => $h->cc_code,
                      'fid'        => $h->fid,
                      'secid'      => $h->secid,
                      'funcid'     => $h->funcid,
                      'mo1'        => $from_mo,
                      'mo2'        => $to_mo,
                      'bgtps_bnum' => $h->b_num,
                      'user_id'    => strtoupper(Session::get('_user')['id']),
                      'type'       => $type
                    ];

            $insertIntoBgt01 = Core::insertTable('rssys.bgt01', $data, 'Budget Allotment Entry');                   

            if ($insertIntoBgt01 == 'true') 
            {
                $flag = 'true';
                Core::updatem99('bgt01_bnum', Core::get_nextincrementlimitchar($b_num->bgt01_bnum, 8));
                
                $Line = Budget::loadDataFromApproLine($h->b_num);

                foreach($Line as $l)
                {
                    $data2 = [ 'b_num' => $b_num->bgt01_bnum,
                               'seq_num' => $l->seq_num,
                               'at_code' => $l->at_code,
                               'appro_amnt' => $l->appro_amnt,
                               'allot_amnt' => ($l->appro_amnt/12) * $noMo,
                               'grpid' => $l->grpid,
                             ];

                    $insertIntoBgt02 = Core::insertTable('rssys.bgt02', $data2, 'Budget Allotment Entry');

                    if ($insertIntoBgt02 == 'true') 
                    {
                       $flag = 'true'; 
                    }
                    else
                    {
                        return $insertIntoBgt02;
                    }
                }
            }
            else
            {
                return $insertIntoBgt01;
            }
        }

        return $flag;
    }

    public function loaddatafromoblig()
    {
        $type = 'O';
        $flag = 'true';
        $Header = Budget::loadDataFromObligHeader();

        foreach($Header as $h)
        {
            $b_num = Core::getm99One('bgt01_bnum');

            $data = [ 'fy'         => $h->fy,
                      'b_num'      => $b_num->bgt01_bnum,
                      'cc_code'    => $h->cc_code,
                      'fid'        => $h->fid,
                      'secid'      => $h->secid,
                      'funcid'     => $h->funcid,
                      'obr_code'   => $h->obr_pk,
                      't_date'     => $h->t_date,
                      'user_id'    => strtoupper(Session::get('_user')['id']),
                      'type'       => $type
                    ];

            $insertIntoBgt01 = Core::insertTable('rssys.bgt01', $data, 'Budget Allotment Entry');   

            if ($insertIntoBgt01 == 'true') 
            {
                $flag = 'true';
                Core::updatem99('bgt01_bnum', Core::get_nextincrementlimitchar($b_num->bgt01_bnum, 8));
                
                $Line = Budget::loadDataFromObligLine($h->obr_pk);

                foreach($Line as $l)
                {
                    $data2 = [ 'b_num' => $b_num->bgt01_bnum,
                               'seq_num' => $l->seq_num,
                               'at_code' => $l->at_code,
                               'oblig_amnt' => $l->amount,
                               'allot_amnt' => $l->amount,
                               'grpid' => $l->fpp,
                             ];

                    $insertIntoBgt02 = Core::insertTable('rssys.bgt02', $data2, 'Budget Allotment Entry');

                    if ($insertIntoBgt02 == 'true') 
                    {
                       $flag = 'true'; 
                    }
                    else
                    {
                        return $insertIntoBgt02;
                    }
                }
            }
            else
            {
                return $insertIntoBgt01;
            }
        }

        return $flag;
    }

    public function getdatafromappro(Request $request)
    {
        $data = explode(" - ", $request->at_code);

        $cc_code = $data[0];
        $at_code = $data[1];
        $fy = $request->fy;

        $appro_amt = Budget::getAmtAppro($fy, $at_code, $cc_code);
        
        if(count($appro_amt) > 0)
        {
            return $appro_amt[0]->appro_amnt;
        }
        else
        {
            return '0.00';
        } 
    }

    public function savemanual(Request $request)
    {
        $data = explode(" - ", $request->atcc_code);

        $cc_code = $data[0];
        $at_code = $data[1];

        $appro_amt = $request->appro_amt;
        $allot_amt = $request->allot_amt;
        $fy = $request->fy;

        $flag = 'true';
        $type = 'M';

        $getDataManual = Budget::getDataManualAppro($fy, $at_code, $cc_code);

        $b_num = Core::getm99One('bgt01_bnum');

        $data = [ 'fy'         => $getDataManual[0]->fy,
                  'b_num'      => $b_num->bgt01_bnum,
                  'cc_code'    => $cc_code,
                  'fid'        => $getDataManual[0]->fid,
                  'secid'      => $getDataManual[0]->secid,
                  'funcid'     => $getDataManual[0]->funcid,
                  'bgtps_bnum' => $getDataManual[0]->b_num,
                  'user_id'    => strtoupper(Session::get('_user')['id']),
                  'type'       => $type
                ];

        $insertIntoBgt01 = Core::insertTable('rssys.bgt01', $data, 'Budget Allotment Entry');  

        if ($insertIntoBgt01 == 'true') 
        {
            $flag = 'true';
            Core::updatem99('bgt01_bnum', Core::get_nextincrementlimitchar($b_num->bgt01_bnum, 8));

            $data2 = [ 'b_num' => $b_num->bgt01_bnum,
                       'seq_num' => 1,
                       'at_code' => $at_code,
                       'appro_amnt' => (float)preg_replace("/([^0-9\\.])/i", "", $appro_amt),
                       'allot_amnt' => (float)preg_replace("/([^0-9\\.])/i", "", $allot_amt),
                       'grpid' => $getDataManual[0]->grpid
                     ];

            $insertIntoBgt02 = Core::insertTable('rssys.bgt02', $data2, 'Budget Allotment Entry');

            if ($insertIntoBgt02 == 'true') 
            {
               $flag = 'true'; 
            }
            else
            {
                return $insertIntoBgt02;
            }
        }
        else
        {
            return $insertIntoBgt01;
        }

        return $flag;
    }

    public function print($b_num)
    {
        $Header = Budget::printAllotHdr($b_num);
        $Line = Budget::printAllotLine($b_num);
        $PPA = Budget::printAllotPPA($b_num); 

        return view('budget.allotment.budget_allot_print', compact('Header', 'Line', 'PPA'));
    }
}