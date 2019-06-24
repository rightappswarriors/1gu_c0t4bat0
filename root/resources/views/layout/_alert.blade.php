@if(Session::has('alert'))
<div class="alert alert-{{Session::get('alert')[1]}} alert-dismissible " id="alert">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<label><b><i class="icon fa fa-ban"></i> {{Session::get('alert')[0]}}!</b> {{Session::get('alert')[2]}}</label>
</div>
@endif