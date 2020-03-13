<?php

namespace App\Http\Controllers\Report\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use App\Inventory;
use Carbon\Carbon;

class SSMI extends Controller
{
    public function view()
    {  
    	$itmgrp = Core::getAll('rssys.itmgrp');

        return view('report.inventory.ssmi', compact('itmgrp'));
    }

    public function print(Request $request)
    {
    	$itmgrp = $request->select_itmgrp;
    	$frmdate = $request->dtp_frmdate;
    	$todate = $request->dtp_todate;

    	$data = Inventory::printSSMI($itmgrp, $frmdate, $todate); 
    	$total = Inventory::printSSMITotal($itmgrp, $frmdate, $todate);

        $date = date_create($todate);
    	$asofdt = date_format($date, "F d, Y");

    	$itmgrpdesc = Inventory::getItemGrp($itmgrp);

    	return view('report.inventory.ssmi-print', compact('asofdt', 'data', 'itmgrpdesc', 'total'));
    }

    public function view_02()
    {  
    	$itmgrp = Core::getAll('rssys.itmgrp');

        return view('report.inventory.ssmi-02', compact('itmgrp'));
    }

    public function print_02(Request $request)
    {
    	$itmgrp = $request->select_itmgrp;
    	$frmdate = $request->dtp_frmdate;
    	$todate = $request->dtp_todate;

    	$data = Inventory::printSSMI_02($itmgrp, $frmdate, $todate); 
    	$total = Inventory::printSSMITotal_02($itmgrp, $frmdate, $todate);

        $date = date_create($todate);
    	$asofdt = date_format($date, "F d, Y");

    	$itmgrpdesc = Inventory::getItemGrp($itmgrp);

    	return view('report.inventory.ssmi-print-02', compact('asofdt', 'data', 'itmgrpdesc', 'total'));
    }
}