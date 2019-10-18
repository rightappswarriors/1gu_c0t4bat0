<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class InventoryReports extends Controller
{
    public function view(){
      return view('report.biology.biologyreport');
    }

    public function index(){
      $data = Inventory::getBioAllHeader();
      return view('report.biology.bioreportsview', compact('data'));
    }

    public function generate(Request $request)
  {
      
      $selected_code = $request->code;     
      
      $getallitems = Inventory::getAllReports($selected_code);

      $header = Inventory::getAllHeader($selected_code);
      if($header == false){
        $isEmpty = 'Y';
      } 
      else{
        $isEmpty = 'N';
      }

     return view('report.biology.bioreport-print', compact('getallitems', 'header', 'isEmpty'));
  }
}