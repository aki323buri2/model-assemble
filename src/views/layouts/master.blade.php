<?php
$links = collect(array_merge([

	'/vendor/jquery/dist/jquery.js', 
	'/vendor/jquery-ui/jquery-ui.js', 
	'/vendor/font-awesome/css/font-awesome.css', 
	'/vendor/tether/dist/js/tether.js', 
	'/vendor/bootstrap/dist/js/bootstrap.js',

	'/vendor/jquery-ui/themes/base/jquery-ui.css', 

	// '/vendor/bootstrap/dist/css/bootstrap.css', 
	'/build/bootstrap/dist/css/bootstrap-custom.css', 

], (array)@$links))->groupBy(function ($url)
{
	return extname_without_dot($url);

})->toArray();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@yield('title')</title>
@foreach ((array)@$links['css'] as $url)
	<link rel="stylesheet" href="{{ $url }}">
@endforeach 
@foreach ((array)@$links['js'] as $url)
	<script src="{{ $url }}"></script>
@endforeach 
<style>
#topbar
{
	margin-bottom: 1rem;
}
#sidebar
{
	float: left;
	width: 20rem;
}
#main
{
	margin-left: 21rem;
}
</style>
@stack('styles')
@stack('scripts')
</head>
<body>

<div id="topbar">
	<nav class="navbar navbar-light bg-faded">
	  <a class="navbar-brand" href="#">Navbar</a>
	  <ul class="nav navbar-nav">
	    <li class="nav-item active">
	      <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
	    </li>
	    <li class="nav-item">
	      <a class="nav-link" href="#">Features</a>
	    </li>
	    <li class="nav-item">
	      <a class="nav-link" href="#">Pricing</a>
	    </li>
	    <li class="nav-item">
	      <a class="nav-link" href="#">About</a>
	    </li>
	  </ul>
	  <form class="form-inline pull-xs-right">
	    <input class="form-control" type="text" placeholder="Search">
	    <button class="btn btn-outline-success" type="submit">Search</button>
	  </form>
	</nav>
</div>
<div id="sidebar">
	<div class="list-group">
	  <a href="#" class="list-group-item active">
	  	<span class="tag tag-danger tag-pill pull-xs-right">2</span>
	    Cras justo odio
	  </a>
	  <a href="#" class="list-group-item list-group-item-action">
	  	<span class="tag tag-success tag-pill pull-xs-right">5</span>
	  	Dapibus ac facilisis in
	  </a>
	  <a href="#" class="list-group-item list-group-item-action">
	  	<span class="tag tag-warning tag-pill pull-xs-right">1</span>
	  	Morbi leo risus
	  </a>
	  <a href="#" class="list-group-item list-group-item-action">
	  	<span class="tag tag-default tag-pill pull-xs-right">2</span>
	  	Porta ac consectetur ac
	  </a>
	  <a href="#" class="list-group-item list-group-item-action disabled">
	  	Vestibulum at eros
	  </a>
	</div>
</div>
<div id="main">
	@yield('main')
</div>

@stack('scripts-after')
</body>
</html>