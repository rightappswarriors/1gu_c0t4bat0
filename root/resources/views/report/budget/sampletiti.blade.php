@extends('_main')
@section('content')
<!-- Content Header (Page header) -->
@include('layout._contentheader')
<!-- Main content -->
<style type="text/css">
</style>
<section class="content printThisNow">
    <?php $totalSectorAppro = 0; $totalSectorAllot = 0; $totalSectorOblig = 0; $totalSectorApproBalance = 0; $totalSectorAllotBalance = 0; $sector1 = []; $sector1Total = []; $m08 = []; $ppasubgrp = []; $ppasubgrp1 = []; $m04 = []; $forAllTotals = []; $forAllTotalsNames = []; $forAllTotalsValues = []; ?>
    <center>
        <h6>STATUS OF APPROPRIATIONS, ALLOTMENTS, OBLIGATIONS AND BALANCES</h6>
        <h2>GENERAL FUND PROPER</h2>
        {{-- <h5>As of {{ ((isset($AsOfDate)) ? $AsOfDate : "No Financial Year Selected") }}</h5> --}}
        <h5 id="isAsOf"></h5>
    </center><br><br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="2">Account Code</th>
                <th rowspan="2">Function/Program/Project</th>
                <th rowspan="2">Appropriation</th>
                <th rowspan="2">Allotment</th>
                <th rowspan="2">Obligation</th>
                <th colspan="2">Balances of</th>
            </tr>
            <tr>
                <th>Appropriations</th>
                <th>Allotments</th>
            </tr>
        </thead>
        <tbody>
            <?php $cTotalAppro = 0; $cTotalAllot = 0; $cTotalOblig = 0; $cTotalApproBal = 0; $cTotalAllotBal = 0; $cGrpid = ""; $_inc = 0; $_inc1 = 0;
            $totalSectorAppro1 = 0; $totalSectorAllot1 = 0; $totalSectorOblig1 = 0; $totalSectorApproBalance1 = 0; $totalSectorAllotBalance1 = 0; ?>

            @foreach($saob AS $saobEach)
            <?php if($_inc < (count($saob) - 1)) { $_inc++; } ?>
            @if(! in_array($saobEach->secdesc, $sector1)) <?php array_push($sector1, $saobEach->secdesc); ?>
                <tr>
                    <td colspan="7"><b>{{$saobEach->secdesc}}</b></td>
                </tr>
            @endif

            @if(! in_array($saobEach->secdesc.$saobEach->cc_desc, $m08)) <?php array_push($m08, $saobEach->secdesc.$saobEach->cc_desc); ?>
                <tr>
                    <td colspan="7"><b>{{$saobEach->cc_desc}}</b></td>
                </tr>
            @endif
            @if(! in_array($saobEach->secdesc.$saobEach->cc_desc.$saobEach->subgrpdesc, $ppasubgrp))
                <?php array_push($ppasubgrp, $saobEach->secdesc.$saobEach->cc_desc.$saobEach->subgrpdesc); array_push($ppasubgrp1, $saobEach->subgrpdesc); $cTotalAppro = 0; $cTotalAllot = 0; $cTotalOblig = 0; $cTotalApproBal = 0; $cTotalAllotBal = 0; $cGrpid = $saobEach->subgrpdesc; ?>
                <tr>
                    <td colspan="7"><b> {{$saobEach->subgrpdesc}}</b></td>
                </tr>
            @endif
            <?php $totalSectorAppro += $saobEach->appro_amnt; $totalSectorAllot += $saobEach->allot_amnt; $totalSectorOblig += $saobEach->oblig_amnt; $totalSectorApproBalance += ($saobEach->appro_amnt - $saobEach->oblig_amnt); $totalSectorAllotBalance += ($saobEach->allot_amnt - $saobEach->oblig_amnt); 

            $cTotalAppro += $saobEach->appro_amnt; $cTotalAllot += $saobEach->allot_amnt; $cTotalOblig += $saobEach->oblig_amnt; $cTotalApproBal += ($saobEach->appro_amnt - $saobEach->oblig_amnt); $cTotalAllotBal += ($saobEach->allot_amnt - $saobEach->oblig_amnt); ?>
            <tr>
                <td style="text-align: left;">{{$saobEach->at_code}}</td>
                <td style="text-align: left;">{{((isset($saobEach->seq_desc)) ? $saobEach->seq_desc : $saobEach->at_desc)}}</td>
                <td style="text-align: right;">{{number_format(($saobEach->appro_amnt), 2)}}</td>
                <td style="text-align: right;">{{number_format(($saobEach->allot_amnt), 2)}}</td>
                <td style="text-align: right;">{{number_format(($saobEach->oblig_amnt), 2)}}</td>
                <td style="text-align: right;">{{number_format(($saobEach->appro_amnt - $saobEach->oblig_amnt), 2)}}</td>
                <td style="text-align: right;">{{number_format(($saobEach->allot_amnt - $saobEach->oblig_amnt), 2)}}</td>
            </tr>
            @if($cGrpid != "") @if(! in_array($saob[$_inc]->secdesc.$saob[$_inc]->cc_desc.$saob[$_inc]->subgrpdesc, $ppasubgrp) || ($_inc1) == (count($saob) - 1))
                <?php
                    array_push($forAllTotalsNames, $saob[$_inc]->subgrpdesc); array_push($forAllTotalsValues, [$cTotalAppro, $cTotalAllot, $cTotalOblig, $cTotalApproBal, $cTotalAllotBal]);

                    if(isset($forAllTotals[$saob[$_inc]->subgrpdesc])) { array_push($forAllTotals[$saob[$_inc]->subgrpdesc], $forAllTotalsValues); } else { $forAllTotals = array_combine($forAllTotalsNames, $forAllTotalsValues); }
                ?>
                <tr>
                    <th colspan="2"> Total {{$ppasubgrp1[count($ppasubgrp1) - 1]}}</th>
                    <th style="text-align: right;">{{number_format($cTotalAppro, 2)}}</th>
                    <th style="text-align: right;">{{number_format($cTotalAllot, 2)}}</th>
                    <th style="text-align: right;">{{number_format($cTotalOblig, 2)}}</th>
                    <th style="text-align: right;">{{number_format($cTotalApproBal, 2)}}</th>
                    <th style="text-align: right;">{{number_format($cTotalAllotBal, 2)}}</th>
                </tr>
            @endif @endif
            <?php if($_inc1 < (count($saob) - 1)) { $_inc1++; } ?>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total SAOOB</th>
                <th>{{number_format($totalSectorAppro, 2)}}</th>
                <th>{{number_format($totalSectorAllot, 2)}}</th>
                <th>{{number_format($totalSectorOblig, 2)}}</th>
                <th>{{number_format($totalSectorApproBalance, 2)}}</th>
                <th>{{number_format($totalSectorAllotBalance, 2)}}</th>
            </tr>
        </tfoot>
    </table>
</section>
<!-- /.content -->
<script>
    let __date = new Date(); __year = __date.getFullYear(), __month = (__date.getMonth() + 1), __theMonths = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"], isAsOf = document.getElementById('isAsOf');
    @if(count($b_period) > 0)
    __year = parseInt("{{$b_period[0]}}");
    __month = parseInt("{{$b_period[1]}}");
    @endif
    __date = new Date(__year, __month, 0);
    if(isAsOf != undefined || isAsOf != null) {
        isAsOf.innerHTML = __theMonths[__month] + " " + __date.getDate() + ", " + __year;
    }
</script>
@endsection