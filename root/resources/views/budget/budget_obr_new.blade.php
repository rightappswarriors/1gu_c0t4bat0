@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'LBP','icon'=>'none','st'=>false],
        ['link'=>url("accounting/obr/new"),'desc'=>'Obligation Request','icon'=>'none','st'=>true]
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
            <h3 class="box-title">Obligation Request</h3>
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
              <div class="col-md-3">
                <div class="form-group">
                    <label>Year <span style="color:red"><strong>*</strong></span></label>
                    {{-- <input type="text" class="form-control" name="hdr_fy_mo" disabled="" value=""> --}}
                    <select id="get_year" class="form-control select2 select2-hidden-accessible" name="fy" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Year</strong> is required." data-parsley-errors-container="#budget_fy_span" required>
                      <option value="">Select Year...</option>
                      @foreach($years as $fys)
                        <option value="{{$fys->fy}}">{{$fys->fy}}</option>
                      @endforeach
                    </select>
                    <span id="budget_fy_span"></span>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                    <label>Fund <span style="color:red"><strong>*</strong></span></label>
                    {{-- <input type="text" class="form-control" name="hdr_fy_mo" disabled="" value=""> --}}
                    <select id="get_fund" class="form-control select2 select2-hidden-accessible" name="fid" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Fund</strong> is required." data-parsley-errors-container="#budget_fid_span" required>
                      <option value="">Select Fund...</option>
                      @foreach($funds as $fids)
                        <option value="{{$fids->fid}}">{{$fids->fdesc}}</option>
                      @endforeach
                    </select>
                    <span id="budget_fid_span"></span>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                    <label>Sector <span style="color:red"><strong>*</strong></span></label>
                    {{-- <input type="text" class="form-control" name="hdr_fy_mo" disabled="" value=""> --}}
                    <select id="get_sector" class="form-control select2 select2-hidden-accessible" name="secid" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" onchange="hideShowAllFunctions();" data-parsley-required-message="<strong>Sector</strong> is required." data-parsley-errors-container="#budget_secid_span" required>
                      <option value="">Select Sector...</option>
                      @foreach($sector as $secids)
                        <option value="{{$secids->secid}}">{{$secids->secdesc}}</option>
                      @endforeach
                    </select>
                    <span id="budget_secid_span"></span>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                    <label>Function <span style="color:red"><strong>*</strong></span></label>
                    {{-- <input type="text" class="form-control" name="hdr_fy_mo" disabled="" value=""> --}}
                    <select id="get_function" class="form-control select2 select2-hidden-accessible" name="funcid" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Function</strong> is required." data-parsley-errors-container="#budget_funcid_span" required>
                      <option value="">Select Function...</option>
                      @foreach($function as $funcids)
                        <option value="{{$funcids->funcid}}" secid="{{$funcids->secid}}">{{$funcids->funcdesc}}</option>
                      @endforeach
                    </select>
                    <span id="budget_funcid_span"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label>Office <span style="color:red"><strong>*</strong></span></label>
                    {{-- <input type="text" class="form-control" name="hdr_fy_mo" disabled="" value=""> --}}
                    <select class="form-control select2 select2-hidden-accessible" name="office" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required-message="<strong>Office</strong> is required." data-parsley-errors-container="#budget_office_span" required>
                      <option value="">Select Office...</option>
                      @foreach($office as $offices)
                        <option value="{{$offices->cc_code}}">{{$offices->cc_desc}}</option>
                      @endforeach
                    </select>
                    <span id="budget_office_span"></span>
                </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Payee <span style="color:red"><strong>*</strong></span></label>
                      <input type="text" class="form-control" name="payee" data-parsley-errors-container="#hdr_payee_span" data-parsley-required-message="<strong>Payee</strong> is required." required>
                      <span id="hdr_payee_span"></span>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Obligation No.</label>
                      <input type="text" class="form-control" name="obr_ref">
                      <span id="hdr_obr_ref_span"></span>
                  </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                    <label>Employee No.</label>
                    {{-- <input type="text" class="form-control" name="hdr_fy_mo" disabled="" value=""> --}}
                    <select id="get_employee" class="form-control select2 select2-hidden-accessible" name="empid" value="" style="width: 100%;" tabindex="-1" aria-hidden="true">
                      <option value="">Select Employee...</option>
                      @foreach($employee as $employees)
                        <option value="{{$employees->empid}}">{{$employees->firstname}} {{$employees->mi}} {{$employees->lastname}}</option>
                      @endforeach
                    </select>
                    <span id="budget_empid_span"></span>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th><button type="button" class="btn btn-success" onclick=" $('#year_selected').val((new Date()).getFullYear()).trigger('change'); clrBody([[], ['check_office', 'check_b_num', 'check_particulars']]);" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus-circle"></i></button></th>
                      <th>Responsibility Center</th>
                      <th>Particulars</th>
                      <th>FPP</th>
                      <th>Account Classification</th>
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
              <div class="col-md-12"><button type="submit" class="btn btn-success"><span id="submitId">Submit</span> form</button>  <button type="button" class="btn btn-danger" onclick="window.location.href = '{{ asset('accounting/obr') }}';">Cancel</button></div>
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
              <div class="col-md-12">
                <label>Responsibility Center</label>
                <select class="form-control" id="check_office" style="width: 100%;">
                  <option selected value>Select Office</option>
                  @foreach($office as $offices)
                    <option value="{{$offices->cc_code}}">{{$offices->cc_desc}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <label>Particulars</label>
                <textarea class="form-control" id="check_particulars" placeholder="Particulars"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="moveToOffice(document.getElementById('check_office').value, document.getElementById('check_office').options[document.getElementById('check_office').selectedIndex].text, document.getElementById('check_particulars').value);">Add to Office</button>
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
                <label>Account Code</label>
                <select class="form-control" id="check_account" style="width: 100%;" onchange="$('#check_ppa').val(this.options[this.selectedIndex].getAttribute('reancy')).trigger('change'); document.getElementById('amount_check').value = this.options[this.selectedIndex].getAttribute('anotherreancy');">
                  <option selected value id reancy>Select Account Titles</option>
                </select>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-8">
                <label>PPA Group</label>
                <select disabled class="form-control" id="check_ppa" style="width: 100%;">
                  <option selected value>Select PPA Group</option>
                  @foreach($ppa as $ppas)
                    <option value="{{$ppas->subgrpid}}">{{$ppas->subgrpdesc}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <label>Appropriated Amount</label>
                <input type="text" id="amount_check" class="form-control" placeholder="0.00" disabled>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="movetoOfficeLines(document.getElementById('office_selected').value, document.getElementById('check_ppa').value, document.getElementById('check_ppa').options[document.getElementById('check_ppa').selectedIndex].text, document.getElementById('check_account').value, document.getElementById('check_account').options[document.getElementById('check_account').selectedIndex].text, document.getElementById('check_account').options[document.getElementById('check_account').selectedIndex].getAttribute('anotherreancy'), '0.00');">Add to lines per Office</button>
            
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
  function moveToOffice(office, officename, particulars) {
    let tBody_bod = document.getElementById('tBody_bod'), office1 = document.getElementById('office_'+office), _date = new Date()
    if(office != "") { if(tBody_bod != null) { if(office1 == null) {
      tBody_bod.innerHTML += '<tr id="office_'+office+'"> <td><input type="hidden" name="rcenter[]" value="'+office+'"> <div><div><button class="btn btn-danger" onclick="removeOneFromTableWithCol(this)"><i class="fa fa-minus-circle"></i></button></div></div> </td> <td><b>'+officename+'</b> <button type="button" class="btn btn-success" onclick="clrBody([[], [\'year_selected\', \'office_selected\', \'check_ppa\', \'check_account\', \'amount_check\']]); $(\'#office_selected\').val(\''+office+'\').trigger(\'change\'); getApproPo(document.getElementById(\'get_year\').value, document.getElementById(\'get_fund\').value, document.getElementById(\'get_sector\').value, document.getElementById(\'get_function\').value, \''+office+'\');" data-toggle="modal" data-target="#exampleModal1"><i class="fa fa-plus-circle"></i></button> </td> <td><input type="text" class="form-control" name="particulars[]" value="'+particulars+'" placeholder="Particulars"></td> <td colspan="3"> <table class="table" id="tbody_'+office+'"> </table> </td> </tr>';
    } } }
  }
  function getApproPo(year, fund, sector, functions, office) {
    let arrSs = ['_token', 'year', 'fund', 'sector', 'functions', 'office'], arrDd = [$('meta[name="csrf-token"]').attr('content'), year, fund, sector, functions, office], check_account = document.getElementById('check_account');
    insDataFunction([arrSs, arrDd], "{{ asset('budget/lbp') }}/sample/request", "POST", {
      functionProcess: function(arr) {
        if(arr.length > 0) {
          check_account.innerHTML = '<option selected value>Select Account Code</option>';
          for(let i = 0; i < arr.length; i++) {
            let ttl = (parseFloat(arr[i].appro_amnt) - parseFloat(arr[i].oblig_amnt)).toFixed(2);
            check_account.innerHTML += '<option value="'+arr[i].at_code+'" reancy="'+arr[i].subgrpid+'" anotherreancy="'+ttl+'">'+arr[i].at_desc+'</option>';
          }
        } else {
          check_account.innerHTML = '<option selected value>No Account Title(s)</option>';
        }
      }
    });
  }
  function movetoOfficeLines(office, ppa, ppadesc, account, account_desc, appro_amnt, amount) {
    let office1 = document.getElementById('tbody_'+office), ppa_office = document.getElementById('tbody_'+office+'_'+ppa), anotherData = function(ppa_office1) { if(ppa_office1 != null) { ppa_office1.innerHTML += '<tr> <td><div class="row"><div class="col-md-2"><button class="btn btn-warning" onclick="removeOneFromTableWithCol(this)"><i class="fa fa-minus-circle"></i></button></div><div class="col-md-10"><input type="text" class="form-control" name="seq_desc['+office+'][]" placeholder="Account Title" value="'+account_desc+'"></div></div></td> <td></td> <td><input type="hidden" name="grpid['+office+'][]" value="'+ppa+'"> '+ppadesc+'</td> <td><input type="hidden" name="at_code['+office+'][]" value="'+account+'"> '+account+'</td> <td><input type="hidden" name="appro_amnt['+office+'][]" value="'+appro_amnt+'"><input type="number" class="form-control getTotalAmount" name="oblig_amnt['+office+'][]" placeholder="Amount" value="'+amount+'"></td> </tr>'; return true; } else { return false; } };
    if(ppa != "" && account != "") {
      if(office1 != null) {  if(ppa_office == null) { office1.innerHTML += '<tbody id="tbody_'+office+'_'+ppa+'"><tr> <td><div><button class="btn btn-danger" onclick="removeOneFromTableWithCol(this)"><i class="fa fa-times-circle"></i></button></div></td> <td colspan="4"> <b>'+ppadesc+'</b> </td> </tr></tbody>'; anotherData(document.getElementById('tbody_'+office+'_'+ppa)); } else { anotherData(document.getElementById('tbody_'+office+'_'+ppa)); } }
    }
  }
  function getAllAtCodes(fy, office) {
    let arrSs = ['_token', 'fy', 'office'], arrDd = [$('meta[name="csrf-token"]').attr('content'), fy, office], check_b_num = document.getElementById('check_b_num');
    if(check_b_num != null) {
      check_b_num.innerHTML = '<option selected value>Loading Approriated Budget</option>';
      insDataFunction([arrSs, arrDd], "{{ asset('budget/lbp') }}/sample/request", "POST", {
        functionProcess: function(arr) {
          if(arr.length > 0) {
            check_b_num.innerHTML = '<option selected value>Select Approriated Budget</option>';
            for(let i = 0; i < arr.length; i++) {
              check_b_num.innerHTML += '<option value="'+arr[i].b_num+'">'+arr[i].fy+' '+arr[i].cc_desc+' ('+arr[i].fdesc+' - '+arr[i].secdesc+')</option>';
            }
          } else {
            check_b_num.innerHTML = '<option selected value>No Approriated Budget(s)</option>';
          }
        }
      });
    }
  }
  function getAllLines(bgt_b_num) {
    let arrSs = ['_token', 'bgt_b_num'], arrDd = [$('meta[name="csrf-token"]').attr('content'), bgt_b_num], check_account = document.getElementById('check_account');
    if(check_account != null) {
      check_account.innerHTML = '<option selected value>Loading Account titles</option>';
      insDataFunction([arrSs, arrDd], "{{ asset('budget/lbp') }}/sample/request", "POST", {
        functionProcess: function(arr) {
          if(arr.length > 0) {
            check_account.innerHTML = '<option selected value>Select Account Code</option>';
            for(let i = 0; i < arr.length; i++) {
              let ttl = (parseFloat(arr[i].allot_amnt) - parseFloat(arr[i].oblig_amnt)).toFixed(2);
              check_account.innerHTML += '<option value="'+arr[i].at_code+'" id="'+ttl+'" reancy="'+arr[i].grpid+'">'+arr[i].at_desc+'</option>';
            }
          } else {
            check_account.innerHTML = '<option selected value>No Account Title(s)</option>';
          }
        }
      });
    }    
  }
  window.addEventListener('change', function(e) {
    let dDom = document.getElementById('checkbox_get'), cDom = document.getElementsByClassName('checkbox_get');
    if(e.type == "checkbox") { if(dDom != null) { let isTrue = dDom.checked; for(let i = 0; i < cDom.length; i++) { if(! cDom[i].checked) { isTrue = cDom[i].checked; } } dDom.checked = isTrue; } }
    if(e.target.classList.contains('getTotalAmount')) {
      insCurAmount();
    }
  });
  function hideShowAllFunctions() {
    let dom = document.getElementsByName('funcid')[0], secid = document.getElementsByName('secid')[0], setHiddenNot = function(vId) { for(let i = 1; i < dom.options.length; i++) { if(dom.options[i].getAttribute('secid') == vId) { dom.options[i].removeAttribute('disabled'); dom.options[i].removeAttribute('hidden'); } else { dom.options[i].setAttribute('disabled', true); dom.options[i].setAttribute('hidden', true); } } };
    if(dom != null) { dom.value = ""; if(secid != null) { setHiddenNot(secid.value); } else { setHiddenNot(null); } $(document).ready(function() { $('select[name=funcid]').select2(); }); }

  }
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
  hideShowAllFunctions();
</script>
@endsection