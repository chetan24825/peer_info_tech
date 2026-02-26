<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $categories = [
      ['name' => 'Transport', 'slug' => 'transport'],
      ['name' => 'Taxi', 'slug' => 'taxi'],
      ['name' => 'Salon', 'slug' => 'salon'],
      ['name' => 'GYM', 'slug' => 'gym'],
      ['name' => 'Fashion', 'slug' => 'fashion'],
      ['name' => 'Others', 'slug' => 'others']
    ];

    foreach ($categories as $category) {
      $store = new Category();
      $store->name = $category['name'];
      $store->slug = $category['slug'];
      $store->save();
    }
  }
}
