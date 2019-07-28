<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use URL;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        URL::forceScheme('https');
        Schema::defaultStringLength(191);

        set_time_limit(3000);

        Validator::extend('html_required', function($attribute, $value, $parameters, $validator) {
            if(!empty($value) && strlen(trim(strip_tags($value))) > 0){
                return true;
            }
            return false;
        });

        Validator::extend('max_mb', function ($attribute, $value, $parameters, $validator) {

            if ($value instanceof UploadedFile && ! $value->isValid()) {
                return false;
            }

            // SplFileInfo::getSize returns filesize in bytes
            $size = $value->getSize() / 1024 / 1024;

            return $size <= $parameters[0];

        });

        Validator::replacer('max_mb', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':' . $rule, $parameters[0], $message);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
