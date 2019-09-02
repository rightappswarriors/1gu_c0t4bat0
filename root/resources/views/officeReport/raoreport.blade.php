
<?php $dom = null; $approSum = 0.00;?>
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
										<div>{{$data[0]}}</div>
									</th>
								<?php endforeach; ?>
							
	            			<?php endif; ?>
	            			<th>Total</th>
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
										<div>{{$data[0]}}</div>
										<?php 
										$approSum += $data[0];
										?>
									</td>
								<?php endforeach; ?>
							
	            			<?php endif; ?>
	            			<td class="font-weight-bold">{{$approSum}}</td>
            			</tr>

            			@isset($obrlne)
            				<?php $headerDetRW = array_values($headerDet);$obrlneRW = array_values($obrlne);$runDown = array();
							$runningCol = 0; $curDate = null;?>
								
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
											
											{{$runningRow}}
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
										<td>{{$runningCol}}</td>
									</tr>

									<tr bgcolor="#93CDDD" class="text-danger">	
										<td></td>
										<td></td>
										<td colspan="3" style="font-weight: bold">BALANCES</td>
										@foreach($headerDet as $key => $value)
											@if(isset($runDown[$key]))
											<td>{{$value[0] - $runDown[$key] }}</td>
											@else
											<td> - </td>
											@endif
										@endforeach
										<td>{{$approSum - $runningCol}}</td>
									</tr>
									
									@endif
									<?php $curDate = $obrlneRW[$i][0]->t_date; ?>
	            				@endfor
	            			
            			@endisset
            			
            		</tbody>
            	</table>