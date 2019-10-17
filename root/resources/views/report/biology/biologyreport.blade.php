@extends('_main')
@php
	    $_ch = " Biology Report"; // Module Name
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
              <h3 class="box-title">Biology Report Table</h3>
              <h4>Fund :</h5>
              <h4>Kind Of Animal :</h5>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tbl_list" class="table table-bordered table-striped">
                <thead>
		            <tr>
		            		
		                <th style="border-right: 2px solid;" colspan="4"><center>Acquisition</center></th>
		                <th style="border-right: 2px solid;" colspan="4"><center> Birth Of Offspring </center></th>
		                <th style="border-right: 2px solid;" colspan="4"><center> Disposition </center></th>

		            </tr>
		            <tr>
		                <th style="">Date</th>
		                <th style="">Property No</th>
		                <th style="">Description</th>
		                <th style="border-right: 2px solid;">Qty.</th>
		                <th style="">Date</th>
		                <th style="">No Of Offspring</th>
		                <th style="">Property No</th>
		                <th style="border-right: 2px solid;">Description</th>
		                <th style="">Date</th>
		                <th style="">Property No</th>
		                <th style="">Nature of Disposition</th>
		                <th style="border-right: 2px solid;">Number of Disposition</th>
		                <th>Action</th>
		            </tr>
        		</thead>
                <tbody>
                 
                <tr>
                  <td style="">sample data</td>
                  <td>sample data</td>
                  <td>sample data</td>
                  <td style="border-right: 2px solid;">sample data</td>
                  <td>sample data</td>
                  <td>sample data</td>
                  <td>sample data</td>
                  <td style="border-right: 2px solid;">sample data</td>
                  <td>sample data</td>
                  <td>sample data</td>
                  <td>sample data</td>
                  <td style="border-right: 2px solid;">sample data</td>
                  <td>
                    <center><a class="btn btn-social-icon btn-primary" href="#"><i class="fa fa-print"></i></a></td></center>
                </tr>
                
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
    <!-- /.content -->
  
@endsection