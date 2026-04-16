<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('suppliers')->insert([
            ['name' => 'Nordic Timber Co.'],
            ['name' => 'Alpine CLT Solutions'],
            ['name' => 'MassivWood Ltd.'],
        ]);
    }
}
