<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Simple Product',
                'slug' => 'simple-product',
            ],
            [
                'name' => 'Attribute Product',
                'slug' => 'attribute-product',
            ],
        ];

        ProductType::insert($types);
    }
}
