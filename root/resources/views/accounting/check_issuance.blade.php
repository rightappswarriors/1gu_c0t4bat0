@extends('_main')
@section('content')
	@include('layout._contentheader')
  <style type="text/css">
    @media print {
      #hideSection, footer {
        display: none;
      }
      #issuancePrint {
        display: block !important;
      }
    }
  </style>
  <section id="hideSection" class="content">
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
          @if(! isset($isrelease)) <div class="col-md-2">
            <div class="form-group">
              <center><label>&nbsp;</label></center>
              <a href="{{ asset('accounting/disbursement/check_issuance/new') }}"><button type="button" class="btn btn-block btn-primary"><i class="fa fa-plus"></i> New Issuance Entry</button></a>
            </div>
          </div> @endif
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
            <h3 class="box-title">Check Issuance Record</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div id="errMsg"></div>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th width="10%">Ref. #</th>
                <th>Payee</th>
                <th>Check No.</th>
                <th>Bank Name</th>
                <th>Issuance Date</th>
                <th width="10%">Options</th>
              </tr>
              </thead>
              <tbody>
                @if(count($tr01_check) > 0) @foreach($tr01_check AS $tr01_checkEach)
                <tr class="@if($tr01_checkEach->canceled == true) text-danger @endif">
                  <td>{{$tr01_checkEach->j_code}}-{{$tr01_checkEach->j_num}}</td>
                  <td>{{$tr01_checkEach->payee}}</td>
                  <td>{{$tr01_checkEach->chk_no}}</td>
                  <td>{{$tr01_checkEach->chk_bank}}</td>
                  <td>{{$tr01_checkEach->t_date}}</td>
                  <td>
                    <?php $tColor = (($tr01_checkEach->isprinted == true) ? "success" : "warning"); ?>
                    @if(! isset($isrelease)) <button class="btn btn-{{$tColor}}" onclick="setChkNo('{{$tr01_checkEach->chk_no}}'); upPrinting()"><i class="fa fa-print"></i></button> @endif
                    @if(isset($isrelease)) @if(! isset($tr01_checkEach->r_date))
                    <button class="btn btn-info" onclick="setChkNo('{{$tr01_checkEach->chk_no}}');" data-toggle="modal" data-target="#addObr"><i class="fa fa-list-alt"></i></button> @endif @endif
                  </td>
                </tr>
                @endforeach @endif
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
  <div class="modal fade in" id="addObr">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h3 class="modal-title">Check Release</h3>
        </div>
        <div class="modal-body">
          <p>Received by</p>
          <input type="text" class="form-control" id="receivedby" placeholder="Received by">
          <p>ID</p>
          <input type="text" class="form-control" id="id" placeholder="ID">
          <p>Contact</p>
          <input type="text" class="form-control" id="contact" placeholder="Contact">
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" onclick="submitForm();"><i class="fa fa-paper-plane"></i> Submit form</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="box" id="issuancePrint" style="display: none;">
    <div class="box-header with-border"><h3 class="box-title">Check</h3></div>
    <div class="box-body">
          <p>Disbursement Link: <strong><u><span id="jcodejnum"></span></u></strong> <span style="float: right;">Date: <strong><span id="dispTDate"></span></strong></span></p>
          <br>
          <p>Payee: <strong><span id="dispPayee"></span></strong></p>
          <p>Check No: <strong><span id="dispCheckno"></span></strong></p>
          <p>Bank Name: <strong><span id="dispBank"></span></strong></p>
    </div>
    <div class="box-footer"></div>
  </div>
  <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
	<script type="text/javascript">
    var chk_no = "", receivedby = document.getElementById('receivedby'), id = document.getElementById('id'), contact = document.getElementById('contact');
    function setChkNo(chkNo) {
      chk_no = chkNo;
      if(checkFields([receivedby, id, contact])) {
        receivedby.value = "";
        id.value = "";
        contact.value = "";
      }
    }
    function procFunc(insDthis, insDthisName) {
      let idIns = insDthis, insName = insDthisName, doms = [], domIns = [['_token', 'chk_no'], [$('meta[name="csrf-token"]').attr('content'), chk_no]];
      insErrMsg('warning', 'Sending request', 'dbsErr');
      idIns.forEach(function(a, b, c) { let d = document.getElementById(a); if(checkFields([d])) { domIns[0].push(a); domIns[1].push(d.value); } });
      insName.forEach(function(a, b, c) { let d = document.getElementsByName(a); for(let i = 0; i < d.length; i++) { if(checkFields([d[i]])) { if(d == 'obr_code[]') {if(d[i].checked) { domIns[0].push(a); domIns[1].push(d[i].value); } } else { domIns[0].push(a); domIns[1].push(d[i].value); } } } });
      return domIns;
    }
    function submitForm() {
      let domIns = procFunc(['officer', 'receivedby', 'id', 'contact'], []);
      insDataFunction(domIns, "{{ asset('accounting/request/upChk') }}", "POST", {
        functionProcess: function(arr) {
          chk_no = "";
          if(arr == true) {
            window.location.href = "{{ asset('accounting/disbursement/check_release') }}";
          } else {
            insErrMsg('danger', arr[arr.length - 1], 'dbsErr');
          }
        }
      });
    }
    function upPrinting() {
      let domIns = procFunc([], []);
      insDataFunction(domIns, "{{ asset('accounting/request/upPrinting') }}", "POST", {
        functionProcess: function(arr) {
          console.log(arr);
          if(arr.length > 0) {
            let jcodejnum = document.getElementById('jcodejnum'), dispTDate = document.getElementById('dispTDate'), dispPayee = document.getElementById('dispPayee'), dispCheckno = document.getElementById('dispCheckno'), dispBank = document.getElementById('dispBank');
            if(checkFields([jcodejnum, dispTDate, dispPayee, dispCheckno, dispBank])) {
              jcodejnum.innerHTML = arr[0].j_code+'-'+arr[0].j_num;
              dispTDate.innerHTML = arr[0].t_date;
              dispPayee.innerHTML = arr[0].payee;
              dispCheckno.innerHTML = arr[0].chk_no;
              dispBank.innerHTML = arr[0].chk_bank;
              window.print();
            }
          } else {
            insErrMsg('danger', arr[arr.length - 1], 'dbsErr');
          }
        }
      });
    }
  </script>
@endsection