<?php
namespace Modules\Core\Models;

use App\BaseModel;
use Illuminate\Support\Facades\Cache;

class QuizQuestions extends BaseModel
{
    protected $table = 'core_quiz_questions';
    public $lastIndex = 0;

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'core_quiz_id');
    }

    public function answers()
    {
        return $this->hasMany(QuizQuestionAnswers::class, 'core_quiz_questions_id');
    }

    // Only allow these fields to be mass assignable
    protected $fillable = [
        'questions',
        'core_quiz_id',
        'type',
        'oneliner',
        'onelinerFooter',
        'icon',
        'affect_result'
    ];
}
