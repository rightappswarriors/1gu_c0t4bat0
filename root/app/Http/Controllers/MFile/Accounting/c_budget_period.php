<?php

	namespace App\Http\Controllers\MFile\Accounting;

	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Core;
	use Session;

	class c_budget_period extends Controller
	{
		public function __construct()
		{
			$this->MOD_CODE = "M1000012";
			// ORDER BY rssys.x03.budget_from ASC, rssys.x03.mo ASC
			$sql = "SELECT * FROM rssys.budget_period";
			$this->budget_period = Core::sql($sql);
			if (count($this->budget_period) > 0) {
				for ($i=0; $i < count($this->budget_period); $i++)
				{
					$this->budget_period[$i]->budgetfrom_desc = Core::DateString($this->budget_period[$i]->budgetfrom);
					$this->budget_period[$i]->budgetto_desc = Core::DateString($this->budget_period[$i]->budgetto);
				}
			}
		}
		public function view() // TO VIEW BUDGET PERIOD MODULE
		{
			$grp = Session::get('grp_ri');
	        if($grp[$this->MOD_CODE]["restrict"] != 'Y') {
	           return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
	        }
			// return dd($this->budget_period);
			return view('masterfile.accounting.masterfile-accounting_budget_period', ['budget_period' => $this->budget_period]);
		}
		public function add(Request $r) // TO ADD NEW BUDGET PERIOD MODULE
		{
			$grp = Session::get('grp_ri');
	        if($grp[$this->MOD_CODE]["add"] != 'Y') {
	           return back()->with('alert', ["Error", "error", "You don't have permission to use this function."]);
	        }
			// return dd($r);
			$data = [
						'budget_code' => $r->txt_id,
						'budget_desc' => $r->txt_name,
						'budgetfrom' => $r->txt_date_from,
						'budgetto' => $r->txt_date_to,
					];
			// return Core::insertTable('rssys.x03', $data, 'Account Period');
			if (Core::insertTable('rssys.budget_period', $data, 'Budget Period'))
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