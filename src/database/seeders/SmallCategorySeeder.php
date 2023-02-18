<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SmallCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvData = fopen(base_path('database/data/small_categories.csv'), 'r');
        $row = true;

        while (($data = fgetcsv($csvData, 1000, ',')) !== false) {
            if (!$row) {
                DB::table('small_categories')->updateOrInsert(
                    [
                        'id' => $data[0],
                    ],
                    [
                        'id' => $data[0],
                        'name' => $data[1],
                        'large_category_id' => $data[2],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
            $row = false;
        }
        fclose($csvData);
    }
}
