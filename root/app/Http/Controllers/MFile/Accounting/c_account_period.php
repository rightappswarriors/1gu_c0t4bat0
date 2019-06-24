<?php

	namespace App\Http\Controllers\MFile\Accounting;

	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Core;
	use Session;

	class c_account_period extends Controller
	{
		public function __construct()
		{
			$this->MOD_CODE = "M1000011";
			$sql = "SELECT * FROM rssys.x03 ORDER BY rssys.x03.fy ASC, rssys.x03.mo ASC";
			$this->x03 = Core::sql($sql);
			if (count($this->x03) > 0) {
				for ($i=0; $i < count($this->x03); $i++)
				{
					$this->x03[$i]->from_desc = Core::DateString($this->x03[$i]->from);
					$this->x03[$i]->to_desc = Core::DateString($this->x03[$i]->to);
				}
			}
			$sql2 = "SELECT * FROM rssys.x04 ORDER BY rssys.x04.mo ASC";
			$this->x04 = Core::sql($sql2);
		}
		public function view()
		{
			$grp = Session::get('grp_ri');
	        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
	           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
	        }
			// return dd($this->x04);
			return view('masterfile.accounting.masterfile-accounting_period', ['x03' => $this->x03, 'x04' => $this->x04]);
		}
		public function add(Request $r)
		{
			$grp = Session::get('grp_ri');
	        if($grp[$this->MOD_CODE]["add"] != 'Y') {
	           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
	        }
			// return dd($r);
			$data = [
						'fy' => $r->txt_yr,
						'mo' => $r->txt_mo,
						'from' => $r->txt_date_from,
						'to' => $r->txt_date_to,
						'month_desc' => $r->txt_mo_desc
					];
			// return Core::insertTable('rssys.x03', $data, 'Account Period');
			if (Core::insertTable('rssys.x03', $data, 'Account Period'))
		        {
		            return back();
		        }
		    return back();
		}
		public function closed(Request $r)
		{
			// return dd($r);
		}
	}