@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'City Treasurer','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Collection','icon'=>'none','st'=>false],
        ['link'=>url("accounting/collection/entry"),'desc'=>'Collection Entry','icon'=>'none','st'=>true],
        ['link'=>'#','desc'=>'Import','icon'=>'none','st'=>false],
    ];
    $_ch = "Collection Entry"; // Module Name
@endphp
@section('content')
<!-- Content Header (Page header) -->
@include('layout._contentheader')
<!-- Main content -->
<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Header</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> --}}
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="">
          <form id="HdrForm" data-parsley-validate novalidate>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Collection Entry #</label>
                        <input type="text" class="form-control" name="" disabled="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Collection Code <span style="color:red"><strong>*</strong></span></label>
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_sec_txt" disabled> --}}
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_sec" disabled style="display: none"> --}}
                        <select class="form-control select2 select2-hidden-accessible" name="hdr_col" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_sec_span" data-parsley-required-message="<strong>Collection</strong> is required." required>
                            @isset($m05)
                              <option value="">Select Collection...</option>
                                @foreach($m05 as $s)
                                    <option value="{{$s->j_code}}">{{$s->j_desc}}</option>
                                @endforeach
                            @else
                              <option value="">No Collection  registered...</option>
                            @endisset
                        </select>
                        <span id="hdr_sec_span"></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Fund <span style="color:red"><strong>*</strong></span></label>
                        <select class="form-control select2 select2-hidden-accessible" name="hdr_fund" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Fund</strong> is required." data-parsley-errors-container="#budget_period_span" required>
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
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Date <span style="color:red"><strong>*</strong></span></label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="date" class="form-control pull-right" name="hdr_date" required data-parsley-required-message="<strong>Date</strong> is required.">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Customer<span style="color:red"><strong>*</strong></span></label>
                        {{-- <input type="text" class="form-control" name="hdr_fy_mo" disabled="" value=""> --}}
                        <select class="form-control select2 select2-hidden-accessible" name="hdr_cust" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Customer</strong> is required." data-parsley-errors-container="#budget_fy_span" required>
                          @isset($m06)
                            <option value="">Select Customer...</option>
                              @foreach($m06 as $x3)
                                <option value="{{$x3->d_code}}" id="cust_{{$x3->d_code}}" cust_name="{{urlencode($x3->d_name)}}">{{$x3->d_code}} {{$x3->d_name}}</option>
                              @endforeach
                          @else
                              <option value="">No Customer registered...</option>
                          @endisset
                        </select>
                        <span id="budget_fy_span"></span>
                        {{-- <input type="text" name="hdr_fy" readonly="" style="display: none" value="@if(isset($data[5])){{$data[5]}}@endif">
                        <input type="text" name="hdr_mo" readonly="" style="display: none" value="@if(isset($data[6])){{$data[6]}}@endif"> --}}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>OR Type <span style="color:red"><strong>*</strong></span></label>
                        {{-- <input type="text" class="form-control EditBudgetapproved" name="hdr_fid_txt" disabled>
                        <input type="text" class="form-control EditBudgetapproved" name="hdr_fid" disabled style="display: none"> --}}
                        <select class="form-control select2 select2-hidden-accessible" name="hdr_or" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_fid_span" data-parsley-required-message="<strong>OR Type</strong> is required." required>
                            @isset($or_type)
                              <option value="">Select OR Type...</option>
                              @foreach($or_type as $o)
                                  <option value="{{$o->or_type}}">{{$o->or_code}}</option>
                              @endforeach
                            @else
                              <option value="">No OR Type registered...</option>
                            @endisset
                        </select>
                        <span id="hdr_fid_span"></span>
                    </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                      <label>Cashier <span style="color:red"><strong>*</strong></span></label>
                      <select class="form-control select2 select2-hidden-accessible" name="hdr_cash" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_cashier_span" data-parsley-required-message="<strong>Cashier</strong> is required." required>
                            @isset($cashiers)
                              <option value="">Select Casher...</option>
                              @foreach($cashiers as $o)
                                  <option value="{{$o->uid}}">{{$o->opr_name}}</option>
                              @endforeach
                            @else
                              <option value="">No Cashier registered...</option>
                            @endisset
                        </select>
                        <span id="hdr_cashier_span"></span>
                  </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Reference <span style="color:red"><strong>*</strong></span></label>
                        <input type="text" class="form-control EditBudgetapproved" name="hdr_ref" data-parsley-required-message="<strong>Reference</strong> is required." required>
                    </div>
                </div>
            </div>
            </form>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Items List</h3>
                    <button id="BudgetEntriesAdd" type="button" class="btn btn-primary" onclick="addMode()" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add Payment</button>
                    <div class="modal fade in" id="modal-default">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                  <h4 class="modal-title">Item <span id="MOD_MODE"></span></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="box-body">
                                      <form id="ItmForm" novalidate data-parsley-validate>
                                          <span class="AddMode EditMode">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Line</label>
                                                        <input type="text" class="form-control" disabled="" name="itm_line">
                                                            <input type="text" class="form-control" disabled="" name="true_bal" style="display:none">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>SOA<span style="color:red;display: none"><strong>*</strong></span></label>
                                                            {{-- <input type="text" class="form-control" name="itm_acc_title_txt" readonly=""> --}}
                                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#itm_acc_title_span" name="itm_soa" data-parsley-required-message="<strong>SOA</strong> is required." onchange="">
                                                            @isset($soa)
                                                             @if(count($soa) > 0)
                                                               <option value="">Select SOA...</option>
                                                                @foreach ($soa as $c)
                                                                  <option value="{{$c->soa_code}}">{{$c->soa_code}}</option>
                                                                @endforeach
                                                              @else
                                                                <option value="">No SOA registered..</option>
                                                             @endif
                                                            @else
                                                                <option value="">No SOA registered..</option>
                                                            @endisset
                                                        </select>
                                                        <span id="itm_acc_title_span"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Payment<span style="color:red;"><strong>*</strong></span></label>
                                                        <select name="itm_payment" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#itm_ppa_span" onchange="ifCheck();getPaymentDesc()" data-parsley-required-message="<strong>Payment</strong> is required." required>
                                                            @isset($m10)
                                                                <option value="">Select Payment...</option>
                                                                @foreach ($m10 as $p)
                                                                    <option value="{{$p->mp_code}}" id="payment_{{$p->mp_code}}" c_desc="{{urlencode($p->mp_desc)}}">{{$p->mp_code}} - {{$p->mp_desc}}</option>
                                                                @endforeach
                                                            @else
                                                                <option value="">No Payment registered..</option>
                                                            @endisset
                                                        </select>
                                                        <span id="itm_ppa_span"></span>
                                                        <input type="text" style="display: none" value="" name="itm_old_ppa">
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
                                                        <label>Amount <span style="color:red"><strong>*</strong></span></label>
                                                        <input type="number" class="form-control" name="itm_amt" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Amount</strong> is required." required>
                                                    </div>
                                                </div>
                                            </div>
                                            <span id="ifCheck" style="display: none">
                                                <div class="row">
                                                  <div class="col-sm-6">
                                                      <div class="form-group">
                                                          <label>Check Date <span style="color:red"><strong>*</strong></span></label>
                                                          <input type="date" class="form-control" name="itm_chk_dt" " placeholder="0.00"  data-parsley-required-message="<strong>Check Date</strong> is required.">
                                                      </div>
                                                  </div>
                                                  <div class="col-sm-6">
                                                      <div class="form-group">
                                                          <label>Check Number <span style="color:red"><strong>*</strong></span></label>
                                                          <input type="text" class="form-control" name="itm_chk_num" data-parsley-required-message="<strong>Check Number</strong> is required.">
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                    <input name="itm_dep" type="checkbox" class="minimal" data-parsley-multiple="sel_sl">
                                                    Deposited
                                                </div>
                                                </div>
                                              </div>
                                            </span>
                                                {{-- <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Allocated <span style="color:red"><strong>*</strong></span></label>
                                                            <input type="number" class="form-control" name="itm_alot" step="0.01" data-parsley-type="number" placeholder="0.00" data-parsley-type-message="Should be a valid <strong>number</strong>." data-parsley-required-message="<strong>Amount</strong> is required." required>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                            {{-- <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Notes</label>
                                                        <textarea class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div> --}}
                                          </span>
                                          <span class="DeleteMode"  style="display: none">
                                              <center>
                                                  <h4 class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                  from Item list?
                                                  </h4>
                                              </center>
                                          </span>
                                        </form>
                                    </div>
                                </div>
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
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Line</th>
                                <th>Payment Type</th>
                                <th>Payment Description</th>
                                <th><center>Amount</center></th>
                                <th><center>Check Number</center></th>
                                <th><center>Check Date</center></th>
                                <th><center>Deposited Account Received</center></th>
                                <th><center>SOA</center></th>
                                <th><center>Options</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="row">
              <div class="col-sm-6">
                <div class="col-sm-3">
                  <label for="">Grand Total:</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" class="form-control" disabled="" name="total_line" value="Php 0.00">
                </div>
              </div>
                <div class="col-sm-6">
                    <div class="col-sm-6">
                      {{-- <div class="form-group" style="display: flex;"> --}}
                        <button type="button" class="btn btn-block btn-success" onclick="SaveProposal()"><i class="fa fa-save"></i> Save</button>
                    </div>
                    <div class="col-sm-6">
                      <button type="button" class="btn btn-block btn-primary" style="margin-top: 0;" onclick="javascript:history.go(-1)"><i class="fa fa-arrow-left"></i> Go Back</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<script>
  var selectedId = 0;
  $(document).ready(function(){
            // $('#SideBar_Budget').addClass('active');
            // $('#SideBar_Budget_Budget_Proposal_Entry_New').addClass('text-green');
            let today = new Date().toISOString().slice(0, 10);
            $('input[name="hdr_date"]').val(today);
            $('table').DataTable();
        });
            {{--@isset($ppa)
                                        @foreach ($ppa as $d)
                                            $('#table_{{$d->subgrpid}} tbody').on( 'click', 'tr', function () {
                                                var table = $('#table_{{$d->subgrpid}}').DataTable();
                                                selectedId = table.row(this).index() ;
                                            } );
                                        @endforeach
                                    @endisset--}}
      $('#example1 tbody').on( 'click', 'tr', function () {
                            var table = $('#example1').DataTable();
                            selectedId = table.row( this ).index() ;
                        } );
    function ifCheck(){
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
            $('input[name="itm_desc"]').val(urldecode($('#payment_'+charge_code).attr('c_desc')));
        } else {
          $('input[name="itm_desc"]').val('');
            // alert('No Charge Selected...');
        }
    }
    function loadTotal()
    {
        var tempAmount = 0; // appr = 0, totalBal = 0
        // var truebal = $(".truebal").map(function(){return $(this).attr("truebal");}).get();
        // var appro = $(".appro").map(function(){return $(this).attr("appro");}).get();
        var amt = $(".amt").map(function(){return $(this).attr("amt");}).get();
        if(amt.length > 0){
            for(let i = 0; i < amt.length; i++){
                tempAmount = tempAmount + parseFloat(amt[i]);
                // appr = appr + parseFloat(appro[i]);
            }
            // totalBal = parseFloat(appr) - parseFloat(tempAmount);
            $('input[name="total_line"]').val(formatNumberToMoney(tempAmount));
        } else {
            $('input[name="total_line"]').val(formatNumberToMoney(0));
        }
    }
  function addMode(selected)
  {
    var line = ($('#example1').DataTable().data().count()/ 9) + 1;

    $('input[name="itm_line"]').val(line);
    $('input[name="itm_soa"]').val('');
    $('select[name="itm_payment"]').val('').trigger('change');
    $('input[name="itm_amt"]').val('');
    $('input[name="itm_chk_dt"]').val('');
    $('input[name="itm_chk_num"]').val('');
    $('input[name="itm_dep"]').prop('checked', false);
        // $('input[name="itm_desc"]').val('');
        // name="acct_desc"

    $('.DeleteMode').hide();
    $('.AddMode').show();

    $('#ItemButtonNameButton').removeClass('fa-save');
    $('#ItemButtonNameButton').addClass('fa-plus');
    $('#ItemButtonName').text('Save & Close');
    $('#MOD_MODE').text('(ADD)');
        if(selected != 0){
            $('select[name="itm_ppa"]').val('').trigger('change');
        }
  }
  function InsModiItem(selected)
  {
    if($('#ItmForm').parsley().validate())
    {
      var line = $('input[name="itm_line"]').val();
      var code = $('select[name="itm_soa"]').val(); // SOA
      var payment = $('select[name="itm_payment"]').val();
      var payment_typ = $('select[name="itm_payment"]').select2('data')[0].text;
      var payment_desc = $('input[name="itm_desc"]').val();
      var amt = $('input[name="itm_amt"]').val(); // balance
      var chk_dt = $('input[name="itm_chk_dt"]').val();
      var chk_num = $('input[name="itm_chk_num"]').val();
      var deposited = (payment == '114') ?  (($('input[name="itm_dep"]').prop('checked')) ? 'Y' : 'N') : '';
      var table = $('#example1').DataTable();
      // var acc_title_desc = $('select[name="itm_acc_title"]').select2('data')[0].text; // Charge
      // var acc_title_id = $('select[name="itm_acc_title"]').select2('data')[0].id;
      // var acc_title2_desc = urldecode($('input[name="acct_title_desc"]').val());
      // var acc_title2_id = $('input[name="acct_title_id"]').val();
      // var desc = urldecode($('#chg_'+acc_title_id).attr('c_desc'));
      // var desc = $('input[name="itm_desc"]').val();
      // var subgrpdesc = $('select[name="itm_ppa"]').select2('data')[0].text;
      // var subgrpid = $('select[name="itm_ppa"]').select2('data')[0].id;
      // var old_ppa = $('input[name="itm_old_ppa"]').val();
      if($('#MOD_MODE').text() == '(ADD)')
      {
        table.row.add([
            line,
            '<span class="pay_typ" pay_typ="'+payment+'">'+payment_typ+'</span>',
            '<span class="pay_desc" pay_desc="'+encodeURI(payment_desc)+'">'+payment_desc+'</span>',
            '<center class="amt" amt="'+parseFloat(amt)+'">'+formatNumberToMoney(parseFloat(amt))+'</center>',
            '<center class="chk_num" chk_num="'+chk_num+'">'+((chk_num !='') ? chk_num : 'N/A')+'</center>',
            '<center class="chk_dt" chk_dt="'+chk_dt+'">'+((chk_dt != '')? DateFormatNow(chk_dt) : 'N/A')+'</center>',
            '<center class ="is_dep" is_dep="'+deposited+'">'+((deposited != '') ? ((deposited == 'Y') ? '<strong style="color:green">Yes</strong>' : '<strong style="color:red">No</strong>') : 'N/A')+'</center>',
            '<span class="soa_code" soa_code="'+code+'">'+((code != '') ? code : 'N/A')+'</span>',
            '<center>' +
              '<a class="btn btn-social-icon btn-warning"  data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode(\''+line+'\', \''+payment+'\', \''+encodeURI(payment_desc)+'\', \''+parseFloat(amt)+'\', \''+chk_num+'\', \''+chk_dt+'\', \''+deposited+'\', \''+code+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+line+'\', \''+payment+'\', \''+encodeURI(payment_desc)+'\', \''+parseFloat(amt)+'\', \''+chk_num+'\', \''+chk_dt+'\', \''+deposited+'\', \''+code+'\');"><i class="fa fa-trash "></i></a>' +
            '</center>'
          ]).draw();

        alert('Added '+payment_desc+' to List');
      } else if($('#MOD_MODE').text() == '(EDIT)'){
          table.row(selectedId).data([
            line,
            '<span class="pay_typ" pay_typ="'+payment+'">'+payment_typ+'</span>',
            '<span class="pay_desc" pay_desc="'+encodeURI(payment_desc)+'">'+payment_desc+'</span>',
            '<center class="amt" amt="'+parseFloat(amt)+'">'+formatNumberToMoney(parseFloat(amt))+'</center>',
            '<center class="chk_num" chk_num="'+chk_num+'">'+((chk_num !='') ? chk_num : 'N/A')+'</center>',
            '<center class="chk_dt" chk_dt="'+chk_dt+'">'+((chk_dt != '')? DateFormatNow(chk_dt) : 'N/A')+'</center>',
            '<center class ="is_dep" is_dep="'+deposited+'">'+((deposited != '') ? ((deposited == 'Y') ? '<strong style="color:green">Yes</strong>' : '<strong style="color:red">No</strong>') : 'N/A')+'</center>',
            '<span class="soa_code" soa_code="'+code+'">'+((code != '') ? code : 'N/A')+'</span>',
            '<center>' +
              '<a class="btn btn-social-icon btn-warning"  data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode(\''+line+'\', \''+payment+'\', \''+encodeURI(payment_desc)+'\', \''+parseFloat(amt)+'\', \''+chk_num+'\', \''+chk_dt+'\', \''+deposited+'\', \''+code+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+line+'\', \''+payment+'\', \''+encodeURI(payment_desc)+'\', \''+parseFloat(amt)+'\', \''+chk_num+'\', \''+chk_dt+'\', \''+deposited+'\', \''+code+'\');"><i class="fa fa-trash "></i></a>' +
            '</center>'
          ]).draw();
          alert('Successfully modified '+payment_desc+'.');
      } else {
        table.row(selectedId).remove().draw();

        // var test = ($('.data_table').DataTable().data().count()/ 9) ;
        // var AllData = $('.data_table').DataTable().rows().data();
        // if(($('#example1').DataTable().data().count()/ 9) > 0 )
        // {
        //  for(let i = 0, x = 1; i < ($('#example1').DataTable().data().count()/ 9); i++, x++){
        //    // AllData[i]
        //    table.row(i).data([
        //        x, AllData[i][1], AllData[i][2], AllData[i][3], AllData[i][4], AllData[i][5]
        //      ]).draw();
        //  }
        // }

        alert('Successfully removed '+payment_desc+'.');
      }
      loadTotal();
            if(selected == 1)
          {
            $('#modal-default').modal('toggle');
          } else {
              addMode(0);
          }
      }
  }
  // \''+line+'\', \''+payment+'\', \''+encodeURI(payment_desc)+'\', \''+parseFloat(amt)+'\', \''+chk_num+'\', \''+chk_dt+'\', \''+deposited+'\', \''+code+'\'
  function EditMode(line, payment, payment_desc, amt, chk_num, chk_dt, deposited, soa_code)
  {
    // alert(acc_title_id);
    // $('input[name="true_bal"]').val(true_bal);
    $('input[name="itm_line"]').val(line);
    $('input[name="itm_soa"]').val(soa_code);
    $('select[name="itm_payment"]').val(payment).trigger('change');
    $('select[name="itm_desc"]').val(urldecode(payment_desc));
    $('input[name="itm_amt"]').val(parseFloat(amt));
    $('input[name="itm_chk_dt"]').val(chk_dt);
    $('input[name="itm_chk_num"]').val(chk_num);
    $('input[name="itm_dep"]').prop('checked', ((deposited == '' || deposited == 'N') ? false: true ));

    $('#ItemButtonNameButton').removeClass('fa-plus');
    $('#ItemButtonNameButton').addClass('fa-save');
    $('.DeleteMode').hide();
    $('.AddMode').hide();
    $('.EditMode').show();
    $('#ItemButtonName').text('Save');
    $('#MOD_MODE').text('(EDIT)');
  }
  function DeleteMode(line, payment, payment_desc, amt, chk_num, chk_dt, deposited, soa_code)
  {
    $('input[name="itm_line"]').val(line);
    $('input[name="itm_soa"]').val(soa_code);
    $('select[name="itm_payment"]').val(payment).trigger('change');
    $('select[name="itm_desc"]').val(urldecode(payment_desc));
    $('input[name="itm_amt"]').val(parseFloat(amt));
    $('input[name="itm_chk_dt"]').val(chk_dt);
    $('input[name="itm_chk_num"]').val(chk_num);
    $('input[name="itm_dep"]').prop('checked', ((deposited == '' || deposited == 'N') ? false: true ));

    $('#DeleteName').text(urldecode(payment_desc));
    $('#MOD_MODE').text('(DELETE)');
    $('.AddMode').hide();
    $('.DeleteMode').show();
  }
  function SaveProposal()
  {
    // if($('input[name="hdr_bgtps01"]').val() != '')
        {
            if($('#HdrForm').parsley().validate())
            {
                if(($('#example1').DataTable().data().count()/ 9) != 0)
                {
                    var pay_typ = $(".pay_typ").map(function(){return $(this).attr("pay_typ");}).get();
                    var pay_desc = $(".pay_desc").map(function(){return urldecode($(this).attr("pay_desc"));}).get();
                    var amt = $(".amt").map(function(){return $(this).attr("amt");}).get();
                    var chk_num = $(".chk_num").map(function(){return $(this).attr("chk_num");}).get();
                    var chk_dt = $(".chk_dt").map(function(){return $(this).attr("chk_dt");}).get();
                    var is_dep = $(".is_dep").map(function(){return $(this).attr("is_dep");}).get();
                    var soa_code = $(".soa_code").map(function(){return $(this).attr("soa_code");}).get();
                    // var at_code = $(".at_code").map(function(){return $(this).attr("at_code");}).get();
                    // var subgrpid = $(".subgrpid").map(function(){return $(this).attr("subgrpid");}).get();
                    var data = {
                            _token : $('meta[name="csrf-token"]').attr('content'),
                            pay_typ : pay_typ,
                            pay_desc : pay_desc,
                            amt : amt,
                            chk_num : chk_num,
                            chk_dt : chk_dt,
                            is_dep : is_dep,
                            soa_code : soa_code,

                            col_code : $('select[name="hdr_col"]').val(),
                            fund : $('select[name="hdr_fund"]').val(),
                            dt : $('input[name="hdr_date"]').val(),
                            cust : $('select[name="hdr_cust"]').val(),
                            cust_name : urldecode($('#cust_' + $('select[name="hdr_cust"]').val()).attr('cust_name')),
                            or_typ : $('select[name="hdr_or"]').val(),
                            ref : $('input[name="hdr_ref"]').val(),
                            cashier : $('select[name="hdr_cash"]').val(),
                          };
                        // console.log(data);
                    $.ajax({
                        url : '{{ url('accounting/collection/entry/save') }}',
                        method : 'POST',
                        data : data,
                        success : function(d){
                            if(d == 'DONE'){
                                alert('Successfully Added new Collection Entry');
                                location.href= "{{ url('accounting/collection/entry') }}";

                            } else {
                                alert('ERROR! an unknown error occured during saving process.');
                            }
                        },
                        error : function(a, b, c){
                            console.log(c);
                        }
                    });
                }
                else
                {
                    alert('No Payments to be saved.');
                }
            }
        }
        // else
        // {
        //      alert('Please select Budget Appropriation ');
        // }
  }
    function Loadapproved()
    {
        $.ajax({
            url : '{{ url('budget/budget-approved-entry/getAllProposals') }}',
            data : {_token: $('meta[name="csrf-token"]').attr('content')},
            success : function(data){
                $('select[name="bgt_b_num"]').empty();
                if(data.length > 0){
                    $('select[name="bgt_b_num"]').append('<option value="">Select Budget Appropriation...</option>');
                    for(let i = 0; i < data.length; i++){
                        $('select[name="bgt_b_num"]').append('<option value="'+data[i].b_num+'">'+data[i].b_num+'-'+data[i].t_desc+'</option>');
                    }
                } else {
                    $('select[name="bgt_b_num"]').append('<option value="">No Budget Appropriation/s finalized.</option>'); 
                }
                 $('select[name="bgt_b_num"]').val('').trigger('change');
            },
            error : function(a, b, c){

            },
        });
    }
    {{--function getapprovedEntries()
            {
                var b_num = $('select[name="bgt_b_num"]').val();
                var table = $('#example2').DataTable(); 
                table.clear().draw();
                if(b_num != ''){
                    $.ajax({
                        url : '{{ url('budget/budget-approved-entry/getProposalEntries') }}',
                        method : 'POST',
                        data : {_token: $('meta[name="csrf-token"]').attr('content'), b_num : b_num},
                        success : function(d){
                            if(d.length > 0)
                            {
                                for(let i = 0, j = 1; i < d.length; i++, j++)
                                {
                                    var test = 0;
                                    // if(d[i].deduct != null && d[i].allot != null && d[i].appro_amnt){
                                    //     test = d[i].deduct;
                                    // } else if (d[i].deduct == null && d[i].allot != null && d[i].appro_amnt){
                                    //     test = d[i].allot;
                                    // } else {
                                    //     test = d[i].appro_amnt;
                                    // }
                                    table.row.add([
                                        j,
                                        d[i].at_code,
                                        d[i].at_desc,
                                        d[i].subgrpdesc,
                                        '<center>'+formatNumberToMoney(parseFloat(d[i].act_deduct))+'</center>'
                                        ]).draw();
                                }
                            }
                        },
                        error : function(a, b, c){
                        }
                    });
                }
            }--}}
    // function Insertapproved()
    // {
    //     var b_num = $('select[name="bgt_b_num"]').val();
    //     if(b_num != '')
    //     {
            // $.ajax({
            //     url : '{{ url('budget/budget-approved-entry/getProposalEntries') }}',
            //     method : 'POST',
            //     data : {_token: $('meta[name="csrf-token"]').attr('content'), b_num : b_num},
            //     success : function(d){
            //         if(d.length > 0)
            //         {
            //             for(let i = 0, j = 1; i < d.length; i++, j++)
            //             {
            //                 var test = 0;
            //                 if(d[i].deduct != null && d[i].allot != null && d[i].appro_amnt){
            //                     test = d[i].deduct;
            //                 } else if (d[i].deduct == null && d[i].allot != null && d[i].appro_amnt){
            //                     test = d[i].allot;
            //                 } else {
            //                     test = d[i].appro_amnt;
            //                 }


            //                 var table = $('#table_'+d[i].subgrpid).DataTable();
            //                 table.clear().draw();
            //                 table.row.add([
            //                     j,
            //                     '<span class="cc_code" cc-code="'+d[i].at_code+'">'+d[i].at_code+'</span>',
            //                     d[i].at_desc,
            //                     '<span class="subgrpid" subgrpid="'+d[i].subgrpid+'">' +d[i].subgrpdesc + '</span>',
            //                     '<center class="appro" appro="'+parseFloat(d[i].act_deduct)+'">'+formatNumberToMoney(parseFloat(d[i].act_deduct))+'</center>',
            //                     '<center class="amt truebal" truebal="'+parseFloat(d[i].act_deduct)+'" amt="'+parseFloat(0)+'">'+formatNumberToMoney(parseFloat(0))+'</center>',
            //                     '<center>' +
            //                         '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EditMode(\''+j+'\', \''+d[i].at_code+'\', \''+d[i].appro_amnt+'\', \''+d[i].subgrpid+'\', \''+parseFloat(0)+'\', \''+parseFloat(d[i].act_deduct)+'\');"></i></a>&nbsp;' +
            //                         '<a style="display:none" class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+d[i].at_desc+'\', \''+d[i].at_code+'\', \''+parseFloat(d[i].appro_amnt)+'\', \''+d[i].subgrpid+'\');"><i class="fa fa-trash "></i></a>' +
            //                     '</center>'
            //                     ]).draw();
            //                 loadSubTotal(d[i].subgrpid);
            //             }
            //             loadTotal();
            //         }
            //     },
            //     error : function(a, b, c){
            //         console.log(c);
            //     }
            // });

    //         $.ajax({
    //             url : '{{ url('budget/budget-approved-entry/getProposal') }}',
    //             method : 'POST',
    //             data : {_token: $('meta[name="csrf-token"]').attr('content'), b_num : b_num},
    //             success : function(d){
    //                 if(d.length > 0)
    //                 {
    //                     $('input[name="hdr_fy_mo"]').val(d[0].fy + '-' + d[0].month_desc);
    //                     $('input[name="hdr_fy"]').val(d[0].fy);
    //                     $('input[name="hdr_mo"]').val(d[0].mo);
    //                     $('input[name="hdr_fid_txt"]').val(d[0].fdesc);
    //                     $('input[name="hdr_fid"]').val(d[0].fid);
    //                     $('input[name="hdr_cc_txt"]').val(d[0].cc_desc);
    //                     $('input[name="hdr_cc"]').val(d[0].cc_code);
    //                     $('input[name="hdr_sec_txt"]').val(d[0].secdesc);
    //                     $('input[name="hdr_sec"]').val(d[0].secid);
    //                     $('input[name="hdr_desc_txt"]').val(d[0].t_desc);
    //                     $('input[name="hdr_desc"]').val(d[0].t_desc);
    //                     $('input[name="hdr_bgtps01"]').val(d[0].b_num);
    //                 }
    //             },
    //             error : function (a, b, c){
    //                 console.log(c);
    //             }
    //         });

    //         $.ajax({
    //             url : '{{ url('budget/budget-approved-entry/getRemainingBalance') }}',
    //             method : 'POST',
    //             data : {_token: $('meta[name="csrf-token"]').attr('content'), b_num : b_num},
    //             success : function(data){
    //                 if(data.length > 0){
    //                     if(data[0].deduct != null){
    //                         $('input[name="hdr_total_view"]').val(formatNumberToMoney(parseFloat(data[0].deduct)));
    //                         $('input[name="hdr_total"]').val(parseFloat(data[0].deduct));
    //                     } else if (data[0].allot_amt != null) {
    //                         $('input[name="hdr_total_view"]').val(formatNumberToMoney(parseFloat(data[0].allot_amt)));
    //                         $('input[name="hdr_total"]').val(parseFloat(data[0].allot_amt));
    //                     } else if(data[0].appro_amnt != null){
    //                         $('input[name="hdr_total_view"]').val(formatNumberToMoney(parseFloat(data[0].appro_amnt)));
    //                         $('input[name="hdr_total"]').val(parseFloat(data[0].appro_amnt));
    //                     }
    //                 }
    //                 else{
    //                     $('input[name="hdr_total_view"]').val('N/A');
    //                     $('input[name="hdr_total"]').val(parseFloat(0));
    //                 }
    //             },
    //             error : function(a, b, c){

    //             }
    //         });
    //         alert('Successfully loaded approved');
    //         $('#modal-default2').modal('toggle');
    //     }
    //     else
    //     {
    //         alert('Select Budget Appropriation');
    //     }
    // }
</script>
@endsection