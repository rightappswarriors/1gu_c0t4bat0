@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Stock Release','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Create','icon'=>'none','st'=>true],
    ];
    $_ch = "Stock Release"; // Module Name
@endphp
@section('content')
		<!-- Content Header (Page header) -->
		@include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Stock Release Info</h3>

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
                  <input type="text" class="form-control" name="txt_code" readonly="">
                @else
                  <input type="text" class="form-control" name="txt_code" value="{{$rechdr->rec_num}}" readonly="">
                @endif
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Purchase Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  @if($isnew)
                    <input type="date" class="form-control pull-right" id="datepicker" name="dtp_invoicedt" data-parsley-errors-container="#validate_invoicedt" data-parsley-required-message="<strong>Invoice date is required.</strong>" required>
                  @else
                    <input type="date" class="form-control pull-right" id="datepicker" name="dtp_invoicedt" value="{{$rechdr->trnx_date}}" readonly="" data-parsley-errors-container="#validate_invoicedt" data-parsley-required-message="<strong>Invoice date is required.</strong>" required>
                  @endif
                </div>
                <span id="validate_invoicedt"></span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Office</label>
                  @if($isnew)
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_costcenter" data-parsley-errors-container="#validate_office" data-parsley-required-message="<strong>Office is required.</strong>" required>
                       <option value="" selected="selected">--- Select Office ---</option>
                       @foreach($costcenter as $cc)
                         <option value="{{$cc->cc_code}}">{{$cc->cc_desc}}</option>
                       @endforeach
                   </select>
                  @else
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_costcenter" required="" disabled="">
                       <option value="" selected="selected">--- Select Office ---</option>
                       @foreach($costcenter as $cc)
                       @if($rechdr->cc_code == $cc->cc_code)
                       <option selected = "selected" value="{{$cc->cc_code}}">{{$cc->cc_desc}}</option>
                       @else
                       <option value="{{$cc->cc_code}}">{{$cc->cc_desc}}</option>
                       @endif
                       @endforeach
                     </select>
                  @endif
                  <span id="validate_office"></span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Stock Location From</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_stocklocation" data-parsley-errors-container="#validate_stockloc" data-parsley-required-message="<strong>Stock Location From is required.</strong>" required>
                  @if($isnew)
                    <option value="" selected="selected">-- Select Stock Location From --</option>
                    @foreach($stock_loc as $st)
                    <option value="{{$st->whs_code}}">{{$st->whs_desc}}</option>
                    @endforeach
                  @else
                    <option value="" selected="selected">-- Select Stock Location From --</option>
                    @foreach($stock_loc as $st)
                    <option value="{{$st->whs_code}}">{{$st->whs_desc}}</option>
                    @endforeach
                  @endif
                </select>
                <span id="validate_stockloc"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Reference</label>
                @if($isnew)
                  <input type="text" class="form-control" name="txt_reference" data-parsley-errors-container="#validate_reference" data-parsley-required-message="<strong>Reference is required.</strong>" required>
                @else
                  <input type="text" class="form-control" name="txt_reference" value="{{$rechdr->_reference}}" readonly="">
                @endif
                <span id="validate_reference"></span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>RIS NO</label>
                @if($isnew)
                  <input type="text" class="form-control" name="txt_ris_no">
                @else
                  <input type="text" class="form-control" name="txt_ris_no" value="{{$rechdr->ris_no}}" readonly="">
                @endif  
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>SAI NO</label>
                @if($isnew)
                  <input type="text" class="form-control" name="txt_sai_no">
                @else
                  <input type="text" class="form-control" name="txt_sai_no" value="{{$rechdr->sai_no}}" readonly="">
                @endif
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Personnel to Receive</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_personnel" data-parsley-errors-container="#validate_personnel" data-parsley-required-message="<strong>Personnel to receive is required.</strong>" required>
                  @if($isnew)
                    <option value="" selected="selected">-- Select Personnel to Receive --</option>
                    @foreach($x08 as $x8)
                    <option value="{{$x8->uid}}">{{$x8->opr_name}}</option>
                    @endforeach
                  @else
                    <option value="">-- Select Personnel to Receive --</option>
                    @foreach($x08 as $x8)
                      @if($rechdr->personnel == $x8->uid)
                        <option selected="selected" value="{{$x8->uid}}">{{$x8->opr_name}}</option>
                      @else  
                        <option value="{{$x8->uid}}">{{$x8->opr_name}}</option>
                      @endif
                    @endforeach
                  @endif
                </select>
                <span id="validate_personnel"></span>
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
                    @if($isnew)
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemsearch-modal"><i class="fa fa-plus"></i> Add item</button>
                    @endif
                </div>
                <div class="col-sm-6">
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
                              <th>Serial No</th>
                              <th>Tag No</th>
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
                              <td><input id="r3" type="radio" name="r3" onclick="EnterItem_Add('{{$di->item_code}}', '{{$di->part_no}}', '{{$di->item_desc}}', '{{$di->sales_unit_id}}', '{{$di->unit_cost}}')"></td>
                              <td>{{$di->item_code}}</td>
                              <td>{{$di->qty_onhand_su}}</td>
                              <td>{{$di->part_no}}</td>
                              <td>{{$di->serial_no}}</td>
                              <td>{{$di->tag_no}}</td>
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
                  <th>Item Code</th>
                  <th>Property No</th>
                  <th>Serial No </th>
                  <th>Tag No</th>
                  <th>Description</th>
                  <th>Request Qty</th>
                  <th>Issued Qty</th>
                  <th>Unit Code</th>
                  <th>Unit Desc</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(!$isnew)
                @foreach($reclne as $rl)
                <tr>  
                  <td>{{$rl->ln_num}}</td>
                  <td>{{$rl->item_code}}</td>
                  <td>{{$rl->part_no}}</td>
                  <td>{{$rl->serial_no}}</td>
                  <td>{{$rl->tag_no}}</td>
                  <td>{{$rl->item_desc}}</td>
                  <td>{{$rl->qty}}</td>
                  <td>{{$rl->issued_qty}}</td>
                  <td>{{$rl->unit_code}}</td>
                  <td>{{$rl->unit_desc}}</td>
                  <td><center><a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit({{$rl->ln_num}});"></i></a><!-- &nbsp;<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete({{$rl->ln_num}});"></i></a> --></center>
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
                <a href="{{route('inventory.stockrelease')}}" class="btn btn-block btn-primary"><i class="fa fa-arrow-left"></i> Go Back</a>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group" style="display: flex;">
                @if($isnew)
                  <a class="btn btn-block btn-success" style="margin-top: 0;"  onclick="Save()"><i class="fa fa-save"></i> Save & Approve</a>
                @else
                  <a class="btn btn-block btn-success" style="margin-top: 0;"  onclick="EditSave()"><i class="fa fa-save"></i> Approve</a>
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
                          <div class="col-sm-8">
                            <div class="form-group">
                              <label>Item Code</label>
                              <input type="text" class="form-control" name="txt_itemcode" readonly="">
                            </div>
                          </div>                       
                        </div>
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Property No.</label>
                              <input type="text" class="form-control" name="txt_partno" readonly="">
                            </div>
                          </div> 
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Serial No.</label>
                              <input type="text" class="form-control" name="txt_serialno" readonly="">
                            </div>
                          </div> 
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Tag No.</label>
                              <input type="text" class="form-control" name="txt_tagno" readonly="">
                            </div>
                          </div> 
                        </div>
                        <div class="row">
                          <div class="col-sm-9">
                            <div class="form-group">
                              <label>Item Description</label>
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
                        <!-- <div class="row">
                          <div class="col-sm-9">
                            <div class="form-group">
                              <label>VAT Type</label>
                              @if($isnew)
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_vat" data-parsley-errors-container="#validate_vat" data-parsley-required-message="<strong>VAT is required.</strong>" required>
                                    <option value="" selected="selected">--- Select VAT ---</option>
                                    @foreach($vat as $v)
                                    <option value="{{$v->vat_code}}">{{$v->vat_desc}}</option>
                                    @endforeach
                                </select>
                              @else
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_vat" data-parsley-errors-container="#validate_vat" data-parsley-required-message="<strong>VAT is required.</strong>" required>
                                    <option value="" selected="selected">--- Select VAT ---</option>
                                    @foreach($vat as $v)
                                    <option value="{{$v->vat_code}}">{{$v->vat_desc}}</option>
                                    @endforeach
                                </select>
                              @endif
                            </div>
                            <span id="validate_vat"></span>
                          </div>
                        </div> -->
                        <div class="row">
                          @if($isnew)
                            <input id="txt_qty" type="hidden" class="form-control" name="txt_qty" placeholder="0.00" required="" readonly="">
                          @else
                            <div class="col-sm-4">
                              <div class="form-group">
                                <label>Quantity</label>
                                  <input id="txt_qty" type="text" class="form-control" name="txt_qty" placeholder="0.00" required="" readonly="">
                              </div>
                            </div>
                          @endif 
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Issued Quantity</label>
                                <input id="txt_issuedqty" type="text" class="form-control" name="txt_issuedqty" placeholder="0.00" data-parsley-errors-container="#validate_issuedqty" data-parsley-required-message="<strong>Issued Quantity is required.</strong>" required>
                                <span id="validate_issuedqty"></span>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Unit Measurement</label>
                                @if($isnew)
                                  <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_unit" data-parsley-errors-container="#validate_unit" data-parsley-required-message="<strong>Issued Quantity is required.</strong>" required>
                                    <option value="" selected="selected">--- Select Unit Measurement ---</option>
                                    @foreach($itemunit as $iu)
                                    <option value="{{$iu->unit_id}}">{{$iu->unit_shortcode}}</option>
                                    @endforeach
                                  </select>
                                  <span id="validate_unit"></span>
                                @else
                                  <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_unit" required="" disabled="">
                                    <option value="" selected="selected">--- Select Unit Measurement ---</option>
                                    @foreach($itemunit as $iu)
                                    <option value="{{$iu->unit_id}}">{{$iu->unit_shortcode}}</option>
                                    @endforeach
                                  </select>
                                @endif
                            </div>
                          </div>
                          
                        </div>
                        <!-- <div class="row">       
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Cost Price</label>
                               <input id="txt_cost" type="text" class="form-control" name="txt_cost" placeholder="0.00" required="" readonly="">
                            </div>
                          </div>                   
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label>Disc Amt</label>
                               <input id="txt_disc" type="text" class="form-control" name="txt_disc" placeholder="0.00" readonly="">
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Line Amount</label>
                               <input type="text" class="form-control" name="txt_lineamt" placeholder="0.00" readonly="">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label>VAT</label>
                               <input type="text" class="form-control" name="txt_vatamt" placeholder="0.00" readonly="">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label>Net Price</label>
                               <input type="text" class="form-control" name="txt_netprice" placeholder="0.00" readonly="">
                            </div>
                          </div>
                        </div> -->
                        
                        
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

      $(document).ready(function() {

      // get selected row
      $('#tbl_itemlist tbody').on( 'click', 'tr', function () {
                var table = $('#tbl_itemlist').DataTable();
                selectedRow = table.row( this ).index() ;

                console.log('rowindex: '+selectedRow);
            } );

      // modif datatable col
      $('#tbl_itemlist').DataTable( {
        "columnDefs": [
            {
                "targets": [ 8 ], // hide unit code col
                "visible": false,
                "searchable": false
            }
        ]
      } );

      } );

      

      function EnterItem_Add(code, part_no, item_desc, unit, cost_price)
      {
        clear();
        $('#ENTER_ITEM').text('Add');
        $('.AddMode').show();
        $('.AddModeBtn').show();
        $('.EditMode').show();
        $('.EditModeBtn').hide();
        $('.DeleteMode').hide();
        
        var line = ($('#tbl_itemlist').DataTable().rows().count()) + 1;

        $('input[name="txt_lineno"]').val(line);
        $('input[name="txt_itemcode"]').val(code);
        $('input[name="txt_partno"]').val(part_no);
        $('input[name="txt_itemdesc"]').val(item_desc);
        $('input[name="txt_cost"]').val(cost_price);
        $('select[name="select_unit"]').val(unit).trigger('change');
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
          var row = table.rows().count() - line;
          var data = table.row(row).data(); // get data of the selected row.
          
          $('input[name="txt_lineno"]').val(data[0]);
          $('input[name="txt_itemcode"]').val(data[1]);
          $('input[name="txt_partno"]').val(data[2]);
          $('input[name="txt_serialno"]').val(data[3]);
          $('input[name="txt_tagno"]').val(data[4]);
          $('input[name="txt_itemdesc"]').val(data[5]);
          $('input[name="txt_qty"]').val(data[6]);
          $('input[name="txt_issuedqty"]').val(data[7]);
          $('select[name="select_unit"]').val(data[8]).trigger('change');

          $('#enteritem-modal').modal('toggle');
          console.log('editline: ' + row);
          console.log('line: ' + line);
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
        if($('#add-form').parsley().validate())
        {

        var table = $('#tbl_itemlist').DataTable();

        var line = $('input[name="txt_lineno"]').val();
        var item_code = $('input[name="txt_itemcode"]').val();
        var part_no = $('input[name="txt_partno"]').val();
        var serial_no = $('input[name="txt_serialno"]').val();
        var tag_no = $('input[name="txt_tagno"]').val();
        var item_desc = $('input[name="txt_itemdesc"]').val();
        var qty = $('input[name="txt_qty"]').val();
        var issued_qty = $('input[name="txt_issuedqty"]').val();
        var unit_code = $('select[name="select_unit"]').select2('data')[0].id;
        var unit_desc = $('select[name="select_unit"]').select2('data')[0].text;
        
        var buttons = '<center>' +
              '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit( \''+line+'\');"></i></a>' +
            '</center>';

        if($('#ENTER_ITEM').text() == 'Add') // add item
        {

        table.row.add([line, item_code, part_no, serial_no, tag_no, item_desc, qty, issued_qty, unit_code, unit_desc, buttons]).draw();

        }
        else if($('#ENTER_ITEM').text() == 'Edit') // edit item
        {
          table.row(selectedRow).data([line, item_code, part_no, serial_no, tag_no, item_desc, qty, issued_qty, unit_code, unit_desc, buttons]).draw();
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

      // function disp_amt_result()
      // {
      //   var total_costamt = 0.00, net_amt = 0.00, qty = 0.00, costprice = 0.00, disc_amt = 0.00, ln_amt = 0.00;

      //   qty = $('input[name="txt_qty"]').val();
      //   costprice = $('input[name="txt_cost"]').val();
        
      //   if($('input[name="txt_disc"]').val() != null)
      //   {
      //     disc_amt = $('input[name="txt_disc"]').val();
      //   }

      //   total_costamt = qty * costprice;

      //   ln_amt = parseFloat(total_costamt - disc_amt).toFixed(2);

      //   $('input[name="txt_lineamt"]').val(ln_amt);
      //   $('input[name="txt_disc"]').val(disc_amt);

      //   disp_vat(ln_amt);
      // }

      // function disp_vat(total_amt)
      // {
      //   var vat_amt = 0.00, net_amt = 0.00;
      //   var tax_type = $('select[name="select_vat"]').select2('data')[0].id;

      //   if(tax_type == 'I')
      //   {
      //       net_amt = parseFloat(total_amt / 1.12).toFixed(2);
      //       vat_amt = parseFloat(total_amt - net_amt).toFixed(2);

      //       $('input[name="txt_netprice"]').val(net_amt);
      //       $('input[name="txt_vatamt"]').val(vat_amt);
      //   }
      //   else if(tax_type == 'E')
      //   {
      //       net_amt = parseFloat(total_amt).toFixed(2);
      //       total_amt = parseFloat(total_amt * 1.12).toFixed(2);
      //       vat_amt = parseFloat(total_amt - net_amt).toFixed(2);

      //       $('input[name="txt_lineamt"]').val(total_amt);
      //       $('input[name="txt_netprice"]').val(net_amt);
      //       $('input[name="txt_vatamt"]').val(vat_amt);
      //   }
      //   else
      //   {
      //       net_amt = parseFloat(total_amt).toFixed(2);
      //       vat_amt = parseFloat(vat_amt).toFixed(2);

      //       $('input[name="txt_netprice"]').val(net_amt);
      //       $('input[name="txt_vatamt"]').val(vat_amt);
      //   }
      // }

      function clear()
      {
        $('input[name="txt_lineno"]').val('');
        $('input[name="txt_itemcode"]').val('');
        $('input[name="txt_partno"]').val('');
        $('input[name="txt_serialno"]').val('');
        $('input[name="txt_tagno"]').val('');
        $('input[name="txt_itemdesc"]').val('');
        // $('select[name="select_vat"]').val('').trigger('change');
        $('input[name="txt_qty"]').val('0');
        $('input[name="txt_issuedqty"]').val('0');
        $('select[name="select_unit"]').val('').trigger('change');
        // $('input[name="txt_cost"]').val('0.00');
        // $('input[name="txt_disc"]').val('0.00');
        // $('input[name="txt_lineamt"]').val('0.00');
        // $('input[name="txt_vatamt"]').val('0.00');
        // $('input[name="txt_netprice"]').val('0.00');
        $('#r3').prop( "checked", false );

      }

      function Save()
      {
        var tbl_itemlist = $('#tbl_itemlist').DataTable();
        
        if($('#HeaderForm').parsley().validate())
        {
          if(tbl_itemlist.data().count() > 0)
          {

             var tbl_itemdata = tbl_itemlist.data().toArray(); // tbl_itemlist data
             var rec_num = $('input[name="txt_code"]').val();

             var data = { 
                           _token : $('meta[name="csrf-token"]').attr('content'),
                           tbl_itemlist: tbl_itemdata,
                           invoicedt: $('input[name="dtp_invoicedt"]').val(),
                           stock_loc: $('select[name="select_stocklocation"]').select2('data')[0].id,
                           personnel: $('select[name="select_personnel"]').select2('data')[0].id,
                           costcenter: $('select[name="select_costcenter"]').select2('data')[0].id,
                           reference: $('input[name="txt_reference"]').val(),
                           ris_no: $('input[name="txt_ris_no"]').val(),
                           sai_no: $('input[name="txt_sai_no"]').val(),
                        };

             $.ajax({
                    url: '{{route('inventory.stockrelease_add')}}',
                    method: 'POST',
                    data: data,
                    success : function(flag)
                             {
                                if(flag)
                                {
                                  console.log(flag);
                                  location.href= "{{route('inventory.stockrelease')}}";
                                }
                                else
                                {
                                  alert('ERROR in saving.');
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
        
        if($('#HeaderForm').parsley().validate())
        {
          if(tbl_itemlist.data().count() > 0)
          {

             var tbl_itemdata = tbl_itemlist.data().toArray(); // tbl_itemlist data
             var rec_num = $('input[name="txt_code"]').val();

             var data = { 
                           _token : $('meta[name="csrf-token"]').attr('content'),
                           tbl_itemlist: tbl_itemdata,
                           invoicedt: $('input[name="dtp_invoicedt"]').val(),
                           stock_loc: $('select[name="select_stocklocation"]').select2('data')[0].id,
                           personnel: $('select[name="select_personnel"]').select2('data')[0].id,
                           costcenter: $('select[name="select_costcenter"]').select2('data')[0].id,
                           reference: $('input[name="txt_reference"]').val(),
                           ris_no: $('input[name="txt_ris_no"]').val(),
                           sai_no: $('input[name="txt_sai_no"]').val(),
                        };

             $.ajax({
                    url: '{{asset('inventory/stockrelease/stockrelease_edit')}}/'+rec_num,
                    method: 'POST',
                    data: data,
                    success : function(flag)
                             {
                                if(flag)
                                {
                                  console.log(flag);
                                  location.href= "{{route('inventory.stockrelease')}}";
                                }
                                else
                                {
                                  alert('ERROR in saving.');
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

      // function total_amount()
      // {
      //   var total_amt = 0.00;
      //   var tbl_itemlist = $('#tbl_itemlist').DataTable();
      //   var tbl_itemdata = tbl_itemlist.data().toArray(); //get all data of the table itemlist

      //   // foreach total amount
      //   $.each(tbl_itemdata, function(){
      //     total_amt += parseFloat(this[10]);
      //   });

      //   $('input[name="txt_grandtotalamt"]').val(total_amt.toFixed(2));

      // }

    </script>

    </section>
    <!-- /.content -->
	
@endsection