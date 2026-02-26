<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Plan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class ClientImport implements ToCollection, WithHeadingRow
{
  public $duplicate_data = [];
  public function collection(Collection $rows)
  {
    foreach ($rows as $row) {
      $client_name = $row['name'];
      $client_email = $row['email'];
      $client_phone = $row['phone'];

      #Skip empty rows
      if (empty($client_name) && empty($client_email) && empty($client_phone)) {
        continue;
      }
      #Add Row In Dupericate Array If Any, And Skip That Row
      if (checkClientExist($row['email'])) {
        $this->duplicate_data[] = ['name' => $client_name, 'email' => $client_email, 'phone' => $client_phone];
        continue;
      }

      $get_country_id = getIdFromSlug('countries', $row['country'])? getIdFromSlug('countries', $row['country']): getIdFromSlug('countries');
      // Create Client
      $client = new Client();
      $client->name = $client_name;
      $client->email = $client_email;
      $client->phone = $client_phone;
      $client->country_id =  $get_country_id;
      $client->save();

      #Made Plan Table Variables from excel import sheet
      $service_type_slug  = $row['service_type'];
      $platform_slug      = $row['platform'];
      $website_type_slug  = $row['website_type'];
      $category_slug      = $row['category'];

      $plan_duration      = $row['plan_duration'];
      $domain_name        = $row['domain_name'];
      $price              = $row['price'];

      $plan_start_date    = Carbon::createFromFormat('d-m-Y', $row['plan_start_date'])->format('Y-m-d');
      $service_plan_id    = getIdFromSlug('service_types',$service_type_slug)? getIdFromSlug('service_types', $service_type_slug):getIdFromSlug('service_types');
      $platform_id        = getIdFromSlug('platforms',$platform_slug)?getIdFromSlug('platforms', $platform_slug):getIdFromSlug('platforms');
      $website_type_id    = getIdFromSlug('website_types',$website_type_slug)? getIdFromSlug('website_types',$website_type_slug): getIdFromSlug('website_types');
      $category_id        = getIdFromSlug('categories',$category_slug)?getIdFromSlug('categories',$category_slug):getIdFromSlug('categories');
      $plan_expire_date   = getPlanExpireDate($plan_start_date, $plan_duration);
      ############################################################################

      #Create Plan
      $plan = new Plan();
      $plan->client_id       = $client->id;
      $plan->service_id      = $service_plan_id;
      $plan->domain_name     = $domain_name;
      $plan->start_date      = $plan_start_date;
      $plan->expire_date     = $plan_expire_date;
      $plan->duration        = $plan_duration;
      $plan->price           = $price;
      $plan->platform_id     = $platform_id;
      $plan->website_type_id = $website_type_id;
      $plan->category_id     = $category_id;
      $plan->save();
    }
  }
}
