<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Http\Tenant\Email\Models\IncomingEmail;

class IncomingEmailTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 20) as $index)
        {
            $body = $faker->realText(150);
            IncomingEmail::create([
                'msid' => $faker->randomDigit,
                'user_id' => 1,
                'from_email' => $faker->email,
                'attachments' => NULL,
                'from_name' => $faker->name,
                'subject' => $faker->sentence(),
                'body_html' => $body,
                'body_text' => $body,
                'is_seen' => 0,
                'type' => $faker->numberBetween(0, 1),
                'received_at' => $faker->dateTimeThisMonth()
            ]);
        }
    }

}