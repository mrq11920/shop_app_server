<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvData = fopen(base_path('database/data/provinces.csv'), 'r');
        $row = true;

        while (($data = fgetcsv($csvData, null, ',')) !== false) {
            if (!$row) {
                DB::table('provinces')->updateOrInsert(
                    [
                        'id' => $data[0],
                    ],
                    [
                        'id' => $data[0],
                        'name' => $data[1],
                        'postal_code' => $data[2],
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
