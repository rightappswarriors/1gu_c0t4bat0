@extends('_main')
@if($isnew)
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Stock In','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Create','icon'=>'none','st'=>true],
    ];
    $_ch = "Stock In"; // Module Name
@endphp
@else
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Stock In','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Edit','icon'=>'none','st'=>true],
    ];
    $_ch = "Stock In"; // Module Name
@endphp
@endif
@section('content')
		<!-- Content Header (Page header) -->
		@include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Stock In Info</h3>

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
                <label>Purchase Order No</label>
                @if($isnew)
                <input type="text" class="form-control" name="txt_purccode" maxlength="9" data-parsley-errors-container="#validate_code" data-parsley-required-message="<strong>Purchase No is required.</strong>" required>
                @else
                <input type="text" class="form-control" name="txt_purccode" maxlength="9" value="{{$rechdr->purc_ord}}" data-parsley-errors-container="#validate_code" data-parsley-required-message="<strong>Purchase No is required.</strong>" required>
                <input type="hidden" class="form-control" name="txt_code" value="{{$rechdr->rec_num}}">
                @endif
                <span id="validate_code"></span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Purchase Order Date <span style="color:red"><strong>*</strong></span></label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  @if($isnew)
                  <input type="date" name="dtp_invoicedt" class="form-control pull-right" id="datepicker" data-parsley-errors-container="#validate_invoicedt" data-parsley-required-message="<strong>Purchase date is required.</strong>" required>
                  @else
                  <input type="date" class="form-control pull-right" id="datepicker" name="dtp_invoicedt" value="{{$rechdr->trnx_date}}" data-parsley-errors-container="#validate_invoicedt" data-parsley-required-message="<strong>Purchase date is required.</strong>" required>
                  @endif
                </div>
                <span id="validate_invoicedt"></span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Stock Location <span style="color:red"><strong>*</strong></span></label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_stocklocation" data-parsley-errors-container="#validate_stocklocation" data-parsley-required-message="<strong>Stock Location is required.</strong>" required>
                  @if($isnew)
                    <option value="" selected="selected">--- Select Stock Location ---</option>
                    @foreach($stock_loc as $st)
                    <option value="{{$st->whs_code}}">{{$st->whs_desc}}</option>
                    @endforeach
                  @else
                    @foreach($stock_loc as $st)
                    @if($rechdr->whs_code == $st->whs_code)
                    <option selected="selected" value="{{$st->whs_code}}">{{$st->whs_desc}}</option>
                    @else
                    <option value="{{$st->whs_code}}">{{$st->whs_desc}}</option>
                    @endif
                    @endforeach
                  @endif
                </select>
                 <span id="validate_stocklocation"></span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Branch <span style="color:red"><strong>*</strong></span></label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true", name="select_branch" data-parsley-errors-container="#validate_branch" data-parsley-required-message="<strong>Branch is required.</strong>" required>
                  @if($isnew)
                    <option value="" selected="selected">--- Select Branch ---</option>
                    @foreach($branch as $b)
                    <option value="{{$b->code}}">{{$b->name}}</option>
                    @endforeach
                  @else
                    @foreach($branch as $b)
                    @if($rechdr->branch == $b->code)
                    <option selected = "selected" value="{{$b->code}}">{{$b->name}}</option>
                    @else
                    <option value="{{$b->code}}">{{$b->name}}</option>
                    @endif
                    @endforeach
                  @endif
                </select>        
                <span id="validate_branch"></span>      
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Supplier Name <span style="color:red"><strong>*</strong></span></label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_supplier" data-parsley-errors-container="#validate_supplier" data-parsley-required-message="<strong>Supplier is required.</strong>" required>
                  @if($isnew)
                    <option value="" selected="selected">--- Select Supplier ---</option>
                    @foreach($supplier as $s)
                    <option value="{{$s->c_code}}">{{$s->c_name}}</option>
                    @endforeach
                  @else
                    @foreach($supplier as $s)
                    @if($rechdr->supl_code == $s->c_code)
                    <option selected="selected" value="{{$s->c_code}}">{{$s->c_name}}</option>
                    @else
                    <option value="{{$s->c_code}}">{{$s->c_name}}</option>
                    @endif
                    @endforeach
                  @endif
                </select>
                <span id="validate_supplier"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Reference <span style="color:red"><strong>*</strong></span></label>
                @if($isnew)
                  <input type="text" class="form-control" name="txt_reference" data-parsley-errors-container="#validate_reference" data-parsley-required-message="<strong>Reference is required.</strong>" required>
                @else
                  <input type="text" class="form-control" name="txt_reference" value="{{$rechdr->_reference}}" data-parsley-errors-container="#validate_reference" data-parsley-required-message="<strong>Reference is required.</strong>" required>
                @endif
                <span id="validate_reference"></span>
              </div>
            </div>
          </div>
          <!-- /.row -->
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemsearch-modal"><i class="fa fa-plus"></i> Add item</button>
                </div>
                <div class="col-sm-6">
                  <h5 class="box-title">Total amount:</h5>
                    &nbsp;<label>@if($isnew)
                                   <input type="text" name="txt_grandtotalamt" readonly="">
                                @else
                                   <input type="text" name="txt_grandtotalamt" value="{{$grandtotal->grandtotal}}" readonly="">
                                @endif
                          </label>
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
                              <th>Part No</th>
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
                              @foreach($disp_items as $di)
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
                  <th>Line</th>
                  <th>Part No</th>
                  <th>Item Code</th>
                  <th>Description</th>
                  <th>Qty</th>
                  <th>Unit Code</th>
                  <th>Unit Desc</th>
                  <th>Cost Price</th>
                  <th>Disc Amt</th>
                  <th>Line Amt</th>
                  <th>Net Price</th>
                  <th>Line Vat</th>
                  <th>Vat</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  @if(!$isnew)
                  @foreach($reclne as $rl)
                     <tr>  
                       <td>{{$rl->ln_num}}</td>
                       <td>{{$rl->part_no}}</td>
                       <td>{{$rl->item_code}}</td>
                       <td>{{$rl->item_desc}}</td>
                       <td>{{$rl->qty}}</td>
                       <td>{{$rl->unit_code}}</td>
                       <td>{{$rl->unit_desc}}</td>
                       <td>{{$rl->price}}</td>
                       <td>{{$rl->discount}}</td>
                       <td>{{$rl->ln_amnt}}</td>
                       <td>{{$rl->net_amnt}}</td>
                       <td>{{$rl->ln_vat}}</td>
                       <td>{{$rl->ln_vatamt}}</td>
                       <td><center><a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit({{$rl->ln_num}});"></i></a>&nbsp;<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete({{$rl->ln_num}});"></i></a></center>
                       </td>
                     </tr>  
                  @endforeach
                  @endif
                </tbody>
                <tfoot>
                <tr>
                  <th>Line</th>
                  <th>Part No</th>
                  <th>Item Code</th>
                  <th>Description</th>
                  <th>Qty</th>
                  <th>Unit Code</th>
                  <th>Unit Desc</th>
                  <th>Cost Price</th>
                  <th>Disc Amt</th>
                  <th>Line Amt</th>
                  <th>Net Price</th>
                  <th>Line Vat</th>
                  <th>Vat</th>
                  <th>Actions</th>
                </tr>
                </tfoot>
              </table>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group" style="display: flex;">
                <a href="{{route('inventory.stockin')}}" class="btn btn-block btn-primary"><i class="fa fa-arrow-left"></i> Go Back</a>
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
                              <label>Line No.</label>
                              <input type="text" class="form-control" name="txt_lineno" readonly="">
                            </div>
                          </div> 
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Item Code</label>
                              <input type="text" class="form-control" name="txt_itemcode" readonly="">
                              <span class="validate_iitem_code"></span>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Part No.</label>
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
                          <div class="col-sm-9">
                            <div class="form-group">
                              <label>VAT Type</label> <span class="validate_ivattype"></span>
                              <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_vat" data-parsley-errors-container="#validate_ivattype" data-parsley-required-message="<strong>VAT Type is required.</strong>" {{-- required --}}>
                                  <option value="" selected="selected">--- Select VAT ---</option>
                                  @foreach($vat as $v)
                                  <option value="{{$v->vat_code}}">{{$v->vat_desc}}</option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Quantity</label>
                                <input id="txt_qty" type="number" class="form-control" name="txt_qty" step="any" placeholder="0.00" data-parsley-errors-container="#validate_iqty" data-parsley-required-message="<strong>Quantity is required.</strong>" {{-- required --}}>
                                <span class="validate_iqty"></span>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Unit Measurement</label>
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_unit" data-parsley-errors-container="#validate_iitemunit" data-parsley-required-message="<strong>Unit Measurement is required.</strong>" {{-- required --}}>
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
                              <label>Cost Price</label>
                               <input id="txt_cost" type="number" class="form-control" name="txt_cost" step="any" placeholder="0.00" data-parsley-errors-container="#validate_icostprice" data-parsley-required-message="<strong>Cost Price is required.</strong>" {{-- required --}}>
                               <span class="validate_icostprice"></span>
                            </div>
                          </div>
                        </div>
                        <div class="row">                          
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Discount Amount</label>
                               <input id="txt_disc" type="number" class="form-control" name="txt_disc" step="any" placeholder="0.00">
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Line Amount</label>
                               <input type="text" class="form-control" name="txt_lineamt" placeholder="0.00" readonly="">
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>VAT</label>
                               <input type="text" class="form-control" name="txt_vatamt" placeholder="0.00" readonly="">
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Net Price</label>
                               <input type="text" class="form-control" name="txt_netprice" placeholder="0.00" readonly="">
                            </div>
                          </div>
                        </div>
                      </div>
                    </span>
                    <span class="DeleteMode">
                      <center>
                          <h4 class="text-transform: uppercase;">Are you sure you want to remove this item?
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
                "targets": [ 5 ], // hide unit code col
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
      
      // if select vat qty change
      $('select[name="select_vat"]').change(function(event)
      {
        disp_amt_result();
      });
      
      // input disc change
      $('#txt_disc').keyup(function(event)
      {
        disp_amt_result();
      });

      // if cost price change
      $('#txt_cost').keyup(function(event)
      {
        disp_amt_result();
      });


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
                             $('input[name="txt_partno"]').val(data[0]); //edited
                             $('input[name="txt_itemdesc"]').val(data[1]);
                             $('input[name="txt_cost"]').val(data[3]);
                             $('select[name="select_unit"]').val(data[2]).trigger('change');
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
          
          $('input[name="txt_lineno"]').val(data[0]);
          $('input[name="txt_partno"]').val(data[1]);
          $('input[name="txt_itemcode"]').val(data[2]);
          $('input[name="txt_itemdesc"]').val(data[3]);
          $('input[name="txt_qty"]').val(data[4]);
          $('select[name="select_unit"]').val(data[5]).trigger('change');
          $('input[name="txt_cost"]').val(data[7]);
          $('input[name="txt_disc"]').val(data[8]);
          $('input[name="txt_lineamt"]').val(data[9]);
          $('input[name="txt_netprice"]').val(data[10]);
          $('select[name="select_vat"]').val(data[11]).trigger('change');
          $('input[name="txt_vatamt"]').val(data[12]);

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
        var unit_code = $('select[name="select_unit"]').select2('data')[0].id;
        var unit_desc = $('select[name="select_unit"]').select2('data')[0].text;
        var cost_price = $('input[name="txt_cost"]').val();
        var disc_amnt = $('input[name="txt_disc"]').val();
        var line_amnt = $('input[name="txt_lineamt"]').val();
        var net_price = $('input[name="txt_netprice"]').val();
        var line_vat = $('select[name="select_vat"]').select2('data')[0].id;
        var vat_amt = $('input[name="txt_vatamt"]').val();
        var buttons = '<center>' +
              '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit( \''+line+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete(\''+line+'\');"></i></a>' +
            '</center>';

        if($('#ENTER_ITEM').text() == 'Add')
        {

        table.row.add([line, part_no, item_code, item_desc, qty, unit_code, unit_desc, cost_price, disc_amnt, line_amnt, net_price, line_vat, vat_amt, buttons]).draw();

        }
        else if($('#ENTER_ITEM').text() == 'Edit')
        {
          table.row(selectedRow).data([line, part_no, item_code, item_desc, qty, unit_code, unit_desc, cost_price, disc_amnt, line_amnt, net_price, line_vat, vat_amt, buttons]).draw();
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

      function disp_amt_result()
      {
        var total_costamt = 0.00, net_amt = 0.00, qty = 0.00, costprice = 0.00, disc_amt = 0.00, ln_amt = 0.00;

        qty = $('input[name="txt_qty"]').val();
        costprice = $('input[name="txt_cost"]').val();
        
        if($('input[name="txt_disc"]').val() != null)
        {
          disc_amt = $('input[name="txt_disc"]').val();
        }

        total_costamt = qty * costprice;

        ln_amt = parseFloat(total_costamt - disc_amt).toFixed(2);

        $('input[name="txt_lineamt"]').val(ln_amt);
        $('input[name="txt_disc"]').val(disc_amt);

        disp_vat(ln_amt);
      }

      function disp_vat(total_amt)
      {
        var vat_amt = 0.00, net_amt = 0.00;
        var tax_type = $('select[name="select_vat"]').select2('data')[0].id;

        if(tax_type == 'I')
        {
            net_amt = parseFloat(total_amt / 1.12).toFixed(2);
            vat_amt = parseFloat(total_amt - net_amt).toFixed(2);

            $('input[name="txt_netprice"]').val(net_amt);
            $('input[name="txt_vatamt"]').val(vat_amt);
        }
        else if(tax_type == 'E')
        {
            net_amt = parseFloat(total_amt).toFixed(2);
            total_amt = parseFloat(total_amt * 1.12).toFixed(2);
            vat_amt = parseFloat(total_amt - net_amt).toFixed(2);

            $('input[name="txt_lineamt"]').val(total_amt);
            $('input[name="txt_netprice"]').val(net_amt);
            $('input[name="txt_vatamt"]').val(vat_amt);
        }
        else
        {
            net_amt = parseFloat(total_amt).toFixed(2);
            vat_amt = parseFloat(vat_amt).toFixed(2);

            $('input[name="txt_netprice"]').val(net_amt);
            $('input[name="txt_vatamt"]').val(vat_amt);
        }
      }

      function clear()
      {
        $('input[name="txt_lineno"]').val('');
        $('input[name="txt_itemcode"]').val('');
        $('input[name="txt_partno"]').val('');
        $('input[name="txt_itemdesc"]').val('');
        $('select[name="select_vat"]').val('').trigger('change');
        $('input[name="txt_qty"]').val('0');
        $('select[name="select_unit"]').val('').trigger('change');
        $('input[name="txt_cost"]').val('0.00');
        $('input[name="txt_disc"]').val('0.00');
        $('input[name="txt_lineamt"]').val('0.00');
        $('input[name="txt_vatamt"]').val('0.00');
        $('input[name="txt_netprice"]').val('0.00');

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
                          purc_code: $('input[name="txt_purccode"]').val(),
                          invoicedt: $('input[name="dtp_invoicedt"]').val(),
                          stock_loc: $('select[name="select_stocklocation"]').select2('data')[0].id,
                          branch: $('select[name="select_branch"]').select2('data')[0].id,
                          supl_code: $('select[name="select_supplier"]').select2('data')[0].id,
                          supl_name: $('select[name="select_supplier"]').select2('data')[0].text,
                          reference: $('input[name="txt_reference"]').val(),
                       };

            $.ajax({
                   url: '{{route('inventory.stockin_add')}}',
                   method: 'POST',
                   data: data,
                   success : function(flag)
                            {
                               if(flag == 'true')
                               {
                                 console.log(flag);
                                 location.href= "{{route('inventory.stockin')}}";
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
                            purc_code: $('input[name="txt_purccode"]').val(),
                            invoicedt: $('input[name="dtp_invoicedt"]').val(),
                            stock_loc: $('select[name="select_stocklocation"]').select2('data')[0].id,
                            branch: $('select[name="select_branch"]').select2('data')[0].id,
                            supl_code: $('select[name="select_supplier"]').select2('data')[0].id,
                            supl_name: $('select[name="select_supplier"]').select2('data')[0].text,
                            reference: $('input[name="txt_reference"]').val(),
                         };

              $.ajax({
                     url: '{{asset('inventory/stockin/stockin_edit')}}/'+rec_num,
                     method: 'POST',
                     data: data,
                     success : function(flag)
                              {
                                 if(flag == 'true')
                                 {
                                   console.log(flag);
                                   location.href= "{{route('inventory.stockin')}}";
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