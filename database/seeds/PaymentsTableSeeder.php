<?php

use App\Models\Client;
use App\Models\Payment;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentsTableSeeder extends Seeder
{
    private $count = 500;

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        if (!Payment::count()) {
            foreach (range(1, $this->count) as $index) {
                $faker = app(Faker::class);

                $payment = new Payment;
                $payment->fill([
                    'user_id' => User::all()->pluck('id')->random(),
                    'client_id' => Client::all()->pluck('id')->random(),
                    'amount' => random_int(10, 1000),
                    'currency' => '840',
                    'history' => $faker->realText(25),
                    'source' => $faker->domainName,
                    'trans_id' => Str::random(15),
                    'is_complete' => 1,
                    'is_paid' => 1,
                    'result_code' => 1,
                    'card_number' => Str::random(16),
                ])->save();
            }
        }
    }
}
