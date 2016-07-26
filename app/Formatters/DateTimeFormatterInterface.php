<?php

namespace Sphere\Formatters;

interface DateTimeFormatterInterface
{
  public function getTimezones();
  public function getFormat($country);
  public function getLocale();
  public function format($country, $datetime);
}