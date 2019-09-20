@extends('_main')
<style>
	th{
		vertical-align: middle!important;
		/*text-align: center!important;*/
	}
</style>
<?php $dom = null; ?>
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
          <div class="col-md-3">
            <div class="form-group">
              {{-- <center><label>&nbsp;</label></center>
              <a href="{{ asset('accounting/collection/or_issuance/new') }}"><button type="button" class="btn btn-block btn-primary"><i class="fa fa-plus"></i> New OR Issuance</button></a> --}}
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              {{-- <center><label>&nbsp;</label></center>
              <button type="button" class="btn btn-block btn-info"><i class="fa fa-print"></i> Print</button> --}}
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-body -->
    </div>

    {{-- initiate sums --}}
    <?php 
    	$approSum = $firstSum = 0.00;
    ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">RAO Report</h3>
          </div>
          <div class="container mt-3">
          	{{($data[0]->subgrpdesc ?? 'NOT SPECIFIED')}}
          </div>
          <div class="container mt-3">
          	{{($cc_code ?? 'NOT SPECIFIED')}} {{($data[0]->cc_desc ?? 'NOT SPECIFIED')}}
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <div id="errMsg"></div>
            
            <div class="container table-responsive">
            	<table class="table table-bordered">
            		<thead>
            			<tr bgcolor="#93CDDD">
	            			<th>Date</th>
	            			<th>OBR #</th>
	            			<th colspan="3">
	            				<div>
	            					Particulars
	            				</div>
	            				<div>
	            					Account Code
	            				</div>
	            				<div>
	            					Appropriation Ordinance No. 2018-14
	            				</div>
	            			</th>
	            			
	            			<?php if(isset($headerDet)): ?>
							
								<?php foreach($headerDet as $key => $data): ?>
									<th>	
										<div>{{$data[1]}}</div>
										<div>{{$key}}</div>
										<div>{{number_format($data[0],2)}}</div>
									</th>
									<?php $firstSum += $data[0]; ?>
								<?php endforeach; ?>
							
	            			<?php endif; ?>
	            			<th>
	            				<div>Total</div>
								<div></div>
								<div>{{number_format($firstSum,2)}}</div>
	            			</th>
            			</tr>
            		</thead>
            		<tbody>
            			<tr bgcolor="#92D050">
            				<td></td>
            				<td></td>
            				<td colspan="3">TOTAL APPROPRIATION (Budget + Addendum)</td>
            				<?php if(isset($headerDet)): ?>
							
								<?php foreach($headerDet as $key => $data): ?>
									<td >	
										<div>{{number_format($data[0],2)}}</div>
										<?php 
										$approSum += $data[0];
										?>
									</td>
								<?php endforeach; ?>
							
	            			<?php endif; ?>
	            			<td class="font-weight-bold">{{number_format($approSum,2)}}</td>
            			</tr>

            			@isset($obrlne)
            				<?php $headerDetRW = array_values($headerDet);$obrlneRW = array_values($obrlne);$runDown = array();
							$runningCol = 0; $curDate = null;?>
							{{-- @for($m = 1; $m < 12; $m++) --}}
								
	            				@for($i = 0; $i < count($obrlneRW); $i++)
									<?php $j = $runningRow = 0;?>
									<tr>
										<td>{{$obrlneRW[$i][0]->t_date}}</td>
										<td>{{$obrlneRW[$i][0]->obr_code}}</td>
										<td colspan="3">{{$obrlneRW[$i][0]->particulars}}</td>
										@foreach($headerDet as $key => $value)
											@if(isset($obrlneRW[$i][$j]))
												@if($obrlneRW[$i][$j]->at_code == $key)
												<?php 
												$runningRow += $obrlneRW[$i][$j]->amount;
												$runDown[$key] = (isset($runDown[$key]) ? $runDown[$key] + $obrlneRW[$i][$j]->amount : $obrlneRW[$i][$j]->amount);
												?>
												<td>{{$obrlneRW[$i][$j]->amount}}</td>
												@else
													@for($k = $j; $k < count($headerDet); $k++)
														@if($obrlneRW[$i][$j]->at_code == $headerDetRW[$k][2])
															<?php 
															$runningRow += $obrlneRW[$i][$j]->amount; 
															$runDown[$headerDetRW[$k][2]] = (isset($runDown[$headerDetRW[$k][2]]) ? $runDown[$headerDetRW[$k][2]] + $obrlneRW[$i][$j]->amount : $obrlneRW[$i][$j]->amount);
															?>
															<td>{{$obrlneRW[$i][$j]->amount}}</td>
														@else
															<td></td>
														@endif
													@endfor
												@endif
											@endisset
											<?php $j++; ?>
										@endforeach
										<td>
											
											{{number_format($runningRow,2)}}
											<?php $runningCol += $runningRow; ?>
										</td>
									</tr>
									@if(Date('m',strtotime($obrlneRW[$i][0]->t_date)) != Date('m',strtotime($curDate)))
									
									<tr bgcolor="#93CDDD">	
										<td></td>
										<td></td>
										<td colspan="3" style="font-weight: bold">TOTAL as of {{Date('F Y',strtotime($obrlneRW[$i][0]->t_date))}}</td>
										@foreach($headerDet as $key => $value)
											@if(isset($runDown[$key]))
											<td>{{$runDown[$key]}}</td>
											@else
											<td></td>
											@endif
										@endforeach
										<td>{{number_format($runningCol,2)}}</td>
									</tr>

									<tr bgcolor="#93CDDD" class="text-danger">	
										<td></td>
										<td></td>
										<td colspan="3" style="font-weight: bold">BALANCES</td>
										@foreach($headerDet as $key => $value)
											@if(isset($runDown[$key]))
											<td>{{number_format($value[0] - $runDown[$key] ,2)}}</td>
											@else
											<td> - </td>
											@endif
										@endforeach
										<td>{{number_format($approSum - $runningCol,2)}}</td>
									</tr>
									
									@endif
									<?php $curDate = $obrlneRW[$i][0]->t_date; ?>
	            				@endfor
            				{{-- @endfor --}}
	            			
            			@endisset
            			
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
  <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
	<script type="text/javascript">

  </script>
@endsection