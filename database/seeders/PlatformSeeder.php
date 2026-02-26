<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $platforms = [
      ['name' => 'Shopify', 'slug' => 'shopify'],
      ['name' => 'Wordpress', 'slug' => 'wordpress'],
      ['name' => 'HTML', 'slug' => 'html'],
      ['name' => 'Other', 'slug' => 'other'],
     ];

    foreach ($platforms  as $platform) {
      $store = new Platform();
      $store->name = $platform['name'];
      $store->slug = $platform['slug'];
      $store->save();
    }
    }
}
