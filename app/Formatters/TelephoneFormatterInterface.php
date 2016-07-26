<?php

namespace Sphere\Formatters;

interface TelephoneFormatterInterface
{
  public function getCountries();
  public function getFormat($country);
  public function getLocale();
  public function format($country, $number);
}