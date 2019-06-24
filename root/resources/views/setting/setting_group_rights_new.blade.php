@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Setting','icon'=>'none','st'=>false],
        ['link'=>url("settings/group-rights"),'desc'=>'Group Rights','icon'=>'none','st'=>true],
        ['link'=>'#','desc'=>'Edit Rights','icon'=>'none','st'=>false],
    ];
    $_ch = "Group Rights"; // Module Name
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
        					<h3 class="box-title"><strong>{{$grp->grp_id}} - {{$grp->grp_desc}}</strong></h3>
                            <div class="box-tools pull-right">
                                <button type="button" onclick="$('#THEFORM').submit()" class="btn btn-success"><i class="fa fa-check"></i> Save
                                </button>
                                <button type="button" class="btn" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Back
                                </button>
                            </div>
        					{{-- <button type="button" class="btn btn-primary" onclick="AddMode();" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Add new</button>
                            <button type="button" class="btn btn-secondary" onclick="location.href='{{url('settings/group-rights/groups')}}'"><i class="fa fa-cog"></i> Groups</button>
                            <button type="button" class="btn btn-secondary" onclick="location.href='{{url('settings/group-rights/modules')}}'"><i class="fa fa-cog"></i> Modules</button> --}}
        					<div class="modal fade in" id="modal-default">
        						<div class="modal-dialog modal-lg">
        							<div class="modal-content">
        								<div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Group Rights <span id="MOD_MODE"></span></h3>
                                        </div>
                                        <div class="modal-body">
                                            <form id="AddForm" method="post" action="" data-parsley-validate novalidate>
                                                @csrf
                                                <span class="AddMode">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="inputEmail3" class="col-sm-4 control-label">Code <span class="text-red">*</span></label>
                                                                <div class="col-sm-6" style="margin-bottom:10px;">
                                                                    <input type="text" maxlength="10" style="text-transform: uppercase;" name="txt_id" class="form-control" placeholder="ID" data-parsley-required-message="<strong>Code</strong> is required." required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-sm-4 control-label">Description <span class="text-red">*</span></label>
                                                                <div class="col-sm-8" style="margin-bottom:10px;">
                                                                    <input type="text" name="txt_name" class="form-control" placeholder="Name" data-parsley-required-message="<strong>Complete Name</strong> is required." data-parsley-errors-container="#name_requirement" required>
                                                                    <span id="name_requirement"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="DeleteMode"  style="display: none">
                                                    <center>
                                                        <p class="text-transform: uppercase;">Are you sure you want to delete <strong><span id="DeleteName" class="text-red"></span></strong>
                                                        from Users list?
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
        				<div class="box-body table-responsive">
                        <form action="{{ url('settings/group-rights') }}/edit/{{$mod_id}}" method="POST" id="THEFORM">
                            @csrf
                            <input type="text" name="grp_id" value="{{$mod_id}}" readonly="" hidden="">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="40%">Description</th>
                                        <th><center>Allow</center></th>
                                        <th><center>Add</center></th>
                                        <th><center>Update</center></th>
                                        <th><center>Delete</center></th>
                                        <th><center>Print</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($gr_ri)
                                        @if(count($gr_ri) > 0)
                                            @foreach ($gr_ri as $d)
                                                @if($d->level == '1')
                                                    <tr class="bg-red-active">
                                                        <th>{{$d->grp_desc}}<input type="text" name="mod[]" style="color:black;display: none" readonly=""  value="{{$d->mod_id}}"></th>
                                                        <td><center><input type="checkbox" onchange="ChkMd(0, '{{$d->level}}' , '{{$d->mod_id}}');" name="alw['{{$d->mod_id}}']" @if($d->restrict == 'Y')checked=""@endif></center></td>
                                                        <td><center><input type="checkbox" onchange="ChkMd(1, '{{$d->level}}' , '{{$d->mod_id}}');" name="add['{{$d->mod_id}}']" @if($d->add == 'Y')checked=""@endif></center></td>
                                                        <td><center><input type="checkbox" onchange="ChkMd(2, '{{$d->level}}' , '{{$d->mod_id}}');" name="upd['{{$d->mod_id}}']" @if($d->upd == 'Y')checked=""@endif></center></td>
                                                        <td><center><input type="checkbox" onchange="ChkMd(3, '{{$d->level}}' , '{{$d->mod_id}}');" name="del['{{$d->mod_id}}']" @if($d->cancel == 'Y')checked=""@endif></center></td>
                                                        <td><center><input type="checkbox" onchange="ChkMd(4, '{{$d->level}}' , '{{$d->mod_id}}');" name="prt['{{$d->mod_id}}']" @if($d->print == 'Y')checked=""@endif></center></td>
                                                    </tr>
                                                    @if($d->hasLevel2 == 1)
                                                        @foreach ($gr_ri as $d1)
                                                            @if($d1->level == '2' && $d1->plevel1 == $d->mod_id)
                                                                <tr class="bg-light-blue-active">
                                                                    <th>&nbsp;&nbsp;-&nbsp;{{$d1->grp_desc}}<input type="text" name="mod[]" style="color:black;display: none" readonly=""  value="{{$d1->mod_id}}"></th>
                                                                    <td><center><input type="checkbox" name="alw['{{$d1->mod_id}}']" @if($d1->restrict == 'Y')checked=""@endif></center></td>
                                                                    <td><center><input type="checkbox" name="add['{{$d1->mod_id}}']" @if($d1->add == 'Y')checked=""@endif></center></td>
                                                                    <td><center><input type="checkbox" name="upd['{{$d1->mod_id}}']" @if($d1->upd == 'Y')checked=""@endif></center></td>
                                                                    <td><center><input type="checkbox" name="del['{{$d1->mod_id}}']" @if($d1->cancel == 'Y')checked=""@endif></center></td>
                                                                    <td><center><input type="checkbox" name="prt['{{$d1->mod_id}}']" @if($d1->print == 'Y')checked=""@endif></center></td>
                                                                </tr>
                                                                @if($d1->hasLevel3 == 1)
                                                                    @foreach ($gr_ri as $d2)
                                                                        @if($d2->level == '3' && $d2->plevel2 == $d1->mod_id)
                                                                        <tr class="bg-gray-active">
                                                                            <th>&nbsp;&nbsp;&nbsp;*&nbsp;{{$d2->grp_desc}}<input type="text" name="mod[]" style="color:black;display: none" readonly=""  value="{{$d2->mod_id}}"></th>
                                                                            <td><center><input type="checkbox" name="alw['{{$d2->mod_id}}']" @if($d2->restrict == 'Y')checked=""@endif></center></td>
                                                                            <td><center><input type="checkbox" name="add['{{$d2->mod_id}}']" @if($d2->add == 'Y')checked=""@endif></center></td>
                                                                            <td><center><input type="checkbox" name="upd['{{$d2->mod_id}}']" @if($d2->upd == 'Y')checked=""@endif></center></td>
                                                                            <td><center><input type="checkbox" name="del['{{$d2->mod_id}}']" @if($d2->cancel == 'Y')checked=""@endif></center></td>
                                                                            <td><center><input type="checkbox" name="prt['{{$d2->mod_id}}']" @if($d2->print == 'Y')checked=""@endif></center></td>
                                                                        </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    @endisset
                                </tbody>
                            </table>
                        </form>
                        {{-- @isset($gr_ri)
                            @if(count($gr_ri) > 0)
                                @foreach ($gr_ri as $d)
                                    @if($d->level == '1')
                                    <div class="box bg-navy box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{$d->grp_desc}}</h3>
                                            @if($d->hasLevel2 == 1)
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                        @if($d->hasLevel2 == 1)
                                        <div class="box-body" style="">
                                          @foreach ($gr_ri as $d1)
                                              @if($d1->level == '2' && $d1->plevel1 == $d->mod_id)
                                                <div class="box box-info box-solid">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">{{$d1->grp_desc}}</h3>
                                                        @if($d1->hasLevel3 == 1)
                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @if($d1->hasLevel3 == 1)
                                                        <div class="box-body" style="">
                                                            @foreach ($gr_ri as $d2)
                                                                @if($d2->level == '3' && $d2->plevel2 == $d1->mod_id)
                                                                 <div class="box box-warning box-solid">
                                                                    <div class="box-header with-border">
                                                                         <h3 class="box-title">{{$d2->grp_desc}}</h3>
                                                                    </div>
                                                                 </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                              @endif
                                          @endforeach
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                @endforeach
                            @else
                            @endif
                        @else
                        @endisset --}}
        				</div> <!-- /.box-body -->
        			</div> <!-- /.box -->
        		</div> <!-- /.col -->
        	</div> <!-- /.row -->
        </section> <!-- /.content -->
	<script type="text/javascript">
        $(document).ready(function(){
            // $('#SideBar_MFile').addClass('active');
            // $('#SideBar_MFile_Inventory').addClass('text-green');
            // $('#SideBar_MFile_GENERIC_NAME').addClass('text-green');
            // $('#TreeView_MasterFile_Inventory_Menu').addClass('menu-open');
            // $('#TreeView_MasterFile_Inventory_Menu2').css('display', 'block');
        });

        function ChkMd(typ, lvl, md, lvl1, lvl2)
        {
            // alert(typ);
            // alert(md);
        }

        function AddMode()
        {
            $('#MOD_MODE').text('(New)');
            $('#AddForm').attr('action', '{{ url('settings/group-rights') }}');
            $('input[name="txt_id"]').val('');
            $('input[name="txt_id"]').removeAttr('readonly');
            $('input[name="txt_name"]').val('');
            $('input[name="txt_name"]').attr('required', '');
            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function EditMode(id, name, pwd, grpid)
        {
            $('#MOD_MODE').text('(Edit)');
            $('#AddForm').attr('action', '{{ url('settings/group-rights') }}/update');
            $('input[name="txt_id"]').val(id);
            $('input[name="txt_id"]').attr('required', '');
            $('input[name="txt_id"]').attr('readonly', '');
            $('input[name="txt_name"]').val(urldecode(name));
            $('input[name="txt_name"]').attr('required', '');
            $('select[name="txt_grp"]').val(grpid).trigger('change');
            $('select[name="txt_grp"]').attr('required', '');
            $('input[name="txt_pass1"]').val(pwd);
            $('input[name="txt_pass2"]').val(pwd);
            $('input[name="txt_pass1"]').attr('required', '');
            $('input[name="txt_pass2"]').attr('required', '');

            $('.AddMode').show();
            $('.DeleteMode').hide();
        }
        function DeleteMode(id, desc)
        {
            $('#MOD_MODE').text('(Delete)');
            $('#AddForm').attr('action', '{{ url('settings/group-rights') }}/delete');
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