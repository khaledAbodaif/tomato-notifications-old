<?php

namespace Queents\TomatoNotifications;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use ProtoneMedia\Splade\Facades\SEO;
use Queents\TomatoPHP\Services\Menu\TomatoMenuRegister;
use Queents\TomatoRoles\Services\Permission;
use Queents\TomatoRoles\Services\TomatoRoles;
use Queents\TomatoSettings\Console\TomatoSettingGenerator;
use Queents\TomatoSettings\Menus\SettingsMenu;

class TomatoNotificationsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/tomato-notifications.php', 'tomato-notifications');

        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'tomato-notifications');

        //Register Langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'tomato-notifications');

        //Register Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        //Publish Views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/tomato-notifications'),
        ], 'views');

        //Publish Config
        $this->publishes([
            __DIR__.'/../config/tomato-settings.php' => config_path('tomato-notifications.php'),
        ], 'config');

        //Publish Lang
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/tomato-notifications'),
        ], 'lang');

        //Publish Migrations
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'migrations');

        //Register generate command
        $this->commands([
            TomatoSettingGenerator::class,
        ]);

        //Register new blade component
        $this->loadViewComponentsAs('tomato-notifications', [
            \Queents\TomatoSettings\Views\Card::class,
        ]);

        $this->registerPermissions();
        $this->registerSettingsConfigPass();
    }

    public function boot(): void
    {
        //Add Middleware Global to Routes web
    }

    /**
     * @return void
     */
    public function registerPermissions(): void
    {
        //Register Permission For Settings
        TomatoRoles::register(Permission::make()
            ->name('admin.settings.site.index')
            ->guard('web')
            ->group('settings')
        );
        TomatoRoles::register(Permission::make()
            ->name('admin.settings.site.store')
            ->guard('web')
            ->group('settings')
        );
        TomatoRoles::register(Permission::make()
            ->name('admin.settings.email.index')
            ->guard('web')
            ->group('settings')
        );
        TomatoRoles::register(Permission::make()
            ->name('admin.settings.email.store')
            ->guard('web')
            ->group('settings')
        );
        TomatoRoles::register(Permission::make()
            ->name('admin.settings.google.index')
            ->guard('web')
            ->group('settings')
        );
        TomatoRoles::register(Permission::make()
            ->name('admin.settings.google.store')
            ->guard('web')
            ->group('settings')
        );
        TomatoRoles::register(Permission::make()
            ->name('admin.settings.services.index')
            ->guard('web')
            ->group('settings')
        );
        TomatoRoles::register(Permission::make()
            ->name('admin.settings.services.store')
            ->guard('web')
            ->group('settings')
        );
        TomatoRoles::register(Permission::make()
            ->name('admin.settings.themes.index')
            ->guard('web')
            ->group('settings')
        );
        TomatoRoles::register(Permission::make()
            ->name('admin.settings.themes.store')
            ->guard('web')
            ->group('settings')
        );
        TomatoRoles::register(Permission::make()
            ->name('admin.settings.payments.index')
            ->guard('web')
            ->group('settings')
        );
        TomatoRoles::register(Permission::make()
            ->name('admin.settings.payments.store')
            ->guard('web')
            ->group('settings')
        );
    }

    public function registerSettingsConfigPass(): void
    {
        try {
            DB::connection()->getPdo();

            Config::set('mail.mailers.smtp', [
                'transport' => \Queents\TomatoSettings\setting('mail_mailer'),
                'host' => \Queents\TomatoSettings\setting('mail_host'),
                'port' => \Queents\TomatoSettings\setting('mail_port'),
                'encryption' => \Queents\TomatoSettings\setting('mail_encryption'),
                'username' => \Queents\TomatoSettings\setting('mail_username'),
                'password' => \Queents\TomatoSettings\setting('mail_password'),
                'timeout' => null,
                'auth_mode' => null,
            ]);

            Config::set('mail.from', [
                'address' => \Queents\TomatoSettings\setting('mail_from_address'),
                'name' => \Queents\TomatoSettings\setting('mail_from_name'),
            ]);

            SEO::canonical(url('/'));
            SEO::title(\Queents\TomatoSettings\setting('site_name'));
            SEO::description(\Queents\TomatoSettings\setting('site_description'));
            SEO::keywords(\Queents\TomatoSettings\setting('site_keywords'));

            SEO::openGraphType('WebPage');
            SEO::openGraphSiteName(\Queents\TomatoSettings\setting('site_name'));
            SEO::openGraphTitle(\Queents\TomatoSettings\setting('site_name'));
            SEO::openGraphUrl(url('/'));
            SEO::openGraphImage(\Queents\TomatoSettings\setting('site_profile'));

            SEO::twitterCard('summary_large_image');
            SEO::twitterTitle(\Queents\TomatoSettings\setting('site_name'));
            SEO::twitterDescription(\Queents\TomatoSettings\setting('site_description'));
            SEO::twitterImage(\Queents\TomatoSettings\setting('site_profile'));

        }
        catch (\Exception $e){
            \Log::error($e);
        }
    }
}
