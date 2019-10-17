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
      
      $select_koa = $request->koa;
      $selected_fund = $request->fund;

     

      $getallitems = Inventory::getAllReports($select_koa, $selected_fund);
      $header = Inventory::getAllHeader($select_koa, $selected_fund);
      if($header == false){
        $isEmpty = 'Y';
      } 
      else{
        $isEmpty = 'N';
      }

     return view('report.biology.bioreport-print', compact('getallitems', 'header', 'isEmpty'));
  }
}