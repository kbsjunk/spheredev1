<?php

namespace Sphere\Formatters;

use CommerceGuys\Addressing\Repository\AddressFormatRepositoryInterface;
use CommerceGuys\Addressing\Repository\CountryRepositoryInterface;
use CommerceGuys\Addressing\Repository\SubdivisionRepositoryInterface;
use CommerceGuys\Addressing\Formatter\FormatterInterface;

class AddressFormatter implements AddressFormatterInterface
{
  
  protected $addressFormatRepository;
  protected $countryRepository;
  protected $subdivisionRepository;
  protected $formatter;
  protected $locale;
  protected $formats = [];
  
  public function __construct(AddressFormatRepositoryInterface $addressFormatRepository,
                              CountryRepositoryInterface $countryRepository,
                              SubdivisionRepositoryInterface $subdivisionRepository,
                              FormatterInterface $formatter)
  {
    
    $this->addressFormatRepository = $addressFormatRepository;
    $this->countryRepository = $countryRepository;
    $this->subdivisionRepository = $subdivisionRepository;
    $this->formatter = $formatter;
    $this->locale = config('app.locale');
    
  }
    
    public function getAddressFormatRepository()
    {
            return $this->addressFormatRepository;
    }
    public function getCountryRepository()
    {
            return $this->countryRepository;
    }
    public function getSubdivisionRepository()
    {
            return $this->subdivisionRepository;
    }
    public function getFormatter()
    {
            return $this->formatter;
    }
  
  public function getCountries()
  {
    return $this->countryRepository->getList($this->getLocale());
  }
  
  public function getCountryPrefixes()
  {
//     $codes = $this->intlCountryRepository->getAll($this->getLocale());
//       dd($codes);
  }
  
  public function getSubdivisions($country)
  {
    return $this->subdivisionRepository->getList($country, 0, $this->getLocale());
  }
  
  public function getFormat($country)
  {
    if (!isset($this->formats[$country])) {
      $this->formats[$country] = $this->addressFormatRepository->get($country, $this->getLocale());
    }
    
    return $this->formats[$country];

  }
  
  public function getFields($country)
  {
    $fields = $this->getFormatString($country);
    
    preg_match_all('/%([A-Za-z0-9]+)/', $fields, $fields);
    
    $fields = array_diff($fields[1], ['recipient', 'organization']);
    
    return $fields;
  }
  
  public function getRequiredFields($country)
  {
    return array_diff($this->getFormat($country)->getRequiredFields(), ['recipient', 'organization']);
  }
  
  public function getAdministrativeAreaType($country)
  {
      $administrativeAreaType = $this->getFormat($country)->getAdministrativeAreaType();
      
      return $administrativeAreaType ? 'administrativeAreaTypes.'.$administrativeAreaType : 'administrativeArea';
  }
  
  public function getLocalityType($country)
  {
      $localityType = $this->getFormat($country)->getLocalityType($country);
      
      return $localityType ? 'localityTypes.'.$localityType : 'locality';
  }
  
  public function getDependentLocalityType($country)
  {
      $dependentLocalityType = $this->getFormat($country)->getDependentLocalityType();
      
      return $dependentLocalityType ? 'dependentLocalityTypes.'.$dependentLocalityType : 'dependentLocality';
  }
  
  public function getPostalCodeType($country)
  {
      $postalCodeType = $this->getFormat($country)->getPostalCodeType();
      
      return $postalCodeType ? 'postalCodeTypes.'.$postalCodeType : 'postalCode';
  }
  
  public function getPostalCodePattern($country)
  {
    return $this->getFormat($country)->getPostalCodePattern();
  }
  
  public function getFormatString($country)
  {
    return $this->getFormat($country)->getFormat();
  }
  
  public function getLocale()
  {
    return $this->locale ?: config('app.locale');
  }
  
  public function getLocalities($country, $administrativeArea)
  {
    return $this->subdivisionRepository->getList($country, $administrativeArea, $this->getLocale());
  }
  
}