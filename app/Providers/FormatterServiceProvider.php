<?php

namespace Sphere\Providers;

use Illuminate\Support\ServiceProvider;

class FormatterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Address
        $this->app->bind('CommerceGuys\Addressing\Repository\AddressFormatRepositoryInterface', 'CommerceGuys\Addressing\Repository\AddressFormatRepository');
        $this->app->bind('CommerceGuys\Addressing\Repository\CountryRepositoryInterface', 'CommerceGuys\Addressing\Repository\CountryRepository');
        $this->app->bind('CommerceGuys\Addressing\Repository\SubdivisionRepositoryInterface', 'CommerceGuys\Addressing\Repository\SubdivisionRepository');
        $this->app->bind('CommerceGuys\Addressing\Formatter\FormatterInterface', 'CommerceGuys\Addressing\Formatter\DefaultFormatter');
        $this->app->bind('Sphere\Formatters\AddressFormatterInterface', 'Sphere\Formatters\AddressFormatter');
      
        $this->app->singleton('formatter.address', function($app) {
          return $app['Sphere\Formatters\AddressFormatterInterface'];
        });
        
        // Telephone
        $this->app->bind('Sphere\Formatters\TelephoneFormatterInterface', 'Sphere\Formatters\TelephoneFormatter');
      
        $this->app->singleton('formatter.telephone', function($app) {
          return $app['Sphere\Formatters\TelephoneFormatterInterface'];
        });
        
        // DateTime
        
        $this->app->bind('Sphere\Formatters\DateTimeFormatterInterface', 'Sphere\Formatters\DateTimeFormatter');
      
        $this->app->singleton('formatter.datetime', function($app) {
          return $app['Sphere\Formatters\DateTimeFormatterInterface'];
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
