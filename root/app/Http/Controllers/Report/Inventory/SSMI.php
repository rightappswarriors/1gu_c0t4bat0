<?php

namespace App\Http\Controllers\Report\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class SSMI extends Controller
{
    public function view()
    {  
        return view('report.inventory.ssmi');
    }
}