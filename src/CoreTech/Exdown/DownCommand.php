<?php namespace CoreTech\Exdown;

use Illuminate\Console\Command;

class DownCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'exdown';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Put the application into maintenance mode";

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		touch($this->laravel['path.storage'].'/meta/exdown');

		$this->comment('Application is now in maintenance mode.');
	}

}
