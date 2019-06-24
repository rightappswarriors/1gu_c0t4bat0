{{--
	*How to use the breadcrumb *
	$_bc contains the following indexes:
	link, desc, icon, st
	example: ['link'=>#,'desc'=>'SampleText','st'=>false,'icon'=>'dashboard']

	This blade is already included on _contentheader blade (root/resrouces/views/layout).

	-Configuration Note:
	If you want the breadcrumb to be active, set 'st' to true.
	If you want to breadcrumb to have no icon set 'icon' it to 'none'.

	(c)By Paolo
 --}}
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
    @if(!empty($_bc))
    @foreach($_bc as $bc)
    <li {!!($bc['st']==true) ? 'class="active"' : ""!!}><a href="{!!$bc['link']!!}">{!!($bc['icon']!='none') ? '<i class="fa fa-'.$bc['icon'].'"></i>' : ""!!} {{$bc['desc']}}</a></li>
    @endforeach
    @endif
</ol>