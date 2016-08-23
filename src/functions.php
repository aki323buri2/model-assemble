<?php
function dump($value)
{
	echo "<pre>\n";
	var_dump($value);
	echo "</pre>\n";
}
function extname($path)
{
	return preg_match('/[.][^.]+$/', $path, $match) ? $match[0] : '';
}
function extname_without_dot($path)
{
	return preg_replace('/^[.]/', '', extname($path));
}
function combine($names, $values)
{
	$names = collect((array)$names);
	$values = collect((array)$values);
	$length = $names->count();
	$values = $values->merge(array_fill(0, $length, null))->slice(0, $length);
	return $names->combine($values);
}
function matrix($names, $values, $keyBy = null)
{
	$matrix = collect();
	foreach ($values as $values)
	{
		$matrix->push((object)combine($names, $values)->all());
	}
	return is_null($keyBy) ? $matrix : $matrix->keyBy($keyBy);
}