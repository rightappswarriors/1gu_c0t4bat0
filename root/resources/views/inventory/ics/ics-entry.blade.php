@extends('_main')
@if($isnew)
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Inventory Custodian Slip','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Create','icon'=>'none','st'=>true],
    ];
    $_ch = "Inventory Custodian Slip"; // Module Name
@endphp
@else
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Inventory Custodian Slip','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Edit','icon'=>'none','st'=>true],
    ];
    $_ch = "Inventory Custodian Slip"; // Module Name
@endphp
@endif
@section('content')
		<!-- Content Header (Page header) -->
		@include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Inventory Custodian Slip Info</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Invoice No</label>
                @if($isnew)
                <input type="text" class="form-control" name="" disabled="">
                @else
                <input type="text" class="form-control" name="txt_code" value="{{$rechdr->rec_num}}" disabled="">
                @endif
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Invoice Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  @if($isnew)
                  <input type="date" name="dtp_invoicedt" class="form-control pull-right" id="datepicker">
                  @else
                  <input type="date" class="form-control pull-right" id="datepicker" name="dtp_invoicedt" value="{{$rechdr->trnx_date}}">
                  @endif
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Office</label>
                @if($isnew)
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_costcenter" required="" disabled="">
                  <option value="" selected="selected">--- Select Office ---</option>
                  @foreach($costcenter as $cc)
                  <option value="{{$cc->cc_code}}">{{$cc->cc_desc}}</option>
                  @endforeach
                </select>
                @else
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_costcenter" required="" disabled="">
                  @foreach($costcenter as $cc)
                  @if($rechdr->cc_code == $cc->cc_code)
                  <option selected = "selected" value="{{$cc->cc_code}}">{{$cc->cc_desc}}</option>
                  @else
                  <option value="{{$cc->cc_code}}">{{$cc->cc_desc}}</option>
                  @endif
                  @endforeach
                </select>
                @endif
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Reference</label>
                @if($isnew)
                <input type="text" class="form-control" name="txt_reference">
                @else
                <input type="text" class="form-control" name="txt_reference" value="{{$rechdr->_reference}}">
                @endif
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>ICS NO</label>
                @if($isnew)
                <input type="text" class="form-control" name="txt_ics_no">
                @else
                <input type="text" class="form-control" name="txt_ics_no" value="{{$rechdr->ics_no}}">
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
        <!-- /.box-body -->
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="row">
                <div class="col-sm-6">
                  <h3 class="box-title">Item Details</h3>
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemsearch-modal"><i class="fa fa-plus"></i> Add item</button> -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#additemfromris-modal"><i class="fa fa-plus"></i> Add item(s) from RIS</button>
                </div>
                <!-- <div class="col-sm-6">
                  <h5 class="box-title">Total amount:</h5>
                    &nbsp;<label><input type="text" name="txt_grandtotalamt" readonly=""></label>
                </div> -->
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
                              <td><input type="radio" name="r3" onclick="EnterItem_Add('{{$di->item_code}}', '{{$di->part_no}}', '{{$di->item_desc}}', '{{$di->sales_unit_id}}', '{{$di->unit_cost}}')"></td>
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
                  <th>Serial No</th>
                  <th>Tag No</th>
                  <th>Description</th>
                  <th>Qty</th>
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
                  <td>{{$rl->unit_code}}</td>
                  <td>{{$rl->unit_desc}}</td>
                  <td><center><a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit({{$rl->ln_num}});"></i></a>&nbsp;<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete({{$rl->ln_num}});"></i></a></center>
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
                <a href="{{route('inventory.ics')}}" class="btn btn-block btn-primary"><i class="fa fa-arrow-left"></i> Go Back</a>
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
                      <form id="add-form">
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
                              <label>Property No</label>
                              <input type="text" class="form-control" name="txt_partno" readonly="">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Serial No</label>
                              <input type="text" class="form-control" name="txt_serialno" readonly="">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Tag No</label>
                              <input type="text" class="form-control" name="txt_tagno" readonly="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label>Item Description</label>
                              <input type="text" class="form-control" name="txt_itemdesc" readonly=""> 
                            </div>
                          </div>
                          
                        </div>
                        
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Quantity</label>
                                <input id="txt_qty" type="text" class="form-control" name="txt_qty" placeholder="0.00" required="">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Unit</label>
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_unit" required="">
                                  <option value="" selected="selected">--- Select Unit ---</option>
                                  @foreach($itemunit as $iu)
                                  <option value="{{$iu->unit_id}}">{{$iu->unit_shortcode}}</option>
                                  @endforeach
                                </select>
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



       <!-- Add item(s) from RIS -->
              <div class="row">
              <div class="modal fade in" id="additemfromris-modal">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                      <h4 class="modal-title">Add item(s) from RIS</h4>
                    </div>
                    <div class="modal-body">
                      <form id="add-form">
                       
                      <div class="box-body">
                        
                        
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label>SELECT RIS</label>
                              <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_ris" required="" onchange="getDataFromLoadItems()">
                                  <option value="" selected="selected">--- Select RIS Approved ---</option>
                                  @foreach($ris_approved as $risa)
                                   {{-- {{print_r([$risa->rec_num,$risa->ris_no,$risa->cc_code,$risa->nameofpersonnel])}} --}}
                                  <option personneltoreceive="{{$risa->uid}}" value="{{$risa->rec_num}}">{{$risa->ris_no}} {{$risa->cc_code}} {{$risa->nameofpersonnel}}</option>

                                  @endforeach
                                </select>

                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                           <div class="table-responsive">
                           <table id="tbl_risitemlist" class="table table-bordered table-striped">
                             <thead>
                               <tr>
                                 <th><input type="checkbox" name="select_all" onchange="checkAllRISItems(this.checked)"></th>
                                 <th>Line</th>
                                 <th>Item Code</th>
                                 <th>Property No</th>
                                 <th>Serial No</th>
                                 <th>Tag No</th>
                                 <th>Description</th>
                                 <th>Issued Qty</th>
                                 <th>Unit Code</th>
                                 <th>Unit Desc</th>
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
                     
                        <button type="button" class="btn btn-primary" onclick="selectedRISItems()">Proceed</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                     
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              </div>
              <!-- End Modal -->
              <!-- Add item(s) from RIS -->       

    <script>

   // Fix modal scroll disabled.
    // $('body').on('hidden.bs.modal', function () {
    //  if($('.modal.in').length > 0)
    //  {
    //      $('body').addClass('modal-open');
    //  }
    //  });
    // Fix modal scroll disabled.

      var selectedRow = 0;
      var loadedItemsFromRIS = [];
      var riscode;

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
      // $('#txt_qty').keyup(function(event)
      // {
      //   disp_amt_result();
      // });
      
      // if select vat qty change
      // $('select[name="select_vat"]').change(function(event)
      // {
      //   disp_amt_result();
      // });
      
      // input disc change
      // $('#txt_disc').keyup(function(event)
      // {
      //   disp_amt_result();
      // });

      // if cost price change
      // $('#txt_cost').keyup(function(event)
      // {
      //   disp_amt_result();
      // });


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
        $('input[name="txt_part_no"]').val(part_no);
        $('input[name="txt_itemdesc"]').val(item_desc);
        //$('input[name="txt_partno"]').val(part_no);
        //$('input[name="txt_cost"]').val(cost_price);
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
          var row = line - 1;
          var data = table.row(row).data();
          
          $('input[name="txt_lineno"]').val(data[0]);
          $('input[name="txt_itemcode"]').val(data[1]);
          $('input[name="txt_partno"]').val(data[2]);
          $('input[name="txt_serialno"]').val(data[3]);
          $('input[name="txt_tagno"]').val(data[4]);
          $('input[name="txt_itemdesc"]').val(data[5]);
          $('input[name="txt_qty"]').val(data[6]);
          $('select[name="select_unit"]').val(data[7]).trigger('change');
          //$('input[name="txt_cost"]').val(data[7]);
          //$('input[name="txt_disc"]').val(data[8]);
          // $('input[name="txt_lineamt"]').val(data[9]);
          // $('input[name="txt_netprice"]').val(data[10]);
          // $('select[name="select_vat"]').val(data[11]).trigger('change');
          // $('input[name="txt_vatamt"]').val(data[12]);

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
        var table = $('#tbl_itemlist').DataTable();

        var line = $('input[name="txt_lineno"]').val();
        var item_code = $('input[name="txt_itemcode"]').val();
        var part_no = $('input[name="txt_partno"]').val();
        var serial_no = $('input[name="txt_serialno"]').val();
        var tag_no = $('input[name="txt_tagno"]').val();
        var item_desc = $('input[name="txt_itemdesc"]').val();
        var qty = $('input[name="txt_qty"]').val();
        var unit_code = $('select[name="select_unit"]').select2('data')[0].id;
        var unit_desc = $('select[name="select_unit"]').select2('data')[0].text;
        // var cost_price = $('input[name="txt_cost"]').val();
        // var disc_amnt = $('input[name="txt_disc"]').val();
        // var line_amnt = $('input[name="txt_lineamt"]').val();
        // var net_price = $('input[name="txt_netprice"]').val();
        // var line_vat = $('select[name="select_vat"]').select2('data')[0].id;
        // var vat_amt = $('input[name="txt_vatamt"]').val();
        var buttons = '<center>' +
              '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit( \''+line+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete(\''+line+'\');"></i></a>' +
            '</center>';

        if($('#ENTER_ITEM').text() == 'Add')
        {

        table.row.add([line, item_code, part_no, serial_no, tag_no, item_desc, qty, unit_code, unit_desc, buttons]).draw();

        }
        else if($('#ENTER_ITEM').text() == 'Edit')
        {
          table.row(selectedRow).data([line, item_code, part_no, serial_no, tag_no, item_desc, qty, unit_code, unit_desc, buttons]).draw();
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

        // total_amount();
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
        $('select[name="select_unit"]').val('').trigger('change');
        // $('input[name="txt_cost"]').val('0.00');
        // $('input[name="txt_disc"]').val('0.00');
        // $('input[name="txt_lineamt"]').val('0.00');
        // $('input[name="txt_vatamt"]').val('0.00');
        // $('input[name="txt_netprice"]').val('0.00');

      }

      function Save()
      {
        var tbl_itemlist = $('#tbl_itemlist').DataTable();
        var tbl_itemdata = tbl_itemlist.data().toArray(); // tbl_itemlist data

        var data = { 
                      _token : $('meta[name="csrf-token"]').attr('content'),
                      tbl_itemlist: tbl_itemdata,
                      invoicedt: $('input[name="dtp_invoicedt"]').val(),
                      // stock_loc: $('select[name="select_stocklocation"]').select2('data')[0].id,
                      // branch: $('select[name="select_branch"]').select2('data')[0].id,
                      costcenter: $('select[name="select_costcenter"]').select2('data')[0].id,
                      reference: $('input[name="txt_reference"]').val(),
                      ics_no: $('input[name="txt_ics_no"]').val(),
                      personnel: $('select[name="select_personnel"]').select2('data')[0].id,
                      ris_code: riscode,
                   };

           $.ajax({
                  url: '{{route('inventory.ics_add')}}',
                  method: 'POST',
                  data: data,
                  success : function(flag)
                           {
                              if(flag)
                              {
                                console.log(flag);
                                location.href= "{{route('inventory.ics')}}";
                              }
                              else
                              {
                                alert('ERROR in saving.');
                              }
                           }
                  });
      }

      function EditSave()
      {
        var tbl_itemlist = $('#tbl_itemlist').DataTable();
        var tbl_itemdata = tbl_itemlist.data().toArray(); // tbl_itemlist data

        var rec_num = $('input[name="txt_code"]').val();

        var data = { 
                      _token : $('meta[name="csrf-token"]').attr('content'),
                      tbl_itemlist: tbl_itemdata,
                      invoicedt: $('input[name="dtp_invoicedt"]').val(),
                      // stock_loc: $('select[name="select_stocklocation"]').select2('data')[0].id,
                      // branch: $('select[name="select_branch"]').select2('data')[0].id,
                      costcenter: $('select[name="select_costcenter"]').select2('data')[0].id,
                      reference: $('input[name="txt_reference"]').val(),
                      ics_no: $('input[name="txt_ics_no"]').val(),
                      personnel: $('select[name="select_personnel"]').select2('data')[0].id,
                   };

           $.ajax({
                  url: '{{asset('inventory/ics/ics_edit')}}/'+rec_num,
                  method: 'POST',
                  data: data,
                  success : function(flag)
                           {
                              if(flag)
                              {
                                console.log(flag);
                                location.href= "{{route('inventory.ics')}}";
                              }
                              else
                              {
                                alert('ERROR in saving.');
                              }
                           }
                  });
      }

      // function total_amount()
      // {
      //   var total_amt = 0.00;
      //   var tbl_itemlist = $('#tbl_itemlist').DataTable();
      //   var tbl_itemdata = tbl_itemlist.data().toArray(); //get all data of the table itemlist

      //   // foreach total amount
      //   $.each(tbl_itemdata, function(){
      //     total_amt += parseFloat(this[9]);
      //   });

      //   $('input[name="txt_grandtotalamt"]').val(total_amt.toFixed(2));

      // }

      function getDataFromLoadItems() // load items from RIS
      {
         var tbl_risitemlist = $('#tbl_risitemlist').DataTable();
         var ris_no = $('select[name="select_ris"]').select2('data')[0].id;
         var dataar;
         
         tbl_risitemlist.clear().draw();

         riscode = ris_no;

         if(ris_no != '')
         {
           $.ajax({
             url: '{{asset('inventory/ics/getDataFromRIS')}}/'+ris_no,
             data : { code : ris_no},
             success : function(data)
             {
                if(data[0].length > 0)
                {
                  loadedItemsFromRIS = data[0];
                  dataar = data[0];

                  for(var i = 0; i < dataar.length; i++)
                  {
                    tbl_risitemlist.row.add(['<input type="checkbox" id="chk_risitems" class="chk_risitems" value="'+dataar[i].ln_num+'">',
                                             dataar[i].ln_num, 
                                             dataar[i].item_code,
                                             dataar[i].part_no,
                                             dataar[i].serial_no,
                                             dataar[i].tag_no,
                                             dataar[i].item_desc,
                                             dataar[i].issued_qty,
                                             dataar[i].unit_code,
                                             dataar[i].unit_desc
                                            ]).draw();
                  }

                  $('select[name="select_costcenter"]').val(data[1]).trigger('change');
                  $('select[name=select_personnel]').val($('[name=select_ris]').find('option:selected').attr('personneltoreceive')).trigger('change');

                }

                
             }
           });
         }
      }

      function checkAllRISItems(chk_bool) // check/uncheck all checkbox risitems
      {
        let chk_risitems = document.getElementsByClassName('chk_risitems');
      
        for(let i = 0; i < chk_risitems.length; i++) 
        {
          chk_risitems[i].checked = chk_bool;
        }
      }

      function selectedRISItems()
      {
        let chk_risitems = document.getElementsByClassName('chk_risitems');
        let tbl_itemlist = $('#tbl_itemlist').DataTable();

        for(let i = 0; i < chk_risitems.length; i++) 
        {
          if(chk_risitems[i].checked)
          {
            loadedItemsFromRIS.forEach(function (a, b, c) {
                if(a.ln_num == chk_risitems[i].value)
                {

                  tbl_itemlist.row.add([a.ln_num, a.item_code, a.part_no, a.serial_no, a.tag_no, a.item_desc, a.issued_qty, a.unit_code, a.unit_desc, '<center>' +
              '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit( \''+a.ln_num+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete(\''+a.ln_num+'\');"></i></a>' +
            '</center>']).draw();
                }
            });
          }
        }

        $('#additemfromris-modal').modal('toggle');
      } 

    </script>

    </section>
    <!-- /.content -->
	
@endsection