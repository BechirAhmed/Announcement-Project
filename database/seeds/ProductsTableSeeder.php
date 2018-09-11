<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\subCategory;
use App\Models\Product;
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
        for ($i = 1; $i <= 5; $i++) {

            $categoryData = [
                'slug' => 'test-category-' . $i,
                'name' => 'Cat' . $i,
                'description' => 'Test Category No #' . $i,
                'is_active' => '1',

            ];

            Category::create($categoryData);
        }

        for ($i = 1; $i <= 5; $i++) {

            $subCategoryData = [
                'slug' => 'test-sub-category-' . $i,
                'name' => 'SubCat' . $i,
                'description' => 'Test Sub Category No #' . $i,
                'is_active' => '1',

            ];

            $subCategory = subCategory::create($subCategoryData);

            $subCategory->categories()->attach(rand(1,5));
        }
    }
}
