@extends('_main')
@if($isnew)
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Biology','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Disposition','icon'=>'none','st'=>true],
    ];
    $_ch = " Disposition"; // Module Name
@endphp
@else
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Item Repair Info','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Edit','icon'=>'none','st'=>true],
    ];
    $_ch = " Disposition"; // Module Name
@endphp
@endif
@section('content')
    <!-- Content Header (Page header) -->
    @include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"> Disposition</h3>
          @if(!$isnew)
            <input type="hidden" name="txt_code" value="{{$biohd->code}}">
          @endif
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <form id="HeaderForm" data-parsley-validate novalidate>
        <div class="box-body" style="">
          <div class="row">

            <div class="col-md-3">
              <div class="form-group">
                <label class="required">FUND<span style="color:red"><strong>*</strong></span></label>
                 @if($isnew)
                  <input type="text" class="form-control" name="b_fund" data-parsley-errors-container="#validate_b_fund" required readonly="">
                 @else
                  <input type="text" class="form-control" name="b_fund" value="{{$biohd->fund}}" data-parsley-errors-container="#validate_b_fund" required readonly="">
                 @endif
                  <span id="#validate_b_fund"></span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="required">Kind of Animals<span style="color:red"><strong>*</strong></span></label>
                 @if($isnew)
                <input type="text" class="form-control" name="b_koa" data-parsley-errors-container="#validate_b_koa" required readonly="">
                @else
                <input type="text" class="form-control" name="b_koa" value="{{$biohd->kindofanimals}}" data-parsley-errors-container="#validate_b_koa" required readonly="">
                @endif
                  <span id="#validate_b_koa"></span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="required">Reference</label>
                @if($isnew)
                  <input type="text" class="form-control" name="txt_reference" data-parsley-errors-container="#validate_reference">
                @else
                  <input type="text" class="form-control" name="txt_reference" value="{{$biohd->reference}}" data-parsley-errors-container="#validate_reference">
                @endif
                  <span id="#validate_reference"></span>
              </div>
            </div>
            <div class="col-md-3" style="display: none;">
              <div class="form-group">
                <label>Acquisition Code</label>
                @if($isnew)
                  <input type="text" class="form-control" name="acq_code" data-parsley-errors-container="#validate_reference">
                @else
                  <input type="text" class="form-control" name="acq_code" value="{{$biohd->acq_code}}" data-parsley-errors-container="#validate_reference">
                @endif
                  <span id="#validate_reference"></span>
              </div>
            </div>                        
            
        </div>
      </form>
        <!-- /.box-body -->
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="row">
                <div class="col-sm-6">
                  <h3 class="box-title">Item Details</h3>
                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemsearch-modal"><i class="fa fa-plus"></i> Add item</button> --}}
                    @if($isnew)
                      <button type="button" class="btn btn-primary" id="addacqitembtn" data-toggle="modal" data-target="#additemfromacq-modal"><i class="fa fa-plus"></i> Add item from Acquisition</button>
                    
                    @else
                    
                      <button type="button" class="btn btn-primary disabled" id="addacqitembtn" data-toggle="modal" data-target="#additemfromacq-modal"><i class="fa fa-plus" disabled></i> Add item from Acquisition</button>
                    
                    @endif
                </div>
              </div>
              <!-- Modal -->
            <div class="row">
              <div class="modal fade" id="itemsearch-modal">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Item Search</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                          <div class="table-responsive">
                          <table id="example1" class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                              <th></th>
                              <th>Item Code</th>
                              <th>Quantity</th>
                              <th>Property No</th>
                              <th>Item Description</th>
                              <th>Unit</th>
                              <th>Brand</th>
                              <th>Price</th>
                              <th>Rack Location</th>
                              <th>Item Category</th>
                              <th>Stock Location</th>
                              <th>Branch</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $di)
                            <tr>
                              <td><input type="radio" name="r3" onclick="EnterItem_Add('{{$di->item_code}}')"></td>
                              <td>{{$di->item_code}}</td>
                              <td>{{$di->qty_onhand_su}}</td>
                              <td>{{$di->part_no}}</td>
                              <td>{{$di->item_desc}}</td>
                              <td>{{$di->sale_unit}}</td>
                              <td>{{$di->brd_name}}</td>
                              <td>{{$di->regular}}</td>
                              <td>{{$di->bin_loc}}</td>
                              <td>{{$di->grp_desc}}</td>
                              <td>{{$di->whs_desc}}</td>
                              <td>{{$di->branchname}}</td>
                            </tr>
                            @endforeach
                            </tfoot>
                          </table>
                          </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#enteritem-modal"><i class="fa fa-plus"></i> Add Item</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            </div> 

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="tbl_itemlist" class="table table-bordered table-striped">
                <thead>
                <tr>
                  
                  <th>Line No.</th>
                  <th>Date</th>
                  <th>Item Code</th>
                  <th>Property No.</th>
                  <th>Description</th>
                  <th>Number Disposed Of</th>
                  <th>Number of Disposed Offspring</th>
                  <th>Nature Of Disposition</th>
                  <th>Remarks</th>
                  <th>Actions</th>

                </tr>
                </thead>
                <tbody>
                  @if(!$isnew)
                  @foreach($bioln as $rl)
                     <tr>
                      
                       <td>{{$rl->ln_num}}</td>
                       <td>{{$rl->date}}</td> 
                       <td>{{$rl->item_code}}</td> 
                       <td>{{$rl->property_no}}</td>
                       <td>{{$rl->item_desc}}</td>
                       <td>{{$rl->numberofdisposition}}</td>
                       <td>{{$rl->numberofoffspring}}</td>
                       <td>{{$rl->natureofdisposition}}</td>
                       <td>{{$rl->remarks}}</td>
                       <td style="white-space: nowrap;"><center><a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit({{$rl->ln_num}});"></i></a>&nbsp;<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete({{$rl->ln_num}});"></i></a></center>
                       </td>
                     </tr>  
                  @endforeach
                  @endif
                </tbody>
              </table>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group" style="display: flex;">
                <a href="{{route('inventory.biology.bio_dispo_table')}}" class="btn btn-block btn-primary"><i class="fa fa-arrow-left"></i> Go Back</a>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group" style="display: flex;">
                @if($isnew)
                <a class="btn btn-block btn-success" style="margin-top: 0;"  onclick="Save()"><i class="fa fa-save"></i> Save</a>
                @else
                <a class="btn btn-block btn-success" style="margin-top: 0;"  onclick="EditSave()"><i class="fa fa-save"></i> Save</a>
                @endif
              </div>
            </div>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

       <!-- /.modal -->
       <!-- Enter Item Modal Form -->
              <div class="row">
              <div class="modal fade in" id="enteritem-modal">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                      <h4 class="modal-title"><span id="ENTER_ITEM"></span> Item</h4>
                    </div>
                    <div class="modal-body">
                      <form id="add-form" data-parsley-validate novalidate>
                        <span class="AddMode EditMode">
                      <div class="box-body">
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="">Line No.</label>
                              <input type="text" class="form-control" name="txt_lineno" readonly="">
                            </div>
                          </div> 
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="">Item Code</label>
                              <input type="text" class="form-control" name="txt_itemcode" readonly="">
                              <span class="validate_iitem_code"></span>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Property No.</label>
                              <input type="text" class="form-control" name="txt_partno" readonly="">
                            </div>
                          </div>                        
                        </div>
                        <div class="row">
                          <div class="col-sm-9">
                            <div class="form-group">
                              <label>Item Descriptions</label>
                              <input type="text" class="form-control" name="txt_itemdesc" readonly=""> 
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Item Search</label>
                              <span class="AddModeBtn">
                                 <button class="btn btn-block btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#itemsearch-modal"><i class="fa fa-search"></i> Item Search</button>
                              </span>
                              <span class="EditModeBtn">
                                 <button class="btn btn-block btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#itemsearch-modal" disabled=""><i class="fa fa-search"></i> Item Search</button>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label>Nature of Disposition</label>
                              <input type="text" class="form-control" name="txt_nature"> 
                            </div>
                          </div>

                          <div class="col-sm-12">
                            <div class="form-group">
                              <label>Item Remarks</label>
                              <input type="text" class="form-control" name="txt_remarks"> 
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <label>Date <span style="color:red"><strong>*</strong></span></label>
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input  value="{{date('Y-m-d',strtotime('now'))}}" name="txt_date" type="date" class="form-control">
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>Number Disposed of <span style="color:red"><strong>*</strong></span></label>
                                <input type="number" id="txt_qty" class="form-control" name="txt_qty" min="0" >
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>Number of Disposed Offspring <span style="color:red"><strong>*</strong></span></label>
                                <input type="number" id="txt_off" class="form-control" name="txt_off" min="0">
                            </div>
                          </div>
                        </div>

                      </div>
                    </span>
                    <span class="DeleteMode">
                      <center>
                          <h4 class="text-transform: uppercase;">Are you sure you want to delete this item?
                          </h4>
                      </center>
                    </span>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <span class="AddModeBtn">
                        <button type="button" class="btn btn-primary" onclick="set_tbl_itemlist('sa')">Save & add more</button>
                        <button type="button" class="btn btn-primary" onclick="set_tbl_itemlist('sc')">Save & close</button>
                      </span>
                      <span class="EditModeBtn">
                        <button type="button" class="btn btn-primary" onclick="set_tbl_itemlist('sc')">Save & close</button>
                      </span>
                      <span class="DeleteMode">
                        <button type="button" class="btn btn-primary" onclick="set_tbl_itemlist('sc')">Delete</button>
                      </span>
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              </div>
              <!-- End Modal -->
              <!-- Enter Item Modal Form -->

              <!-- Add item(s) from ACQUISITION -->
              <div class="row">
              <div class="modal fade in" id="additemfromacq-modal">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                      <h4 class="modal-title">Add item(s) from Acquisition</h4>
                    </div>
                    <div class="modal-body">
                      <form id="add-form">
                       
                      <div class="box-body">
                        
                        
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label>SELECT ACQUISITION</label>
                              <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_acq" required="" onchange="getDataFromLoadItems()">
                                  <option value="" selected="selected">--- Select ACQUISITION HEADER ---</option>
                                  @foreach($acqData as $acq)
                                   {{-- {{print_r([$risa->rec_num,$risa->ris_no,$risa->cc_code,$risa->nameofpersonnel])}} --}}
                                  <option value="{{$acq->code}}">{{$acq->fund}} || {{$acq->kindofanimals}}</option>

                                  @endforeach
                                </select>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                           <div class="table-responsive">
                           <table id="tbl_acqitemlist" class="table table-bordered table-striped">
                             <thead>
                               <tr>
                                 <th><input type="checkbox" name="select_all" onchange="checkAllACQItems(this.checked)"></th>
                                 <th>Line</th>
                                 <th>Item Code</th>
                                 <th>Property No</th>
                                 <th>Date</th>
                                 <th>Description</th>
                               </tr>
                             </thead>
                             <tbody>
                             </tbody>
                           </table>
                          </div>
                      </div>
                        
                        
                      </div>
                   
                      </form>
                    </div>
                    <div class="modal-footer">
                     
                        <button type="button" class="btn btn-primary" onclick="selectedACQItems()">Proceed</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                     
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              </div>
              <!-- End Modal -->
              <!-- Add item(s) from ACQUISITION -->  

    <script>

   // Fix modal scroll disabled.
    $('body').on('hidden.bs.modal', function () {
     if($('.modal.in').length > 0)
     {
         $('body').addClass('modal-open');
     }
     });
    // Fix modal scroll disabled.

      var selectedRow = 0;
      loadedItemsFromACQ = [];

      // hide table rpo column
      $(document).ready(function() {

      // get selected row
      $('#tbl_itemlist tbody').on( 'click', 'tr', function () {
                var table = $('#tbl_itemlist').DataTable();
                selectedRow = table.row( this ).index();

            });

      $('#tbl_itemlist').DataTable( {
        "columnDefs": [
            {
 
                "visible": false,
                "searchable": false
            }
        ]
      } );
      } );



      function EnterItem_Add(code)
      {
        clear();

        $('#ENTER_ITEM').text('Add');
        $('.AddMode').show();
        $('.AddModeBtn').show();
        $('.EditMode').show();
        $('.EditModeBtn').hide();
        $('.DeleteMode').hide();
        
        var line = ($('#tbl_itemlist').DataTable().rows().count()) + 1;

        $.ajax({
                 url: '{{asset('inventory/stockin/stockin_getitemdetails')}}/'+code,
                 method: 'GET',
                 success : function(data)
                           {
                             $('input[name="txt_lineno"]').val(line);
                             $('input[name="txt_itemcode"]').val(code);
                             $('input[name="txt_partno"]').val(data[0]);
                             $('input[name="txt_itemdesc"]').val(data[1]);
                           }
              });
      }

      function EnterItem_Edit(line)
      {
          $('#ENTER_ITEM').text('Edit');
          $('.AddMode').show();
          $('.AddModeBtn').hide();
          $('.EditMode').show();
          $('.EditModeBtn').show();
          $('.DeleteMode').hide();

          var table = $('#tbl_itemlist').DataTable();
          var row = line - 1;
          var data = table.row(row).data();
          var itemcode = data[2];
         
          
          $('input[name="txt_lineno"]').val(data[0]);
          $('input[name="txt_partno"]').val(data[3]);
          $('input[name="txt_itemcode"]').val(data[2]);
          $('input[name="txt_itemdesc"]').val(data[4]);
          $('input[name="txt_qty"]').val(data[5]);
          $('input[name="txt_nature"]').val(data[7]);
          $('input[name="txt_remarks"]').val(data[8]);
          $('input[name="txt_off"]').val(data[6]);

          $.ajax({
             url: '{{asset('inventory/biology/bio_getinventorydetails')}}/'+itemcode,
             method: 'GET',
             success : function(data)
             {
                if(data.length > 0){
                  var max = data[0].qty_onhand_su;
                  $("input[name='txt_off']").attr({
                     "max" : max,        // substitute your own
                  });
                }
             }
           });

          $('#enteritem-modal').modal('toggle');

          //console.log(data);
      }

      function EnterItem_Delete(line)
      {
        $('#ENTER_ITEM').text('Delete');
        $('.AddMode').hide();
        $('.AddModeBtn').hide();
        $('.EditMode').hide();
        $('.EditModeBtn').hide();
        $('.DeleteMode').show();

        $('#enteritem-modal').modal('toggle');
      }


      

      function set_tbl_itemlist(type)
      {
        if($('#add-form').parsley().validate()) // check required fields of the Add Item Form
        {

        var table = $('#tbl_itemlist').DataTable();

        
        var line = $('input[name="txt_lineno"]').val();
        var item_code = $('input[name="txt_itemcode"]').val();
        var part_no = $('input[name="txt_partno"]').val();
        var item_desc = $('input[name="txt_itemdesc"]').val();
        var qty = $('input[name="txt_qty"]').val();
        var date = $('input[name="txt_date"]').val();
        var nature = $('input[name="txt_nature"]').val();
        var remarks = $('input[name="txt_remarks"]').val();
        var offspring = $('input[name="txt_off"]').val();
        var buttons = '<center>' +
              '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit( \''+line+'\');"></i></a>&nbsp;' +
              '<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete(\''+line+'\');"></i></a>' +
            '</center>';

        if($('#ENTER_ITEM').text() == 'Add')
        {

        table.row.add([line, date, item_code,part_no, item_desc, qty, offspring, nature, remarks, buttons]).draw();

        }
        else if($('#ENTER_ITEM').text() == 'Edit')
        {
          table.row(selectedRow).data([line, date, item_code,part_no, item_desc, qty, offspring, nature, remarks, buttons]).draw();
        }
        else // remove item
        {
          table.row(selectedRow).remove().draw();
          
          var i;
          var r = 1;

          for(i = 0; i < $('#tbl_itemlist').DataTable().rows().count(); i ++)
          {
            table.cell({row:i, column:0}).data(r);
            r++;
          }

          alert('Successfully deleted.');
        }

        total_amount();
        clear();

        if(type == 'sc') // save and close
        {
            $('#enteritem-modal').modal('toggle');
        }
        else
        {
            $('#enteritem-modal').modal('toggle');
            $('#itemsearch-modal').modal('show');
        }
      }
      }

      function clear()
      {
        $('input[name="txt_itemcode"]').val('');
        $('input[name="txt_lineno"]').val('');
        $('input[name="txt_partno"]').val('');
        $('input[name="txt_remarks"]').val('');
        $('input[name="txt_itemdesc"]').val('');
        $('select[name="select_vat"]').val('').trigger('change');
        $('input[name="txt_qty"]').val('');
        $('select[name="select_unit"]').val('').trigger('change');
      }


      function getDataFromLoadItems() // load items from ACQUISITION
      {
         var tbl_acqitemlist = $('#tbl_acqitemlist').DataTable();
         var code = $('select[name="select_acq"]').select2('data')[0].id;
         var dataar;
         
         tbl_acqitemlist.clear().draw();

         acqcode = code;

         if(code != '')
         {
           $.ajax({
             url: '{{asset('inventory/biology/bio_getacqdetails')}}/'+code,
             method: 'GET',
             success : function(data)
             {

                if(data.length > 0)
                {
                  loadedItemsFromACQ = data[0];
                  dataar = data[0];
                  
                  for(var i = 0; i < dataar.length; i++)
                  {
                    tbl_acqitemlist.row.add(['<input type="checkbox" id="chk_acqitems" class="chk_acqitems" value="'+dataar[i].ln_num+'">',
                                             dataar[i].ln_num, 
                                             dataar[i].item_code,
                                             dataar[i].property_no,
                                             dataar[i].date,
                                             dataar[i].item_desc,
                                            ]).draw();


                  }
                       $('input[name="b_fund"]').val(dataar[0].fund);
                       $('input[name="b_koa"]').val(dataar[0].kindofanimals);
                       $('input[name="txt_reference"]').val(dataar[0].reference);
                       $('input[name="acq_code"]').val(dataar[0].code);
                  // $('select[name="select_costcenter"]').val(data[1]).trigger('change');
                  // $('select[name=select_personnel]').val($('[name=select_ris]').find('option:selected').attr('personneltoreceive')).trigger('change');

                }

                
             }
           });
         }
      }

      function checkAllACQItems(chk_bool) // check/uncheck all checkbox risitems
      {
        let chk_acqitems = document.getElementsByClassName('chk_acqitems');
      
        for(let i = 0; i < chk_acqitems.length; i++) 
        {
          chk_acqitems[i].checked = chk_bool;
        }
      }

      function selectedACQItems()
      {
        var table = $('#tbl_itemlist').DataTable();
        let chk_acqitems = document.getElementsByClassName('chk_acqitems');
        let tbl_itemlist = $('#tbl_itemlist').DataTable();

        for(let i = 0; i < chk_acqitems.length; i++) 
        {
          if(chk_acqitems[i].checked)
          {
            loadedItemsFromACQ.forEach(function (a, b, c) {
                if(a.ln_num == chk_acqitems[i].value)
                {
                 var line = ($('#tbl_itemlist').DataTable().rows().count()) + 1;
                 var buttons = '<center>' +
                                  '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit( \''+line+'\');"></i></a>&nbsp;' +
                                  '<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete(\''+a.ln_num+'\');"></i></a>' +
                                '</center>';
                  table.row.add([line, null, a.item_code, a.property_no, a.item_desc, null, null, null, null, buttons]).draw();
                }
            });
          }
        }
        $('#addacqitembtn').addClass('disabled');
        $("#addacqitembtn").attr("disabled","");
        $('#additemfromacq-modal').modal('toggle');
      }

       function Save()
      {
        var tbl_itemlist = $('#tbl_itemlist').DataTable();

        if($('#HeaderForm').parsley().validate()) // check required fields of the header
        {
          if(tbl_itemlist.data().count() > 0) // check table items
          {
            var tbl_itemdata = tbl_itemlist.data().toArray(); // tbl_itemlist data

            var data = { 
                          _token : $('meta[name="csrf-token"]').attr('content'),
                          tbl_itemlist: tbl_itemdata,
                          fund: $('input[name="b_fund"]').val(),
                          koa: $('input[name="b_koa"]').val(),
                          reference: $('input[name="txt_reference"]').val(),
                          acq_code: $('input[name="acq_code"]').val(),

                       };

            $.ajax({
                   url: '{{route('inventory.biologydisposition_add')}}',
                   method: 'POST',
                   data: data,
                   success : function(flag)
                            {
                               if(flag == 'true')
                               {
                                 console.log(flag);
                                 location.href= "{{route('inventory.biology.bio_dispo_table')}}";
                               }
                               else
                               {
                                 alert('SYSTEM ERROR:\n'+flag);
                               }
                            }
                   });

            console.log(data);
          }
          else
          {
            alert("There's no item(s) to add. Please entry item(s).");
          }
        
         }
      }


      function EditSave()
      {
        var tbl_itemlist = $('#tbl_itemlist').DataTable();

        if($('#HeaderForm').parsley().validate()) // check required fields of the header
        {
          if(tbl_itemlist.data().count() > 0) // check table items
          {
              var tbl_itemdata = tbl_itemlist.data().toArray(); // tbl_itemlist data

              var code = $('input[name="txt_code"]').val();

              var data = { 
                            _token : $('meta[name="csrf-token"]').attr('content'),
                            tbl_itemlist: tbl_itemdata,
                            fund: $('input[name="b_fund"]').val(),
                            koa: $('input[name="b_koa"]').val(),
                            reference: $('input[name="txt_reference"]').val(),
                            acq_code: $('input[name="acq_code"]').val(),
                         };

              $.ajax({
                     url: '{{asset('inventory/biology/biologydisposition_edit')}}/'+code,
                     method: 'POST',
                     data: data,
                     success : function(flag)
                              {
                                 if(flag == 'true')
                                 {
                                   console.log(flag);
                                   location.href= "{{route('inventory.biology.bio_dispo_table')}}";
                                 }
                                 else
                                 {
                                   alert('SYSTEM ERROR:\n'+flag);
                                 }
                              }
                     });
         }
         else
         {
           alert("There's no item(s) to add. Please entry item(s).");
         }
       }
      }

      function total_amount()
      {
        var total_amt = 0.00;
        var tbl_itemlist = $('#tbl_itemlist').DataTable();
        var tbl_itemdata = tbl_itemlist.data().toArray(); //get all data of the table itemlist

        // foreach total amount
        $.each(tbl_itemdata, function(){
          total_amt += parseFloat(this[9]);
        });

        $('input[name="txt_grandtotalamt"]').val(total_amt.toFixed(2));

      }

    </script>


    </section>
    <!-- /.content -->
  
@endsection