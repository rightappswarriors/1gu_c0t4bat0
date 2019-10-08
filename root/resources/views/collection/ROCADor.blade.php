@extends('_main')
@section('content')
	@include('layout._contentheader')
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">OR Issued</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <div id="errMsg"></div>
            <form method="POST">
            	{{csrf_field()}}
	            <table class="table table-bordered table-striped">
	              <thead>
	              <tr>
	                <th>OR Type</th>
	                <th>From</th>
	                <th>To</th>
	                <th width="10%">Value</th>
	              </tr>
	              </thead>
	              <tbody>
	                @isset($or_issued) @foreach($or_issued AS $each)
	                <tr>
	                  <td>{{$each->or_code}}</td>
	                  <td>{{$each->or_no}}</td>
	                  <td><input type="number" value="{{$each->or_no_to}}" name="or_to[]" class="form-control"></td>
	                  <td>
	                  	<input type="text" name="amount[]" class="form-control" value="0.00">
	                  	<input type="hidden" name="transid[]" value="{{$each->transid}}">
	                  </td>
	                </tr>
	                @endforeach
	                @endisset
	                <tr>
	                  <td></td>
	                  <td></td>
	                  <td class="text-right">Total</td>
	                  <td class="bg-secondary font-weight-bold" id="total">0.00</td>
	                </tr>
	              </tbody>
	            </table>
	            <div class="pull-left">
	            	<button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Submit form</button>
	          	</div>
	          	<div class="pull-right">
	            	<a href="{{url('ROCAD/collection')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancel</button></a>
	          	</div>
            </form>
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

		$('body').on('keyup blur', 'input[name="amount[]"]', function(event) {
	      formatCurrency($(this));
	      totalAll();
	    })


		function totalAll(){
			let total = 0;
			$('[name="amount[]"]').each(function(index, el) {
				total += parseFloat($(el).val().replace(/\,/g,''));
			});
			$("#total").html(Number(total).toLocaleString());
		}
	    
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

	    $('form').submit(function(event) {
	    	event.preventDefault();
	    	let data = $(this).serialize();
	    	 $.ajax({
		    	method: 'POST',
		    	data: data,
		    	success: function(a){
		    		if(a == 'done'){
		    			alert('Successfully updated data');
		    			window.location.href=" {{url('collection/ROCAD')}} ";
		    		} else {
		    			alert(a);
		    		}
		    	}
		    })
	    });
  </script>
@endsection