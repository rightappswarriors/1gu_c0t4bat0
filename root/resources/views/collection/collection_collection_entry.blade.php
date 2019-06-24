@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'City Treasurer','icon'=>'none','st'=>false],
        // ['link'=>'#','desc'=>'Collection Entry','icon'=>'none','st'=>false],
        ['link'=>url("accounting/collection/entry"),'desc'=>'Collection Entry','icon'=>'none','st'=>true]
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
          <h3 class="box-title">Options</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> --}}
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="">
          <form id="PerFundCheck" data-parsley-validate novalidate>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                {{-- <label>Financial Year</label> --}}
                {{-- <select class="form-control select2 select2-hidden-accessible" name="sel_fy_mo" onchange="getEntries()" style="width: 100%;" tabindex="-1" data-parsley-errors-container="#sel_fy_span" aria-hidden="true" data-parsley-required-message="<strong>Period</strong> is required." required>
                  @isset($x03)
                    <option value="">Select Period...</option>
                    @foreach($x03 as $x3)
                      <option value="{{$x3->fy}}">{{$x3->fy}}</option>
                    @endforeach
                  @else
                    <option value="">No Period registered...</option>
                  @endisset
                </select> --}}
                <span id="sel_fy_span"></span>
              </div>
            </div>
            {{-- <div class="col-md-3">
              <div class="form-group">
                <label>Budget Period</label>
                <select class="form-control select2 select2-hidden-accessible" name="sel_budget" onchange="getEntries()" style="width: 100%;" tabindex="-1" data-parsley-errors-container="#sel_budget_span" aria-hidden="true" data-parsley-required-message="<strong>Budget Period</strong> is required." required>
                  @isset($budget_period)
                    <option value="">Select Period...</option>
                    @foreach($budget_period as $b)
                      <option value="{{$b->budget_code}}">{{$b->budget_desc}}</option>
                    @endforeach
                  @else
                    <option value="">No Period registered...</option>
                  @endisset
                </select>
                <span id="sel_budget_span"></span>
              </div>
            </div> --}}
            <div class="col-md-4">
              <div class="form-group">
                {{-- <label>Fund</label> --}}
                {{-- <select class="form-control select2 select2-hidden-accessible" name="sel_fid" onchange="getEntries()" data-parsley-required-message="<strong>Fund</strong> is required." style="width: 100%;" data-parsley-errors-container="#sel_fid_span" tabindex="-1" aria-hidden="true" required>
                    @isset($fund)
                        <option value="">Select Fund...</option>
                        @foreach($fund as $f)
                            <option value="{{$f->fid}}">{{$f->fdesc}}</option>
                        @endforeach
                    @else
                         <option value="">No Fund registered...</option>
                    @endisset
                </select> --}}
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
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Collection</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="10%">Collection Code</th>
                  <th width="10%">Reference</th>
                  {{-- <th>Description</th> --}}
                  {{-- <th>Branch</th> --}}
                  <th>Customer</th>
                  <th>OR Type</th>
                  <th>Date</th>
                  <th>Cashier</th>
                  <th>Fund</th>
                  {{-- <th><center>Finalized</center></th> --}}
                  {{-- <th><center>Approved</center></th> --}}
                  <th width="10%"><center>Options</center></th>
                </tr>
                </thead>
                <tbody>
                @isset ($col_hdr)
                    @if(count($col_hdr) > 0)
                      @foreach ($col_hdr as $data)
                        <tr>
                          <td>{{$data->col_code}}</td>
                          <td>{{$data->or_ref}}</td>
                          <td>{{$data->debt_name}}</td>
                          <td>{{$data->or_code}}</td>
                          <td>{{date_format(date_create($data->trnx_date), 'M d, Y')}}</td>
                          <td>{{$data->opr_name}}</td>
                          <td>{{$data->fdesc}}</td>
                          <td>
                            <center>
                              <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$data->col_code}}');"></i></a>
                            </center>
                          </td>
                        </tr>
                      @endforeach
                    @endif
                @endisset
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <input type="file" class="form-control" name="itm_import" data-parsley-required-message="<strong>CSV file</strong> is required." required>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" onclick="SubmitImport()" class="btn btn-success"><i id="" class="fa fa-plus"></i> <spa>Import</span></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
	<script type="text/javascript">

        $(document).ready(function(){
            // $('#SideBar_Budget').addClass('active');
            // $('#SideBar_Budget_Budget_Proposal_Entry_New').addClass('text-green');
            // getEntries();
            // $('#SideBar_MFile_Accounting_Journal').addClass('text-green');
        });
        function getEntries()
        {

            var table = $('#example1').DataTable();
            var fymo =  $('select[name="sel_fy_mo"]').val();
            var budget = $('select[name="sel_budget"]').val();
            var fid = $('select[name="sel_fid"]').val();
            if (fymo != '' && fid != '' && budget != '') {
            table.clear().draw();
                $.ajax({
                    url : '{{ url('budget/budget-proposal-entry-new/get') }}',
                    data : {_token : $('meta[name="csrf-token"]').attr('content'), prd : fymo, fid : fid, budget : budget},
                    success : function(data){
                        if (data.length > 0) {
                            for (var i = 0; i < data.length; i++) {
                                var finalized = (data[i].finalized != 'Y') ?  '<i class="fa fa-check" style="font-size:25px;color:green"></i>'
                                            : '<i class="fa fa-times" style="font-size:25px;color:red"></i>';
                                var closed = (data[i].closed != 'Y') ?  '<i class="fa fa-check" style="font-size:25px;color:green"></i>'
                                            : '<i class="fa fa-times" style="font-size:25px;color:red"></i>';
                                var isclosed = (data[i].closed == 'Y') ? 'btn-info' : 'btn-warning';
                                var isIcon = (data[i].closed == 'Y') ? 'fa-eye' : 'fa-pencil';
                                table.row.add([
                                        data[i].b_num,
                                        // data[i].t_desc,
                                        // data[i].name,
                                        // data[i].fdesc,
                                        data[i].cc_desc,
                                        data[i].secdesc,
                                        stringToDateFormat(data[i].t_date),
                                        // '<center>'+finalized+'</center>',
                                        // '<center>'+closed+'</center>',
                                        '<center>' +
                                            '<a class="btn btn-social-icon '+isclosed+'" data-toggle="modal" data-target="#modal-default"><i class="fa '+isIcon+'" onclick="EditMode(\''+data[i].b_num+'\');"></i></a>' +
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
            // var fymo =  $('select[name="sel_fy_mo"]').val();
            // var fid = $('select[name="sel_fid"]').val();
            // var budget = $('select[name="sel_budget"]').val();
            // if ($('#PerFundCheck').parsley().validate()) {
            //     var test = fymo.split('-');
            //     var fy = test[0];
            //     var mo = test[1];
            //     location.href ='{{ url('budget/budget-proposal-entry-new/new') }}/'+ fy + '/' + fid;
            // }
            location.href = '{{ url('accounting/collection/entry/new') }}';
        }
        function EditMode(b_num)
        {
            location.href ='{{ url('accounting/collection/entry/') }}/'+ b_num;
        }
        function SubmitImport(){
        if($('#ItmForm2').parsley().validate())
        {
            var formData = new FormData();
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('file', $('input[name="itm_import"]')[0].files[0]);

            $.ajax({
                   url : '{{url('accounting/collection/entry/new')}}/import',
                   type : 'POST',
                   data : formData,
                   processData: false,  // tell jQuery not to process the data
                   contentType: false,  // tell jQuery not to set contentType
                   success : function(data) {
                    if(data == 'DONE') {
                        alert('Successfully imported data from csv.');
                        $('#modal-default2').modal('toggle');
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
    </script>
@endsection