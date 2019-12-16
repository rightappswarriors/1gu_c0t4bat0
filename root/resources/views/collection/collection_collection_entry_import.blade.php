@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'City Treasurer','icon'=>'none','st'=>false],
        // ['link'=>'#','desc'=>'Collection Entry','icon'=>'none','st'=>false],
        ['link'=>url("accounting/collection/entry"),'desc'=>'Collection Entry','icon'=>'none','st'=>true],
        ['link'=>'#','desc'=>'Import','icon'=>'none','st'=>false],
    ];
    $_ch = "Import"; // Module Name
@endphp
@section('content')
		<!-- Content Header (Page header) -->
		@include('layout._contentheader')
        <!-- Main content -->
    <section class="content">
      <div class="box box-default collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title">Options</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="display: none">
          <form id="PerFuMndCheck" data-parsley-validate novalidate>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <span id="sel_fy_span"></span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <span id="sel_fid_span"></span>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <center><label>&nbsp;</label></center>
                <button type="button" class="btn btn-block btn-primary" onclick="newBudgetEntry()"><i class="fa fa-plus"></i> New Collection Entry</button>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <center><label>&nbsp;</label></center>
                <button type="button" class="btn btn-block btn-info"    ><i class="fa fa-print"></i> Print</button>
              </div>
            </div>
            <div class="col-sm-2" style="display: none">
              <div class="form-group">
                <center><label>&nbsp;</label></center>
                <button type="button" class="btn btn-block btn-default" data-toggle="modal" data-target="#modal-default2"><i class="fa fa-upload"></i> Import</button>
              </div>
            </div>
          </div>
          </form>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      {{-- <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Import</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            </div>
            <!-- /.box-body -->

          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div> --}}
      <!-- /.row -->
      <form id="he" action="{{url('accounting/collection/saveimport')}}" method="post">
        {{csrf_field()}}
        <span id="ShowAll">
                    

          
        </span>

      </form>
    </section>
<div class="modal fade in" id="modal-default2">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Import <span id=""></span></h4>
          </div>
          <div class="modal-body">
              <div class="box-body">
                <form id="ItmForm2" novalidate data-parsley-validate>
                      {{-- <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                              <label>Journal <span style="color:red"><strong>*</strong></span></label>
                              <select class="form-control select2 select2-hidden-accessible" name="itm_col" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_sec_span" data-parsley-required-message="<strong>Journal</strong> is required." required>
                                @isset($m05)
                                  <option value="">Select Journal...</option>
                                    @foreach($m05 as $s)
                                        <option value="{{$s->j_code}}">{{$s->j_desc}}</option>
                                    @endforeach
                                @else
                                  <option value="">No Journal  registered...</option>
                                @endisset
                              </select>
                              <span id="hdr_sec_span"></span>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                              <label>Fund <span style="color:red"><strong>*</strong></span></label>
                              <select class="form-control select2 select2-hidden-accessible" name="itm_fund" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Fund</strong> is required." data-parsley-errors-container="#budget_period_span" required>
                                  @isset($fund)
                                      <option value="">Select Fund...</option>
                                      @foreach($fund as $bp)
                                        <option value="{{$bp->fid}}">{{$bp->fdesc}}</option>
                                      @endforeach
                                  @else
                                      <option value="">No Fund registered...</option>
                                  @endisset
                              </select>
                              <span id="budget_period_span"></span>
                          </div>
                      </div>
                      </div> --}}
                      <div class="row">
                          <div class="col-sm-12">
                              <div class="form-group">
                                  <label>&nbsp;</label>
                                  <input type="file" class="form-control" name="itm_import" data-parsley-required-message="<strong>CSV file</strong> is required." accept=".csv" required>
                              </div>
                          </div>
                      </div>
                      {{-- <div class="row" id="importErrorRow">
                        <div class="col-md-12">
                          <div class="box box-danger collapsed-box">
                            <div class="box-header with-border">
                              <h3 class="box-title"><strong id="importErrorNum" style="color:red">0</strong> error/s occured during import.</h3>

                              <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                              </div>
                              <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body" id="importErrorBody" style="display: none;height: 150px; overflow-y: scroll;">
                              
                            </div>
                            <!-- /.box-body -->
                          </div>
                          <!-- /.box -->
                        </div>
                      </div> --}}
                  </form>
              </div>
          </div>
          <div class="modal-footer">
            {{-- <i class="fa fa-refresh fa-spin"></i> --}}
            <button type="button" onclick="SubmitImport()" class="btn btn-success"><i id="leIcoN" class="fa fa-plus"></i><i id="leIcoN2" class="fa fa-refresh fa-spin" hidden></i> <span>Import</span></button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
          </div>
      </div>
      <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade in" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      {{-- MODAL HEADER --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Payment <span id="MOD_MODE"></span></h4>
      </div>
      {{-- MODAL HEADER --}}
      {{-- MODAL BODY --}}
      <div class="modal-body">
        <div class="box-body">
          <form id="ItmForm" novalidate data-parsley-validate>

            <span class="AddMode EditMode">
              <div class="row" hidden="">
                <input type="text" name="itm_tbl_or_no">
                <input type="text" name="itm_tbl_no">
              </div>
              <div class="row" style="display: none">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Line</label>
                        <input type="text" class="form-control" disabled="" name="itm_line">
                            <input type="text" class="form-control" disabled="" name="true_bal" style="display:none">
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                      <label>Local Tin<span style="color:red;"><strong>*</strong></span></label>
                      <input type="text" class="form-control" name="itm_tin" data-parsley-required-message="<strong>Tin</strong> is required." required="">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                      <label>TD# or Bus ID<span style="color:red;display: none"><strong>*</strong></span></label>
                      <input type="text" class="form-control" name="itm_tdbd" data-parsley-required-message="<strong>TD #/Bus ID</strong> is required.">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>{{-- Payment --}}Tax Type<span style="color:red;"><strong>*</strong></span></label>
                    <select name="itm_payment" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#itm_ppa_span" onchange="ifCheck();getPaymentDesc()" data-parsley-required-message="<strong>Tax Type</strong> is required." required>
                      @isset($m04_2)
                        @if(count($m04_2) > 0)
                            <option value="">Select Payment...</option>

                            @foreach($m04_2 AS $m4a1)
                                <option value="{{$m4a1->taxtype_id}}" id="payment_{{$m4a1->taxtype_id}}" c_desc="{{urlencode($m4a1->taxtype_desc)}}">{{$m4a1->taxtype_id}} - {{$m4a1->taxtype_desc}} @isset($m4a1->taxtype_desc)
                                ({{urldecode($m4a1->taxtype_desc)}})@endisset</option>
                            @endforeach
                            
                        @else
                            <option value="">No Payment registered..</option>
                        @endif
                      @else
                          <option value="">No Payment registered..</option>
                      @endisset
                    </select>
                    <span id="itm_ppa_span"></span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                      <label>Description<span style="color:red;"><strong>*</strong></span></label>
                      <input type="text" class="form-control" name="itm_desc" data-parsley-required-message="<strong>Description</strong> is required." required="">
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Type <span style="color:red"><strong>*</strong></span></label>
                    <input type="text" name="itm_type" class="form-control" data-parsley-required-message="<strong>Type</strong> is required." required>
                  </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Payer <span style="color:red"><strong>*</strong></span></label>
                    <input type="text" class="form-control" name="itm_payer"  data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Payer</strong> is required." required>
                  </div>
                </div>
              </div>

              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>Quarter <span style="color:red"><strong>*</strong></span></label>
                          <select name="qtr" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" required>
                           <option value="">Please Select</option>
                           <option otherData="1" value="1st">1st</option>
                           <option otherData="2" value="2nd">2nd</option>
                           <option otherData="3" value="3rd">3rd</option>
                           <option otherData="4" value="4th">4th</option>
                          </select>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group">
                          <label>Year <span style="color:red"><strong>*</strong></span></label>
                          <input type="number" min="1900" max="3000" step="1" value="{{Date('Y')}}" class="form-control" name="dp" required>
                      </div>
                  </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>COA<span style="color:red;display: none"><strong>*</strong></span></label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#itm_acc_title_span" name="itm_soa" data-parsley-required-message="<strong>SOA</strong> is required." onchange="">
                      @isset($soa)
                        @if(count($soa) > 0)
                          <option value="">Select COA...</option>
                          @foreach ($soa as $c)
                            <option value="{{$c->soa_code}}">{{$c->soa_code}}</option>
                          @endforeach
                        @else
                          <option value="">No COA registered..</option>
                        @endif
                      @else
                          <option value="">No COA registered..</option>
                      @endisset
                    </select>
                    <span id="itm_acc_title_span"></span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Amount <span style="color:red"><strong>*</strong></span></label>
                        <input type="number" class="form-control" name="itm_amt" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Amount</strong> is required." required>
                    </div>
                </div>
              </div>
            </span>
            <span class="DeleteMode"  style="display: none">
              <center>
                  <h4 class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                  from Payment list?
                  </h4>
              </center>
            </span>
          </form>
        </div>
      </div>
      {{-- MODAL BODY --}}
      {{-- MODAL FOOTER --}}
      <div class="modal-footer">
          <span class="AddMode EditMode">
              <button type="button" onclick="InsModiItem(0)" class="btn btn-success AddMode"><i id="" class="fa fa-plus"></i> <span id="">Save & Add More</span></button>
              <button type="button" onclick="InsModiItem(1)" class="btn btn-success AddMode EditMode"><i id="ItemButtonNameButton" class="fa fa-plus"></i> <span id="ItemButtonName">Save & Close</span></button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
          </span>
          <span class="DeleteMode" style="display: none">
              <button type="button" onclick="InsModiItem(1)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
              <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
          </span>
      </div>
      {{-- MODAL FOOTER --}}
    </div>
  </div>
