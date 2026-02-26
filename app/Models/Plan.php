<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
  public $fillable = ['status', 'is_plan_active'];
    public function service_type()
    {
        return $this->belongsTo(ServiceType::class, 'service_id');
    }
    public function clients()
    {
        return $this->belongsTo(Client::class, 'client_id')->with('country');
    }

    public function platforms(){
      return $this->belongsTo(Platform::class,'platform_id');
    }

    public function websites(){
      return $this->belongsTo(WebsiteType::class, 'website_type_id');
    }

    public function categories(){
      return $this->belongsTo(Category::class, 'category_id');
    }
}
