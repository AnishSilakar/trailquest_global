<?php
namespace Themes\YourTrailQuest\Vendor;

use Illuminate\Support\ServiceProvider;

use Modules\ModuleServiceProvider;
use Modules\Page\Hook;
use Modules\Template\Models\Template;
use Themes\YourTrailQuest\Hotel\Blocks\FormSearchHotel;
use Themes\YourTrailQuest\Hotel\Blocks\ListHotel;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot(){
        add_filter(\Modules\Vendor\Hook::VENDOR_SETTING_CONFIG,[$this,'alterSettings']);
        add_action(\Modules\Vendor\Hook::VENDOR_SETTING_AFTER_GENERAL,[$this,'showCustomFields']);
    }

    public function alterSettings($settings){
        if(!empty($settings['vendor'])){
            $settings['vendor']['keys'][] = 'vendor_page_become_an_expert';
        }
        return $settings;
    }

    public function showCustomFields(){
        echo view('Vendor::admin.setting-after-general');
    }

}
