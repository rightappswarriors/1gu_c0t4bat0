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
            <div class="col-md-4">
              <div class="form-group">
                <label>Invoice No</label>
                @if($isnew)
                <input type="text" class="form-control" name="" disabled="">
                @else
                <input type="text" class="form-control" name="txt_code" value="{{$rechdr->rec_num}}" disabled="">
                @endif
              </div>
            </div>
            <div class="col-md-4">
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
            <div class="col-md-4">
              <div class="form-group">
                <label>Office</label>
                @if($isnew)
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_costcenter" required="">
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

             <div class="col-md-3">
              <div class="form-group">
                <label>Personnel to Receive Designation</label>

                @if($isnew)
                  <input list="select_receivedbydesig" name="select_receivedbydesig" style="width: 100%;" data-parsley-errors-container="#validate_selectreceivedfromdesig" data-parsley-required-message="<strong>Received From Designation is required.</strong>" required>
                @else
                  <input list="select_receivedbydesig" name="select_receivedbydesig" value="{{$rechdr->are_receivebydesig}}" style="width: 100%;" data-parsley-errors-container="#validate_selectreceivedfromdesig" data-parsley-required-message="<strong>Received From Designation is required.</strong>" required>
                @endif

                <datalist id="select_receivedbydesig">
                  @foreach($are_position as $ap)
                    <option value="{{$ap->name}}">
                  @endforeach
                </datalist>
                <span id="validate_selectreceivedfromdesig"></span>
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
                    <button type="button" class="btn btn-warning" onclick="EnterItem_Add('', '', '', '', '', 'TEXT-ITEM')"><i class="fa fa-plus"></i> Add Text Item</button>
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
                  <th>Unit Cost</th>
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
                  <td>{{$rl->price}}</td>
                  <td><center><a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit({{$rl->ln_num}}, '{{$rl->item_code}}');"></i></a>&nbsp;<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete({{$rl->ln_num}});"></i></a></center>
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
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Unit Cost</label>
                                <input id="txt_unitcost" type="text" class="form-control" name="txt_unitcost" required="" readonly="">
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

                    {{-- TEXT-ITEM FORM --}}
                    <span class="AddModeText EditModeText">
                    <form id="add-formtext" data-parsley-validate novalidate>
                      <div class="box-body">
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Line No</label>
                              <input type="text" class="form-control" name="txt_lineno_text" readonly="">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Item Code</label>
                              <input type="text" class="form-control" name="txt_itemcode_text" readonly="">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Unit Desc</label>
                              <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="unit_desc_text" required="">
                                <option value="" selected="selected">--- Select Unit ---</option>
                                @foreach($itemunit as $iu)
                                <option value="{{$iu->unit_id}}">{{$iu->unit_shortcode}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label>Description</label>
                               <textarea class="form-control" rows="2" id="txt_description_text" name="txt_description_text"></textarea>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>Serial No</label>
                              <input type="text" class="form-control" name="txt_serialno_text" id="txt_serial_text">
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>Tag No</label>
                              <input type="text" class="form-control" name="txt_tagno_text" id="txt_tag_text">
                            </div>
                          </div> 
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Unit Cost</label>
                              <input type="number" class="form-control" name="txt_unitcost_text" id="txt_unitcost_text">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Qty.</label>
                              <input type="number" class="form-control" min="0" name="txt_qty_text">
                            </div>
                          </div> 
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Property No.</label>
                              <input type="text" class="form-control" name="txt_partno_text">
                            </div>
                          </div>                              
                        </div>
                      </div>
                    </form>
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
                "targets": [7], // hide unit code col
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


      function EnterItem_Add(code, part_no, item_desc, unit, cost_price, typeitem)
      {
        if(typeitem == 'TEXT-ITEM')
        {
          var line = ($('#tbl_itemlist').DataTable().rows().count()) + 1;
          clear();
          $('#ENTER_ITEM').text('Add Text');
          $('.AddModeText').show();
          $('EditModeText').show();
          $('.AddMode').hide();
          $('.AddModeBtn').hide();
          $('.EditMode').hide();
          $('.EditModeBtnText').hide();
          $('.AddModeBtnText').show();
          $('.EditModeBtn').hide();
          $('.DeleteMode').hide();
          $('.DeleteModeText').hide();

          
          var line = ($('#tbl_itemlist').DataTable().rows().count()) + 1;

          $('input[name="txt_lineno_text"]').val(line);
          $('input[name="txt_itemcode_text"]').val('TEXT-ITEM');


          $('#enteritem-modal').modal('toggle');
        }
        else
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
      }

      function EnterItem_Edit(line, typeitem)
      {
        if(typeitem == 'TEXT-ITEM')
        {
          clear();
          $('#ENTER_ITEM').text('Edit Text');
          $('.AddMode').hide();
          $('.EditMode').hide();
          $('.EditModeBtn').hide();
          $('.EditModeText').show();
          $('.AddModeText').show();
          $('.AddModeBtn').hide();
          $('.AddModeBtnText').hide();
          $('.DeleteMode').hide();
          $('.EditModeBtnText').show();
          $('.DeleteModeText').hide();

          var table = $('#tbl_itemlist').DataTable();
          var row = line - 1;
          var data = table.row(row).data();
          
          $('input[name="txt_lineno_text"]').val(data[0]);
          $('input[name="txt_itemcode_text"]').val(data[1]);
          $('input[name="txt_partno_text"]').val(data[2]);
          $('input[name="txt_serialno_text"]').val(data[3]);
          $('input[name="txt_tagno_text"]').val(data[4]);
          $('textarea[name="txt_description_text"]').val(data[5]);
          $('input[name="txt_qty_text"]').val(data[6]);
          $('select[name="unit_desc_text"]').val(data[7]).trigger('change');
          $('input[name="txt_unitcost_text"]').val(data[9]);
          


          //$('input[name="txt_cost"]').val(data[7]);
          //$('input[name="txt_disc"]').val(data[8]);
          // $('input[name="txt_lineamt"]').val(data[9]);
          // $('input[name="txt_netprice"]').val(data[10]);
          // $('select[name="select_vat"]').val(data[11]).trigger('change');
          // $('input[name="txt_vatamt"]').val(data[12]);

          $('#enteritem-modal').modal('toggle');

          //console.log(data);
        }
        else
        {
          clear();
          $('#ENTER_ITEM').text('Edit');
          $('.AddMode').show();
          $('.EditMode').show();
          $('.EditModeBtn').show();
          $('.EditModeText').hide();
          $('.AddModeText').hide();
          $('.AddModeBtn').hide();
          $('.AddModeBtnText').hide();
          $('.DeleteMode').hide();
          $('.EditModeBtnText').hide();
          $('.DeleteModeText').hide();

          

          var table = $('#tbl_itemlist').DataTable();
          var row = line - 1;
          var data = table.row(row).data();
          var line = ($('#tbl_itemlist').DataTable().rows().count()) + 1;
          $('input[name="txt_lineno"]').val(data[0]);
          $('input[name="txt_itemcode"]').val(data[1]);
          $('input[name="txt_partno"]').val(data[2]);
          $('input[name="txt_serialno"]').val(data[3]);
          $('input[name="txt_tagno"]').val(data[4]);
          $('input[name="txt_itemdesc"]').val(data[5]);
          $('input[name="txt_qty"]').val(data[6]);
          $('select[name="select_unit"]').val(data[7]).trigger('change');
          $('input[name="txt_unitcost"]').val(data[9]);
          //$('input[name="txt_cost"]').val(data[7]);
          //$('input[name="txt_disc"]').val(data[8]);
          // $('input[name="txt_lineamt"]').val(data[9]);
          // $('input[name="txt_netprice"]').val(data[10]);
          // $('select[name="select_vat"]').val(data[11]).trigger('change');
          // $('input[name="txt_vatamt"]').val(data[12]);
          $('#enteritem-modal').modal('toggle');

          //console.log(data);
        }
         
      }

      function EnterItem_Delete(line)
      {
        $('#ENTER_ITEM').text('Delete Text');
        $('.AddMode').hide();
        $('.AddModeBtn').hide();
        $('.AddModeText').hide();
        $('.AddModeBtnText').hide();
        $('.EditMode').hide();
        $('EditModeText').hide();
        $('.EditModeBtn').hide();
        $('.EditModeBtnText').hide();
        $('.DeleteMode').show();

        $('#enteritem-modal').modal('toggle');
      }

      function set_tbl_itemlist(type, typeitem)
      {
        var table = $('#tbl_itemlist').DataTable();

        //SET TABLE ITEMLIST FOR ITEM
        if(typeitem == 'item')
        {
          var line = $('input[name="txt_lineno"]').val();
          var item_code = $('input[name="txt_itemcode"]').val();
          var part_no = $('input[name="txt_partno"]').val();
          var serial_no = $('input[name="txt_serialno"]').val();
          var tag_no = $('input[name="txt_tagno"]').val();
          var item_desc = $('input[name="txt_itemdesc"]').val();
          var qty = $('input[name="txt_qty"]').val();
          var unit_code = $('select[name="select_unit"]').select2('data')[0].id;
          var unit_desc = $('select[name="select_unit"]').select2('data')[0].text;
          var unit_cost = $('input[name="txt_unitcost"]').val();
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
          table.row.add([line, item_code, part_no, serial_no, tag_no, item_desc, qty, unit_code, unit_desc, unit_cost, buttons]).draw();
          }
          else if($('#ENTER_ITEM').text() == 'Edit')
          {
            table.row(selectedRow).data([line, item_code, part_no, serial_no, tag_no, item_desc, qty, unit_code, unit_desc, unit_cost, buttons]).draw();
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

          if(type == 'sc-item') // save and close
          {
              $('#enteritem-modal').modal('toggle');
          }
          else
          {
              $('#enteritem-modal').modal('toggle');
              $('#itemsearch-modal').modal('show');
          }
        }

        //SET TABLE LIST FOR TEXT-ITEM
        else if(typeitem == 'text-item')
        {
          var line = $('input[name="txt_lineno_text"]').val();
          var item_code = $('input[name="txt_itemcode_text"]').val();
          var part_no = $('input[name="txt_partno_text"]').val();
          var serial_no = $('input[name="txt_serialno_text"]').val();
          var tag_no = $('input[name="txt_tagno_text"]').val();
          var item_desc = $('textarea[name="txt_description_text"]').val();
          var qty = $('input[name="txt_qty_text"]').val();
          var unit_code = $('select[name="unit_desc_text"]').select2('data')[0].id;
          var unit_desc = $('select[name="unit_desc_text"]').select2('data')[0].text;
          var unit_cost = $('input[name="txt_unitcost_text"]').val();
          // var cost_price = $('input[name="txt_cost"]').val();
          // var disc_amnt = $('input[name="txt_disc"]').val();
          // var line_amnt = $('input[name="txt_lineamt"]').val();
          // var net_price = $('input[name="txt_netprice"]').val();
          // var line_vat = $('select[name="select_vat"]').select2('data')[0].id;
          // var vat_amt = $('input[name="txt_vatamt"]').val();
          console.log(unit_code);
          console.log(unit_desc);

          var buttons = '<center>' +
                          '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit( \''+line+'\', \''+item_code+'\');"></i></a>&nbsp;' +
                          '<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete(\''+line+'\', \''+item_code+'\');"></i></a>' +
                        '</center>';

          if($('#ENTER_ITEM').text() == 'Add Text')
          {
          table.row.add([line, item_code, part_no, serial_no, tag_no, item_desc, qty, unit_code, unit_desc, unit_cost, buttons]).draw();
          }
          else if($('#ENTER_ITEM').text() == 'Edit Text')
          {
            table.row(selectedRow).data([line, item_code, part_no, serial_no, tag_no, item_desc, qty, unit_code, unit_desc, unit_cost, buttons]).draw();
          }
          // else // remove item
          // {
          //   table.row(selectedRow).remove().draw();
            
          //   var i;
          //   var r = 1;

          //   for(i = 0; i < $('#tbl_itemlist').DataTable().rows().count(); i ++)
          //   {
          //     table.cell({row:i, column:0}).data(r);
          //     r++;
          //   }
          //   alert('Successfully deleted.');
          // }


          // total_amount();
          clear();

          if(type == 'sc-textitem') // save and close
          {
              $('#enteritem-modal').modal('toggle');
          }
          else
          {
              let line = ($('#tbl_itemlist').DataTable().rows().count()) + 1;
              $('input[name="txt_lineno_text"]').val(line);
              $('input[name="txt_itemcode_text"]').val('TEXT-ITEM');
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
          else
          {
            console.log('fail');
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

        $('input[name="txt_lineno_text"]').val('');
        $('input[name="txt_itemcode_text"]').val('');
        $('input[name="txt_partno_text"]').val('');
        $('input[name="txt_serialno_text"]').val('');
        $('input[name="txt_tagno_text"]').val('');
        $('textarea[name="txt_description_text"]').val('');
        $('input[name="txt_qty_text"]').val('0');
        $('input[name="txt_unitcost_text"]').val('0');
        $('select[name="unit_desc_text"]').val('').trigger('change');
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
                      desig: $('input[name="select_receivedbydesig"]').val(),
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
                      desig: $('input[name="select_receivedbydesig"]').val()
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
                  console.log(data[0]);
                  console.log(data[1]);
                  console.log(data[2]);
                  for(var i = 0; i < dataar.length; i++)
                  {
                    loadedPrice = dataar[i].price;
                    if(loadedPrice == null){
                      priceVal = 0;
                    }
                    else
                    {
                      priceVal = dataar[i].price;
                    }
                    var price = priceVal;
                    var line = ($('#tbl_itemlist').DataTable().rows().count()) + 1;
                    tbl_risitemlist.row.add(['<input type="checkbox" id="chk_risitems" class="chk_risitems" value="'+dataar[i].ln_num+'">',
                                             dataar[i].ln_num, 
                                             dataar[i].item_code,
                                             dataar[i].part_no,
                                             dataar[i].serial_no,
                                             dataar[i].tag_no,
                                             dataar[i].item_desc,
                                             dataar[i].issued_qty,
                                             dataar[i].unit_code,
                                             dataar[i].unit_desc,
                                             price
                                            ]).draw();
                  }

                  $('select[name="select_costcenter"]').val(data[1]).trigger('change');
                  $('select[name=select_personnel]').val($('[name=select_ris]').find('option:selected').attr('personneltoreceive')).trigger('change');
                  $('input[name="select_receivedbydesig"]').val(data[2]);

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
                   loadedPrice = a.price;
                    if(loadedPrice == null){
                      priceVal = 0;
                    }
                    else
                    {
                      priceVal = a.price;
                    }
                    var price = priceVal;
                  var line = ($('#tbl_itemlist').DataTable().rows().count()) + 1;
                  tbl_itemlist.row.add([line, a.item_code, a.part_no, a.serial_no, a.tag_no, a.item_desc, a.issued_qty, a.unit_code, a.unit_desc,price, 
                  '<center>' +
                    '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit( \''+line+'\');"></i></a>&nbsp;' +
                    '<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete(\''+line+'\');"></i></a>' +
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