@extends('layouts/sidebar')
@section('title', 'Home')
<?php
$links = array_merge((array)@$links, [
 	'vendor/lightbox2/dist/js/lightbox.js',
 	'vendor/lightbox2/dist/css/lightbox.css',
]);
$columns = $catalog->getColumns();

$data = $cache;

?>

@push('styles')
<style>
#table1 th 
{
	text-align: center;
}
#table1 i.fa
{
	font-size: 1.5rem;
}
#table1 .console
{
	width: 30rem;
}
#table1 tbody td.nouka, 
#table1 tbody td.baika, 
#table1 tbody td.stanka
{
	text-align: right;
}
#table1 tbody td.catno
{
	cursor: pointer;
}
</style>
@endpush

@section('main')

<p>
	<a href="/vuevue">vuevue</a>
</p>

<div class="modal fade" id="modal1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			
			<div class="modal-body">
			
			<div id="card"></div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">
					Close
				</button>
				<button type="button" class="btn btn-primary">
					Save changes
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$(function ()
{
	var modal = $('#modal1').on('shown.bs.modal', function ()
	{
		var el = $(this).find('.catno input').select();
		console.log(el.val());
	});
	// modal.modal('show');
});
</script>
</script>

</script>

<table class="table table-sm table-bordered" id="table1">
	<thead>
		<tr>
			<th class="no">#</th>

			@foreach ($columns as $column)
			<th
				class="{{ $column->name }}"
				data-name="{{ $column->name }}"
				data-title="{{ $column->title }}"
			>
				{{ $column->title }}
			</th>
			@endforeach

			<th class="console"><i class="fa fa-cog"></i></th>
		</tr>
	</thead>
	<?php $no = 0?>
	<tbody>
	
		@foreach ($data as $row)
			<tr
			data-catno="{{ $row->catno }}"
			>
				<th scope="row">{{ ++$no }}</th>

				@foreach ($columns as $name => $column)
					<?php $value = @$row->$name?>
					<td
					class="{{ $name }}"
					data-name="{{ $name }}"
					data-value="{{ $value }}"
					>
					{{ $value }}
					</td>
				@endforeach 

				<td class="console">	
				</td>
			</tr>
		@endforeach
	
	</tbody>
</table>

@endsection

@push('scripts-after')
<script>
$(function ()
{
	$('#table1 tbody td.catno').on('click', function (e)
	{
		var $this = $(this);
		var tr = $this.closest('tr');
		var catno = tr.data('catno');

		$.ajax({
			url: '/home/card'
			, data: {catno: catno}
		})
		.done(function (data)
		{
			var html = $(data).find('#card1');

			var card = $('#card');
			card.empty().append(html);

			$('[data-toggle=tooltip]').tooltip();

			$('#modal1').modal('show');
		})
		;
	});
});
</script>
@endpush
@push('styles')
<style>
#modal1 .modal-content
{
	width: 50rem;
}
#card1
{
	margin: 0 auto;

	margin-bottom: 5rem;
}
#card1 img.card-img-top
{
	width: 95%;
	margin: 2.5%;
}
</style>
@endpush
