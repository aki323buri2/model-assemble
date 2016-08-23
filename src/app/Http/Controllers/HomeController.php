<?php
namespace App\Http\Controllers;

use Route;
use View;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Base\Model;

class HomeController extends Controller 
{
	public static function routes()
	{
		Route::get('/', __CLASS__.'@home');
	}

	public function home(Request $request)
	{
		$columns = matrix(
			['name', 'type', 'bytes', 'title']
			, [
				['catno'  , 'string' , 10      , 'カタログＣＤ'], 
				['shcds'  , 'string' , 10      , 'ｼｮｸﾘｭｰＣＤ'], 
				['eoscd'  , 'string' , 15      , 'ＥＯＳＣＤ'], 
				['mekame' , 'string' , 20      , 'メーカー名'], 
				['shiren' , 'string' , 10      , '仕入先ＣＤ'], 
				['hinmei' , 'string' , 30      , '品名'], 
				['sanchi' , 'string' , 20      , '産地'], 
				['tenyou' , 'string' , 20      , '天・養'], 
				['nouka'  , 'float'  , [10, 2] , '納価'], 
				['baika'  , 'float'  , [10, 2] , '売価'], 
				['stanka' , 'float'  , [10, 2] , '仕入'], 
			]
			, 'name');

		$model = new Model(combine(
			$columns->keys()->all()
			, [
				'10194', 
				'94031', 
				'36151546', 
				'西脇水産', 
				'26960', 
				'輪島の醤油漬けと干物セット', 
				'その他', 
				'天然', 
				'3,613', 
				'5,184', 
				'3,100', 
			]
		));

		// $model->setColumns($columns);

		$model->catno = 'aaaaa';

		dump($model->nouka);

		return View::make('home');
	}
}