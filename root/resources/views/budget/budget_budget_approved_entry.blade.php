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
          <h3 class="box-title">Filter Data</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> --}}
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="">
          <form id="PerFundCheck" data-parsley-validate novalidate>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                  <label>Financial Year</label>
                  <select class="form-control select2 select2-hidden-accessible" name="sel_fy" onchange="getEntries()" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#sel_fy_span" aria-hidden="true" data-parsley-required-message="<strong>Year</strong> is required." required>
                  @isset($data[0])
                    <option value="">Select Year...</option>
                    @foreach($data[0] as $x03)
                      <option value="{{$x03->fy}}">{{$x03->fy}}</option>
                    @endforeach
                  @else
                    <option value="">No Year registered...</option>
                  @endisset
                </select>
                <span id="sel_fy_span"></span>
              </div>
            </div>
            {{-- <div class="col-md-3">
              <div class="form-group">
                <label>Budget Period</label>
                <select class="form-control select2 select2-hidden-accessible" name="sel_budget" onchange="getEntries();getFromToDate()" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  @isset($data[2])
                    <option value="">Select Budget Period...</option>
                    @foreach($data[2] as $budget_period)
                      <option value="{{$budget_period->budget_code}}" id="bdtper_{{$budget_period->budget_code}}" bp_frm="{{$budget_period->budgetfrom}}" bp_to="{{$budget_period->budgetto}}">{{$budget_period->budget_desc}}</option>
                    @endforeach
                  @else
                    <option value="">No Budget Period registered...</option>
                  @endisset
                </select>
              </div>
            </div> --}}
            {{-- <div class="col-md-3">
              <div class="form-group">
                <label>From</label>
                <input type="date" name="input_date_from" class="form-control">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>To</label>
                <input type="date" name="input_date_to" class="form-control">
              </div>
            </div> --}}
            <div class="col-md-3">
              <div class="form-group">
                <label>From</label>
                <select name="sel_frm" onchange="getEntries()" style="width: 100%" data-parsley-errors-container="#sel_frm_span" aria-hidden="true" data-parsley-required-message="<strong>From month</strong> is required." required>
                    <option value="">Select from month..</option>
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
                <span id="sel_frm_span"></span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>To</label>
                <select name="sel_to" onchange="getEntries()" style="width: 100%" data-parsley-errors-container="#sel_to_span" aria-hidden="true" data-parsley-required-message="<strong>To month</strong> is required." required>
                    <option value="">Select to month..</option>
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
                <span id="sel_to_span"></span>
              </div>
            </div>
            {{-- <div class="col-md-3">
              <div class="form-group">
                <label>Fund</label>
                <select class="form-control select2 select2-hidden-accessible" name="sel_fid" onchange="getEntries()" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    @isset($data[1])
                        <option value="">Select Fund...</option>
                        @foreach($data[1] as $fund)
                            <option value="{{$fund->fid}}">{{$fund->fdesc}}</option>
                        @endforeach
                    @else
                         <option value="">No Fund registered...</option>
                    @endisset
                </select>
              </div>
            </div> --}}
            <div class="col-md-2">
              <div class="form-group">
                <center><label>&nbsp;</label></center>
                <button type="button" class="btn btn-block btn-primary" onclick="newBudgetEntry()"><i class="fa fa-plus"></i> New Allotment</button>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-group">
                <center><label>&nbsp;</label></center>
                <button type="button" class="btn btn-block btn-info"    ><i class="fa fa-print"></i> Print</button>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </form>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Unposted Entries</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="10%">Ref. #</th>
                  {{-- <th>Description</th> --}}
                  {{-- <th>Branch</th> --}}
                  <th>Cost Center</th>
                  <th>Sector</th>
                  <th>Date</th>
                  {{-- <th><center>Finalized</center></th> --}}
                  {{-- <th><center>Closed</center></th> --}}
                  <th width="10%">Options</th>
                </tr>
                </thead>
                <tbody>
               {{-- \ --}}
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
	<script type="text/javascript">
        $(document).ready(function(){
            $('#SideBar_Budget').addClass('active');
            $('#SideBar_Budget_Budget_Approved_Entry').addClass('text-green');
            getEntries();
            // $('#SideBar_MFile_Accounting_Journal').addClass('text-green');
        });
        function getFromToDate()
        {
          var bdug = $('select[name="sel_budget"]').val();
          if(bdug != ''){
            $('input[name="input_date_from"]').val($('#bdtper_' + bdug).attr('bp_frm'));
            $('input[name="input_date_to"]').val($('#bdtper_' + bdug).attr('bp_to'));
          } else {
            $('input[name="input_date_from"]').val('');
            $('input[name="input_date_to"]').val('');
          }
        }
        function getEntries()
        {

            var table = $('#example1').DataTable();
            var fymo =  $('select[name="sel_fy"]').val();
            var frm = $('select[name="sel_frm"]').val();
            var top = $('select[name="sel_to"]').val();
            // var fid = $('select[name="sel_fid"]').val();
            // var bdug = $('select[name="sel_budget"]').val();
            // var from_dt = $('input[name="input_date_from"]').val();
            // var to_dt = $('input[name="input_date_to"]').val();
            table.clear().draw();
            if (fymo != '' && frm != '' && top != '') {
                $.ajax({
                    url : '{{ url('budget/budget-approved-entry/get') }}',
                    data : {_token : $('meta[name="csrf-token"]').attr('content'), fy : fymo, dt_frm : frm, dt_to: top},
                    success : function(data){
                        if (data.length > 0) {
                            for (var i = 0; i < data.length; i++) {
                                var finalized = (data[i].finalized == 'Y') ?  '<i class="fa fa-check" style="font-size:25px;color:green"></i>'
                                            : '<i class="fa fa-times" style="font-size:25px;color:red"></i>';
                                var closed = (data[i].closed == 'Y') ?  '<i class="fa fa-check" style="font-size:25px;color:green"></i>'
                                            : '<i class="fa fa-times" style="font-size:25px;color:red"></i>';
                                var isclosed = (data[i].closed != 'Y') ? 'btn-info' : 'btn-warning';
                                var isIcon = (data[i].closed != 'Y') ? 'fa-eye' : 'fa-pencil';
                                table.row.add([
                                        data[i].b_num,
                                        data[i].cc_desc,
                                        data[i].secdesc,
                                        (data[i].t_date != '') ? stringToDateFormat(data[i].t_date) : 'N/A',
                                        '<center>' +
                                            '<a class="btn btn-social-icon '+isclosed+'" data-toggle="modal" data-target="#modal-default"><i class="fa '+isIcon+'" onclick="EditMode(\''+data[i].b_num+'\');"></i></a>' +
                                        '</center>'
                                    ]).draw();
                            }
                        }
                    },
                    error : function (a, b, c){
                      console.log(c);
                    },

                });
            }
        }
        function newBudgetEntry()
        {
            var fymo =  $('select[name="sel_fy"]').val();
            var frm = $('select[name="sel_frm"]').val();
            var top = $('select[name="sel_to"]').val();
            if ($('#PerFundCheck').parsley().validate() && parseInt(top) > parseInt(frm)) {
              location.href ='{{ url('budget/budget-approved-entry/approve') }}/'+fymo+ '/' + frm + '/' +top;
              // location.href ='{{ url('budget/budget-approved-entry/approve') }}';
            } else {
              if(parseInt(top) < parseInt(frm))
              {
                alert('Error: Please change the selected months');
              }
            }
            // if (fymo != '' && fid != '') {
            //     var test = fymo.split('-');
            //     var fy = test[0];
            //     var mo = test[1];
                // budget/budget-proposal-entry/new/{fy}/{mo}/{fid}
                // location.href ='{{ url('budget/budget-approved-entry/new') }}/'+ fy + '/' + mo + '/' + fid;
            // }
            // 
        }
        function EditMode(b_num)
        {
            location.href ='{{ url('budget/budget-approved-entry') }}/'+ b_num;
        }
    </script>
@endsection