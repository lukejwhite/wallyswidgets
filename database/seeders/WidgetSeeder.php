<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WidgetSeeder extends Seeder
{
    /**
     * Preset popular widget pack sizes
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('widgets')->insert([
            ['pack_size' => 250, 'cost' => 10.99],
            ['pack_size' => 500, 'cost' => 19.99],
            ['pack_size' => 1000, 'cost' => 34.99],
            ['pack_size' => 2000, 'cost' => 59.99],
            ['pack_size' => 5000, 'cost' => 119.99],
        ]);
    }
}
