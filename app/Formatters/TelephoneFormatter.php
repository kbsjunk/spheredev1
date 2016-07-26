<?php

namespace Sphere\Formatters;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
    
use CommerceGuys\Addressing\Repository\CountryRepositoryInterface;

class TelephoneFormatter implements TelephoneFormatterInterface
{
  
  protected $formatter;
  protected $countryRepository;
  protected $locale;
  protected $formats = [];
  
  public function __construct(CountryRepositoryInterface $countryRepository)
  {
    $this->formatter = PhoneNumberUtil::getInstance();
    $this->countryRepository = $countryRepository;
    $this->locale = config('app.locale');
  }
 
  public function getCountries()
  {
    $countries = $this->countryRepository->getList($this->getLocale());
      
    foreach ($countries as $code => &$name) {
        $metadata = $this->formatter->getMetadataForRegion($code);
        
        $name = ($metadata ? '+'.$metadata->getCountryCode() : null);
    }
      
      return $countries;
  }
    
  public function getFormat($country)
  {
    return $this->formatter->getMetadataForRegion($code);
  }
  
  public function getLocale()
  {
    return $this->locale ?: config('app.locale');
  }
    
public function format($country, $number)
{
    try {
        $phoneNumber = $this->formatter->parse($number, $country);
        return trim(str_replace('+'.$phoneNumber->getCountryCode(), '', $this->formatter->format($phoneNumber, PhoneNumberFormat::NATIONAL)));
    } catch (NumberParseException $e) {
        return $number;
    }
}
    
  
  
}