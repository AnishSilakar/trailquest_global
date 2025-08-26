<?php
namespace Themes\YourTrailQuest\Quiz\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Booking\Models\Booking;
use Validator;

class QuizController extends \Modules\Quiz\Controllers\QuizController
{
    public function renderQuiz(){
        return view('Quiz::frontend.view');
    }
}