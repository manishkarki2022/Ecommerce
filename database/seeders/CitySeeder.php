<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = array(
            array('code' => 'KTM', 'name' => 'Kathmandu'),
            array('code' => 'PKR', 'name' => 'Pokhara'),
            array('code' => 'LTP', 'name' => 'Lalitpur',),
            array('code' => 'BKT', 'name' => 'Bhaktapur'),
            array('code' => 'BIR', 'name' => 'Biratnagar'),
            array('code' => 'BGJ', 'name' => 'Birgunj'),
            array('code' => 'BTL', 'name' => 'Butwal'),
            array('code' => 'DHR', 'name' => 'Dharan'),
            array('code' => 'BHP', 'name' => 'Bharatpur'),
            array('code' => 'HTD', 'name' => 'Hetauda'),
            array('code' => 'JNK', 'name' => 'Janakpur'),
            array('code' => 'SDG', 'name' => 'Siddharthanagar'),
            array('code' => 'DMK', 'name' => 'Damak'),
            array('code' => 'DGD', 'name' => 'Dhangadhi'),
            array('code' => 'NGJ', 'name' => 'Nepalgunj'),
            array('code' => 'ITH', 'name' => 'Itahari'),
            array('code' => 'TKP', 'name' => 'Tikapur'),
            array('code' => 'TLS', 'name' => 'Tulsipur'),
            array('code' => 'GHR', 'name' => 'Ghorahi'),
            array('code' => 'RBJ', 'name' => 'Rajbiraj')
        );
        DB::table('cities')->insert($cities);
    }
}
