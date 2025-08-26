<?php

namespace Themes\YourTrailQuest\Quiz;

use Illuminate\Support\ServiceProvider;
use Modules\Quiz\Controllers\QuizController;

class ModuleProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(QuizController::class, \Themes\YourTrailQuest\Quiz\Controllers\QuizController::class);
    }

}
