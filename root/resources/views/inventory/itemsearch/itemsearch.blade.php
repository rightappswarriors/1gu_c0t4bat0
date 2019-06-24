@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>url("budget/budget-approved-entry"),'desc'=>'Item Search','icon'=>'none','st'=>true]
    ];
    $_ch = "Item Search"; // Module Name
@endphp
@section('content')
		<!-- Content Header (Page header) -->
		@include('layout._contentheader')
        <!-- Main content -->
        <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Item Search List</h3>
              
              <!-- <button class="btn btn-primary"><i class="fa fa-print"></i> Print</button> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Item Code</th>
                  <th>Quantity</th>
                  <th>Particulars</th>
                  <th>Unit Measure</th>
                  <th>Brand</th>
                  <th>Price</th>
                  <th>Rack Location</th>
                  <th>Item Category</th>
                  <th>Stock Location</th>
                  <th>Branch</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($disp_items as $di)
                <tr>
                  <td>{{$di->item_code}}</td>
                  <td>{{$di->qty_onhand_su}}</td>
                  <td>{{$di->item_desc}}</td>
                  <td>{{$di->sale_unit}}</td>
                  <td>{{$di->brd_name}}</td>
                  <td>{{$di->regular}}</td>
                  <td>{{$di->bin_loc}}</td>
                  <td>{{$di->grp_desc}}</td>
                  <td>{{$di->whs_desc}}</td>
                  <td>{{$di->branchname}}</td>
                </tr>
                @endforeach
                </tbody>
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
      
    </section>
	
@endsection