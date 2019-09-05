@extends('_main')
@if($isnew)
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Item Repair','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Create','icon'=>'none','st'=>true],
    ];
    $_ch = "Item Repair"; // Module Name
@endphp
@else
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Item Repair Info','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Edit','icon'=>'none','st'=>true],
    ];
    $_ch = "Item Repair"; // Module Name
@endphp
@endif
@section('content')
    <!-- Content Header (Page header) -->
    @include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Item Repair Info</h3>
            <input type="hidden" name="text_code" >
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
                <label>Model</label>
                <input type="text" class="form-control" name="ir_model" >
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Unit Serial No.</label>
                <input type="text" class="form-control" name="ir_unitserialno" >
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Engine Serial No.</label>
                <input type="text" class="form-control" name="ir_engineserialno" >
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Plate No.</label>
                <input type="text" class="form-control" name="ir_plateno" >
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>User ID</label>
                <input type="text" class="form-control" name="recipient" >
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Designation</label>
                <input type="text" class="form-control" name="ir_designation" >
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Office</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="cc_code" data-parsley-errors-container="#validate_selectcostcenter" data-parsley-required-message="<strong>Office is required.</strong>" required>
                  @if($isnew)
                    <option value="" selected="selected">--- Select Office ---</option>
                    @foreach($costcenter as $cc)
                    <option value="{{$cc->cc_code}}">{{$cc->cc_desc}}</option>
                    @endforeach
                  @else 
                    @foreach($costcenter as $cc)
                    @if($rechdr->cc_code == $cc->cc_code)
                    <option selected = "selected" value="{{$cc->cc_code}}">{{$cc->cc_desc}}</option>
                    @else
                    <option value="{{$cc->cc_code}}">{{$cc->cc_desc}}</option>
                    @endif
                    @endforeach
                  @endif
                </select>
                <span id="validate_selectcostcenter"></span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Date of A.R.E</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" name="ir_dateofare" class="form-control pull-right" id="datepicker" data-parsley-errors-container="#validate_invoicedt" data-parsley-required-message="<strong>ARE date is required.</strong>" required>
                </div>
                <span id="validate_invoicedt"></span>
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
                    <button type="button" class="btn btn-warning" onclick="EnterItem_Add('', '', '', '', '', '', '', 'TEXT-ITEM')"><i class="fa fa-plus"></i> Add Text Item</button>
                </div>
                <div class="col-sm-6">
                  <!-- <h5 class="box-title">Total amount:</h5>
                    &nbsp;<label><input type="text" name="txt_grandtotalamt" readonly=""></label> -->
                </div>
              </div>
              <!-- Modal -->
            
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="tbl_itemlist" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Line</th>
                  <th>ITEM Code</th>
                  <th>Job Order</th>
                  <th>Date</th>
                  <th>Pre-Post No</th>
                  <th>Post-Repair Date</th>
                  <th>Invoice/Delivery No</th>
                  <th>Invoice/Delivery Date</th>
                  <th>Name of Auto Supply/Supplier</th>
                  <th>Qty</th>
                  <th>Unit</th>
                  <th>Materials</th>
                  <th>Cost</th>
                  <th>Remarks</th>
                  <th>Option</th>
                </tr>
                </thead>
                <tbody>
                  @if(!$isnew)
                  @foreach($reclne as $rl)
                  <tr>  
                    <td>{{$rl->ln_num}}</td>
                    <td>{{$rl->item_code}}</td>
                    <td>{{$rl->ir_joborder}}</td>
                    <td>{{$rl->ir_date}}</td>
                    <td>{{$rl->ir_prepost}}</td>
                    <td>{{$rl->ir_postdate}}</td>
                    <td>{{$rl->ir_invoice}}</td>
                    <td>{{$rl->ir_delvdate}}</td>
                    <td>{{$rl->ir_supplier}}</td>
                    <td>{{$rl->recv_qty}}</td>
                    <td>{{$rl->unit}}</td>
                    <td>{{$rl->price}}</td>
                    <td>{{$rl->ir_material}}</td>
                    <td>{{$rl->notes}}</td>
                    <td><center><a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit({{$rl->ln_num}}, '{{$rl->item_code}}');"></i></a>&nbsp;<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete({{$rl->ln_num}}, '{{$rl->item_code}}');"></i></a></center>
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
                <a href="{{route('inventory.are')}}" class="btn btn-block btn-primary"><i class="fa fa-arrow-left"></i> Go Back</a>
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

                    <span class="AddMode EditMode">
                    <form id="add-form" data-parsley-validate novalidate>
                      <div class="box-body">
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Line No.</label>
                              <input type="text" class="form-control" name="txt_lineno" readonly="">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Item Code</label>
                              <input type="text" class="form-control" name="txt_itemcode" >
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Job Order</label>
                              <input type="text" class="form-control" name="txt_ir_joborder" >
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Date</label>
                              <input type="date" class="form-control" name="txt_ir_date">
                            </div>
                          </div>  
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Pre-Post No.</label>
                              <input type="text" class="form-control" name="txt_ir_prepost">
                            </div>
                          </div>  
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Post-Repair Date</label>
                              <input type="date" class="form-control" name="txt_ir_postdate">
                            </div>
                          </div> 
                        </div>
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Invoice/Delivery No.</label>
                              <input type="text" class="form-control" name="txt_ir_invoice">
                            </div>
                          </div>  
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Invoice/Delivery Date</label>
                              <input type="date" class="form-control" name="txt_ir_delvdate">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Name of Auto Supplier</label>
                              <input type="text" class="form-control" name="txt_ir_supplier">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Quantity</label>
                                <input id="txt_qty" type="number" class="form-control" name="txt_recv_qty" step="any" placeholder="0.00" data-parsley-errors-container="#validate_iqty" data-parsley-required-message="<strong>Quantity is required.</strong>" required>
                                <span class="validate_iqty"></span>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Unit Measurement</label>
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_unit_text" data-parsley-errors-container="#validate_iitemunit" data-parsley-required-message="<strong>Unit Measurement is required.</strong>" required>
                                  <option value="" selected="selected">--- Select Unit ---</option>
                                  @foreach($itemunit as $iu)
                                  <option value="{{$iu->unit_id}}">{{$iu->unit_shortcode}}</option>
                                  @endforeach
                                </select>
                                <span class="validate_iitemunit"></span>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Price</label>
                              <input type="text" class="form-control" name="txt_price">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Spare Parts</label>
                              <input type="text" class="form-control" name="txt_ir_material">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Remarks</label>
                              <input type="text" class="form-control" name="txt_notes">
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                    </span>
                    <span class="DeleteMode">
                      <center>
                          <h4 class="text-transform: uppercase;">Are you sure you want to delete this item?
                          </h4>
                      </center>
                    </span>
                    
                    {{-- TEXT-ITEM FORM --}}
                    <span class="AddModeText EditModeText">
                    <form id="add-formtext" data-parsley-validate novalidate>
                      <div class="box-body">
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Line No.</label>
                              <input type="text" class="form-control" name="txt_lineno_text" readonly="">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Item Code</label>
                              <input type="text" class="form-control" name="txt_itemcode_text" >
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Job Order</label>
                              <input type="text" class="form-control" name="txt_ir_joborder_text" >
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Date</label>
                              <input type="date" class="form-control" name="txt_ir_date_text">
                            </div>
                          </div>  
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Pre-Post No.</label>
                              <input type="text" class="form-control" name="txt_ir_prepost_text">
                            </div>
                          </div>  
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Post-Repair Date</label>
                              <input type="date" class="form-control" name="txt_ir_postdate_text">
                            </div>
                          </div> 
                        </div>
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Invoice/Delivery No.</label>
                              <input type="text" class="form-control" name="txt_ir_invoice_text">
                            </div>
                          </div>  
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Invoice/Delivery Date</label>
                              <input type="date" class="form-control" name="txt_ir_delvdate_text">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Name of Auto Supplier</label>
                              <input type="text" class="form-control" name="txt_ir_supplier_text">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Quantity</label>
                                <input id="txt_qty" type="number" class="form-control" name="txt_recv_qty_text" step="any" placeholder="0.00" data-parsley-errors-container="#validate_iqty" data-parsley-required-message="<strong>Quantity is required.</strong>" required>
                                <span class="validate_iqty"></span>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Unit Measurement</label>
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_unit_text" data-parsley-errors-container="#validate_iitemunit" data-parsley-required-message="<strong>Unit Measurement is required.</strong>" required>
                                  <option value="" selected="selected">--- Select Unit ---</option>
                                  @foreach($itemunit as $iu)
                                  <option value="{{$iu->unit_id}}">{{$iu->unit_shortcode}}</option>
                                  @endforeach
                                </select>
                                <span class="validate_iitemunit"></span>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Price</label>
                              <input type="text" class="form-control" name="txt_price_text">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Spare Parts</label>
                              <input type="text" class="form-control" name="txt_ir_material_text">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Remarks</label>
                              <input type="text" class="form-control" name="txt_notes_text">
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                    </span>
                    <span class="DeleteModeText">
                      <center>
                          <h4 class="text-transform: uppercase;">Are you sure you want to delete this text-item?
                          </h4>
                      </center>
                    </span>

                    </div>
                    <div class="modal-footer">
                      <span class="AddModeBtn">
                        <button type="button" class="btn btn-primary" onclick="set_tbl_itemlist('sa-item', 'item')">Save & add more</button>
                        <button type="button" class="btn btn-primary" onclick="set_tbl_itemlist('sc-item', 'item')">Save & close</button>
                      </span>

                      <span class="AddModeBtnText">
                        <button type="button" class="btn btn-primary" onclick="set_tbl_itemlist('sa-textitem', 'text-item')">Save & add more</button>
                        <button type="button" class="btn btn-primary" onclick="set_tbl_itemlist('sc-textitem', 'text-item')">Save & close</button>
                      </span>

                      <span class="EditModeBtn">
                        <button type="button" class="btn btn-primary" onclick="set_tbl_itemlist('sc-item', 'item')">Save & close</button>
                      </span>

                      <span class="EditModeBtnText">
                        <button type="button" class="btn btn-primary" onclick="set_tbl_itemlist('sc-textitem', 'text-item')">Save & close</button>
                      </span>

                      <span class="DeleteMode">
                        <button type="button" class="btn btn-primary" onclick="set_tbl_itemlist('sc-item', 'remove-item')">Delete</button>
                      </span>

                      <span class="DeleteModeText">
                        <button type="button" class="btn btn-primary" onclick="set_tbl_itemlist('sc-item', 'remove-item')">Delete</button>
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

      // hide table rpo column
      $(document).ready(function() {

      // get selected row
      $('#tbl_itemlist tbody').on( 'click', 'tr', function () {
                var table = $('#tbl_itemlist').DataTable();
                selectedRow = table.row( this ).index() ;

                console.log('rowindex: '+selectedRow);
            } );

      $('#tbl_itemlist').DataTable( {
        "columnDefs": [
            {
                "targets": [ 7 ], // hide unit code col
                "visible": false,
                "searchable": false
            }
        ]
      } );
      } );

      // if input qty change
      $('#txt_qty').keyup(function(event)
      {
        disp_amt_result();
      });

      // if cost price change
      $('#txt_cost').keyup(function(event)
      {
        disp_amt_result();
      });

      // if input qty text change
      $('#txt_qty_text').keyup(function(event)
      {
        disp_amt_result_text();
      });

      // if cost price text change
      $('#txt_cost_text').keyup(function(event)
      {
        disp_amt_result_text();
      });


      function EnterItem_Add(code, ir_joborder, ir_date, ir_prepost, ir_postdate, ir_invoice, ir_delvdate, ir_supplier, recv_qty, unit, price, ir_material, notes, type)
      {
        clear();

        var line = ($('#tbl_itemlist').DataTable().rows().count()) + 1;

        if(type == 'ITEM')
        {
          $('#ENTER_ITEM').text('Add');
          $('.AddMode').show();
          $('.AddModeBtn').show();
          $('.EditMode').show();
          $('.EditModeBtn').hide();
          $('.DeleteMode').hide();

          $('.AddModeText').hide();
          $('.AddModeBtnText').hide();
          $('.EditModeText').hide();
          $('.EditModeBtnText').hide();
          $('.DeleteModeText').hide();

          $('input[name="txt_lineno"]').val(line);
          $('input[name="txt_itemcode"]').val(code);
          $('input[name="txt_ir_joborder"]').val(ir_joborder);
          $('input[name="txt_ir_date"]').val(ir_date);
          $('input[name="txt_ir_prepost"]').val(ir_prepost);
          $('input[name="txt_ir_postdate"]').val(ir_postdate);
          $('input[name="txt_ir_invoice"]').val(ir_invoice);
          $('input[name="txt_ir_delvdate"]').val(ir_delvdate);
          $('input[name="txt_ir_supplier"]').val(ir_supplier);
          $('input[name="txt_recv_qty"]').val(recv_qty);
          $('select[name="select_unit"]').val(unit).trigger('change');
          $('input[name="txt_price"]').val(price);
          $('input[name="txt_ir_material"]').val(ir_material);
          $('input[name="txt_notes"]').val(notes);          
        }
        else // TEXT ITEM
        {
          $('#ENTER_ITEM').text('Add Text');
          $('.AddModeText').show();
          $('.AddModeBtnText').show();
          $('.EditModeText').show();
          $('.EditModeBtnText').hide();
          $('.DeleteModeText').hide();

          $('.AddMode').hide();
          $('.AddModeBtn').hide();
          $('.EditMode').hide();
          $('.EditModeBtn').hide();
          $('.DeleteMode').hide();

          $('input[name="txt_lineno_text"]').val(line);
          $('input[name="txt_itemcode_text"]').val('TEXT-ITEM');

          $('#enteritem-modal').modal('toggle');
        }
      }

      function EnterItem_Edit(line, type)
      {
        var table = $('#tbl_itemlist').DataTable();
        var row = line - 1;
        var data = table.row(row).data();

        if(type == 'TEXT-ITEM')
        {
          

          $('#ENTER_ITEM').text('Edit Text');
          $('.AddMode').hide();
          $('.AddModeBtn').hide();
          $('.EditMode').hide();
          $('.EditModeBtn').hide();
          $('.DeleteMode').hide();

          $('.AddModeText').show();
          $('.AddModeBtnText').hide();
          $('.EditModeText').show();
          $('.EditModeBtnText').show();
          $('.DeleteModeText').hide();
          
          $('input[name="txt_lineno_text"]').val(data[0]);
          $('input[name="txt_itemcode_text"]').val(data[1]);
          $('input[name="txt_ir_joborder_text"]').val(data[2]);
          $('input[name="txt_ir_date_text"]').val(data[3]);
          $('input[name="txt_ir_prepost_text"]').val(data[4]);
          $('input[name="txt_ir_postdate_text"]').val(data[5]);
          $('input[name="txt_ir_invoice_text"]').val(data[6]);
          $('input[name="txt_ir_delvdate_text"]').val(data[7]);
          $('input[name="txt_ir_supplier_text"]').val(data[8]);
          $('input[name="txt_recv_qty_text"]').val(data[9]);
          $('select[name="select_unit_text_text"]').val(data[10]).trigger('change');
          $('input[name="txt_price_text"]').val(data[11]);
          $('input[name="txt_ir_material_text"]').val(data[12]);
          $('input[name="txt_notes_text"]').val(data[13]); 

          $('#enteritem-modal').modal('toggle');
        }
        else
        {
          $('#ENTER_ITEM').text('Edit');
          $('.AddModeText').hide();
          $('.AddModeBtnText').hide();
          $('.EditModeText').hide();
          $('.EditModeBtnText').hide();
          $('.DeleteModeText').hide();

          $('.AddMode').show();
          $('.AddModeBtn').hide();
          $('.EditMode').show();
          $('.EditModeBtn').show();
          $('.DeleteMode').hide();
          
          $('input[name="txt_lineno_text"]').val(data[0]);
          $('input[name="txt_itemcode_text"]').val(data[1]);
          $('input[name="txt_ir_joborder_text"]').val(data[2]);
          $('input[name="txt_ir_date_text"]').val(data[3]);
          $('input[name="txt_ir_prepost_text"]').val(data[4]);
          $('input[name="txt_ir_postdate_text"]').val(data[5]);
          $('input[name="txt_ir_invoice_text"]').val(data[6]);
          $('input[name="txt_ir_delvdate_text"]').val(data[7]);
          $('input[name="txt_ir_supplier_text"]').val(data[8]);
          $('input[name="txt_recv_qty_text"]').val(data[9]);
          $('select[name="select_unit_text_text"]').val(data[10]).trigger('change');
          $('input[name="txt_price_text"]').val(data[11]);
          $('input[name="txt_ir_material_text"]').val(data[12]);
          $('input[name="txt_notes_text"]').val(data[13]); 

          $('#enteritem-modal').modal('toggle');
        }  
      }

      function EnterItem_Delete(line, type)
      {
        if(type == 'TEXT-ITEM')
        {
          $('#ENTER_ITEM').text('Delete Text');
          $('.AddMode').hide();
          $('.AddModeBtn').hide();
          $('.EditMode').hide();
          $('.EditModeBtn').hide();

          $('.AddModeText').hide();
          $('.AddModeBtnText').hide();
          $('.EditModeText').hide();
          $('.EditModeBtnText').hide();

          $('.DeleteMode').hide();

          $('.DeleteModeText').show();

          $('#enteritem-modal').modal('toggle');
        }
        else
        {
          $('#ENTER_ITEM').text('Delete');
          $('.AddMode').hide();
          $('.AddModeBtn').hide();
          $('.EditMode').hide();
          $('.EditModeBtn').hide();

          $('.AddModeText').hide();
          $('.AddModeBtnText').hide();
          $('.EditModeText').hide();
          $('.EditModeBtnText').hide();
          
          $('.DeleteModeText').hide();

          $('.DeleteMode').show();

          $('#enteritem-modal').modal('toggle');
        }
      }

      function set_tbl_itemlist(type, typeitem)
      {
        var table = $('#tbl_itemlist').DataTable();

        // if form is item
        if(typeitem == 'item')
        {
          if($('#add-form').parsley().validate()) // check required fields of the Add Item Form
          {
            //var table = $('#tbl_itemlist').DataTable();

            var line = $('input[name="txt_lineno"]').val();
            var item_code = $('input[name="txt_itemcode"]').val();
            var ir_joborder = $('input[name="txt_ir_joborder"]').val();
            var ir_date = $('input[name="txt_ir_date"]').val();
            var ir_prepost = $('input[name="txt_ir_prepost"]').val();
            var ir_postdate = $('input[name="txt_ir_postdate"]').val();
            var ir_invoice = $('input[name="txt_ir_invoice"]').val();
            var ir_delvdate = $('input[name="txt_ir_delvdate"]').val();
            var ir_supplier = $('input[name="txt_ir_supplier"]').val();
            var recv_qty = $('input[name="txt_recv_qty"]').val();
            var unit_code = $('select[name="select_unit"]').select2('data')[0].id;
            var unit_desc = $('select[name="select_unit"]').select2('data')[0].text;
            var price = $('input[name="txt_price"]').val();
            var ir_material = $('input[name="txt_ir_material"]').val();
            var notes = $('input[name="txt_notes"]').val();
            var buttons = '<center>' +
              '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit( \''+line+'\', \''+item_code+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete(\''+line+'\');"></i></a>' +
            '</center>';

            if($('#ENTER_ITEM').text() == 'Add')
            { 
              table.row.add([line, item_code, ir_joborder, ir_date, ir_prepost, ir_postdate, ir_invoice, ir_delvdate, ir_supplier, recv_qty, unit_desc,  price, ir_material, notes, buttons]).draw();
            }
            else if($('#ENTER_ITEM').text() == 'Edit')
            {
              table.row(selectedRow).data([line, item_code, ir_joborder, ir_date, ir_prepost, ir_postdate, ir_invoice, ir_delvdate, ir_supplier, recv_qty, unit_desc,  price, ir_material, notes, buttons]).draw();
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
            
            clear();

            if(type == 'sc-item') // save and close item
            {
                $('#enteritem-modal').modal('toggle');
            }
            else if(type == 'sa-item') // save and add more item
            {
                $('#enteritem-modal').modal('toggle');
                $('#itemsearch-modal').modal('show');
            }
          }
        }
        // if form is text-item
        else if(typeitem == 'text-item')
        {
          if($('#add-formtext').parsley().validate()) // check required fields of the Add Text Item Form
          {
            //var table = $('#tbl_itemlist').DataTable();

            var line = $('input[name="txt_lineno_text"]').val();
            var item_code = $('input[name="txt_itemcode_text"]').val();
            var ir_joborder = $('input[name="txt_ir_joborder_text"]').val();
            var ir_date = $('input[name="txt_ir_date_text"]').val();
            var ir_prepost = $('input[name="txt_ir_prepost_text"]').val();
            var ir_postdate = $('input[name="txt_ir_postdate_text"]').val();
            var ir_invoice = $('input[name="txt_ir_invoice_text"]').val();
            var ir_delvdate = $('input[name="txt_ir_delvdate_text"]').val();
            var ir_supplier = $('input[name="txt_ir_supplier_text"]').val();
            var recv_qty = $('input[name="txt_recv_qty_text"]').val();
            var unit_code = $('select[name="select_unit_text"]').select2('data')[0].id;
            var unit_desc = $('select[name="select_unit_text"]').select2('data')[0].text;
            var price = $('input[name="txt_price_text"]').val();
            var ir_material = $('input[name="txt_ir_material_text"]').val();
            var notes = $('input[name="txt_notes_text"]').val();
            var buttons = '<center>' +
              '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit( \''+line+'\', \''+item_code+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete(\''+line+'\');"></i></a>' +
            '</center>';

            if($('#ENTER_ITEM').text() == 'Add Text')
            { 
              var test = [line, ir_joborder, ir_date, ir_prepost, ir_postdate, ir_invoice, ir_delvdate, ir_supplier, recv_qty, unit_desc, price, ir_material, notes, buttons];

              console.log(test);
              table.row.add([line, item_code, ir_joborder, ir_date, ir_prepost, ir_postdate, ir_invoice, ir_delvdate, ir_supplier, recv_qty, unit_desc,  price, ir_material, notes, buttons]).draw();
            }
            else if($('#ENTER_ITEM').text() == 'Edit Text')
            {
              table.row(selectedRow).data([line, item_code, ir_joborder, ir_date, ir_prepost, ir_postdate, ir_invoice, ir_delvdate, ir_supplier, recv_qty, unit_desc,  price, ir_material, notes, buttons]).draw();
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
            
            clear();

            if(type == 'sc-textitem') // save and close text item
            {
                $('#enteritem-modal').modal('toggle');
            }
            else if(type == 'sa-textitem') // save and add more text item
            {
                let line = ($('#tbl_itemlist').DataTable().rows().count()) + 1;
                $('input[name="txt_lineno_text"]').val(line);
                $('input[name="txt_itemcode_text"]').val('TEXT-ITEM');
            }
          }
        }
        else if(typeitem == 'remove-item')
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
          $('#enteritem-modal').modal('toggle');
        }
      }

      function clear()
      {
        $('input[name="txt_lineno"]').val('');
        $('input[name="txt_itemcode"]').val('');
        $('input[name="txt_ir_joborder"]').val('');
        $('input[name="txt_ir_date"]').val('');
        $('input[name="txt_ir_prepost"]').val('');
        $('input[name="txt_ir_postdate"]').val('');
        $('input[name="txt_ir_invoice"]').val('');
        $('input[name="txt_ir_delvdate"]').val('');
        $('input[name="txt_ir_supplier"]').val('');
        $('input[name="txt_recv_qty"]').val('0.00');
        $('select[name="select_unit"]').val('').trigger('change');
        $('input[name="txt_price"]').val('0.00');
        $('input[name="txt_ir_material"]').val('');
        $('input[name="txt_notes"]').val('');

        $('input[name="txt_lineno_text"]').val('');
        $('input[name="txt_itemcode_text"]').val('');
        $('input[name="txt_ir_joborder_text"]').val('');
        $('input[name="txt_ir_date_text"]').val('');
        $('input[name="txt_ir_prepost_text"]').val('');
        $('input[name="txt_ir_postdat_texte"]').val('');
        $('input[name="txt_ir_invoice_text"]').val('');
        $('input[name="txt_ir_delvdate_text"]').val('');
        $('input[name="txt_ir_supplier_text"]').val('');
        $('input[name="txt_recv_qty_text"]').val('0.00');
        $('select[name="select_unit_text"]').val('').trigger('change');
        $('input[name="txt_price_text"]').val('0.00');
        $('input[name="txt_ir_material_text"]').val('');
        $('input[name="txt_notes_text"]').val('');

      } 

      function disp_amt_result()
      {
        var total_costamt = 0.00, qty = 0.00, costprice = 0.00, ln_amt = 0.00;

        qty = $('input[name="txt_qty"]').val();
        costprice = $('input[name="txt_cost"]').val();

        total_costamt = qty * costprice;

        ln_amt = parseFloat(total_costamt).toFixed(2);

        $('input[name="txt_lineamt"]').val(ln_amt);
      }

      function disp_amt_result_text()
      {
        var total_costamt = 0.00, qty = 0.00, costprice = 0.00, ln_amt = 0.00;

        qty = $('input[name="txt_qty_text"]').val();
        costprice = $('input[name="txt_cost_text"]').val();

        total_costamt = qty * costprice;

        ln_amt = parseFloat(total_costamt).toFixed(2);

        $('input[name="txt_lineamt_text"]').val(ln_amt);
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
                          ir_model: $('input[name="ir_model"]').val(),
                          ir_unitserialno: $('input[name="ir_unitserialno"]').val(),
                          ir_enginerserialno: $('input[name="ir_enginerserialno"]').val(),
                          ir_plateno: $('input[name="ir_plateno"]').val(),
                          recipient: $('input[name="recipient"]').val(),
                          ir_designation: $('input[name="ir_designation"]').val(),
                          cc_code: $('select[name="cc_code"]').select2('data')[0].id,
                          ir_dateofare: $('input[name="ir_dateofare"]').val(),
                       };
    
               $.ajax({
                      url: '{{route('inventory.itemrepair_entry')}}',
                      method: 'POST',
                      data: data,
                      success : function(flag)
                               {
                                  if(flag == 'true')
                                  {
                                    location.href= "{{route('inventory.itemrepair')}}";
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


      function EditSave()
      {
        var tbl_itemlist = $('#tbl_itemlist').DataTable();

        if($('#HeaderForm').parsley().validate()) // check required fields of the header
        {
          if(tbl_itemlist.data().count() > 0) // check table items
          {
             var tbl_itemdata = tbl_itemlist.data().toArray(); // tbl_itemlist data

             var rec_num = $('input[name="txt_code"]').val();

             var data = { 
                      _token : $('meta[name="csrf-token"]').attr('content'),
                      tbl_itemlist: tbl_itemdata,
                      ir_model: $('input[name="ir_model"]').val(),
                      ir_unitserialno: $('input[name="ir_unitserialno"]').val(),
                      ir_enginerserialno: $('input[name="ir_enginerserialno"]').val(),
                      ir_plateno: $('input[name="ir_plateno"]').val(),
                      recipient: $('input[name="recipient"]').val(),
                      ir_designation: $('input[name="ir_designation"]').val(),
                      cc_code: $('select[name="cc_code"]').select2('data')[0].id,
                      ir_dateofare: $('input[name="ir_dateofare"]').val(),
                   };

             $.ajax({
                  url: '{{asset('inventory/itemrepair/itemrepair_edit')}}/'+rec_num,
                  method: 'POST',
                  data: data,
                  success : function(flag)
                           {
                              if(flag == 'true')
                              {
                                console.log(flag);
                                location.href= "{{route('inventory.itemrepair')}}";
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

    </script>

    </section>
    <!-- /.content -->
  
@endsection