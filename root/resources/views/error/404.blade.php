@extends('_main')

@section('content')
<div class="content">
	<p>404 - Page Not Found.</p>
	<a href="{{URL::current()}}">{{URL::current()}}</a>
</div>
@stop