<?php

return [
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
            "do_si"      => "도/시",
        ],    
        'localityTypes' => [
//             "city"      => "군/군",
            "district"  => "District",
            "post_town" => "Post Town",
        ],    
        'dependentLocalityTypes' => [
            "neighborhood"     => "Neighborhood",
            "suburb"           => "Suburb",
//             "district"         => "구",
            "village_township" => "Village/ Township",
        ],    
        'postalCodeTypes' => [
            "postal" => "Postal Code",
            "zip"    => "ZIP Code",
            "pin"    => "PIN Code",
        ],
    ]
];