<?php

namespace Sphere\Formatters;

interface AddressFormatterInterface
{
  public function getCountries();
  public function getSubdivisions($country);
  public function getFormat($country);
  public function getFields($country);
  public function getRequiredFields($country);
  public function getAdministrativeAreaType($country);
  public function getLocalityType($country);
  public function getDependentLocalityType($country);
  public function getPostalCodeType($country);
  public function getPostalCodePattern($country);
  public function getFormatString($country);
  public function getLocale();
}