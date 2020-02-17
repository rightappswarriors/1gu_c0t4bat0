@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Property Acknowledgment Receipt','icon'=>'none','st'=>false],
        $toolbar,
    ];
    $_ch = "Property Acknowledgment Receipt"; // Module Name
@endphp
@section('content')
		<!-- Content Header (Page header) -->
		@include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Property Acknowledgment Receipt Info</h3>

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
              <div class="form-group" hidden="">
                <label>Code</label>
                @if($isnew)
                <input type="text" class="form-control" name="" disabled="">
                @else
                <input type="text" class="form-control" name="txt_code" value="{{$rechdr->rec_num}}" disabled="">
                @endif
              </div>
              <div class="form-group" >
                <label>PAR NO</label>
                @if($isnew)
                <input type="text" class="form-control" name="txt_par">
                @else
                <input type="text" class="form-control" name="txt_par" value="{{$rechdr->purc_ord}}" disabled="">
                @endif
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Entity Name</label>
                @if($isnew)
                <input type="text" class="form-control" name="txt_reference" data-parsley-errors-container="#validate_txtreference" {{-- data-parsley-required-message="<strong>Reference is required.</strong>" required --}}>
                @else
                <input type="text" class="form-control" name="txt_reference" value="{{$rechdr->_reference}}" data-parsley-errors-container="#validate_txtreference" {{-- data-parsley-required-message="<strong>Reference is required.</strong>" required --}}>
                @endif
                <span id="validate_txtreference"></span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>PAR Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  @if($isnew)
                  <input type="date" name="dtp_invoicedt" class="form-control pull-right" id="datepicker" data-parsley-errors-container="#validate_invoicedt" {{-- data-parsley-required-message="<strong>ARE date is required.</strong>" required --}}>
                  @else
                  <input type="date" class="form-control pull-right" id="datepicker" name="dtp_invoicedt" value="{{$rechdr->trnx_date}}" data-parsley-errors-container="#validate_invoicedt" {{-- data-parsley-required-message="<strong>ARE date is required.</strong>" required --}}>
                  @endif
                </div>
                <span id="validate_invoicedt"></span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Fund Cluster</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_costcenter" data-parsley-errors-container="#validate_selectcostcenter" data-parsley-required-message="<strong>Office is required.</strong>" required>
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
          </div>
          <div class="row">
            {{-- <div class="col-md-3">
              <div class="form-group">
                <label>Received From</label>
                
                @if($isnew)
                  <input list="select_receivedfrom" name="select_receivedfrom" style="width: 100%;" data-parsley-errors-container="#validate_selectreceivedfrom" data-parsley-required-message="<strong>Received From is required.</strong>" required>
                @else
                  <input list="select_receivedfrom" name="select_receivedfrom" value="{{$rechdr->are_receivedfrom}}" style="width: 100%;" data-parsley-errors-container="#validate_selectreceivedfrom" data-parsley-required-message="<strong>Received From is required.</strong>" required>
                @endif  

                <datalist id="select_receivedfrom">
                  @foreach($are_users as $au)
                    <option value="{{$au->name}}">
                  @endforeach
                </datalist>
                <span id="validate_selectreceivedfrom"></span>

                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_receivedfrom" data-parsley-errors-container="#validate_selectreceivedfrom" data-parsley-required-message="<strong>Received From is required.</strong>" required>
                  @if($isnew)
                    <option value="" selected="selected">--- Select Received From ---</option>
                    @foreach($x08 as $x8)
                    <option value="{{$x8->uid}}">{{$x8->opr_name}}</option>
                    @endforeach
                  @else
                    @foreach($x08 as $x8)
                      @if($rechdr->are_receivedfrom == $x8->uid)
                       <option selected = "selected" value="{{$x8->uid}}">{{$x8->opr_name}}</option>
                      @else
                       <option value="{{$x8->uid}}">{{$x8->opr_name}}</option>
                      @endif
                    @endforeach
                  @endif
                </select>
                <span id="validate_selectreceivedfrom"></span>
              </div>
            </div> --}}
            <div class="col-md-3">
              <div class="form-group">
                <label>Issued To</label>

                @if($isnew)
                  <input list="select_issuedto" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_issuedto" data-parsley-errors-container="#validate_selectissuedto" data-parsley-required-message="<strong>Issued To is required.</strong>" required>
                @else
                  <input list="select_issuedto" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_issuedto" value = "{{$rechdr->are_issuedto}}" data-parsley-errors-container="#validate_selectissuedto" data-parsley-required-message="<strong>Issued To is required.</strong>" required>
                @endif

                <datalist id="select_issuedto">
                  @foreach($are_users as $au)
                    <option value="{{$au->name}}">
                  @endforeach
                </datalist>
                <span id="validate_selectissuedto"></span>

              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Received By</label>

                @if($isnew)
                  <input list="select_receivedby" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_receivedby" data-parsley-errors-container="#validate_selectreceivedby" data-parsley-required-message="<strong>Received By is required.</strong>" required>
                @else
                  <input list="select_receivedby" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_receivedby" value = "{{$rechdr->are_receivedby}}" data-parsley-errors-container="#validate_selectreceivedby" data-parsley-required-message="<strong>Received By is required.</strong>" required>
                @endif  

                <datalist id="select_receivedby">
                  @foreach($are_users as $au)
                    <option value="{{$au->name}}">
                  @endforeach
                </datalist>
                <span id="validate_selectreceivedby"></span>

              </div>
            </div>
          </div>
          <div class="row">
            {{-- <div class="col-md-3">
              <div class="form-group">
                <label>Received From Designation</label>

                @if($isnew)
                  <input list="select_receivedfromdesig" name="select_receivedfromdesig" style="width: 100%;" data-parsley-errors-container="#validate_selectreceivedfromdesig" data-parsley-required-message="<strong>Received From Designation is required.</strong>" required>
                @else
                  <input list="select_receivedfromdesig" name="select_receivedfromdesig" value="{{$rechdr->are_receivedfromdesig}}" style="width: 100%;" data-parsley-errors-container="#validate_selectreceivedfromdesig" data-parsley-required-message="<strong>Received From Designation is required.</strong>" required>
                @endif

                <datalist id="select_receivedfromdesig">
                  @foreach($are_position as $ap)
                    <option value="{{$ap->name}}">
                  @endforeach
                </datalist>
                <span id="validate_selectreceivedfromdesig"></span>
              </div>
            </div> --}}
            <div class="col-md-3">
              <div class="form-group">
                <label>Issued To Designation</label>

                @if($isnew)
                  <input list="select_issuedtodesig" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_issuedtodesig" data-parsley-errors-container="#validate_selectissuedtodesig" data-parsley-required-message="<strong>Issued To Designation is required.</strong>" required>
                @else
                  <input list="select_issuedtodesig" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_issuedtodesig" value="{{$rechdr->are_issuedtodesig}}" data-parsley-errors-container="#validate_selectissuedtodesig" data-parsley-required-message="<strong>Issued To Designation is required.</strong>" required>
                @endif  

                <datalist id="select_issuedtodesig">
                  @foreach($are_position as $ap)
                    <option value="{{$ap->name}}">
                  @endforeach
                </datalist>
                <span id="validate_selectissuedtodesig"></span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Received By Designation</label>

                @if($isnew)
                  <input list="select_receivedbydesig" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_receivedbydesig" data-parsley-errors-container="#validate_selectreceivedbydesig" data-parsley-required-message="<strong>Received By Designation is required.</strong>" required>
                @else
                  <input list="select_receivedbydesig" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_receivedbydesig" value="{{$rechdr->are_receivebydesig}}" data-parsley-errors-container="#validate_selectreceivedbydesig" data-parsley-required-message="<strong>Received By Designation is required.</strong>" required>
                @endif  
                <datalist id="select_receivedbydesig">
                  @foreach($are_position as $ap)
                    <option value="{{$ap->name}}">
                  @endforeach
                </datalist>
                <span id="validate_selectreceivedbydesig"></span>
              </div>
            </div>
          </div>
          {{-- <div class="row"> --}}
            
            {{-- <div class="col-md-3">
              <div class="form-group">
                <label>RIS NO</label>
                @if($isnew)
                <input type="text" class="form-control" name="txt_ris_no">
                @else
                <input type="text" class="form-control" name="txt_ris_no" value="{{$rechdr->ris_no}}">
                @endif
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>SAI NO</label>
                @if($isnew)
                <input type="text" class="form-control" name="txt_sai_no">
                @else
                <input type="text" class="form-control" name="txt_sai_no" value="{{$rechdr->sai_no}}">
                @endif
              </div>
            </div> --}}
          {{-- </div> --}}
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
                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemsearch-modal"><i class="fa fa-plus"></i> Add item</button> --}}
                    <button type="button" class="btn btn-warning" onclick="EnterItem_Add('', '', '', '', '', '', '', 'TEXT-ITEM')"><i class="fa fa-plus"></i> Add Text Item</button>
                </div>
                <div class="col-sm-6">
                  <!-- <h5 class="box-title">Total amount:</h5>
                    &nbsp;<label><input type="text" name="txt_grandtotalamt" readonly=""></label> -->
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
                              <td><input type="radio" name="r3" onclick="EnterItem_Add('{{$di->item_code}}', '{{$di->part_no}}', '{{$di->item_desc}}', '{{$di->sales_unit_id}}', '{{$di->serial_no}}', '{{$di->tag_no}}', '{{$di->regular}}', 'ITEM')"></td>
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
                  <th>Cost Price</th>
                  <th>Line Amount</th>
                  <th>Acquired Date</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  @if(!$isnew)
                  @isset($reclne)
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
                    <td>{{$rl->ln_amnt}}</td>
                    <td>{{$rl->ir_date}}</td>
                    <td><center><a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit({{$rl->ln_num}}, '{{$rl->item_code}}');"></i></a>&nbsp;<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete({{$rl->ln_num}}, '{{$rl->item_code}}');"></i></a></center>
                  </td>
                  </tr>  
                  @endforeach
                  @endisset
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
                <a href="{{route('inventory.par')}}" class="btn btn-block btn-primary"><i class="fa fa-arrow-left"></i> Go Back</a>
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
                        <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Quantity</label>
                                <input id="txt_qty" type="number" class="form-control" name="txt_qty" step="any" placeholder="0.00" data-parsley-errors-container="#validate_iqty" data-parsley-required-message="<strong>Quantity is required.</strong>" required>
                                <span class="validate_iqty"></span>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Unit Measurement</label>
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_unit" data-parsley-errors-container="#validate_iitemunit" data-parsley-required-message="<strong>Unit Measurement is required.</strong>" required>
                                  <option value="" selected="selected">--- Select Unit ---</option>
                                  @foreach($itemunit as $iu)
                                  <option value="{{$iu->unit_id}}">{{$iu->unit_shortcode}}</option>
                                  @endforeach
                                </select>
                                <span class="validate_iitemunit"></span>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Cost Price</label>
                               <input id="txt_cost" type="number" class="form-control" name="txt_cost" step="any" placeholder="0.00" data-parsley-errors-container="#validate_icostprice" data-parsley-required-message="<strong>Cost Price is required.</strong>" required>
                               <span class="validate_icostprice"></span>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Line Amount</label>
                               <input type="text" class="form-control" name="txt_lineamt" placeholder="0.00" readonly="">
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
                          <div class="col-sm-8">
                            <div class="form-group">
                              <label>Item Code</label>
                              <input type="text" class="form-control" name="txt_itemcode_text" readonly="">
                            </div>
                          </div>                      
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>Property No.</label>
                             {{--  <input type="text" class="form-control" name="txt_partno_text"> --}}
                              <div><textarea id="txt_partno_text" class="form-control" name="txt_partno_text" rows="4" cols="88"></textarea></div>
                            </div>
                          </div>  
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Date Acquired</label>
                              <div><input type="date" name="dtp_acqdate" class="form-control pull-right" id="datepicker"></div>
                            </div>
                          </div>  
                          <div class="col-sm-4" hidden="">
                            <div class="form-group">
                              <label>Serial No.</label>
                              <input style="width: 259px;" type="text" class="form-control" name="txt_serialno_text">
                            </div>
                            <div class="form-group">
                              <label>Tag No.</label>
                              <input style="width: 259px;" type="text" class="form-control" name="txt_tagno_text">
                            </div>
                          </div>                          
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label>Item Description</label>
                              <div><textarea id="txt_itemdesc_text" class="form-control" name="txt_itemdesc_text" rows="4" cols="88"></textarea></div>
                            </div>
                          </div>
                          <div class="col-sm-3">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Quantity</label>
                                <input id="txt_qty_text" type="number" class="form-control" name="txt_qty_text" step="any" placeholder="0.00" data-parsley-errors-container="#validate_iqty_text" data-parsley-required-message="<strong>Quantity is required.</strong>" required>
                                <span class="validate_iqty_text"></span>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Unit Measurement</label>
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_unit_text" data-parsley-errors-container="#validate_iitemunit_text" data-parsley-required-message="<strong>Unit Measurement is required.</strong>" required>
                                  <option value="" selected="selected">--- Select Unit ---</option>
                                  @foreach($itemunit as $iu)
                                  <option value="{{$iu->unit_id}}">{{$iu->unit_shortcode}}</option>
                                  @endforeach
                                </select>
                                <span class="validate_iitemunit_text"></span>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Cost Price</label>
                               <input id="txt_cost_text" type="number" class="form-control" name="txt_cost_text" step="any" placeholder="0.00" data-parsley-errors-container="#validate_icostprice_text" data-parsley-required-message="<strong>Cost Price is required.</strong>" required>
                               <span class="validate_icostprice_text"></span>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Line Amount</label>
                               <input type="text" class="form-control" name="txt_lineamt_text" placeholder="0.00" readonly="">
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


      function EnterItem_Add(code, part_no, item_desc, unit, serial_no, tag_no, costprice, type)
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
          $('input[name="txt_part_no"]').val(part_no);
          $('input[name="txt_itemdesc"]').val(item_desc);
          $('input[name="txt_partno"]').val(part_no);
          $('input[name="txt_serialno"]').val(serial_no);
          $('input[name="txt_tagno"]').val(tag_no);
          $('input[name="txt_cost"]').val(costprice);
          $('select[name="select_unit"]').val(unit).trigger('change');
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
          $('textarea[name="txt_partno_text"]').val(data[2]);
          $('input[name="txt_serialno_text"]').val(data[3]);
          $('input[name="txt_tagno_text"]').val(data[4]);
          $('textarea[name="txt_itemdesc_text"]').val(data[5]);
          $('input[name="txt_qty_text"]').val(data[6]);
          $('select[name="select_unit_text"]').val(data[7]).trigger('change');
          $('input[name="txt_cost_text"]').val(data[9]);
          $('input[name="txt_lineamt_text"]').val(data[10]);
          $('input[name="dtp_acqdate"]').val(data[11]);

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
          
          $('input[name="txt_lineno"]').val(data[0]);
          $('input[name="txt_itemcode"]').val(data[1]);
          $('input[name="txt_partno"]').val(data[2]);
          $('input[name="txt_serialno"]').val(data[3]);
          $('input[name="txt_tagno"]').val(data[4]);
          $('input[name="txt_itemdesc"]').val(data[5]);
          $('input[name="txt_qty"]').val(data[6]);
          $('select[name="select_unit"]').val(data[7]).trigger('change');
          $('input[name="txt_cost"]').val(data[9]);
          $('input[name="txt_lineamt"]').val(data[10]);

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
            var part_no = $('input[name="txt_partno"]').val();
            var serial_no = $('input[name="txt_serialno"]').val();
            var tag_no = $('input[name="txt_tagno"]').val();
            var item_desc = $('input[name="txt_itemdesc"]').val();
            var qty = $('input[name="txt_qty"]').val();
            var unit_code = $('select[name="select_unit"]').select2('data')[0].id;
            var unit_desc = $('select[name="select_unit"]').select2('data')[0].text;
            var cost_price = $('input[name="txt_cost"]').val();
            var line_amt = $('input[name="txt_lineamt"]').val();
            var acqdate = $('input[name="dtp_acqdate"]').val();
            var buttons = '<center>' +
              '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit( \''+line+'\', \''+item_code+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete(\''+line+'\');"></i></a>' +
            '</center>';

            if($('#ENTER_ITEM').text() == 'Add')
            { 
              table.row.add([line, item_code, part_no, serial_no, tag_no, item_desc, qty, unit_code, unit_desc, cost_price, line_amt, acqdate, buttons]).draw();
            }
            else if($('#ENTER_ITEM').text() == 'Edit')
            {
              table.row(selectedRow).data([line, item_code, part_no, serial_no, tag_no, item_desc, qty, unit_code, unit_desc, cost_price, line_amt, acqdate, buttons]).draw();
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
            var part_no = $('textarea[name="txt_partno_text"]').val();
            var serial_no = $('input[name="txt_serialno_text"]').val();
            var tag_no = $('input[name="txt_tagno_text"]').val();
            var item_desc = $('textarea[name="txt_itemdesc_text"]').val();
            var qty = $('input[name="txt_qty_text"]').val();
            var unit_code = $('select[name="select_unit_text"]').select2('data')[0].id;
            var unit_desc = $('select[name="select_unit_text"]').select2('data')[0].text;
            var cost_price = $('input[name="txt_cost_text"]').val();
            var line_amt = $('input[name="txt_lineamt_text"]').val();
            var acqdate = $('input[name="dtp_acqdate"]').val();
            var buttons = '<center>' +
              '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit( \''+line+'\', \''+item_code+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete(\''+line+'\', \''+item_code+'\');"></i></a>' +
            '</center>';

            if($('#ENTER_ITEM').text() == 'Add Text')
            { 
              table.row.add([line, item_code, part_no, serial_no, tag_no, item_desc, qty, unit_code, unit_desc, cost_price, line_amt, acqdate, buttons]).draw();
            }
            else if($('#ENTER_ITEM').text() == 'Edit Text')
            {
              table.row(selectedRow).data([line, item_code, part_no, serial_no, tag_no, item_desc, qty, unit_code, unit_desc, cost_price, line_amt, acqdate, buttons]).draw();
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
        $('input[name="txt_partno"]').val('');
        $('input[name="txt_serialno"]').val('');
        $('input[name="txt_tagno"]').val('');
        $('input[name="txt_itemdesc"]').val('');
        $('input[name="txt_qty"]').val('0.00');
        $('select[name="select_unit"]').val('').trigger('change');
        $('input[name="txt_cost"]').val('0.00');
        $('input[name="txt_lineamt"]').val('0.00');

        $('input[name="txt_lineno_text"]').val('');
        $('input[name="txt_itemcode_text"]').val('');
        $('textarea[name="txt_partno_text"]').val('');
        $('input[name="txt_serialno_text"]').val('');
        $('input[name="txt_tagno_text"]').val('');
        $('textarea[name="txt_itemdesc_text"]').val('');
        $('input[name="txt_qty_text"]').val('0');
        $('select[name="select_unit_text"]').val('').trigger('change');
        $('input[name="txt_cost_text"]').val('0.00');
        $('input[name="txt_lineamt_text"]').val('0.00');

        $('input[name="dtp_acqdate"]').val('');

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
                          invoicedt: $('input[name="dtp_invoicedt"]').val(),
                          costcenter: $('select[name="select_costcenter"]').select2('data')[0].id,
                          par: $('input[name="txt_par"]').val(),
                          reference: $('input[name="txt_reference"]').val(),
                          receivedby: $('input[name="select_receivedby"]').val(),
                          // receivedfrom: $('input[name="select_receivedfrom"]').val(),
                          issuedto: $('input[name="select_issuedto"]').val(),
                          receivedbydesig: $('input[name="select_receivedbydesig"]').val(),
                          // receivedfromdesig: $('input[name="select_receivedfromdesig"]').val(),
                          issuedtodesig: $('input[name="select_issuedtodesig"]').val(),
                       };
    
               $.ajax({
                      url: '{{route('inventory.par_add')}}',
                      method: 'POST',
                      data: data,
                      success : function(flag)
                               {
                                  if(flag == 'true')
                                  {
                                    location.href= "{{route('inventory.par')}}";
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
                      invoicedt: $('input[name="dtp_invoicedt"]').val(),
                      costcenter: $('select[name="select_costcenter"]').select2('data')[0].id,
                      par: $('input[name="txt_par"]').val(),
                      reference: $('input[name="txt_reference"]').val(),
                      receivedby: $('input[name="select_receivedby"]').val(),
                      // receivedfrom: $('input[name="select_receivedfrom"]').val(),
                      issuedto: $('input[name="select_issuedto"]').val(),
                      receivedbydesig: $('input[name="select_receivedbydesig"]').val(),
                      // receivedfromdesig: $('input[name="select_receivedfromdesig"]').val(),
                      issuedtodesig: $('input[name="select_issuedtodesig"]').val(),
                   };

             $.ajax({
                  url: '{{asset('inventory/par/par_edit')}}/'+rec_num,
                  method: 'POST',
                  data: data,
                  success : function(flag)
                           {
                              if(flag == 'true')
                              {
                                console.log(flag);
                                location.href= "{{route('inventory.par')}}";
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