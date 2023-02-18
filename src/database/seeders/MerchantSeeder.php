<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get all provinces
        $provinceMap = [];
        foreach (Province::all(['id', 'name',]) as $province) {
            $provinceMap[strtolower($province->name)] = $province->id;
        }
        $csvData = fopen(base_path('database/data/merchants.csv'), 'r');
        $row = true;


        while (($data = fgetcsv($csvData, null, ',')) !== false) {
            if (!$row) {
                DB::table('users')->updateOrInsert(
                    [
                        'id' => $data[0],
                    ],
                    [
                        'id' => $data[0],
                        'email' => $data[5],
                        'password' => '$2y$10$fsIvY6LpZ7m48oPNOrUbOOFDaYHCkN4cTA.VZAF08RISU6JtuhvKm',
                        'role' => config('user.roles.merchant'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                DB::table('user_profiles')->insert(
                    [
                        'user_id' => $data[0],
                        'full_name' => $data[1],
                        'description' => $data[2],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
                $images = json_decode(str_replace('\'', '"', $data[8]));
                if (!empty($images)) {
                    DB::table('images')->updateOrInsert(
                        [
                            'imageable_id' => $data[0],
                            'imageable_type' => "App\Models\UserProfile"
                        ],
                        [
                            'url' => $images[0]->path,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }

                $splitedAddress = explode(',', $data[4]);
                DB::table('user_addresses')->insert([
                    'user_id' => $data[0],
                    'name' => 'shop address',
                    'address' => $data[4],
                    'phone_number' => $data[6],
                    'province_id' => $provinceMap[strtolower(trim(end($splitedAddress)))],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $row = false;
        }
        fclose($csvData);
    }
}
