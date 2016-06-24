<?php

use Illuminate\Database\Seeder;

use Sphere\User;

use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::where('username', '<>', 'kitbs')->delete();
      
        $faker = Faker::create();
      
        for ($i=1; $i < 100; $i++) {
          $user = User::create([
            'username' => str_slug($faker->userName),
            'email'    => $faker->userName . '+sphere@kitbs.mailgun.org',
            'name'     => $faker->firstName . ' ' . $faker->lastName,
            'password' => bcrypt('password'),
          ]);
        }
    }
}
