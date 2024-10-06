<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name'=>'Heart'
        ]);
        Category::create([
            'name'=>'Cold'
        ]);
        Category::create([
            'name'=>'PainKiller'
        ]);
        Category::create([
            'name'=>'flu'
        ]);
        Category::create([
            'name'=>'diabetes'
        ]);
        Category::create([
            'name'=>'Anti-allergic'
        ]);
        Category::create([
            'name'=>'Appetizer'
        ]);
        Category::create([
            'name'=>'Antihypertensive'
        ]);
    }
}
