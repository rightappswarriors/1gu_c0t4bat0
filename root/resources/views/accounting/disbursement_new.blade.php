@extends('_main')
@section('content')
	@include('layout._contentheader')
  <section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
        <center>
          <h2 class="box-title">Republic of the Philippines</h2><br>
          <h2 class="box-title">Province of Negros Oriental</h2><br>
          <h3 class="box-title"><b>City of Guihulngan</b></h3>
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
          <div class="col-md-9">
            <center><strong>DISBURSEMENT VOURCHER</strong></center>
          </div>
          <div class="col-md-3">
            <p style="float: right;">No: <input type="text" id="t_desc" placeholder="Disbursement No."></p>
          </div>
        </div>
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
            <input type="text" class="form-control" id="payee" placeholder="Payee">
          </div>
          <div class="col-md-3">
            <p>TIN/Employee No.</p>
            <input type="text" class="form-control" id="empid" placeholder="TIN/Employee No.">
          </div>
          <div class="col-md-3">
            <p>Obligation Request No.</p>
            <div class="row">
              <div class="col-md-12">
                {{-- <input type="text" class="form-control" id="obrdata" readonly>
              </div>
              <div class="col-md-3"> --}}
                {{-- <button class="btn btn-info" data-toggle="modal" data-target="#addObr"><i class="fa fa-plus"></i></button> --}}
                <select class="form-control" onchange="loadRecord();" id="obr_code">
                  <option value selected hidden disabled>Select</option>
                  @foreach($collection AS $collectionEach)
                  <option value="{{$collectionEach[0]->obr_code}}">{{$collectionEach[0]->obr_ref}} - {{$collectionEach[0]->payee}}</option>
                  @endforeach
                </select>
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
                <p>GUIHULNGAN, OR. NEG.</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <center><span>TIN/Employee No.</span></center>
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
          <div class="col-md-12">
            <div id="tblErr"></div>
            <table class="table table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th style="width: 30%;">Description</th>
                  <th style="width: 30%;">Accounting Code</th>
                  <th style="width: 30%;">Amount</th>
                  <th style="width: 10%;">
                    {{-- <button class="btn btn-info" onclick="thisInsRow('exTbody');"><i class="fa fa-plus"></i></button> --}}
                  </th>
                </tr>
              </thead>
              <tbody id="exTbody"></tbody>
              <tfoot>
                <tr>
                  <td colspan="2">
                    {{-- <textarea class="form-control" placeholder="Remarks" id="col_code"></textarea> --}}
                  </td>
                  <td><input type="number" class="form-control" id="credit" placeholder="Total" value="0.00" disabled></td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
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
    var sNNum = 0, j_num = "";
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
      let idIns = ['j_code', 't_desc', 'at_code1', 'payee', 'empid', 'cc_code', 'scc_code', 'credit', 'col_code', 'obr_code'], insName = ['seq_desc[]', 'at_code[]', 'debit[]', 'obr_code[]'], doms = [], domIns = [['_token', 'j_num'], [$('meta[name="csrf-token"]').attr('content'), j_num]];
      insErrMsg('warning', 'Sending request', 'dbsErr');
      idIns.forEach(function(a, b, c) { let d = document.getElementById(a); if(checkFields([d])) { domIns[0].push(a); domIns[1].push(d.value); } });
      insName.forEach(function(a, b, c) { let d = document.getElementsByName(a); for(let i = 0; i < d.length; i++) { if(checkFields([d[i]])) { if(a == 'obr_code[]') {if(d[i].checked) { domIns[0].push(a); domIns[1].push(d[i].value); } } else { domIns[0].push(a); domIns[1].push(d[i].value); } } } });
      insDataFunction(domIns, "{{ asset('accounting/request/insDisbursement') }}", "POST", {
        functionProcess: function(arr) {
          let setBool = true;
          arr.forEach(function(a, b, c) {
            if(a != true) {
              setBool = false;
            }
          });
          if(setBool) {
            window.location.href = "{{ asset('accounting/disbursement') }}";
          } else {
            insErrMsg('danger', arr[arr.length - 1], 'dbsErr');
          }
        }
      });
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