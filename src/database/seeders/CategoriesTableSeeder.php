<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'id' => '1',
            'categories' => 'メンズ',

        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => '2',
            'categories' => 'レディース',

        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => '3',
            'categories' => 'ベビー・キッズ',

        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => '4',
            'categories' => 'インテリア',

        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => '5',
            'categories' => 'ホビー',

        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => '6',
            'categories' => '家電',

        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => '7',
            'categories' => 'スポーツ',

        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => '8',
            'categories' => 'コスメ',

        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => '9',
            'categories' => '自動車',

        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => '10',
            'categories' => '本・音楽・ゲーム',

        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => '11',
            'categories' => 'その他',

        ];
        DB::table('categories')->insert($param);
    }
}
