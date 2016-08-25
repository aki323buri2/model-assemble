@extends('layouts/master')
@section('title', 'Home')
<?php
$links = array_merge((array)@$links, [
	'/vendor/handsontable/dist/handsontable.full.js',
	'/vendor/handsontable/dist/handsontable.full.css' 
]);

$columns = $catalog->getColumns();
?>
@section('main')
<p>
	Home?
</p>

<div id="validate"></div>

<div id="hot"></div>

@endsection

@push('scripts-after')
<script>
$(function ()
{
	var validate = $('#validate');
	var hot = handson($('#hot'));

	hot.selectCell(0, 0);

	$(hot.rootElement).on('hot.validate', function (e, data)
	{
		$.ajax({url: '/home/validate'
			, type: 'post'
			, data: { data: data }
		})
		.done(function (data)
		{
			validate.html(data);
		})
		;
	});

	var cache = [];
	@foreach ($cache as $object)
		(function ()
		{
			var object = {};
			@foreach ($object as $name => $value)
				object['{{ $name }}'] = '{{ $value }}';
			@endforeach
			cache.push(object);
		})();
	@endforeach
	if (cache.length)
	{
		hot.updateSettings({data: cache});
		$(hot.rootElement).trigger('hot.validate', [hot2json(hot)]);
	}
});
function handson(div)
{
	var hot = div.handsontable({
		columns: columns()
		, rowHeaders: true
		, afterChange: afterChange
	});

	return hot.handsontable('getInstance');
}
function columns()
{
	columns = [];
	@foreach ($columns as $column)
		(function ()
		{
			var column = {};
			column.data  = '{{ $column->name  }}';
			column.title = '{{ $column->title }}';
			@if(in_array($column->type, ['int', 'integer', 'real', 'float', 'double']))
				column.type = 'numeric';
			@endif
			columns.push(column);
		})();
	@endforeach
	return columns;
}
function afterChange(changes, source)
{
	var excepts = ['loadData'];
	var check = excepts.indexOf(source) < 0;
	if (!check) return;

	var data = hot2json(this);

	$(this.rootElement).trigger('hot.validate', [data]);
}
function hot2json(hot)
{
	var data = hot.getData();

	var props = [];
	for (var i = 0; i < hot.countCols(); i++)
	{
		props.push(hot.colToProp(i));
	}

	var objects = [];
	
	$.each(data, function (index, array)
	{
		var object = {};
		
		$.each(props, function (index, prop)
		{
			var value = array[index];
			object[prop] = value;
		});

		objects.push(object);
	});

	return objects;
}
</script>
@endpush