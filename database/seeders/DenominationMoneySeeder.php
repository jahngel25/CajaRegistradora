<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DenominationMoneySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('denomination_money')->insert([
            [
                'value' => '50',
                'id_type' => '1'
            ],
            [
                'value' => '100',
                'id_type' => '1'
            ],
            [
                'value' => '200',
                'id_type' => '1'
            ],
            [
                'value' => '500',
                'id_type' => '1'
            ],
            [
                'value' => '1000',
                'id_type' => '1'
            ],
            [
                'value' => '5000',
                'id_type' => '2'
            ],
            [
                'value' => '10000',
                'id_type' => '2'
            ],
            [
                'value' => '20000',
                'id_type' => '2'
            ],
            [
                'value' => '50000',
                'id_type' => '2'
            ],
            [
                'value' => '100000',
                'id_type' => '2'
            ]
        ]);
    }
}
