<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void

  {
    $countries = [
      ['name' => 'India', 'slug' => 'india', 'country_code' => '+91'],
      ['name' => 'United Kingdom', 'slug' => 'united-kingdom', 'country_code' => '+44'],
      ['name' => 'United State', 'slug' => 'united-state', 'country_code' => '+1'],
      ['name' => 'New Zealand	', 'slug' => 'new-zealand	', 'country_code' => '+64	'],
      ['name' => 'Australia', 'slug' => 'australia', 'country_code' => '+61'],
      ['name' => 'Switzerland', 'slug' => 'switzerland', 'country_code' => '+41'],
      ['name' => 'Canada', 'slug' => 'canada', 'country_code' => '+1'],
      ['name' => 'Denmark', 'slug' => 'denmark', 'country_code' => '+45'],
      ['name' => 'Germany', 'slug' => 'germany', 'country_code' => '+49'],
      ['name' => 'Other', 'slug' => 'other', 'country_code' => '+0'],
    ];

    foreach ($countries as $country) { 
         $store = new Country();
        $store->name = $country['name'];
        $store->slug = $country['slug'];
        $store->country_code = $country['country_code'];
        $store->save();
     }
  }
}
