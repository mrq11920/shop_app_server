<?php

namespace Database\Seeders;

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
        // php artisan make:migration:schema create_products_table --schema="name:string, desc:string, image_url:string, 
        // sku:string, price:decimal, quantity:unsignedBigInteger, discount_id:unsignedBigInteger, category_id:unsignedBigInteger" --model=true
        DB::table('products')->insert([
            [
                'id' => 1,
                'name' => 'Ca chua',
                'desc' => 'Muong dang la mot loai hoa qua rat tot cho suc khoe dac biet tot voi nhung nguoi bi benh cao huyet ap',
                'image_url' => 'https://vidas.vn/static/media/images/save_tem/s200_200/c%C3%A0%20chua.jpg',
                'sku' => '',
                'price' => 90000,
                'unit_type' => '250 Gram',
                'quantity' => 100,
                'category_id' => 1
            ],
            [
                'id' => 2,
                'name' => 'Chim tri thit nguyen con',
                'desc' => 'La chim quy, Tien vua, ho cung Cong, chim Phuong',
                'image_url' => 'https://vidas.vn/static/media/images/shop/chim-tri-do-1584953276.jpg',
                'sku' => '',
                'price' => 249000,
                'unit_type' => 'Kg',
                'quantity' => 50,
                'category_id' => 2
            ],
            [
                'id' => 3,
                'name' => 'Thit nhan tao gia nam',
                'desc' => 'Thanh phan: bot dau nanh, gluten lua mi, phan lap protein dau nanh',
                'image_url' => 'https://vidas.vn/static/media/images/save_tem/20220912_090539-compressed.jpg',
                'sku' => '',
                'price' => 200000,
                'unit_type' => 'Goi',
                'quantity' => 50,
                'category_id' => 3
            ],
            [
                'id' => 4,
                'name' => 'Thit lon dong hop',
                'desc' => 'Thanh phan: bot dau nanh, gluten lua mi, phan lap protein dau nanh',
                'image_url' => 'https://vidas.vn/static/media/images/save_tem/20220912_090539-compressed.jpg',
                'sku' => '',
                'price' => 120000,
                'unit_type' => 'Hop',
                'quantity' => 50,
                'category_id' => 4,
            ],
        ]);
    }
}
