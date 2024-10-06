<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Address::create([
           'name'=>'Damascus',
           'parent_id'=>NULL,
        ]);
        Address::create([
           'name'=>'Homs',
           'parent_id'=>NULL,
        ]);
        Address::create([
           'name'=>'Aleppo',
           'parent_id'=>NULL,
        ]);
        Address::create([
           'name'=>'Latakkia',
           'parent_id'=>NULL,
        ]);
        Address::create([
           'name'=>'Abbasyeen',
           'parent_id'=>1,
        ]);
        Address::create([
           'name'=>'Midan',
           'parent_id'=>1,
        ]);
        Address::create([
           'name'=>'Salhieh',
           'parent_id'=>1,
        ]);
        Address::create([
           'name'=>'Jaramana',
           'parent_id'=>1,
        ]);
        Address::create([
           'name'=>'Homs city',
           'parent_id'=>2,
        ]);
        Address::create([
           'name'=>'Palmyra',
           'parent_id'=>2,
        ]);
        Address::create([
           'name'=>'Sadad',
           'parent_id'=>2,
        ]);
        Address::create([
           'name'=>'Fairouzeh',
           'parent_id'=>2,
        ]);
        Address::create([
           'name'=>'Aleppo city',
           'parent_id'=>3,
        ]);
        Address::create([
           'name'=>'Hamdanieh',
           'parent_id'=>3,
        ]);
        Address::create([
           'name'=>'Salah Al Deen',
           'parent_id'=>3,
        ]);
        Address::create([
           'name'=>'Merdian',
           'parent_id'=>3,
        ]);
        Address::create([
           'name'=>'Lattakia city',
           'parent_id'=>4,
        ]);
        Address::create([
           'name'=>'Jableh',
           'parent_id'=>4,
        ]);
        Address::create([
           'name'=>'Quardaha',
           'parent_id'=>4,
        ]);
        Address::create([
           'name'=>'Ain Al Baidda',
           'parent_id'=>4,
        ]);
        Address::create([
           'name'=>'Square',
           'parent_id'=>5,
        ]);
        Address::create([
           'name'=>'Main Road',
           'parent_id'=>5,
        ]);
        Address::create([
           'name'=>'Souk',
           'parent_id'=>6,
        ]);
        Address::create([
           'name'=>'Jazmatieh',
           'parent_id'=>6,
        ]);
        Address::create([
           'name'=>'Al shuhadaa',
           'parent_id'=>7,
        ]);
        Address::create([
           'name'=>'Al Arabiyah',
           'parent_id'=>7,
        ]);
        Address::create([
           'name'=>'Qrrayyat',
           'parent_id'=>8,
        ]);
        Address::create([
           'name'=>'Rawdah',
           'parent_id'=>8,
        ]);
        Address::create([
           'name'=>'Bab Al Sebaa',
           'parent_id'=>9,
        ]);
        Address::create([
           'name'=>'Hamedieh',
           'parent_id'=>9,
        ]);
        Address::create([
           'name'=>'Ancient Souk',
           'parent_id'=>10,
        ]);
        Address::create([
           'name'=>'Center Square',
           'parent_id'=>10,
        ]);
        Address::create([
           'name'=>'Al Dalleh',
           'parent_id'=>11,
        ]);
        Address::create([
           'name'=>'Al Souk',
           'parent_id'=>11,
        ]);
        Address::create([
           'name'=>'Al Nawras',
           'parent_id'=>12,
        ]);
        Address::create([
           'name'=>'Al Alieh',
           'parent_id'=>12,
        ]);
        Address::create([
           'name'=>'Jamelieh',
           'parent_id'=>13,
        ]);
        Address::create([
           'name'=>'Slemanieh',
           'parent_id'=>13,
        ]);
        Address::create([
           'name'=>'Main Souk',
           'parent_id'=>14,
        ]);
        Address::create([
           'name'=>'Main Square',
           'parent_id'=>14,
        ]);
        Address::create([
           'name'=>'Main Road',
           'parent_id'=>15,
        ]);
        Address::create([
           'name'=>'Al Sabeel',
           'parent_id'=>15,
        ]);
        Address::create([
           'name'=>'Mokambo',
           'parent_id'=>16,
        ]);
        Address::create([
           'name'=>'Al Ahmadeih',
           'parent_id'=>16,
        ]);
        Address::create([
           'name'=>'Al Samak Square',
           'parent_id'=>17,
        ]);
        Address::create([
           'name'=>'Al Raiedieh',
           'parent_id'=>17,
        ]);
        Address::create([
           'name'=>'Main Road',
           'parent_id'=>18,
        ]);
        Address::create([
           'name'=>'Souk Al Ahmad',
           'parent_id'=>18,
        ]);
        Address::create([
           'name'=>'Al Akram',
           'parent_id'=>19,
        ]);
        Address::create([
           'name'=>'The Square',
           'parent_id'=>19,
        ]);
        Address::create([
           'name'=>'Al Bustan',
           'parent_id'=>20,
        ]);
        Address::create([
           'name'=>'Al Ashraf',
           'parent_id'=>20,
        ]);
      
    }
}
