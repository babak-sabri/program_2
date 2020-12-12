<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DataSourceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
		foreach (config('data-sources') as $source=>$class) {
			$this->app->bind(
				"{$source}-data-source",
				$class
			);
		}
	}

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
