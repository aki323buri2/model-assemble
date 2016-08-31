<?php
namespace App;

use App;
use App\Base\Model;

class Catalog extends Model 
{
	protected $storePath;
	protected $cachePath;
	protected $keyName = 'id';

	public function __construct($attributes = null)
	{
		parent::__construct($attributes);

		$this->storePath = App::basePath().'/storage/catalog.json';
		$this->cachePath = App::basePath().'/storage/cache.json';
		
		$this->setColumns(matrix(
			['name', 'type', 'size', 'title']
			, [
				['catno'  , 'string' , 15     , 'カタログＣＤ'], 
				['shcds'  , 'string' , 10     , 'ｼｮｸﾘｭｰＣＤ'], 
				['eoscd'  , 'string' , 20     , 'ＥＯＳＣＤ'], 
				['mekame' , 'string' , 50     , 'メーカー名'], 
				['shiren' , 'string' , 10     , '仕入先ＣＤ'], 
				['hinmei' , 'string' , 100    , '品名'], 
				['sanchi' , 'string' , 80     , '産地'], 
				['tenyou' , 'string' , 50     , '天・養'], 
				['nouka'  , 'float'  , [10,2] , '納価'], 
				['baika'  , 'float'  , [10,2] , '売価'], 
				['stanka' , 'float'  , [10,2] , '仕入'], 
			]
			, 'name')
		);

		$this->keyName = $this->columns->keys()[0];
	}
	public function all()
	{
		$path = $this->storePath;
		$path = $this->cachePath;
		$load = json_decode(file_get_contents($path));
		foreach ($load as $that)
		{
			$add = new static($that);
			$all[] = $add;
		}
		return collect($all);
	}
	
	public function find($keyValue)
	{
		$all = $this->all();
		$keyName = $this->keyName;
		$filter = $all->filter(function ($item, $index) use ($keyName, $keyValue)
		{
			return $item->$keyName === $keyValue;
		});

		return $filter;
	}

	public function storePath() 
	{
		return $this->storePath;
	}
	public function cachePath() 
	{
		return $this->cachePath;
	}
}