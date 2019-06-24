@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Masterfile','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Accounting','icon'=>'none','st'=>false],
        ['link'=>url("master-file/accounting/budget-period"),'desc'=>'Budget Period','icon'=>'none','st'=>true]
    ];
    $_ch = "Budget Period"; // Module Name
@endphp
@section('content')
		<!-- Content Header (Page header) -->
		@include('layout._contentheader')
        <!-- Main content -->
        <section class="content">
        	<div class="row">
        		<div class="col-xs-12">
        			<div class="box">
        				<div class="box-header">
        					<h3 class="box-title">Budget Period List</h3>
        					<button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
        					<div class="modal fade in" id="modal-default">
        						<div class="modal-dialog">
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Period <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-4 control-label">Code <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_id" onchange="" maxlength="3" class="form-control" placeholder="Code"  data-parsley-required-message="<strong>Code</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="form-group"> --}}
                                                            {{-- <label class="col-sm-4 control-label">Description <span class="text-red">*</span></label> --}}
                                                            {{-- <div class="col-sm-8" style="margin-bottom:10px;"> --}}
                                                                <!-- <input type="text" name="month_desc" class="form-control" placeholder="Description"> -->
                                                            {{-- </div> --}}
                                                        {{-- </div> --}}
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Description <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" class="form-control" placeholder="Description" name="txt_name" style="width: 100%" data-parsley-errors-container="#txt_desc" data-parsley-required-message="<strong>Description</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">From <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="date" class="form-control" data-parsley-required-message="<strong>Date From</strong> is required." name="txt_date_from" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">To <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="date" class="form-control" data-parsley-required-message="<strong>Date To</strong> is required."  name="txt_date_to" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <h4 class="text-transform: uppercase;">Are you sure you want to closed <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        budget period?
                                                        </h4>
                                                    </center>
                                                </span>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <span class="AddMode">
                                                <button type="button" onclick="$('#AddForm').submit()" class="btn btn-success"><i class="fa fa-plus"></i> Save</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                            </span>
                                            <span class="DeleteMode" style="display: none">
                                                <button type="button" onclick="$('#AddForm').submit()" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                                <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                            </span>
                                        </div>
        							</div><!-- /.modal-content -->
        						</div><!-- /.modal-dialog -->
        					</div><!-- /.modal -->
        				</div><!-- /.box-header -->
        				<div class="box-body">
        					<table id="example1" class="table table-bordered table-striped">
        						<thead>
                                    <tr>
                                        <th><center>Code</center></th>
                                        <th><center>Description</center></th>
                                        <th><center>From</center></th>
                                        <th><center>To</center></th>
                                        <th><center>Journalize</center></th>
                                        {{-- <th><center>MO</center></th> --}}
                                        <th width="15%"><center>Options</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@isset($budget_period)
                                        @foreach($budget_period as $x3)
                                            <tr>
                                                <th><center>{{$x3->budget_code}}</center></th>
                                                <td><center>{{$x3->budget_desc}}</center></td>
                                                <td class="center"><center>{{$x3->budgetfrom_desc}}</center></td>
                                                <td class="center"><center>{{$x3->budgetto_desc}}</center></td>
                                                <td>
                                                    <center>
                                                    @if($x3->closed == null)
                                                      <span style="color:red"><strong>NO</strong></span>
                                                    @elseif($x3->closed == 'Y')
                                                      <span style="color:green"><strong>YES</strong></span>
                                                    @endif
                                                  </center>
                                                </td>
                                                {{-- <td class="center"><center>{{$x3->mo}}</center></td> --}}
                                                <td>
                                                    <center style="display:none">
                                                       <a class="btn btn-social-icon btn-success" data-toggle="modal" data-target="#modal-default"><i class="fa fa-check" onclick="EditMode();" disabled></i></a>
                                                       {{-- <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$x3->mag_code}}', '{{$x3->mag_desc}}');"><i class="fa fa-trash "></i></a> --}}
                                                    </center>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <th>Rendering engine</th>
                                        <th>Browser</th>
                                        <th>Platform(s)</th>
                                        <th>Engine version</th>
                                        <th>CSS grade</th>
                                    </tr>
                                </tfoot> --}}
        					</table>
        				</div> <!-- /.box-body -->
        			</div> <!-- /.box -->
        		</div> <!-- /.col -->
        	</div> <!-- /.row -->
        </section> <!-- /.content -->
	<script type="text/javascript">
        $(document).ready(function(){
            $('#SideBar_MFile').addClass('active');
            $('#SideBar_MFile_Accounting').addClass('text-green');
            $('#SideBar_MFile_Accounting_Budget_Period').addClass('text-green');
        });
        var getDaysInMonth = function(month,year) {
            // Here January is 1 based
            //Day 0 is the last day in the previous month
           return new Date(year, month, 0).getDate();
          // Here January is 0 based
          // return new Date(year, month+1, 0).getDate();
          };
      //   function getTheDays(){
      //   var yr = $('input[name="txt_yr"]').val();
      //   var mo = $('select[name="txt_mo"]').val();
      //   if ((yr != '') && (mo != '')) {
      //       if (yr.length == 4) {
      //           var yr1 = parseInt(yr, 10);
      //           var mo1 = parseInt(mo, 10);
      //           // var leMO = (mo1 == 10 ? 12 : (mo1 + 2) % 12).toString();
      //           // console.log(leMO);
      //           var date1 = yr1.toString() + '-' + ((mo1.toString().length == 2) ? mo1.toString() : '0' + mo1.toString()) + '-01';
      //           var date2 = yr1.toString() + '-' + ((mo1.toString().length == 2) ? mo1.toString() : '0' + mo1.toString()) + '-' + getDaysInMonth(mo1, yr1);
      //           console.log('Date1 =' + date1);
      //           console.log('Date2 =' + date2);
      //           if (mo1 != 0) {
      //             // $('input[name="txt_mo2"]').val(leMO);
      //             $('input[name="txt_date_from"]').val(date1);
      //             $('input[name="txt_date_to"]').val(date2);
      //           }
      //           // console.log(date1);
      //       }
      //   }
      // }
      function getDesc()
      {
        $().val($('select[name="txt_mo"]').select2('data')[0].text)
      }
        function AddMode()
        {
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/budget-periods') }}');
            $('input[name="txt_id"]').val('');
            $('input[name="txt_id"]').removeAttr('readonly');
            $('input[name="txt_name"]').val('');
            $('input[name="txt_name"]').attr('required', '');
            // $('select[name="sel_type"]').attr('required', '');
            // $('select[name="sel_type"]').val('').trigger('change');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function EditMode(id, desc, acc_id)
        {
            $('#MOD_MODE').text('(Edit)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/budget-periods') }}/update');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').attr('required', '');
            $('input[name="txt_id"]').attr('readonly', '');
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').attr('required', '');
            // $('select[name="sel_type"]').attr('required', '');
            // $('select[name="sel_type"]').val(acc_id).trigger('change');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function DeleteMode(id, desc)
        {
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/budget-periods') }}/delete');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').removeAttr('required');
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').attr('required', '');
            $('select[name="sel_type"]').removeAttr('required');
            $('#DeleteName').text(desc);
            $('.DeleteMode').show();
            $('.AddMode').hide();
        }
    </script>
@endsection