<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CLTLayerSeeder extends Seeder
{
    public function run(): void
    {
        // Layup 1 (5 layer: 0-90-0-90-0)
        DB::table('clt_layers')->insert([
            [
                'layup_id' => 1,
                'layer_order' => 1,
                'thickness' => 40,
                'width' => 1200,
                'angle' => 0,
            ],
            [
                'layup_id' => 1,
                'layer_order' => 2,
                'thickness' => 20,
                'width' => 1200,
                'angle' => 90,
            ],
            [
                'layup_id' => 1,
                'layer_order' => 3,
                'thickness' => 40,
                'width' => 1200,
                'angle' => 0,
            ],
            [
                'layup_id' => 1,
                'layer_order' => 4,
                'thickness' => 20,
                'width' => 1200,
                'angle' => 90,
            ],
            [
                'layup_id' => 1,
                'layer_order' => 5,
                'thickness' => 40,
                'width' => 1200,
                'angle' => 0,
            ],
        ]);

        // Layup 2 (3 layer)
        DB::table('clt_layers')->insert([
            [
                'layup_id' => 2,
                'layer_order' => 1,
                'thickness' => 35,
                'width' => 1000,
                'angle' => 0,
            ],
            [
                'layup_id' => 2,
                'layer_order' => 2,
                'thickness' => 25,
                'width' => 1000,
                'angle' => 90,
            ],
            [
                'layup_id' => 2,
                'layer_order' => 3,
                'thickness' => 35,
                'width' => 1000,
                'angle' => 0,
            ],
        ]);
    }
}
