<?php

use App\Models\Client;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;

class ClientsTableSeeder extends Seeder
{
    private $count = 300;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Client::count()) {
            foreach (range(1, $this->count) as $index) {
                $faker = app(Faker::class);

                $transaction = new Client;
                $transaction->fill([
                    'name' => $faker->firstName(),
                    'surname' => $faker->lastName(),
                    'email' => $faker->email,
                ])->save();
            }
        }
    }
}
