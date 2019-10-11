@extends('_main')
@section('content')
	@include('layout._contentheader')
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">List of Collectors with submitted OR total this day ({{Date('Y-m-d')}})</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <div id="errMsg"></div>
            <div class="container mt-5">
	            <div class="row">
	            	<div class="col-md-6">Collector Name</div>
	            	<div class="col-md-6">Expected cash to liquidate</div>
	            </div>
	            <div class="row mt-3">
	            	<div class="col-md-6">{{($det[0]->opr_name ?? 'NOT DEFINED')}}</div>
	            	<div class="col-md-6">{{(number_format($det[0]->total,2) ?? 'NOT DEFINED')}}</div>
	            </div>
            </div>
            <div class="container mt-5">
            	<form method="POST">
            		{{csrf_field()}}
            		<label for="liquidate">Total Cash given</label>
            		<input required type="text" name="amount" class="form-control" id="liquidate" style="text-align: center;">
            		<div class="pull-left mt-3">
		            	<button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Submit form</button>
		          	</div>
		          	<div class="pull-right mt-3">
		            	<a href="{{url('collection/Liquidating-officer')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancel</button></a>
		          	</div>
            	</form>
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
  <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
	<script type="text/javascript">

		$('body').on('keyup blur', 'input[name="amount"]', function(event) {
	      formatCurrency($(this));
	    })
	    
	    function formatNumber(n) {
	      return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
	    }


	    function formatCurrency(input, blur) {

	      var input_val = input.val();
	      
	      if (input_val === "") { return; }
	      
	      var original_len = input_val.length;

	      var caret_pos = input.prop("selectionStart");
	        
	      if (input_val.indexOf(".") >= 0) {

	        var decimal_pos = input_val.indexOf(".");

	        var left_side = input_val.substring(0, decimal_pos);
	        var right_side = input_val.substring(decimal_pos);

	        left_side = formatNumber(left_side);

	        right_side = formatNumber(right_side);
	        
	        if (blur === "blur") {
	          right_side += "00";
	        }
	        
	        right_side = right_side.substring(0, 2);

	        input_val = left_side + "." + right_side;

	      } else {
	        input_val = formatNumber(input_val);
	        input_val = input_val;
	        
	        if (blur === "blur") {
	          input_val += ".00";
	        }
	      }
	      
	      input.val(input_val);

	      var updated_len = input_val.length;
	      caret_pos = updated_len - original_len + caret_pos;
	      input[0].setSelectionRange(caret_pos, caret_pos);
	    }

  </script>
@endsection