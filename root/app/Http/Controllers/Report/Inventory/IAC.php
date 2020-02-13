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
    	$date = $request->dtp_date;
        $itmgrp = $request->select_itmgrp;

        $data = Inventory::printIAC($date, $itmgrp);
        $total = Inventory::printIACTotal($date, $itmgrp);

        $date = date_create($date);
        $asofdt = date_format($date, "F d, Y");

        $itmgrpdesc = Inventory::getItemGrp($itmgrp);

    	return view('report.inventory.iac-print', compact('asofdt', 'data', 'total', 'itmgrpdesc'));
    }
}