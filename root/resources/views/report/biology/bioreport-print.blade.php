@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Budget','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Report','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Biology','icon'=>'none','st'=>true]
    ];
    $_ch = "Biology Report"; // Module Name
@endphp
@section('content')
    <!-- Content Header (Page header) -->
    @include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
      {{-- <div class="graph-image graph-7">
        <img src="{{url('images/Carabao.jpg')}}" alt="Graph Description" />
      </div> --}}
      <div class="row">
        <div class="col-sm-12">
          <center><b>Republic of the Philippines<br> Province of Negros Oriental<br> LGU-City of Guihulngan<br><br>
            <u>WORD, OTHER ANIMALS AND BREEDING STOCKS PROPERTY CODE</u></b><br>
          </center>
          @if(count($getallitems) > 0)
            Fund: {{$header->fund}}
            <br>
            Kind Of Animal: {{$header->kindofanimals}}
          @else

          @endif  
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th colspan="4"><center>Acquistion</center></th>
                <th colspan="2"><center>Birth Of Offspring</center></th>
                <th colspan="3"><center>Disposition</center></th>
              </tr>
            </thead>
            <thead>
              <tr>
                <td>Date</td>
                <td>Property No.</td>
                <td>Description</td>
                <td>Qty.</td>
                
                <td>Date</td>
                <td>No. Of Offspring</td>
                
                <td>Date</td>
                <td>Nature Of Disposition</td>
                <td>No Disposed of</td>
              </tr>
            @if(count($getallitems) > 0)
            </thead>
            @foreach($getallitems as $d)
            <tbody style="border: none;">
              <tr>
              <td>{{$d->date}}</td>
              <td>{{$d->property_no}}</td>
              <td>{{$d->item_desc}}</td>
              <td>{{$d->acquisitionqty}}</td>
              <td>{{$d->offdate}}</td>
              <td>{{$d->offspringqty}}</td>
              <td>{{$d->dispodate}}</td>
              <td>{{$d->natureofdisposition}}</td>
              <td>{{$d->numberofdisposition}}</td>
              </tr>
            </tbody>
            @endforeach
            @else
            <h3>NO DATA FOUND</h3>
            @endif
          </table>
        </div>
      </div>
      <br>
      
      
      
    </section>

    <style>
      @media print{
        
        .table th{
        background-color: transparent !important;
        border: 1px solid !important;
        font-size: 13px !important;
      }

      .table td{
        background-color: transparent !important;
        border: 1px solid !important;
        /*border-right:none !important;
border-left:none !important;*/

      }

      @page{
        size:landscape;
      }

      /*table > tbody > td .hideborder{
        border: hidden;
      }*/
/*      tr.noborder td{
        border-bottom:none !important;
        border-top:none !important;
      }

      tr.noborder2 td:last-child {
        border-bottom: 1px solid  !important;
        border-top: 1px solid  !important;
      }*/

      tr.noborder3 td:last-child {
        border-bottom: 1px solid !important;
        border-top: 1px solid !important;
      }

      /*tr.noborder td{
        border-bottom:none !important;
border-top:none !important;
      }*/
    }
    </style>

    <script>
    
    window.onload = function() 
     {
       $('textarea').each(function() {
        $(this).height($(this).prop('scrollHeight'));
        });

       window.print(); 
       //location.href= "{{url("report/biology/bioreportsview")}}";
     }

    </script>
  
@endsection