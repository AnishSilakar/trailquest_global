<?php
namespace Modules\Core\Models;

use App\BaseModel;
use Illuminate\Support\Facades\Cache;

class QuizQuestionAnswers extends BaseModel
{
    protected $table = 'core_quiz_question_answers';

    protected $fillable = [
        'answers',
        'is_correct',
        'core_quiz_questions_id'
    ];

    public function question()
    {
        return $this->belongsTo(QuizQuestions::class, 'core_quiz_questions_id');
    }
    
}
