<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceType;
class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $serviceTypes = [
           ['name'=>'Hosting','slug'=>'hosting'],
            ['name'=>'Domain','slug'=>'domain'],
            ['name'=>'Hosting+Domain','slug'=>'hosting-domain'], 
            ['name'=>'AMC','slug'=>'amc'], 
            ['name'=>'Other','slug'=>'other'] 
        ];

        foreach ($serviceTypes as $type) {
            ServiceType::create($type);
        }

        


    }
}
