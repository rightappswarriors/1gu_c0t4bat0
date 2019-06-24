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
          <h3 class="box-title">Filter Data</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> --}}
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <button class="btn btn-primary" onclick="window.location.href = '{{ asset('budget/lbp') }}/{{$form_no}}/new';">New Entry</button>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Local Budget Preparations #{{$form_no}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr id="tHead"></tr>
                </thead>
                <tbody id="tBody">
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
  <script type="text/javascript">
    var appDet = JSON.parse('{!!addslashes(json_encode($appDet))!!}'), form_no = "{{$form_no}}",
    form_cols = {
      '8': [
        ['Fiscal Year', 'Fund', 'Sector', 'Amount Funded'],
        ['fy', 'fdesc', 'secdesc', 'appro_amnt'],
        'b_num'
      ],
      '9': [
        ['Fiscal Year', 'Fund', 'Sector', 'Amount Appropriated'],
        ['fy', 'fdesc', 'secdesc', 'appro_amnt'],
        'b_num'
      ],
    }, haveAdd = [['Options'], ['<button type="button" class="btn btn-warning" onclick="window.location.href = \'{{ asset('budget/lbp') }}/{{$form_no}}/edit\';"><i class="fa fa-edit"></i></button></button>']], tHead = document.getElementById('tHead'), tBody = document.getElementById('tBody');


    if(form_cols[form_no] != undefined) {
      if(tHead != null && form_cols[form_no][0] != undefined) { tHead.innerHTML = "";
        for(let i = 0; i < form_cols[form_no][0].length; i++) {
          tHead.innerHTML += '<th>'+form_cols[form_no][0][i]+'</th>';
        }
        for(let i = 0; i < haveAdd[0].length; i++) {
          tHead.innerHTML += '<th>'+haveAdd[0][i]+'</th>';
        }
      }
      if(tBody != null && form_cols[form_no][0] != undefined) { tBody.innerHTML = ""; if(appDet.length > 0) { for(let j = 0; j < appDet.length; j++) { tBody.innerHTML += '<tr id="'+appDet[j][form_cols[form_no][2]]+'"></tr>'; let curDom = document.getElementById(appDet[j][form_cols[form_no][2]]); if(curDom != null) { curDom.innerHTML = ""; 
        for(let i = 0; i < form_cols[form_no][0].length; i++) {
          if(form_cols[form_no][1][i] != undefined) { if(appDet[j][form_cols[form_no][1][i]] != undefined) {
            curDom.innerHTML += '<td>'+appDet[j][form_cols[form_no][1][i]]+'</td>';
          } }
        }
        for(let i = 0; i < haveAdd[0].length; i++) {
          if(haveAdd[1] != undefined) { if(haveAdd[1][i] != undefined) {
            curDom.innerHTML += '<td>'+haveAdd[1][i]+'</td>';
          } }
        }
      } } } else {
        let insToo = ""; for(let i = 0; i < ((form_cols[form_no][0].length - 1) + haveAdd[0].length); i++) { insToo += '<td hidden></td>'; }
        tBody.innerHTML = '<tr><td colspan="'+(form_cols[form_no][0].length + haveAdd[0].length)+'">Nothing to display here.</td> ' + insToo + ' </tr>';
      } }
    }
  </script>
@endsection