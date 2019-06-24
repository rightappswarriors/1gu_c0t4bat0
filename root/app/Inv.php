<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Carbon\Carbon;

class Inv extends Model
{
	public static function saveToStkcrd($data = [])
	{
        try 
		{
			if ($table!=null) 
			{
				if (!empty($data)) 
				{
					if (DB::table(DB::raw('stkcrd'))->insert($data)) 
					{
						return true;
					}
				}
			}
			else
			{
				return false;
			}
			
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Inv::alert(0, '');
			return false;
		}
	}
}

?>