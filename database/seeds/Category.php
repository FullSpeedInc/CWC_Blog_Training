<?php

use Illuminate\Database\Seeder;

class Category extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            0 => [
                'name'   => 'category 1',
                'updated_user_id' => 1
            ],
            1 => [
                'name'   => 'category 2',
                'updated_user_id' => 1
            ]
        ];

        DB::table('article_category')->insert($categories);
    }
}
