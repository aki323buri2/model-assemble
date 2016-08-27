<?php
namespace App\Http\Controllers;

use App;
use View;
use Route;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Catalog;

class HomeController extends Controller 
{
	public static function routes()
	{
		Route::get('/', __CLASS__.'@index');
		Route::get('/home', __CLASS__.'@index');
		Route::post('/home/validate', __CLASS__.'@validate');
	}

	protected $catalog;

	protected $cachePath;

	public function __construct()
	{
		$this->catalog = new Catalog;

		$this->cachePath = App::basePath().'/storage/cache.json';
	}

	public function load_cache()
	{
		if (file_exists($this->cachePath))
		{
			$cache = json_decode(file_get_contents($this->cachePath));
		}
		else 
		{
			$cache = [];
		}
		return $cache;
	}

	public function index(Request $request)
	{
		return View::make('home', [
			'catalog' => $this->catalog, 
			'cache'   => $this->load_cache(), 
		]);
	}
	public function validate(Request $request)
	{
		$data = $request->input('data');

		return View::make('validate', [
			'catalog' => $this->catalog, 
			'data' => $data, 
		]);
	}
}