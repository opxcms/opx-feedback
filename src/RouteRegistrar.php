<?php

namespace Modules\Opx\FeedBack;

use Core\Foundation\Module\RouteRegistrar as BaseRouteRegistrar;
use Illuminate\Support\Facades\Route;

class RouteRegistrar extends BaseRouteRegistrar
{
    public function registerPublicAPIRoutes($profile): void
    {
        Route::namespace('Modules\Opx\FeedBack\Controllers')
            ->middleware('web')
            ->group(static function () {
                Route::post('api/feedback', 'FeedBackController@handleFeedback');
            });
    }

}