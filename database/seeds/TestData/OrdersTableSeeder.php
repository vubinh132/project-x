<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderDetails = [
            [
                'product_id' => 1,
                'order_id' => 1,
                'quantity' => 10,
                'price' => -425000,
                'created_at' => "2018-04-01",
                'updated_at' => "2018-04-01"
            ],
            [
                'product_id' => 1,
                'order_id' => 2,
                'quantity' => -1,
                'price' => 59000,
                'created_at' => "2018-04-02",
                'updated_at' => "2018-04-02"
            ],
            [
                'product_id' => 1,
                'order_id' => 3,
                'quantity' => -1,
                'price' => 59000,
                'created_at' => "2018-04-03",
                'updated_at' => "2018-04-03"
            ],
            [
                'product_id' => 2,
                'order_id' => 4,
                'quantity' => 10,
                'price' => -500000,
                'created_at' => "2018-04-04",
                'updated_at' => "2018-04-04"
            ],
            [
                'product_id' => 1,
                'order_id' => 4,
                'quantity' => 10,
                'price' => -400000,
                'created_at' => "2018-04-04",
                'updated_at' => "2018-04-04"
            ],
            [
                'product_id' => 1,
                'order_id' => 5,
                'quantity' => -2,
                'price' => 120000,
                'created_at' => "2018-04-05",
                'updated_at' => "2018-04-05"
            ],
            [
                'product_id' => 2,
                'order_id' => 5,
                'quantity' => -2,
                'price' => 120000,
                'created_at' => "2018-04-05",
                'updated_at' => "2018-04-05"
            ],
            [
                'product_id' => 4,
                'order_id' => 6,
                'quantity' => 10,
                'price' => -400000,
                'created_at' => "2018-05-05",
                'updated_at' => "2018-05-05"
            ],
            [
                'product_id' => 4,
                'order_id' => 7,
                'quantity' => -10,
                'price' => 500000,
                'created_at' => "2018-05-06",
                'updated_at' => "2018-05-06"
            ],
            [
                'product_id' => 1,
                'order_id' => 8,
                'quantity' => -1,
                'price' => 9500,
                'created_at' => "2018-05-11",
                'updated_at' => "2018-05-11"
            ],
            [
                'product_id' => 2,
                'order_id' => 8,
                'quantity' => -1,
                'price' => 20000,
                'created_at' => "2018-05-11",
                'updated_at' => "2018-05-11"
            ],
        ];
        $orders = [
            [
                'status' => 3,
                'name' => "seudo",
                'code' => null,
                "selling_web" => null,
                'note' => "Nhap hang seudo 20180401",
                'created_at' => "2018-04-01",
                'updated_at' => "2018-04-01"
            ],
            [
                'status' => 2,
                'name' => "Nguyen Van A",
                'code' => "L-200942248950046",
                "selling_web" => 2,
                'note' => null,
                'created_at' => "2018-04-02",
                'updated_at' => "2018-04-02"
            ],
            [
                'status' => 2,
                'name' => "Nguyen Van B",
                'code' => "S-200942248950047",
                "selling_web" => 3,
                'note' => null,
                'created_at' => "2018-04-03",
                'updated_at' => "2018-04-03"
            ],
            [
                'status' => 3,
                'name' => "seudo",
                'code' => null,
                "selling_web" => null,
                'note' => "Nhap hang seudo 20180404",
                'created_at' => "2018-04-04",
                'updated_at' => "2018-04-04"
            ],
            [
                'status' => 1,
                'name' => "Nguyen Van C",
                'code' => "L-200942248950057",
                "selling_web" => 2,
                'note' => null,
                'created_at' => "2018-04-05",
                'updated_at' => "2018-04-05"
            ],
            [
                'status' => 3,
                'name' => "seudo",
                'code' => null,
                "selling_web" => null,
                'note' => 'nhap hang seudo 20180505',
                'created_at' => "2018-05-05",
                'updated_at' => "2018-05-05"
            ],

            [
                'status' => 2,
                'name' => "Nguyen Van D",
                'code' => "L-200942248977057",
                "selling_web" => 2,
                'note' => null,
                'created_at' => "2018-05-06",
                'updated_at' => "2018-05-06"
            ],
            [
                'status' => 2,
                'name' => "Nguyen Van E",
                'code' => "S-27942248977057",
                "selling_web" => 3,
                'note' => null,
                'created_at' => "2018-05-11",
                'updated_at' => "2018-05-11"
            ],
        ];
        DB::table('orders')->insert($orders);
        DB::table('order_details')->insert($orderDetails);
    }
}

