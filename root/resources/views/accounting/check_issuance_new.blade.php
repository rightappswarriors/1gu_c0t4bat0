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
            <center><strong>CHECK ISSUANCE</strong></center>
          </div>
          <div class="col-md-3">
            <p>Check Date</p>
            <input type="date" class="form-control" id="chk_date">
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-7">
            <p>Payee</p>
            <input type="text" class="form-control" id="payee" placeholder="Payee">
          </div>
          <div class="col-md-5">
            <p>Disbursement Entry</p>
            <input type="hidden" id="j_code"><input type="hidden" id="j_num">
            <select class="form-control" id="j_code-j_num" onchange="setJcodeNum();">
              <option value hidden selected disabled>Please select</option>
              @if(count($tr01) > 0) @foreach($tr01 AS $tr01Each)
              <option value="{{$tr01Each[0]->j_code}}_{{$tr01Each[0]->j_num}}">{{$tr01Each[0]->t_desc}} - {{$tr01Each[0]->payee}}</option>
              @endforeach @endif
            </select>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <p>Check No.</p>
            <input type="text" class="form-control" id="chk_no" placeholder="Check No.">
          </div>
          <div class="col-md-6">
            <p>Bank Name</p>
            <input type="text" class="form-control" id="chk_bank" placeholder="Bank Name">
          </div>
        </div>
      </div>
      <div class="box-footer">
        <div class="pull-left">
          @if(! isset($obr)) <button class="btn btn-success" onclick="submitForm();"><i class="fa fa-paper-plane"></i> @isset($obrEdit) Update @else Submit @endisset form</button> @endif
        </div>
        <div class="pull-right">
          <a href="{{ asset('accounting/disbursement/check_issuance') }}"><button class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancel</button></a>
        </div>
      </div>
    </div>
  </section>
  <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
	<script type="text/javascript">
    function setJcodeNum() {
      let dom = document.getElementById('j_code-j_num'), j_code = document.getElementById('j_code'), j_num = document.getElementById('j_num');
      if(checkFields([dom, j_code, j_num])) { if(dom.value != "") {
        let newvalue = (dom.value).split('_');
        if(newvalue.length > 1) {
          j_code.value = newvalue[0]; j_num.value = newvalue[1];
        }
      } }
    }
    function submitForm() {
      let idIns = ['payee', 'j_code', 'j_num', 'chk_no', 'chk_bank', 'chk_date'], insName = [], doms = [], domIns = [['_token'], [$('meta[name="csrf-token"]').attr('content')]];
      insErrMsg('warning', 'Sending request', 'dbsErr');
      idIns.forEach(function(a, b, c) { let d = document.getElementById(a); if(checkFields([d])) { domIns[0].push(a); domIns[1].push(d.value); } });
      insName.forEach(function(a, b, c) { let d = document.getElementsByName(a); for(let i = 0; i < d.length; i++) { if(checkFields([d[i]])) { if(d == 'obr_code[]') {if(d[i].checked) { domIns[0].push(a); domIns[1].push(d[i].value); } } else { domIns[0].push(a); domIns[1].push(d[i].value); } } } });
      insDataFunction(domIns, "{{ asset('accounting/request/insCheck') }}", "POST", {
        functionProcess: function(arr) {
          if(arr == true) {
            window.location.href = "{{ asset('accounting/disbursement/check_issuance') }}";
          } else {
            insErrMsg('danger', arr[arr.length - 1], 'dbsErr');
          }
        }
      });
    }
  </script>
@endsection