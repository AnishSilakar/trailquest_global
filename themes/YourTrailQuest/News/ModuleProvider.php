<?php
namespace Themes\YourTrailQuest\News;

use Illuminate\Support\ServiceProvider;

use Modules\Template\Models\Template;
use Themes\YourTrailQuest\News\Blocks\ListNews;

class ModuleProvider extends ServiceProvider
{

    public function boot(){
        Template::register(static::getTemplateBlocks());
    }

    public static function getTemplateBlocks(){
        return [
            'list_news'=>ListNews::class,
        ];
    }
}
