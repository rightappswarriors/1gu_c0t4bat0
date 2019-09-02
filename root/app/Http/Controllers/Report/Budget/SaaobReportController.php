<?php

namespace App\Http\Controllers\Report\Budget;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use Carbon\Carbon;
use DB;
use App\Budget;

class SaaobReportController extends Controller
{
	public function view()
  {
        $financialyear = Budget::getX03();
        $fund = Budget::getFund();

        return view('report.saaob.saaob', compact('financialyear', 'fund'));
  }

  public function generate(Request $request)
  {
      $fy = $request->fy;
      $fund = $request->fund;

      $Header = Budget::generateSAAOBHdr($fy, $fund);

      dd($Header);
      $Line = Budget::printApproLine($b_num);
      $PPA = Budget::printApproPPA($b_num);

      return view('report.saaob.saaob-print', compact('Header', 'Line', 'PPA'));
  }
}