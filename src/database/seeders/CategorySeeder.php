<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // name:string, desc:string, image_url:string" --model=true
        DB::table('categories')->insert([
            [
                'id' => 1,
                'name' => 'Rau, cu, qua',
                'image_url' => 'https://vidas.vn/static/media/images/save_tem/s200_200/c%C3%A0%20chua.jpg',
                'desc' => '',
            ],
            [
                'id' => 2,
                'name' => 'Cac loai thit',
                'image_url' => 'https://vidas.vn/static/media/images/save_tem/s200_200/20220912_090345-compressed.jpg',
                'desc' => '',
            ],
            [
                'id' => 3,
                'name' => 'Thuy - Hai san',
                'image_url' => 'https://vidas.vn/static/media/images/save_tem/s200_200/rong-nho-c%C3%A1ch-nhi%E1%BB%87t.jpg',
                'desc' => '',
            ],
            [
                'id' => 4,
                'name' => 'Thuc pham dong hop',
                'image_url' => 'https://vidas.vn/static/media/images/save_tem/s200_200/DSCF3847.JPG',
                'desc' => '',
            ],
        ]);
    }
}
