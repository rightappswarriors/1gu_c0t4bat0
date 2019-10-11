@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Stock Transaction Card','icon'=>'none','st'=>true]
    ];
    $_ch = "Stock Transaction Card"; // Module Name
@endphp
@section('content')
    <!-- Content Header (Page header) -->
    @include('layout._contentheader')
        <!-- Main content -->
        <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Stock Transaction Card</h3>
              {{-- <a href="{{route('inventory.stockin_add')}}"><button class="btn btn-primary"><i class="fa fa-plus-circle"></i> Create</button></a> --}}
              <!-- <button class="btn btn-primary"><i class="fa fa-print"></i> Print</button> -->
            </div>
            <!-- /.box-header -->
            <!-- /.box-header -->
            <form id="HeaderForm" data-parsley-validate novalidate>
              <div class="box-body" style="">

                <div class="row">
                  <div class="col-md-3">
              <div class="form-group">
                <label>Stock Location <span style="color:red"><strong>*</strong></span></label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_stocklocation" data-parsley-errors-container="#validate_stocklocation" data-parsley-required-message="<strong>Stock Location is required.</strong>" required>
                  @if($isnew)
                    <option value="" selected="selected">--- Select Stock Location ---</option>
                    @foreach($stock_loc as $st)
                    <option value="{{$st->whs_code}}">{{$st->whs_desc}}</option>
                    @endforeach
                  @else
                    @foreach($stock_loc as $st)
                    @if($rechdr->whs_code == $st->whs_code)
                    <option selected="selected" value="{{$st->whs_code}}">{{$st->whs_desc}}</option>
                    @else
                    <option value="{{$st->whs_code}}">{{$st->whs_desc}}</option>
                    @endif
                    @endforeach
                  @endif
                </select>
                 <span id="validate_stocklocation"></span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Branch <span style="color:red"><strong>*</strong></span></label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true", name="select_branch" data-parsley-errors-container="#validate_branch" data-parsley-required-message="<strong>Branch is required.</strong>" required>
                  @if($isnew)
                    <option value="" selected="selected">--- Select Branch ---</option>
                    @foreach($branch as $b)
                    <option value="{{$b->code}}">{{$b->name}}</option>
                    @endforeach
                  @else
                    @foreach($branch as $b)
                    @if($rechdr->branch == $b->code)
                    <option selected = "selected" value="{{$b->code}}">{{$b->name}}</option>
                    @else
                    <option value="{{$b->code}}">{{$b->name}}</option>
                    @endif
                    @endforeach
                  @endif
                </select>     
                <span id="validate_branch"></span>      
              </div>
            </div>
            
            <div class="col-md-3">
              <div class="form-group">
                <label> </label><br>
                <a><button type="button" id="toggleModalSearch" class="btn btn-primary btn-block btn-lg"><i class="fa fa-search-plus"></i> Search Item</button></a>
              </div>
            </div>
          </div>
          <hr>
                <form id="add-form" data-parsley-validate novalidate>
              <span class="AddMode">
                <div class="box-body">
<<<<<<< HEAD
                  <div class="row"> 
                      <div class="col-sm-3">
=======
                  <div class="row">
                  <div class="col-sm-3">
                        <div class="form-group">
                          <label>Item Code</label>
                          <input type="text" class="form-control" name="txt_itemcode_text"  readonly="">
                        </div>
                        </div> 
                      <div class="col-sm-3" hidden="">
>>>>>>> a8e4aa4031104383d96db004e0dca404095b9e0c
                        <div class="form-group">
                          <label>Item Code</label>
                          <input type="text" class="form-control" name="txt_itemcode"  readonly="">
                        </div>
                        </div>
<<<<<<< HEAD
                      <div class="col-sm-3">
                      <div class="form-group">
                        <label>Item Descriptions</label>
=======
                      <div class="col-sm-6">
                      <div class="form-group">
                        <label>Item Description</label>
