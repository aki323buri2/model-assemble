@extends('layouts/master')
@section('title', 'Card')
<?php
$columns = $catalog->getColumns()->all();
?>
@push('styles')
<style>
#card1
{
	margin: 0 auto;
	margin-top: 3rem;
	width: 50rem;
}
#card1 > img.card-img-top
{
	width: 49rem;
	margin: .5rem;
}
#card1  #form1
{
	margin-top: 2rem;
}
</style>
@endpush
@push('scripts')
<script>
$(function ()
{
	$('[data-toggle=tooltip]').tooltip();
});
</script>
@endpush

@section('main')

<div class="container">
	
<div class="card" id="card1">
	<img class="card-img-top" 
		src="http://ad-design.966v.com/static_images/20160805/4be415001b92c4aa2c9c2b015a1de4e05600d8c526fcd5468c78fd72.jpg"
		alt="Card image cap">
	<div class="card-block">
		<h4 class="card-title">Card title</h4>
		<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
		<a href="#" class="btn btn-primary">Go somewhere</a>

		<form id="form1">
			@foreach ($columns as $name => $column)
				<?php $title = $column->title?>
				<div class="form-group row">
					<label for="{{ $name }}" class="col-sm-3 col-form-label"
						data-toggle="tooltip"
						data-placement="left"
						title="{{ $name }}"
					>
						{{ $title }}
					</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="{{ $name }}"
							placeholder="{{ $title }}"
							value="{{ $catalog->$name }}"
						>
					</div>
				</div>
			@endforeach
			
			<div class="form-group row">
				<div class="offset-sm-3 col-sm-9">
					<button type="submit" class="btn btn-primary">
						Save this
						<i class="fa fa-thumbs-up"></i>
					</button>
				</div>
			</div>
		</form>

		<form id="form2">
			<div class="form-group row">
				<label for="email1" class="col-sm-2 col-form-label">Email</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="email1" placeholder="Email">
				</div>
			</div>
			<div class="form-group row">
				<label for="password1" class="col-sm-2 col-form-label">Password</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="password1" placeholder="Password">
				</div>
			</div>
			<fieldset class="form-group row">
				<legend class="col-form-legend col-sm-2">Radios</legend>
				<div class="col-sm-10">
					<div class="form-check">
						<label class="custom-control custom-radio">
							<input id="radio1" name="radio" type="radio" class="custom-control-input">
							<span class="custom-control-indicator"></span>
							<span class="custom-control-description">
								Toggle this custom radio
							</span>
					</div>
					<div class="form-check">
						</label>
						<label class="custom-control custom-radio">
							<input id="radio2" name="radio" type="radio" class="custom-control-input">
							<span class="custom-control-indicator"></span>
							<span class="custom-control-description">
								Or toggle this other custom radio
							</span>
						</label>
					</div>
					<div class="form-check disabled">
						</label>
						<label class="custom-control custom-radio">
							<input id="radio2" name="radio" type="radio" class="custom-control-input" disabled>
							<span class="custom-control-indicator"></span>
							<span class="custom-control-description">
								Option three is disabled
							</span>
						</label>
					</div>
				</div>
			</fieldset>
			<div class="form-group row">
				<label class="col-sm-2">Checkbox</label>
				<div class="col-sm-10">
					<div class="form-check">
						<label class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="check1">
							<span class="custom-control-indicator"></span>
							<span class="custom-control-description">
								Check this custom checkbox
							</span>
						</label>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="offset-sm-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Sign in</button>
				</div>
			</div>
		</form>
		
	</div>
</div>

</div>

@endsection