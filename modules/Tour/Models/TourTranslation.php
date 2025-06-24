<?php
namespace Modules\Tour\Models;

use App\BaseModel;

class TourTranslation extends BaseModel
{
    protected $table = 'bravo_tour_translations';
    protected $fillable = [
        'aftercompleting',
        'whofor',
        'important_information',
        'whonotfor',
        'title',
        'content',
        'short_desc',
        'address',
        'faqs',
        'include',
        'exclude',
        'itinerary',
        'surrounding',
    ];
    protected $slugField     = false;
    protected $seo_type = 'tour_translation';
    protected $cleanFields = [
        'content'
    ];
    protected $casts = [
        'aftercompleting' => 'array',
        'whofor' => 'array',
        'whonotfor' => 'array',
        'faqs' => 'array',
        'include' => 'array',
        'exclude' => 'array',
        'itinerary' => 'array',
        'surrounding' => 'array',
    ];
    public function getSeoType(){
        return $this->seo_type;
    }
    public function getRecordRoot(){
        return $this->belongsTo(Tour::class,'origin_id');
    }
}