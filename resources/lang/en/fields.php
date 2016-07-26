<?php

return [
    
    'datetime' => [
        'date'     => 'Date',
        'time'     => 'Time',
        'timezone' => 'Time Zone',
    ],
    
    'boolean' => [
        'true'  => 'Yes',
        'false' => 'No',
    ],
    
    'address' => [
        'countryCode'        => 'Country',
        'administrativeArea' => 'Administrative Area',
        'locality'           => 'Locality',
        'dependentLocality'  => 'Dependent Locality',
        'postalCode'         => 'Postal Code',
        'sortingCode'        => 'Sorting Code',
        'addressLine1'       => 'Address Line 1',
        'addressLine2'       => 'Address Line 2',
        'recipient'          => 'Recipient',
        'organization'       => 'Organization',
    
        'administrativeAreaTypes' => [
            "province"   => "Province",
            "oblast"     => "Oblast",
            "state"      => "State",
            "department" => "Department",
            "county"     => "County",
            "emirate"    => "Emirate",
            "island"     => "Island",
            "area"       => "Area",
            "district"   => "District",
            "prefecture" => "Prefecture",
            "parish"     => "Parish",
            "do_si"      => "Province/ City",
        ],    
        'localityTypes' => [
            "city"      => "City",
            "district"  => "District",
            "post_town" => "Post Town",
        ],    
        'dependentLocalityTypes' => [
            "neighborhood"     => "Neighborhood",
            "suburb"           => "Suburb",
            "district"         => "District",
            "village_township" => "Village/ Township",
        ],    
        'postalCodeTypes' => [
            "postal" => "Postal Code",
            "zip"    => "ZIP Code",
            "pin"    => "PIN Code",
        ],
    ]
];