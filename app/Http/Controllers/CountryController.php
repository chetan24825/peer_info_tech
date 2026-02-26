<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PHPUnit\Framework\Constraint\Count;

class CountryController extends Controller
{
    public function index(Request $request){

      $data = Country::where('status','active')->select('id','name', 'slug', 'country_code', 'status')->get();
      if($request->ajax()){
        return DataTables::of($data)
        ->addIndexColumn()

        ->addColumn('action', function ($data) {
          return '<div class="hstack gap-2 flex-wrap">
                <a href="javascript:void(0);" class="text-info fs-14 lh-1 edit_country_btn" data-id="' . $data->id . '"><i
                        class="ri-edit-line"></i>
                </a>
                <a href="javascript:void(0);" class="text-danger delete_country_btn fs-14 lh-1" data-id="' . $data->id . '"><i
                        class="ri-delete-bin-5-line"></i>
                </a>
            </div>';
        })
        ->rawColumns(['action'])
        ->make(true);

      }
      return view('clients.country.list');
    }

    public function store(Request $request){
     $slug = Str::slug($request->name, '-');
     $request->all();
     $store=new Country();
     $store->name=$request->name;
     $store->slug = $slug;
     $store->country_code = $request->code;
     $store->save();
     return redirect()->back();
    }

    public function getCountry($id){
    $country = Country::find($id);
    if (!$country) {
      return response()->json(['message' => 'Client not found'], 404);
    }
    return response()->json(['country' => $country], 200);
    }

    public function update(Request $request){
      $slug = Str::slug($request->name, '-');
      $store = Country::find($request->country_id);
      $store->name = $request->name;
      $store->country_code = $request->code;
      $store->slug = $slug;
      $store->save();
      return redirect()->back();
    }
  public function delete($id)
  {
    $country = Country::find($id);

    if (!$country) {
      return response()->json(['status' => false, 'message' => 'Country not found'], 404);
    }

    $country->delete();

    return response()->json(['status' => true, 'message' => 'Country deleted successfully']);
  }
}