@extends('_main')
@if($isnew)
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Turn Over','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Create','icon'=>'none','st'=>true],
    ];
    $_ch = "Turn Over"; // Module Name
@endphp
@else
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Turn Over Info','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Edit','icon'=>'none','st'=>true],
    ];
    $_ch = "Turn Over"; // Module Name
@endphp
@endif
@section('content')
    <!-- Content Header (Page header) -->
    @include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
        
        <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Turn Over Info</h3>
                  @if(!$isnew)
                    <input type="hidden" name="txt_code" value="{{$rechdr->rec_num}}">
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
                            <label>Reference</label>
                                @if($isnew)
                                    <input type="text" class="form-control" name="_reference" data-parsley-errors-container="#validate_to_received">
                                @else
                                    <input type="text" class="form-control" name="_reference" value="{{$rechdr->_reference}}" data-parsley-errors-container="#validat__reference">
                                @endif
                                    <span id="#validate__reference"></span>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Received By</label>
                                @if($isnew)
                                    <input type="text" class="form-control" name="to_receivedby" data-parsley-errors-container="#validate_to_received">
                                @else
                                    <input type="text" class="form-control" name="to_receivedby" value="{{$rechdr->to_receivedby}}" data-parsley-errors-container="#validate_to_receivedby">
                                @endif
                                    <span id="#validate_to_receivedby"></span>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Turned Over By</label>
                                @if($isnew)
                                    <input type="text" class="form-control" name="to_by" data-parsley-errors-container="#validate_to_by">
                                @else
                                    <input type="text" class="form-control" name="to_by" value="{{$rechdr->to_by}}" data-parsley-errors-container="#validate_to_by">
                                @endif
                                    <span id="#validate_to_by"></span>
                          </div>
                        </div>
                    </div>
                    <div class="row">
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
                                <label>Turn Over Date</label>
                                    <div class="input-group date">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                    @if($isnew)
                                        <input type="date" name="to_date" class="form-control pull-right" id="datepicker" data-parsley-errors-container="#validate_to_date" data-parsley-required-message="<strong>ARE date is required.</strong>" required>
                                    @else
                                        <input type="date" name="to_date" class="form-control pull-right" id="datepicker" value="{{$rechdr->to_date}}" data-parsley-errors-container="#validate_to_date" data-parsley-required-message="<strong>ARE date is required.</strong>" required>
                                    @endif
                                            <span id="#validate_to_date"></span> 
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>User ID</label>
                            @if($isnew)
                                <input type="text" class="form-control" name="recipient" data-parsley-errors-container="#validate_recipient" readonly="">
                            @else
                                <input type="text" class="form-control" name="recipient" value="{{$rechdr->recipient}}" data-parsley-errors-container="#validate_recipient" readonly="">
                            @endif
                                <span id="#validate_recipient"></span>
                            </div>
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
                              <th>Article</th>
                              <th>Qty.</th>
                              <th>Description</th>
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
                                <td>{{$rl->to_article}}</td>
                                <td>{{$rl->recv_qty}}</td>
                                <td>{{$rl->item_desc}}</td>
                                <td>{{$rl->notes}}</td>
                                <td>
                                    <center>
                                        <a class="btn btn-social-icon btn-warning">
                                            <i class="fa fa-pencil" onclick="EnterItem_Edit({{$rl->ln_num}}, '{{$rl->item_code}}');"></i>
                                        </a>&nbsp;
                                        <a class="btn btn-social-icon btn-danger">
                                            <i class="fa fa-trash" onclick="EnterItem_Delete({{$rl->ln_num}}, '{{$rl->item_code}}');"></i>
                                        </a>
                                    </center>
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
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group" style="display: flex;">
                                <a href="{{route('inventory.turnover')}}" class="btn btn-block btn-primary"><i class="fa fa-arrow-left"></i> Go Back</a>
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
            </div>
        </div>

         <!-- /.modal -->
        <!-- Enter Item Modal Form -->
        <div class="row">
            <div class="modal fade in" id="enteritem-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                            <h4 class="modal-title"><span id="ENTER_ITEM"></span> Item</h4>
                        </div>
                        <div class="modal-body">
                            <span class="AddMode EditMode">
                                <form id="add-form" data-parsley-validate novalidate>
                                    <div class="box-body">

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Line No.</label>
                                                    <input type="text" class="form-control" name="txt_lineno" readonly="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Item Code</label>
                                                    <input type="text" class="form-control" name="txt_itemcode" readonly=""> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Article</label>
                                                    <input type="text" class="form-control" name="txt_to_article">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Quantity</label>
                                                    <input id="txt_qty" type="number" class="form-control" name="txt_recv_qty" step="any" placeholder="0.00" data-parsley-errors-container="#validate_iqty" data-parsley-required-message="<strong>Quantity is required.</strong>" required>
                                                    <span class="validate_iqty"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <input type="text" class="form-control" name="text_item_desc">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
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
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Line No.</label>
                                                    <input type="text" class="form-control" name="txt_lineno_text" readonly="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Item Code</label>
                                                    <input type="text" class="form-control" name="txt_itemcode_text" readonly=""> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Article</label>
                                                    <input type="text" class="form-control" name="txt_to_article_text">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Quantity</label>
                                                    <input id="txt_qty" type="number" class="form-control" name="txt_recv_qty_text" step="any" placeholder="0.00" data-parsley-errors-container="#validate_iqty" data-parsley-required-message="<strong>Quantity is required.</strong>" required>
                                                    <span class="validate_iqty"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <input type="text" class="form-control" name="txt_item_desc_text">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
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

                        </div><!--Modal body-->

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
                        </div><!--Modal footer-->

                    </div><!--Modal content-->
                </div><!--Modal dialog-->
            </div><!--modal fade in-->
        </div><!--row-->
        <!-- End Modal -->

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

        function EnterItem_Add(code, to_article, recv_qty, item_desc, notes, type)
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
              $('input[name="txt_to_article"]').val(to_article);
              $('input[name="txt_recv_qty"]').val(recv_qty);
              $('input[name="text_item_desc"]').val(item_desc);
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
              $('input[name="txt_to_article_text"]').val(data[2]);
              $('input[name="txt_recv_qty_text"]').val(data[3]);
              $('input[name="txt_item_desc_text"]').val(data[4]);
              $('input[name="txt_notes_text"]').val(data[5]); 

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
              $('input[name="txt_to_article"]').val(data[2]);
              $('input[name="txt_recv_qty"]').val(data[3]);
              $('input[name="text_item_desc"]').val(data[4]);
              $('input[name="txt_notes"]').val(data[5]); 

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
                var to_article = $('input[name="txt_to_article"]').val();
                var recv_qty = $('input[name="txt_recv_qty"]').val();
                var item_desc = $('input[name="text_item_desc"]').val();
                var notes = $('input[name="txt_notes"]').val();
                var buttons = '<center>' +
                  '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit( \''+line+'\', \''+item_code+'\');"></i></a>&nbsp;' +
                                '<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete(\''+line+'\');"></i></a>' +
                '</center>';

                if($('#ENTER_ITEM').text() == 'Add')
                { 
                  table.row.add([line, item_code, to_article, recv_qty, item_desc, notes, buttons]).draw();
                }
                else if($('#ENTER_ITEM').text() == 'Edit')
                {
                  table.row(selectedRow).data([line, item_code, to_article, recv_qty, item_desc, notes, buttons]).draw();
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
                var to_article = $('input[name="txt_to_article_text"]').val();
                var recv_qty = $('input[name="txt_recv_qty_text"]').val();
                var item_desc = $('input[name="txt_item_desc_text"]').val();
                var notes = $('input[name="txt_notes_text"]').val();
                var buttons = '<center>' +
                  '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit( \''+line+'\', \''+item_code+'\');"></i></a>&nbsp;' +
                                '<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete(\''+line+'\');"></i></a>' +
                '</center>';

                if($('#ENTER_ITEM').text() == 'Add Text')
                { 
                  var test = [line, item_code, to_article, recv_qty, item_desc, notes, buttons];

                  console.log(test);
                  table.row.add([line, item_code, to_article, recv_qty, item_desc, notes, buttons]).draw();
                }
                else if($('#ENTER_ITEM').text() == 'Edit Text')
                {
                  table.row(selectedRow).data([line, item_code, to_article, recv_qty, item_desc, notes, buttons]).draw();
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
            $('input[name="txt_to_article"]').val('');
            $('input[name="txt_recv_qty"]').val('0.00');
            $('input[name="text_item_desc"]').val('');
            $('input[name="txt_notes"]').val('');

            $('input[name="txt_lineno_text"]').val('');
            $('input[name="txt_itemcode_text"]').val('');
            $('input[name="txt_to_article_text"]').val('');
            $('input[name="txt_recv_qty_text"]').val('0.00');
            $('input[name="txt_item_desc_text"]').val('');
            $('input[name="txt_notes_text"]').val('');
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
                                  _reference: $('input[name="_reference"]').val(),
                                  to_receivedby: $('input[name="to_receivedby"]').val(),
                                  to_by: $('input[name="to_by"]').val(),
                                  cc_code: $('select[name="cc_code"]').select2('data')[0].id,
                                  to_date: $('input[name="to_date"]').val(),                                  
                                  recipient: $('input[name="recipient"]').val(),
                               };

                       $.ajax({
                              url: '{{route('inventory.turnover_entry')}}',
                              method: 'POST',
                              data: data,
                              success : function(flag)
                                       {
                                          if(flag == 'true')
                                          {
                                            location.href= "{{route('inventory.turnover')}}";
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
                          _reference: $('input[name="_reference"]').val(),
                          to_date: $('input[name="to_date"]').val(),
                          to_by: $('input[name="to_by"]').val(),
                          cc_code: $('select[name="cc_code"]').select2('data')[0].id,
                          to_receivedby: $('input[name="to_receivedby"]').val(),
                          recipient: $('input[name="recipient"]').val(),
                       };

                 $.ajax({
                      url: '{{asset('inventory/turnover/turnover_edit')}}/' +rec_num,
                      method: 'POST',
                      data: data,
                      success : function(flag)
                               {
                                  if(flag == 'true')
                                  {
                                    console.log(flag);
                                    location.href= "{{route('inventory.turnover')}}";
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