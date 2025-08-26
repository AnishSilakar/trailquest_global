<?php
namespace Modules\Core\Models;

use App\BaseModel;
use Illuminate\Support\Facades\Cache;

class Quiz extends BaseModel
{
    protected $table = 'core_quiz';
    public $lastIndex = 0;

    public function questions()
    {
        return $this->hasMany(QuizQuestions::class, 'core_quiz_id');
    }

    protected $fillable = [
        'title',
        'description',
        'oneliner',
        'icon',
        'buttonTxt'
    ];
    
}
