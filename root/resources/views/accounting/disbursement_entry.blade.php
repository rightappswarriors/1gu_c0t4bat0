@php
 $_bc = [
        ['link'=>'#','desc'=>'Accounting','icon'=>'none','st'=>false],
        ['link'=>url("accounting/disburse/entry"),'desc'=>'Disbursement Entry','icon'=>'none','st'=>true]
  ];
  $_ch = "Disbursement Entry"; // Module Name
@endphp
@extends('_main')
@section('content')
  @include('layout._contentheader')
  <section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Disbursement Entry <br>
        {{-- <a class="btn btn-block btn-primary" id="journalEntryButton" disabled><i class="fa fa-plus"></i> New Disbursement Entry</a> --}}
      </h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> --}}
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body" style="">
        <form id="HeaderForm" data-parsley-validate novalidate>
          <div class="box-body" style="">
              <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="required">From  </label>
                 <input type="date" style="margin-bottom: 1%;" name="d_datet" id="d_datef" class="form-control" placeholder="Ref. No." value="{{date('Y-m-01')}}">
                    </div>
                      </div>
                      <div class="col-sm-4">
              <div class="form-group">
                <label class="required">To  </label>
                  <input type="date" style="margin-bottom: 1%;" name="d_datef" id="d_datet" class="form-control" placeholder="Ref. No." value="{{date('Y-m-d')}}">
                    </div>
                      </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="required">Type  </label>
                  <select class="form-control select2 select2-hidden-accessible" onchange="processJournalButton()" id="journal" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <option value hidden selected disabled>Please select</option>
                  @isset($journal) @foreach($journal AS $each)
                  <option value="{{$each->j_code}}">{{$each->j_desc}}</option>
                  @endforeach @endisset
                  </select>
                    </div>
                      </div>
              </div>
          </div>

      <div class="col-md-2">
            <div class="form-group">
              <center><label>&nbsp;</label></center>
              <a class="btn btn-block btn-primary" id="journalEntryButton" disabled><i class="fa fa-plus"></i> New Disbursement Entry</a>
            </div>
          </div>
          {{-- <div class="col-md-2">
            <div class="form-group">
              <center><label>&nbsp;</label></center>
              <button type="button" class="btn btn-block btn-info"><i class="fa fa-print"></i> Print</button>
            </div>
          </div>
 --}}
      </form>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
    </div>

    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="row">
                <div class="col-sm-6">
                  <h3 class="box-title">Disbursement List</h3>
                </div>
              </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="myTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th nowrap>CODE</th>
                  <th nowrap>DISBURSEMENT DESC.</th>
                  <th nowrap>DATE OF TRANSACTION</th>                     
                  <th nowrap>PAID</th>
                  <th nowrap>BRANCH</th>        
                  <th nowrap><center>Option</center></th>
                </tr>
                </thead>
                <tbody>
                   @isset($entryData)
                    @foreach($entryData as $data)
                    <tr>
                      <td>{{$data->j_code}}</td>
                      <td>{{$data->t_desc}}</td>
                      <td>{{$data->t_date}}</td>
                      <td>{{$data->payee}}</td>
                      <td>{{$data->name}}</td>
                      <td nowrap>
                        <center>
                          <a href="{{ url('accounting/disburse/entry/edit/'.$data->j_code.'/'.$data->j_num) }}" class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" ></i></a>
                          &nbsp;
                          <a onclick="$('[name=j_num]').val('{{$data->j_num}}'); $('[name=j_code]').val('{{$data->j_code}}');" class="btn btn-social-icon btn-danger" type="button" class="btn btn-primary" data-toggle="modal" data-target="#cancelTransaction" ><i class="fa fa-trash"></i></a>
                        </center>
                      </td>
                    </tr>
                    @endforeach
                   @endisset
                </tbody>
                <tfoot>
                <tr>
                  <th nowrap>CODE</th>
                  <th nowrap>DISBURSEMENT DESC.</th>
                  <th nowrap>DATE OF TRANSACTION</th>                     
                  <th nowrap>PAID</th>
                  <th nowrap>BRANCH</th>        
                  <th nowrap><center>Option</center></th>
                </tr>
                </tfoot>
              </table>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


   

    {{-- modal area --}}
    <div class="modal" id="cancelTransaction">
      <div class="modal-dialog">
        <form action="{{url('accounting/disburse/entry/cancel')}}" method="POST">
          {{csrf_field()}}
          <input type="hidden" name="j_num">
          <input type="hidden" name="j_code">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
              <h3 class="modal-title">CANCEL (Disbursement) <span id="MOD_MODE"></span></h3>
            </div>
            <div class="modal-body">
              <center>
                  <h4 class="text-transform: uppercase;">Are you sure you want to cancel this entry
                  from Account Journal?
                  </h4>
              </center>
            </div>
            
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger"><i class="fa fa-ban"></i> Cancel Transaction</button>
                <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-times"></i> Back</button>
            </div>
            
          </div>  
        </form>
      </div>
    </div>

    <!-- Modal -->
  <div class="modal fade" id="myPrint" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Print</h4>
        </div>
        <div class="modal-body">
          <div class="container">
          <div class="row">
            <div class="col-sm-3">
            <div class="form-group">
              <label>Select Print Forma </label>
                <select  style="width: 90%;" class="form-control">
                    <option >Please Select</option>
                    <option>Voucher & Check</option>
                    <option>Voucher Only</option>
                    <option>Check Only</option>
                      </select>
                        </div>
                          </div>
          </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-print"></i>  Print</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  </section>
  <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
  <script>
    function processJournalButton(){
      let journalButton = $('#journalEntryButton');
      if($.trim(document.getElementById('journal').value) != ""){
        $(journalButton).attr('href','{{'entry/entries/'}}'+ $.trim(document.getElementById('journal').value)).removeAttr('disabled');
      } else {
        $(journalButton).removeAttr('href').attr('disabled',true);
      }
    }

    $(document).ready( function () {
    $('#myTable').DataTable();
} );
  </script>
 

@endsection