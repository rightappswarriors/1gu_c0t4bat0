@extends('_main')
@section('content')
<?php 
$runningRowTotal = $perAmount = $runningTotalCol = 0;
$runningColTotal = [];

?>
  <section class="content">
      <div class="box box-default">
 
      <!-- /.box-header -->
      <div class="box-body" style="">
        <div class="container text-center">
          <p>Republic of the Philippines</p>
          <p>Province of Negros Oriental</p>
          <p>City of Guihulngan</p>
          <p>Office of the City Treasurer</p>
          <p class="text-center font-weight-bold">STATEMENT OF COLLECTIONS OF DIFFERENT COLLECTORS FOR THE MONTHS OF {{$dateFormatted[0][0]}}, {{$dateFormatted[0][1]}} -  {{$dateFormatted[1][0]}}, {{$dateFormatted[1][1]}}</p>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
            

              <tr>
                <td style="vertical-align : middle;text-align:center; font-weight: bold;">Date</td>
                @isset($users)
                @foreach($users as $key => $user)
                <td style="vertical-align : middle;text-align:center; font-weight: bold;">{{$user[0]}}</td>
                @endforeach
                @endisset
                <td style="vertical-align : middle;text-align:center; font-weight: bold;">TOTAL</td>
                
              </tr>
            </thead>
            <tbody>

              @foreach($data as $keyD => $d)
              <?php 
                $runningRowTotal = 0;
              ?>
              <tr>
                <td>{{Date('m/d/Y',strtotime($keyD))}}</td>
                @foreach($users as $key => $user)
                  @foreach($d as $data)
                  @if($user[1] == $data->uid)
                  <?php 
                    $perAmount = $data->sum;
                    $runningRowTotal += $perAmount;
                    $runningColTotal[$data->uid] = (isset($runningColTotal[$data->uid]) ? $runningColTotal[$data->uid] + $data->sum : $data->sum );
                  ?>
                  @endif
                  @endforeach
                  <td>{{Number_format($perAmount,2)}}</td>
                  <?php 
                    $perAmount = 0;
                  ?>
                @endforeach
                <td>{{Number_format($runningRowTotal,2)}} <?php $runningTotalCol += $runningRowTotal; ?></td>

              </tr>
              @endforeach
              <tr>
                <td>TOTAL</td>
                @foreach($users as $key => $user)
                <?php $currentUser = $user[1]; ?>
                <td>{{Number_format($runningColTotal[$currentUser],2)}}</td>
                @endforeach
                <td>{{Number_format($runningTotalCol,2)}}</td>
              </tr>
              
            </tbody>
          </table>
        </div>

      {{-- {{dd($runningColTotal)}} --}}
      <div class="col-md-12 ">
        <div class="row">
          <div class="col-md-6 ">
            PREPARED BY:
            <div class="row text-center">
              <p><u>ELIZA I. BAGUIO</u></p>
              <p>Reproduction Machine Operator II</p>
            </div>
          </div>
          <div class="col-md-6 ">
            CERTIFIED CORRECT:
            <div class="row text-center">
              <p><u>JESUSA MARTINEEZ DEPOSA, MPA</u></p>
              <p>City Treasurer</p>
            </div>
          </div>
        </div>
      </div>
      </div>
      <!-- /.box-body -->
    </div>

        
  </section>
  <script type="text/javascript" src="{{ asset('root/public/js/forall.js') }}"></script>
  <script type="text/javascript">
      
  </script>
@endsection