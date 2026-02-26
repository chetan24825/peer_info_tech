<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
  protected $fillable = ['name','email','phone','country_id'];

    // function service_type(){
    //     return $this->belongsTo(ServiceType::class,'service_type','id');
    // }

function plans(){
    return $this->hasMany(Plan::class,'client_id','id')->where('is_plan_active',1)->with('service_type');
}

  public function country()
  {
    return $this->belongsTo(Country::class, 'country_id', 'id');
  }
}
