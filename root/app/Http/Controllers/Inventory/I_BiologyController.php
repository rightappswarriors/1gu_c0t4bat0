<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class I_BiologyController extends Controller
{
    private $stk_trns_type = "BA";
    private $module = "Biological Acquisition";



    // START BIOLOGY ACQUISITION

    public function acq_table(){
      $data = Inventory::getBioAcq();
      return view('inventory.biology.bio_acq_table', compact('data'));
    }

    public function acq_add(Request $request)
    {
        if($request->isMethod('get'))
        {

            $isnew = true;
            $data = Inventory::getBioItemSearchTable();

            return view('inventory.biology.biologyacqusition_add', compact( 'data', 'isnew'));
        }
        else if($request->isMethod('post'))
        {

          try {
              $datetime = Carbon::now();
              $flag = "true";

              $table = 'rssys.biology_acquisitionhd';
              $tableln = "rssys.biology_acquistionln";

              $getCode = Core::getm99One('biological_acquisition');
              $code = $getCode->biological_acquisition;

              if (empty($code)) {
                  return 'code is null.';
              }

              $fund = $request->fund;
              $koa = $request->koa;
              $reference = $request->reference;

              $data = [
                  'code' => $code,
                  'fund' => $fund,
                  'kindofanimals' => $koa,
                  'reference' => $reference,
              ];

              $insertHeader = Core::insertTable($table, $data, $this->module);

              if ($insertHeader == true) {
                  $updateM99 = Core::updatem99('biological_acquisition', Core::get_nextincrementlimitchar($code, 8));

                  if ($updateM99 == true) {
                      foreach($request->tbl_itemlist as $tb) {
                          $data2 = ['code' => $code,
                              'date' => $tb[0],
                              'ln_num' => $tb[1],
                              'item_code' => $tb[2],
                              'property_no' => $tb[3],
                              'item_desc' => $tb[4],
                              'qty' => $tb[5],
                              'remarks' => $tb[6],
                          ];

                          $insertLine = Core::insertTable($tableln, $data2, $this->module);

                      }
                      return json_encode($insertLine);
                  } else {
                      return json_encode($updateM99);
                  }
              } else {
                  return json_encode($insertHeader);
              }

              return $flag;
          } catch (Exception $e) {
              return $e->getMessage();
          }
        
        }
    }



    public function acq_edit(Request $request, $code) {
      if($request->isMethod('get')) // for entry
      {

          $data = Inventory::getBioItemSearchTable();
          $biohd=Inventory::getBioAcqHeader($code);
          $bioln=Inventory::getBioAcqLine($code);
          $isnew=false;
          return view('inventory.biology.biologyacqusition_add', compact('data', 'biohd', 'bioln', 'isnew'));
      }
      elseif($request->isMethod('post')) {
          $flag="true";
          $table = 'rssys.biology_acquisitionhd';
          $tableln = "rssys.biology_acquistionln";
          $code=$code;
          $fund = $request->fund;
          $koa = $request->koa;
          $reference = $request->reference;

          $data=[ 'code' => $code,
                  'fund' => $fund,
                  'kindofanimals' => $koa,
                  'reference' => $reference,
                ];
          $updHeader=Core::updateTable($table, 'code', $code, $data, $this->module);
          if($updHeader=='true') {
              $del_dataln=[['code',
              '=',
              $code]];
      
              $delLine=Core::deleteTableMultiWhere($tableln, $del_dataln, $this->module);
              foreach($request->tbl_itemlist as $tb) {
                  $data2=[
                            'code' => $code,
                            'date' => $tb[0],
                            'ln_num' => $tb[1],
                            'item_code' => $tb[2],
                            'property_no' => $tb[3],
                            'item_desc' => $tb[4],
                            'qty' => $tb[5],
                            'remarks' => $tb[6],];
                  $insertLine=Core::insertTable($tableln, $data2, $this->module);

              }

                      return json_encode($insertLine);

          }
          else {
              return json_encode($updHeader);
          }
          return $flag;
      }
}

    public function acq_cancel(Request $request)
    {
      $table = "rssys.biology_acquisitionhd";
      $flag = 'true';

      $cancelBioAcq = Inventory::cancelBioAcq($request->code, $this->module);

      if($cancelBioAcq = 'true')
      {
        return $cancelBioAcq;
      }

      return $flag;
    }


    //END BIOLOGY ACQUISITION


    // START BIOLOGY OF OFFSPRING

    public function boo_table(){
      $data = Inventory::getBioBoo();
      return view('inventory.biology.bio_boo_table', compact('data'));
    }

    public function boo_add(Request $request)
    {
        if($request->isMethod('get'))
        {

            $isnew = true;
            $data = Inventory::getBioItemSearchTable();

            return view('inventory.biology.biologyoffspring_add', compact( 'data', 'isnew'));
        }
        else if($request->isMethod('post'))
        {

          try {

              $datetime = Carbon::now();
              $flag = "true";

              $table = 'rssys.biology_offspringhd';
              $tableln = "rssys.biology_offspringln";

              $getCode = Core::getm99One('biological_offspring');
              $code = $getCode->biological_offspring;

              if (empty($code)) {
                  return 'code is null.';
              }

              $fund = $request->fund;
              $koa = $request->koa;
              $reference = $request->reference;

              $data = [
                  'code' => $code,
                  'fund' => $fund,
                  'kindofanimals' => $koa,
                  'reference' => $reference,
              ];

              $insertHeader = Core::insertTable($table, $data, $this->module);

              if ($insertHeader == true) {
                  $updateM99 = Core::updatem99('biological_offspring', Core::get_nextincrementlimitchar($code, 8));

                  if ($updateM99 == true) {
                      foreach($request->tbl_itemlist as $tb) {
                          $data2 = ['code' => $code,
                              'date' => $tb[0],
                              'ln_num' => $tb[1],
                              'item_code' => $tb[2],
                              'property_no' => $tb[3],
                              'item_desc' => $tb[4],
                              'numberofoffspring' => $tb[5],
                              'remarks' => $tb[6],
                          ];

                          $insertLine = Core::insertTable($tableln, $data2, $this->module);

                          
                      }
                      return json_encode($insertLine);
                  } else {
                      return json_encode($updateM99);
                  }
              } else {
                  return json_encode($insertHeader);
              }

              return $flag;
          } catch (Exception $e) {
              return $e->getMessage();
          }
        
        }
    }



    public function boo_edit(Request $request, $code) {
      if($request->isMethod('get')) // for entry
      {

          $data =Inventory::getBioItemSearchTable();
          $biohd=Inventory::getBioBooHeader($code);
          $bioln=Inventory::getBioBooLine($code);
          $isnew=false;
          return view('inventory.biology.biologyoffspring_add', compact('data', 'biohd', 'bioln', 'isnew'));
      }
      elseif($request->isMethod('post')) {
          $flag="true";
          $table = 'rssys.biology_offspringhd';
          $tableln = "rssys.biology_offspringln";
          $code=$code;
          $fund = $request->fund;
          $koa = $request->koa;
          $reference = $request->reference;

          $data=[ 'code' => $code,
                  'fund' => $fund,
                  'kindofanimals' => $koa,
                  'reference' => $reference,
                ];
          $updHeader=Core::updateTable($table, 'code', $code, $data, $this->module);
          if($updHeader=='true') {
              $del_dataln=[['code',
              '=',
              $code]];
      
              $delLine=Core::deleteTableMultiWhere($tableln, $del_dataln, $this->module);
              foreach($request->tbl_itemlist as $tb) {
                  $data2=[
                            'code' => $code,
                            'date' => $tb[0],
                            'ln_num' => $tb[1],
                            'item_code' => $tb[2],
                            'property_no' => $tb[3],
                            'item_desc' => $tb[4],
                            'numberofoffspring' => $tb[5],
                            'remarks' => $tb[6],];
                  $insertLine=Core::insertTable($tableln, $data2, $this->module);
                      
              }
              return json_encode($insertLine);
          }
          else {
              return json_encode($updHeader);
          }
          return $flag;
      }
}

    public function boo_cancel(Request $request)
    {
      $table = "rssys.biology_offspringhd";
      $flag = 'true';

      $cancelBioBoo = Inventory::cancelBioBoo($request->code, $this->module);

      if($cancelBioBoo = 'true')
      {
        return $cancelBioBoo;
      }

      return $flag;
    }

    //END BIOLOGY OF OFFSPRING

    // START BIOLOGY OF DISPOSITION

    public function dispo_table(){
      $data = Inventory::getBioDispo();
      return view('inventory.biology.bio_dispo_table', compact('data'));
    }


    public function dispo_add(Request $request)
    {
        if($request->isMethod('get'))
        {

            $isnew = true;
            $data = Inventory::getBioItemSearchTable();

            return view('inventory.biology.biologydisposition_add', compact( 'data', 'isnew'));
        }
        else if($request->isMethod('post'))
        {

          try {

              $datetime = Carbon::now();
              $flag = "true";

              $table = 'rssys.biology_dispositionhd';
              $tableln = "rssys.biology_dispositionln";

              $getCode = Core::getm99One('biological_disposition');
              $code = $getCode->biological_disposition;

              if (empty($code)) {
                  return 'code is null.';
              }

              $fund = $request->fund;
              $koa = $request->koa;
              $reference = $request->reference;

              $data = [
                  'code' => $code,
                  'fund' => $fund,
                  'kindofanimals' => $koa,
                  'reference' => $reference,
              ];

              $insertHeader = Core::insertTable($table, $data, $this->module);

              if ($insertHeader == true) {
                  $updateM99 = Core::updatem99('biological_disposition', Core::get_nextincrementlimitchar($code, 8));

                  if ($updateM99 == true) {
                      foreach($request->tbl_itemlist as $tb) {
                          $data2 = ['code' => $code,
                              'date' => $tb[0],
                              'ln_num' => $tb[1],
                              'item_code' => $tb[2],
                              'property_no' => $tb[3],
                              'item_desc' => $tb[4],
                              'numberofdisposition' => $tb[5],
                              'natureofdisposition' => $tb[6],
                              'remarks' => $tb[6],
                          ];

                          $insertLine = Core::insertTable($tableln, $data2, $this->module);
                      }
                      return json_encode($insertLine);
                  } else {
                      return json_encode($updateM99);
                  }
              } else {
                  return json_encode($insertHeader);
              }

              return $flag;
          } catch (Exception $e) {
              return $e->getMessage();
          }
        
        }
    }




    public function dispo_edit(Request $request, $code) {
      if($request->isMethod('get')) // for entry
      {

          $data =Inventory::getBioItemSearchTable();
          $biohd=Inventory::getBioDispoHeader($code);
          $bioln=Inventory::getBioDispoLine($code);
          $isnew=false;
          return view('inventory.biology.biologydisposition_add', compact('data', 'biohd', 'bioln', 'isnew'));
      }
      elseif($request->isMethod('post')) {
          $flag="true";
          $table = 'rssys.biology_dispositionhd';
          $tableln = "rssys.biology_dispositionln";
          $code=$code;
          $fund = $request->fund;
          $koa = $request->koa;
          $reference = $request->reference;

          $data=[ 'code' => $code,
                  'fund' => $fund,
                  'kindofanimals' => $koa,
                  'reference' => $reference,
                ];
          $updHeader=Core::updateTable($table, 'code', $code, $data, $this->module);
          if($updHeader=='true') {
              $del_dataln=[['code',
              '=',
              $code]];
      
              $delLine=Core::deleteTableMultiWhere($tableln, $del_dataln, $this->module);
              foreach($request->tbl_itemlist as $tb) {
                  $data2=[
                            'code' => $code,
                            'date' => $tb[0],
                            'ln_num' => $tb[1],
                            'item_code' => $tb[2],
                            'property_no' => $tb[3],
                            'item_desc' => $tb[4],
                            'numberofdisposition' => $tb[5],
                            'natureofdisposition' => $tb[6],
                            'remarks' => $tb[7],];
                  $insertLine=Core::insertTable($tableln, $data2, $this->module);     
              }
              return json_encode($insertLine);
          }
          else {
              return json_encode($updHeader);
          }
          return $flag;
      }
}

    public function dispo_cancel(Request $request)
    {
      $table = "rssys.biology_dispositionhd";
      $flag = 'true';

      $cancelBioDispo = Inventory::cancelBioDispo($request->code, $this->module);

      if($cancelBioDispo = 'true')
      {
        return $cancelBioDispo;
      }

      return $flag;
    }


//END BIOLOGY OF DISPOSITION
}




