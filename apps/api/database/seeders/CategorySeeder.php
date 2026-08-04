<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [

            [
                'code' => 'CAT001',
                'name' => 'Makanan',
                'description' => 'Kategori makanan',
            ],

            [
                'code' => 'CAT002',
                'name' => 'Minuman',
                'description' => 'Kategori minuman',
            ],

            [
                'code' => 'CAT003',
                'name' => 'Snack',
                'description' => 'Kategori snack',
            ],

            [
                'code' => 'CAT004',
                'name' => 'Frozen Food',
                'description' => 'Kategori frozen food',
            ],

            [
                'code' => 'CAT005',
                'name' => 'ATK',
                'description' => 'Alat Tulis Kantor',
            ],

        ];

        foreach ($categories as $item) {

            Category::updateOrCreate(

                [
                    'code' => $item['code'],
                ],

                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'active' => true,
                ]

            );

        }
    }
}
