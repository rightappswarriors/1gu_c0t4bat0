@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>url("budget/budget-obligation-entry"),'desc'=>'Obligation Entry','icon'=>'none','st'=>true]
    ];
    $_ch = "Budget Obligation Entry"; // Module Name
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
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Period</label>
                <select class="form-control select2 select2-hidden-accessible" name="sel_fy_mo" onchange="getEntries()" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  @isset($data[0])
                    <option value="">Select Period...</option>
                    @foreach($data[0] as $x03)
                      <option value="{{$x03->fy}}-{{$x03->mo}}">{{$x03->fy}}-{{$x03->month_desc}}</option>
                    @endforeach
                  @else
                    <option value="">No Period registered...</option>
                  @endisset
                </select>
              </div>
            </div>
            <div class="col-md-4">
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
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <center><label>&nbsp;</label></center>
                <button type="button" class="btn btn-block btn-primary" onclick="newBudgetEntry()"><i class="fa fa-plus"></i> New Budget Obligation</button>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <center><label>&nbsp;</label></center>
                <button type="button" class="btn btn-block btn-info"    ><i class="fa fa-print"></i> Print</button>
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
              <h3 class="box-title">Unposted Entries</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="10%">Ref. #</th>
                  <th>Description</th>
                  <th>Date</th>
                  {{-- <th>Branch</th> --}}
                  <th>Cost Center</th>
                  <th>Sector</th>
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
            $('#SideBar_Budget_Budget_Obligation_Entry').addClass('text-green');
            getEntries();
            // $('#SideBar_MFile_Accounting_Journal').addClass('text-green');
        });
        function getEntries()
        {

            var table = $('#example1').DataTable();
            var fymo =  $('select[name="sel_fy_mo"]').val();
            var fid = $('select[name="sel_fid"]').val();
            table.clear().draw();
            if (fymo != '' && fid != '') {
                $.ajax({
                    url : '{{ url('budget/budget-obligation-entry/get') }}',
                    data : {_token : $('meta[name="csrf-token"]').attr('content'), prd : fymo, fid : fid},
                    success : function(data){
                        if (data.length > 0) {
                            for (var i = 0; i < data.length; i++) {
                                // var finalized = (data[i].finalized == 'Y') ?  '<i class="fa fa-check" style="font-size:25px;color:green"></i>'
                                //             : '<i class="fa fa-times" style="font-size:25px;color:red"></i>';
                                // var closed = (data[i].closed == 'Y') ?  '<i class="fa fa-check" style="font-size:25px;color:green"></i>'
                                //             : '<i class="fa fa-times" style="font-size:25px;color:red"></i>';
                                var isclosed = (data[i].closed != 'Y') ? 'btn-info' : 'btn-warning';
                                var isIcon = (data[i].closed != 'Y') ? 'fa-eye' : 'fa-pencil';
                                table.row.add([
                                        data[i].j_num,
                                        data[i].t_desc,
                                        stringToDateFormat(data[i].t_date),
                                        // data[i].name,
                                        // data[i].fdesc,
                                        data[i].cc_desc,
                                        data[i].secdesc,
                                        // '<center>'+finalized+'</center>',
                                        // '<center>'+closed+'</center>',
                                        '<center>' +
                                            '<a class="btn btn-social-icon '+isclosed+'" data-toggle="modal" data-target="#modal-default"><i class="fa '+isIcon+'" onclick="EditMode(\''+data[i].j_num+'\');"></i></a>' +
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
            // if (fymo != '' && fid != '') {
            //     var test = fymo.split('-');
            //     var fy = test[0];
            //     var mo = test[1];
                // budget/budget-proposal-entry/new/{fy}/{mo}/{fid}
                // location.href ='{{ url('budget/budget-approved-entry/new') }}/'+ fy + '/' + mo + '/' + fid;
            // }
            location.href ='{{ url('budget/budget-obligation-entry/new') }}';
        }
        function EditMode(b_num)
        {
            location.href ='{{ url('budget/budget-obligation-entry') }}/'+ b_num;
        }
    </script>
@endsection