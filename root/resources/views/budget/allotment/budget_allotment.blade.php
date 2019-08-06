@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>url("budget/budget-approved-entry"),'desc'=>'Allotment Entry','icon'=>'none','st'=>true]
    ];
    $_ch = "Budget Allotment"; // Module Name
@endphp
@section('content')
<!-- Content Header (Page header) -->
@include('layout._contentheader')
<!-- Main content -->
<section class="content">
 <div class="box box-default">
 <div class="box-header with-border">
    <div class="row">
      <br>
      <div class="col-md-3">
        <button type="button" class="btn btn-block btn-primary" onclick="Allotment_Modal('appro');"><i class="fa fa-plus"></i> Load data from Appropriation</button>
      </div>
      <div class="col-md-3">
        <button type="button" class="btn btn-block btn-warning" onclick="Allotment_Modal('oblig');"><i class="fa fa-plus"></i> Equal to Obligation</button>
      </div>
      <div class="col-md-3">
        <button type="button" class="btn btn-block btn-info" onclick="Allotment_Modal('manual');"><i class="fa fa-plus"></i> Manual Entry</button>
      </div>
    </div>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
 </div>
 <!-- /.box-header -->
 <div class="box-body" style="">
 </div>
 <!-- /.box-body -->
 <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Budget Allotment Entries</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="10%">Code</th>
                  <th>FY</th>
                  <th>Fund</th>
                  <th>Sector</th>
                  <th>Function</th>
                  <th>Office</th>
                  <th>Type</th>
                  <th width="10%">Options</th>
                </tr>
                </thead>
                <tbody>
                @isset($allotment)
                @foreach($allotment as $a)
                <tr>
                  <td>{{$a->b_num}}</td>
                  <td>{{$a->fy}}</td>
                  <td>{{$a->fund}}</td>
                  <td>{{$a->sector}}</td>
                  <td>{{$a->function}}</td>
                  <td>{{$a->office}}</td>
                  <td>{{$a->type}}</td>
                  <td><a class="btn btn-social-icon btn-info" data-toggle="modal" data-target="#modal-default"><i class="fa fa-print" onclick="PrintMode('{{$a->b_num}}');"></i></a></td>
                </tr>
                @endforeach
                @endisset
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
 </div>
 <!-- /.row -->
 <!-- Start Modal -->
<div class="row">
<div class="modal fade in" id="allotment-modal">
  <div class="modal-dialog">
    <div class="modal-content">
       <div class="modal-header">
        <h4 class="modal-title"><span id="AM_TITLE"></span></h4>
       </div>
       <div class="modal-body">
        {{-- Start Appro --}}
        <span class="ApproMode">
          <div class="box-body">
          <form id="appro-form" data-parsley-validate novalidate>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Financial Year</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_fy" data-parsley-errors-container="#validate_select_fy" data-parsley-required-message="<strong>Financial Year is required.</strong>" required>
                      <option value="" selected="selected">--- Select Financial Year ---</option>
                      @foreach($financialyear as $fy)
                      <option value="{{$fy->fy}}">{{$fy->fy}}</option>
                      @endforeach
                    </select>
                    <span class="validate_select_fy"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>From</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_from" data-parsley-errors-container="#validate_select_from" data-parsley-required-message="<strong>From Month is required.</strong>" required>
                      <option value="" selected="selected">--- Select From Month ---</option>
                      <option value="1">January</option>
                      <option value="2">February</option>
                      <option value="3">March</option>
                      <option value="4">April</option>
                      <option value="5">May</option>
                      <option value="6">June</option>
                      <option value="7">July</option>
                      <option value="8">August</option>
                      <option value="9">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>        
                    </select>
                    <span class="validate_select_from"></span>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>To</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_to" data-parsley-errors-container="#validate_select_to" data-parsley-required-message="<strong>To Month is required.</strong>" required>
                      <option value="" selected="selected">--- Select To Month ---</option>
                      <option value="1">January</option>
                      <option value="2">February</option>
                      <option value="3">March</option>
                      <option value="4">April</option>
                      <option value="5">May</option>
                      <option value="6">June</option>
                      <option value="7">July</option>
                      <option value="8">August</option>
                      <option value="9">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>   
                    </select>
                    <span class="validate_select_to"></span>
                </div>
              </div>
            </div>
          </form>
          </div>
        </span>
        {{-- End Appro --}}
        {{-- Start Oblig --}}
        <span class="ObligMode">
          <div class="box-body">
          <div class="row">
              <div class="col-sm-12">
                <h4><center>Are you sure you want to generate data from the <strong>Obligation</strong>?</center></h4>
              </div>
          </div>
          </div>
        </span>
        {{-- End Oblig --}}
        {{-- Start Manual --}}
        <span class="ManualMode">
          <div class="box-body">
          <form id="manual-form" data-parsley-validate novalidate>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Financial Year</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_fym" data-parsley-errors-container="#validate_select_fym" data-parsley-required-message="<strong>Financial Year is required.</strong>" required>
                      <option value="" selected="selected">--- Select Financial Year ---</option>
                      @foreach($financialyear as $fy)
                      <option value="{{$fy->fy}}">{{$fy->fy}}</option>
                      @endforeach
                    </select>
                    <span class="validate_select_fym"></span>
                </div>
              </div>
            </div>
            {{-- <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Fund</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_fund" data-parsley-errors-container="#validate_select_fund" data-parsley-required-message="<strong>Financial Year is required.</strong>" required>
                      <option value="" selected="selected">--- Select Fund ---</option>
                      @foreach($fund as $fd)
                      <option value="{{$fd->fid}}">{{$fd->fdesc}}</option>
                      @endforeach
                    </select>
                    <span class="validate_select_fund"></span>
                </div>
              </div>
            </div> --}}
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Search</label>
                  <input list="select_acctCode" name="select_acctCode" style="width: 100%;" onchange="getApproAmt(value)"> 
                  <datalist id="select_acctCode">
                    @foreach($manual as $m) 
                    <option value="{{$m->cc_code}} - {{$m->at_code}}"> 
                    @endforeach
                  </datalist>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Appropriation</label>
                  <input type="text" class="form-control" name="txt_appro">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Allotment</label>
                  <input type="text" class="form-control" name="txt_allot">
                </div>
              </div>
            </div>
          </form>
          </div>
        </span>
        {{-- End Manual --}}
       </div>
       <div class="modal-footer">  
          <span class="ApproMode">
            <button type="button" class="btn btn-success" onclick="loadDataFromAppro();">Load Data</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </span>
          <span class="ObligMode">
            <button type="button" class="btn btn-success" onclick="loadDataFromOblig();">Yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
          </span>
          <span class="ManualMode">
            <button type="button" class="btn btn-success" onclick="saveManual();">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </span>
       </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
