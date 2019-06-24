@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Report','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>url("report/budget/saob"),'desc'=>'SAOB','icon'=>'none','st'=>true],
    ];
    $_ch = "Generate SAOB Report"; // Module Name
@endphp
@section('content')
<!-- Content Header (Page header) -->
@include('layout._contentheader')
<!-- Main content -->
<section class="content">
    <div class="modal fade in" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Generate SAOB <span id="MOD_MODE"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <form id="ItmForm" novalidate data-parsley-validate>
                            <span class="AddMode">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label> Period <span style="color:red"><strong>*</strong></span></label>
                                            <select name="budget_period" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#budget_period_text" name="fid" data-parsley-required-message="<strong>Period</strong> is required." required>
                                                @isset($budget_period)
                                                    <option value="">Select Period...</option>
                                                    @foreach($x03 as $b)
                                                        <option value="{{$b->fy}}">{{$b->fy}}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">No Period registered...</option>
                                                @endisset
                                            </select>
                                            <span id="budget_period_text"></span>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Budget Period <span style="color:red"><strong>*</strong></span></label>
                                            <select name="budget_period" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#budget_period_text" name="fid" data-parsley-required-message="<strong>Budget Period</strong> is required." required>
                                                @isset($budget_period)
                                                    <option value="">Select Budget Period...</option>
                                                    @foreach($budget_period as $b)
                                                        <option value="{{$b->budget_code}}">{{$b->budget_desc}}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">No Budget Period registered...</option>
                                                @endisset
                                            </select>
                                            <span id="budget_period_text"></span>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Sector <span style="color:red"><strong>*</strong></span></label>
                                            <select class="form-control" name="sector">
                                                @isset($sector)
                                                @else
                                                <option value="">No sectors registered...</option>
                                                @endisset
                                            </select>
                                            <span id="sector_span"></span>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Fund <span style="color:red"><strong>*</strong></span></label>
                                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-errors-container="#itm_acc_title_span" name="fid" data-parsley-required-message="<strong>Fund</strong> is required." required>
                                                @isset($fund)
                                                    <option value="">Select Fund...</option>
                                                    @foreach ($fund as $f)
                                                        <option value="{{$f->fid}}">{{$f->fdesc}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            <span id="itm_acc_title_span"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Sector <span style="color:red"><strong>*</strong></span></label>
                                            <select class="form-control select2 select2-hidden-accessible" name="sector" value="" style="width: 100%;" data-parsley-errors-container="#fymo_span" tabindex="-1" aria-hidden="true" required="" data-parsley-required-message="<strong>Sector</strong> is required.">
                                                @isset($sector)
                                                    <option value="">Select Sector...</option>
                                                    @foreach($sector as $x3)
                                                      <option value="{{$x3->secid}}">{{$x3->secdesc}}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">No Sector registered...</option>
                                                @endisset
                                            </select>
                                            <span id="fymo_span"></span>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Notes</label>
                                            <textarea class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div> --}}
                            </span>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="GenerateSaob()" class="btn btn-success"><i id="ItemButtonNameButton" class="fa fa-plus"></i> <span id="ItemButtonName">Generate</span></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</section>
<!-- /.content -->
<script>
	// var selectedId = 0, SelectedMode = 0;
	$(document).ready(function(){
            $('#modal-default').modal('toggle');
        });
    function GenerateSaob()
    {
        if($('#ItmForm').parsley().validate())
        {
            var sector = $('select[name="sector"]').val();
            var fid = $('select[name="fid"]').val();
            var budget_period = $('select[name="budget_period"]').val();
            // var test = fymo.split('-');
            // var fy = test[0];
            // var mo = test[1];
            location.href = "{{ url('reports/budget/saaob/') }}/" + sector + "_" + fid + "_" + budget_period;
        }
    }
</script>
@endsection