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
	              	<th>Action</th>
	                <th>OR Type</th>
	                <th>From</th>
	                <th>Quantity Sold</th>
	                <th width="10%">Value</th>
	              </tr>
	              </thead>
	              <tbody>
	                @isset($or_issued) @foreach($or_issued AS $each)
	                <tr overall="{{$each->or_no_to}}" transid="{{$each->transid}}">
                	  <td>
                		<button onclick="addElement(this.parentElement.parentElement)" class="btn btn-success" type="button"><i class="fa fa-plus"></i></button>
                	  </td>
	                  <td>{{$each->or_code}}</td>
	                  <td>{{$each->or_no}}</td>
	                  <td>
	                  	{{$each->or_no_to}}
	                  </td>
	                  <td>
	                  	-
	                  	<input type="hidden" name="transid[]" value="{{$each->transid}}">
	                  </td>
	                </tr>
	                <tr>
	                	<td>
	                		<button onclick="deleteThis(this.parentElement.parentElement)" class="btn btn-danger" type="button"><i class="fa fa-minus"></i></button>
	                	</td>
	                	<td colspan="2" width="70%">
	                		<select required="" name="ors[{{$each->transid}}][]" class="form-control">
	                			<option value="">Please Select</option>
	                			@isset($or)
	                			@foreach($or as $o)
	                			<option value="{{$o->taxtype_id}}">{{$o->taxtype_desc}}</option>
	                			@endforeach
	                			@endisset
	                		</select>
	                	</td>
	                	<td>
	                		<input required="" limit="{{$each->or_no_to}}" forTrans="{{$each->transid}}" type="number" name="or_to[{{$each->transid}}][]" class="form-control">
	                	</td>
	                	<td>
	                		<input required="" type="text" name="amount[{{$each->transid}}][]" class="form-control toTotal" value="0.00">
	                	</td>
	                </tr>
	                @endforeach
	                @endisset
	                <tr>
	                  <td colspan="3"></td>
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

		$('body').on('keyup blur', '.toTotal', function(event) {
	      formatCurrency($(this));
	      totalAll();
	    })


		function totalAll(){
			let total = 0;
			$('.toTotal').each(function(index, el) {
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


	    function deleteThis(element){
	    	element.remove();
	    	totalAll();
	    }

	    function addElement(elemnt){
	    	let extraDetails = [elemnt.getAttribute('overall'),elemnt.getAttribute('transid')];
	    	let toAddElement = 
	    	'<tr>'+
            	'<td>'+
            		'<button onclick="deleteThis(this.parentElement.parentElement)" class="btn btn-danger" type="button"><i class="fa fa-minus"></i></button>'+
            	'</td>'+
            	'<td colspan="2" width="70%">'+
            		'<select required="" name="ors['+extraDetails[1]+'][]" class="form-control">'+
            			'<option value="">Please Select</option>'+
            			@isset($or)
            			@foreach($or as $o)
            			'<option value="{{$o->taxtype_id}}">{{$o->taxtype_desc}}</option>'+
            			@endforeach
            			@endisset
            		'</select>'+
            	'</td>'+
            	'<td>'+
            		'<input required="" limit="'+extraDetails[0]+'" forTrans="'+extraDetails[1]+'" type="number" name="or_to['+extraDetails[1]+'][]" class="form-control">'+
            	'</td>'+
            	'<td>'+
            		'<input required="" type="text" name="amount['+extraDetails[1]+'][]" class="form-control toTotal" value="0.00">'+
            	'</td>'+
            '</tr>';
            $(toAddElement).insertAfter(elemnt);
            $('select').select2();
	    }

	    $(document).on('keyup','[fortrans]',function(){
	    	let thisid = $(this).attr('forTrans'), limit = $(this).attr('limit'), counter = 0;
	    	$('[fortrans="'+thisid+'"]').each(function(index, el) {
	    		counter += parseInt( Number(this.value) );
	    		if(counter > limit){
	    			alert('You have exceeded the given OR of until ' + limit +'. Please change or check entries');
	    			this.value = ""; this.focus();
	    		}
	    	});
	    })
  </script>
@endsection