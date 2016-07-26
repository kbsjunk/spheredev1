<?php

use Illuminate\Database\Seeder;

use Sphere\Group;

use Faker\Factory as Faker;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::whereRaw('1 = 1')->delete();
      
        $faker = Faker::create();
      
        for ($i=1; $i < 20; $i++) {
          $word = $faker->city;
          $user = Group::create([
            'name' => ucfirst($word),
            'slug' => str_slug($word),
          ]);
        }
    }
}
