<?php

namespace Themes\YourTrailQuest\User;

use Illuminate\Support\ServiceProvider;
use Modules\User\Controllers\UserController;

class ModuleProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(UserController::class, \Themes\YourTrailQuest\User\Controllers\UserController::class);
    }

}
