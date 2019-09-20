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
      $fy = $request->select_fy;
      $fid = $request->select_fund;
      $mo1 = $request->mo1;
      $mo2 = $request->mo2;
      $fund = Budget::printSAAOBGetFund($fid);

      $Header = Budget::printSAAOBHdr($fy, $fid);
      $Line = Budget::printSAAOBLine($fy, $fid, $mo1, $mo2);
      $Function = Budget::printSAAOBFunc($fy, $fid);
      $PPA = Budget::printSAAOBPPA($fy, $fid);

      return view('report.saaob.saaob-print', compact('Header', 'Line', 'fund', 'Function', 'PPA'));
  }
}