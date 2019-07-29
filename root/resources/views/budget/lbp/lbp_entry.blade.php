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
                        <label>Fund <span style="color:red"><strong>*</strong></span></label>
                        <select class="form-control select2 select2-hidden-accessible" name="fid" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_fid_span" data-parsley-required-message="<strong>Fund</strong> is required." required>
                            @isset($funds)
                                <option value="">Select Fund...</option>
                                @foreach($funds as $fund)
                                    <option value="{{$fund->fid}}">{{$fund->fdesc}}</option>
                                @endforeach
                            @else
                                <option value="">No Fund registered...</option>
                            @endisset
                        </select>
                        <span id="hdr_fid_span"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Reference</label>
                        <input type="text" class="form-control" name="t_desc">
                        <span id="hdr_t_desc_span"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sector <span style="color:red"><strong>*</strong></span></label>
                        <select class="form-control select2 select2-hidden-accessible" name="secid" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#hdr_secid_span" data-parsley-required-message="<strong>Sector</strong> is required." required>
                            @isset($sector)
                                <option value="">Select Sector...</option>
                                @foreach($sector as $sectors)
                                    <option value="{{$sectors->secid}}">{{$sectors->secdesc}}</option>
                                @endforeach
                            @else
                                <option value="">No Sectors registered...</option>
                            @endisset
                        </select>
                        <span id="hdr_secid_span"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Function <span style="color:red"><strong>*</strong></span></label>
                        {{-- <input type="text" class="form-control" name="hdr_fy_mo" disabled="" value=""> --}}
                        <select class="form-control select2 select2-hidden-accessible" name="funcid" value="" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#budget_funcid_span" data-parsley-required-message="<strong>Function</strong> is required." required>
                          @isset($function)
                          <option value="">Select Function...</option>
                          @foreach($function as $functions)
                            <option value="{{$functions->funcid}}" secid="{{$functions->secid}}">{{$functions->funcdesc}}</option>
                          @endforeach
                      @else
                          <option value="">No Function registered...</option>
                      @endisset
                        </select>
                        <span id="budget_funcid_span"></span>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 40%">Particulars</th>
                      <th style="width: 30%">Account Classification</th>
                      <th style="width: 30%">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th colspan="3">
                         @if(!isset($edit))
                        <button type="button" class="btn btn-success" onclick="insRevenue('','','');"><i class="fa fa-plus-circle"></i></button>
                        @endif
                        1.0 New Revenue Sources</th>
                    </tr>
                    <tr>
                      <td colspan="3">
                        <table class="table"><tbody id="newrevenue"></tbody></table>
                      </td>
                    </tr>
                    <tr>
                      <th colspan="3">
                        @if(!isset($edit))
                        <button type="button" class="btn btn-success" onclick="curBodyIns('actualcollection');" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus-circle"></i></button>
                        @endif 
                      2.0 Actual Collection in Excess of the Estimated Income</th>
                    </tr>
                    <tr>
                      <td colspan="3">
                        <table class="table"><tbody id="actualcollection"></tbody></table>
                      </td>
                    </tr>
                    <tr>
                      <th colspan="3">
                        @if(!isset($edit))
                        <button type="button" class="btn btn-success" onclick="curBodyIns('savings');" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus-circle"></i></button> 
                        @endif
                      3.0 Savings</th>
                    </tr>
                    <tr>
                      <td colspan="3">
                        <table class="table"><tbody id="savings"></tbody></table>
                      </td>
                    </tr>
                    <tr>
                      <th colspan="3">
                        @if(!isset($edit))
                        <button type="button" class="btn btn-success" onclick="curBodyIns('realignment');" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus-circle"></i></button> 
                        @endif
                        4.0 Realignment
                      </th>
                    </tr>
                    <tr>
                      <td colspan="3">
                        <table class="table"><tbody id="realignment"></tbody></table>
                      </td>
                    </tr>
                    <tr>
                      <th colspan="3">
                        @if(!isset($edit))
                        <button type="button" class="btn btn-success" onclick="curBodyIns('reversion');" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus-circle"></i></button> 
                        @endif
                      5.0 REVERSION</th>
                    </tr>
                    <tr>
                      <td colspan="3">
                        <table class="table"><tbody id="reversion"></tbody></table>
                      </td>
                    </tr>
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
            <h3 class="modal-title" id="exampleModalLabel">Insert data to <span class="nameNameHere"></span></h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <center><label>Where to get Funds</label></center>
            <div class="row">
              <div class="col-md-3">
                <select class="form-control" id="check_table" style="width: 100%;">
                  <option selected value disabled hidden>Select Table</option>
                  <option value="bgtps">Appropriation</option>
                  <option value="bgt">Allotment</option>
                </select>
              </div>
              <div class="col-md-3">
                <select class="form-control" id="check_funds" style="width: 100%;">
                  <option selected value>Select Funds</option>
                  @foreach($funds as $funding)
                    <option value="{{$funding->fid}}">{{$funding->fdesc}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <select class="form-control" id="check_ppa" style="width: 100%;">
                  <option selected value>Select PPA Sub-group</option>
                  @foreach($ppa as $ppas)
                    <option value="{{$ppas->subgrpid}}">{{$ppas->subgrpdesc}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <button class="btn btn-info btn-block" onclick="searchData()"><span id="forLoading"></span> Search</button>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-4">
                <label>Fiscal Year</label>
                <select class="form-control" id="check_fy" style="width: 100%;">
                  <option selected value>Select Year</option>
                  @foreach($years as $year)
                    <option value="{{$year->fy}}">{{$year->fy}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <label>Month (from)</label>
                <select class="form-control" id="check_mo_from" style="width: 100%;">
                  <option selected value>Select Month</option>
                  <option value="1">January</option>
                  <option value="2">February</option>
                  <option value="3">March</option>
                  <option value="4">April</option>
                  <option value="5">May</option>
                  <option value="6">June</option>
                  <option value="7">July</option>
                  <option value="8">August</option>
                  <option value="9">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
                </select>
              </div>
              <div class="col-md-4">
                <label>Month (to)</label>
                <select class="form-control" id="check_mo_to" style="width: 100%;">
                  <option selected value>Select Month</option>
                  <option value="1">January</option>
                  <option value="2">February</option>
                  <option value="3">March</option>
                  <option value="4">April</option>
                  <option value="5">May</option>
                  <option value="6">June</option>
                  <option value="7">July</option>
                  <option value="8">August</option>
                  <option value="9">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
                </select>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6" hidden>
                <input type="checkbox" id="check_group">
                <label for="check_group">Group data</label>
              </div>
              <div class="col-md">
                <input type="checkbox" id="checkbox_get" onchange="forCheckboxes('checkbox_get', this.checked);">
                <label for="checkbox_get">Select All</label>
              </div>

            </div>
            <hr>
            <div class="container-fluid">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th></th>
                    <th>Account Classification</th>
                    <th>Account Title</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody id="tBody"> </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="moveToDivs();" data-dismiss="modal">Add to <span class="nameNameHere"></span></button>
          </div>
        </div>
      </div>
    </div>

</section>
<!-- /.content -->
<script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
<script type="text/javascript">
  var curBody = "", nameName = { actualcollection: "Actual Collection", savings: "Savings", realignment: "Realignment", reversion: "REVERSION" }, numsUsed = {}, arrInsted = [], tempInsted = [];
  function curBodyIns(strBody) {
    let tBody = document.getElementById('tBody');
    if(strBody != curBody) {
      if(tBody != null) { tBody.innerHTML = ""; }
      curBody = strBody; if(document.getElementsByClassName('nameNameHere').length > 0) { for(let i = 0; i < document.getElementsByClassName('nameNameHere').length; i++){ document.getElementsByClassName('nameNameHere')[i].innerHTML = nameName[strBody]; } }
      clrBody([[], ['check_table', 'check_funds', 'check_fy', 'check_mo_from', 'check_mo_to'], ['check_group', 'checkbox_get']]);
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
      if(arrVal[2] != undefined) { if(Array.isArray(arrVal[2])) { for(let i = 0; i <arrVal[2].length; i++) { document.getElementById(arrVal[2][i]).checked = false; } } }
    }
  }
  function cloneAppend(elId, elInsTo) {
    let dom = document.getElementById(elId);
    if(dom != null || dom != undefined) {
      let dClone = dom.cloneNode(true), insDom = document.getElementById(elInsTo);
      if(insDom != null || insDom != undefined) { 
        dClone.removeAttribute('id'); dClone.classList.add(elId); insDom.appendChild(dClone);
        let doms = insDom.getElementsByClassName(elId)[insDom.getElementsByClassName(elId).length - 1];
        if(doms != undefined || doms != null) { let ndoms = ["input", "select"]; for(let j = 0; j < ndoms.length; j++) { let cdom = doms.getElementsByTagName(ndoms[j]); if(cdom != undefined || cdom != null) { for(let i = 0; i < cdom.length; i++) { cdom[i].value = ""; } } } }
      }
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
  // function insRevenue(samplevalue) {
  //   let newrevenue = document.getElementById('newrevenue');
  //   if(newrevenue != null) {
  //     newrevenue.innerHTML += '<tr><td>'
  //     +'<div class="row"><div class="col-md-1"><button type="button" class="btn btn-danger" onclick="removeOneClone(this)"><i class="fa fa-times-circle"></i></button></div><div class="col-md-11"><input type="text" class="form-control" name="seq_desc[]" placeholder="New Revenue Sources" value="'+samplevalue+'"></div></div><input type="hidden" class="form-control" name="form_where[]" value="newrevenue"><input type="hidden" name="check_table[]" value=""><input type="hidden" name="check_funds[]" value=""><input type="hidden" name="check_ppa[]" value=""><input type="hidden" name="check_fy[]" value=""><input type="hidden" name="check_mo_from[]" value=""><input type="hidden" name="check_mo_to[]" value=""><input type="hidden" name="at_code[]" value=""><input type="hidden" name="at_desc[]" value=""><input type="hidden" name="appro_amnt[]" value=""><input type="hidden" class="form-control" name="group_m[]" value=""></td></tr>';
  //   }
  // }

  function insRevenue(samplevalue,bnum,seqnum) {
    let newrevenue = document.getElementById('newrevenue');
    if(newrevenue != null) {
      whatToInsert = '<tr><td>'
      +'<div class="row"><div class="col-md-1"> @if(!isset($edit))<button type="button" class="btn btn-danger" onclick="removeOneClone(this)"><i class="fa fa-times-circle"></i></button>@endif </div><div class="col-md-11"><input type="text" class="form-control" name="seq_desc[]" placeholder="New Revenue Sources" value="'+samplevalue+'">'+(Number(bnum) >= 1 && Number(seqnum) >= 1 ? '<input type="hidden" class="form-control" name="b_num[]" value="'+bnum+'"><input type="hidden" class="form-control" name="seq_num[]" value="'+seqnum+'">' :'')+'</div></div><input type="hidden" class="form-control" name="form_where[]" value="newrevenue"><input type="hidden" name="check_table[]" value=""><input type="hidden" name="check_funds[]" value=""><input type="hidden" name="check_ppa[]" value=""><input type="hidden" name="check_fy[]" value=""><input type="hidden" name="check_mo_from[]" value=""><input type="hidden" name="check_mo_to[]" value=""><input type="hidden" name="at_code[]" value=""><input type="hidden" name="at_desc[]" value=""><input type="hidden" name="appro_amnt[]" value=""><input type="hidden" class="form-control" name="group_m[]" value=""></td></tr>';
    }
    // $(whatToInsert).insertBefore(newrevenue);
    $(newrevenue).append(whatToInsert);
  }
  function searchData() {
    let arrSs = ['_token', 'check_table', 'check_funds', 'check_ppa', 'check_fy', 'check_mo_from', 'check_mo_to'], arrDd = [$('meta[name="csrf-token"]').attr('content'), document.getElementById('check_table').value, document.getElementById('check_funds').value, document.getElementById('check_ppa').value, document.getElementById('check_fy').value, document.getElementById('check_mo_from').value, document.getElementById('check_mo_to').value], forLoading = document.getElementById('forLoading');
    if(forLoading != null) { forLoading.innerHTML = '<img src="{{ asset('root/public/img/load.gif') }}">'; }
    insDataFunction([arrSs, arrDd], "{{ asset('budget/lbp') }}/{{$form_no}}/request", "POST", {
      functionProcess: function(arr) {
        let colThis = ((arrDd[1] == "bgtps") ? "appro_amnt" : "allot_amnt"), tBody = document.getElementById('tBody');
        if(forLoading != null) { forLoading.innerHTML = ''; }
        if(tBody != null) {
          tBody.innerHTML = "";
          if(arr.length > 0) {
            // tempInsted = []; arr.map(function(a, b, c) { tempInsted.push(a); });
            for(let i = 0; i < arr.length; i++) {
              let tl_amt = (parseFloat(arr[i][colThis]) - parseFloat(arr[i]['oblig_amnt']) - parseFloat(arr[i]['lbp_amnt'])).toFixed(2);
              // arrInsted.map(function(a, b, c) { if(a.at_code == arr[i]['at_code']) { tl_amt = tl_amt - a[colThis]; } });
              tBody.innerHTML += '<tr> <td><input type="hidden" name="check_table1[]" value="'+arrDd[1]+'"> <input type="hidden" name="check_funds1[]" value="'+arrDd[2]+'"> <input type="hidden" name="check_ppa1[]" value="'+arrDd[3]+'"> <input type="hidden" name="check_fy1[]" value="'+arrDd[4]+'"> <input type="hidden" name="check_mo_from1[]" value="'+arrDd[5]+'"> <input type="hidden" name="check_mo_to1[]" value="'+arrDd[6]+'"> <input type="hidden" name="at_code1[]" value="'+arr[i]['at_code']+'"> <input type="hidden" name="at_desc1[]" value="'+arr[i]['at_desc']+'"> <input type="checkbox" class="checkbox_get" name="group_check[]" value="'+arr[i]['at_code']+'"></td> <td>'+arr[i]['at_code']+'</td> <td><b>'+arr[i]['at_desc']+'</b></td> <td><input type="number" class="form-control" name="amount1[]" value="'+tl_amt+'"></td> </tr>';
            }
          }
        }
      }
    });
  }
  function moveToDivs(arrData = []) {
    let check_group = ['group_check[]'], nmArrays = [['check_table1[]', 'check_funds1[]', 'check_ppa1[]', 'check_fy1[]', 'check_mo_from1[]', 'check_mo_to1[]', 'at_code1[]', 'at_desc1[]', 'amount1[]']], moveMArrays = [['check_table[]', 'check_funds[]', 'check_ppa[]', 'check_fy[]', 'check_mo_from[]', 'check_mo_to[]', 'at_code[]', 'at_desc[]', 'appro_amnt[]']], needsTotal = [['amount1[]']], arrConsole = [], groupThis = 0, 
    insDoms = function() { for(let i = 0; i < check_group.length; i++) { 
    let cDom = document.getElementsByName(check_group[i]); 
    if(cDom.length > 0) { 
      for(let k = 0; k < cDom.length; k++) { 
        let cArrConsole = {}, cStrConsole = ""; 
        if(cDom[k] != null) { 
          if(cDom[k].checked) { 
            if(nmArrays[i] != undefined) { 
              if(Array.isArray(nmArrays[i])) { 
                for(let j = 0; j < nmArrays[i].length; j++) { 
                  let dDom = document.getElementsByName(nmArrays[i][j])[k]; 
                  if(dDom != null) { 
                    cArrConsole[moveMArrays[i][j]] = dDom.value; 
                    cStrConsole += '<input type="hidden" name="'+moveMArrays[i][j]+'" value="'+dDom.value+'">'; 
                  } 
                } 
              } 
            } 
            arrConsole.push([cStrConsole, cArrConsole]); 
          } 
        } 
      } 
    } /* cArrConsole */ } return arrConsole; }, cBody = document.getElementById(curBody); //arrInsted.map(function(a, b, c) { tempInsted.push(a); });

    if(cBody != null) { if(curBody != "") { 
      if(document.getElementById('check_group') != null) { 
        if(document.getElementById('check_group').checked) { 
          let i = 1, csStr = "", csSum = 0, insTDom = insDoms(); 
          for(let k = 0; k < i; k++) { 
            if(! (i in numsUsed)) { 
              numsUsed[i] = i; break; 
            } else { 
              i++; 
            } 
          } for(let j = 0; j < insTDom.length; j++) { 
            csStr += insTDom[j][0] + '<input type="hidden" class="form-control" name="group_m[]" value="'+i+'"><input type="hidden" class="form-control" name="form_where[]" value="'+curBody+'">'; csSum += parseFloat(insTDom[j][1]['appro_amnt[]']); 
          } 
          cBody.innerHTML += '<tr> <td>'+csStr+' <div class="row"><div class="col-md-2"><button class="btn btn-danger" onclick="removeOneFromTableWithCol(this)"><i class="fa fa-minus-circle"></i></button></div><div class="col-md-10"><input type="text" class="form-control" name="seq_desc[]" placeholder="'+nameName[curBody]+' Description"></div></div></td> <td></td> <td></td> <td><b>'+csSum.toFixed(2)+'</b></td> </tr>'; 
        } else {
      let j = 1, insTDom = insDoms();
      for(let i = 0; i < insTDom.length; i++) {
        for(let k = 0; k < j; k++) { 
          if(! (j in numsUsed)) { 
            numsUsed[j] = j; break; 
          } else { 
            j++; 
          } 
        }
        cBody.innerHTML += '<tr> <td>'+insTDom[i][0] + '<input type="hidden" class="form-control" name="group_m[]" value="'+j+'"><input type="hidden" class="form-control" name="form_where[]" value="'+curBody+'"> <div class="row"><div class="col-md-2"> @if(!isset($edit))<button class="btn btn-danger" onclick="removeOneFromTableWithCol(this)"><i class="fa fa-minus-circle"></i></button>@endif </div><div class="col-md-10"> <input type="text" class="form-control" name="seq_desc[]" placeholder="'+nameName[curBody]+' Description" value="'+insTDom[i][1]['at_desc[]']+'"></div></div></td> <td><b>'+insTDom[i][1]['at_code[]']+'</b></td> <td></td> <td><b>'+insTDom[i][1]['appro_amnt[]']+'</b></td> </tr>';
        
      }
    } 
  } 
} 
}
  }
  window.addEventListener('change', function(e) {
    let dDom = document.getElementById('checkbox_get'), cDom = document.getElementsByClassName('checkbox_get');
    if(e.type == "checkbox") { if(dDom != null) { let isTrue = dDom.checked; for(let i = 0; i < cDom.length; i++) { if(! cDom[i].checked) { isTrue = cDom[i].checked; } } dDom.checked = isTrue; } }
  });
  @isset($appDet)
  function forEditOnly() {
    let appDet = JSON.parse('{!!addslashes(json_encode($appDet))!!}');
    for(let i = 0; i < appDet.length; i++) {
      document.getElementsByName('fy')[0].value = appDet[i]['fy'];
      document.getElementsByName('fid')[0].value = appDet[i]['fid'];
      document.getElementsByName('t_desc')[0].value = appDet[i]['t_desc'];
      document.getElementsByName('secid')[0].value = appDet[i]['secid'];
      document.getElementsByName('funcid')[0].value = appDet[i]['funcid'];
      

      curBodyIns(appDet[i]['form_where']);
      if(appDet[i]['form_where'] == "newrevenue") {
        insRevenue(appDet[i]['seq_desc'],appDet[i]['b_num'],appDet[i]['seq_num']);
      } else {
        let tBody = document.getElementById('tBody');
        if(tBody != null) {
          if((i - 1) > -1) { if(appDet[i-1]['group_m'] != appDet[i]['group_m']) { tBody.innerHTML = ""; } else { if(document.getElementById('check_group') != null) { document.getElementById('check_group').checked = true; } } }
          let tl_amt = (parseFloat(appDet[i]['appro_amnt'])).toFixed(2);
          tBody.innerHTML += '<tr> <td><input type="hidden" name="check_table1[]" value="'+appDet[i]['check_table']+'"> <input type="hidden" name="check_funds1[]" value="'+appDet[i]['check_funds']+'"> <input type="hidden" name="check_ppa1[]" value="'+appDet[i]['check_ppa']+'"> <input type="hidden" name="check_fy1[]" value="'+appDet[i]['check_fy']+'"> <input type="hidden" name="check_mo_from1[]" value="'+appDet[i]['check_mo_from']+'"> <input type="hidden" name="check_mo_to1[]" value="'+appDet[i]['check_mo_to']+'"> <input type="hidden" name="at_code1[]" value="'+appDet[i]['at_code']+'"> <input type="hidden" name="at_desc1[]" value="'+appDet[i]['seq_desc']+'"> <input type="hidden" class="form-control" name="b_num[]" value="'+appDet[i]['b_num']+'"><input type="hidden" class="form-control" name="seq_num[]" value="'+appDet[i]['seq_num']+'">  <input type="checkbox" class="checkbox_get" name="group_check[]" value="'+appDet[i]['appro_amnt']+'" checked></td> <td>'+appDet[i]['at_code']+'</td> <td><b>'+appDet[i]['at_desc']+'</b></td> <td><input type="number" class="form-control" name="amount1[]" value="'+tl_amt+'"></td> </tr>';
          if((i + 1) < appDet.length) { 
            if(appDet[i+1]['group_m'] != appDet[i]['group_m']) { 
              moveToDivs([appDet[i]['b_num'],appDet[i]['seq_num']]); 
            } 
          }
        }
      }
    }
  }
  forEditOnly();
  @endisset
</script>
@endsection