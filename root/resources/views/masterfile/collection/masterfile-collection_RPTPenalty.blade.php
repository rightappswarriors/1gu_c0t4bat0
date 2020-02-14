@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Masterfile','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Accounting','icon'=>'none','st'=>false],
        ['link'=>url("master-file/accounting/fund"),'desc'=>'Fund','icon'=>'none','st'=>true]
    ];
    $_ch = "RPT Penalty"; // Module Name
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
        					<h3 class="box-title">RPT Penalty List</h3>
        					<button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
        					<div class="modal fade in" id="modal-default">
        						<div class="modal-dialog">
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Funds <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-4 control-label">Year <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="year" class="form-control" placeholder="Year">
                                                                <input type="hidden" name="id">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">January <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" name="m[1]" class="form-control" placeholder="January" data-parsley-required-message="<strong>January</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">February <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" name="m[2]" class="form-control" placeholder="February" data-parsley-required-message="<strong>February</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">March <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" name="m[3]" class="form-control" placeholder="March" data-parsley-required-message="<strong>March</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">April <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" name="m[4]" class="form-control" placeholder="April" data-parsley-required-message="<strong>April</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">May <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" name="m[5]" class="form-control" placeholder="May" data-parsley-required-message="<strong>May</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">June <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" name="m[6]" class="form-control" placeholder="June" data-parsley-required-message="<strong>June</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">July <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" name="m[7]" class="form-control" placeholder="July" data-parsley-required-message="<strong>July</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">August <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" name="m[8]" class="form-control" placeholder="August" data-parsley-required-message="<strong>August</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">September <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" name="m[9]" class="form-control" placeholder="September" data-parsley-required-message="<strong>September</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">October <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" name="m[10]" class="form-control" placeholder="October" data-parsley-required-message="<strong>October</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">November <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" name="m[11]" class="form-control" placeholder="November" data-parsley-required-message="<strong>November</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">December <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" name="m[12]" class="form-control" placeholder="December" data-parsley-required-message="<strong>December</strong> is required." required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <p class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        from Funds list?
                                                        </p>
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
                                        <th>Year</th>
                                        <th width="15%"><center>Options</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@isset($data)
                                    @foreach($data as $d)
                                        <tr>
                                            <td>{{$d->year}}</td>
                                            <td>
                                                <center>
                                                    <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$d->year}}','{{$d->rptkey}}');"></i></a>
                                                    <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$d->rptkey}}','{{$d->year}}');"><i class="fa fa-trash "></i></a>
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
            $('#SideBar_MFile_Accounting_Fund').addClass('text-green');
        });
        function AddMode()
        {
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('master-file/Collection/RPT-Penalty') }}');
            $('input[name="id"]').val('');
            $('input[name="year"]').val('');
            $('[name^="m"]').attr('required',true);
            $('[name^="m"]').val('');
            $('input[name="txt_id"]').val('');
            $('input[name="txt_id"]').removeAttr('required');
            $('input[name="txt_name"]').val('');
            $('input[name="txt_name"]').attr('required', '');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function EditMode(year, key)
        {
            $('#MOD_MODE').text('(Edit)');
            $('#AddForm').attr('action', '{{ url('master-file/Collection/RPT-Penalty') }}/update');
            $('input[name="year"]').val(year);
            $('input[name="id"]').val(key);
            $('[name^="m"]').attr('required',true);
            $.ajax({
                method: 'POST',
                data: {key: key, action: 'getData'},
                success: function(data){
                    if(data.length){
                        let a = JSON.parse(data);
                        let b = JSON.parse(a.value);
                        for (var i = 0; i < 13; i++) {
                            $("[name='m["+i+"]']").val(b[i]);
                        }
                    }
                }
            })
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function DeleteMode(key, year)
        {
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('master-file/Collection/RPT-Penalty') }}/delete');
            $('input[name="year"]').val(year);
            $('input[name="id"]').val(key);
            $('[name^="m"]').removeAttr('required');
            $('.DeleteMode').show();
            $('.AddMode').hide();
        }
    </script>
@endsection