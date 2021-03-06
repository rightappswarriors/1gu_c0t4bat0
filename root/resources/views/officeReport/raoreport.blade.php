<table class="table table-bordered">
	<tr>
		<th>{{($data[0]->subgrpdesc ?? 'NOT SPECIFIED')}}</th>
	</tr>
	<tr>
		<th>{{($cc_code ?? 'NOT SPECIFIED')}} {{($data[0]->cc_desc ?? 'NOT SPECIFIED')}}</th>
	</tr>
</table>

<?php $dom = null; $approSum = $firstSum = 0.00;?>

            	<table class="table table-bordered" >
            		<thead>
            			<tr>
	            			<th style="width:10;border: 1px solid #000000;background-color: #93CDDD;"></th>
	            			<th style="width:10;border: 1px solid #000000;background-color: #93CDDD;"></th>
	            			<th align="center" style="width:60;border: 1px solid #000000;background-color: #93CDDD;">Particulars</th>
	            			<?php if(isset($headerDet)): ?>
							
								<?php foreach($headerDet as $key => $data): ?>
									<th align="center" style="width:20;border: 1px solid #000000;background-color: #93CDDD;">{{$data[1]}}</th>
								<?php endforeach; ?>
							
	            			<?php endif; ?>
	            			<th style="width:15;border: 1px solid #000000;background-color: #93CDDD;"></th>
            			</tr>
            			<tr>    
            				<th style="border: 1px solid #000000;background-color: #93CDDD;" align="center">Date</th>
            				<th style="border: 1px solid #000000;background-color: #93CDDD;" align="center">OBR #</th>
						  <th style="border: 1px solid #000000;background-color: #93CDDD;" align="right">Accounting Code</th>
						    <?php if(isset($headerDet)): ?>
							
								<?php foreach($headerDet as $key => $data): ?>
									<th align="center" style="border: 1px solid #000000;background-color: #93CDDD;">{{$key}}</th>
								<?php endforeach; ?>
							
	            			<?php endif; ?>

	            			<th style="border: 1px solid #000000;background-color: #93CDDD;" align="center">Total</th>
						</tr>
						  <tr>			
						  <th style="border: 1px solid #000000;background-color: #93CDDD;"></th>		
						  <th style="border: 1px solid #000000;background-color: #93CDDD;"></th>	    
						    <th style="background-color: #93CDDD;" align="right">Appropriation Ordinance No. 2018-14</th>
						    <?php if(isset($headerDet)): ?>
							
								<?php foreach($headerDet as $key => $data): ?>
									<th align="right" style="border: 1px solid #000000;background-color: #93CDDD;">{{number_format($data[0])}}</th>
									<?php $firstSum += $data[0]; ?>
								<?php endforeach; ?>
							
	            			<?php endif; ?>
						    <th style="border: 1px solid #000000;background-color: #93CDDD;">{{number_format($firstSum,2)}}</th>
						  </tr>
            		</thead>
            		<tbody>
            			<tr>
            				<td style="border: 1px solid #000000;background-color: #92D050;"></td>
            				<td style="border: 1px solid #000000;background-color: #92D050;"></td>
            				<td style="border: 1px solid #000000;background-color: #92D050;" align="right">TOTAL APPROPRIATION (Budget + Addendum)</td>
            				<?php if(isset($headerDet)): ?>
							
								<?php foreach($headerDet as $key => $data): ?>
									<td style="border: 1px solid #000000;background-color: #92D050;">	
										{{number_format($data[0],2)}}
										<?php 
										$approSum += $data[0];
										?>
									</td>
								<?php endforeach; ?>
							
	            			<?php endif; ?>
	            			<td style="border: 1px solid #000000;background-color: #92D050;" class="font-weight-bold">{{number_format($approSum,2)}}</td>
            			</tr>

            			@isset($obrlne)
            				<?php $headerDetRW = array_values($headerDet);$obrlneRW = array_values($obrlne);$runDown = array();
							$runningCol = 0; $curDate = null;?>
								
	            				@for($i = 0; $i < count($obrlneRW); $i++)
									<?php $j = $runningRow = 0;?>
									<tr>
										<td style="border: 1px solid #000000;">{{$obrlneRW[$i][0]->t_date}}</td>
										<td style="border: 1px solid #000000;">{{$obrlneRW[$i][0]->obr_code}}</td>
										<td style="border: 1px solid #000000;">{{$obrlneRW[$i][0]->particulars}}</td>
										@foreach($headerDet as $key => $value)
											@if(isset($obrlneRW[$i][$j]))
												@if($obrlneRW[$i][$j]->at_code == $key)
												<?php 
												$runningRow += $obrlneRW[$i][$j]->amount;
												$runDown[$key] = (isset($runDown[$key]) ? $runDown[$key] + $obrlneRW[$i][$j]->amount : $obrlneRW[$i][$j]->amount);
												?>
												<td style="border: 1px solid #000000;">{{number_format($obrlneRW[$i][$j]->amount,2)}}</td>
												@if($j == 1)
												<td style="border: 1px solid #000000;"></td>
												@endif
												@else
													@for($k = $j; $k < count($headerDet); $k++)
														@if($obrlneRW[$i][$j]->at_code == $headerDetRW[$k][2])
															<?php 
															$runningRow += $obrlneRW[$i][$j]->amount; 
															$runDown[$headerDetRW[$k][2]] = (isset($runDown[$headerDetRW[$k][2]]) ? $runDown[$headerDetRW[$k][2]] + $obrlneRW[$i][$j]->amount : $obrlneRW[$i][$j]->amount);
															?>
															<td style="border: 1px solid #000000;">{{$obrlneRW[$i][$j]->amount}}</td>
														@else
															<td style="border: 1px solid #000000;"></td>
														@endif
													@endfor
												@endif
											@endisset
											<?php $j++; ?>
										@endforeach
										<td style="border: 1px solid #000000;">
											{{number_format($runningRow,2)}}
											<?php $runningCol += $runningRow; ?>
										</td>
									</tr>
									@if(Date('m',strtotime($obrlneRW[$i][0]->t_date)) != Date('m',strtotime($curDate)))
									
									<tr bgcolor="#93CDDD">	
										<td style="border: 1px solid #000000;background-color: #93CDDD;"></td>
										<td style="border: 1px solid #000000;background-color: #93CDDD;"></td>
										<td style="border: 1px solid #000000;background-color: #93CDDD;font-weight: bold">TOTAL as of {{Date('F Y',strtotime($obrlneRW[$i][0]->t_date))}}</td>
										@foreach($headerDet as $key => $value)
											@if(isset($runDown[$key]))
											<td style="border: 1px solid #000000;background-color: #93CDDD;">{{number_format($runDown[$key],2)}}</td>
											@else
											<td style="border: 1px solid #000000;background-color: #93CDDD;"></td>
											@endif
										@endforeach
										<td style="border: 1px solid #000000;background-color: #93CDDD;">{{number_format($runningCol,2)}}</td>
									</tr>

									<tr bgcolor="#93CDDD" class="text-danger">	
										<td style="border: 1px solid #000000;background-color: #93CDDD;"></td>
										<td style="border: 1px solid #000000;background-color: #93CDDD;"></td>
										<td style="border: 1px solid #000000;background-color: #93CDDD;font-weight: bold">BALANCES</td>
										@foreach($headerDet as $key => $value)
											@if(isset($runDown[$key]))
											<td style="border: 1px solid #000000;background-color: #93CDDD;">{{number_format($value[0] - $runDown[$key] ,2  )}}</td>
											@else
											<td style="border: 1px solid #000000;background-color: #93CDDD;"> - </td>
											@endif
										@endforeach
										<td style="border: 1px solid #000000;background-color: #93CDDD;">{{number_format($approSum - $runningCol,2)}}</td>
									</tr>
									
									@endif
									<?php $curDate = $obrlneRW[$i][0]->t_date; ?>
	            				@endfor
	            			
            			@endisset
            			
            		</tbody>
            	</table>