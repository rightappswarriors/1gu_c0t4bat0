@extends('_main')
@section('content')
	@include('layout._contentheader')
  <section class="content">
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
          <div class="col-md-7">
            <div class="form-group">
              <label>Disbursement Type</label>
              <select class="form-control select2 select2-hidden-accessible" id="jname" onchange="loadRecord();" style="width: 100%;" tabindex="-1" aria-hidden="true">
                <option value hidden selected disabled>Please select</option>
                @isset($disbType) @foreach($disbType AS $each)
                <option value="{{$each->j_code}}" {{ $each->j_code == 'CV' ? 'selected' : '' }}>{{$each->j_desc}}</option>
                @endforeach @endisset
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <center><label>&nbsp;</label></center>
              <button type="button" class="btn btn-block btn-primary" onclick="openNewDE();"><i class="fa fa-plus"></i> New Disbursement Entry</button>
            </div>
          </div>
          <div class="col-md-2">
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
            <h3 class="box-title">Disbursement Record</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <div id="errMsg"></div>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th width="10%">Ref. #</th>
                <th>Description</th>
                <th>Date</th>
                <th>Mode of Payment</th>
                <th>Amount</th>
                <th>Paid to</th>
                <th>User</th>
                <th width="10%">Options</th>
              </tr>
              </thead>
              <tbody>
             {{-- \ --}}
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
  <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
	<script type="text/javascript">

    $(() => {
      loadRecord();
    });

    function loadRecord() {
      let example1 = $('#example1').DataTable();
      let    = document.getElementById('jname');
      if(checkFields([jname])) {
        insDataFunction([['_token', 'jname'], [$('meta[name="csrf-token"]').attr('content'), jname.value]], "{{ asset('accounting/request/getDisbursementRecords') }}", "POST", {
          functionProcess: function(arr) {
            if(Array.isArray(arr)) {
              example1.clear().draw();
              if(arr.length > 0) {
                arr.forEach(function(a, b, c) {
                  let dispButton = ((a.fundavailable != null) ? ((a.isreviewed != null) ? '' : '<button class="btn btn-info" onclick="isreviewed(\''+a.j_code+'\', \''+a.j_num+'\');"><i class="fa fa-file-text-o"></i></button>') : '<button class="btn btn-warning" onclick="fundavailable(\''+a.j_code+'\', \''+a.j_num+'\');"><i class="fa fa-file-text"></i></button>');
                  example1.row.add([
                    a.j_code + '-' + a.j_num,
                    a.t_desc,
                    a.t_date,
                    a.at_desc,
                    a.credit,
                    a.payee,
                    a.user_id,
                    '<a href="{{ asset('accounting/disbursement') }}/edit/'+a.j_code+'/'+a.j_num+'"><button class="btn btn-warning"><i class="fa fa-edit"></i></button></a> ' + dispButton
                  ]).draw();
                });
              }
            } else {
              insErrMsg('danger', arr, 'errMsg');
            }
          }
        });
      }
    }
    function fundavailable(j_code, j_num) {
      let tPrompt = confirm("Change fund availability status to: 'Yes'?");
      if(tPrompt) {
        insDataFunction([['_token', 'j_code', 'j_num', 'fundavailable'], [$('meta[name="csrf-token"]').attr('content'), j_code, j_num, true]], "{{ asset('accounting/request/fundavailable') }}", "POST", {
          functionProcess: function(arr) {
            console.log(arr);
            loadRecord();
          }
        });
      }
    }
    function isreviewed(j_code, j_num) {
      let tPrompt = confirm("Change reviewed status to: 'Yes'?");
      if(tPrompt) {
        insDataFunction([['_token', 'j_code', 'j_num', 'isreviewed'], [$('meta[name="csrf-token"]').attr('content'), j_code, j_num, true]], "{{ asset('accounting/request/isreviewed') }}", "POST", {
          functionProcess: function(arr) {
            console.log(arr);
            loadRecord();
          }
        });
      }
    }
    function openNewDE() {
      let jname = document.getElementById('jname');
      if(checkFields([jname])) { if(jname.value != "") {
        window.location.href = "{{ asset('accounting/disbursement/disbursement_new') }}/" + jname.value;
      } else { alert('Please select Disbursement type.'); } }
    }
  </script>
@endsection