@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Property Acknowledgment Receipt','icon'=>'none','st'=>true]
    ];
    $_ch = "Property Acknowledgment Receipt"; // Module Name
@endphp
@section('content')
    <!-- Content Header (Page header) -->
    @include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
      <div class="graph-image graph-7">
        <img src="{{url('images/Carabao.jpg')}}" alt="Graph Description" />
      </div>
      <div class="row" >
        <div class="col-sm-12" >
          <table style="border: 0 !important;margin:10px 0 10px 0 !important;"  id="tbl_list" class="table table-striped">
              <thead>
                <tr>
                  <div class="image">
                  <th style="border: none !important;">
                    <img src="{{url('images/logo1.jpg')}}" class="img-circle" alt="logo" style="width: 145px;"></th>
                  <th style="border: none !important;">
                    <center><h3>PROPERTY ACKNOWLEDGMENT RECEIPT</h3><h4>Local Government Unit - City of Guihulngan</h4><h4>General Services Office</h4></center></th>
                  <th style="border: none !important;"><img src="{{url('images/guihulngan.png')}}" class="img-circle logo" alt="logo" style="width:133px;margin-top: -10%;"></th>
                </div>
                </tr>
              </thead>
          </table>
          
         {{--  <div class="row">
             <div class="col-sm-6">
               <h4>Entity Name: {{$par_header->entity}}</h4>
             </div>
          </div>
          <div class="row">
             <div class="col-sm-6">
               <h4>Fund Cluster: {{$par_header->office}}</h4>
             </div>
             <div class="col-sm-6">
               <h4>PAR No: {{$par_header->parno}}</h4>
             </div>
          </div> --}}

          <table class="table">
            <tr>
             <td colspan="12" class="noBorder">Entity Name: {{$par_header->office}}</td>
           </tr>
           <tr>
             <td  class="noBorder">Fund Cluster: {{$par_header->entity}}</td>
             <td align="right"  class="noBorder">PAR No: {{$par_header->parno}}</td>
           </tr>

          <table  class="table table-bordered table-striped" style="margin:10px 0 10px 0 !important;">
            <thead>
            <tr>
                 {{-- <th style="white-space: nowrap;font-size:14px;">Item #</th> --}}
                 <th style="white-space: nowrap;font-size:14px;">Qty</th>
                 <th style="white-space: nowrap;font-size:14px;">Unit</th>
                 <th width="75%" style="font-size:14px;">Description</th>
                 {{-- <th nowspan style="font-size:14px;">Serial No.</th> --}}
                 <th width="40%" style="font-size:14px;">Property No.</th>
                 <th style="white-space: nowrap;font-size:14px;">Date Acquired</th>
                 <th style="white-space: nowrap;font-size:14px;">Amount</th>
            </tr>
          </thead>
            <tbody>
            @foreach($par as $a)
            <tr>
                 {{-- <td>{{$a->ln_num}}</td> --}}
                 <td>{{$a->qty}}</td>
                 <td>{{$a->unit_desc}}</td>
                 <td><textarea>{{$a->item_desc}}</textarea></td>
                 {{-- <td>{{$a->serial_no}}</td> --}}
                 <td><textarea>{{$a->part_no}}</textarea></td>
                 <td>{{$a->ir_date}}</td>
                 <td>{{$a->price}}</td>
            </tr>
            @endforeach
            </tbody>
          </table>

          {{-- <table  class="table table-bordered table-striped" style="margin:8px 0 8px 0 !important;">
            <tfoot>
              <tr>
                <th colspan="8">Office/Department: {{$par_header->office}}</th>
              </tr>
            </tfoot>
          </table> --}}

          <table class="table table-bordered table-striped">
            <tr>
             {{-- <th colspan="3">Received From:</th> --}}
             <th colspan="3">Issued By:</th>
             <th colspan="2">Received By: </th>
             
           </tr>
           <tr>
             {{-- <th colspan="3">
              <br>
               <center><u>{{$par_header->receivedfrom}}</u></center><div><center>{{$par_header->receivedfromdesig}}</center></div>
             </th> --}}
             <th colspan="3">
              <br>
               <center><u>{{$par_header->issuedto}}</u></center><div><center>{{$par_header->issuedtodesig}}</center></div>
             </th>
             <th colspan="2">
              <br>
               <div><center><u>{{$par_header->receivedby}}</u></center><div><center>{{$par_header->receivedbydesig}}</center></div>
             </th>
             
           </tr>
           <tr>
{{--              <th colspan="3">
               <div><center>____________________</center></div><div><center><font size="1">Date</font></center></div>
             </th> --}}
             <th colspan="3">
               <div><center>____________________</center></div><div><center><font size="1">Date</font></center></div>
             </th>
             <th colspan="2">
               <div><center>____________________</center></div><div><center><font size="1">Date</font></center></div>
             </th>
           </tr>
          </table>
        </div>
      </div>
      
    </section>

    <style>
      @media print {
  .logo{
    margin-top: -95%;
  }
              .table td{
        background-color: transparent !important;
        border: 1px solid #000 !important;

      }
       .table th{
        white-space: nowrap;
        background-color: transparent !important;
        border: 1px solid #000 !important;
      }

      td.noBorder{
        white-space: nowrap;
        background-color: transparent !important;
        border: 0 !important;
  padding: 0 8px 0 8px !important;
      }
        * {

        }
        
        #Header, #Footer {display: none ! important;}

        #sidebar-parent {
          display: none;
        }

        #print_hide, #print_name_hide {
          display: none;
        }
         .graph-image img{
        opacity: 0.2; /* set your opacity */ 
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        left:0;
      }
      } 
  @page { margin: 0;}
      textarea {
    border: none;
    overflow: hidden;
    outline: none;

    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
    scroll-behavior: none;

    resize: none; /*remove the resize handle on the bottom right*/
    }
      .graph-7{background: url({{url('images/Carabao.jpg')}}) no-repeat;}
    </style>

    <script>
  
    window.onload = function() 
     {
       $('textarea').each(function() {
        $(this).height($(this).prop('scrollHeight'));
        });

       window.print(); 
       //location.href= "{{route('inventory.are')}}";
     }



    </script>
  
@endsection