<?php
namespace App\Base;

use ArrayAccess;
use IteratorAggregate;
use Illuminate\Support\Collection;

class Model implements ArrayAccess, IteratorAggregate
{
	protected $columns;
	protected $original;
	protected $attributes;

	public function __construct($attributes = null)
	{
		$this->setColumns();
		$this->setOriginal();
		$this->setAttributes($attributes);
		$this->syncOriginal();
	}
	public function setColumns($columns = null)
	{
		return $this->setCollection($this->columns, $columns);
	}
	public function setOriginal($original = null)
	{
		return $this->setCollection($this->original, $original);
	}
	public function setAttributes($attributes = null)
	{
		return $this->setCollection($this->attributes, $attributes);
	}
	public function setCollection(&$target, $collection)
	{
		if (is_null($target))
		{
			$target = new Collection;
		}
		else
		{
			$target = collect($collection);
		}

		return $this;
	}
	public function syncOriginal()
	{
		// Deep copy
		$this->original = new Collection($this->attributes->all());
	}

	// getter & setter 
	public function getColumns($key = null)
	{
		return $this->getCollection($this->columns, $key);
	}
	public function getOriginal($key = null)
	{
		return $this->getCollection($this->original, $key);
	}
	public function getAttributes($key = null)
	{
		return $this->getCollection($this->attributes, $key);
	}
	public function setAttributesValue($key, $value)
	{
		return $this->setCollectionValue($this->attributes, $key, $value);
	}
	public function getCollection($collection, $key = null)
	{
		return $this->getCollectionValue($collection, $key);
	}
	public function getCollectionValue($collection, $key)
	{
		if (is_null($key)) return $collection;

		return $this->castValue($key, $collection->get($key));
	}
	public function setCollectionValue($collection, $key, $value)
	{
		return $collection->put($key, $value);
	}

	// cast value
	public function castValue($key, $value)
	{
		$type = $this->getType($key);
		
		switch ($type)
		{
			case 'int': 
			case 'integer': 
				return (int)preg_replace('/[,]([0-9]{3})/', '$1', $value);
			case 'real': 
			case 'float': 
			case 'double': 
				return (float)preg_replace('/[,]([0-9]{3})/', '$1', $value);
			case 'bool': 
			case 'boolean': 
				return (bool)$value;
			case 'string': 
				return (string)$value;
			default: 
				return $value;
		}
	}
	public function getType($key)
	{
		$column = $this->columns->get($key);

		if (is_null($column)) return null;

		return property_exists($column, 'type') ? $column->type : @$column['type'];
	}


	// determin isDirty
	public function getDirty()
	{
		$dirty = new Collection();

		foreach ($this as $key => $value)
		{
			$changed = false;

			if (!$this->original->has($key))
			{
				$changed = true;
			}
			else if ($value !== $this->getOriginal($key))
			{
				$changed = true;
			}

			if ($changed) $dirty->put($key, $value);
		}

		return $dirty;
	}
	public function isDirty()
	{
		return getDirty()->count() > 0;
	}


	//==============================================
	// object like accessor
	//==============================================
	public function __get($key)
	{
		return $this->getAttributes($key);
	}
	public function __set($key, $value)
	{
		return $this->setAttributesValue($key, $value);
	}
	//==============================================
	// implement abstract methods: 
	//==============================================
	// for ArrayAccess
	public function offsetExists($offset)
	{
		return isset($this->$offset);
	}
	public function offsetGet($offset)
	{
		return $this->$offset;
	}
	public function offsetSet($offset, $value)
	{
		return $this->$offset = $value;
	}
	public function offsetUnset($offset)
	{
		unset($this->$offset);
	}
	// for IteratorAggregate
	public function getIterator()
	{
		foreach ($this->attributes as $name => $value)
		{
			yield $name => $this->$name;
		}
	}
}