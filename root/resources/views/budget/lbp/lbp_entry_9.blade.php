@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'LBP','icon'=>'none','st'=>false],
        ['link'=>url("budget/lbp/".$form_no.""),'desc'=>'Local Budget Preparations','icon'=>'none','st'=>true]
    ];
    $_ch = "Local Budget Preparations"; // Module Name
@endphp
@section('content')
<!-- Content Header (Page header) -->
@include('layout._contentheader')
<!-- Main content -->
<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Local Budget Preparations #{{$form_no}}</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> --}}
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="">
          <form method="post" id="HdrForm" data-parsley-validate novalidate>
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                      <label>Financial Year <span style="color:red"><strong>*</strong></span></label>
                      {{-- <input type="text" class="form-control" name="hdr_fy_mo" disabled="" value=""> --}}
                      <select class="form-control select2 select2-hidden-accessible" name="fy" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Year</strong> is required." data-parsley-errors-container="#budget_fy_span" required>
                        @isset($years)
                        <option value="">Select Year...</option>
                        @foreach($years as $x3)
                          <option value="{{$x3->fy}}">{{$x3->fy}}</option>
                        @endforeach
                    @else
                        <option value="">No Year registered...</option>
                    @endisset
                      </select>
                      <span id="budget_fy_span"></span>
                  </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Reference</label>
                        <input type="text" class="form-control" name="t_desc">
                        <span id="hdr_t_desc_span"></span>
                    </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                      <label>Funding Source <span style="color:red"><strong>*</strong></span></label>
                      {{-- <input type="text" class="form-control" name="hdr_fy_mo" disabled="" value=""> --}}
                      <select class="form-control select2 select2-hidden-accessible" name="lbp08_b_num" onchange="curAmount = parseFloat(this.options[this.selectedIndex].id); insCurAmount();" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Year</strong> is required." data-parsley-errors-container="#budget_lbp08_b_num_span" required>
                        <option value="">Select Year...</option>
                        @foreach($getData as $gd)
                         {{-- <option value="{{$gd->b_num}}" id="{{$gd->appro_amnt}}">{{$gd->fy}} - {{$gd->fdesc}} ({{$gd->appro_amnt}})</option> --}}
                          <option value="{{$gd->fy}}" id="{{$gd->appro_amnt}}">{{$gd->fy}} - {{$gd->fdesc}} ({{$gd->appro_amnt}})</option>
                        @endforeach
                      </select>
                      <span id="budget_lbp08_b_num_span"></span>
                  </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-8"></div>
              <div class="col-md-4">
                Total Amount from Source: &#8369;&nbsp;<span id="getAll">0.00</span>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th><button type="button" class="btn btn-success" onclick="clrBody([[], ['check_office', 'check_fid', 'check_secid']]);" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus-circle"></i></button></th>
                      <th>Implementing Office</th>
                      <th>Particulars/Purpose</th>
                      <th>AIP Code</th>
                      <th>Object of Expenditure</th>
                      <th>Account Code</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody id="tBody_bod">

                  </tbody>
                </table>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12"><button type="submit" class="btn btn-success"><span id="submitId">Submit</span> form</button>  <button type="button" class="btn btn-danger" onclick="window.location.href = '{{ asset('budget/lbp') }}/{{$form_no}}';">Cancel</button></div>
            </div>
          </form>
        </div>
        <!-- /.box-body -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Insert data to Office</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                <label>Office</label>
                <select class="form-control" id="check_office" style="width: 100%;">
                  <option selected value>Select Office</option>
                  @foreach($office as $offices)
                    <option value="{{$offices->cc_code}}">{{$offices->cc_desc}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <label>Fund</label>
                <select class="form-control" id="check_fid" style="width: 100%;">
                  <option selected value>Select Fund</option>
                  @foreach($funds as $fund)
                    <option value="{{$fund->fid}}">{{$fund->fdesc}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <label>Sector</label>
                <select class="form-control" id="check_secid" style="width: 100%;">
                  <option selected value>Select Sector</option>
                  @foreach($sector as $sectors)
                    <option value="{{$sectors->secid}}">{{$sectors->secdesc}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="moveToOffice(document.getElementById('check_office').value, document.getElementById('check_office').options[document.getElementById('check_office').selectedIndex].text, document.getElementById('check_fid').value, document.getElementById('check_secid').value);">Add to Office</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModal1Label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="exampleModal1Label">Insert data to lines per Office</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <label>Office Selected</label>
                <select disabled class="form-control" id="office_selected" style="width: 100%;">
                  <option selected value>Select Office</option>
                  @foreach($office as $officess)
                    <option value="{{$officess->cc_code}}">{{$officess->cc_desc}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <label>PPA Group</label>
                <select class="form-control" id="check_ppa" style="width: 100%;">
                  <option selected value>Select PPA Group</option>
                  @foreach($ppa as $ppas)
                    <option value="{{$ppas->subgrpid}}">{{$ppas->subgrpdesc}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <label>Account Code</label>
                <select class="form-control" id="check_account" style="width: 100%;">
                  <option selected value>Select Account Code</option>
                  @foreach($account as $fund)
                    <option value="{{$fund->at_code}}" id="{{$fund->at_desc}}">{{$fund->at_code}} - {{$fund->at_desc}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="movetoOfficeLines(document.getElementById('office_selected').value, document.getElementById('check_ppa').value, document.getElementById('check_ppa').options[document.getElementById('check_ppa').selectedIndex].text, document.getElementById('check_account').value, document.getElementById('check_account').options[document.getElementById('check_account').selectedIndex].id, '0.00');">Add to lines per Office</button>
          </div>
        </div>
      </div>
    </div>

</section>
<!-- /.content -->
<script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
<script type="text/javascript">
  var curBody = "", nameName = { actualcollection: "Actual Collection", savings: "Savings", realignment: "Realignment", reversion: "REVERSION" }, numsUsed = {}, arrInsted = [], tempInsted = [], curAmount = 0;
  function changeCurAmount(cCurAmount) {
    let getAll = document.getElementById('getAll');
    if(getAll != null) {
      getAll.innerHTML = cCurAmount.toFixed(2);
    }
  }
  function insCurAmount() {
    let getTotalAmount = document.getElementsByClassName('getTotalAmount'), curHereAmount = 0;
    if(getTotalAmount.length > 0) { for(let i = 0; i < getTotalAmount.length; i++) {
      curHereAmount += parseFloat(getTotalAmount[i].value);
    } }
    changeCurAmount(curAmount - curHereAmount);
  }
  function curBodyIns(strBody) {
    let tBody = document.getElementById('tBody');
    if(tBody != null) { tBody.innerHTML = ""; }
    if(strBody != curBody) {
      curBody = strBody; if(document.getElementsByClassName('nameNameHere').length > 0) { for(let i = 0; i < document.getElementsByClassName('nameNameHere').length; i++){ document.getElementsByClassName('nameNameHere')[i].innerHTML = nameName[strBody]; } }
      clrBody([[], ['check_table', 'check_funds', 'check_fy', 'check_mo_from', 'check_mo_to']]);
    }
  }
  function forCheckboxes(clName, boolean) {
    let cName = document.getElementsByClassName(clName);
    if(cName.length > 0) { for(let i = 0; i < cName.length; i++) {
      cName[i].checked = boolean;
    } }
  }
  function clrBody(arrVal) {
    if(Array.isArray(arrVal)) {
      if(arrVal[0] != undefined) { if(Array.isArray(arrVal[0])) { for(let i = 0; i <arrVal[0].length; i++) { document.getElementById(arrVal[0][i]).value = ""; } } }
      if(arrVal[1] != undefined) { if(Array.isArray(arrVal[1])) { for(let i = 0; i <arrVal[1].length; i++) { $('#' + arrVal[1][i]).val("").trigger('change'); } } }
    }
  }
  function removeClone(clName) {
    let dom = document.getElementsByClassName(clName);
    if(dom != null || dom != undefined) {
      for(let i = 0; i < dom.length; i++) { dom[i].parentNode.removeChild(dom[i]); }
    }
  }
  function removeOneFromTableWithCol(thisNode) {
    if(thisNode != null) { thisNode.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(thisNode.parentNode.parentNode.parentNode.parentNode); }
  }
  function removeOneClone(thisNode) {
    if(! thisNode.parentNode.parentNode.parentNode.parentNode.hasAttribute('id')) { thisNode.parentNode.parentNode.parentNode.parentNode.removeChild(thisNode.parentNode.parentNode.parentNode); }
  }
  function moveToOffice(office, officename, fund, sector) {
    let tBody_bod = document.getElementById('tBody_bod'), office1 = document.getElementById('office_'+office);
    if(tBody_bod != null) { if(office1 == null) {
      tBody_bod.innerHTML += '<tr id="office_'+office+'"> <td><input type="hidden" name="cc_code[]" value="'+office+'"><input type="hidden" name="fid[]" value="'+fund+'"><input type="hidden" name="secid[]" value="'+sector+'"> <div><div><button class="btn btn-danger" onclick="removeOneFromTableWithCol(this)"><i class="fa fa-minus-circle"></i></button></div></div> </td> <td><b>'+officename+'</b> <button type="button" class="btn btn-success" onclick="clrBody([[], [\'check_ppa\', \'check_account\']]); $(\'#office_selected\').val(\''+office+'\').trigger(\'change\');" data-toggle="modal" data-target="#exampleModal1"><i class="fa fa-plus-circle"></i></button> </td> <td colspan="5"> <table class="table" id="tbody_'+office+'"> </table> </td> </tr>';
    } }
  }
  function movetoOfficeLines(office, ppa, ppadesc, account, account_desc, amount) {
    let office1 = document.getElementById('tbody_'+office), ppa_office = document.getElementById('tbody_'+office+'_'+ppa), anotherData = function(ppa_office1) { if(ppa_office1 != null) { ppa_office1.innerHTML += '<tr> <td><div class="row"><div class="col-md-2"><button class="btn btn-warning" onclick="removeOneFromTableWithCol(this)"><i class="fa fa-minus-circle"></i></button></div><div class="col-md-10"><input type="text" class="form-control" name="seq_desc['+office+'][]" placeholder="Account Title" value="'+account_desc+'"></div></div></td> <td></td> <td><input type="hidden" name="grpid['+office+'][]" value="'+ppa+'"> '+ppadesc+'</td> <td><input type="hidden" name="at_code['+office+'][]" value="'+account+'"> '+account+'</td> <td><input type="number" class="form-control getTotalAmount" name="appro_amnt['+office+'][]" placeholder="Amount" value="'+amount+'"></td> </tr>'; return true; } else { return false; } };
    if(office1 != null) {  if(ppa_office == null) { office1.innerHTML += '<tbody id="tbody_'+office+'_'+ppa+'"><tr> <td><div><button class="btn btn-danger" onclick="removeOneFromTableWithCol(this)"><i class="fa fa-times-circle"></i></button></div></td> <td colspan="4"> <b>'+ppadesc+'</b> </td> </tr></tbody>'; anotherData(document.getElementById('tbody_'+office+'_'+ppa)); } else { anotherData(document.getElementById('tbody_'+office+'_'+ppa)); } }
  }
  window.addEventListener('change', function(e) {
    let dDom = document.getElementById('checkbox_get'), cDom = document.getElementsByClassName('checkbox_get');
    if(e.type == "checkbox") { if(dDom != null) { let isTrue = dDom.checked; for(let i = 0; i < cDom.length; i++) { if(! cDom[i].checked) { isTrue = cDom[i].checked; } } dDom.checked = isTrue; } }
    if(e.target.classList.contains('getTotalAmount')) {
      insCurAmount();
    }
  });
  @isset($appDet)
  function forEditOnly() {
    let appDet = JSON.parse('{!!addslashes(json_encode($appDet))!!}'), usedCc_codes = {};
    for(let i = 0; i < appDet.length; i++) {
      document.getElementsByName('fy')[0].value = appDet[i]['fy'];
      document.getElementsByName('t_desc')[0].value = appDet[i]['t_desc'];
      $('select[name="lbp08_b_num"]').val(appDet[i]['lbp08_b_num']).trigger('change');

      if(! (appDet[i]['cc_code'] in usedCc_codes)) {
        usedCc_codes[appDet[i]['cc_code']] = appDet[i]['cc_code'];
        moveToOffice(appDet[i]['cc_code'], appDet[i]['cc_desc'], appDet[i]['fid'], appDet[i]['secid']);
      }
      movetoOfficeLines(appDet[i]['cc_code'], appDet[i]['grpid'], appDet[i]['subgrpdesc'], appDet[i]['at_code'], appDet[i]['seq_desc'], appDet[i]['appro_amnt']);
    }
  }
  forEditOnly();
  @endisset
</script>
@endsection