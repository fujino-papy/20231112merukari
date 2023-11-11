<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategoriesTableSeeder::class,
            ConditionsTableSeeder::class,
        ]);
        \App\Models\User::factory(10)->create(); // ユーザーを作成（適宜調整）
        \App\Models\Item::factory(20)->create(); // アイテムを作成（適宜調整）
    }
}
