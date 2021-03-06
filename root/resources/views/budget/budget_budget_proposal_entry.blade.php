@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>url("budget/budget-proposal-entry"),'desc'=>'Proposal Entry','icon'=>'none','st'=>true]
    ];
    $_ch = "Budget Appropriation Entry"; // Module Name
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
                <label>Year</label>
                <select class="form-control select2 select2-hidden-accessible" name="sel_fy_mo" onchange="getEntries()" style="width: 100%;" tabindex="-1" data-parsley-errors-container="#sel_fy_span" aria-hidden="true" data-parsley-required-message="<strong>Year</strong> is required." required>
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
            <div class="col-md-3">
              <div class="form-group" style="display: none">
                <label>Fund</label>
                <select class="form-control select2 select2-hidden-accessible" name="sel_fid" onchange="getEntries()" data-parsley-required-message="<strong>Fund</strong> is required." style="width: 100%;" data-parsley-errors-container="#sel_fid_span" tabindex="-1" aria-hidden="true">
                    @isset($data[1])
                        <option value="">Select Fund...</option>
                        @foreach($data[1] as $fund)
                            <option value="{{$fund->fid}}">{{$fund->fdesc}}</option>
                        @endforeach
                    @else
                         <option value="">No Fund registered...</option>
                    @endisset
                </select>
                <span id="sel_fid_span"></span>
              </div>
            </div>
            <div class="col-sm-2 pull-right">
              <div class="form-group">
                <center><label>&nbsp;</label></center>
                {{-- <button type="button" class="btn btn-block btn-info"><i class="fa fa-print"></i> Print</button> --}}
                <a class="btn btn-block btn-info" data-toggle="modal" data-target="#printall-modal"><i class="fa fa-print"></i> Print</a>
              </div>
            </div>
            <div class="col-md-3 pull-right">
              <div class="form-group">
                <center><label>&nbsp;</label></center>
                <button type="button" class="btn btn-block btn-primary" onclick="newBudgetEntry()"><i class="fa fa-plus"></i> New Budget Appropriation</button>
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
              <h3 class="box-title">Unposted Entries</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="10%">Code</th>
                  <th>Year</th>
                  <th>Fund</th>
                  <th>Sector</th>
                  <th>Function</th>
                  <th>Office</th>
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
      <div class="row">
      <div class="modal fade in" id="printall-modal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Print All Budget Appropriation</h4>
            </div>
            <div class="modal-body">
            <form id="printall" data-parsley-validate novalidate>
            <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Year</label>
                <select class="form-control select2 select2-hidden-accessible" name="select_fy" style="width: 100%;" tabindex="-1" data-parsley-errors-container="#select_fy" aria-hidden="true" data-parsley-required-message="<strong>Year</strong> is required." required>
                  @isset($data[0])
                    <option value="">Select Year...</option>
                    @foreach($data[0] as $x03)
                      <option value="{{$x03->fy}}">{{$x03->fy}}</option>
                    @endforeach
                  @else
                    <option value="">No Year registered...</option>
                  @endisset
                </select>
                <span id="select_fy"></span>
              </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Fund</label>
                <select class="form-control select2 select2-hidden-accessible" name="select_fid" data-parsley-required-message="<strong>Fund</strong> is required." style="width: 100%;" data-parsley-errors-container="#select_fid" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Fund</strong> is required." required>
                    @isset($data[1])
                        <option value="">Select Fund...</option>
                        @foreach($data[1] as $fund)
                            <option value="{{$fund->fid}}">{{$fund->fdesc}}</option>
                        @endforeach
                    @else
                         <option value="">No Fund registered...</option>
                    @endisset
                </select>
                <span id="select_fid"></span>
              </div>
            </div>
            </div>
             </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" onclick="printAll()">Generate</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      </div>
    </section>
	<script type="text/javascript">
        $(document).ready(function(){
            $('#SideBar_Budget').addClass('active');
            $('#SideBar_Budget_Budget_Proposal_Entry').addClass('text-green');
            getEntries();
            // $('#SideBar_MFile_Accounting_Journal').addClass('text-green');
        });
        function getEntries()
        {

            var table = $('#example1').DataTable();
            var fymo =  $('select[name="sel_fy_mo"]').val();
            // var fid = $('select[name="sel_fid"]').val();
            table.clear().draw();
            //  && fid != ''
            if (fymo != '') {
                $.ajax({
                    url : '{{ url('budget/budget-proposal-entry/get') }}',
                    data : {_token : $('meta[name="csrf-token"]').attr('content'), prd : fymo},
                    success : function(data){
                        if (data.length > 0) {
                            for (var i = 0; i < data.length; i++) {
                                var finalized = (data[i].finalized != 'Y') ?  '<i class="fa fa-check" style="font-size:25px;color:green"></i>'
                                            : '<i class="fa fa-times" style="font-size:25px;color:red"></i>';
                                var closed = (data[i].closed != 'Y') ?  '<i class="fa fa-check" style="font-size:25px;color:green"></i>'
                                            : '<i class="fa fa-times" style="font-size:25px;color:red"></i>';
                                var isclosed = (data[i].closed != 'Y') ? 'btn-info' : 'btn-warning';
                                var isIcon = (data[i].closed != 'Y') ? 'fa-eye' : 'fa-pencil';

                                table.row.add([
                                        data[i].b_num,
                                        data[i].fy,
                                        data[i].fund,
                                        data[i].sector,
                                        data[i].function,
                                        data[i].office,
                                        '<center>' +
                                            '<a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode(\''+data[i].b_num+'\');"></i></a>' +
                                            '<a class="btn btn-social-icon btn-info" data-toggle="modal" data-target="#modal-default"><i class="fa fa-print" onclick="PrintMode(\''+data[i].b_num+'\');"></i></a>' +
                                            // '<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode();"><i class="fa fa-trash "></i></a>'
                                        '</center>'
                                    ]).draw();
                            }
                        }
                    },
                    error : function (a, b, c){},

                });
            }
        }
        function newBudgetEntry()
        {
            var fymo =  $('select[name="sel_fy_mo"]').val();
            var fid = $('select[name="sel_fid"]').val();
            if ($('#PerFundCheck').parsley().validate()) {
                var test = fymo.split('-');
                var fy = test[0];
                var mo = test[1];
                // budget/budget-proposal-entry/new/{fy}/{mo}/{fid}
                location.href ='{{ url('budget/budget-proposal-entry/new') }}/'+ fy  + '/' + fid;
            }
        }
        function EditMode(b_num)
        {
            location.href ='{{ url('budget/budget-proposal-entry') }}/'+ b_num;
        }

        function PrintMode(b_num)
        {

           location.href ='{{ url('budget/budget-proposal-entry/print') }}/'+ b_num;
        }

        function printAll()
        {
           if ($('#printall').parsley().validate()) 
           {
                var fy =  $('select[name="select_fy"]').val();
                var fid = $('select[name="select_fid"]').val();
                var fund = $('select[name="select_fid"]').select2('data')[0].text;

                var data = [fy, fid, fund];

                //alert(data);

                location.href ='{{ url('budget/printallappro') }}/'+ data;

                // $.ajax({
                //   url: '{{ url('budget/printallappro') }}',
                //   method: 'POST',
                //   data : {_token : $('meta[name="csrf-token"]').attr('content'), fy : fy, fid : fid, fund : fund},
                //   success : function(data){
                //       alert(data);
                //   }
                // });
           }
        }













    </script>
@endsection