</div>
<!-- End Modal -->
</div>

<script>

  function Allotment_Modal(type)
  {
     if(type == 'appro')
     {
       $('#AM_TITLE').text('Load Data From Appropriation');
       $('.ApproMode').show();
       $('.ObligMode').hide();
       $('.ManualMode').hide();
     }
     else if(type == 'oblig')
     {
       $('#AM_TITLE').text('Load Data From Obligation');
       $('.ApproMode').hide();
       $('.ObligMode').show();
       $('.ManualMode').hide();
     }
     else if(type == 'manual')
     {
       $('#AM_TITLE').text('Manual Allotment');
       $('.ApproMode').hide();
       $('.ObligMode').hide();
       $('.ManualMode').show();
     }

     $('#allotment-modal').modal('toggle');
  }

  function loadDataFromAppro()
  {
     if($('#appro-form').parsley().validate()) // check appro form
     {
        var data = { 
                     _token : $('meta[name="csrf-token"]').attr('content'),
                     fy: $('select[name="select_fy"]').select2('data')[0].id,
                     from_mo: $('select[name="select_from"]').select2('data')[0].id,
                     to_mo: $('select[name="select_to"]').select2('data')[0].id,
                   };
        $.ajax({
                 url: '{{route('budget.loaddatafromappro')}}',
                 method: 'POST',
                 data: data,
                 success : function(flag)
                          {
                             if(flag == 'true')
                             {
                               location.href= "{{route('budget.allotment')}}";
                             }
                             else
                             {
                               alert('SYSTEM ERROR:\n'+flag);
                             }
                          }
                 });           
     }
  }

  function loadDataFromOblig()
  {
    $.ajax({
              url: '{{route('budget.loaddatafromoblig')}}',
              method: 'GET',
              success : function(flag)
                       {
                          if(flag == 'true')
                          {
                            location.href= "{{route('budget.allotment')}}";
                          }
                          else
                          {
                            alert('SYSTEM ERROR:\n'+flag);
                          }
                       }
              });  
  }

  function getApproAmt(value)
  {
    var fy =  $('select[name="select_fym"]').select2('data')[0].id;

    var data =  {
                   _token : $('meta[name="csrf-token"]').attr('content'),
                   fy : fy,
                   at_code : value,
                };

    $.ajax({
                 data: data,
                 url : '{{ route('budget.getdatafromappro') }}',
                 method: 'POST',
                 success : function(data)
                           {
                             $('input[name="txt_appro"]').val(parseFloat(data).toLocaleString());
                           }
        });
  }

  function saveManual()
  {
    var fy =  $('select[name="select_fym"]').select2('data')[0].id;
    var atcc_code =  $('input[name="select_acctCode"]').val();
    var appro_amt = $('input[name="txt_appro"]').val();
    var allot_amt = $('input[name="txt_allot"]').val();

    var data =  {
                   _token : $('meta[name="csrf-token"]').attr('content'),
                   atcc_code : atcc_code,
                   appro_amt : appro_amt,
                   allot_amt : allot_amt,
                   fy : fy,
                };

    $.ajax({
                 data: data,
                 url : '{{ route('budget.savemanual') }}',
                 method: 'POST',
                 success : function(flag)
                           {
                             if(flag == 'true')
                             {
                               location.href= "{{route('budget.allotment')}}";
                             }
                             else
                             {
                               alert('SYSTEM ERROR:\n'+flag);
                             }
                           }
        });

  }

  function PrintMode(b_num)
  {

     location.href ='{{ url('budget/allotment/print-allot') }}/'+ b_num;
  }

</script>
</section>
@endsection