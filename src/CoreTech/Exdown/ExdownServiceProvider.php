<?php namespace CoreTech\Exdown;

use Illuminate\Support\ServiceProvider;

class ExdownServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('core-tech/exdown');
		$this->check();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['command.exup'] = $this->app->share(function($app)
		{
			return new UpCommand;
		});

		$this->app['command.exdown'] = $this->app->share(function($app)
		{
			return new DownCommand;
		});

		$this->commands('command.exup', 'command.exdown');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

	/**
	 * If not run from command line and exdown file exists,
	 * die with view excluding a specific IP addresses.
	 *
	 * @return void
	 */
	public function check()
	{
		if (php_sapi_name() !== 'cli' and file_exists($this->app['path.storage'].'/meta/exdown'))
		{
			$ip = \Request::getClientIp();
			$ips = $this->app['config']->get('exdown::allowed_ips', array());

			! in_array($ip, $ips) and die(\View::make('exdown::exdown'));
		}
	}

}
