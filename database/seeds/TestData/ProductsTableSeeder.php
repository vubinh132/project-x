<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'sku' => 'DHL01',
                'status' => 2,
                'name' => 'Đồng hồ LED để bàn',
                'old_price' => 69000,
                'price' => 59000,
                'description' => 'Đồng hồ LED để bàn...',
                'content' => 'Đồng hồ LED để bàn...',
                'image_url' => 'test_img_001.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'sku' => 'DHL02',
                'status' => 2,
                'name' => 'Đồng hồ LED để bàn',
                'old_price' => 99000,
                'price' => 79000,
                'description' => 'Đồng hồ LED để bàn...',
                'content' => 'Đồng hồ LED để bàn...',
                'image_url' => 'test_img_001.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'sku' => 'DHL03',
                'status' => 1,
                'name' => null,
                'old_price' => null,
                'description' => null,
                'content' => null,
                'image_url' => null,
                'quantity' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],   [
                'sku' => 'DHL04',
                'status' => 3,
                'name' => 'Đồng hồ LED để bàn',
                'old_price' => 99000,
                'price' => 79000,
                'description' => 'Đồng hồ LED để bàn...',
                'content' => 'Đồng hồ LED để bàn...',
                'image_url' => 'test_img_001.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];
        DB::table('products')->insert($products);
    }
}

