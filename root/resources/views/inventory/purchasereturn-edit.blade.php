@extends('_main')
@php
    $_bc = [
        ['link'=>'#','desc'=>'Inventory','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Purchase Return','icon'=>'none','st'=>false],
        ['link'=>'#','desc'=>'Edit','icon'=>'none','st'=>true],
    ];
    $_ch = "Purchase Return"; // Module Name
@endphp
@section('content')
		<!-- Content Header (Page header) -->
		@include('layout._contentheader')
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Purchase Return</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Purchase Invoice No</label>
                <input type="text" class="form-control" name="txt_code" value="{{$prethdr->pret_num}}" disabled="">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Invoice Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" class="form-control pull-right" id="datepicker" name="dtp_invoicedt" value="{{$prethdr->trnx_date}}">
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Stock Location</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_stocklocation">
                  @foreach($stock_loc as $st)
                  @if($prethdr->whs_code == $st->whs_code)
                  <option selected="selected" value="{{$st->whs_code}}">{{$st->whs_desc}}</option>
                  @else
                  <option value="{{$st->whs_code}}">{{$st->whs_desc}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Branch</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true", name="select_branch">
                  @foreach($branch as $b)
                  @if($prethdr->branch == $b->code)
                  <option selected = "selected" value="{{$b->code}}">{{$b->name}}</option>
                  @else
                  <option value="{{$b->code}}">{{$b->name}}</option>
                  @endif
                  @endforeach
                </select>              
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Supplier Name</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_supplier">
                  @foreach($supplier as $s)
                  @if($prethdr->supl_code == $s->c_code)
                  <option selected="selected" value="{{$s->c_code}}">{{$s->c_name}}</option>
                  @else
                  <option value="{{$s->c_code}}">{{$s->c_name}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Reference</label>
                <input type="text" class="form-control" name="txt_reference" value="{{$prethdr->reference}}">
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="row">
                <div class="col-sm-6">
                  <h3 class="box-title">Purchase item Details</h3>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemsearch-modal"><i class="fa fa-plus"></i> Add item</button>
                </div>
                <div class="col-sm-6">
                  <h5 class="box-title">Total amount:</h5>
                    &nbsp;<label><input type="text" name="txt_grandtotalamt" value="{{$grandtotal->grandtotal}}" readonly=""></label>
                </div>
              </div>


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
                              <th>Part No</th>
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
                              @foreach($disp_items as $di)
                            <tr>
                              <td><input type="radio" name="r3" onclick="EnterItem_Add('{{$di->item_code}}', '{{$di->part_no}}', '{{$di->item_desc}}', '{{$di->sales_unit_id}}', '{{$di->unit_cost}}')"></td>
                              <td>{{$di->item_code}}</td>
                              <td>{{$di->qty_onhand_su}}</td>
                              <td>{{$di->part_no}}</td>
                              <td>{{$di->item_desc}}</td>
                              <td>{{$di->sale_unit}}</td>
                              <td>{{$di->brd_name}}</td>
                              <td>{{$di->regular}}</td>
                              <td>{{$di->bin_loc}}</td>
                              <td>{{$di->grp_desc}}</td>
                              <td>{{$di->whs_desc}}</td>
                              <td>{{$di->branchname}}</td>
                            </tr>
                            @endforeach
                            </tfoot>
                          </table>
                          </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#enteritem-modal"><i class="fa fa-plus"></i> Add Item</button>
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
                  <th>Line</th>
                  <th>Part No</th>
                  <th>Item Code</th>
                  <th>Description</th>
                  <th>Qty</th>
                  <th>Unit Code</th>
                  <th>Unit Desc</th>
                  <th>Cost Price</th>
                  <th>Disc Amt</th>
                  <th>Line Amt</th>
                  <th>Net Price</th>
                  <th>Line Vat</th>
                  <th>Vat</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pretlne as $pl)
                <tr>  
                  <td>{{$pl->ln_num}}</td>
                  <td>{{$pl->part_no}}</td>
                  <td>{{$pl->item_code}}</td>
                  <td>{{$pl->item_desc}}</td>
                  <td>{{$pl->qty}}</td>
                  <td>{{$pl->unit_code}}</td>
                  <td>{{$pl->unit_desc}}</td>
                  <td>{{$pl->price}}</td>
                  <td>{{$pl->discount}}</td>
                  <td>{{$pl->ln_amnt}}</td>
                  <td>{{$pl->net_amnt}}</td>
                  <td>{{$pl->ln_vat}}</td>
                  <td>{{$pl->ln_vatamt}}</td>
                  <td><center><a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit({{$pl->ln_num}});"></i></a>&nbsp;<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete({{$pl->ln_num}});"></i></a></center>
                  </td>
                </tr>  
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Line</th>
                  <th>Part No</th>
                  <th>Item Code</th>
                  <th>Description</th>
                  <th>Qty</th>
                  <th>Unit Code</th>
                  <th>Unit Desc</th>
                  <th>Cost Price</th>
                  <th>Disc Amt</th>
                  <th>Line Amt</th>
                  <th>Net Price</th>
                  <th>Line Vat</th>
                  <th>Vat</th>
                  <th>Actions</th>
                </tr>
                </tfoot>
              </table>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group" style="display: flex;">
                <a href="{{route('inventory.pr')}}" class="btn btn-block btn-primary"><i class="fa fa-arrow-left"></i> Go Back</a>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group" style="display: flex;">
                <a class="btn btn-block btn-success" style="margin-top: 0;"  onclick="Save()"><i class="fa fa-save"></i> Save</a>
              </div>
            </div>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

       <!-- /.modal -->
       <!-- Enter Item Modal Form -->
              <div class="row">
              <div class="modal fade in" id="enteritem-modal">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                      <h4 class="modal-title"><span id="ENTER_ITEM"></span> Item</h4>
                    </div>
                    <div class="modal-body">
                      <form id="add-form">
                        <span class="AddMode EditMode">
                      <div class="box-body">
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Line No.</label>
                              <input type="text" class="form-control" name="txt_lineno" readonly="">
                            </div>
                          </div> 
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Item Code</label>
                              <input type="text" class="form-control" name="txt_itemcode" readonly="">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Part No.</label>
                              <input type="text" class="form-control" name="txt_partno" readonly="">
                            </div>
                          </div>                        
                        </div>
                        <div class="row">
                          <div class="col-sm-9">
                            <div class="form-group">
                              <label>Item Description</label>
                              <input type="text" class="form-control" name="txt_itemdesc" readonly=""> 
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Item Search</label>
                              <button class="btn btn-block btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#itemsearch-modal"><i class="fa fa-search"></i> Item Search</button>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-9">
                            <div class="form-group">
                              <label>VAT Type</label>
                              <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_vat" required="">
                                  <option value="" selected="selected">--- Select VAT ---</option>
                                  @foreach($vat as $v)
                                  <option value="{{$v->vat_code}}">{{$v->vat_desc}}</option>
                                  @endforeach
                                </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Quantity</label>
                                <input id="txt_qty" type="text" class="form-control" name="txt_qty" placeholder="0.00" required="">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Unit</label>
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="select_unit" required="">
                                  <option value="" selected="selected">--- Select Unit ---</option>
                                  @foreach($itemunit as $iu)
                                  <option value="{{$iu->unit_id}}">{{$iu->unit_shortcode}}</option>
                                  @endforeach
                                </select>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>Cost Price</label>
                               <input id="txt_cost" type="text" class="form-control" name="txt_cost" placeholder="0.00" required="">
                            </div>
                          </div>
                        </div>
                        <div class="row">                          
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Discount Amount</label>
                               <input id="txt_disc" type="text" class="form-control" name="txt_disc" placeholder="0.00">
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Line Amount</label>
                               <input type="text" class="form-control" name="txt_lineamt" placeholder="0.00">
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>VAT</label>
                               <input type="text" class="form-control" name="txt_vatamt" placeholder="0.00">
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label>Net Price</label>
                               <input type="text" class="form-control" name="txt_netprice" placeholder="0.00">
                            </div>
                          </div>
                        </div>
                        
                      </div>
                    </span>
                    <span class="DeleteMode">
                      <center>
                          <h4 class="text-transform: uppercase;">Are you sure you want to delete this item?
                          </h4>
                      </center>
                    </span>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <span class="AddMode EditMode">
                        <button type="button" class="btn btn-primary" onclick="set_tbl_itemlist()">Save</button>
                      </span>
                      <span class="DeleteMode">
                        <button type="button" class="btn btn-primary" onclick="set_tbl_itemlist()">Delete</button>
                      </span>
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              </div>
              <!-- End Modal -->
              <!-- Enter Item Modal Form -->

    <script>
      var selectedRow = 0;

      $(document).ready(function() {

      // get selected row
      $('#tbl_itemlist tbody').on( 'click', 'tr', function () {
                var table = $('#tbl_itemlist').DataTable();
                selectedRow = table.row( this ).index() ;

                console.log('rowindex: '+selectedRow);
            } );

      // modif datatable col
      $('#tbl_itemlist').DataTable( {
        "columnDefs": [
            {
                "targets": [ 5 ], // hide unit code col
                "visible": false,
                "searchable": false
            }
        ]
      } );

      } );

      // if input qty change
      $('#txt_qty').keyup(function(event)
      {
        disp_amt_result();
      });
      
      // if select vat qty change
      $('select[name="select_vat"]').change(function(event)
      {
        disp_amt_result();
      });
      
      // input disc change
      $('#txt_disc').keyup(function(event)
      {
        disp_amt_result();
      });

      // input cost price change
      $('#txt_cost').keyup(function(event)
      {
        disp_amt_result();
      })

      function EnterItem_Add(code, part_no, item_desc, unit, cost_price)
      {
        clear();
        $('#ENTER_ITEM').text('Add');
        $('.AddMode').show();
        $('.DeleteMode').hide();
        
        var line = ($('#tbl_itemlist').DataTable().rows().count()) + 1;

        $('input[name="txt_lineno"]').val(line);
        $('input[name="txt_itemcode"]').val(code);
        $('input[name="txt_partno"]').val(part_no);
        $('input[name="txt_itemdesc"]').val(item_desc);
        $('input[name="txt_cost"]').val(cost_price);
        $('select[name="select_unit"]').val(unit).trigger('change');
      }

      function EnterItem_Edit(line)
      {
          $('#ENTER_ITEM').text('Edit');
          $('.EditMode').show();
          $('.DeleteMode').hide();

          var table = $('#tbl_itemlist').DataTable();
          var row = line - 1;
          var data = table.row(row).data(); // get data of the selected row.
          
          $('input[name="txt_lineno"]').val(data[0]);
          $('input[name="txt_partno"]').val(data[1]);
          $('input[name="txt_itemcode"]').val(data[2]);
          $('input[name="txt_itemdesc"]').val(data[3]);
          $('input[name="txt_qty"]').val(data[4]);
          $('select[name="select_unit"]').val(data[5]).trigger('change');
          $('input[name="txt_cost"]').val(data[7]);
          $('input[name="txt_disc"]').val(data[8]);
          $('input[name="txt_lineamt"]').val(data[9]);
          $('input[name="txt_netprice"]').val(data[10]);
          $('select[name="select_vat"]').val(data[11]).trigger('change');
          $('input[name="txt_vatamt"]').val(data[12]);

          $('#enteritem-modal').modal('toggle');
          console.log('editline: ' + selectedRow);
      }

      function EnterItem_Delete(line)
      {
        $('#ENTER_ITEM').text('Delete');
        $('.AddMode').hide();
        $('.EditMode').hide();
        $('.DeleteMode').show();

        $('#enteritem-modal').modal('toggle');
      }

      function set_tbl_itemlist()
      {
        var table = $('#tbl_itemlist').DataTable();

        var line = $('input[name="txt_lineno"]').val();
        var item_code = $('input[name="txt_itemcode"]').val();
        var part_no = $('input[name="txt_partno"]').val();
        var item_desc = $('input[name="txt_itemdesc"]').val();
        var qty = $('input[name="txt_qty"]').val();
        var unit_code = $('select[name="select_unit"]').select2('data')[0].id;
        var unit_desc = $('select[name="select_unit"]').select2('data')[0].text;
        var cost_price = $('input[name="txt_cost"]').val();
        var disc_amnt = $('input[name="txt_disc"]').val();
        var line_amnt = $('input[name="txt_lineamt"]').val();
        var net_price = $('input[name="txt_netprice"]').val();
        var line_vat = $('select[name="select_vat"]').select2('data')[0].id;
        var vat_amt = $('input[name="txt_vatamt"]').val(); 
        
        var buttons = '<center>' +
              '<a class="btn btn-social-icon btn-warning"><i class="fa fa-pencil" onclick="EnterItem_Edit( \''+line+'\');"></i></a>&nbsp;' +
                            '<a class="btn btn-social-icon btn-danger"><i class="fa fa-trash" onclick="EnterItem_Delete(\''+line+'\');"></i></a>' +
            '</center>';

        if($('#ENTER_ITEM').text() == 'Add') // add item
        {

        table.row.add([line, part_no, item_code, item_desc, qty, unit_code, unit_desc, cost_price, disc_amnt, line_amnt, net_price, line_vat, vat_amt, buttons]).draw();

        }
        else if($('#ENTER_ITEM').text() == 'Edit') // edit item
        {
          table.row(selectedRow).data([line, part_no, item_code, item_desc, qty, unit_code, unit_desc, cost_price, disc_amnt, line_amnt, net_price, line_vat, vat_amt, buttons]).draw();
        }
        else // remove item
        {
          table.row(selectedRow).remove().draw();
          alert('Successfully deleted.');
        }

        total_amount();

        $('#enteritem-modal').modal('toggle');
        clear();
      }

      function disp_amt_result()
      {
        var total_costamt = 0.00, net_amt = 0.00, qty = 0.00, costprice = 0.00, disc_amt = 0.00, ln_amt = 0.00;

        qty = $('input[name="txt_qty"]').val();
        costprice = $('input[name="txt_cost"]').val();
        
        if($('input[name="txt_disc"]').val() != null)
        {
          disc_amt = $('input[name="txt_disc"]').val();
        }

        total_costamt = qty * costprice;

        ln_amt = parseFloat(total_costamt - disc_amt).toFixed(2);

        $('input[name="txt_lineamt"]').val(ln_amt);
        $('input[name="txt_disc"]').val(disc_amt);

        disp_vat(ln_amt);
      }

      function disp_vat(total_amt)
      {
        var vat_amt = 0.00, net_amt = 0.00;
        var tax_type = $('select[name="select_vat"]').select2('data')[0].id;

        if(tax_type == 'I')
        {
            net_amt = parseFloat(total_amt / 1.12).toFixed(2);
            vat_amt = parseFloat(total_amt - net_amt).toFixed(2);

            $('input[name="txt_netprice"]').val(net_amt);
            $('input[name="txt_vatamt"]').val(vat_amt);
        }
        else if(tax_type == 'E')
        {
            net_amt = parseFloat(total_amt).toFixed(2);
            total_amt = parseFloat(total_amt * 1.12).toFixed(2);
            vat_amt = parseFloat(total_amt - net_amt).toFixed(2);

            $('input[name="txt_lineamt"]').val(total_amt);
            $('input[name="txt_netprice"]').val(net_amt);
            $('input[name="txt_vatamt"]').val(vat_amt);
        }
        else
        {
            net_amt = parseFloat(total_amt).toFixed(2);
            vat_amt = parseFloat(vat_amt).toFixed(2);

            $('input[name="txt_netprice"]').val(net_amt);
            $('input[name="txt_vatamt"]').val(vat_amt);
        }
      }

      function clear()
      {
        $('input[name="txt_lineno"]').val('');
        $('input[name="txt_itemcode"]').val('');
        $('input[name="txt_partno"]').val('');
        $('input[name="txt_itemdesc"]').val('');
        $('select[name="select_vat"]').val('').trigger('change');
        $('input[name="txt_qty"]').val('0');
        $('select[name="select_unit"]').val('').trigger('change');
        $('input[name="txt_cost"]').val('0.00');
        $('input[name="txt_disc"]').val('0.00');
        $('input[name="txt_lineamt"]').val('0.00');
        $('input[name="txt_vatamt"]').val('0.00');
        $('input[name="txt_netprice"]').val('0.00');

      }

      function Save()
      {
        var tbl_itemlist = $('#tbl_itemlist').DataTable();
        var tbl_itemdata = tbl_itemlist.data().toArray(); // tbl_itemlist data

        var rec_num = $('input[name="txt_code"]').val();

        var data = { 
                      _token : $('meta[name="csrf-token"]').attr('content'),
                      tbl_itemlist: tbl_itemdata,
                      invoicedt: $('input[name="dtp_invoicedt"]').val(),
                      stock_loc: $('select[name="select_stocklocation"]').select2('data')[0].id,
                      branch: $('select[name="select_branch"]').select2('data')[0].id,
                      supl_code: $('select[name="select_supplier"]').select2('data')[0].id,
                      supl_name: $('select[name="select_supplier"]').select2('data')[0].text,
                      reference: $('input[name="txt_reference"]').val(),
                   };

           $.ajax({
                  url: '{{asset('inventory/purchasereturn/edit')}}/'+rec_num,
                  method: 'POST',
                  data: data,
                  success : function(flag)
                           {
                              if(flag)
                              {
                                console.log(flag);
                                location.href= "{{route('inventory.pr')}}";
                              }
                              else
                              {
                                alert('ERROR in saving.');
                              }
                           }
                  });
      }

      function total_amount()
      {
        var total_amt = 0.00;
        var tbl_itemlist = $('#tbl_itemlist').DataTable();
        var tbl_itemdata = tbl_itemlist.data().toArray(); //get all data of the table itemlist

        // foreach total amount
        $.each(tbl_itemdata, function(){
          total_amt += parseFloat(this[9]);
        });

        $('input[name="txt_grandtotalamt"]').val(total_amt.toFixed(2));

      }

    </script>

    </section>
    <!-- /.content -->
	
@endsection