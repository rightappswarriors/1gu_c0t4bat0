<?php

namespace App\Http\Controllers\Collection;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use Carbon\Carbon;
use DB;

class c_collection_entry extends Controller
{
	public function __construct()
    {
        $this->retArr = [];
        $SQLrp_class = "SELECT * FROM rssys.rp_class  WHERE active = TRUE";
        $this->rp_class = Core::sql($SQLrp_class);
        $SQLm05 = "SELECT * FROM rssys.m05  WHERE active = TRUE";
        $this->m05 = Core::sql($SQLm05);
        $SQLm06 = "SELECT * FROM rssys.m06  WHERE active = TRUE";
        $this->m06 = Core::sql($SQLm06);
        $this->or_type = Core::getAll('rssys.or_types');
        $this->m10 = Core::getAll('rssys.m10');
        $this->soa = Core::getAll('rssys.soalne');
        $this->fund = Core::getAll('rssys.fund');
        $sql = "SELECT uid, opr_name AS name FROM rssys.x08 WHERE rssys.x08.grp_id = '005'";
        $this->cashiers = Core::sql($sql);
        $SQLM04 =   "SELECT * FROM rssys.m04 WHERE active = TRUE AND payment = 'Y'";
        $SQLM04_2 = "SELECT * FROM rssys.m04 WHERE active = TRUE AND payment = 'N'";
        $this->m04 = DB::select($SQLM04);
        $this->m04_2 = DB::select($SQLM04_2);
        
        // $this->retArr2 = array_reverse($this->retArr);
        // sort($this->retArr2);
        // SOOO LAG
        // $this->retArr2 = sort($this->retArr2);
        // $this->retArr = [];
    }

