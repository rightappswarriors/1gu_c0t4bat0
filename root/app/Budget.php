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
}
