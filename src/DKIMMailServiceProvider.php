<?php
declare(strict_types=1);

namespace SimonSchaufi\LaravelDKIM;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Mail\MailServiceProvider;

class DKIMMailServiceProvider extends MailServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishesConfig();
    }

    /**
     * Load and publishes the package configuration file.
     */
    private function publishesConfig(): void
    {
        $this->publishes([
            __DIR__.'/../config/dkim.php' => config_path('dkim.php'),
        ], 'dkim-config');
    }

    /**
     * Register the Illuminate mailer instance.
     *
     * @return void
     */
    protected function registerIlluminateMailer()
    {
        $this->app->singleton('mail.manager', static function (Application $app) {
            return new MailManager($app);
        });

        $this->app->bind('mailer', static function (Application $app) {
            return $app->make('mail.manager')->mailer();
        });
    }
}
