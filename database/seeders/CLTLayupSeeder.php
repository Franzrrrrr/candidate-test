<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CLTLayupSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('clt_layups')->insert([
            [
                'supplier_id' => 1,
                'name' => 'L-2023-X',
            ],
            [
                'supplier_id' => 1,
                'name' => 'L-204-A',
            ],
            [
                'supplier_id' => 2,
                'name' => 'L-500-X',
            ],
        ]);
    }
}
