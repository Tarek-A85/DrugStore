<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name'=>'Unipharma',
        ]);
        Company::create([
            'name'=>'BARAKAT',
        ]);
        Company::create([
            'name'=>'AVENZOR',
        ]);
        Company::create([
            'name'=>'PHARMASYR',
        ]);
        Company::create([
            'name'=>'ASIA',
        ]);
    }
}
