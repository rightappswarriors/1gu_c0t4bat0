<div class="box box-default collapsed-box">
  <div class="box-header with-border">
    <h3 class="box-title">Options</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>

    </div>
  </div>
<!-- /.box-header -->
  <div class="box-body" style="display: none">
    <form id="PerFundCheck" data-parsley-validate="" novalidate="">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <span id="sel_fy_span"></span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <span id="sel_fid_span"></span>
          </div>
        </div>
      <div class="col-md-2">
      <div class="form-group">
      <center><label>&nbsp;</label></center>
      <button type="button" class="btn btn-block btn-primary" onclick="newBudgetEntry()"><i class="fa fa-plus"></i> New Collection Entry</button>
      </div>
      </div>
      <div class="col-sm-2">
      <div class="form-group">
      <center><label>&nbsp;</label></center>
      <button type="button" class="btn btn-block btn-info"><i class="fa fa-print"></i> Print</button>
      </div>
      </div>
      <div class="col-sm-2" style="display: none">
      <div class="form-group">
      <center><label>&nbsp;</label></center>
      <button type="button" class="btn btn-block btn-default" data-toggle="modal" data-target="#modal-default2"><i class="fa fa-upload"></i> Import</button>
      </div>
      </div>
      </div>
    </form>
  <!-- /.row -->
  </div>
<!-- /.box-body -->
</div>