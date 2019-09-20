<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Carbon\Carbon;
use Core;

class Inventory extends Model
{
    public static function getItemSearch() // items with qty
    {
        try 
		{
			$sql = "SELECT i.item_code, COALESCE(SUM(st.qty_in),0.00) - COALESCE(SUM(st.qty_out),0.00) AS qty_onhand_su, i.part_no, i.serial_no, i.tag_no, i.cartype, i.item_desc, iu.unit_shortcode AS sale_unit, i.sales_unit_id, b.brd_name, i.brd_code, i.sell_pric AS regular, i.sc_price AS senior, i.bin_loc, i.unit_cost, ig.grp_desc, i.item_grp, st.whs_code, w.whs_desc, CASE WHEN st.branch IS NULL THEN i.branch ELSE st.branch END AS branchcode, CASE WHEN branch.name IS NULL THEN ibranch.name ELSE branch.name END AS branchname, COALESCE(c_name, 'None') AS c_name, i.active AS active FROM rssys.items  i LEFT JOIN rssys.itmunit iu ON i.sales_unit_id=iu.unit_id LEFT JOIN rssys.brand b ON i.brd_code=b.brd_code LEFT JOIN rssys.itmgrp ig ON ig.item_grp=i.item_grp LEFT JOIN rssys.stkcrd st ON st.item_code=i.item_code LEFT JOIN rssys.whouse w ON w.whs_code=st.whs_code LEFT JOIN rssys.branch ON w.branch=branch.code LEFT JOIN rssys.branch ibranch ON i.branch=ibranch.code LEFT JOIN rssys.m07 m7 ON m7.c_code = i.supl_code WHERE i.active = 'true' GROUP BY i.item_code, i.part_no, i.cartype, i.item_desc,iu.unit_shortcode, i.sales_unit_id, b.brd_name, i.brd_code, i.sell_pric, i.sc_price, i.bin_loc, i.unit_cost, ig.grp_desc, i.item_grp, st.whs_code, w.whs_desc, branchcode, branchname, c_name ORDER BY item_code";
			
			return DB::select(DB::raw($sql));
		} 
		catch (\Exception $e) 
		{
			return $e->getMessage();
		}
    }

    public static function getReceivingPO()
    {
    	try
    	{
    	   $sql = "SELECT * FROM rssys.rechdr WHERE trn_type = 'P' AND (cancel != 'Y' OR cancel isnull)";
   
    	   return DB::select(DB::raw($sql));
        }
        catch(\Exception $e)
        {
        	return $e->getMessage();
        }
    }

