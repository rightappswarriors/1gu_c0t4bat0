@extends('_main')
@section('content')
	@include('layout._contentheader')
  <form method="POST" id="submitEntries">
  {{csrf_field()}}
  <section class="content">
    <div class="row">
      <div class="col-sm-2"></div>
      <div class="col-sm-8">
            <div class="box box-default">

      <input type="hidden" name="action" value="{{(isset($action) ? $action : 'add')}}">
      <div class="box-header with-border">
        <h3 class="box-title">Header</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body" style="padding-bottom: 10px;">
          <div class="row">
            <div class="col-md-12" style="padding-top:10px;">
              <div class="col-md font-weight-bold" style="font-weight: bold;">Date <span class="text-danger">*</span></div>
              <input type="date" id="editdate" name="date" class="form-control" data-parsley-required-message="<strong>Date</strong> is required." required>
            </div>

            <div class="col-md-12" style="padding-top:10px;">
              <div class="col-md font-weight-bold" style="font-weight: bold;">OBR Number <span class="text-danger">*</span></div>
              <input name="obr" id="editobr" placeholder="OBR Number" name="text" class="form-control" data-parsley-required-message="<strong>OBR Number</strong> is required." required >
            </div>

            <div class="col-md-12" style="padding-top:10px;">
              <div class="col-md font-weight-bold" style="font-weight: bold;">Payee <span class="text-danger">*</span></div>
              <input name="payee" id="editpayee" placeholder="Payee" name="text" class="form-control" data-parsley-required-message="<strong>Payee</strong> is required." required>
            </div>

            <div class="col-md-12" style="padding-top:10px;">
                <div class="col-md font-weight-bold" style="font-weight: bold;">Particulars <span class="text-danger">*</span></div>
                <input name="particulars" id="editparticulars" placeholder="Particulars" name="text" class="form-control" data-parsley-required-message="<strong>Particulars</strong> is required." required>
            </div>
            <div class="col-md-12" style="padding-top:10px;">
              <div class="col-md font-weight-bold" style="font-weight: bold;">Responsibility Center <span class="text-danger">*</span></div>

              <select name="subgrpid" id="editresponsibility" onchange="getATDetails(this.value)" class="form-control" style="width: 100%" data-parsley-required-message="<strong>oOffice</strong> is required." required>
                <option value="" hidden disabled selected>Please Select</option>
                @isset($cc_code)
                  @foreach($cc_code as $cc)
                  <option value="{{$cc->cc_code}}">{{$cc->cc_desc}}</option>
                  @endforeach
                @endisset
              </select>

            </div>

            {{-- <div class="col-md" style="padding-top:10px;">
              <div class="col-md font-weight-bold" style="font-weight: bold;">Fund <span class="text-danger">*</span></div>

              <select name="fund" id="editfund" class="form-control" style="width: 100%" data-parsley-required-message="<strong>oOffice</strong> is required." required>
                <option value="" hidden disabled selected>Please Select</option>
                @isset($funds)
                  @foreach($funds as $cc)
                  <option value="{{$cc->fid}}">{{$cc->fdesc}}</option>
                  @endforeach
                @endisset
              </select>

            </div> --}}

            <div class="col-md-12" style="padding-top:10px;">
              <div class="col-md font-weight-bold" style="font-weight: bold;">F.P.P <span class="text-danger">*</span></div>

              <select name="fpp[]" class="form-control" style="width: 100%" data-parsley-required-message="<strong>F.P.P</strong> is required." required>
                <option value="" disabled readonly hidden selected>Please Select</option>
                @isset($ppe)
                  @foreach($ppe as $p)
                    <option value="{{$p->subgrpid}}">{{$p->subgrpdesc}}</option>
                  @endforeach
                @endisset
              </select>

            </div>

            <div class="col-md-12" style="padding-top:10px;">
              <div class="col-md font-weight-bold" style="font-weight: bold;">Account Code <span class="text-danger">*</span></div>

              <select name="at_code[]" class="form-control" style="width: 100%" data-parsley-required-message="<strong>Account Code</strong> is required." required>
                <option value="" hidden disabled selected>Please Select</option>
                @isset($bgtps02)
                  @foreach($bgtps02 as $b)
                  <option value="{{$b->at_code}}">{{$b->at_code}} - {{$b->at_desc}}</option>
                  @endforeach
                @endisset
              </select>

            </div>

            <div class="col-md-12" style="padding-top:10px;">
              <div class="col-md font-weight-bold" style="font-weight: bold;">Amount <span class="text-danger">*</span></div>

              <input name="amount[]" class="form-control" style="width: 100%" value="0.00" placeholder="Amount" type="text" data-parsley-required-message="<strong>Amount</strong> is required." required>
            </div>

          </div>
      </div>
    </div>
      </div>
      <div class="col-sm-2"></div>
    </div>


    <div class="row">
      <div class="col-xs-12">
        {{-- <div class="box">
          <div class="box-header">
            <h3 class="box-title">Admin Entry Record</h3>
          </div>
          <div class="container">
            <button type="button" class="btn btn-success pull-right" onclick="addItem()"><i class="fa fa-plus-circle"></i></button>
          </div>
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
                  @endforeach
                @endisset
              </tbody>
            </table>
          </div>
        </div> --}}

        <div class="row">
          <div class="col-sm-3"></div>
          <div class="col-sm-3">
              <button type="button" class="btn btn-block btn-primary"  onclick="window.location.href= '{{url('accounting/collection/obligation_request/Entry/Admin')}}'"><i class="fa fa-arrow-left"></i> Go Back</button>
          </div>
          <div class="col-sm-3">
             <button  type="submit" class="btn btn-block btn-success" ><i class="fa fa-save"></i> Save</button>
          </div>
          <div class="col-sm-3"></div>
        </div>

      </div>
    </div>
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
      var myTable = $('#example1').DataTable();
 
      myTable
        .row( $(whichElement).parents('tr') )
        .remove()
        .draw();
    }

    $('body').on('keyup blur', 'input[name="amount[]"]', function(event) {
      formatCurrency($(this));
    })

    
    function formatNumber(n) {
      return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }


    function formatCurrency(input, blur) {

      var input_val = input.val();
      
      if (input_val === "") { return; }
      
      var original_len = input_val.length;

      var caret_pos = input.prop("selectionStart");
        
      if (input_val.indexOf(".") >= 0) {

        var decimal_pos = input_val.indexOf(".");

        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        left_side = formatNumber(left_side);

        right_side = formatNumber(right_side);
        
        if (blur === "blur") {
          right_side += "00";
        }
        
        right_side = right_side.substring(0, 2);

        input_val = left_side + "." + right_side;

      } else {
        input_val = formatNumber(input_val);
        input_val = input_val;
        
        if (blur === "blur") {
          input_val += ".00";
        }
      }
      
      input.val(input_val);

      var updated_len = input_val.length;
      caret_pos = updated_len - original_len + caret_pos;
      input[0].setSelectionRange(caret_pos, caret_pos);
    }




    $('body').on('load', 'select', function(event) {
      $('select.select2').select2();
    })

    $("#submitEntries").submit(function(event) {
      event.preventDefault();
      let toClearFields = ['at_code[]','amount[]'];
      let dataToSend = $(this).serialize();
      $.ajax({
        method: 'POST',
        data: dataToSend,
        success: function(a){
          if(a != 'true'){
            alert(a);
          } else {
            alert('Saved Successfully');
            if('{{$action}}' == 'add'){
            toClearFields.forEach( function(element, index) {
              document.getElementsByName(element)[0].value = "";
              document.getElementsByName(element)[0].dispatchEvent(new Event('change'));
            });
            document.getElementsByName(toClearFields[1])[0].focus();
            }
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

    function getATDetails(value){
      document.getElementsByName('at_code[]')[0].value = '';
      document.getElementsByName('at_code[]')[0].dispatchEvent(new Event('change'));
      $('select[name="at_code[]"]').select2({
          ajax: {
            method: 'POST',
            data: {action: 'get-at_code', _token: '{{ csrf_token() }}', cc_code: value},
            dataType: 'json'
          }
      });
    }


    @isset($obrhdr)
    

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
          let fieldsToFill = ['fpp','at_code','amount'];
          fieldsToFill.forEach( function(element) {
            if(document.getElementsByName(element+'[]')[0]){
              document.getElementsByName(element+'[]')[0].value = obrlne[element];
              document.getElementsByName(element+'[]')[0].dispatchEvent(new Event('change'));
            }
          });
          // obrlne.forEach(function(ek){
          //   console.log(ek);
          //   if(document.getElementById(ek['id']).length){
          //     $("#"+ek['id']).val(ek['at_code']).trigger('change');
          //     $("#"+ek['id']).parent().next().find('select').val(ek['fpp']).trigger('change');
          //   }
          // })
        }
      }

    })

    @endisset
  </script>
@endsection