<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class QuizSubmission extends Model
{
    protected $table = 'core_quiz_submission';

    protected $fillable = [
        'name',
        'email',
        'contact',
        'quiz_id',
        'result'
    ];

    public $timestamps = true;

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizQuestionAnswers::class, 'quiz_submission_id');
    }
}