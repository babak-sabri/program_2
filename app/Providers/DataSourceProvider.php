<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\DataService\DataServiceInterface;

class DataSourceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $source         = request()->get('source');
        $handlerClass   = config('data-sources.'.$source, false);
        if(!$handlerClass) {
            throw new \Exception('Invalid data source selected');
        }
        $this->app->bind(
            DataServiceInterface::class,
            $handlerClass
        );
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