</div>
	<script type="text/javascript">
    var selectedId = 0, select_col = '', select_fund = '', test, allIds = [];
    var leTEST = true, leError = "";
        $(document).ready(function(){
            // $('#SideBar_Budget').addClass('active');
            // $('#SideBar_Budget_Budget_Proposal_Entry_New').addClass('text-green');
            // getEntries();
            // $('#SideBar_MFile_Accounting_Journal').addClass('text-green');
            $('#importErrorRow').hide();
            if($('select[name="itm_col"] option').length > 1)
            {
              $('select[name="itm_col"]').val('CRJ').trigger('change');
            }

            if($('select[name="itm_fund"] option').length > 1)
            {
              $('select[name="itm_fund"]').val('00000000').trigger('change');
            }

            $('#leIcoN').show();$('#leIcoN2').hide();
            $('#modal-default2').modal('show');
            $('table').DataTable();
        });
    function getIndexNow(inx, tbl){
        var table = $('#'+tbl).DataTable();
        // selectedId = $('#'+inx).closest('tr').index();
    }
    function SubmitImport(){
        if($('#ItmForm2').parsley().validate())
        {
            var formData = new FormData();
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('file', $('input[name="itm_import"]')[0].files[0]);
            $('#leIcoN').hide();$('#leIcoN2').show();
            $.ajax({
                   url : '{{url('accounting/collection/entry/new')}}/import',
                   type : 'POST',
                   data : formData,
                   processData: false,  // tell jQuery not to process the data
                   contentType: false,  // tell jQuery not to set contentType
                   success : function(data) {
                    if(data.status == 'DONE') {
                        $('#leIcoN').show();$('#leIcoN2').hide();
                        $('#importErrorBody').empty();
                      // if(data.error_count > 0)
                      // {
                      //   alert('An error occured during the process.');
                      //   $('#importErrorNum').text(data.error_count);
                      //   addError(data.error, data.error_count);
                      //   $('#importErrorRow').show();
                      // } else {
                        $('#modal-default2').modal('toggle');
                        select_col = $('select[name="itm_col"]').val();
                        select_fund = $('select[name="itm_fund"]').val();
                        ShowImportedData(data.header, data.data);
                        alert('Successfully imported data from csv.');
                      // }
                    } else {
                        alert('An error occured during the process.');
                        console.log(data);
                    }
                       // console.log(data);
                       // alert(data);
                   },
                   error : function(a, b, c){

                   }
            });
        }
    }
    function addError(data, leCount)
    {
      if(leCount > 0)
      {
        for(var i = 0, z = 1; i < leCount;i++, z++)
        {
          if(data[i] != undefined) {
            $('#importErrorBody').append(
                '<div class="callout callout-danger">' +
                  '<h4><i class="icon fa fa-info" style="display:none"></i>&nbsp;'+z+'.)&nbsp;'+data[i]+'</h4>'+
                '</div>'
              );
          }
        }
      }
    }
    function ShowImportedData(header, data)
    {
      if(data.length > 0)
      {
         $('#ShowAll').append(
            '<div class="row">' +

              '<div class="col-md-12">' +

                '<div class="box box-default">' +

                  '<div class="box-header with-border">' +
                    '<h3>Header</h3>' +
                  '</div>' +

                  '<div class="box-body">' +
                    '<div class="row">' +
                      // '<form id="CheckMeFirst" data-parsley-validate novalidate>' +
                      '<div class="col-md-4">' +
                        '<div class="form-group">' +
                          '<label>Cashier<span style="color:red"><strong>*</strong></span></label>' +
                          // '<input type="text" class="form-control" data-parsley-required-message="<strong>Reference</strong> is required." required value="'+header.officer+'" name="hd_cashier" readonly="" hidden>' +
                          '<select class="form-control select2 select2-hidden-accessible" {{--onchange="loadORIssuance()"--}} name="hdr_cash" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_cashier_span" data-parsley-required-message="<strong>Cashier</strong> is required." required>' +
                            @isset($cashiers)
                                @if(count($cashiers) > 0)
                                  '<option value="">Select Cashier...</option>' +
                                  @foreach($cashiers as $o)
                                      '<option value="{{$o->uid}}">{{$o->name}}</option>' +
                                  @endforeach
                                @else
                                    '<option value="">No Cashier registered...</option>' +
                                @endif
                            @else
                              '<option value="">No Cashier registered...</option>' +
                            @endisset
                          '</select>' +
                          '<span id="hdr_cashier_span"></span>' +
                        '</div>' +
                      '</div>'+
                      '<div class="col-md-6" id="CASHIER_ERROR">' +
                      '</div>'+
                      // '</form>' +

                    '</div>' +
                  '</div>' +

                '</div>' +

              '</div>' +

            '</div>'
          );
         test = data;
         // $('select[name="hdr_cash"]').select2();
         var exists = header.chk_ofc.length > 0 ? true : false ;
          if(!exists){
            $('#CASHIER_ERROR').append(
                '<div class="callout callout-danger">' +
                '<h5>'+header.officer+' is not Found or currently not registered in the system.</h5>' +
                '</div>'
              );
            $('select[name="hdr_cash"]').parsley().validate();
          } else {
            $('select[name="hdr_cash"]').val(header.chk_ofc[0]).trigger('change');
          }
        for(var i = 0, kk =1 ; i < data.length; i++, kk++)
        {
          $('#ShowAll').append(
            // MAIN ROW
            '<div class="row Coll_entry" or_no="'+data[i].or_no+'" no="'+data[i].no+'" id="ROW_'+data[i].or_no+'_'+data[i].no+'">' +
              // COLUMN MD 12
              '<div class="col-md-12">' +
                // MAIN BOX
                '<div class="box box-default">' +
                  // BOX HEADER
                  '<div class="box-header with-border">' +
                    '<h3 class="box-title">'+kk+'.) '+data[i].or_no+'</h3> <a onclick="AddMode(\''+data[i].or_no+'\', \''+data[i].no+'\');" class="btn btn-social-icon btn-success" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i></a> <h3 class="box-title">Add new</h3>' +
                    // '<div class="box-tools pull-right">' +
                    //   '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>' +
                    //   '</button>' +
                    // '</div>' +
                  '</div>' +
                  // BOX HEADER

                  // BOX BODY
                  '<div class="box-body">' +
                    // COLUMN HEAD
                    // '<form id="hdr_form_'+data[i].or_no+'_'+data[i].no+'" data-parsley-validate novalidate>' +
                    // ROW 1
                    '<div class="row">' +
                      // OR TYPE
                      // '<div class="col-md-3">' +
                      //   '<div class="form-group">' +
                      //     '<label>OR Type <span style="color:red"><strong>*</strong></span></label>' +
                      //     '<select class="form-control select2 select2-hidden-accessible" {{--onchange="loadORIssuance()"--}} name="hd_or_typ['+data[i].or_no+']" style="width: 100%;" id="head_or_typ_'+data[i].or_no+'" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hd_or_typ_'+data[i].or_no+'"" data-parsley-required-message="<strong>OR Type</strong> is required." {{-- required --}}>' +
                      //       @isset($or_type)
                      //           '<option value="">Select OR Type...</option>' +
                      //         @foreach($or_type as $o)
                      //             '<option value="{{$o->or_type}}">{{$o->or_code}}</option>'+
                      //         @endforeach
                      //       @else
                      //         '<option value="">No OR Type registered...</option>' +
                      //       @endisset
                      //     '</select>' +
                      //     '<span id="hd_or_typ_'+data[i].or_no+'"></span>' +
                      //   '</div>' +
                      // '</div>' +
                      // OR TYPE
                      // JOURNAL
                      // '<div class="col-md-4">' +
                      //   '<div class="form-group">' +
                      //     '<label>Journal <span style="color:red"><strong>*</strong></span></label>' +
                      //     '<select class="form-control select2 select2-hidden-accessible" name="hd_jr['+data[i].or_no+']" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hd_jr_'+data[i].or_no+'" data-parsley-required-message="<strong>Journal</strong> is required." required>' +
                      //       @isset($m05)
                      //         '<option value="">Select Journal...</option>' +
                      //           @foreach($m05 as $s)
                      //               '<option value="{{$s->j_code}}">{{$s->j_desc}}</option>' +
                      //           @endforeach
                      //       @else
                      //         '<option value="">No Journal  registered...</option>' +
                      //       @endisset
                      //     '</select>' +
                      //     '<span id="hd_jr_'+data[i].or_no+'"></span>' +
                      //   '</div>' +
                      // '</div>' +
                      // JOURNAL
                      // FUND
                      // '<div class="col-md-4">' +
                      //   '<div class="form-group">' +
                      //     '<label>Fund <span style="color:red"><strong>*</strong></span></label>' +
                      //     '<select class="form-control select2 select2-hidden-accessible" name="hd_fund['+data[i].or_no+']" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Fund</strong> is required." data-parsley-errors-container="#hd_fd_'+data[i].or_no+'" >' +
                      //       @isset($fund)
                      //           '<option value="">Select Fund...</option>' +
                      //           @foreach($fund as $bp)
                      //             '<option value="{{$bp->fid}}">{{$bp->fdesc}}</option>' +
                      //           @endforeach
                      //       @else
                      //           '<option value="">No Fund registered...</option>' +
                      //       @endisset
                      //     '</select>' +
                      //     '<span id="hd_fd_'+data[i].or_no+'"></span>' +
                      //   '</div>' +
                      // '</div>' +
                      // FUND
                    // '</div>' +//HEHE
                    // ROW 1
                    // ROW 2
                    // '<div class="row">' +//HEHE
                      // OR NUMBER
                      '<div class="col-md-4">' +
                        '<div class="form-group">' +
                          '<label>OR No.</label>' +
                          '<input type="text" class="form-control" data-parsley-required-message="<strong>Reference</strong> is required." required value="'+data[i].or_no+'" name="hd_or_num[]" readonly="" or_num="'+data[i].no+'">' +
                        '</div>' +
                      '</div>'+
                      // OR NUMBER
                      // CUSTOMER
                      // '<div class="col-md-3">' +
                      //   '<div class="form-group">' +
                      //     '<label>Customer <span style="color:red"><strong>*</strong></span></label>' +
                      //     // '<input type="text" class="form-control" data-parsley-required-message="<strong>Customer</strong> is required." value="'+(data[i].paid_by != false ? data[i].paid_by : '')+'" name="hd_cust" required>' +
                      //     '<select required class="form-control select2 select2-hidden-accessible" name="hd_cust['+data[i].or_no+']" id="hd_cust_'+data[i].or_no+'_'+data[i].no+'" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" leCustomer="'+data[i].paid_by_encode+'" data-parsley-required-message="<strong>Customer</strong> is required." data-parsley-errors-container="#budget_hd_cust_'+data[i].or_no+'_'+data[i].no+'" {{-- required --}}>' +
                      //       @isset($m06)
                      //         '<option value="">Select Customer...</option>' +
                      //           @foreach($m06 as $x3)
                      //             '<option value="{{$x3->d_code}}" id="cust_{{$x3->d_code}}" cust_name="{{urlencode($x3->d_name)}}">{{$x3->d_code}} {{$x3->d_name}}</option>' +
                      //           @endforeach
                      //       @else
                      //           '<option value="">No Customer registered...</option>' +
                      //       @endisset
                      //     '</select>' +
                      //     '<span id="budget_hd_cust_'+data[i].or_no+'_'+data[i].no+'"></span>' +
                      //   '</div>' +
                      // '</div>'+
                      // CUSTOMER
                      // DATE
                      '<div class="col-md-4">' +
                        '<div class="form-group">' +
                          '<label>Date <span style="color:red;"><strong>*</strong></span></label>' +
                          '<div class="input-group date">' +
                              '<div class="input-group-addon">' +
                                  '<i class="fa fa-calendar"></i>' +
                              '</div>' +
                              '<input required type="date" class="form-control pull-right" name="hd_dt['+data[i].or_no+']" required data-parsley-required-message="<strong>Date</strong> is required." value="'+data[i].date+'"  readonly>' +
                          '</div>'+
                        '</div>' +
                      '</div>'+
                      // DATE
                      // Real property type
                      '<div class="col-md-4">' +
                        '<div class="form-group">' +
                          '<label>Real Property Class </label>' +
                          // '<input type="text" class="form-control" data-parsley-required-message="<strong>Customer</strong> is required." value="'+(data[i].paid_by != false ? data[i].paid_by : '')+'" name="hd_cust" required>' +
                          '<select class="form-control select2 select2-hidden-accessible" name="hd_real_property['+data[i].or_no+']" id="hd_cust_'+data[i].or_no+'_'+data[i].no+'" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" leCustomer="'+data[i].paid_by_encode+'" {{-- required --}}>' +
                            @isset($real)
                              '<option value="">Select Real Property Class...</option>' +
                                @foreach($real as $r)
                                  '<option value="{{$r->rpid}}" id="cust_{{$r->rpid}}" cust_name="{{urlencode($r->rp_desc)}}">{{$r->rpid}} {{$r->rp_desc}}</option>' +
                                @endforeach
                            @else
                                '<option value="">No Real Property Class registered...</option>' +
                            @endisset
                          '</select>' +
                          '<span id="budget_hd_cust_'+data[i].or_no+'_'+data[i].no+'"></span>' +
                        '</div>' +
                      '</div>'+
                      // Real property type
                    '</div>' +
                    // ROW 2
                    // '</form>' +
                    // COLUMN HEAD
                    // COLUMN BODY
                    // '<div class="row table-responsive">' +
                      '<table id="table_'+data[i].or_no+'_'+data[i].no+'" class="table table-bordered table-striped">' +
                        '<thead>' +
                          '<tr>' +
                            '<th>Line</th>' +
                            '<th>Local TIN</th>' +
                            '<th>TD#/Bus ID</th>' +
                            '<th>Taxpayer</th>' +
                            '<th><center>Type</center></th>' +
                            '<th>Tax Type</th>' +
                            '<th>Period</th>' +
                            '<th>Year</th>' +
                            '<th><center>COA Acc</center></th>' +
                            '<th><center>Amount</center></th>' +
                            '<th><center>Options</center></th>' +
                          '</tr>' +
                        '</thead>' +
                        '<tbody></tbody>' +
                      '</table>' +
                    // '</div>' +
                    // COLUMN BODY
                  '</div>' +
                  // BOX BODY
                  // BOX FOOTER
                  '<div class="box-footer">' +
                    '<div class="col-sm-6">&nbsp;' +
                    '</div>' +
                    '<div class="col-sm-6">' +
                      '<div class="col-sm-5">' +
                        '<label for=""><strong>'+data[i].or_no+'</strong>&nbsp;&nbsp;&nbsp;&nbsp;Sub-Total:</label>' +
                      '</div>' +
                      '<div class="col-sm-7">' +
                        '<input type="text" class="form-control" disabled="" name="sub_total_'+data[i].or_no+'_'+data[i].no+'" value="Php 0.00">' +
                      '</div>' +
                    '</div>' +
                  '</div>' +
                  // BOX FOOTER
                '</div>' +
                // MAIN BOX
              '</div>'+
              // COLUMN MD 12
            '<div>'
            // MAIN ROW
          );
          if(data[i].chk_or_type.length > 0)
          {
            // console.log(data[i].chk_or_type[0].or_type);
            $('#head_or_typ_'+data[i].or_no).val(data[i].chk_or_type[0].or_type).trigger('change');
          }
          if(data[i].chk_customer.length > 0)
          {
            $('#hd_cust_'+data[i].or_no+'_'+data[i].no).val(data[i].chk_customer[0].d_code).trigger('change');
          }
          $('#table_'+data[i].or_no+'_'+ data[i].no).DataTable({
                "createdRow": function (row, data, dataIndex) {
                  // console.log();
                    if ($(data[5]).attr('tax_typ_id') == '') {
                        $(row).addClass("danger");
                    }
                }
            });
          $('#table_'+data[i].or_no+'_'+ data[i].no).on( 'click', 'tr', function () {
            var id = $(this).closest('table')[0]['id'];
            // console.log('#table_'+data[i].or_no+'_'+ data[i].no);
              var table = $('#'+id).DataTable();
              selectedId = table.row( this ).index() ;
              // console.log(this);
          });
          // for adding per line
          if(data[i].data.length > 0)
          {
            let forNull = null;
            for(var j = 0, k = 1; j< data[i].data.length; j++,k++)
            {
              $('#table_'+data[i].or_no+'_'+ data[i].no).DataTable().row.add([
                k,
                '<span class="tin" pay_tin="'+data[i].data[j].local_tin+'">'+data[i].data[j].local_tin+'</span><input name="hiddentin['+data[i].or_no+'][]" type="hidden" value="'+data[i].data[j].local_tin+'">',

                '<span class="td_id" td_id="'+data[i].data[j].to_bus+'">'+((data[i].data[j].to_bus != '') ? data[i].data[j].to_bus : 'N/A')+'</span><input name="hiddentd['+data[i].or_no+'][]" type="hidden" value="'+data[i].data[j].to_bus+'">',

                '<span class="payer" payer="'+data[i].data[j].tax_payer+'">'+data[i].data[j].tax_payer+'</span><input name="hiddenpayer['+data[i].or_no+'][]" type="hidden" value="'+data[i].data[j].tax_payer+'">',

                '<span class="py_typ" py_typ="'+data[i].data[j].type+'"><center>'+data[i].data[j].type+'</center></span><input name="hiddenpy_typ['+data[i].or_no+'][]" type="hidden" value="'+data[i].data[j].type+'">',

                '<span class="tax_type" tax_typ_id="'+((data[i].data[j].tax_code[0] != undefined) ? data[i].data[j].tax_code[0] : '')+'" tax_type="'+encodeURI(data[i].data[j].tax_type)+'">'+data[i].data[j].tax_type+'</span><input name="hiddentax_typ_id['+data[i].or_no+'][]" type="hidden" value="'+encodeURI(data[i].data[j].tax_type)+'"><input name="hiddentax_id['+data[i].or_no+'][]" type="hidden" value="'+((data[i].data[j].tax_code[0] != undefined) ? data[i].data[j].tax_code[0] : '')+'">',

                '<td><span class="qtr" qtr="">NOT SET</span><input name="hiddenqtr['+data[i].or_no+'][]" value="" type="hidden"></td></td>',

                '<td><span class="year" year="">NOT SET</span><input name="hiddendp['+data[i].or_no+'][]" value="" type="hidden"></td>',

                '<span class="soa_code" soa_code="">'+'N/A'+'</span><input name="hiddensoa_code['+data[i].or_no+'][]" type="hidden" value=""><input name="hiddenpaymentdesc['+data[i].or_no+'][]" type="hidden" value="'+encodeURI(data[i].data[j].tax_type)+'">',

                '<center class="amt" amt="'+parseFloat(isNaN(data[i].data[j].amt) ? '0' : data[i].data[j].amt)+'">'+formatNumberToMoney(parseFloat(data[i].data[j].amt))+'</center><input name="hiddenamt['+data[i].or_no+'][]" type="hidden" value="'+parseFloat(isNaN(data[i].data[j].amt) ? '0' : data[i].data[j].amt)+'">',
                '<center>' +
                //'+((data[i].data[j].tax_code[0] != undefined) ? data[i].data[j].tax_code[0].at_code : '')+'
                //(or_no, no, line, tin, td_bus, payer, itm_type, payment, payment_desc, soa_code, amt)
                  '<a class="btn btn-social-icon btn-warning" id="edt_'+data[i].or_no+'_'+data[i].no+'_'+k+'"  data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode(\''+data[i].or_no+'\', \''+data[i].no+'\', \''+k+'\', \''+data[i].data[j].local_tin+'\', \''+data[i].data[j].to_bus+'\', \''+data[i].data[j].tax_payer+'\', \''+data[i].data[j].type+'\', \''+((data[i].data[j].tax_code[0] != undefined) ? data[i].data[j].tax_code[0] : '')+'\', \''+encodeURI(data[i].data[j].tax_type)+'\', \'\', \''+parseFloat(data[i].data[j].amt)+'\');"></i></a>&nbsp;' +
                  '<a class="btn btn-social-icon btn-danger" id="del_'+data[i].or_no+'_'+data[i].no+'_'+k+'" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+data[i].or_no+'\', \''+data[i].no+'\', \''+k+'\', \''+data[i].data[j].local_tin+'\', \''+data[i].data[j].to_bus+'\', \''+data[i].data[j].tax_payer+'\', \''+data[i].data[j].type+'\', \'\', \''+encodeURI(data[i].data[j].tax_type)+'\', \'\', \''+parseFloat(data[i].data[j].amt)+'\');"><i class="fa fa-trash"></i></a>' +
              '</center>',
              ]).draw();
            }
            // console.log(data[i].data[0].local_tin);
            SubTotal(data[i].or_no, data[i].no);
          }
          // end for adding per line
        }
        $('#ShowAll').append(
            '<div class="row">' +
              '<div class="col-sm-6">' +
                '<div class="col-sm-3">' +
                  '<label for="">Grand Total:</label>' +
                '</div>' +
                '<div class="col-sm-9">' +
                  '<input type="text" class="form-control" disabled="" name="total_line" value="Php 0.00">' +
                '</div>' +
              '</div>' +
                '<div class="col-sm-6">' +
                    '<div class="col-sm-6">' +
                      {{-- <div class="form-group" style="display: flex;"> --}}
                        '<button type="submit" class="btn btn-block btn-success" onclick="SaveProposal()"><i class="fa fa-save"></i> Save</button>' +
                    '</div>'+
                    '<div class="col-sm-6">' +
                      '<button type="button" class="btn btn-block btn-primary" style="margin-top: 0;" onclick="javascript:history.go(-1)"><i class="fa fa-arrow-left"></i> Go Back</button>' +
                    '</div>' +
                '</div>' +
            '</div>'
          );
        GrandTotal();
        // $('select[name="hd_jr"]').select2();
        // $('select[name="hd_cust"]').select2();
        // $('select[name="hd_real_property"]').select2();
        // $('select[name="hd_fund"]').select2();
        // $('select[name="hd_or_typ"]').select2();
        $("select").select2();
        if($('select[name^="hd_jr"] option').length > 1)
        {
          $('select[name^="hd_jr"]').val('CRJ').trigger('change');
        }
        if($('select[name^="hd_fund"] option').length > 1)
        {
          $('select[name^="hd_fund"]').val('00000008').trigger('change');
        }
      }
    }
    function SubTotal (or_id, no)
    {
      var Total = 0;
      var TableData = $("#table_"+or_id+"_"+no).DataTable().rows().data();
      if(TableData.length > 0){
        for(var i = 0; i < TableData.length; i ++)
        {
          var temp001 = TableData[i][7];
          var mySubString = temp001 .substring(
              temp001.lastIndexOf('amt="') + 5, 
              temp001.lastIndexOf('">')
          );
          var toBeAdded = (mySubString != 'NaN') ? parseFloat(mySubString) : 0;
          Total = Total + toBeAdded;
        }
        $('input[name="sub_total_'+or_id+'_'+no+'"]').val(formatNumberToMoney(Total));
      } else {
        $('input[name="sub_total_'+or_id+'_'+no+'"]').val(formatNumberToMoney(0));
      }
    }
    function GrandTotal()
    {
      var Total = 0;
      var TableData = $("table").DataTable().rows().data();
      if(TableData.length > 0){
        for(var i = 0; i < TableData.length; i ++)
        {
          var temp001 = TableData[i][7];
          var mySubString = temp001 .substring(
              temp001.lastIndexOf('amt="') + 5,
              temp001.lastIndexOf('">')
          );
          var toBeAdded = (mySubString != 'NaN') ? parseFloat(mySubString) : 0;
          Total = Total + toBeAdded;
        }
        $('input[name="total_line"]').val(formatNumberToMoney(Total));
      } else {
        $('input[name="total_line"]').val(formatNumberToMoney(0));
      }
    }
    function ifCheck ()
    {
      var test = $('select[name="itm_payment"]').val();
      if(test == '114'){
          $('#ifCheck').show();
          $('input[name="itm_chk_dt"]').attr('required', '');
          $('input[name="itm_chk_num"]').attr('required', '');
      } else {
          $('#ifCheck').hide();
          $('input[name="itm_chk_dt"]').removeAttr('required');
          $('input[name="itm_chk_num"]').removeAttr('required');
      }
      $('input[name="itm_chk_dt"]').val('');
      $('input[name="itm_chk_num"]').val('');
      $('input[name="itm_dep"]').prop('checked', false);
    }
    function getPaymentDesc()
    {
      var charge_code = $('select[name="itm_payment"]').val();
        if(charge_code != '') {
            (typeof($('#payment_'+charge_code).attr('c_desc')) != 'undefined' ? $('input[name="itm_desc"]').val(urldecode($('#payment_'+charge_code).attr('c_desc'))) : '') ;
        } else {
          $('input[name="itm_desc"]').val('');
            // alert('No Charge Selected...');
        }
    }
    function AddMode(or_no, no)
    {
      $('#MOD_MODE').text('(ADD)');
      $('#ItmForm').parsley().reset();
      var line = ($('#table_'+or_no+'_'+no).DataTable().data().count()/ 9) + 1;
      $('input[name="itm_tbl_or_no"]').val(or_no);
      $('input[name="itm_tbl_no"]').val(no);
      $('input[name="itm_line"]').val(line);
      $('input[name="itm_desc"]').val('');
      $('input[name="itm_tin"]').val('');
      $('input[name="itm_tdbd"]').val('');
      $('input[name="itm_soa"]').val('');

      $('select[name="itm_payment"]').val('').trigger('change');
      // $('select[name="itm_ppa_type"]').val('').trigger('change');
      $('input[name="itm_type"]').val('');
      $('input[name="itm_amt"]').val('');

      $('.DeleteMode').hide();
      $('.AddMode').show();

      $('#ItemButtonNameButton').removeClass('fa-save');
      $('#ItemButtonNameButton').addClass('fa-plus');
      $('#ItemButtonName').text('Save & Close');
    }
    function EditMode(or_no, no, line, tin, td_bus, payer, itm_type, payment, payment_desc, soa_code, amt)
    {
      $('#MOD_MODE').text('(EDIT)');
      $('input[name="itm_tbl_or_no"]').val(or_no);
      $('input[name="itm_tbl_no"]').val(no);
      $('input[name="itm_line"]').val(line);
      $('input[name="itm_tin"]').val(tin);
      $('input[name="itm_tdbd"]').val(td_bus);
      $('input[name="itm_payer"]').val(payer);
      $('input[name="itm_type"]').val(itm_type);
      $('select[name="itm_payment"]').val(payment).trigger('change');
      $('input[name="itm_desc"]').val(urldecode(payment_desc));
      $('input[name="itm_soa"]').val(soa_code);
      $('input[name="itm_amt"]').val(parseFloat(amt));

      $('#ItemButtonNameButton').removeClass('fa-plus');
      $('#ItemButtonNameButton').addClass('fa-save');
      $('.DeleteMode').hide();
      $('.AddMode').hide();
      $('.EditMode').show();
      $('#ItemButtonName').text('Save');
    }
    function DeleteMode(or_no, no, line, tin, td_bus, payer, itm_type, payment, payment_desc, soa_code, amt)
    {
      $('#MOD_MODE').text('(DELETE)');
      $('input[name="itm_tbl_or_no"]').val(or_no);
      $('input[name="itm_tbl_no"]').val(no);
      $('input[name="itm_line"]').val(line);
      $('input[name="itm_tin"]').val(tin);
      $('input[name="itm_tdbd"]').val(td_bus);
      $('input[name="itm_payer"]').val(payer);
      $('input[name="itm_type"]').val(itm_type);
      $('select[name="itm_payment"]').val(payment).trigger('change');
      $('input[name="itm_desc"]').val(urldecode(payment_desc));
      $('input[name="itm_soa"]').val(soa_code);
      $('input[name="itm_amt"]').val(parseFloat(amt));

      $('#ItemButtonNameButton').removeClass('fa-plus');
      $('#ItemButtonNameButton').addClass('fa-save');
      $('.DeleteMode').hide();
      $('.AddMode').hide();
      $('.EditMode').show();
      $('#ItemButtonName').text('Save');

      $('#DeleteName').text(urldecode(payment_desc));
      $('.AddMode').hide();
      $('.DeleteMode').show();
    }
    function InsModiItem(selected)
    {
      if($('#ItmForm').parsley().validate()){
        var or_no = $('input[name="itm_tbl_or_no"]').val();
        var no = $('input[name="itm_tbl_no"]').val();
        var line = $('input[name="itm_line"]').val();
        var code = $('select[name="itm_soa"]').val(); // SOA
        var tin = $('input[name="itm_tin"]').val(); // local_tin
        var td_bus = $('input[name="itm_tdbd"]').val();
        var payment = $('select[name="itm_payment"]').val(); // tax type
        var payment_typ = $('select[name="itm_payment"]').select2('data')[0].text;
        var payment_desc = $('input[name="itm_desc"]').val(); // description
        var amt = $('input[name="itm_amt"]').val(); // balance
        var payer = $('input[name="itm_payer"]').val(); // Payer
        var qtrDesc = $('select[name="qtr"]').select2('data')[0].text;
        var qtr = $('select[name="qtr"]').val();
        var dp = $('input[name="dp"]').val();
        var itm_type = $('input[name="itm_type"]').val(); // itm type
        var table = $('#table_'+or_no+'_'+no).DataTable(); // TABLE

        if($('#MOD_MODE').text() == '(ADD)')
        {
          table.row.add([
            line,
            '<span class="tin" pay_tin="'+tin+'">'+tin+'</span><input name="hiddentin['+or_no+'][]" value="'+tin+'" type="hidden">',
            '<span class="td_id" td_id="'+td_bus+'">'+((td_bus != '') ? td_bus : 'N/A')+'</span><input name="hiddentd['+or_no+'][]" value="'+td_bus+'" type="hidden">',
            '<span class="payer" payer="'+payer+'">'+payer+'</span><input name="hiddenpayer['+or_no+'][]" value="'+payer+'" type="hidden">',
            '<span class="py_typ" py_typ="'+itm_type+'"><center>'+itm_type+'</center></span><input name="hiddenpy_typ['+or_no+'][]" value="'+itm_type+'" type="hidden">',
            '<span class="tax_type" tax_typ_id="'+payment+'" tax_type="'+encodeURI(payment_desc)+'">'+payment_desc+'</span><input name="hiddentax_typ_id['+or_no+'][]" value="'+encodeURI(payment_desc)+'" type="hidden"><input name="hiddentax_id['+or_no+'][]" type="hidden" value="'+payment+'">',
            '<td><span class="qtr" qtr="'+qtr+'">'+qtrDesc+'</span><input name="hiddenqtr['+or_no+'][]" value="'+qtr+'" type="hidden"></td>',
            '<td><span class="year" year="'+dp+'">'+dp+'</span><input name="hiddendp['+or_no+'][]" value="'+dp+'" type="hidden"></td>',
            '<span class="soa_code" soa_code="'+code+'">'+((code != '') ? code : 'N/A')+'</span><input name="hiddensoa_code['+or_no+'][]" value="'+code+'" type="hidden"><input name="hiddenpaymentdesc['+or_no+'][]" type="hidden" value="'+encodeURI(payment_desc)+'">',
            '<center class="amt" amt="'+parseFloat(amt)+'">'+formatNumberToMoney(parseFloat(amt))+'</center><input name="hiddenamt['+or_no+'][]" value="'+parseFloat(amt)+'" type="hidden">',
            '<center>' +
                '<a class="btn btn-social-icon btn-warning"  data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode(\''+or_no+'\', \''+no+'\', \''+line+'\', \''+tin+'\', \''+td_bus+'\', \''+payer+'\', \''+itm_type+'\', \''+payment+'\', \''+encodeURI(payment_desc)+'\', \''+code+'\', \''+parseFloat(amt)+'\');"></i></a>&nbsp;' +
                '<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+or_no+'\', \''+no+'\', \''+line+'\', \''+tin+'\', \''+td_bus+'\', \''+payer+'\', \''+itm_type+'\', \''+payment+'\', \''+encodeURI(payment_desc)+'\', \''+code+'\', \''+parseFloat(amt)+'\');"><i class="fa fa-trash "></i></a>' +
            '</center>'
          ]).draw();
          alert('Added '+payment_desc+' to List');
        }
        else if($('#MOD_MODE').text() == '(EDIT)')
        {
          table.row(selectedId).data([
            line,
            '<span class="tin" pay_tin="'+tin+'">'+tin+'</span><input name="hiddentin['+or_no+'][]" value="'+tin+'" type="hidden">',
            '<span class="td_id" td_id="'+td_bus+'">'+((td_bus != '') ? td_bus : 'N/A')+'</span><input name="hiddentd['+or_no+'][]" value="'+td_bus+'" type="hidden">',
            '<span class="payer" payer="'+payer+'">'+payer+'</span><input name="hiddenpayer['+or_no+'][]" value="'+payer+'" type="hidden">',
            '<span class="py_typ" py_typ="'+itm_type+'"><center>'+itm_type+'</center></span><input name="hiddenpy_typ['+or_no+'][]" value="'+itm_type+'" type="hidden">',
            '<span class="tax_type" tax_typ_id="'+payment+'" tax_type="'+encodeURI(payment_desc)+'">'+payment_desc+'</span><input name="hiddentax_typ_id['+or_no+'][]" value="'+encodeURI(payment_desc)+'" type="hidden"><input name="hiddentax_id['+or_no+'][]" type="hidden" value="'+payment+'">',
            '<td><span class="qtr" qtr="'+qtr+'">'+qtrDesc+'</span><input name="hiddenqtr['+or_no+'][]" value="'+qtr+'" type="hidden"></td>',
            '<td><span class="year" year="'+dp+'">'+dp+'</span><input name="hiddendp['+or_no+'][]" value="'+dp+'" type="hidden"></td>',
            '<span class="soa_code" soa_code="'+code+'">'+((code != '') ? code : 'N/A')+'</span><input name="hiddensoa_code['+or_no+'][]" value="'+code+'" type="hidden"><input name="hiddenpaymentdesc['+or_no+'][]" type="hidden" value="'+encodeURI(payment_desc)+'">',
            '<center class="amt" amt="'+parseFloat(amt)+'">'+formatNumberToMoney(parseFloat(amt))+'</center><input name="hiddenamt['+or_no+'][]" value="'+parseFloat(amt)+'" type="hidden">',
            '<center>' +
                '<a class="btn btn-social-icon btn-warning"  data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode(\''+or_no+'\', \''+no+'\', \''+line+'\', \''+tin+'\', \''+td_bus+'\', \''+payer+'\', \''+itm_type+'\', \''+payment+'\', \''+encodeURI(payment_desc)+'\', \''+code+'\', \''+parseFloat(amt)+'\');"></i></a>&nbsp;' +
                '<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+or_no+'\', \''+no+'\', \''+line+'\', \''+tin+'\', \''+td_bus+'\', \''+payer+'\', \''+itm_type+'\', \''+payment+'\', \''+encodeURI(payment_desc)+'\', \''+code+'\', \''+parseFloat(amt)+'\');"><i class="fa fa-trash "></i></a>' +
            '</center>'
          ]).draw();
          table.row(selectedId).nodes().to$().removeClass("danger");
          alert('Successfully modified '+payment_desc+'.');
        } else {
          table.row(selectedId).remove().draw();
          alert('Successfully removed '+payment_desc+'.');
        }
      SubTotal(or_no, no);
      GrandTotal();
      if(selected == 1)
        {
          $('#modal-default').modal('toggle');
        } else {
            addMode(or_no, no, 0);
        }
      }
    }
    function SaveProposal()
    {
      leTEST = true;
      var COL_OR_NUM = $('[name="hd_or_num"]').map(function(){return $(this).val();}).get();
      var COL_OR_TYP = $('[name="hd_or_typ"]').map(function(){return $(this).val();}).get();
      var COL_CUST = $('[name="hd_cust"]').map(function(){return $(this).val();}).get();
      var COL_DT = $('[name="hd_dt"]').map(function(){return $(this).val();}).get();
      var COL_NUM = $('[name="hd_or_num"]').map(function(){return $(this).attr('or_num');}).get();
      var COL_JR = $('[name="hd_jr"]').map(function(){return $(this).val();}).get();
      var COL_FUND = $('[name="hd_fund"]').map(function(){return $(this).val();}).get();
      var COL_REAL_PROPERTY = $('[name="hd_real_property"]').map(function(){return $(this).val();}).get();
      var COL_CUST_NAME = $('[name="hd_cust"]').map(function(){return $(this).attr('leCustomer');}).get();
      // CHECK NUMBER OF COLLECTION TO SAVE
      if(COL_OR_NUM.length > 0)
      {
        // CHECK CASHIER
        if($('#CheckMeFirst').parsley().validate())
        {
          // // LOOP EACH OR TYPES
          // for(var i = 0; i < COL_OR_NUM.length;i++)
          // {
          //   if(leTEST)
          //   {
          //     // CHECK EACH COLLECTION HEADER
          //     if($('#hdr_form_'+COL_OR_NUM[i]+'_'+COL_NUM[i]).parsley().validate())
          //     {
          //       // LOOP EACH ROW IN EACH COLLECTION
          //       for(var j = 0; j <  $('#table_'+COL_OR_NUM[i]+'_'+COL_NUM[i]).DataTable().row().length; j++)
          //       {
          //         // CHECK ROW if HAS DANGER CLASS
          //         if($($('#table_'+COL_OR_NUM[i]+'_'+COL_NUM[i]).DataTable().row(j).node()).hasClass('danger'))
          //         {
          //           leTEST = false;
          //           $('html, body').animate({
          //               scrollTop: $('#ROW_'+COL_OR_NUM[i]+'_'+COL_NUM[i]).offset().top
          //           }, 500);
          //           break;
          //         }
          //         // CHECK ROW if HAS DANGER CLASS
          //       }
          //       // LOOP EACH ROW IN EACH COLLECTION
          //     }
          //     else
          //     {
          //       leTEST = false;break;
          //     }
          //     // CHECK EACH COLLECTION HEADER
          //   }
          // }
          // // LOOP EACH OR TYPES

          if(leTEST == true)
          {
           // save here
          var AllData = [];
          let arrOfHidden = ['hiddentin','hiddentd','hiddenpayer','hiddenpy_typ','hiddentax_typ_id','hiddentax_id','hiddenpaymentdesc','hiddenqtr','hiddendp','hiddensoa_code','hiddenamt'];
          for(var i = 0; i < COL_OR_NUM.length; i++)
          {
            var TempoRaryStorage1 = [];
            var TempoRaryStorage2 = [];
            var TempoRaryStorage1 = [];
            var TempoRaryStorage2 = [];
            TempoRaryStorage1["col_code"] = COL_JR[i];
            TempoRaryStorage1["fund"] = COL_FUND[i];
            TempoRaryStorage1["dt"] = COL_DT[i];
            TempoRaryStorage1["cust"] = COL_CUST[i];
            TempoRaryStorage1["cust_name"] = COL_CUST_NAME[i];
            TempoRaryStorage1["or_typ"] = COL_OR_TYP[i];
            TempoRaryStorage1["or_no"] = COL_OR_NUM[i];
            TempoRaryStorage1["real_property"] = COL_REAL_PROPERTY[i];
            TempoRaryStorage1["cashier"] = $('select[name="hdr_cash"]').val();
            TempoRaryStorage1["data"] = [];

            let tableqwe = $('#table_'+COL_OR_NUM[i]+'_'+COL_NUM[i]).DataTable();
            tableqwe.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
              let data = this.data();
              let thisNode = $(this.node());
              arrOfHidden.forEach(function(el,key){
                if(thisNode.find('[name="'+el+'"]').length){
                  TempoRaryStorage1["data"][el + '^' + rowIdx + '^' + tableLoop] = thisNode.find('[name="'+el+'"]').val();
                }
              })
              
            } );
            AllData.push(TempoRaryStorage1);
          }
          console.log(AllData);
          $.ajax({
            url: '{{url('accounting/collection/saveimport')}}',
            method: 'POST',
            cache: false,
            data: {_token: '{{csrf_token()}}', data: $("#he").serialize()},
            success: function(a){
              console.log(a);
            }
          })
          }
          else
          {
            alert('An error has been detected by the system.');
          }
        }
        // CHECK CASHIER
        else
        {
          // $('#CheckMeFirst').focus();
        }
        // CHECK CASHIER
      }
      // CHECK NUMBER OF COLLECTION TO SAVE
      else
      {

      }
      // CHECK NUMBER OF COLLECTION TO SAVE
    }
    $("#collection, #collection_menu").show();
    @isset($qtr)
    $('[name="qtr"]').val($('[name="qtr"] option[otherData = {{$qtr}}]').val()).trigger('change');
    @endisset
    </script>
@endsection