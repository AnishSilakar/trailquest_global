<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class QuizSubmissionAnswers extends Model
{
protected $table = 'core_quiz_submission_answers';

    protected $fillable = [
        'question_id',
        'answers_id',
        'quiz_submission_id',
        'range_value',
    ];

    public $timestamps = true;

    public function quizSubmission()
    {
        return $this->belongsTo(QuizSubmission::class);
    }
}