>>>>>>> a8e4aa4031104383d96db004e0dca404095b9e0c
                        <input type="text" class="form-control" name="txt_itemdesc" readonly=""> 
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>QUANTITY CURRENT BALANCES</label>
<<<<<<< HEAD
                        <input type="text" class="form-control" name="-" readonly=""> 
                      </div>
                    </div>
                    <div class="col-sm-3">
=======
                        <input type="text" class="form-control" name="txt_qty_currnt_blnce" readonly=""> 
                      </div>
                    </div>
                    <div class="col-sm-3" hidden="">
>>>>>>> a8e4aa4031104383d96db004e0dca404095b9e0c
                      <div class="form-group">
                        <label>TOTAL INV. COST BALANCES </label>
                        @if($isnew)
                            <input type="text" class="form-control" name="txt_grandtotalamt" readonly="">
                        @else
                            <input type="text" class="form-control" name="txt_grandtotalamt" value="{{$grandtotal->grandtotal}}" readonly="">
                        @endif 
                      </div>
                    </div>                     
                  </div>
              </span>
          </form>       
              </div>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">



              <!-- Modal -->
            <div class="row">
              <div class="modal fade" id="itemsearch-modal">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Item Search</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                          <div class="table-responsive">
                          <table id="example1" class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                              <th></th>
                              <th>Item Code</th>
                              <th>Quantity</th>
                              <th>Property No</th>
                              <th>Serial No</th>
                              <th>Tag No</th>
                              <th>Item Description</th>
                              <th>Unit</th>
                              <th>Brand</th>
                              <th>Price</th>
                              <th>Rack Location</th>
                              <th>Item Category</th>
                              <th>Stock Location</th>
                              <th>Branch</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                          </table>
                          </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                      <button type="button" id="AddItem" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" {{-- onclick="set_tbl_itemlist('sc')" --}}><i class="fa fa-plus"></i> Add Item</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            </div>  


            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="tbl_itemlist" class="table table-bordered table-striped">
                <thead>
                <tr>
<<<<<<< HEAD
                  <th>trn_type_desc</th>
                  <th>trn_type</th>
                  <th>item_code</th>
                  <th>item_desc</th>
                  <th>trn_date</th>
                  <th>reference</th>
                  <th>qty_in</th>
                  <th>qty_out</th>
                  <th>price</th>
                  <th>supl_name</th>
                  <th>cht_code</th>
=======
                  <th>Type</th>
                  <th>Type Code</th>
                  <th>Item Code</th>
                  <th>Item Description</th>
                  <th>Transaction Date</th>
                  <th>Transaction Code</th>
                  <th>IN</th>
                  <th>OUT</th>
                  <th>Price</th>
                  <th>Supplier</th>
                  <th>Unit</th>
>>>>>>> a8e4aa4031104383d96db004e0dca404095b9e0c

                </tr>
                </thead>
                <tbody>
                 
                </tbody>
                <tfoot>
                <tr>
<<<<<<< HEAD
                  <th>trn_type_desc</th>
                  <th>trn_type</th>
                  <th>item_code</th>
                  <th>item_desc</th>
                  <th>trn_date</th>
                  <th>reference</th>
                  <th>qty_in</th>
                  <th>qty_out</th>
                  <th>price</th>
                  <th>supl_name</th>
                  <th>cht_code</th>
=======
                  <th>Type</th>
                  <th>Type Code</th>
                  <th>Item Code</th>
                  <th>Item Description</th>
                  <th>Transaction Date</th>
                  <th>Transaction Code</th>
                  <th>IN</th>
                  <th>OUT</th>
                  <th>Price</th>
                  <th>Supplier</th>
                  <th>Unit</th>

>>>>>>> a8e4aa4031104383d96db004e0dca404095b9e0c
                </tr>
                </tfoot>
              </table>
            </div>
            </div>
            <!-- /.box-body -->     
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
<<<<<<< HEAD
      <!-- /.row --> 
=======
      <!-- /.row -->
