<?php
namespace Themes\YourTrailQuest\Template;

use Illuminate\Support\ServiceProvider;
use Modules\Template\Models\Template;
use Themes\YourTrailQuest\Template\Blocks\AboutText;
use Themes\YourTrailQuest\Template\Blocks\DownloadApp;
use Themes\YourTrailQuest\Template\Blocks\FaqList;
use Themes\YourTrailQuest\Template\Blocks\FormSearchAllService;
use Themes\YourTrailQuest\Template\Blocks\ListAllService;
use Themes\YourTrailQuest\Template\Blocks\ListFeaturedItem;
use Themes\YourTrailQuest\Template\Blocks\LoginRegister;
use Themes\YourTrailQuest\Template\Blocks\OfferBlock;
use Themes\YourTrailQuest\Template\Blocks\Subscribe;
use Themes\YourTrailQuest\Template\Blocks\Terms;
use Themes\YourTrailQuest\Template\Blocks\TextFeaturedBox;
use Themes\YourTrailQuest\Template\Blocks\TextImage;
use Themes\YourTrailQuest\Template\Blocks\Activities;



class ModuleProvider extends ServiceProvider
{
    public function boot(){
        Template::register(static::getTemplateBlocks());
    }
    public static function getTemplateBlocks(){
        return [
            "list_all_service"=>ListAllService::class,
            'subscribe'=>Subscribe::class,
            'download_app' => DownloadApp::class,
            'login_register' => LoginRegister::class,
            'list_terms'=>Terms::class,
            'faqs'=>FaqList::class,
            'about_text'=>AboutText::class,
            'form_search_all_service' => FormSearchAllService::class,
            'text_featured_box' => TextFeaturedBox::class,
            'text_image' => TextImage::class,
            //hide block for YourTrailQuest
            'form_search_tour' => null,   
            'list_tours' => null,
            'box_category_tour' => null,   
            'offer_block' => OfferBlock::class,
            'activities' => Activities::class
        ];
    }
}
