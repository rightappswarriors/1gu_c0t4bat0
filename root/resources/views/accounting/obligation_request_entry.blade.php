@extends('_main')
@section('content')
	@include('layout._contentheader')
  <form method="POST" id="submitEntries">
  <section class="content">
    <div class="box box-default">

      <input type="hidden" name="action" value="{{(isset($action) ? $action : 'add')}}">
      <div class="box-header with-border">
        <h3 class="box-title">Header</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> --}}
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body" style="padding-bottom: 10px;">
        <div class="container">
          <div class="row">

            <div class="col-md-6" style="padding-top:10px;">
              <div class="col-md font-weight-bold" style="font-weight: bold;">Date <span class="text-danger">*</span></div>
              <input type="date" id="editdate" name="date" class="form-control" data-parsley-required-message="<strong>Date</strong> is required." required>
            </div>

            <div class="col-md-6" style="padding-top:10px;">
              <div class="col-md font-weight-bold" style="font-weight: bold;">OBR Number <span class="text-danger">*</span></div>
              <input name="obr" id="editobr" placeholder="OBR Number" name="text" class="form-control" data-parsley-required-message="<strong>OBR Number</strong> is required." required >
            </div>

            <div class="col-md-6" style="padding-top:10px;">
              <div class="col-md font-weight-bold" style="font-weight: bold;">Payee <span class="text-danger">*</span></div>
              <input name="payee" id="editpayee" placeholder="Payee" name="text" class="form-control" data-parsley-required-message="<strong>Payee</strong> is required." required>
            </div>

            <div class="col-md-6" style="padding-top:10px;">
                <div class="col-md font-weight-bold" style="font-weight: bold;">Particulars <span class="text-danger">*</span></div>
                <input name="particulars" id="editparticulars" placeholder="Particulars" name="text" class="form-control" data-parsley-required-message="<strong>Particulars</strong> is required." required>
            </div>


           {{--  <div class="col-md-6" style="padding-top:10px;">
              <div class="col-md font-weight-bold" style="font-weight: bold;">F.P.P <span class="text-danger">*</span></div>

              <select name="fpp" id="editfpp" class="form-control">
                <option value="" disabled readonly hidden></option>
                @isset($ppe)
                  @foreach($ppe as $p)
                    <option value="{{$p->subgrpid}}">{{$p->subgrpdesc}}</option>
                  @endforeach
                @endisset
              </select>

            </div> --}}

            <div class="col-md-6" style="padding-top:10px;">
              <div class="col-md font-weight-bold" style="font-weight: bold;">Responsibility Center <span class="text-danger">*</span></div>

              <select name="subgrpid" id="editresponsibility" class="form-control" style="width: 100%" data-parsley-required-message="<strong>oOffice</strong> is required." required>
                <option value="" hidden disabled selected>Please Select</option>
                @isset($cc_code)
                  @foreach($cc_code as $cc)
                  <option value="{{$cc->cc_code}}">{{$cc->cc_desc}}</option>
                  @endforeach
                @endisset
              </select>

            </div>

            <div class="col-md-6" style="padding-top:10px;">
              <div class="col-md font-weight-bold" style="font-weight: bold;">Fund <span class="text-danger">*</span></div>

              <select name="fund" id="editfund" class="form-control" style="width: 100%" data-parsley-required-message="<strong>oOffice</strong> is required." required>
                <option value="" hidden disabled selected>Please Select</option>
                @isset($funds)
                  @foreach($funds as $cc)
                  <option value="{{$cc->fid}}">{{$cc->fdesc}}</option>
                  @endforeach
                @endisset
              </select>

            </div>

          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
      
    <div class="form-group">
              <center><label>&nbsp;</label></center>
              {{-- <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> New Admin Entry</button> --}}


              <div class="modal fade in" id="modal-default">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h3 class="modal-title">Admin Entry</h3>
                    </div>

                    {{-- <div class="modal-body">
                        <form id="AddForm" method="post" data-parsley-validate novalidate>
                            @csrf
                            <input type="hidden" name="action" value="add">
                            <span class="AddMode">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="acc_cde" class="col-sm-4 control-label">Account Code<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <select name="at_code" id="acc_cde" class="form-control" style="width: 100%" data-parsley-required-message="<strong>Account Code</strong> is required." required>
                                            <option value="" hidden disabled selected>Please Select</option>
                                            @isset($m04)
                                              @foreach($m04 as $m)
                                              <option value="{{$m->at_code}}">{{$m->at_desc}}</option>
                                              @endforeach
                                            @endisset
                                          </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ppe" class="col-sm-4 control-label">Amount<span class="text-red">*</span></label>
                                        <div class="col-sm-8" style="margin-bottom:10px;">
                                          <input name="amount" value="0.00" placeholder="Amount" name="text" class="form-control" data-parsley-required-message="<strong>Amount</strong> is required." required>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        </form>
                    </div> --}}
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

                   {{--  <div class="modal-body">
                        <form id="EditForm" method="post" data-parsley-validate novalidate>
                            @csrf
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="oid" id="oid">
                            <span class="AddMode">
                              <div class="box-body">
                                <div class="form-group">
                                    <label for="editacc_cde" class="col-sm-4 control-label">Account Code<span class="text-red">*</span></label>
                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                      <select name="at_code" id="editacc_cde" class="form-control" style="width: 100%" data-parsley-required-message="<strong>Account Code</strong> is required." required>
                                        <option value="" hidden disabled>Please Select</option>
                                        @isset($m04)
                                          @foreach($m04 as $m)
                                          <option value="{{$m->at_code}}">{{$m->at_desc}}</option>
                                          @endforeach
                                        @endisset
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ppe" class="col-sm-4 control-label">Amount<span class="text-red">*</span></label>
                                    <div class="col-sm-8" style="margin-bottom:10px;">
                                      <input name="amount" value="0.00" placeholder="Amount" id="editamount" name="text" class="form-control" data-parsley-required-message="<strong>Amount</strong> is required." required>
                                    </div>
                                </div>
                                <div class="form-group">
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
                                </div>
                              </div>
                            </span>
                        </form>
                    </div> --}}
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


    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Admin Entry Record</h3>
          </div>
          <div class="container">
            <button type="button" class="btn btn-success pull-right" onclick="addItem()"><i class="fa fa-plus-circle"></i></button>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div id="errMsg"></div>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Account Description</th>
                <th>F.P.P</th>
                <th>Amount</th>
                <th>Options</th>
              </tr>
              </thead>
              <tbody>

                @isset($data)
                  @foreach($data as $d)
                    <tr>
                      <td>
                        <select name="at_code[]" id="{{$d->id}}" class="form-control" style="width: 100%" data-parsley-required-message="<strong>Account Code</strong> is required." required>
                          <option value="" hidden disabled selected>Please Select</option>
                          @isset($m04)
                            @foreach($m04 as $m)
                            <option value="{{$m->at_code}}">{{$m->at_desc}}</option>
                            @endforeach
                          @endisset
                        </select>
                      </td>
                      <td>
                        <select name="fpp[]" class="form-control" style="width: 100%" data-parsley-required-message="<strong>F.P.P</strong> is required." required>
                          <option value="" disabled readonly hidden selected>Please Select</option>
                          @isset($ppe)
                            @foreach($ppe as $p)
                              <option value="{{$p->subgrpid}}">{{$p->subgrpdesc}}</option>
                            @endforeach
                          @endisset
                        </select>
                      </td>
                      <td>
                        <input name="amount[]" style="width: 100%" value="{{number_format($d->amount,2)}}" placeholder="Amount" name="text" class="form-control" data-parsley-required-message="<strong>Amount</strong> is required." required>
                      </td>
                      <td>
                        <a title="delete this entry" class="btn btn-social-icon btn-danger" onclick="DeleteMode(this);"><i class="fa fa-trash "></i></a>
                      </td>
                    </tr>
                    </tr>
                  @endforeach
                @endisset
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <div class="row">
          <div class="col-sm-4" style="float: right;">
              <button type="button" class="btn btn-block btn-primary" style="margin-top: 0;" onclick="window.location.href= '{{url('accounting/collection/obligation_request/Entry/Admin')}}'"><i class="fa fa-arrow-left"></i> Go Back</button>
          </div>
          <div class="col-sm-4" style="float: right;">
            <button type="submit" class="btn btn-block btn-success"><i class="fa fa-save"></i> Save</button>
          </div>
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  </form>
  <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
	<script type="text/javascript">
    function EditMode(oid, acccde, amount){
      $("#oid").val(oid);
      $("#editacc_cde").val(acccde).trigger('change');
      $("#editamount").val(amount);
    }

    function DeleteMode(whichElement){
      $(whichElement).parent().parent().remove()
    }

    $('body').on('keyup blur', 'input[name="amount[]"]', function(event) {
      formatCurrency($(this));
    })

    // $("input[name='amount[]']").on({
    //     keyup: function() {
    //       formatCurrency($(this));
    //     },
    //     blur: function() { 
    //       formatCurrency($(this), "blur");
    //     }
    // });

    
    function formatNumber(n) {
      // format number 1000000 to 1,234,567
      return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }


    function formatCurrency(input, blur) {
      // appends $ to value, validates decimal side
      // and puts cursor back in right position.
      
      // get input value
      var input_val = input.val();
      
      // don't validate empty input
      if (input_val === "") { return; }
      
      // original length
      var original_len = input_val.length;

      // initial caret position 
      var caret_pos = input.prop("selectionStart");
        
      // check for decimal
      if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);
        
        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
          right_side += "00";
        }
        
        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = left_side + "." + right_side;

      } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = input_val;
        
        // final formatting
        if (blur === "blur") {
          input_val += ".00";
        }
      }
      
      // send updated string to input
      input.val(input_val);

      // put caret back in the right position
      var updated_len = input_val.length;
      caret_pos = updated_len - original_len + caret_pos;
      input[0].setSelectionRange(caret_pos, caret_pos);
    }




    $('body').on('load', 'select', function(event) {
      $('select.select2').select2();
    })

    $("#submitEntries").submit(function(event) {
      event.preventDefault();
      let dataToSend = $(this).serialize();
      $.ajax({
        method: 'POST',
        data: dataToSend,
        success: function(a){
          if(a != 'true'){
            alert(a);
          } else {
            location.reload();
          }
        }
      })
    });

    function addItem()
    {
      var table = $('#example1').DataTable();
      table.row.add([
              '<select name="at_code[]" class="form-control" style="width: 100%" data-parsley-required-message="<strong>Account Code</strong> is required." required>'+
                '<option value="" hidden disabled selected>Please Select</option>'+
                @isset($m04)
                  @foreach($m04 as $m)
                  '<option value="{{$m->at_code}}">{{$m->at_desc}}</option>'+
                  @endforeach
                @endisset
              '</select>',
              '<select name="fpp[]" class="form-control" style="width: 100%" data-parsley-required-message="<strong>F.P.P</strong> is required." required>'+
                '<option value="" disabled readonly hidden selected>Please Select</option>'+
                @isset($ppe)
                  @foreach($ppe as $p)
                    '<option value="{{$p->subgrpid}}">{{$p->subgrpdesc}}</option>'+
                  @endforeach
                @endisset
              '</select>',
              '<input name="amount[]" style="width: 100%" value="0.00" placeholder="Amount" name="text" class="form-control" data-parsley-required-message="<strong>Amount</strong> is required." required>',
              '<a title="delete this entry" class="btn btn-social-icon btn-danger" onclick="DeleteMode(this);"><i class="fa fa-trash "></i></a>'
          ]).draw();
    }


    @isset($obrhdr)
    // let obr = JSON.parse('{!!$obrhdr!!}');
    {{-- let obrlne = JSON.parse('{!!json_encode($data)!!}'); --}}
    

    $.ajax({
      method: 'POST',
      data: {action: 'getobrhdr', _token: '{{ csrf_token() }}'},
      success: function(a){
        if(a){
          let obrhdr = JSON.parse(a);

          let domWithValuesHeader = [['editdate','editobr','editpayee','editparticulars','editfpp','editresponsibility','editfund'],['t_date','obr_code','payee','particulars','fpp','cc_code','fid']];
          if(domWithValuesHeader[0].length == domWithValuesHeader[1].length){
            var i;
            for (i = 0; i < domWithValuesHeader[0].length; i++) {
              if($("#"+domWithValuesHeader[0][i]).length > 0){
                $("#"+domWithValuesHeader[0][i]).val(obrhdr[0][domWithValuesHeader[1][i]]).trigger('change');
              }
            }
          }
          
        }
      }

    })


    $.ajax({
      method: 'POST',
      data: {action: 'getobrlne', _token: '{{ csrf_token() }}'},
      success: function(a){
        if(a){
          let obrlne = JSON.parse(a);
          obrlne.forEach(function(ek){
            if(document.getElementById(ek['id']).length){
              // document.getElementById(ek['id']).value = ek['at_code'];
              $("#"+ek['id']).val(ek['at_code']).trigger('change');
              $("#"+ek['id']).parent().next().find('select').val(ek['fpp']).trigger('change');
              // document.getElementById(ek['id']).parentNode.nextElementSibling.childNodes[1].value = ek['fpp'];
            }
          })
        }
      }

    })

    @endisset
  </script>
@endsection