>>>>>>> a8e4aa4031104383d96db004e0dca404095b9e0c

    <script>
   // Fix modal scroll disabled.
    $('body').on('hidden.bs.modal', function () {
<<<<<<< HEAD
=======

>>>>>>> a8e4aa4031104383d96db004e0dca404095b9e0c
     if($('.modal.in').length > 0)
     {
         $('body').addClass('modal-open');
     }
     });
    // Fix modal scroll disabled.

      var selectedRow = 0;

    $(document).ready( function () {
    $('#tbl_itemlist').DataTable();
    } );


    $(document).ready(function() {
    // get selected row
    $('#tbl_itemlist tbody').on( 'click', 'tr', function () {
              var table = $('#tbl_itemlist').DataTable();
              selectedRow = table.row( this ).index() ;

              console.log('rowindex: '+selectedRow);
          } );
    } );

      $("#toggleModalSearch").click(function(){
        let stockLocation = $.trim($("[name=select_stocklocation]").val());
        let branch = $.trim($("[name=select_branch]").val());

<<<<<<< HEAD
        if(stockLocation == '' || branch == ''){
          $(this).removeAttr('data-target');
          alert("Please Select Stock Location and Branch first!");
        } else {
          $(this).attr('data-target','#itemsearch-modal');  
=======
        if(stockLocation == '' || branch == '')
        {
          $(this).removeAttr('data-target');
          alert("Please Select Stock Location and Branch first!");
        } else {
           $(this).attr('data-target','#itemsearch-modal');  
>>>>>>> a8e4aa4031104383d96db004e0dca404095b9e0c
           var table = $('#example1').DataTable(); 
           table.clear().draw();
          $.ajax({
            url: '{{url('/inventory/stocktransactcard')}}',
            method: 'POST',
            data: {_token: '{{csrf_token()}}', action: 'getSearch', stkLoc: stockLocation, branch: branch},
<<<<<<< HEAD
=======
            async: true,
            // beforeSend: function(){
            //   // Show image container
            //   $(".preloader").show();
            //  },
>>>>>>> a8e4aa4031104383d96db004e0dca404095b9e0c
            success: function (a){
              for (var i = 0; i < a.length; i++) {
                console.log(a[i]);
                table.row.add([
<<<<<<< HEAD
                  '<input type="radio" name="r3" onclick="EnterItem_Add('+Number(a[i]['item_code'])+',  \''+a[i]['part_no']+'\', \''+a[i]['item_desc']+'\', '+a[i]['sales_unit_id']+', '+a[i]['serial_no']+', '+a[i]['tag_no']+', '+a[i]['regular']+' )">',
=======
                  //'<input type="radio" name="r3" onclick="EnterItem_Add('+Number(a[i]['item_code'])+',  \''+a[i]['part_no']+'\', \''+a[i]['item_desc']+'\', '+a[i]['sales_unit_id']+', '+a[i]['serial_no']+', '+a[i]['tag_no']+', '+a[i]['regular']+' )">',
                  '<input type="radio" name="r3" onclick="EnterItem_Add('+Number(a[i]['item_code'])+', '+Number(a[i]['qty_onhand_su'])+')">',
>>>>>>> a8e4aa4031104383d96db004e0dca404095b9e0c
                  a[i]['item_code'],
                  a[i]['qty_onhand_su'],
                  a[i]['part_no'],
                  a[i]['serial_no'],
                  a[i]['tag_no'],
                  a[i]['item_desc'],
                  a[i]['sale_unit'],
                  a[i]['brd_name'],
                  a[i]['regular'],
                  a[i]['bin_loc'],
                  a[i]['grp_desc'],
                  a[i]['whs_desc'],
                  a[i]['branchname'],
                ]).draw();
              }
<<<<<<< HEAD
            }
          })       
          $("#itemsearch-modal").modal('show');
=======
            },
            complete:function(a){
              // Hide image container
              // $(".preloader").hide();
              $("#itemsearch-modal").modal('show');
            }
          })       
          //$("#itemsearch-modal").modal('show');
>>>>>>> a8e4aa4031104383d96db004e0dca404095b9e0c
        }
        });


