@extends('_main')
@section('content')
	@include('layout._contentheader')
  <section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
        <center>
          <h2 class="box-title">Republic of the Philippines</h2><br>
          <h2 class="box-title">{{$header->comp_addr}}</h2><br>
          <h3 class="box-title"><b>{{$header->comp_name}}</b></h3>
        </center>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> --}}
        </div>
      </div>
      <!-- /.box-header -->
      {{-- {{dd($dbAll[0])}} --}}
      <div class="box-body" style="">
        <div id="dbsErr"></div>
        <div class="row">
          <div class="col">
            <center><strong>DISBURSEMENT VOURCHER</strong></center>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <p style="">No:</p>
            <input type="text" class="form-control" id="t_desc" placeholder="Disbursement No.">
          </div>
          <div class="col-md-3">
            <p>Date</p>
            <input type="date" class="form-control" id="date" placeholder="Date">
          </div>
        </div>
        <hr/>
        <div class="row">
          <div class="col-md-6">
            <p>Mode of Payment</p>
            <select class="form-control" id="at_code1">
              <option value hidden selected disabled>Please select</option>
              @isset($mop) @foreach($mop AS $each)
              <option value="{{$each->at_code}}">{{$each->at_desc}}</option>
              @endforeach @endisset
            </select>
          </div>
          <div class="col-md-6">
            <p>Disbursement Type:</p>
            <select class="form-control" id="j_code" tabindex="-1" aria-hidden="true" disabled="true">
              @isset($disbType) @foreach($disbType AS $disbTypeEach)
              <option value="{{$disbTypeEach->j_code}}" selected>{{$disbTypeEach->j_desc}}</option>
              @endforeach @endisset
            </select>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <p>Payee</p>
            <!-- <input type="text" class="form-control" id="payee" placeholder="Payee"> -->
            <select class="form-control" id="payee">
              <option value hidden selected disabled>Please select</option>
              @isset($payees)
                @foreach($payees AS $payee)
                  <option value="{{$payee->c_code}}">{{$payee->c_name}}</option>
                @endforeach
              @endisset
            </select>
          </div>
          <div class="col-md-3">
            <p>TIN/Employee No.</p>
            <input type="text" class="form-control" id="empid" placeholder="TIN/Employee No." disabled>
          </div>
          <div class="col-md-3">
            <p>Obligation Request No.</p>
            <div class="row">
              <div class="col-md-12">
                <input type="text" class="form-control" id="obrdata">
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <br>
            <div class="row">
              <div class="col-md-12">
                <p>Address</p>
                <input type="text" class="form-control" id="address" placeholder="Cotabato City" disabled>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <!-- <center><span>TIN/Employee No.</span></center> -->
            <div class="row">
              <div class="col-md-12">
                <p>Cost Center</p>
                <select class="form-control" id="cc_code">
                  <option value hidden selected disabled>Please select</option>
                  @isset($cc_code) @foreach($cc_code AS $cc_codeEach)
                  <option value="{{$cc_codeEach->cc_code}}">{{$cc_codeEach->cc_desc}}</option>
                  @endforeach @endisset
                </select>
              </div>
              {{-- <div class="col-md-6">
                <p>Sub-cost Center</p>
                <select class="form-control" id="scc_code">
                  <option value hidden selected disabled>Please select</option>
                </select>
              </div> --}}
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <p>Description</p>
            <textarea class="form-control" placeholder="Description" id="description"></textarea>
          </div>

          <div class="col-md-6">
            <p>Amount</p>
            <input type="number" class="form-control" id="credit" placeholder="Total" value="0.00">
          </div>
        </div>
        <hr>
        
      </div>
      <div class="box-footer">
        <div class="pull-left">
          <button class="btn btn-success" onclick="submitForm();"><i class="fa fa-paper-plane"></i> Submit form</button>
        </div>
        <div class="pull-right">
          <a href="{{ asset('accounting/disbursement') }}"><button class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancel</button></a>
        </div>
      </div>
    </div>
  </section>
  <div class="modal fade in" id="addObr">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h3 class="modal-title">Obligation Request(s) <span id="MOD_MODE"></span></h3>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th></th>
                <th>OBR No.</th>
                <th>Payee</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @if(count($collection)) @foreach($collection AS $collectionEach)
              <tr>
                <td><input type="checkbox" value="{{$collectionEach[0]->obr_code}}" name="obr_code[]"></td>
                <td>{{$collectionEach[0]->obr_ref}}</td>
                <td>{{$collectionEach[0]->payee}}</td>
                <td>{{date('M d, Y', strtotime($collectionEach[0]->t_date))}}</td>
              </tr>
              @endforeach @else
              <tr>
                <td colspan="4">No collection.</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
          <button type="button" class="btn btn-success" onclick="loadRecord();" data-dismiss="modal"><i class="fa fa-check"></i> Proceed</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
	<script type="text/javascript">
    const $payeeSelect = $('#payee');
    const $tinInput = $('#empid');
    const $addressInput = $('#address');
    const $dateInput = $('#date');

    var sNNum = 0, j_num = "";
    const payees = {!! json_encode($payees) !!};
    let selectedPayee = null;


    $(function() {
      $dateInput.val(new Date().toISOString().slice(0, 10));
    })

    function thisInsRow(elId) {
      let insRow = '<tr> <td> <input type="text" class="form-control" placeholder="Description" name="seq_desc[]"> </td> <td> <select class="form-control" name="at_code[]"><option value hidden selected disabled>Please select</option> @isset($pom) @foreach($pom AS $eachPom) <option value="{{$eachPom->at_code}}">{{$eachPom->at_desc}}</option> @endforeach @endisset </select> </td> <td> <input type="number" class="form-control" placeholder="Amount" name="debit[]" onclick="giveTotal([\'debit[]\', \'addedDebit\'], \'credit\');" onkeyup="giveTotal([\'debit[]\', \'addedDebit\'], \'credit\');"> </td> <td> <button class="btn btn-danger" id="deleteButton'+sNNum+'" onclick="thisDelRow(this.id);"><i class="fa fa-times"></i></button> </td> </tr>'; sNNum++;
      addNewRow(elId, insRow);
      giveTotal(['debit[]', 'addedDebit'], 'credit');
    }
    function thisDelRow(btnId) {
      let eDom = (document.getElementById(btnId).parentNode).parentNode;
      deleteCurrentRow(eDom);
      giveTotal(['debit[]', 'addedDebit'], 'credit');
    }
    function thisDelRowByClass(btnClName) {
      let cDom = document.getElementsByClassName(btnClName);
      for(let i = 0; i < cDom.length; i++) {
        if(checkFields([cDom[i]])) {
          deleteCurrentRow(cDom[i]);
          giveTotal(['debit[]', 'addedDebit'], 'credit');
        }
      }
    }
    function loadRecord() {
      thisDelRowByClass('fromOldData'); insErrMsg('warning', 'Sending request', 'tblErr');
      let obr_code = document.getElementById('obr_code');
      if(checkFields([obr_code])) {
        let arrSs = ['_token'], arrDd = [$('meta[name="csrf-token"]').attr('content')];
        // for(let i = 0; i < obr_code.length; i++) { if(obr_code[i].checked) { arrSs.push('obr_code[]'); arrDd.push(obr_code[i].value); } }
        // document.getElementById('obrdata').value = arrDd.join(", ");
        arrSs.push('obr_code[]'); arrDd.push(obr_code.value);
        insDataFunction([arrSs, arrDd], "{{ asset('accounting/request/getCollectionRecords') }}", "POST", {
          functionProcess: function(arr) {
            insErrMsg('success', 'Request sent.', 'tblErr');
            if(Array.isArray(arr)) {
              thisDelRowByClass('fromOldData');
              for(let i = 0; i < arr.length; i++) {
                // document.getElementById('payee').value = ((arr[i][0].payee != null) ? arr[i][0].payee : "");
                let insRow = '<tr class="fromOldData"> <td colspan="2"> <textarea class="form-control" placeholder="Particulars" disabled>'+((arr[i][0].particulars != null) ? arr[i][0].particulars : "")+'</textarea> </td> <td> <input type="number" class="form-control" placeholder="Amount" name="addedDebit" value="'+arr[i][1]['thisTotal'].toFixed(2)+'" onclick="giveTotal(this.name, \'credit\');" onkeyup="giveTotal(this.name, \'credit\');" disabled> </td> <td>  </tr>';
                sNNum++;
                addNewRow('exTbody', insRow);
                giveTotal(['debit[]', 'addedDebit'], 'credit');
              }
            } else {
              console.log(arr);
            }
          }
        });
      }
    }
    function submitForm() {
      let modeOfPayment = $('#at_code1').val();
      let disbursementType = $('#j_code').val();
      let empId = $('#empid').val();
      let obr = $('#obrdata').val();
      let address = $('#address').val();
      let costCenter = $('#cc_code').val();
      let description = $('#description').val();
      let amount = $('#credit').val();
      let jCnum = $('#t_desc').val();
      let token = $('meta[name="csrf-token"]').attr('content');
      let dateVal = $dateInput.val();
      let date = new Date(dateVal); 

      const url = "{{ asset('accounting/request/insDisbursement') }}";
      const data = {
        'j_cnum': jCnum,
        't_desc': description,
        'j_code': disbursementType,
        'j_num': j_num,
        'payee': selectedPayee['c_name'],
        'sl_code': selectedPayee['c_code'],
        'cc_code': costCenter,
        'credit': amount,
        'pay_code': modeOfPayment,
        'obr_no': obr,
        'fy': date.getFullYear(),
        'mo': date.getMonth(),
        'date': dateVal
      };

      $.ajax({
        url: "{{ asset('accounting/request/insDisbursement') }}",
        method: 'POST',
        data: data,
        success: (response) => {
          // console.log(response);
          // if (response == "ok") {
            console.log("asdasd ", response);
            window.location.href = "{{ asset('accounting/disbursement') }}"
          // }
        }
      });
    }

    $payeeSelect.change(function() {
      selectedPayee = getPayee(this.value);

      const tin = selectedPayee['c_tin'] ? selectedPayee['c_tin'] : '';
      const addr1 = selectedPayee['c_addr1'] ? selectedPayee['c_addr1'] : '';
      const addr2 = selectedPayee['c_addr2'] ? selectedPayee['c_addr2'] : '';
      const address = addr1 ? (addr1 + " " + addr2) : addr2;

      $tinInput.val(tin);
      $addressInput.val(address);
    });

    function getPayee(cCOde) {
      for(let payee of payees) {
        if (payee['c_code'] === cCOde) {
          return payee;
        }
      }

      return null;
    }
    @isset($dbAll)
    j_num = "{{$dbAll[0][0]->j_num}}";
    document.getElementById('t_desc').value = "{{$dbAll[0][0]->t_desc}}";
    document.getElementById('payee').value = "{{$dbAll[0][0]->payee}}";
    document.getElementById('obr_code').value = "{{$dbAll[0][0]->obr_code}}";
    document.getElementById('cc_code').value = "{{$dbAll[0][0]->cc_code}}";
    document.getElementById('at_code1').value = "{{$dbAll[0][1][0]->at_code}}";

    loadRecord();
    // $dbAll[0][0]
    @endisset
  </script>
@endsection