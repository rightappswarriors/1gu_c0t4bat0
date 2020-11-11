@php
 $_bc = [
        ['link'=>'#','desc'=>'Accounting','icon'=>'none','st'=>false],
        ['link'=>url("accounting/disburse/entry"),'desc'=>'Disbursement Entry','icon'=>'none','st'=>true]
  ];
  $_ch = "Disbursement Info"; // Module Name
@endphp
@extends('_main')

@section('content')
    <!-- Content Header (Page header) -->
    @include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
      <form id="HeaderForm" data-parsley-validate>
        {{csrf_field()}}
        <input type="hidden" name="action" value="{{isset($action) ? $action : 'add'}}">
        {{-- <input type="hidden" name="fy" value="{{($periodE ?? $data[0]->fy)}}"> --}}
        {{-- <input type="hidden" name="mo" value="{{isset($period[1][0]) ? $period[1][0]->month_desc: $data[0]->mo}}"> --}}
        <input type="hidden" name="j_code" value="{{isset($j_code) ? $j_code : null}}">
       {{--  <input type="hidden" name="branch" value="{{($branchE ?? $data[0]->branch)}}"> --}}
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Disbursement Entry</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> --}}
          </div>
        </div>
        <!-- /.box-header -->
        
        <div class="box-body" style="">

<div class="row">
  <div class="col-sm-6 mb-5 mb-md-0">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title text-center" style="font-size: 20px; margin-bottom: 10px;">Disbursement Info</h5>
        {{csrf_field()}}
            <div class="col-sm-6">
              <div class="form-group">
                <label>Type  </label>
                <input type="text" disabled class="form-control" value="{{isset($journal[1][0]) ? $journal[1][0]->j_desc : Date('F',strtotime($data[0]->mo))}}">
              </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                  <label class="required"> Date</label>
                     <input type="date" required style="margin-bottom: 1%;" name="t_date" class="form-control" placeholder="Ref. No." value="{{date('Y-m-d')}}">
                      </div>
                        </div>
      </div>
    <div class="card-body">
        <div class="col-sm-6">
              <div class="form-group">
                <label>Description  </label>
                  <input type="text" class="form-control" name="t_desc" > 
                    </div>
                      </div>
        <div class="col-sm-5">
            <div class="form-group">
              <label class="required">BRANCH  </label>
                <select required class="form-control" style="width: 100%;" name="branch">
                       <option value hidden selected disabled>Please select</option>
                @isset($branch) @foreach($branch AS $each)
                <option value="{{$each->code}}">{{$each->code.' - '. $each->name}}</option>
                @endforeach @endisset
                      </select>
                        </div>
                          </div>
      </div>
      <div class="card-body">
        <div class="col-sm-11">
              <div class="form-group">
                <label>Explanation</label>
                  <textarea type="text" rows="4" class="form-control" name="j_memo"> </textarea>
                          </div>
                            </div>
      </div>

    </div>
  </div>

  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title text-center" style="font-size: 20px; margin-bottom: 10px;">Payments</h5>
          <div class="col-sm-6">
            <div class="form-group">
              <label class="required">Payment Thru </label>
                <select required class="form-control" name="at_code" style="width: 100%;">
                  <option value hidden selected disabled>Please select</option>
                      @isset($m04) @foreach($m04 AS $each)
                        <option cib="{{$each->cib_acct}}" value="{{$each->at_code}}">{{$each->at_code}} - {{$each->at_desc}}</option>
                        @endforeach @endisset
                          </select>
                            </div>
                              </div>
        
        <div class="col-sm-6">
          <div class="form-group">
            <label class="required">Payment Amount</label>
              <input type="text" required class="form-control" name="payAmount" value="0.00">
                </div>
                  </div>

         
      </div>
      <div class="card-body">
        <div class="col-sm-6">
              <div class="form-group">
                <label>Check No  </label>
                  <input disabled type="text" class="form-control" name="ck_num"> 
                    </div>
                      </div>
        

        <div class="col-sm-6">
              <div class="form-group">
                <label>Check Date </label>
                  <input disabled type="date" style="margin-bottom: 1%;" name="ck_date" class="form-control" placeholder="Ref. No." value="{{date('Y-m-d')}}">
                    </div>
                      </div>
        <div class="col-sm-12">
              <div class="form-group">
                <label class="required">Paid To  </label>
                  <select required class="form-control" style="width: 100%;" name="payee">
                    <option value hidden selected disabled>Please Select</option>
                      @isset($payee) @foreach($payee AS $each)
                <option value="{{$each->payee}}">{{$each->payee}}</option>
                @endforeach @endisset
                      </select>
                    </div>
                      </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label>Total DISBURSED</label>
              <input type="text" class="form-control" id="total" placeholder="0.00" name="totaldisburse" disabled=""> 
          </div>
        </div> 



        <div class="col-sm-4">
          <div class="form-group">
            <label>LESS : <i>PAYMENT</i>  </label>
              <input type="text" class="form-control" placeholder="0.00" name="lesspay" disabled=""> 
          </div>
        </div>



        <div class="col-sm-4">
          <div class="form-group">
            <label>BALANCE</label>
              <input type="text" class="form-control" placeholder="0.00" name="balance" disabled=""> 
          </div>
        </div>
        
      </div>

    </div>
  </div>

