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
    	$date = $request->dtp_date;

    	$year = date('Y', strtotime($date));

    	$frmdt = $year.'-01-01';
    	$todt = $date;

    	$data = Inventory::printSSMI($itmgrp, $frmdt, $todt); 

        $date = date_create($date);
    	$asofdt = date_format($date, "F d, Y");

    	$itmgrpdesc = Inventory::getItemGrp($itmgrp);

    	return view('report.inventory.ssmi-print', compact('asofdt', 'data', 'itmgrpdesc'));
    }
}