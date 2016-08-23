<?php
require_once __DIR__.'/../vendor/autoload.php';

use Illuminate\Support\Traits\CapsuleManagerTrait;
use Illuminate\Support\Facades\Facade;
use Illuminate\Container\Container;

class Application 
{
	use CapsuleManagerTrait;

	public function __construct(Container $container = null)
	{
		$this->setupContainer($container ?: new Container);

		// configiration
		$this->container['config']['view.paths'] = [__DIR__.'/../src/views'];
		$this->container['config']['view.compiled'] = __DIR__.'/../storage/view/compiled';

		// providers register & boot
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
		foreach ((array)@$registered as $provider)
		{
			$provider->boot();
		}

		// Facades
		$this->container->instance('app', $this->container);

		$facades = [
			'App' => Illuminate\Support\Facades\App::class, 
			'Route' => Illuminate\Support\Facades\Route::class, 
			'View' => Illuminate\Support\Facades\View::class, 
			'Config' => Illuminate\Support\Facades\Config::class, 
			'Request' => Illuminate\Support\Facades\Request::class, 
			'Response' => Illuminate\Support\Facades\Response::class, 
			'Input' => Illuminate\Support\Facades\Input::class, 
		];
		Facade::setFacadeApplication($this->container);
		spl_autoload_register(function ($alias) use ($facades)
		{
			$abstract = @$facades[$alias];
			if (isset($abstract)) return class_alias($abstract, $alias);
		}, true, true);

		// Aliases
		$aliases = [
			'request' => [Illuminate\Http\Request::class], 
		];
		foreach ($aliases as $key => $aliases)
		{
			foreach ($aliases as $alias)
			{
				$this->container->alias($key, $alias);
			}
		}
	}

	public function dispatch()
	{
		$this->container->instance('request' , $request  = Illuminate\Http\Request::capture());
		$this->container->instance('response', $response = Route::dispatch($request));
		$response->send();
	}
}

$application = new Application;

require __DIR__.'/../src/routes.php';

$application->dispatch();