</div>

        </div>

      
    

        <!-- /.box-body -->
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="row">
                <div class="col-sm-6">
                  <h3 class="box-title">Journal Entry Details</h3>
                    <button data-backdrop="static" onclick="processIncrement();" type="button" class="btn btn-primary" data-toggle="modal" data-target="#addItem"><i class="fa fa-plus"></i> Add item</button>
                </div>
              </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="lineTable" class="table table-bordered table-striped">
                  <thead>
                      <tr>
                          <th nowrap>LINE</th>
                          <th nowrap>ACCOUNT TITLE</th>
                          <th nowrap>SUBSIDIARY</th>
                          <th nowrap>COST CENTER</th>
                          <th nowrap>SUB COST CENTER</th>
                          <th nowrap>AMOUNT</th>
                          <th nowrap>INVOICE</th>
                          <th nowrap>NOTES</th>
                          <th nowrap><center>OPTION</center></th>
                      </tr>
                  </thead>
                  <tbody>                  

                  </tbody>
                   <tfoot>
                      <tr>
                          <th>LINE</th>
                          <th>ACCOUNT TITLE</th>
                          <th>SUBSIDIARY</th>
                          <th>COST CENTER</th>
                          <th>SUB COST CENTER</th>
                          <th>AMOUNT</th>
                          <th>INVOICE</th>
                          <th>NOTES</th>
                          <th><center>OPTION</center></th>
                      </tr>
                  </tfoot> 
              </table>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          {{-- <div class="row">
            <div class=" col-sm-2" style="float:right;">
              Total Credit <span id="creditTotal" style="font-weight: bold;">0.00</span>
            </div>
            <div class="col-sm-2" style="float:right;">
              Total Debit <span id="debitTotal" style="font-weight: bold;">0.00</span>
            </div>
            <div class="col-sm-offset-1 col-sm-2" style="float:right;">
              Balance <span id="balanceTotal" style="font-weight: bold;">0.00</span>
            </div>
          </div> --}}
          <div class="box-footer row">
            <div class="col-sm-3 box-tools pull-right">
              <div class="form-group" style="display: flex;">
                <a href="{{url('accounting/disburse/entry')}}" class="btn btn-block btn-primary"><i class="fa fa-arrow-left"></i> Go Back</a>
              </div>
            </div>
            <div class="col-sm-3 box-tools pull-right">
              <div class="form-group" style="display: flex;">

                <button href="{{url('accounting/disburse/entries@save')}}" type="submit" class="btn btn-block btn-success" style="margin-top: 0;"><i class="fa fa-save"></i> Save</button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      </form>
    </section>
    <!-- /.content -->

    {{-- modal area --}}
     <div id="deleteItem" class="modal fade">
        <div class="modal-dialog modal-sm-4 ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Delete Disbursement Line</h4>
                </div>
                <div class="modal-body">
                   <div class="row">
                    <div class="container">
                        <p>Are you sure?</p>
                        </div>                       
                     <div class="col-md-12">
                        <div class="col-md-6">
                          <button type="button" class="btn btn-block btn-danger" style="margin-top: 0;" data-dismiss="modal"><i class="fa fa-trash"></i> Delete List</button>
                        </div>
                        <div class="col-md-6">
                          <button type="button" class="btn btn-block btn-default savelne" data-dismiss="modal"  href="{{ url('accounting/soa/entry/save') }}"><i class="fa fa-arrow-left"></i> Cancel</button>
                        </div>
                     </div>
                     {{-- </div> --}}
                   </div>
                </div>
            </div>
        </div>
      </div> 
    {{-- modal area --}}

    <div id="addItem" class="modal fade">
        <div class="modal-dialog modal-sm-4 ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">New Disbursement Entry</h4>
                </div>
                <div class="modal-body">
                   <div class="row">
                     {{-- <div class="container"> --}}
                      <div class="container">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label>LINE</label>
                  <input type="text" class="form-control" name="seq_num" id="seq_num"  value="1" disabled=""> 
                    </div>
                      </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label>Code  </label>
                <input type="text" disabled name="at_codeDis" class="form-control">
                   </div>
                      </div>     
          </div>
          </div>
          <div class="container">
          <div class="row">
            <div class="col-sm-3">
            <div class="form-group">
              <label class="required">Accounting Title</label>
                <select name="at_codeLine" onchange="document.getElementsByName('at_codeDis')[0].value = this.value" style="width: 100%;" class="form-control">
                  <option value hidden selected disabled>Please Select</option>
                      @isset($m04) @foreach($m04 AS $each)
                <option value="{{$each->at_code}}">{{$each->at_desc}}</option>
                @endforeach @endisset
                      </select>
                        </div>
                          </div>
            <div class="col-sm-3">
            <div class="form-group">
              <label class="required">Subsdiary Name</label>
                <select class="form-control" name="sl_code" style="width: 100%;">
                      <option value hidden selected disabled>Please select</option>
                      @isset($m06) @foreach($m06 AS $each)
                <option value="{{$each->d_code}}">{{$each->d_name}}</option>
                @endforeach @endisset
                      </select>
                        </div>
                          </div>
          </div>
          </div>
          <div class="container">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label class="required">Invoice Number</label>
                  <input type="text" class="form-control" name="invoice"> 
                    </div>
                      </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="required">Amount</label>
                  <input type="text" value="0.00" class="form-control" name="amount"> 
                    </div>
                      </div>
          </div>
          </div>
          <div class="container">
          <div class="row">
            <div class="col-sm-3">
            <div class="form-group">
              <label class="required">Cost Center</label>
                <select class="form-control" style="width: 100%;" name="cc_code">
                      <option value hidden selected disabled>Please select</option>
                      @isset($m08) @foreach($m08 AS $each)
                <option value="{{$each->cc_code}}">{{$each->cc_desc}}</option>
                @endforeach @endisset
                      </select>
                        </div>
                          </div>
            <div class="col-sm-3">
            <div class="form-group">
              <label class="required">Sub Cost Center</label>
                <select class="form-control" style="width: 100%;" name="scc_code">
                      <option value hidden selected disabled>Please select</option>
                      @isset($subctr) @foreach($subctr AS $each)
                <option value="{{$each->scc_code}}">{{$each->scc_desc}}</option>
                @endforeach @endisset
                      </select>
                        </div>
                          </div> 
          </div>
          </div>

          <div class="container">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Note</label>
                    <textarea type="text" class="form-control" name="seq_desc"> </textarea>
                </div>
              </div>
            </div>
          </div>
                     <div class="col-md-12">                        
                        <div class="col-md-6">
                          <button type="button" class="btn btn-block btn-success savelne" data-dismiss="modal"  href="{{ url('accounting/soa/entry/save') }}"><i class="fa fa-save"></i> Save and Close</button>
                        </div>
                        <div class="col-md-6">
                          <button type="button" class="btn btn-block btn-primary" style="margin-top: 0;" data-dismiss="modal"><i class="fa fa-arrow-left"></i>Go Back</button>
                        </div>
                     </div>
                     {{-- </div> --}}
                   </div>
                </div>
            </div>
        </div>
      </div> 

      <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
      <script>
        var increment = 0;
        var balance = 0;
        var lineArray = [['at_codeLine[]','at_codeLine',['at_codeLineSpan[]',true]],['sl_code[]','sl_code',['sl_codeSpan[]',true]],['invoice[]','invoice',['invoiceSpan[]',false]],['amount[]','amount',['amountSpan[]',false]],['cc_code[]','cc_code',['cc_codeSpan[]',true]],['scc_code[]','scc_code',['scc_codeSpan[]',true]],['seq_desc[]','seq_desc',['seq_descSpan[]',false]]];

        function EditMode(whichElement,action){
          let childsToSelect = lineArray;
          switch (action) {
            case 'process':
              let parentOfCheckedDOM = $(whichElement).parent().parent();
              $('#seq_num').val(Number($(parentOfCheckedDOM).find('[name="lineno[]"]').text()));
              childsToSelect.forEach(function(el,key){
                if($('[name="'+el[1]+'"]').length){
                  $('[name="'+el[1]+'"]').val($(parentOfCheckedDOM).find('[name="'+el[0]+'"]').val()).trigger('change').trigger('keyup');
                }
              })
              getTotalOfAmounts();
            break;

            case 'edit':
              parentOfEditedElement = $('#seq_num').val();
              childsToSelect.forEach(function(el,key){
                if($('[name="'+el[1]+'"]').length){
                  $("#"+parentOfEditedElement).parent().parent().find('[name="'+el[0]+'"]').val($('[name="'+el[1]+'"]').val()).trigger('change').trigger('keyup');
                  $("#"+parentOfEditedElement).parent().parent().find('[name="'+el[2][0]+'"]').html( (el[2][1] === true ? $('[name="'+el[1]+'"]').find(':selected').text() : $('[name="'+el[1]+'"]').val() ) );

                  $('[name="'+el[1]+'"]').val('').trigger('change');
                }
              })
              getTotalOfAmounts();
            break;
            default:
              // statements_def
              break;
          }
        }

        function addItem()
        {
          increment++;
          var table = $('#lineTable').DataTable();
          table.row.add([
              '<div id="'+increment+'" name="lineno[]" class="inc">'+increment+'</div>',
              '<span name="at_codeLineSpan[]"></span><select readonly name="at_codeLine[]" style="width: 100%; display: none;" class="form-control">'+
                 ' <option value hidden selected disabled >Please Select</option>'+
                  @isset($m04) @foreach($m04 AS $each)
                  '<option value="{{$each->at_code}}">{{$each->at_desc}}</option>'+
                  @endforeach @endisset
              '</select>',
              '<span name="sl_codeSpan[]"></span><select readonly class="form-control" name="sl_code[]" style="width: 100%; display: none;">'+
              '<option value hidden selected disabled>Please Select</option>'+
                @isset($m06) @foreach($m06 AS $each)
                '<option value="{{$each->d_code}}">{{$each->d_name}}</option>'+
                @endforeach @endisset
              '</select>',
              '<span name="cc_codeSpan[]"></span><select readonly class="form-control" style="width: 100%; display: none;" name="cc_code[]">'+
                '<option value="">Please select</option>'+
                @isset($m08) @foreach($m08 AS $each)
                '<option value="{{$each->cc_code}}">{{$each->cc_desc}}</option>'+
                @endforeach @endisset
              '</select>',
              '<span name="scc_codeSpan[]"></span><select readonly class="form-control" style="width: 100%; display: none;" name="scc_code[]">'+
              '<option value="">Please select</option>'+
                @isset($subctr) @foreach($subctr AS $each)
              '<option value="{{$each->scc_code}}">{{$each->scc_desc}}</option>'+
                @endforeach @endisset
              '</select>',
              '<span name="amountSpan[]"></span><input readonly type="text" value="0.00" class="form-control" name="amount[]" style="display: none;">',
              '<span name="invoiceSpan[]"></span><input readonly type="text" class="form-control" name="invoice[]" style="display: none;">',
              '<span name="seq_descSpan[]"></span><textarea rows="1" readonly type="text" class="form-control" name="seq_desc[]" style="display: none;"></textarea>',
              '<a data-toggle="modal" data-target="#addItem" title="Edit this entry" class="btn btn-social-icon btn-warning" onclick="EditMode(this,\'process\');">&nbsp;<i class="fa fa-edit "></i></a>&nbsp;'+
              '<a title="Delete this entry" class="btn btn-social-icon btn-danger" onclick="DeleteMode(this);"><i class="fa fa-trash "></i></a>'
          ]).draw();
          setTimeout(function() {
            getTotalOfAmounts();
          }, 100);
        }
        
        $(document).ready(function(){
          $("#lineTable").DataTable();
        })

        $('body').on('keyup blur', 'input[name=payAmount], input[name=lesspay], [name=amount]', function(event) {
          formatCurrency($(this));
          getTotalOfAmounts();
        })

        $("[name=payAmount]").on('keyup keydown', function(event) {
          $("[name=lesspay]").val(this.value).trigger('keyup');
        })

        $('[name=at_code]').change(function(event) {
          let toggleDisable = ['ck_num','ck_date'];
            toggleDisable.forEach(function(el,key){
              if($('[name=at_code]').find('option:selected').attr('cib') == 'Y'){
                $('[name='+el+']').removeAttr('disabled');
              } else {
                $('[name='+el+']').attr('disabled',true);
              }
            })
        });

        function processIncrement(){
          if( $('div#'+Number($("#seq_num").val()) ).length){
            $("#seq_num").val(increment+1);
          }
        }

        function getTotalOfAmounts(){
          document.getElementById('total').value = Number(iterateOnObjectReturnTotal(document.getElementsByName('amount[]'))).toLocaleString();
          document.getElementsByName('balance')[0].value = Number(iterateOnObjectReturnTotal(document.getElementsByName('totaldisburse')) - iterateOnObjectReturnTotal(document.getElementsByName('lesspay'))).toLocaleString();
        }

        function iterateOnObjectReturnTotal(node){
          let total = 0.00;
          node.forEach(function(el,key){
             total += parseInt($(el).val().replace(/\,/g,''));
          })
          return total;
        }


        $(".savelne").click(function(){
          getTotalOfAmounts();
          if( $('div#'+Number($("#seq_num").val()) ).length){
            EditMode(this,'edit');
          } else {

            let tableForLne = $("#lineTable").DataTable();
            let getValueOfDom = lineArray;
            addItem();
            let currentTableDom = $('#'+increment).parent().parent();
            
            getValueOfDom.forEach(function(el,key){
              if($(currentTableDom).find('[name="'+el[1]+'[]"]').length){
                $(currentTableDom).find('[name="'+el[1]+'[]"]').val($('[name='+el[1]+']').val()).trigger('change');
                $(currentTableDom).find('[name="'+el[2][0]+'"]').html( (el[2][1] === true ? $('[name="'+el[1]+'"]').find(':selected').text() : $('[name="'+el[1]+'"]').val() ) );
              }
            })
            $("#seq_num").val(increment+1);
          }
        })

        function DeleteMode(whichElement){
         let alertToDelete = window.confirm('Remove this Entry?');
          if(alertToDelete){
           var myTable = $('#lineTable').DataTable();
           myTable
             .row( $(whichElement).parents('tr') )
             .remove()
             .draw();
             getTotalOfAmounts();
          }
        }

        $("#HeaderForm").submit(function(event) {
          event.preventDefault();
          if($(this).parsley().isValid()){
            let data = $(this).serialize();
            $.ajax({
              url: '{{url('accounting/disburse/entry/save/'.(isset($j_code) && isset ($j_num) ? $j_code .'/'.$j_num : ''))}}',
              method: 'POST',
              data: data,
              success: function(a){
                if(a == 'success'){
                  alert('Succesfully Completed Operation');
                  window.location.href="{{url('accounting/disburse/entry')}}";
                } else {
                  alert(a);
                }
              }
            })
          } else {
            alert ('Please Check all fields for required inputs');
          }
        });

         @if(isset($action) && strtolower($action) == 'edit')
            $(document).ready(function(){
              let headerData = JSON.parse('{!! json_encode($data[0]) !!}');
              let lineData = JSON.parse('{!! json_encode($data[1]) !!}');
              let exessData = JSON.parse('{!! json_encode($data[2]) !!}');
              // array 0 - dom array 1 - field name
              let domForHeader = [['t_date','t_date'],['t_desc','t_desc'],['branch','branch'],['j_memo','j_memo'],['at_code','paythru'],['ck_num','ck_num'],['ck_date','ck_date'],['payee','payee']];

              domForHeader.forEach(function(el,key){
                if(document.getElementsByName(el[0]).length){
                  document.getElementsByName(el[0])[0].value = headerData[el[1]];
                  document.getElementsByName(el[0])[0].dispatchEvent(new Event('change'));
                }
              })
              $('[name=payAmount]').val(Number(exessData['credit'])).trigger('change').trigger('keyup');

              let currentTableDom;
              let getValueOfDom = lineArray;
              increment = 0;
              for (var i=0; i < lineData.length; i++) {
                addItem();
                currentTableDom = $('#'+increment).parent().parent();
                getValueOfDom.forEach(function(el,key){
                  $(currentTableDom).find('[name="'+el[0]+'[]"]').val(lineData[i][el[1]]).trigger('change').trigger('keyup');
                })
                $(currentTableDom).find('[name="amount[]"]').val((Number(lineData[i]['debit']) > 0) ? Number(lineData[i]['debit']) : Number(lineData[i]['credit'])).trigger('change').trigger('keyup');
                EditMode(currentTableDom.find('td a:eq(0)')[0],'process');
                $('.savelne:eq(0)')[0].click();
                $("#seq_num").text(increment+1);
                getTotalOfAmounts();
              }
            })
            
          @endif

      </script>
  
@endsection