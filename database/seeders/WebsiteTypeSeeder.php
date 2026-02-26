<?php
namespace Database\Seeders;
use App\Models\WebsiteType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class WebsiteTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $website_types = [
      ['name' => 'Informative', 'slug' => 'informative'],
      ['name' => 'Ecommerce', 'slug' => 'ecommerce'],
      ['name' => 'Semi Ecommerce', 'slug' => 'semi-ecommerce'],
      ['name' => 'Other', 'slug' => 'other'],
    ];

    foreach ($website_types  as $website_type) {
      $store = new WebsiteType();
      $store->name = $website_type['name'];
      $store->slug = $website_type['slug'];
      $store->save();
    }
  }
}