<<<<<<< HEAD
      function EnterItem_Add(item_code, part_no, item_desc, sales_id, sNo, tag_no, regular){
        // clear();
        // console.log([item_code, part_no, item_desc, sales_id, sNo, tag_no, regular]);

        // var zero = "0000000000";
        // var n = zero.length;

        // var gg = zero+item_code;
        let lenghtOFIC = item_code.toString().length;
        if(lenghtOFIC < 10){

          let lack = (10 - item_code.toString().length);
          console.log(lack);
          // loop, add 0 on each loop to item_code
          // sample 0000437
          // make pointer go before the number
          // for (var i = "0"; i == lack; i++) {
          //  lack = lack + "0";
           console.log(lack);
          // }
        }

        for (let step = 0; step < 5; step++) {
  // Runs 5 times, with values of step 0 through 4.
  console.log('Walking east one step');
}

        $('[name=txt_itemcode]').val(item_code);
        $('[name=txt_itemdesc]').val(item_desc);
      }

      //  function EnterItem_Add(item_code, part_no, item_desc, sales_id, sNo, tag_no, regular, type){
      //   //var line = ($('#tbl_itemlist').DataTable().rows().count()) + 1;

      //   if(type == 'ITEM')
      //   {
      //     $('#ENTER_ITEM').text('Add');
      //     $('.AddMode').show();


      //     $('input[name="txt_itemcode"]').val(item_code);
      //     $('input[name="txt_itemdesc"]').val(item_desc);
      //   }else // TEXT ITEM
      //   {
      //     $('#ENTER_ITEM').text('Add Text');
      //     $('.AddModeText').show();


      //   }
      // }

=======
      function EnterItem_Add(item_code, qty_onhand_su){
        // clear();
        // console.log([item_code, part_no, item_desc, sales_id, sNo, tag_no, regular]);

        var zero = "0000000000";
        var n = zero.length;
        let lenghtOFIC = item_code.toString().length;

        var lack = n - item_code.toString().length;
        

        for (var i = 1; i <= 1; i++) {
          var gg = '';
          for (var j = 1; j <= lack; j++) {
             gg += '0';
          }
          var mm = gg+item_code
          console.log(mm);
        }

        $('[name=txt_itemcode_text]').val(mm);
        $('[name=txt_itemcode]').val(item_code);
        $('input[name="txt_qty_currnt_blnce"]').val(qty_onhand_su);
        // $('[name=txt_itemdesc]').val(item_desc);

         $.ajax({
            url: '{{asset('inventory/stockin/stockin_getitemdetails')}}/'+mm,
            method: 'GET',
            success : function(data)
                      {
                        $('input[name="txt_itemdesc"]').val(data[1]);
                        $('input[name="txt_qty_currnt_blnce"]').val(qty_onhand_su);                        
                      }
         });
      }

>>>>>>> a8e4aa4031104383d96db004e0dca404095b9e0c
      $("#AddItem").click(function(){
        let stockLocation = $.trim($("[name=select_stocklocation]").val());
        let item_code = $.trim($("[name=txt_itemcode]").val());
          // $(this).attr('data-target','#itemsearch-modal');  
           var table = $('#tbl_itemlist').DataTable(); 
           table.clear().draw();
          $.ajax({
            url: '{{url('/inventory/stocktransactcard')}}',
            method: 'POST',
            data: {_token: '{{csrf_token()}}', action: 'getLine', stkLoc: stockLocation, item_code: item_code},
            success: function (a){
              console.log(a);
              for (var i = 0; i < a.length; i++) {
                table.row.add([
                  a[i]['trn_type_desc'],
                  a[i]['trn_type'],
                  a[i]['item_code'],
                  a[i]['item_desc'],
                  a[i]['trnx_date'],
                  a[i]['reference'],
                  a[i]['qty_in'],
                  a[i]['qty_out'],
                  a[i]['price'],
                  a[i]['supl_name'],
                  a[i]['unit_shortcode' ],
                ]).draw();
              }
            }
          })      
        });

<<<<<<< HEAD
=======

      

>>>>>>> a8e4aa4031104383d96db004e0dca404095b9e0c
     

    </script>

    </section>
    <!-- /.content -->
  
@endsection 