@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Setting','icon'=>'none','st'=>false],
        ['link'=>url("settings/group-rights"),'desc'=>'Group Rights','icon'=>'none','st'=>true],
        ['link'=>url("settings/group-rights/modules"),'desc'=>'Modules','icon'=>'none','st'=>true]
    ];
    $_ch = "Modules"; // Module Name
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
        					<div class="row">
                                <div class="col-sm-5">
                                    <h3 class="box-title">Module List</h3>
                                    <button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
                                </div>
                                <div class="col-sm-7">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <select name="lvl_selector" onchange="filterData()" id="" class="form-control">
                                                <option value="">Select Level...</option>
                                                <option value="1">Level 1</option>
                                                <option value="2">Level 2</option>
                                                <option value="3">Level 3</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4" style="">
                                            <select name="lvl_1_sel" onchange="filterData(0)" class="form-control"></select>
                                        </div>
                                        <div class="col-sm-4" style="">
                                            <select name="lvl_2_sel" onchange="filterData(1)" class="form-control"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
        					<div class="modal fade in" id="modal-default">
        						<div class="modal-dialog">
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Modules <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-4 control-label">Code <span class="text-red">*</span></label>
                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                            <input type="text" maxlength="8" style="text-transform: uppercase;" name="txt_id" class="form-control" placeholder="ID" data-parsley-required-message="<strong>Code</strong> is required." required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Description <span class="text-red">*</span></label>
                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                            <input type="text" name="txt_name" class="form-control" placeholder="Name" data-parsley-required-message="<strong>Description</strong> is required." data-parsley-errors-container="#name_requirement" required>
                                                            <span id="name_requirement"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Path <span class="text-red">*</span></label>
                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                            <input type="text" name="txt_path" class="form-control" placeholder="Path" data-parsley-required-message="<strong>Path</strong> is required." data-parsley-errors-container="#name_requirement2" required>
                                                            <span id="name_requirement2"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Office\s{{-- <span class="text-red">*</span> --}}</label>
                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                            <select id="OFFICE" style="width: 100%" name="txt_office[]" class="form-control" placeholder="Path" data-parsley-required-message="<strong>Office</strong> is required." data-parsley-errors-container="#name_requirement3" multiple="multiple">
                                                            @isset($office)
                                                                @if(count($office) > 0)
                                                                    @foreach ($office as $o)
                                                                        <option value="{{$o->cc_code}}">{{$o->cc_desc}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value=""></option>
                                                                @endif
                                                            @else
                                                                <option value=""></option>
                                                            @endisset
                                                            </select>
                                                            <span id="name_requirement3"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 12px" class="col-sm-4 control-label">Give Access to Specified Users Only</label>
                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                            <select id="USERS" style="width: 100%" name="txt_uid[]" class="form-control"  multiple="multiple">
                                                            @isset($users)
                                                                @if(count($users) > 0)
                                                                    @foreach ($users as $o)
                                                                        <option value="{{$o->uid}}">{{$o->opr_name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value=""></option>
                                                                @endif
                                                            @else
                                                                <option value=""></option>
                                                            @endisset
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="form-group">
                                                        <label class="col-sm-4 control-label">User <span class="text-red">*</span></label>
                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                            <input type="text" name="txt_user[]" class="form-control" placeholder="Path" data-parsley-errors-container="#name_requirement4" multiple="multiple">
                                                            <span id="name_requirement4"></span>
                                                        </div>
                                                    </div> --}}
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Level <span class="text-red">*</span></label>
                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                            <select onchange="filterData2()" name="txt_level" style="width:75%" class="form-control"  data-parsley-required-message="<strong>Level</strong> is required." data-parsley-errors-container="#sel_level_spn" required>
                                                                <option value="">Select Level..</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                            </select>
                                                            <span id="sel_level_spn"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group sel_lvl_1_div" style="display: none">
                                                        <label class="col-sm-4 control-label">Level 1<span class="text-red sel_lvl_1_div" style="display: none">*</span></label>
                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                            <select  name="txt_level_1" onchange="filterData2(1)" style="width:75%" class="form-control"  data-parsley-required-message="<strong>Level 1</strong> is required." data-parsley-errors-container="#sel_level_spn1" >
                                                            </select>
                                                            <span id="sel_level_spn1"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group sel_lvl_2_div" style="display: none">
                                                        <label class="col-sm-4 control-label">Level 2<span class="text-red sel_lvl_2_div" style="display: none">*</span></label>
                                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                                            <select  name="txt_level_2" style="width:75%" class="form-control"  data-parsley-required-message="<strong>Level 2</strong> is required." data-parsley-errors-container="#sel_level_spn2">
                                                            </select>
                                                            <span id="sel_level_spn2"></span>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <p class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        from Module list?
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
                                        <th>Level</th>
                                        <th width="15%"><center>Options</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	{{-- @isset($group_rights)
                                        @foreach($group_rights as $d)
                                            <tr>
                                                <th>{{$d->grp_id}}</th>
                                                <td>{{$d->grp_desc}}</td>
                                                <td></td>
                                                <td>
                                                    <center>
                                                       <a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode('{{$d->grp_id}}', '{{urlencode($d->grp_desc)}}');"></i></a>
                                                       <a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode('{{$d->grp_id}}', '{{$d->grp_desc}}');"><i class="fa fa-trash "></i></a>
                                                    </center>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset --}}
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
        });
        function filterData(num)
        {
            // alert(num);
            $('#example1').DataTable().clear().draw();
            var mod_lvl = $('select[name="lvl_selector"]').val();
            
            if((mod_lvl == '1') && (num == undefined)) {
                    loadData(mod_lvl);
                    $('select[name="lvl_1_sel"]').empty();
                    $('select[name="lvl_2_sel"]').empty();
                } else if((mod_lvl == '2') && (num == undefined)){
                    $('select[name="lvl_2_sel"]').empty();
                    loadData2(1, 'lvl_1_sel');
                } else if((mod_lvl == '2') && (num == '0')) {
                    loadData(mod_lvl);
                } else if((mod_lvl == '3') && (num == undefined)) {
                    loadData2(1, 'lvl_1_sel');
                } else if((mod_lvl == '3') && (num == '0')){
                    loadData2(2, 'lvl_2_sel');
                } else if((mod_lvl == '3') && (num == '1')){
                    loadData(mod_lvl);
                } else {
                    $('select[name="lvl_1_sel"]').empty();
                    $('select[name="lvl_2_sel"]').empty();
                }
        }
        function filterData2(num)
        {
            var lvl = $('select[name="txt_level"]').val();
            if((lvl == '1') && (num== undefined) ){
                $('.sel_lvl_1_div').hide();
                $('.sel_lvl_2_div').hide();
                $('select[name="txt_level_1"]').empty();
                $('select[name="txt_level_2"]').empty();
                $('select[name="txt_level_1"]').removeAttr('required');
                $('select[name="txt_level_2"]').removeAttr('required');
            } else if((lvl == '2') && (num== undefined)) {
                $('.sel_lvl_1_div').show();
                $('.sel_lvl_2_div').hide();
                loadData3(1, 'txt_level_1');
                $('select[name="txt_level_1"]').attr('data-parsley-required', 'true');
                $('select[name="txt_level_2"]').removeAttr('required');
                $('select[name="txt_level_1"]').empty();
                $('select[name="txt_level_2"]').empty();
            }  else if((lvl == '2') && (num== '1')) {
                // $('.sel_lvl_1_div').show();
                // $('.sel_lvl_2_div').hide();
                // loadData3(1, 'txt_level_1');
                // $('select[name="txt_level_1"]').attr('required', '');
                // $('select[name="txt_level_2"]').removeAttr('required');
                // $('select[name="txt_level_1"]').empty();
                // $('select[name="txt_level_2"]').empty();
            } else if((lvl == '3') && (num== undefined)) {
                $('.sel_lvl_1_div').show();
                $('.sel_lvl_2_div').show();
                loadData3(1, 'txt_level_1');
                $('select[name="txt_level_1"]').attr('data-parsley-required', 'true');
                $('select[name="txt_level_2"]').removeAttr('required');
                $('select[name="txt_level_1"]').empty();
                $('select[name="txt_level_2"]').empty();
            } else if((lvl == '3') && (num== '1')) {
                $('.sel_lvl_1_div').show();
                $('.sel_lvl_2_div').show();
                $('select[name="txt_level_1"]').attr('data-parsley-required', 'true');
                $('select[name="txt_level_2"]').attr('data-parsley-required', 'true');
                $('select[name="txt_level_2"]').empty();
                loadData3(2, 'txt_level_2');
            } else {
                $('.sel_lvl_1_div').hide();
                $('.sel_lvl_2_div').hide();
                $('select[name="txt_level_1"]').empty();
                $('select[name="txt_level_2"]').empty();
                $('select[name="txt_level_1"]').removeAttr('required');
                $('select[name="txt_level_2"]').removeAttr('required');
            }
        }
        function loadData3(mod_lvl, selected)
        {
            $.ajax({
                url : '{{ url('settings/group-rights/modules/getAll') }}',
                data : {
                        _token : $('meta[name="csrf-token"]').attr('content'), 
                        mod_lvl : mod_lvl,
                        lvl_1 : $('select[name="txt_level_1"]').val(),
                        lvl_2 : $('select[name="txt_level_2"]').val(),
                    },
                success : function(data){
                    $('select[name="'+selected+'"]').empty();
                    if(data.length > 0){
                        $('select[name="'+selected+'"]').append('<option value="">Select Module Level '+mod_lvl+'..</option>')
                        for (var i = 0; i < data.length; i++) {
                           $('select[name="'+selected+'"]').append(
                                '<option value="'+data[i].mod_id+'">'+data[i].grp_desc+'</option>'
                            );
                        }
                    } else {
                        $('select[name="'+selected+'"]').append('<option value="">No registered module..</option>')
                    }
                }
            });
        }
        function loadData(mod_lvl)
        {

            $.ajax({
                url : '{{ url('settings/group-rights/modules/getAll') }}',
                data : {
                        _token : $('meta[name="csrf-token"]').attr('content'), 
                        mod_lvl : mod_lvl,
                        lvl_1 : $('select[name="lvl_1_sel"]').val(),
                        lvl_2 : $('select[name="lvl_2_sel"]').val(),
                        lvl_3 : $('select[name="lvl_3_sel"]').val(),
                    },
                success : function(data){
                    $('#example1').DataTable().clear().draw();
                    if(data.length > 0){
                        for (var i = 0; i < data.length; i++) {
                            $('#example1').DataTable().row.add([
                                  data[i].mod_id,
                                  data[i].grp_desc,
                                  data[i].level,
                                  '<center>' +
                                    '<span class="MG006_update">' +
                                    '<a class="btn btn-social-icon btn-warning" data-toggle="modal" data-target="#modal-default"><i class="fa fa-pencil" onclick="EditMode(\''+data[i].mod_id+'\', \''+data[i].grp_desc+'\', \''+(data[i].path != 'null' ? encodeURI(data[i].path) : '')+'\', \''+data[i].plevel1+'\', \''+data[i].plevel2+'\', \''+data[i].level+'\', \''+encodeURI(data[i].cc_code)+'\', \''+encodeURI(data[i].uid)+'\');"></i></a>' +
                                    '</span>&nbsp;' +
                                  //   '<span class="MG006_cancel">' +
                                  //   '<a class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#modal-default" onclick="DeleteMode(\''+data[i].mod_id+'\', \''+data[i].grp_desc+'\');"><i class="fa fa-trash "></i></a>'+
                                  // '</span>' +
                                  '</center>'

                              ]).draw();
                        }
                    }
                }
            });
        }
        function loadData2(mod_lvl, selected)
        {

            $.ajax({
                url : '{{ url('settings/group-rights/modules/getAll') }}',
                data : {
                        _token : $('meta[name="csrf-token"]').attr('content'), 
                        mod_lvl : mod_lvl,
                        lvl_1 : $('select[name="lvl_1_sel"]').val(),
                        lvl_2 : $('select[name="lvl_2_sel"]').val(),
                        lvl_3 : $('select[name="lvl_3_sel"]').val(),
                    },
                success : function(data){
                    $('select[name="'+selected+'"]').empty();
                    if(data.length > 0){
                        $('select[name="'+selected+'"]').append('<option val="">Select Module Level '+mod_lvl+'..</option>')
                        for (var i = 0; i < data.length; i++) {
                           $('select[name="'+selected+'"]').append(
                                '<option value="'+data[i].mod_id+'">'+data[i].grp_desc+'</option>'
                            );
                        }
                    }
                }
            });
        }
        function AddMode()
        {
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('settings/group-rights/modules') }}');
            $('input[name="txt_id"]').val('');
            $('input[name="txt_id"]').removeAttr('readonly');
            $('input[name="txt_name"]').val('');
            $('input[name="txt_name"]').attr('required', '');
            $('input[name="txt_path"').val('');
            $('input[name="txt_path"]').attr('required', '');
            $('select[name="txt_level"]').val('').trigger('change');
            $('select[name="txt_level"]').attr('required', '');
            $('#OFFICE').val(null).trigger('change');
            $('#USERS').val().trigger('change');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        
        function EditMode(id, name, path, lvl1, lvl2, lvl, office, uid)
        {
            $('#MOD_MODE').text('(Edit)');
            $('#AddForm').attr('action', '{{ url('settings/group-rights/modules') }}/update');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').attr('required', '');
            $('input[name="txt_id"]').attr('readonly', '');
            $('input[name="txt_name"]').val(urldecode(name));
            $('input[name="txt_name"]').attr('required', '');
            $('input[name="txt_path"').val((path != 'null') ? urldecode(path) : '');
            $('input[name="txt_path"]').attr('required', '');
            $('select[name="txt_level"]').val(lvl).trigger('change');
            $('select[name="txt_level"]').attr('required', '');
            if(lvl == '2' || lvl == '3') {
                setTimeout(function(){
                    $('select[name="txt_level_1"]').val(lvl1).trigger('change');
                    $('select[name="txt_level_1"]').attr('required', '');
                }, 750);
            }

            if(lvl== '3') {
                setTimeout(function(){
                    $('select[name="txt_level_2"]').val(lvl2).trigger('change');
                    $('select[name="txt_level_2"]').attr('required', '');
                }, 1250);
            }
            // console.log();
            if(office != 'null') {
                $('#OFFICE').val(JSON.parse(urldecode(office))).trigger('change');
            } else {
                $('#OFFICE').val(null).trigger('change');
            }

            if(uid != 'null') {
                $('#USERS').val(JSON.parse(urldecode(uid))).trigger('change');
            } else {
                $('#USERS').val().trigger('change');
            }
            // $('select[name="txt_grp"]').val(grpid).trigger('change');
            // $('select[name="txt_grp"]').attr('required', '');
            // $('input[name="txt_pass1"]').val(pwd);
            // $('input[name="txt_pass2"]').val(pwd);
            // $('input[name="txt_pass1"]').attr('required', '');
            // $('input[name="txt_pass2"]').attr('required', '');

            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function DeleteMode(id, desc)
        {
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('settings/group-rights/modules') }}/delete');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').removeAttr('required');
            $('input[name="txt_name"]').val(desc);
            $('input[name="txt_name"]').attr('required', '');
            $('#DeleteName').text(desc);
            $('.DeleteMode').show();
            $('.AddMode').hide();
        }
    </script>
@endsection