    public static function getReceivingPOHeader($rec_num) // get rpo data header
	{	
		try 
		{
			$sql = 'SELECT * FROM rssys.rechdr WHERE rec_num = \''.$rec_num.'\' ORDER BY rec_num LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public static function getReceivingPOLine($rec_num) // get rpo data line
	{
		try
		{
            $sql = 'SELECT rl.ln_num, rl.part_no, rl.item_code, rl.item_desc, rl.recv_qty as qty, rl.unit as unit_code, it.unit_shortcode as unit_desc, rl.price, rl.discount, rl.ln_amnt, rl.net_amnt, rl.ln_vat, rl.ln_vatamt, rl.cnt_code as cc_code, m8.cc_desc, rl.scc_code, st.scc_desc FROM rssys.reclne rl LEFT JOIN rssys.itmunit it ON rl.unit = it.unit_id LEFT JOIN rssys.m08 m8 ON rl.cnt_code = m8.cc_code LEFT JOIN rssys.subctr st ON rl.scc_code = st.scc_code WHERE rec_num = \''.$rec_num.'\' ORDER BY CAST(rl.ln_num as integer)';
            
            return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}


    public static function saveToStkcrd($data = []) // save to stkcrd
	{
        try 
		{
            $table = 'rssys.stkcrd';

			if ($table!=null) 
			{
				if (!empty($data)) 
				{
					if (DB::table(DB::raw($table))->insert($data)) 
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

	public static function cancelReceivingPO($code, $stk_ref, $table, $col, $module) // cancel Receiving PO
	{
		try 
		{
			$datetime = Carbon::now();
            $getData = Inventory::getReceivingPOHeader($code);

            $supl_name = "CANCELLED-".$getData->supl_name;

            $data = ['supl_name' => $supl_name,
                     'cancel' => "Y",
                     'canc_user' => strtoupper(Session::get('_user')['id']),
                     'canc_date' => $datetime->toDateString(),
                     'canc_time' => $datetime->toTimeString()
                    ];        

			if (isset($table) && isset($col) && isset($code) ) 
			{
				if (!empty($data)) 
				{
					if (DB::table(DB::raw($table))->where($col, '=', $code)->update($data)) 
					{
                        if (DB::table(DB::raw('rssys.stkcrd'))->where('reference', '=', $stk_ref)->delete())
				        {
				        	if (isset($module)) 
				            {
						    	Inventory::alert(1, 'modified  data in '.$module);
						    }
						    return true;
				        }
					}
				}
			}
			if (isset($module)) {
			//Inventory::alert(2, 'occured upon modiification of data in '.$module);
			}
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Inventory::alert(0, '');
			return false;
		}
	}

	public static function getTotalAmtRPO($code) // get grand total of Receiving PO.
	{
		try
		{
            $sql = 'SELECT SUM(ln_amnt) as grandtotal FROM rssys.reclne WHERE rec_num = \''.$code.'\'';
            
            return DB::select(DB::raw($sql))[0];
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public static function getPurchaseReturn() // get all data of Purchase Return
	{
		try
		{
			$sql = "SELECT * FROM rssys.prethdr WHERE cancel != 'Y' OR cancel isnull";

			return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public static function getPurchaseReturnHeader($pret_num) // get rpo data header
	{	
		try 
		{
			$sql = 'SELECT * FROM rssys.prethdr WHERE pret_num = \''.$pret_num.'\' ORDER BY pret_num LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public static function getPurchaseReturnLine($pret_num) // get rpo data line
	{
		try
		{
            $sql = 'SELECT pl.ln_num, pl.part_no, pl.item_code, pl.item_desc, pl.ret_qty as qty, pl.unit as unit_code, it.unit_shortcode as unit_desc, pl.price, pl.discount, pl.ln_amnt, pl.net_amnt, pl.ln_vat, pl.ln_vatamt FROM rssys.pretlne pl LEFT JOIN rssys.itmunit it ON pl.unit = it.unit_id WHERE pret_num = \''.$pret_num.'\'';
            
            return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public static function getTotalAmtPR($code) // get grand total of Purchase Return.
	{
		try
		{
            $sql = 'SELECT SUM(ln_amnt) as grandtotal FROM rssys.pretlne WHERE pret_num = \''.$code.'\'';
            
            return DB::select(DB::raw($sql))[0];
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public static function cancelPurchaseReturn($code, $stk_ref, $table, $col, $module) // cancel Purchase Return
	{
		try 
		{
			$datetime = Carbon::now();
            $getData = Inventory::getPurchaseReturnHeader($code); 

            $supl_name = "CANCELLED-".$getData->supl_name;

            $data = ['supl_name' => $supl_name,
                     'cancel' => "Y",
                     'canc_user' => strtoupper(Session::get('_user')['id']),
                     'canc_date' => $datetime->toDateString(),
                     'canc_time' => $datetime->toTimeString()
                    ];

			if (isset($table) && isset($col) && isset($code) ) 
			{
				if (!empty($data)) 
				{
					if (DB::table(DB::raw($table))->where($col, '=', $code)->update($data)) 
					{
                        if (DB::table(DB::raw('rssys.stkcrd'))->where('reference', '=', $stk_ref)->delete())
				        {
				        	if (isset($module)) 
				            {
						    	Inventory::alert(1, 'modified  data in '.$module);
						    }
						    return true;
				        }
					}
				}
			}
			if (isset($module)) {
			Inventory::alert(2, 'occured upon modiification of data in '.$module);
			}
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Inventory::alert(0, '');
			return false;
		}
	}

	public static function getStockIssuance()
    {
    	try
    	{
    	   $sql = "SELECT rh.rec_num, rh._reference, rh.trnx_date, rh.recipient, wh.whs_desc FROM rssys.rechdr rh LEFT JOIN rssys.whouse wh ON rh.whs_code = wh.whs_code WHERE rh.trn_type = 'I' AND (rh.cancel != 'Y' OR rh.cancel isnull)";
   
    	   return DB::select(DB::raw($sql));
        }
        catch(\Exception $e)
        {
        	return $e->getMessage();
        }
    }

    public static function getStockIssuanceHeader($rec_num) // get rpo data header
	{	
		try 
		{
			$sql = 'SELECT * FROM rssys.rechdr WHERE rec_num = \''.$rec_num.'\' ORDER BY rec_num LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public static function getStockIssuanceLine($rec_num) // get rpo data line
	{
		try
		{
            $sql = 'SELECT rl.ln_num, rl.part_no, rl.item_code, rl.item_desc, rl.recv_qty as qty, rl.unit as unit_code, it.unit_shortcode as unit_desc, rl.price, rl.ln_amnt, rl.notes, rl.cnt_code as cc_code, m8.cc_desc, rl.scc_code, st.scc_desc FROM rssys.reclne rl LEFT JOIN rssys.itmunit it ON rl.unit = it.unit_id LEFT JOIN rssys.m08 m8 ON rl.cnt_code = m8.cc_code LEFT JOIN rssys.subctr st ON rl.scc_code = st.scc_code WHERE rec_num = \''.$rec_num.'\'';
            
            return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public static function getTotalAmtSI($code) // get grand total of Receiving PO.
	{
		try
		{
            $sql = 'SELECT SUM(ln_amnt) as grandtotal FROM rssys.reclne WHERE rec_num = \''.$code.'\'';
            
            return DB::select(DB::raw($sql))[0];
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public static function cancelStockIssuance($code, $stk_ref, $table, $col, $module) // cancel Receiving PO
	{
		try 
		{
			$datetime = Carbon::now();
            $getData = Inventory::getStockIssuanceHeader($code);

            $reference = "CANCELLED-".$getData->_reference;

            $data = ['_reference' => $reference,
                     'cancel' => "Y",
                     'canc_user' => strtoupper(Session::get('_user')['id']),
                     'canc_date' => $datetime->toDateString(),
                     'canc_time' => $datetime->toTimeString()
                    ];

			if (isset($table) && isset($col) && isset($code) ) 
			{
				if (!empty($data)) 
				{
					if (DB::table(DB::raw($table))->where($col, '=', $code)->update($data)) 
					{
                        if (DB::table(DB::raw('rssys.stkcrd'))->where('reference', '=', $stk_ref)->delete())
				        {
				        	if (isset($module)) 
				            {
						    	Inventory::alert(1, 'modified  data in '.$module);
						    }
						    return true;
				        }
					}
				}
			}
			if (isset($module)) {
			Inventory::alert(2, 'occured upon modiification of data in '.$module);
			}
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Inventory::alert(0, '');
			return false;
		}
	}

	public static function getStockTransfer()
    {
    	try
    	{
    	   $sql = "SELECT rh.rec_num, rh._reference, rh.trnx_date, rh.trn_type, rh.cancel, rh.recipient, rh.t_date, rh.t_time, rh.branch, wh.whs_desc as loc_from, wh1.whs_desc as loc_to, b.name as branch, CASE WHEN rh.is_receiving = '1' THEN 'Y' ELSE 'N' END as is_receive FROM rssys.rechdr rh LEFT JOIN rssys.branch b ON rh.branch = b.code LEFT JOIN rssys.whouse wh ON rh.\"locationFrom\" = wh.whs_code LEFT JOIN rssys.whouse wh1 ON rh.\"locationTo\" = wh1.whs_code WHERE rh.trn_type = 'T' AND (rh.cancel != 'Y' OR rh.cancel isnull)";
   
    	   return DB::select(DB::raw($sql));
        }
        catch(\Exception $e)
        {
        	return $e->getMessage();
        }
    }

    public static function getStockTransferHeader($rec_num) // get stocktransfer data header
	{	
		try 
		{
			$sql = 'SELECT rh.rec_num, rh._reference, rh.trnx_date, rh.recipient, rh.branch, rh."locationTo" as loc_to, rh."locationFrom" as loc_from FROM rssys.rechdr rh WHERE rh.rec_num = \''.$rec_num.'\' ORDER BY rh.rec_num LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public static function getStockTransferLine($rec_num) // get stocktransfer data line
	{
		try
		{
            $sql = 'SELECT rl.ln_num, rl.part_no, rl.item_code, rl.item_desc, rl.recv_qty as qty, rl.unit as unit_code, it.unit_shortcode as unit_desc, rl.price, rl.ln_amnt, rl.receiving_qty FROM rssys.reclne rl LEFT JOIN rssys.itmunit it ON rl.unit = it.unit_id WHERE rec_num = \''.$rec_num.'\'';
            
            return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public static function getTotalAmtStockTransfer($code) // get grand total of StockTransfer.
	{
		try
		{
            $sql = 'SELECT SUM(ln_amnt) as grandtotal FROM rssys.reclne WHERE rec_num = \''.$code.'\'';
            
            return DB::select(DB::raw($sql))[0];
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public static function cancelStockTransfer($code, $stk_ref, $table, $col, $module) // cancel Stock Transfer
	{
		try 
		{
			$datetime = Carbon::now();
            $getData = Inventory::getStockTransferHeader($code);

            $reference = "CANCELLED-".$getData->_reference;

            $data = ['_reference' => $reference,
                     'cancel' => "Y",
                     'canc_user' => strtoupper(Session::get('_user')['id']),
                     'canc_date' => $datetime->toDateString(),
                     'canc_time' => $datetime->toTimeString()
                    ];

			if (isset($table) && isset($col) && isset($code) ) 
			{
				if (!empty($data)) 
				{
					if (DB::table(DB::raw($table))->where($col, '=', $code)->update($data)) 
					{
                        if (DB::table(DB::raw('rssys.stkcrd'))->where('reference', '=', $stk_ref)->delete())
				        {
				        	if (isset($module)) 
				            {
						    	Inventory::alert(1, 'modified  data in '.$module);
						    }
						    return true;
				        }
					}
				}
			}
			if (isset($module)) {
			Inventory::alert(2, 'occured upon modiification of data in '.$module);
			}
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Inventory::alert(0, '');
			return false;
		}
	}

    // get Receiving Stock Transfer transactions.
	public static function getRecvStockTransfer()
    {
    	try
    	{
    	   $sql = "SELECT rh.rec_num, rh._reference, rh.trnx_date, rh.trn_type, rh.cancel, rh.recipient, rh.t_date, rh.t_time, rh.branch, wh.whs_desc as loc_from, wh1.whs_desc as loc_to, b.name as branch FROM rssys.rechdr rh LEFT JOIN rssys.branch b ON rh.branch = b.code LEFT JOIN rssys.whouse wh ON rh.\"locationFrom\" = wh.whs_code LEFT JOIN rssys.whouse wh1 ON rh.\"locationTo\" = wh1.whs_code WHERE rh.trn_type = 'T' AND rh.is_receiving = '0' AND (rh.cancel != 'Y' OR rh.cancel isnull)";
   
    	   return DB::select(DB::raw($sql));
        }
        catch(\Exception $e)
        {
        	return $e->getMessage();
        }
    }

    // get Stock Adjustment transactions.
    public static function getStockAdjustment()
    {
    	try
    	{
    	   $sql = "SELECT rh.rec_num, rh._reference, rh.trnx_date, rh.recipient, wh.whs_desc, b.name as branch FROM rssys.rechdr rh LEFT JOIN rssys.whouse wh ON rh.whs_code = wh.whs_code LEFT JOIN rssys.branch b ON rh.branch = b.code WHERE rh.trn_type = 'A' AND (rh.cancel != 'Y' OR rh.cancel isnull)";
   
    	   return DB::select(DB::raw($sql));
        }
        catch(\Exception $e)
        {
        	return $e->getMessage();
        }
    }

    // get Stock Adjustment Header
    public static function getStockAdjHeader($rec_num)
	{	
		try 
		{
			$sql = 'SELECT * FROM rssys.rechdr WHERE rec_num = \''.$rec_num.'\' ORDER BY rec_num LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// get Stock Adjustmnet Line
	public static function getStockAdjLine($rec_num) 
	{
		try
		{
            $sql = 'SELECT rl.ln_num, rl.part_no, rl.item_code, rl.item_desc, rl.recv_qty as qty, rl.unit as unit_code, it.unit_shortcode as unit_desc, rl.price, rl.ln_amnt, rl.notes FROM rssys.reclne rl LEFT JOIN rssys.itmunit it ON rl.unit = it.unit_id WHERE rec_num = \''.$rec_num.'\'';
            
            return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	// get Grand Total Amount of selected Stock Adj
	public static function getTotalAmtAdj($code)
	{
		try
		{
            $sql = 'SELECT SUM(ln_amnt) as grandtotal FROM rssys.reclne WHERE rec_num = \''.$code.'\'';
            
            return DB::select(DB::raw($sql))[0];
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	// Cancel Selected Stock Adj Transaction
	public static function cancelStockAdj($code, $stk_ref, $table, $col, $module)
	{
		try 
		{
			$datetime = Carbon::now();
            $getData = Inventory::getStockAdjHeader($code);

            $reference = "CANCELLED-".$getData->_reference;

            $data = ['_reference' => $reference,
                     'cancel' => "Y",
                     'canc_user' => strtoupper(Session::get('_user')['id']),
                     'canc_date' => $datetime->toDateString(),
                     'canc_time' => $datetime->toTimeString()
                    ];

			if (isset($table) && isset($col) && isset($code) ) 
			{
				if (!empty($data)) 
				{
					if (DB::table(DB::raw($table))->where($col, '=', $code)->update($data)) 
					{
                        if (DB::table(DB::raw('rssys.stkcrd'))->where('reference', '=', $stk_ref)->delete())
				        {
				        	if (isset($module)) 
				            {
						    	Inventory::alert(1, 'modified  data in '.$module);
						    }
						    return true;
				        }
					}
				}
			}
			if (isset($module)) {
			Inventory::alert(2, 'occured upon modiification of data in '.$module);
			}
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Inventory::alert(0, '');
			return false;
		}
	}

	// get all Stock In Transactions Header.
	public static function getStockIn()
    {
    	try
    	{
    	   $sql = "SELECT * FROM rssys.rechdr WHERE trn_type = 'P' AND (cancel != 'Y' OR cancel isnull)";
   
    	   return DB::select(DB::raw($sql));
        }
        catch(\Exception $e)
        {
        	return $e->getMessage();
        }
    }
    
    // get specific Stock In Transaction header.
    public static function getStockInHeader($rec_num)
	{	
		try 
		{
			$sql = 'SELECT * FROM rssys.rechdr WHERE rec_num = \''.$rec_num.'\' ORDER BY rec_num LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

    // get specific Stock In Transaction line.
	public static function getStockInLine($rec_num) 
	{
		try
		{
            $sql = 'SELECT rl.ln_num, rl.part_no, rl.item_code, rl.item_desc, rl.recv_qty as qty, rl.unit as unit_code, it.unit_shortcode as unit_desc, rl.price, rl.discount, rl.ln_amnt, rl.net_amnt, rl.ln_vat, rl.ln_vatamt, rl.cnt_code as cc_code, m8.cc_desc, rl.scc_code, st.scc_desc FROM rssys.reclne rl LEFT JOIN rssys.itmunit it ON rl.unit = it.unit_id LEFT JOIN rssys.m08 m8 ON rl.cnt_code = m8.cc_code LEFT JOIN rssys.subctr st ON rl.scc_code = st.scc_code WHERE rec_num = \''.$rec_num.'\'';
            
            return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	// get item details of StockIn.
    public static function getItemDetails($code)
	{	
		try 
		{
			$sql = 'SELECT part_no, item_desc, sales_unit_id, unit_cost FROM rssys.items WHERE item_code = \''.$code.'\' LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

    // get specific grand total amount of Stock In.
	public static function getTotalAmtStockIn($code)
	{
		try
		{
            $sql = 'SELECT SUM(ln_amnt) as grandtotal FROM rssys.reclne WHERE rec_num = \''.$code.'\'';
            
            return DB::select(DB::raw($sql))[0];
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

    // cancel Stock In Transactions.
	public static function cancelStockIn($code, $stk_ref, $table, $col, $module)
	{
		try 
		{
			$datetime = Carbon::now();
            $getData = Inventory::getStockInHeader($code);

            $supl_name = "CANCELLED-".$getData->supl_name;

            $data = ['supl_name' => $supl_name,
                     'cancel' => "Y",
                     'canc_user' => strtoupper(Session::get('_user')['id']),
                     'canc_date' => $datetime->toDateString(),
                     'canc_time' => $datetime->toTimeString()
                    ];        

			if (isset($table) && isset($col) && isset($code) ) 
			{
				if (!empty($data)) 
				{
					if (DB::table(DB::raw($table))->where($col, '=', $code)->update($data)) 
					{
                        if (DB::table(DB::raw('rssys.stkcrd'))->where('reference', '=', $stk_ref)->delete())
				        {
				        	if (isset($module)) 
				            {
						    	//Inventory::alert(1, 'modified  data in '.$module);
						    }
						    return true;
				        }
					}
				}
			}
			if (isset($module)) {
			//Inventory::alert(2, 'occured upon modiification of data in '.$module);
			}
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Inventory::alert(0, '');
			return false;
		}
	}

	// get all RIS Transactions Header.
	public static function getRIS()
    {
    	try
    	{
    	   $sql = "SELECT rec_num, _reference, trnx_date, ris_no, sai_no, m8.cc_desc as cc_code, b.name as branch, w.whs_desc as whs_code, recipient FROM rssys.rechdr rh LEFT JOIN rssys.branch b ON rh.branch = b.code LEFT JOIN rssys.whouse w ON rh.whs_code = w.whs_code LEFT JOIN rssys.m08 m8 ON rh.cc_code = m8.cc_code WHERE trn_type = 'R' AND (rh.cancel != 'Y' OR rh.cancel isnull)";
   
    	   return DB::select(DB::raw($sql));
        }
        catch(\Exception $e)
        {
        	return $e->getMessage();
        }
    }

    // use for incremental of code with string
    public static function get_nextincrementwithchar($val)
    {
    	try
    	{
    	  preg_match("/([a-zA-Z]+)(\\d+)/", $val, $code);
  
          $codeInt = Core::get_nextincrementlimitchar($code[2], 7);
          $newCode = $code[1].$codeInt;
  
    	  return $newCode;
        }
        catch (\Exception $e)
        {
        	return $e->getMessage();
        }
    }

    // get specific RIS Transaction header.
    public static function getRISHeader($rec_num)
	{	
		try 
		{
			$sql = 'SELECT rec_num, _reference, trnx_date, ris_no, sai_no, cc_code, whs_code, branch, recipient FROM rssys.rechdr WHERE rec_num = \''.$rec_num.'\' ORDER BY rec_num LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// get specific RIS Transaction line.
	public static function getRISLine($rec_num) 
	{
		try
		{
            $sql = 'SELECT rl.ln_num, rl.part_no, i.serial_no, i.tag_no, rl.item_code, rl.item_desc, rl.recv_qty as qty, rl.unit as unit_code, it.unit_shortcode as unit_desc, rl.price, rl.discount, rl.ln_amnt, rl.net_amnt, rl.ln_vat, rl.ln_vatamt, rl.cnt_code as cc_code, m8.cc_desc, rl.scc_code, st.scc_desc FROM rssys.reclne rl LEFT JOIN rssys.itmunit it ON rl.unit = it.unit_id LEFT JOIN rssys.m08 m8 ON rl.cnt_code = m8.cc_code LEFT JOIN rssys.subctr st ON rl.scc_code = st.scc_code LEFT JOIN rssys.items i ON rl.item_code = i.item_code WHERE rec_num = \''.$rec_num.'\'';
            
            return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	// get specific grand total amount of RIS.
	public static function getTotalAmtRIS($code)
	{
		try
		{
            $sql = 'SELECT SUM(ln_amnt) as grandtotal FROM rssys.reclne WHERE rec_num = \''.$code.'\'';
            
            return DB::select(DB::raw($sql))[0];
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	// cancel RIS Transaction.
	public static function cancelRIS($code, $stk_ref, $table, $col, $module)
	{
		try 
		{
			$datetime = Carbon::now();
            $getData = Inventory::getRISHeader($code);

            $reference = "CANCELLED-".$getData->_reference;

            $data = ['_reference' => $reference,
                     'cancel' => "Y",
                     'canc_user' => strtoupper(Session::get('_user')['id']),
                     'canc_date' => $datetime->toDateString(),
                     'canc_time' => $datetime->toTimeString()
                    ];        

			if (isset($table) && isset($col) && isset($code) ) 
			{
				if (!empty($data)) 
				{
					if (DB::table(DB::raw($table))->where($col, '=', $code)->update($data)) 
					{
            //             if (DB::table(DB::raw('rssys.stkcrd'))->where('reference', '=', $stk_ref)->delete())
				        // {
				        	if (isset($module)) 
				            {
						    	Inventory::alert(1, 'modified  data in '.$module);
						    }
						    return true;
				        //}
					}
				}
			}
			if (isset($module)) {
			//Inventory::alert(2, 'occured upon modiification of data in '.$module);
			}
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Inventory::alert(0, '');
			return false;
		}
	}

	// get all Stock Release Transactions Header.
	public static function getStockRelease()
    {
    	try
    	{
    	   $sql = "SELECT rec_num, _reference, trnx_date, ris_no, sai_no, m8.cc_desc as cc_code, b.name as branch, w.whs_desc as whs_code, recipient, approve FROM rssys.rechdr rh LEFT JOIN rssys.branch b ON rh.branch = b.code LEFT JOIN rssys.whouse w ON rh.\"locationFrom\" = w.whs_code LEFT JOIN rssys.m08 m8 ON rh.cc_code = m8.cc_code WHERE (trn_type = 'R' OR trn_type = 'SR') AND (rh.cancel != 'Y' OR rh.cancel isnull)";
   
    	   return DB::select(DB::raw($sql));
        }
        catch(\Exception $e)
        {
        	return $e->getMessage();
        }
    }

    // get specific Stock Release Transaction header.
    public static function getStockReleaseHeader($rec_num)
	{	
		try 
		{
			$sql = 'SELECT rec_num, _reference, trnx_date, ris_no, sai_no, cc_code, whs_code, branch, recipient, personnel FROM rssys.rechdr WHERE rec_num = \''.$rec_num.'\' ORDER BY rec_num LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// get specific Stock Release Transaction line.
	public static function getStockReleaseLine($rec_num) 
	{
		try
		{
            $sql = 'SELECT rl.ln_num, rl.part_no, i.serial_no, i.tag_no, rl.item_code, rl.item_desc, rl.recv_qty as qty, rl.unit as unit_code, it.unit_shortcode as unit_desc, rl.price, rl.discount, rl.ln_amnt, rl.net_amnt, rl.ln_vat, rl.ln_vatamt, rl.cnt_code as cc_code, m8.cc_desc, rl.scc_code, st.scc_desc, rl.issued_qty FROM rssys.reclne rl LEFT JOIN rssys.itmunit it ON rl.unit = it.unit_id LEFT JOIN rssys.m08 m8 ON rl.cnt_code = m8.cc_code LEFT JOIN rssys.subctr st ON rl.scc_code = st.scc_code LEFT JOIN rssys.items i ON rl.item_code = i.item_code WHERE rec_num = \''.$rec_num.'\'';
            
            return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	// get all ARE Transactions Header.
	public static function getARE()
    {
    	try
    	{
    	   // $sql = "SELECT rec_num, _reference, trnx_date, ris_no, sai_no, m8.cc_desc as cc_code, b.name as branch, w.whs_desc as whs_code, recipient, are_status FROM rssys.rechdr rh LEFT JOIN rssys.branch b ON rh.branch = b.code LEFT JOIN rssys.whouse w ON rh.whs_code = w.whs_code LEFT JOIN rssys.m08 m8 ON rh.cc_code = m8.cc_code WHERE trn_type = 'R' AND (rh.cancel != 'Y' OR rh.cancel isnull)";

    		$sql = "SELECT rec_num, _reference, trnx_date, m8.cc_desc as cc_code, b.name as branch, w.whs_desc as whs_code, recipient, are_status FROM rssys.rechdr rh LEFT JOIN rssys.branch b ON rh.branch = b.code LEFT JOIN rssys.whouse w ON rh.whs_code = w.whs_code LEFT JOIN rssys.m08 m8 ON rh.cc_code = m8.cc_code WHERE trn_type = 'A' AND (rh.cancel != 'Y' OR rh.cancel isnull)";
   
    	   return DB::select(DB::raw($sql));
        }
        catch(\Exception $e)
        {
        	return $e->getMessage();
        }
    }

    public static function getIR()
    {
    	try
    	{
    		$data = "SELECT * FROM rssys.rechdr INNER JOIN rssys.m08 ON rechdr.cc_code = m08.cc_code WHERE rec_num LIKE 'IR%' AND (cancel != 'Y' OR cancel isnull)";


   
    	   return DB::select(DB::raw($data));
        }
        catch(\Exception $e)
        {
        	return $e->getMessage();
        }
    }

    public static function getTO()
    {
    	try
    	{
    		$data = "SELECT * FROM rssys.rechdr INNER JOIN rssys.m08 ON rechdr.cc_code = m08.cc_code WHERE rec_num LIKE 'TO%' AND (cancel != 'Y' OR cancel isnull)";

   
    	   return DB::select(DB::raw($data));
        }
        catch(\Exception $e)
        {
        	return $e->getMessage();
        }
    }

    // get all ICS Transactions Header.
	public static function getICS()
    {
    	try
    	{
    	   $sql = "SELECT rec_num, _reference, trnx_date, ics_no, x8.opr_name as personnel, m8.cc_desc as cc_code, b.name as branch, w.whs_desc as whs_code, recipient FROM rssys.rechdr rh LEFT JOIN rssys.branch b ON rh.branch = b.code LEFT JOIN rssys.whouse w ON rh.whs_code = w.whs_code LEFT JOIN rssys.m08 m8 ON rh.cc_code = m8.cc_code LEFT JOIN rssys.x08 x8 ON rh.personnel = x8.uid WHERE trn_type = 'I' AND (rh.cancel != 'Y' OR rh.cancel isnull)";
   
    	   return DB::select(DB::raw($sql));
        }
        catch(\Exception $e)
        {
        	return $e->getMessage();
        }
    }

    // get all RIS from ICS.
	public static function getRISFromICS()
    {
    	try
    	{
    	   $sql = "SELECT rec_num, _reference, trnx_date, ris_no, sai_no, m8.cc_desc as cc_code, b.name as branch, w.whs_desc as whs_code, recipient FROM rssys.rechdr rh LEFT JOIN rssys.branch b ON rh.branch = b.code LEFT JOIN rssys.whouse w ON rh.whs_code = w.whs_code LEFT JOIN rssys.m08 m8 ON rh.cc_code = m8.cc_code WHERE trn_type = 'R' AND (rh.cancel != 'Y' OR rh.cancel isnull) AND approve = 'true'";
   
    	   return DB::select(DB::raw($sql));
        }
        catch(\Exception $e)
        {
        	return $e->getMessage();
        }
    }

    // get specific RIS Transaction line from ICS.
	public static function getRISLineFromICS($rec_num) 
	{
		try
		{
            $sql = 'SELECT rl.ln_num, rl.part_no, i.serial_no, i.tag_no, rl.item_code, rl.item_desc, rl.recv_qty as qty, rl.unit as unit_code, it.unit_shortcode as unit_desc, rl.price, rl.discount, rl.ln_amnt, rl.net_amnt, rl.ln_vat, rl.ln_vatamt, rl.cnt_code as cc_code, m8.cc_desc, rl.scc_code, st.scc_desc, issued_qty FROM rssys.reclne rl LEFT JOIN rssys.itmunit it ON rl.unit = it.unit_id LEFT JOIN rssys.m08 m8 ON rl.cnt_code = m8.cc_code LEFT JOIN rssys.subctr st ON rl.scc_code = st.scc_code LEFT JOIN rssys.items i ON rl.item_code = i.item_code WHERE rec_num = \''.$rec_num.'\'';
            
            return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	// get specific ICS Transaction header.
    public static function getICSHeader($rec_num)
	{	
		try 
		{
			$sql = 'SELECT rec_num, _reference, trnx_date, ics_no, personnel, m8.cc_desc as cc_code, b.name as branch, w.whs_desc as whs_code, recipient FROM rssys.rechdr rh LEFT JOIN rssys.branch b ON rh.branch = b.code LEFT JOIN rssys.whouse w ON rh.whs_code = w.whs_code LEFT JOIN rssys.m08 m8 ON rh.cc_code = m8.cc_code LEFT JOIN rssys.x08 x8 ON rh.personnel = x8.uid WHERE rec_num = \''.$rec_num.'\' ORDER BY rec_num LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// get selected RIS Office
	public static function getRISOffice($rec_num)
	{	
		try 
		{
			$sql = 'SELECT cc_code FROM rssys.rechdr WHERE rec_num = \''.$rec_num.'\' ORDER BY rec_num LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// get specific ICS Transaction line.
	public static function getICSLine($rec_num) 
	{
		try
		{
            $sql = 'SELECT rl.ln_num, rl.part_no, i.serial_no, i.tag_no, rl.item_code, rl.item_desc, rl.recv_qty as qty, 
rl.unit as unit_code, it.unit_shortcode as unit_desc, rl.price, rl.discount, rl.ln_amnt, rl.net_amnt, 
rl.ln_vat, rl.ln_vatamt, rl.cnt_code as cc_code, m8.cc_desc, rl.scc_code, st.scc_desc 
FROM rssys.reclne rl 
LEFT JOIN rssys.itmunit it ON rl.unit = it.unit_id LEFT JOIN rssys.m08 m8 ON rl.cnt_code = m8.cc_code 
LEFT JOIN rssys.subctr st ON rl.scc_code = st.scc_code 
LEFT JOIN rssys.items i ON rl.item_code = i.item_code  WHERE rec_num = \''.$rec_num.'\'';
            
            return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	// cancel ICS Transaction.
	public static function cancelICS($code, $stk_ref, $table, $col, $module)
	{
		try 
		{
			$datetime = Carbon::now();
            $getData = Inventory::getICSHeader($code);

            $reference = "CANCELLED-".$getData->_reference;

            $data = ['_reference' => $reference,
                     'cancel' => "Y",
                     'canc_user' => strtoupper(Session::get('_user')['id']),
                     'canc_date' => $datetime->toDateString(),
                     'canc_time' => $datetime->toTimeString()
                    ];        

			if (isset($table) && isset($col) && isset($code) ) 
			{
				if (!empty($data)) 
				{
					if (DB::table(DB::raw($table))->where($col, '=', $code)->update($data)) 
					{
            //             if (DB::table(DB::raw('rssys.stkcrd'))->where('reference', '=', $stk_ref)->delete())
				        // {
				        	if (isset($module)) 
				            {
						    	Inventory::alert(1, 'modified  data in '.$module);
						    }
						    return true;
				        //}
					}
				}
			}
			if (isset($module)) {
			//Inventory::alert(2, 'occured upon modiification of data in '.$module);
			}
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Inventory::alert(0, '');
			return false;
		}
	}

	public static function print_are($rec_num) // print ARE
	{
		try
		{
            //$sql = 'SELECT rl.ln_num, rl.part_no, i.serial_no, rl.item_code, rl.item_desc, rl.issued_qty as qty, it.unit_shortcode as unit_desc, i.unit_cost as price, (i.unit_cost * rl.issued_qty) as ln_amnt FROM rssys.reclne rl LEFT JOIN rssys.itmunit it ON rl.unit = it.unit_id LEFT JOIN rssys.items i ON rl.item_code = i.item_code WHERE rec_num = \''.$rec_num.'\' ORDER BY rl.ln_num ASC';

            $sql = 'SELECT rl.ln_num, rl.part_no, rl.serial_no, rl.item_code, rl.item_desc, ROUND(rl.issued_qty, 2) as qty, it.unit_shortcode as unit_desc, ROUND(rl.price, 2) as price, ROUND(rl.ln_amnt, 2) as ln_amnt FROM rssys.reclne rl LEFT JOIN rssys.itmunit it ON rl.unit = it.unit_id WHERE rec_num = \''.$rec_num.'\' ORDER BY rl.ln_num ASC';
            
            return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public static function print_areheader($rec_num) // print ARE
	{
		try
		{
            $sql = 'SELECT m8.cc_desc as office, are_receivedfrom as receivedfrom, are_receivedby as receivedby, are_issuedto as issuedto, are_receivedfromdesig as receivedfromdesig, are_receivebydesig as receivedbydesig, are_issuedtodesig as issuedtodesig FROM rssys.rechdr rh LEFT JOIN rssys.m08 m8 ON rh.cc_code = m8.cc_code WHERE rec_num = \''.$rec_num.'\'';
            
            return DB::select(DB::raw($sql))[0];
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

    // get all Waster Material Transactions Header.
    public static function getWasteMaterial()
    {
    	try
    	{
    		$sql = "SELECT wm.code, wm.trnx_date, wh.whs_desc as whs_code, wm.recipient, m8.cc_desc as cc_code, wm.certified_correct, wm.disposal_approved FROM rssys.wastematerialhdr wm LEFT JOIN rssys.whouse wh ON wm.whs_code = wh.whs_code LEFT JOIN rssys.m08 m8 ON wm.cc_code = m8.cc_code WHERE wm.cancel isnull ORDER BY wm.code";

    		return DB::select(DB::raw($sql));
    	}
    	catch(\Exception $e)
    	{
    		return $e->getMessage();
    	}
    }

    // get specific Waste Material Transaction Header.
	public static function getWasteMaterialHeader($code)
	{
		try
		{
			$sql = 'SELECT * FROM rssys.wastematerialhdr WHERE code = \''.$code.'\' LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
		}
	}

	// get specific Waste Material Transaction line.
	public static function getWasteMaterialLine($code) 
	{
		try
		{
            $sql = 'SELECT wm.code, wm.ln_num, wm.item_code, i.part_no, i.serial_no, i.tag_no, wm.item_desc, wm.unit, it.unit_shortcode, wm.qty, wm.price, wm.or_no FROM rssys.wastemateriallne wm LEFT JOIN rssys.items i ON wm.item_code = i.item_code LEFT JOIN rssys.itmunit it ON wm.unit = it.unit_id WHERE wm.code = \''.$code.'\'';
            
            return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	// cancel Waste Material Transactions.
	public static function cancelWasteMaterial($code, $stk_ref, $table, $col, $module)
	{
		try 
		{
			$datetime = Carbon::now();

            $data = ['cancel' => "Y",
                     'canc_user' => strtoupper(Session::get('_user')['id']),
                     'canc_date' => $datetime->toDateString(),
                     'canc_time' => $datetime->toTimeString()
                    ];        

			if (isset($table) && isset($col) && isset($code) ) 
			{
				if (!empty($data)) 
				{
					if (DB::table(DB::raw($table))->where($col, '=', $code)->update($data)) 
					{
            //             if (DB::table(DB::raw('rssys.stkcrd'))->where('reference', '=', $stk_ref)->delete())
				        // {
				        	if (isset($module)) 
				            {
						    	Inventory::alert(1, 'modified  data in '.$module);
						    }
						    return true;
				        //}
					}
				}
			}
			if (isset($module)) {
			//Inventory::alert(2, 'occured upon modiification of data in '.$module);
			}
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Inventory::alert(0, '');
			return false;
		}
	}

	// get specific ARE Transaction header.
    public static function getAREHeader($rec_num)
	{	
		try 
		{
			$sql = 'SELECT rec_num, _reference, trnx_date, cc_code, whs_code, branch, recipient, are_receivedby, are_receivedfrom, are_issuedto, are_receivebydesig, are_receivedfromdesig, are_issuedtodesig FROM rssys.rechdr WHERE rec_num = \''.$rec_num.'\' ORDER BY rec_num LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// get specific ARE Transaction line.
	public static function getARELine($rec_num) 
	{
		try
		{
            $sql = 'SELECT rl.ln_num, rl.part_no, rl.serial_no, rl.tag_no, rl.item_code, rl.item_desc, rl.recv_qty as qty, rl.unit as unit_code, it.unit_shortcode as unit_desc, rl.price, rl.discount, rl.ln_amnt, rl.net_amnt, rl.ln_vat, rl.ln_vatamt, rl.cnt_code as cc_code, m8.cc_desc, rl.scc_code, st.scc_desc FROM rssys.reclne rl LEFT JOIN rssys.itmunit it ON rl.unit = it.unit_id LEFT JOIN rssys.m08 m8 ON rl.cnt_code = m8.cc_code LEFT JOIN rssys.subctr st ON rl.scc_code = st.scc_code LEFT JOIN rssys.items i ON rl.item_code = i.item_code WHERE rec_num = \''.$rec_num.'\'';
            
            return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public static function getIRHeader($rec_num)
	{	
		try 
		{
			$sql = 'Select rec_num, ir_model, ir_unitserialno, ir_engineserialno, ir_plateno, recipient, ir_designation, cc_code, ir_dateofare From rssys.rechdr Where rec_num = \''.$rec_num.'\' ORDER BY rec_num LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	/*
	 * Get all lines of Item Repair with specific code.
	 */
	public static function getItemRepairLine($rec_num) 
	{
		try
		{
            $sql = 'SELECT rl.ln_num, rl.item_code, rl.ir_joborder, rl.ir_date, rl.ir_prepost, rl.ir_postdate, rl.ir_delvdate, rl.ir_supplier, rl.recv_qty, rl.unit as unit_code, it.unit_shortcode as unit_desc, rl.price, rl.ir_material, rl.notes, rl.ir_invoice FROM rssys.reclne rl LEFT JOIN rssys.itmunit it ON rl.unit = it.unit_id WHERE rl.rec_num = \''.$rec_num.'\' ORDER BY CAST(ln_num as integer)';
            
            return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}


	public static function getTOHeader($rec_num)
	{	
		try 
		{
			//$sql = 'Select rec_num, _reference, to_date, to_by, cc_code, to_receivedby, trn_type, recipient, t_date, t_time From rssys.rechdr Where rec_num = \''.$rec_num.'\' ORDER BY rec_num LIMIT 1';

			$sql = 'Select rechdr.rec_num, rechdr._reference, rechdr.to_date, rechdr.to_by, rechdr.cc_code, rechdr.to_receivedby, rechdr.trn_type, rechdr.recipient, rechdr.t_date, rechdr.t_time, m08.cc_desc as cc_desc From rssys.rechdr INNER JOIN rssys.m08 ON rechdr.cc_code = m08.cc_code Where rec_num = \''.$rec_num.'\' ORDER BY rec_num LIMIT 1';

			return DB::select(DB::raw($sql))[0];
		} 
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public static function getTOLine($rec_num) 
	{
		try
		{
            $sql = 'SELECT ln_num, item_code, item_desc, item_code, to_article, recv_qty, notes FROM rssys.reclne WHERE rec_num = \''.$rec_num.'\' ORDER BY CAST(ln_num as integer)';
            
            return DB::select(DB::raw($sql));
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}


	// check if exist, else insert
	public static function checkIfExistInsert($table, $col, $value)
	{
       
		$sql = 'SELECT COUNT(*) FROM '.$table.' WHERE '.$col.' = \''.$value.'\' LIMIT 1';

	   $check = DB::select(DB::raw($sql))[0];

	   if($check->count <= 0)
	   {
         $data = ['name' => $value];
         Core::insertTable($table, $data, 'ARE');
	   }
	}

	// cancel a ARE Transactions.
	public static function cancelARE($code, $table, $col, $module)
	{
		try 
		{
			$datetime = Carbon::now();

            $data = ['cancel' => "Y",
                     'canc_user' => strtoupper(Session::get('_user')['id']),
                     'canc_date' => $datetime->toDateString(),
                     'canc_time' => $datetime->toTimeString()
                    ];        

			if (isset($table) && isset($col) && isset($code) ) 
			{
				if (!empty($data)) 
				{
					if (DB::table(DB::raw($table))->where($col, '=', $code)->update($data)) 
					{
						return true;
          //               if (DB::table(DB::raw('rssys.stkcrd'))->where('reference', '=', $stk_ref)->delete())
				      //   {
				      //   	if (isset($module)) 
				      //       {
						    // 	//Inventory::alert(1, 'modified  data in '.$module);
						    // }
						    // return true;
				      //   }
					}
				}
			}
			if (isset($module)) {
			//Inventory::alert(2, 'occured upon modiification of data in '.$module);
			}
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Inventory::alert(0, '');
			return false;
		}
	}

	//cancel a IR
	public static function cancelIR($code, $table, $col, $module)
	{
		try 
		{
			$datetime = Carbon::now();

            $data = ['cancel' => "Y",
                     'canc_user' => strtoupper(Session::get('_user')['id']),
                     'canc_date' => $datetime->toDateString(),
                     'canc_time' => $datetime->toTimeString()
                    ];        

			if (isset($table) && isset($col) && isset($code) ) 
			{
				if (!empty($data)) 
				{
					if (DB::table(DB::raw($table))->where($col, '=', $code)->update($data)) 
					{
						return true;
          //               if (DB::table(DB::raw('rssys.stkcrd'))->where('reference', '=', $stk_ref)->delete())
				      //   {
				      //   	if (isset($module)) 
				      //       {
						    // 	//Inventory::alert(1, 'modified  data in '.$module);
						    // }
						    // return true;
				      //   }
					}
				}
			}
			if (isset($module)) {
			//Inventory::alert(2, 'occured upon modiification of data in '.$module);
			}
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Inventory::alert(0, '');
			return false;
		}
	}

	//cancel a TO
	public static function cancelTO($code, $table, $col, $module)
	{
		try 
		{
			$datetime = Carbon::now();

            $data = ['cancel' => "Y",
                     'canc_user' => strtoupper(Session::get('_user')['id']),
                     'canc_date' => $datetime->toDateString(),
                     'canc_time' => $datetime->toTimeString()
                    ];        

			if (isset($table) && isset($col) && isset($code) ) 
			{
				if (!empty($data)) 
				{
					if (DB::table(DB::raw($table))->where($col, '=', $code)->update($data)) 
					{
						return true;
          //               if (DB::table(DB::raw('rssys.stkcrd'))->where('reference', '=', $stk_ref)->delete())
				      //   {
				      //   	if (isset($module)) 
				      //       {
						    // 	//Inventory::alert(1, 'modified  data in '.$module);
						    // }
						    // return true;
				      //   }
					}
				}
			}
			if (isset($module)) {
			//Inventory::alert(2, 'occured upon modiification of data in '.$module);
			}
			return false;
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
			Inventory::alert(0, '');
			return false;
		}
	}
	
}
