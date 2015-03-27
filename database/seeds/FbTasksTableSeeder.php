<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Http\Tenant\Tasks\Models\Tasks;
//use Laracasts\TestDummy\Factory as TestDummy;

class FbTasksTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 50) as $index)
        {
            Tasks::create([
                'subject' => $faker->sentence(),
                'body' => $faker->realText(80),
                'due_date' => $faker->dateTimeThisYear,
            ]);
        }
        //TestDummy::times(20)->create('App\Post');
    }

}