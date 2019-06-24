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
      <div class="box-body" style="">
        <div id="dbsErr"></div>
        <div class="row">
          <div class="col-md-9">
            <center><strong>OBLIGATION REQUEST</strong></center>
          </div>
          <div class="col-md-3">
            <p style="float: right;">No: @isset($obr) <b><u>{{$obr[0][0]->obr_ref}}</u></b> @else <input type="text" id="obr_ref" placeholder="OBR No." @isset($obrEdit) value="{{$obrEdit[0][0]->obr_ref}}" @endisset> @endisset</p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <p>Payee</p>
            @isset($obr) <b><u>{{$obr[0][0]->payee}}</u></b> @else <input type="text" class="form-control" id="payee" placeholder="Payee" @isset($obrEdit) value="{{$obrEdit[0][0]->payee}}" @endisset> @endisset
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <p>Office</p>
            <select class="form-control" id="office">
              @isset($obr) @else <option value hidden selected disabled>Please select</option> @endisset
              @foreach($cc_data AS $cc_dataEach)
              <option value="{{$cc_dataEach->cc_code}}" @isset($obr) @if($obr[0][0]->office == $cc_dataEach->cc_code) selected="selected" @endif @endisset @isset($obrEdit) @if($obrEdit[0][0]->office == $cc_dataEach->cc_code) selected="selected" @endif @endisset>{{$cc_dataEach->cc_desc}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <p>Address</p>
            @isset($obr) <b><u>{{$obr[0][0]->address}}</u></b> @else <input type="text" class="form-control" id="address" placeholder="Address" @isset($obrEdit) value="{{$obrEdit[0][0]->address}}" @endisset> @endisset
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-3">
            <p>Fund: <span id="b_fid"><b>None</b></span></p>
          </div>
          <div class="col-md-3">
            <p>Cost Center: <span id="b_cc_desc"><b>None</b></span></p>
          </div>
          <div class="col-md-3">
            <p>Sector: <span id="b_secid"><b>None</b></span></p>
          </div>
          <div class="col-md-3">
            <p>Description: <span id="b_t_desc"><b>None</b></span></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <p>Responsibility Center</p>
            {{-- @isset($obr) <b><u>{{$obr[0][0]->rcenter}}</u></b> @else <input type="text" class="form-control" placeholder="Responsibility Center" id="rcenter"@isset($obrEdit) value="{{$obrEdit[0][0]->rcenter}}" @endisset> @endisset --}}
            <select class="form-control" id="rcenter">
              @isset($obr) @else <option value hidden selected disabled>Please select</option> @endisset
              @foreach($cc_data AS $cc_dataEach1)
              <option value="{{$cc_dataEach1->cc_code}}" @isset($obr) @if($obr[0][0]->rcenter == $cc_dataEach1->cc_code) selected="selected" @endif @endisset @isset($obrEdit) @if($obrEdit[0][0]->rcenter == $cc_dataEach1->cc_code) selected="selected" @endif @endisset>{{$cc_dataEach1->cc_desc}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <p>Particulars</p>
            @isset($obr) <b><u>{{$obr[0][0]->rcenter}}</u></b> @else <textarea class="form-control" placeholder="Particulars" id="particulars" @isset($obrEdit) value="{{$obrEdit[0][0]->particulars}}" @endisset>@isset($obrEdit) {{$obrEdit[0][0]->particulars}} @endisset</textarea> @endisset
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <table id="" class="table table-bordered">
              <thead class="thead-dark">
                <tr>
                  {{-- <th style="width: 1%;"></th>
                  <th style="width: 1%;"></th> --}}
                  <th style="width: 15%;">Line</th>
                  <th style="width: 15%;">FPP</th>
                  <th style="width: 20%;">Accounting Code</th>
                  <th style="width: 10%;">Alloted</th>
                  <th style="width: 25%;">Amount</th>
                  <th style="width: 10%;">
                    @if(! isset($obr)) {{-- <button class="btn btn-info" data-toggle="modal" data-target="#addObr"><i class="fa fa-plus"></i></button> --}}
                    <button class="btn btn-warning" data-toggle="modal" data-target="#addObr"><i class="fa fa-file-text-o"></i></button>
                    <button class="btn btn-danger" onclick="linesDel();"><i class="fa fa-times"></i></button> @endif
                  </th>
                </tr>
              </thead>
              <tbody id="exTbody"></tbody>
              <tfoot>
                <tr>
                  <td colspan="4" style="padding-top: 5%;"></td>
                  <td style="padding-top: 5%;"><b><u>&#8369;&nbsp;<span id="getAll">0.00</span></u></b></td>
                  <td style="padding-top: 5%;"></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        {{-- <hr>
        <div class="row">
          <div class="col-md-6">
            <p>A. Certified</p>
            <p><input type="checkbox" id="allotment"> <label for="allotment">Charges to appropriation/allotment necessary, lawful and under my direct supervision</label></p>
            <p><input type="checkbox" id="supporting"> <label for="supporting">Supporting documents valid proper and legal</label></p>
          </div>
          <div class="col-md-6">
            <p>B. Certified</p>
            <div class="row">
              <div class="col-md-4">
                Existense of available appropriation
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6" style="padding-top: 5%;">
            <center>
              <label style="border-bottom: 2px solid black; color: white;">asdfgasdwqerqerqwerwqersdfasdfwwqerew</label><span style="float: right; padding-right: 10%;">DATE</span><br>
              <span style="color: white;">Asst. City Treasurer/OIC-City Treasurer</span>
            </center>
          </div>
          <div class="col-md-6" style="padding-top: 5%;">
            <center>
              <label>MA. SOCORRO M. NUNEZ</label><span style="float: right; padding-right: 10%;">DATE</span><br>
              <span>City Budget Officer</span>
            </center>
          </div>
        </div> --}}
      </div>
      <div class="box-footer">
        <div class="pull-left">
          @if(! isset($obr)) <button class="btn btn-success" onclick="submitForm();"><i class="fa fa-paper-plane"></i> @isset($obrEdit) Update @else Submit @endisset form</button> @endif
        </div>
        <div class="pull-right">
          <a href="{{ asset('accounting/collection/obligation_request') }}"><button class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancel</button></a>
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
            <h3 class="modal-title">Budget Allocated</h3>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <p>Budget Allocated</p>
              <select class="form-control" id="b_num" style="width: 100%;" onchange="loadRecord();">
                <option value hidden selected disabled>Please select</option>
                @foreach($allot AS $allotEach)
                <option value="{{$allotEach[0]->b_num}}">{{$allotEach[0]->ref_num}} - {{$allotEach[0]->t_desc}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <p>Accounting code</p>
              <select class="form-control" id="pom" style="width: 100%;" onchange="loadRecord();">
                <option value hidden selected disabled>Please select</option>
                @foreach($pom AS $pomEach)
                <option value="{{$pomEach->at_code}}">{{$pomEach->at_code}} - {{$pomEach->at_desc}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div id="tblErr"></div>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th><input type="checkbox" onchange="changeCheckboxChecked(this.checked)"></th>
                    <th>Line #</th>
                    <th>Accounting Title</th>
                    <th>PPA</th>
                    <th>Alloted Amount</th>
                  </tr>
                </thead>
                <tbody id="clExTbdy"></tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal" onclick="submitTable();"><i class="fa fa-check"></i> Proceed</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
	<script type="text/javascript">
    var sNNum = 0, sNBool = false, obr_code = "{{((! isset($obrEdit)) ? "" : $obrEdit[0][0]->obr_code)}}", b_num = [], loadThisLater = [], seq_numAccpt = [];
    function sureInsRow(elId, insRow) {
      sNNum++;
      addNewRow(elId, insRow);
      giveTotal(['debit[]', 'addedDebit'], 'getAll');
      for(let i = 0; i < document.getElementsByClassName('addRowSpan').length; i++) {
        document.getElementsByClassName('addRowSpan')[i].setAttribute('rowspan', (document.getElementById('exTbody').getElementsByTagName('tr').length));
      }
    }
    function thisDelRow(btnId) {
      let eDom = (document.getElementById(btnId).parentNode).parentNode;
      deleteCurrentRow(eDom);
      giveTotal(['debit[]', 'addedDebit'], 'getAll');
    }
    function linesDel() {
      let asdfg = document.getElementsByClassName('forMultipleDelete');
      if(checkFields([asdfg])) {
        for(let i = 0; i < asdfg.length; i++) {
          if(asdfg[i].checked) {
            deleteCurrentRow((asdfg[i].parentNode).parentNode);
            giveTotal(['debit[]', 'addedDebit'], 'getAll');
          }
        }
      }
    }
    function thisDelRowByClass(btnClName) {
      let cDom = document.getElementsByClassName(btnClName);
      for(let i = 0; i < cDom.length; i++) {
        if(checkFields([cDom[i]])) {
          deleteCurrentRow(cDom[i]);
          giveTotal(['debit[]', 'addedDebit'], 'getAll');
        }
      }
    }
    function loadRecord() {
      thisDelRowByClass('fromOldData'); insErrMsg('warning', 'Sending request', 'tblErr');
      let b_num = document.getElementById('b_num'), pom = document.getElementById('pom');
      if(checkFields([b_num, pom])) {
        let arrSs = ['_token', 'b_num', 'at_code'], arrDd = [$('meta[name="csrf-token"]').attr('content'), b_num.value, pom.value];
        insDataFunction([arrSs, arrDd], "{{ asset('accounting/request/getAllotLines') }}", "POST", {
          functionProcess: function(arr) {
            insErrMsg('success', 'Request sent.', 'tblErr');
            if(Array.isArray(arr)) {
              loadThisLater = arr;
              document.getElementById('clExTbdy').innerHTML = "";
              for(let i = 0; i < arr.length; i++) {
                let insRow = '<tr> <td> <input type="checkbox" class="forMultipleDelete" value="'+arr[i].seq_num+'"> </td> <td> '+arr[i].seq_num+' </td> <td> '+arr[i].at_code+' </td> <td> '+arr[i].grpid+' </td> <td> '+arr[i].allot_amnt1+' </td> </tr>';
                sureInsRow('clExTbdy', insRow);
              }
              @isset($obrEdit) ifObrEdit(); @endisset
            } else {
              let insRow = '';
              sureInsRow('clExTbdy', insRow);
            }
          }
        });
      }
    }
    function submitTable() {
      document.getElementById('exTbody').innerHTML = '';
      let forMultipleDelete = document.getElementsByClassName('forMultipleDelete');
      if(checkFields([forMultipleDelete])) {
        for(let i = 0; i < forMultipleDelete.length; i++) {
          if(forMultipleDelete[i].checked) {
            loadThisLater.forEach(function(a, b, c) {
              if(a.seq_num == forMultipleDelete[i].value) {
                let insRow = '<tr> <td> <input type="text" class="form-control" name="seq_num[]" value="'+a.seq_num+'" disabled> <input type="hidden" name="grp_id[]" value="'+a.grpid+'"> </td> <td> <input type="text" class="form-control" name="fpp[]" placeholder="FPP"> </td> <td> <input type="text" class="form-control" disabled name="at_code[]" value="'+a.at_code+'"> </td> <td> <input class="form-control" type="hidden" name="def_amnt[]" disabled value="'+a.allot_amnt+'"><input class="form-control" type="text" name="allot_amnt[]" disabled value="'+a.allot_amnt+'"> </td> <td> <input type="number" class="form-control" name="debit[]" placeholder="Amount"onchange="giveTotal([\'debit[]\', \'addedDebit\'], \'getAll\'); checkLineAmount(\'debit[]\', \'allot_amnt[]\', \'def_amnt[]\');"> </td> </tr>';
                sureInsRow('exTbody', insRow);
              }
            });
          }
        }
      }
    }
    function submitForm() {
      let idIns = ['obr_ref', 'payee', 'particulars', 'rcenter', 'office', 'address', 'b_num'], insName = ['seq_num[]', 'fpp[]', 'grp_id[]', 'at_code[]', 'debit[]', 'obr_code[]'], doms = [], domIns = [['_token', 'obr_code'], [$('meta[name="csrf-token"]').attr('content'), obr_code]];
      insErrMsg('warning', 'Sending request', 'dbsErr');
      idIns.forEach(function(a, b, c) { let d = document.getElementById(a); if(checkFields([d])) { domIns[0].push(a); domIns[1].push(d.value); } });
      insName.forEach(function(a, b, c) { let d = document.getElementsByName(a); for(let i = 0; i < d.length; i++) { if(checkFields([d[i]])) { if(d == 'obr_code[]') {if(d[i].checked) { domIns[0].push(a); domIns[1].push(d[i].value); } } else { domIns[0].push(a); domIns[1].push(d[i].value); } } } });
      insDataFunction(domIns, "{{ asset('accounting/request/insOBR') }}", "POST", {
        functionProcess: function(arr) {
          let setBool = true;
          arr.forEach(function(a, b, c) {
            if(a != true) {
              setBool = false;
            }
          });
          if(setBool) {
            window.location.href = "{{ asset('accounting/collection/obligation_request') }}";
          } else {
            insErrMsg('danger', arr[arr.length - 1], 'dbsErr');
          }
        }
      });
    }
    function changeCheckboxChecked(checkedBool) {
      let asdfg = document.getElementsByClassName('forMultipleDelete');
      if(checkFields([asdfg])) {
        for(let i = 0; i < asdfg.length; i++) {
          asdfg[i].checked = checkedBool;
        }
      }
    }
    function ifObrEdit() {
      let forMultipleDelete = document.getElementsByClassName('forMultipleDelete');
      @isset($obrEdit) @if(count($obrEdit[0][1]) > 0) @foreach($obrEdit[0][1] AS $obrEditEach)
      if(forMultipleDelete != null || forMultipleDelete != undefined) { for(let i = 0; i < forMultipleDelete.length; i++) { 
        if(forMultipleDelete[i].value == "{{$obrEditEach->seq_num}}") {
          forMultipleDelete[i].checked = true;
        }
      } }
      submitTable();
      @endforeach @endif @endisset
      ifObrEditTotal();
    }
    function ifObrEditTotal() {
      let seq_num = document.getElementsByName('seq_num[]'), debit = document.getElementsByName('debit[]'), fpp = document.getElementsByName('fpp[]');
      @isset($obrEdit) @if(count($obrEdit[0][1]) > 0) @foreach($obrEdit[0][1] AS $obrEditEach)
      if(seq_num != null || seq_num != undefined) { for(let i = 0; i < seq_num.length; i++) { 
        if(seq_num[i].value == "{{$obrEditEach->seq_num}}") {
          debit[i].value = parseFloat("{{$obrEditEach->debit}}");
          fpp[i].value = "{{$obrEditEach->fpp}}";
        }
      } }
      @endforeach @endif @endisset
      giveTotal(['debit[]', 'addedDebit'], 'getAll'); checkLineAmount('debit[]', 'allot_amnt[]', 'def_amnt[]');
    }
  </script>
  <script type="text/javascript">
    @isset($obrEdit)
    document.getElementById('b_num').value = "{{$obrEdit[0][0]->b_num}}";
    loadRecord();
    @endisset
  </script>
@endsection