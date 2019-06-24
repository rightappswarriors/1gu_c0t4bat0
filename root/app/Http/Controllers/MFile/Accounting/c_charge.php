<?php

	namespace App\Http\Controllers\MFile\Accounting;

	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Core;
	use Session;

	class c_charge extends Controller
	{
		public function __construct()
		{
			$this->MOD_CODE = "M1000013";
			$sql = "SELECT * FROM rssys.m08 ORDER BY cc_desc ASC";
			$this->m08 = Core::sql($sql);; // Cost Center 
			$sql1 = "SELECT * FROM rssys.m04 ORDER BY at_desc ASC";
			$this->m04 = Core::sql($sql1); // Account Title
			$sql2 = "SELECT * FROM rssys.charge 
					 LEFT JOIN rssys.m04 ON rssys.charge.at_code = rssys.m04.at_code
					 LEFT JOIN rssys.m08 ON rssys.charge.cc_code = rssys.m08.cc_code
					 -- LEFT JOIN rssys.subctr ON rssys.charge.scc_code = rssys.subctr.scc_code
					 WHERE rssys.charge.active = TRUE
					 ORDER BY rssys.charge.chg_desc ASC
					";
			$this->charge = Core::sql($sql2);
			$sql3 = 'SELECt * FROM rssys.ppasubgrp ORDER BY seq';
	    	$this->ppa = Core::sql($sql3);
		}
		public function view() // TO VIEW CHARGE MODULE
		{
			$grp = Session::get('grp_ri');
	        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
	           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
	        }
			// return dd($this->charge);
			return view('masterfile.accounting.masterfile-accounting_charges', ['m08' => $this->m08, 'm04' => $this->m04, 'charge' => $this->charge]);
		}
		public function add(Request $r) // TO ADD NEW CHARGE MODULE
		{
			$grp = Session::get('grp_ri');
	        if($grp[$this->MOD_CODE]["add"] != 'Y') {
	           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
	        }
			$data = [
						'chg_code' => $r->txt_id,
						'chg_desc' => $r->txt_name,
						'chg_num' => (isset($r->txt_chg_num) ? $r->txt_chg_num : '00000001'),
						'at_code' => (isset($r->select_act_ttl) ? $r->select_act_ttl : ''),
						'cc_code' => (isset($r->select_cc_code) ? $r->select_cc_code : ''),
						'chg_type' => (isset($r->select_typ) ? $r->select_typ : 'C'),
						'scc_code' => (isset($r->select_scc_code) ? $r->select_scc_code : ''),
						'price' => (isset($r->txt_dfl_pri) ? floatval($r->txt_dfl_pri) : floatval(0.00)),
					];
				// return dd(Core::insertTable('rssys.charge', $data, 'Charge'));
			if (Core::insertTable('rssys.charge', $data, 'Charge'))
		        {
		            return back();
		        }
		    return back();
		}
		public function getSubCosts(Request $r) // TO GET SUB COSTS
		{
			$sql = "SELECT * FROM rssys.subctr WHERE cc_code = '$r->cc_code'";
			return Core::sql($sql);
		}
		public function update(Request $r) // TO UPDATE EXISTING CHARGE MODULE
		{
			$grp = Session::get('grp_ri');
	        if($grp[$this->MOD_CODE]["upd"] != 'Y') {
	           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
	        }
			// return dd($r);
			$data = [
						// 'chg_code' => $r->txt_id,
						'chg_desc' => $r->txt_name,
						'chg_num' => (isset($r->txt_chg_num) ? $r->txt_chg_num : '00000001'),
						'at_code' => (isset($r->select_act_ttl) ? $r->select_act_ttl : ''),
						'cc_code' => (isset($r->select_cc_code) ? $r->select_cc_code : ''),
						'chg_type' => (isset($r->select_typ) ? $r->select_typ : 'C'),
						'scc_code' => (isset($r->select_scc_code) ? $r->select_scc_code : ''),
						'price' => (isset($r->txt_dfl_pri) ? floatval($r->txt_dfl_pri) : floatval(0.00)),
					];
			// return dd(Core::updateTable('rssys.charge', 'chg_code', $r->txt_id, $data, 'Charge'));
			if (Core::updateTable('rssys.charge', 'chg_code', $r->txt_id, $data, 'Charge'))
	        {
	             return back();
	        }
	        return back();
		}
		public function delete(Request $r) // TO REMOVE EXISTING CHARGE MODULE
		{
			$grp = Session::get('grp_ri');
	        if($grp[$this->MOD_CODE]["del"] != 'Y') {
	           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
	        }
			$data = ['active' => FALSE];
			if (Core::updateTable('rssys.charge', 'chg_code', $r->txt_id, $data, 'Charge'))
	        {
	             return back();
	        }
	        return back();
		}
	}