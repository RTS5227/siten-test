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
        DB::table('commons')->delete();
        $commons = [
            'offices' => [
                [
                    'code' => 'VT',
                    'name' => 'Viettel'
                ],
                [
                    'code' => 'VP',
                    'name' => 'Vinaphone'
                ],
                [
                    'code' => 'MF',
                    'name' => 'Mobifone'
                ],
            ],
            'roles' => [
                [
                    'code' => 'ADMIN',
                    'name' => 'Admin'
                ],
                [
                    'code' => 'GENERAL',
                    'name' => 'Chung'
                ],
            ],
            'types' => [
                [
                    'code' => 'USE',
                    'name' => 'Có thể sử dụng'
                ],
                [
                    'code' => 'NOT_USE',
                    'name' => 'Không thể sử dụng'
                ],
            ]
        ];

        $t = [];
        foreach ($commons as $k => $v) {
            $t[] = ['name' => $k, 'value' => json_encode($v)];
        }
        DB::table('commons')->insert($t);
    }
}
