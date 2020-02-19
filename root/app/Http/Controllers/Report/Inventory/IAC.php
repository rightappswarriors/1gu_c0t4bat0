<?php

namespace App\Http\Controllers\Report\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use App\Inventory;
use Carbon\Carbon;

class IAC extends Controller
{
    public function view()
    {  
        $itmgrp = Core::getAll('rssys.itmgrp');

        return view('report.inventory.iac', compact('itmgrp'));
    }

    public function print(Request $request)
    {
    	$frmdate = $request->dtp_frmdate;
        $todate = $request->dtp_todate;
        $itmgrp = $request->select_itmgrp;

        $data = Inventory::printIAC($frmdate, $todate, $itmgrp);
        $total = Inventory::printIACTotal($frmdate, $todate, $itmgrp);

        $date = date_create($todate);
        $asofdt = date_format($date, "F d, Y");

        $itmgrpdesc = Inventory::getItemGrp($itmgrp);

    	return view('report.inventory.iac-print', compact('asofdt', 'data', 'total', 'itmgrpdesc'));
    }
}