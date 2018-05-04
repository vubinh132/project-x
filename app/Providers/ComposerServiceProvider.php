<?php namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;
use App\Services\CommonService;

class ComposerServiceProvider extends ServiceProvider
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer('profile', 'App\Http\ViewComposers\ProfileComposer');

        // Using Closure based composers...
//        View::composer('*', function ($view) {
//            $viewParams = [
//                'version' => explode('|', CommonService::getSettingChosenValue('VERSION_DETAILS'))[0]
//            ];
//            $view->with('viewParams', $viewParams);
//        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}