<?php

namespace Sphere\Formatters;

use DateTime;
use DateTimeZone;
use Carbon\Carbon;

class DateTimeFormatter implements DateTimeFormatterInterface
{

    protected $formatter;
//   protected $timezoneRepository;
    protected $locale;
    protected $formats = [];

    public function __construct()
    {
//     $this->timezoneRepository = $countryRepository;
        $this->locale = config('app.locale');
    }

    public function getTimezones()
    {
        $timezones = DateTimeZone::listIdentifiers(); //FIXME
    
        return array_combine($timezones, $timezones);
    }

    public function getFormat($country)
    {
        
    }

    public function getLocale()
    {
        return $this->locale ?: config('app.locale');
    }

    public function format($country, $datetime)
    {

    }

}