    public function view() // TO VIEW COLLECTION ENTRY LIST MODULE
    {
        $sql = "SELECT * FROM rssys.colhdr AS colhd
                LEFT JOIN rssys.or_types AS or_typ ON colhd.or_type = or_typ.or_type
                LEFT JOIN rssys.x08 AS cashier ON colhd.coll_code =  cashier.uid
                LEFT JOIn rssys.fund AS fnd ON colhd.fid = fnd.fid
                ORDER BY colhd.col_code ASC
                ";
        $sqlData = Core::sql($sql);
    	return view('collection.collection_collection_entry', ['col_hdr' => $sqlData]);
    }
    public function getEntries(Request $r) // TO GET COLLECTION ENTRIES MODULE
    {
    	$sql = "SELECT * FROM rssys.bgt01
                LEFT JOIN rssys.branch ON rssys.bgt01.branch = rssys.branch.code
                LEFT JOIN rssys.m08 ON rssys.bgt01.cc_code = rssys.m08.cc_code
                LEFT JOIN rssys.fund ON rssys.bgt01.fid = rssys.fund.fid
                LEFT JOIN rssys.sector ON rssys.bgt01.secid = rssys.sector.secid
                WHERE rssys.bgt01.fy = '$r->fy' AND
                rssys.bgt01.mo BETWEEN '$r->dt_frm' AND '$r->dt_to'
                    ORDER BY rssys.bgt01.b_num ASC";
    	$data = Core::sql($sql3);
    	return $data;
    }
    public function getEntries2(Request $r) // TO GET COLLECTION ENTRIES MODULE (FILTERED BY DATE)
    {
        $dt = Carbon::parse($r->fy.'-'.$r->dt_frm.'-01')->toDateString();
        $dt2 = Carbon::parse($r->fy.'-'.$r->dt_to.'-01')->endOfMonth()->toDateString();
        // return $dt2;
        $sql2 = "SELECT * FROM rssys.bgt01
                LEFT JOIN rssys.branch ON rssys.bgt01.branch = rssys.branch.code
                LEFT JOIN rssys.m08 ON rssys.bgt01.cc_code = rssys.m08.cc_code
                LEFT JOIN rssys.fund ON rssys.bgt01.fid = rssys.fund.fid
                LEFT JOIN rssys.sector ON rssys.bgt01.secid = rssys.sector.secid
                WHERE rssys.bgt01.fy = '$r->fy' AND
                rssys.bgt01.t_date BETWEEN '$dt' AND '$dt2'
                    ORDER BY rssys.bgt01.b_num ASC";
        $sql = "SELECT * FROM rssys.bgtps01
                LEFT JOIN rssys.branch ON rssys.bgtps01.branch = rssys.branch.code
                LEFT JOIN rssys.m08 ON rssys.bgtps01.cc_code = rssys.m08.cc_code
                LEFT JOIN rssys.fund ON rssys.bgtps01.fid = rssys.fund.fid
                LEFT JOIN rssys.sector ON rssys.bgtps01.secid = rssys.sector.secid
                WHERE rssys.bgtps01.fy = '$r->fy' AND 
                rssys.bgtps01.mo BETWEEN '$r->dt_frm' AND '$r->dt_to'
                    ORDER BY rssys.bgtps01.b_num ASC";
        $data = Core::sql($sql);
        return $data;
    }
    public function new() // TO VIEW NEW COLLECTION ENTRY 
    {
        // SOOO LAG


        $data = DB::select("SELECT * FROM rssys.or_issuance ORDER BY or_no DESC");
        $min = ""; $max = "";
        if(count($data) > 0) {
            for($j = 0; $j < count($data); $j++)
            {
                $min = $data[$j]->or_no; $max = $data[$j]->or_no_to;
                if(isset($min) && isset($max)) { for($i = intval($min); $i <= intval($max); $i++) {
                    $n_or_no = str_pad($i, strlen($data[$j]->or_no), "0", STR_PAD_LEFT);
                    if(count(DB::select("SELECT * FROM rssys.colhdr WHERE or_no = '$n_or_no'")) < 1) {
                        array_push($this->retArr, $n_or_no);
                    }
                } }
            }
        }
        // return dd($this->retArr);
    	return view('collection.collection_collection_entry_new', ['m05'=>$this->m05, 'or_type' => $this->or_type, 'm06' => $this->m06, 'm10' => $this->m10, 'soa' => $this->soa, 'fund' => $this->fund, 'cashiers' => $this->cashiers, 'm04'=>$this->m04, 'm04_2' => $this->m04_2, 'or_num' =>$this->retArr]);
    }
    public function getORTypes(Request $r) // TO GET OR TYPE 
    {
        $data = DB::select("SELECT * FROM rssys.or_issuance WHERE '$r->id' BETWEEN or_no AND or_no_to");
        // return $r->all();
        return $data;
    }
    public function getOrIssuance(Request $r) // TO GET OR ISSUANCE 
    {
        // return $r->all();
        // SELECT 1 FROM rssys.or_issuance WHERE collector=&#39;&lt;cashier&gt;&#39; AND or_type=&lt;or_type&gt; AND &lt;or_num&gt; BETWEEN or_from AND or_to
        // $data = DB::select()
        // SELECT DISTINCT or_no FROM rssys.or_issuance WHERE collector = '' AND or_type = '' ORDER BY or_no ASC
        // SELECT DISTINCT or_no_to FROM rssys.or_issuance WHERE collector = '' AND or_type = '' ORDER BY or_no_to ASC

        // SELECT MIN(or_no) AS  min, MAX(or_no_to) AS max FROM rssys.or_issuance WHERE collector = '$r->cashier' AND or_type = '$r->or'
        $data =  DB::select("SELECT MIN(or_no) AS or_no, MAX(or_no_to) AS or_no_to FROM rssys.or_issuance WHERE collector = '$r->cashier' AND or_type = '$r->or' ORDER BY or_no DESC");
        // $data1 = DB::select("SELECT DISTINCT or_no_to FROM rssys.or_issuance WHERE collector = '$r->cashier' AND or_type = '$r->or' ORDER BY or_no_to DESC");
        // ,'or_no_to'=>$data1
        $retArr = []; $min = ""; $max = "";
        if(count($data) > 0) {
            $min = $data[0]->or_no; $max = $data[0]->or_no_to;
            if(isset($min) && isset($max)) { for($i = intval($min); $i <= intval($max); $i++) {
                $n_or_no = str_pad($i, strlen($data[0]->or_no), "0", STR_PAD_LEFT);
                if(count(DB::select("SELECT * FROM rssys.colhdr WHERE or_no = '$n_or_no'")) < 1) {
                    array_push($retArr, $n_or_no);
                }
            } }
        }
        $retArr2 = array_reverse($retArr);
        return response()->json(['or_no'=> $retArr2, 'asdf'=>[$min, $max]]);
        // return 'TEST';
    }
    public function getOrIssuance2(Request $r) // TO GET OR ISSUANCE (FILTERED)
    {
        $data = DB::select("SELECT 1 FROM rssys.or_issuance WHERE collector='$r->cashier' AND or_type='$r->or' AND or_no BETWEEN '$r->frm' AND '$r->to'");
        // return $r->all();
        return $data;
    }
    public function save(Request $r) // TO ADD NEW COLLECTION ENTRY
    {
        // return dd($r->all());
        $dt = Carbon::now();
    	$b_num = Core::getm99One('col_code');
        $sql00 = "SELECT j_num FROM rssys.m05 WHERE j_code = '$r->col_code'";
        $testData = Core::sql($sql00);
    	$insertIntoBgt01 =
    		[
                'col_code' => $b_num->col_code,
                'debt_code' => $r->cust,
                'debt_name' => $r->cust_name,
                'trnx_date' => $r->dt,
                'or_type' => $r->or_typ,
                'or_ref' => $r->ref,
                'coll_code' => $r->cashier,
                'jrnlz' => 'N',
                'cancel' => 'N',
                'user_id' => strtoupper(Session::get('_user')['id']),
                't_date' => $dt->toDateString(),
                't_time' => $dt->toTimeString(),
                'j_code' => $r->col_code,
                'j_num' => $testData[0]->j_num,
                't_ipaddress' => request()->ip(),
                'fid' => $r->fund,
                'or_no' => $r->or_no,
    		];
            if (Core::insertTable('rssys.colhdr', $insertIntoBgt01, 'Collection Entry')) {
                Core::updatem99('col_code', Core::get_nextincrementlimitchar($b_num->col_code, 8));
             if (count($r->pay_typ)) {
                 for ($i=0, $j = 1; $i < count($r->pay_typ); $i++, $j++) {
                     $insertIntoBgt02 =
                         [
                             'or_code' => $b_num->col_code,
                             'ln_num' => $j,
                             'type' => $r->pay_typ[$i],
                             // 'chk_num' => $r->chk_num[$i],
                             // 'chk_date' => $r->chk_dt[$i],
                             'amount' => floatval($r->amt[$i]),
                             // 'deposited' => $r->is_dep[$i],
                             'soa_code' => $r->soa_code[$i],
                             'payment_desc' => $r->pay_desc[$i],
                             'tin' => $r->tin[$i],
                             'td_bus_id' => $r->td_id[$i],
                             'payment_type' => $r->typ[$i],
                             'payer' => $r->payer[$i],
                         ];
                    // return dd(Core::insertTable('rssys.collne2', $insertIntoBgt02, 'Collection Entry'));
                     if (Core::insertTable('rssys.collne2', $insertIntoBgt02, 'Collection Entry')) {
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
    public function edit($b_num) // TO VIEW EXISTING COLLECTION ENTRY
    {
    	$sql1 = "SELECT * FROM rssys.colhdr
				WHERE rssys.colhdr.col_code = '$b_num'
    			";

    	$sql2 = "SELECT * FROM rssys.collne2
                LEFT JOIN  rssys.m10 ON rssys.collne2.type = rssys.m10.mp_code
    			WHERE rssys.collne2.or_code = '$b_num'
    			ORDER BY rssys.collne2.ln_num ASC
    			";
    	$d1 = Core::sql($sql1);
    	$d2 = Core::sql($sql2);
        // return dd($d2);
    	return view('collection.collection_collection_entry_view', ['m05'=>$this->m05, 'or_type' => $this->or_type, 'm06' => $this->m06, 'm10' => $this->m10, 'soa' => $this->soa, 'fund' => $this->fund, 'cashiers' => $this->cashiers, 'colhdr' =>$d1, 'colne' => $d2,  'm04_2' => $this->m04_2, 'm04'=>$this->m04,]);
    }
    public function update(Request $r) // TO UPDATE EXISTING COLLECTION ENTRY
    {
        // return dd($r->all());
        $dt = Carbon::now();
        $sql00 = "SELECT j_num FROM rssys.m05 WHERE j_code = '$r->col_code'";
        $testData = Core::sql($sql00);
        $insertIntoBgt01 =
            [
                'col_code' => $r->b_num,
                'debt_code' => $r->cust,
                'debt_name' => $r->cust_name,
                'trnx_date' => $r->dt,
                'or_type' => $r->or_typ,
                'or_ref' => $r->ref,
                'coll_code' => $r->cashier,
                'jrnlz' => 'N',
                'cancel' => 'N',
                'user_id' => strtoupper(Session::get('_user')['id']),
                't_date' => $dt->toDateString(),
                't_time' => $dt->toTimeString(),
                'j_code' => $r->col_code,
                'j_num' => $testData[0]->j_num,
                't_ipaddress' => request()->ip(),
                'fid' => $r->fund,
            ];
        $del = [['or_code', '=', $r->b_num]];
        Core::deleteTableMultiWhere('rssys.collne2', $del, 'Collection Entry' );
        if (Core::updateTable('rssys.colhdr', 'col_code', $r->b_num, $insertIntoBgt01, 'Collection Entry')) 
        {
            if (count($r->pay_typ)) {
                for ($i=0, $j = 1; $i < count($r->pay_typ); $i++, $j++) {
                     $insertIntoBgt02 =
                         [
                             'or_code' => $r->b_num,
                             'ln_num' => $j,
                             'type' => $r->pay_typ[$i],
                             // 'chk_num' => $r->chk_num[$i],
                             // 'chk_date' => $r->chk_dt[$i],
                             'amount' => floatval($r->amt[$i]),
                             // 'deposited' => $r->is_dep[$i],
                             'soa_code' => $r->soa_code[$i],
                             'payment_desc' => $r->pay_desc[$i],
                             'tin' => $r->tin[$i],
                             'td_bus_id' => $r->td_id[$i],
                             'payment_type' => $r->typ[$i],
                             'payer' => $r->payer[$i],
                         ];
                     if (Core::insertTable('rssys.collne2', $insertIntoBgt02, 'Collection Entry') != true) {
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
    //     $sql = 'SELECT * FROM rssys.bgtps01';
    //     return Core::sql($sql);
    // }
    public function import_view() // TO VIEW COLLECTION ENTRY IMPORT
    {
        // return dd($this->retArr2)
        return view('collection.collection_collection_entry_import', ['m04_2'=>$this->m04_2, 'soa' => $this->soa, 'fund' =>  $this->fund, 'm05' => $this->m05, 'or_type' => $this->or_type, 'cashiers' => $this->cashiers, 'm06' => $this->m06, 'real' => $this->rp_class]);
    }
    public function import(Request $r) // TO IMPORT CSV FILE
    {
        // return dd($r->all());
        // DONT ERASE THIS Youtube LINKS for reference - Bossmhelzkie
        // https://www.youtube.com/watch?v=6P_nqOX38CE
        // https://www.youtube.com/watch?v=m7kQ1pYL1dc
        $upload = $r->file('file');
        $error = [];
        $filePath = $upload->getRealPath();

        $file = fopen($filePath, 'r');
        // dd($header);

        // $header = fgetcsv($file, 9999);
        $head = array(); $data = array(); $temp = array();
        $test001 = array_map('str_getcsv', file($filePath));

        $head["name"] = $test001[7][3];
        $head["period"] = $test001[7][13];
        $head["officer"] = $test001[9][3];

        $chck_officerSQL = "SELECT uid, opr_name FROM rssys.x08 WHERE rssys.x08.grp_id = '005' AND opr_name LIKE '%".$head["officer"]."%'";
        // $chck_officer = DB::select($chck_officerSQL);
        // DB::table(DB::raw('rssys.m04'))->where('acro', 'like', '%'.urlencode($temp4["tax_type"]).'%')->pluck('at_code');
        $chck_officer = DB::table(DB::raw('hris.hr_employee'))->where(DB::raw('CONCAT(firstname, \' \', mi, \' \',lastname) LIKE \'%'.$head["officer"].'%\' AND positions = \'CSH\''))->pluck('empid');
        // [['positions', 'CSH'], ['CONCAT(firstname, \' \', mi, \' \',lastname)', 'like', '%'.$head["officer"].'%']]
        // $chck_officer = DB::table(DB::raw('rssys.x08'))->where([['grp_id', '005'], ['opr_name', 'like', '%'.$head["officer"].'%']])->pluck('uid');
        // if(count($chck_officer) <= 0)
        // {
        //     array_push($error, $head["officer"].'  Not Found/Registered in the system.');
        // }
        $head["chk_ofc"] =  $chck_officer;

        for($i = 13; $i < count($test001) ;$i++)
        {
            if($test001[$i][0] == "Date :"){
                array_push($temp, $i);
            }
            if(strpos($test001[$i][0], "Run Date") != false)  {
                array_push($temp, ($i - 2));
                break;
            }
        }

        if(count($temp) > 0)
        {
            for($i = 0; $i < count($temp); $i ++)
            {
                $temp2 = array(); $temp3 = array();
                $dt = Carbon::parse($test001[$temp[$i]][2]);
                $temp2["date"] = $dt->toDateString();
                $temp2["or_no"] = $test001[$temp[$i] + 1][3];
                $chck_or_typeSQL = "SELECT or_type FROM rssys.or_issuance WHERE '".$temp2["or_no"]."' BETWEEN  or_no AND or_no_to";
                $chck_or_type = DB::select($chck_or_typeSQL);
                if(count($chck_or_type) <=0)
                {
                    array_push($error, 'OR Type for '.$temp2["or_no"].' is not found.');
                }
                $temp2["chk_or_type"] = $chck_or_type;

                $temp2["paid_by"] = substr($test001[$temp[$i] + 1][7], 10, strlen($test001[$temp[$i] + 1][7]));
                $temp2["paid_by"] = ($temp2["paid_by"] == false) ? "" : $temp2["paid_by"];
                $temp2["paid_by_encode"] = urlencode($temp2["paid_by"]);
                // DB::table(DB::raw('rssys.m04'))->where('acro', 'like', '%'.urlencode($temp4["tax_type"]).'%')->pluck('at_code');
                // $chck_customerSQL = ($temp2["paid_by"] == false || $temp2["paid_by"] == '') ? '' : "SELECT d_code FROM rssys.m06 WHERE active = true AND d_name LIKE '%".$temp2["paid_by"]."%'";
                $WHERE_EXTRA = ""; $new_payer = explode(", ", $temp2["paid_by"]);
                foreach($new_payer AS $ePayer) { $ePayers = ((!empty($ePayer)) ? preg_replace('/[^\p{L}\p{N}\s]/u', '', $ePayer) : "no_user_found"); $WHERE_EXTRA .= " AND UPPER(d_name) LIKE UPPER('%$ePayers%')"; }
                $chck_customerSQL = "SELECT d_code FROM rssys.m06 WHERE active = true AND (1=1 $WHERE_EXTRA)";
                $chck_customer = DB::select($chck_customerSQL);
                // $chck_customer = ($temp2["paid_by"] == false || $temp2["paid_by"] == '') ? '' : DB::table(DB::raw('rssys.m06'))->where('active', '=', true)->where('d_name', 'like', '%'.$temp2["paid_by"].'%')->pluck('d_code');
                $temp2["chk_customer"] = $chck_customer;
                // $temp2["chk_customer"] = mb_convert_encoding($temp2["chk_customer"], 'UTF-8', 'UTF-8');

                // $chkc_customer = ($temp2["paid_by"] != '') ? DB::table(DB::raw('rssys.m06'))->where('d_name', 'like', '%'.$temp2["paid_by"].'%')->pluck('d_code') : '';
                // $temp2["chck_customer"] = ($temp2["paid_by"] != '') ? $chkc_customer : '';
                $temp2["no"] = $test001[$temp[$i] + 1][5];
                 $_start = 0; $_end = 0;
                if(isset($temp[$i + 1])) {
                    $_start = ($temp[$i] + 2); $_end = $temp[$i + 1] - 1;
                } else {
                    $_start = ($temp[$i] + 2); $_end = count($test001)-7;
                }
                for($j = $_start; $j < $_end; $j++)
                    {
                        $temp4 = array();

                        if( $test001[$j][0] != '') {

                            $temp4["local_tin"] = $test001[$j][0];
                            $temp4["to_bus"] = $test001[$j][4];
                            $temp4["tax_payer"] = $test001[$j][7];
                            $temp4["type"] = $test001[$j][8];
                            $temp4["tax_type"] = $test001[$j][9];
                            // $tax_codSQL = "SELECT at_code FROM rssys.m04 WHERE acro LIKE '%".urlencode($temp4["tax_type"])."%'";
                            // $temp4["tax_type_SQL"] = $tax_codSQL;
                            // $tax_code = DB::select($tax_codSQL);
                            $tax_code = DB::table(DB::raw('rssys.m04'))->where('acro', 'like', '%'.urlencode($temp4["tax_type"]).'%')->pluck('at_code');
                            // if($tax_code == null)
                            // {
                            //     array_push($error, 'Tax Code for '.$temp4["tax_type"].' is not found.');
                            // }
                            $temp4["tax_code"] = $tax_code;
                            // $temp4["tax_pay_id"] = DB::select('SELECT * FROM');
                            $temp4["amt"] = str_replace(',', '' , $test001[$j][16]);
                            array_push($temp3, $temp4);
                        }
                        // else {
                        // }
                        $temp2["data"] = $temp3;
                    }

                    array_push($data, $temp2);
            }
        }
        // return array_values(array_unique($error));
        // return Core::convert_from_latin1_to_utf8_recursively($data);
        $data2 = Core::convert_from_latin1_to_utf8_recursively($data);
        return response()->json(['status'=>'DONE', 'header' => $head, 'data' =>$data2, 'error' => array_values(array_unique($error)), 'error_count' => count(array_unique($error))]);
        // return $data;

        // $escapedHeader=[];
        //validate
        // foreach ($header as $key => $value) {
        //     $lheader=strtolower($value);
        //     $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
        //     array_push($escapedHeader, $escapedItem);
        // }
        // $data = [];$data2 = [];
        // while ($columns = fgetcsv($file)) {
            // if($columns[0]=="" || $columns[1]=="")
            // {
            //     continue;
            // }
            //trim data
            // foreach ($columns as $key => &$value) {
            //     $value=preg_replace('/\D/','',$value);
            // }

           // $data= array_combine($escapedHeader, $columns);
           // $arrayGOD = array_push($data2, $data);

           // setting type
           // foreach ($data as $key => &$value) {
           //  $value=($key=="zip" || $key=="month")?(integer)$value: (float)$value;
           // }
        // }

        // return $data2;
        // if(count($data2) > 0) {
        //     for ($i=0, $j = 1; $i < count($data2); $i++, $j++) {
        //              $insertIntoBgt02 =
        //                  [
        //                      'or_code' => '00000006',
        //                      'ln_num' => $j,
        //                      'type' => $data2[$i]['type'],
        //                      'chk_num' => ($data2[$i]['checknumber'] != '') ? $data2[$i]['checknumber'] : null,
        //                      'chk_date' => ($data2[$i]['checkdate'] != '') ? $data2[$i]['checkdate'] : null,
        //                      'amount' => floatval($data2[$i]['amount']),
        //                      'deposited' => ($data2[$i]['deposited'] != '') ? $data2[$i]['deposited'] : null,
        //                      'soa_code' => ($data2[$i]['soa'] != '') ? $data2[$i]['deposited'] : null,
        //                      'payment_desc' => $data2[$i]['description']
        //                  ];
        //              if (Core::insertTable('rssys.collne2', $insertIntoBgt02, 'Collection Entry')) {
        //              } else {
        //                  return 'ERROR';
        //                  break;
        //              }
        //          }
        //          return 'DONE';
        // }
    }
    public function saveImport(Request $r) // TO SAVE THE IMPORTED CSV FILE
    {
        if(isset($r->hd_or_num)){
            for ($i=0; $i < count($r->hd_or_num); $i++) { 
                $dt = Carbon::now();
                $b_num = Core::getm99One('col_code');
                $fromImport = $r->hd_jr[$r->hd_or_num[$i]];
                $sql00 = "SELECT j_num FROM rssys.m05 WHERE j_code = '$fromImport'";
                $testData = Core::sql($sql00);
                $insertIntoBgt01 =
                [
                    'col_code' => $b_num->col_code,
                    'debt_code' => ($r->hd_cust[$r->hd_or_num[$i]] ?? 'NOT SET'),
                    'debt_name' => (DB::table('rssys.m06')->where('d_code',$r->hd_cust[$r->hd_or_num[$i]])->select('d_name')->first()->d_name ?? 'NOT FOUND'),
                    'trnx_date' => ($r->hd_dt[$r->hd_or_num[$i]] ?? Date('Y-m-d')),
                    'or_type' => ($r->hd_or_typ[$r->hd_or_num[$i]] ?? Date('Y-m-d')),
                    'or_ref' => 'From Import',
                    'coll_code' => $r->hdr_cash,
                    'jrnlz' => 'N',
                    'cancel' => 'N',
                    'user_id' => strtoupper(Session::get('_user')['id']),
                    't_date' => $dt->toDateString(),
                    't_time' => $dt->toTimeString(),
                    'j_code' => $fromImport,
                    'j_num' => $testData[0]->j_num,
                    't_ipaddress' => request()->ip(),
                    'fid' => ($r->hd_fund[$r->hd_or_num[$i]] ?? Date('Y-m-d')),
                    'rptype' => ($r->hd_real_property[$r->hd_or_num[$i]] ?? 'NOT SET'),
                    'or_no' => $r->hd_or_num[$i], // get this
                ];
                if (Core::insertTable('rssys.colhdr', $insertIntoBgt01, 'Collection Entry') == true) {
                    Core::updatem99('col_code', Core::get_nextincrementlimitchar($b_num->col_code, 8));
                    if (count($r->hiddentax_typ_id[$r->hd_or_num[$i]])) {
                         for ($k=0, $j = 1; $k < count($r->hiddentax_typ_id[$r->hd_or_num[$i]]); $k++, $j++) {
                             $insertIntoBgt02 =
                                 [
                                     'or_code' => $b_num->col_code,
                                     'ln_num' => $j,
                                     'type' => $r->hiddenpy_typ[$r->hd_or_num[$i]][$k],
                                     // 'chk_num' => $r->chk_num[$i],
                                     // 'chk_date' => $r->chk_dt[$i],
                                     'amount' => floatval($r->hiddenamt[$r->hd_or_num[$i]][$k]),
                                     // 'deposited' => $r->is_dep[$i],
                                     'soa_code' => $r->hiddensoa_code[$r->hd_or_num[$i]][$k],
                                     'payment_desc' => urldecode($r->hiddentax_typ_id[$r->hd_or_num[$i]][$k]),
                                     'tin' => $r->hiddentin[$r->hd_or_num[$i]][$k],
                                     'td_bus_id' => $r->hiddentd[$r->hd_or_num[$i]][$k],
                                     'payment_type' => $r->hiddenpy_typ[$r->hd_or_num[$i]][$k],
                                     'payer' => $r->hiddenpayer[$r->hd_or_num[$i]][$k],
                                 ];
                             if (Core::insertTable('rssys.collne2', $insertIntoBgt02, 'Collection Entry') != true) {
                                 return 'ERROR';
                                 break;
                             } 
                         }
                        Session::flash('alert', ['Success','success','Successfully save imported iTax']);
                        return redirect('accounting/collection/entry');
                    }
                }
                return 'ERROR';
            }


        }
    }
}