<?php

namespace Sphere\Console\Commands;

use Illuminate\Console\Command;

use File;

class CreateAddressViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view:address';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate address attribute view fields.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fields = [
//           'countryCode',
//           'administrativeArea',
          'locality',
          'dependentLocality',
          'postalCode',
          'sortingCode',
          'addressLine1',
          'addressLine2',
//           'recipient',
//           'organization',
        ];
      
      $view = File::get(storage_path('data/address.view.txt'));
      
      foreach ($fields as $field) {
        $newView = str_replace(':field:', $field, $view);

        File::put(resource_path('views/custom_fields/address_'.$field.'.blade.php'), $newView);
      }
      
    }
}
