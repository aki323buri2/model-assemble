<?php
require_once __DIR__.'/../vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\Facade;

class Application extends Container
{
	protected $basePath;

	public function basePath()
	{
		return $this->basePath;
	}

	public function __construct()
	{
		static::setInstance($this);
		$this->instance('app', $this);
		$this->instance('container', $this);

		$this->basePath = realpath(__DIR__.'/..');

		// configuration
		$this->instance('config', new Fluent);
		$this['config']['view.paths'] = [__DIR__.'/../src/views'];
		$this['config']['view.compiled'] = __DIR__.'/../storage/view/compiled';

		// register & boot providers
		$providers = [
			Illuminate\Events\EventServiceProvider::class, 
			Illuminate\Routing\RoutingServiceProvider::class, 
			Illuminate\Filesystem\FilesystemServiceProvider::class, 
			Illuminate\View\ViewServiceProvider::class, 
		];
		foreach ($providers as $provider)
		{
			($registered[] = new $provider($this->container))->register();
		}
		/*
		foreach ((array)@$registered as $provider)
		{
			$provider->boot();
		}
		*/

		// Facades
		$facades = [
			'App' => Illuminate\Support\Facades\App::class, 
			'Route' => Illuminate\Support\Facades\Route::class, 
			'View' => Illuminate\Support\Facades\View::class, 
			'Config' => Illuminate\Support\Facades\Config::class, 
			'Request' => Illuminate\Support\Facades\Request::class, 
			'Resonse' => Illuminate\Support\Facades\Resonse::class, 
			'Input' => Illuminate\Support\Facades\Input::class, 
		];
		Facade::setFacadeApplication($this);
		spl_autoload_register(function ($alias) use ($facades)
		{
			$abstract = @$facades[$alias];
			if (isset($abstract)) return class_alias($abstract, $alias);
		}, true, true);

		// Aliases 
		$aliases = [
			'request' => [Illuminate\Http\Request::class], 
		];
		foreach ($aliases as $alias => $abstracts)
		{
			foreach ($abstracts as $abstract)
			{
				$this->alias($alias, $abstract);
			}
		}
	}

	public function dispatch()
	{
		$this->instance('request' , $request  = Illuminate\Http\Request::capture());
		$this->instance('response', $response = Route::dispatch($request));
		$response->send();
	}
}

$application = new Application;

require __DIR__.'/../src/routes.php';

$application->dispatch();