<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionsTableSeeder extends Seeder
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
            'conditions' => '新品、未使用',

        ];
        DB::table('conditions')->insert($param);

        $param = [
            'id' => '2',
            'conditions' => '未使用に近い',

        ];
        DB::table('conditions')->insert($param);

        $param = [
            'id' => '3',
            'conditions' => '目立った傷、汚れなし',

        ];
        DB::table('conditions')->insert($param);

        $param = [
            'id' => '4',
            'conditions' => 'やや傷、汚れあり',

        ];
        DB::table('conditions')->insert($param);

        $param = [
            'id' => '5',
            'conditions' => '傷や汚れあり',

        ];
        DB::table('conditions')->insert($param);

        $param = [
            'id' => '6',
            'conditions' => '全体的に状態が悪い',

        ];
        DB::table('conditions')->insert($param);
    }
}
