<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\SmallCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get all categories
        $smallCategories = SmallCategory::all(['id', 'name', 'large_category_id']);
        $mapSmallCategories = ['name' => 'id'];
        $mapLargeCategories = ['small_category_id' => 'large_category_id'];

        foreach ($smallCategories as $category) {
            $mapSmallCategories[strtolower($category->name)] = $category->id;
            $mapLargeCategories[$category->id] = $category->large_category_id;
        }
        // get all provinces
        $provinceMap = [];
        foreach (Province::all(['id', 'name',]) as $province) {
            $provinceMap[strtolower($province->name)] = $province->id;
        }
        $csvData = fopen(base_path('database/data/products.csv'), 'r');
        $row = true;

        while (($data = fgetcsv($csvData, null, ',')) !== false) {
            if (!$row) {
                $splitedAddress = explode('-', $data[7]);
                DB::table('products')->updateOrInsert(
                    [
                        'id' => $data[0],
                    ],
                    [
                        'id' => $data[0],
                        'merchant_id' => $data[10],
                        'name' => $data[1],
                        'description' => json_encode($data[8]),
                        'price' => $data[3],
                        'small_category_id' => $mapSmallCategories[strtolower($data[2])],
                        'large_category_id' => $mapLargeCategories[$mapSmallCategories[strtolower($data[2])]],
                        'unit_type' => $data[4],
                        'quantity' => rand(5, 10),
                        'province_id' => $provinceMap[strtolower(trim(end($splitedAddress)))],
                        'status' => config('product.status.approved'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                $images = json_decode(str_replace('\'', '"', $data[12]));
                if (!empty($images)) {
                    foreach ($images as $image) {
                        DB::table('images')->insert([
                            'imageable_id' => $data[0],
                            'imageable_type' => "App\Models\Product",
                            'url' => $image->path,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
            $row = false;
        }
        fclose($csvData);
    }
}
