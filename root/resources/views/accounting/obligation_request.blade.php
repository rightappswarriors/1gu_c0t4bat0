@extends('_main')
@section('content')
	@include('layout._contentheader')
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
        <div class="row">
          {{-- <div class="col-md-9">
          </div> --}}
          <div class="col-md-2">
            <div class="form-group">
              <center><label>&nbsp;</label></center>
              <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> New Admin Entry</button>


              <div class="modal fade in" id="modal-default">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h3 class="modal-title">Admin Entry</h3>
                    </div>

                    <div class="modal-body">
                        <form id="AddForm" method="post" data-parsley-validate novalidate>
                            @csrf
                            <input type="hidden" name="action" value="add">
                            <span class="AddMode">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="ppe" class="col-sm-4 control-label">Date<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <input type="date" name="date" class="form-control" data-parsley-required-message="<strong>Date</strong> is required." required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ppe" class="col-sm-4 control-label">OBR Number<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <input name="obr" placeholder="OBR Number" name="text" class="form-control" data-parsley-required-message="<strong>OBR Number</strong> is required." required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ppe" class="col-sm-4 control-label">Payee<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <input name="payee" placeholder="Payee" name="text" class="form-control" data-parsley-required-message="<strong>Payee</strong> is required." required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ppe" class="col-sm-4 control-label">Particulars<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <input name="particulars" placeholder="Particulars" name="text" class="form-control" data-parsley-required-message="<strong>Particulars</strong> is required." required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="responsibility" class="col-sm-4 control-label">Responsibility Center <span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <select name="subgrpid" id="responsibility" class="form-control" style="width: 100%" data-parsley-required-message="<strong>Office</strong> is required." required>
                                            <option value="" hidden disabled selected>Please Select</option>
                                            @isset($cc_code)
                                              @foreach($cc_code as $cc)
                                              <option value="{{$cc->cc_code}}">{{$cc->cc_desc}}</option>
                                              @endforeach
                                            @endisset
                                          </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fund" class="col-sm-4 control-label">Fund<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <select name="fund" id="fund" class="form-control" style="width: 100%" data-parsley-required-message="<strong>Fund</strong> is required." required>
                                            <option value="" hidden disabled selected>Please Select</option>
                                            @isset($funds)
                                              @foreach($funds as $cc)
                                              <option value="{{$cc->fid}}">{{$cc->fdesc}}</option>
                                              @endforeach
                                            @endisset
                                          </select>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="ppe" class="col-sm-4 control-label">F.P.P<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <select name="fpp" id="ppe" class="form-control" style="width: 100%" data-parsley-required-message="<strong>F.P.P</strong> is required." required>
                                            <option value="" hidden disabled selected>Please Select</option>
                                            @isset($ppe)
                                              @foreach($ppe as $pe)
                                              <option value="{{$pe->subgrpid}}">{{$pe->subgrpdesc}}</option>
                                              @endforeach
                                            @endisset
                                          </select>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="form-group">
                                        <label for="ppe" class="col-sm-4 control-label">Account Code<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <input name="acccode" placeholder="Account Code" name="text" class="form-control" data-parsley-required-message="<strong>Account Code</strong> is required." required>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="form-group">
                                        <label for="ppe" class="col-sm-4 control-label">Amount<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <input name="amount" type="text" placeholder="Amount" name="text" class="form-control" data-parsley-required-message="<strong>Amount</strong> is required." required>
                                        </div>
                                    </div> --}}
                                </div>
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

              <div class="modal fade in" id="edit-default">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h3 class="modal-title">Edit Admin Entry</h3>
                    </div>

                    <div class="modal-body">
                        <form id="EditForm" method="post" data-parsley-validate novalidate>
                            @csrf
                            <input type="hidden" name="action" value="edit">
                            <span class="AddMode">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="ppe" class="col-sm-4 control-label">Date<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <input type="date" id="editdate" name="date" class="form-control" data-parsley-required-message="<strong>Date</strong> is required." required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ppe" class="col-sm-4 control-label">OBR Number<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <input name="obr" id="editobr" placeholder="OBR Number" name="text" class="form-control" data-parsley-required-message="<strong>OBR Number</strong> is required." required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ppe" class="col-sm-4 control-label">Payee<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <input name="payee" id="editpayee" placeholder="Payee" name="text" class="form-control" data-parsley-required-message="<strong>Payee</strong> is required." required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ppe" class="col-sm-4 control-label">Particulars<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <input name="particulars" id="editparticulars" placeholder="Particulars" name="text" class="form-control" data-parsley-required-message="<strong>Particulars</strong> is required." required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="editresponsibility" class="col-sm-4 control-label">Responsibility Center <span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <select name="subgrpid" id="editresponsibility" class="form-control" style="width: 100%" data-parsley-required-message="<strong>oOffice</strong> is required." required>
                                            <option value="" hidden disabled>Please Select</option>
                                            @isset($cc_code)
                                              @foreach($cc_code as $cc)
                                              <option value="{{$cc->cc_code}}">{{$cc->cc_desc}}</option>
                                              @endforeach
                                            @endisset
                                          </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="editppe" class="col-sm-4 control-label">F.P.P<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <select name="fpp" id="editppe" class="form-control" style="width: 100%" data-parsley-required-message="<strong>F.P.P</strong> is required." required>
                                            <option value="" hidden disabled>Please Select</option>
                                            @isset($ppe)
                                              @foreach($ppe as $pe)
                                              <option value="{{$pe->subgrpid}}">{{$pe->subgrpdesc}}</option>
                                              @endforeach
                                            @endisset
                                          </select>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="ppe" class="col-sm-4 control-label">Account Code<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <input name="acccode" placeholder="Account Code" name="text" class="form-control" data-parsley-required-message="<strong>Account Code</strong> is required." required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ppe" class="col-sm-4 control-label">Amount<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <input name="amount" type="text" placeholder="Amount" name="text" class="form-control" data-parsley-required-message="<strong>Amount</strong> is required." required>
                                        </div>
                                    </div> --}}
                                </div>
                            </span>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span class="AddMode">
                            <button type="button" onclick="$('#EditForm').submit()" class="btn btn-success"><i class="fa fa-plus"></i> Save</button>
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

              <div class="modal fade in" id="delete-default">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h3 class="modal-title">Delete Admin Entry <span id="MOD_MODE"></span></h3>
                    </div>

                    <div class="modal-body">
                      <form id="DeleteForm" method="post" data-parsley-validate novalidate>
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="deleteobr">
                            <input type="hidden" name="action" value="delete">
                            <div class="col-sm-8" style="margin-bottom:10px;">
                              Are you sure you want to delete <span id="idhere" class="text-warning" style="color:red;"></span> ? 
                            </div>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                        <span class="AddMode">
                            <button type="button" onclick="$('#DeleteForm').submit()" class="btn btn-success"><i class="fa fa-trash"></i> Delete</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </span>
                        <span class="DeleteMode" style="display: none">
                            <button type="button" onclick="$('#AddForm').submit()" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                            <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                        </span>
                    </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
          <div class="col-md-1">
            <div class="form-group">
              <center><label>&nbsp;</label></center>
              <button type="button" class="btn btn-block btn-info"><i class="fa fa-print"></i> Print</button>
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
            <h3 class="box-title">Admin Entry Record</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div id="errMsg"></div>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                {{-- <th width="10%">F.P.P</th> --}}
                <th>Date</th>
                <th>OBR Code</th>
                <th>Payee</th>
                <th>Particulars</th>
                <th>Fund</th>
                <th width="10%">Options</th>
              </tr>
              </thead>
              <tbody>

                @isset($data)
                  @foreach($data as $d)
                    <tr>
                      {{-- <td>{{$d->subgrpdesc}}</td> --}}
                      <td>{{$d->t_date}}</td>
                      <td>{{$d->obr_code}}</td>
                      <td>{{$d->payee}}</td>
                      <td>{{$d->particulars}}</td>
                      <td>{{$d->fdesc}}</td>
                      <td>
                          <center>
                             {{-- <a title="add new entry" href="{{url('accounting/collection/obligation_request/Entry/Admin/'.$d->obr_pk)}}" target="_blank" class="btn btn-social-icon btn-success"><i class="fa fa-plus"></i></a> --}}
                             <a title="edit new entry" target="_blank" href="{{url('accounting/collection/obligation_request/Entry/Admin/'.$d->obr_pk)}}" class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" {{-- onclick="EditMode('{{$d->t_date}}','{{$d->obr_pk}}','{{addslashes($d->payee)}}','{{addslashes($d->particulars)}}','{{addslashes($d->cc_code)}}', '{{addslashes($d->subgrpid)}}');" --}}></i></a>
                             <a title="delete this entry" class="btn btn-social-icon btn-danger" data-toggle="modal" data-target="#delete-default" onclick="DeleteMode('{{$d->obr_pk}}', '{{$d->particulars}}');"><i class="fa fa-trash "></i></a>
                          </center>
                      </td>
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
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
	<script type="text/javascript">
    function EditMode(date, obr, payee, particular, res, fpp){
      $("#editdate").val(date);
      $("#editobr").val(obr);
      $("#editpayee").val(payee);
      $("#editparticulars").val(particular);
      $("#editresponsibility").val(res);
      $("#editppe").val(fpp);
    }

    function DeleteMode(id,desc){
      $("input[name=deleteobr]").val(id);
      $("#idhere").html(desc);
    }

    // $("input[name=amount]").keyup(function(event) {
    //   if(event.which >= 37 && event.which <= 40) return;
    //   $(this).val(function(index, value) {
    //     return value
    //     .replace(/\D/g, "")
    //     .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    //     ;
    //   });
    // });
  </script>
@endsection