<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        \App\User::truncate();
        \App\Category::truncate();
        \App\Product::truncate();
        \App\Transaction::truncate();
        \Illuminate\Support\Facades\DB::table('category_product')->truncate();

        $userQuantity = 200;
        $productsQuantity = 30;
        $categoriesQuantity = 1000;
        $transactionsQuantity = 1000;

       factory(App\User::class, $userQuantity)->create();
       factory(App\Category::class, $categoriesQuantity)->create();
       factory(App\Product::class, $productsQuantity)->create()->each(
           function ($product) {
               $categories = \App\Category::all()->random(mt_rand(1,5))->pluck('id');
               $product->categories()->attach($categories);
           }
       );
       factory(App\Transaction::class, $transactionsQuantity)->create();


    }
}
