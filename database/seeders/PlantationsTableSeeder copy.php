<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class PlantationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $currencyIDs = DB::table('currencies')->pluck('id');

        foreach (range(1,20) as $index) {
            DB::table('plantations')->insert([
                'name' => $faker->company(),
                'year' => $faker->year(),
                'cost' => 39,
                'currency_id' => $faker->randomElement($currencyIDs),
            ]);
        }
    }
}
