<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\paginator;
use App\Models\Image;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        paginator::useBootstrap();
        $logo = Image::on("sqlsrv")->first();
        if ($logo) {
            $imagepath= asset("logo_images/".$logo->image_path);
        }
        else
         $imagepath=asset('assets/images/logo-dark.png');
         View::share('image_path', $imagepath);
    }
}
