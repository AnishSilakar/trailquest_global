<?php
namespace Themes\YourTrailQuest;

use Illuminate\Contracts\Http\Kernel;
use Themes\YourTrailQuest\Database\Seeders\DatabaseSeeder;
use Themes\YourTrailQuest\Database\Seeders\DatabaseSeederForReImport;


class ThemeProvider extends \Themes\Base\ThemeProvider
{
    public static $version = '2.0.0';
    public static $name = 'Your Trail Quest';
    public static $parent = 'base';

    public static $seeder = DatabaseSeeder::class;

    public static $seederForReImport = DatabaseSeederForReImport::class;

    public static function info()
    {
        // TODO: Implement info() method.
    }

    public function boot(Kernel $kernel)
    {
        parent::boot($kernel);
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        add_action(\Modules\Core\Hook::CORE_SETTING_AFTER_FOOTER,[$this,'showCustomFieldsAfterFooter']);
    }

    public function register()
    {
        parent::register();
        $this->app->register(\Themes\YourTrailQuest\User\ModuleProvider::class); 
        $this->app->register(\Themes\YourTrailQuest\Page\ModuleProvider::class);
        $this->app->register(\Themes\YourTrailQuest\Location\ModuleProvider::class); 
        $this->app->register(\Themes\YourTrailQuest\News\ModuleProvider::class);
        $this->app->register(\Themes\YourTrailQuest\Template\ModuleProvider::class);
        $this->app->register(\Themes\YourTrailQuest\Tour\ModuleProvider::class); 
        $this->app->register(\Themes\YourTrailQuest\Contact\ModuleProvider::class); 
        $this->app->register(\Themes\YourTrailQuest\Core\ModuleProvider::class);
        //anish Added
        $this->app->register(\Themes\YourTrailQuest\Quiz\ModuleProvider::class);
        // $this->app->register(\Themes\YourTrailQuest\Vendor\ModuleProvider::class); 
        // $this->app->register(UpdaterProvider::class);
    }

    public function showCustomFieldsAfterFooter(){
        echo view('Core::admin.settings.setting-after-footer');
    }

}
