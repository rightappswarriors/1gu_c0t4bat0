@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Masterfile','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Accounting','icon'=>'none','st'=>false],
        ['link'=>url("master-file/accounting/or_types"),'desc'=>'OR Type','icon'=>'none','st'=>true]
    ];
    $_ch = "OR Types"; // Module Name
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
        					<h3 class="box-title">OR Type List</h3>
        					<button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
        					<div class="modal fade in" id="modal-default">
        						<div class="modal-dialog">
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">OR Types <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-4 control-label">Code <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_id" class="form-control" placeholder="ID" data-parsley-required-message="<strong>Code</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Description <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="text" name="txt_name" class="form-control" placeholder="Description" data-parsley-required-message="<strong>Description</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Suggestive OR to <span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <input type="number" name="suggestive" class="form-control" placeholder="Suggestive OR to" data-parsley-required-message="<strong>Suggestive OR to</strong> is required." required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Has SEF?<span class="text-red">*</span></label>
                                                            <div class="col-sm-8" style="margin-bottom:10px;">
                                                                <select name="hassef" class="form-control" data-parsley-required-message="<strong>SEF</strong> is required." required style="width: 100%;">
                                                                    <option selected value="false">No</option>
                                                                    <option value="true">Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <p class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        from OR Types list?
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
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Suggestive OR upto</th>
                                        <th>Has SEF</th>
                                        <th width="15%"><center>Options</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@isset($or_types)
                                        @foreach($or_types as $fund)
                                            <tr>
                                                <th>{{$fund->or_type}}</th>
                                                <td>{{$fund->or_code}}</td>
                                                <td>{{$fund->suggestiveORto}}</td>
                                                <td>{{($fund->hassef == 1 ? 'Yes' : 'No')}}</td>
                                                <td>
                                                    <center>
                                                       <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$fund->or_type}}', '{{$fund->or_code}}', '{{$fund->suggestiveORto}}', '{{$fund->hassef}}');"></i></a>
                                                       <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$fund->or_type}}', '{{$fund->or_code}}');"><i class="fa fa-trash "></i></a>
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
            $('#SideBar_MFile_OR_TYPE').addClass('text-green');
        });
        function AddMode()
        {
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/or_types') }}');
            $('input[name="txt_id"]').val('');
            $('input[name="txt_id"]').removeAttr('readonly');
            $('input[name="txt_name"]').val('');
            $('input[name="txt_name"]').attr('required', '');
            $('input[name="suggestive"]').val('');
            $('input[name="suggestive"]').attr('required', '');
            $('select[name="hassef"]').val('');
            $('select[name="hassef"]').attr('required', '');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function EditMode(id, desc, suggest, hassef)
        {
            hassef = hassef.trim() != '' ? 'true' : 'false';
            $('#MOD_MODE').text('(Edit)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/or_types') }}/update');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').attr('required', '');
            $('input[name="txt_id"]').attr('readonly', '');
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').attr('required', '');
            $('input[name="suggestive"]').val(suggest);
            $('input[name="suggestive"]').attr('required', '');
            $('select[name="hassef"]').val(hassef).trigger('change');
            $('select[name="hassef"]').attr('required', '');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function DeleteMode(id, desc)
        {
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('master-file/accounting/or_types') }}/delete');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').removeAttr('required');
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').attr('required', '');
            $('select[name="hassef"]').removeAttr('required');
            $('input[name="suggestive"]').removeAttr('required');
            $('#DeleteName').text(desc);
            $('.DeleteMode').show();
            $('.AddMode').hide();
        }
    </script>
@endsection