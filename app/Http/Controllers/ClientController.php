<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ServiceType;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Plan;
use BcMath\Number;
use App\Exports\ClientListExport;
use App\Exports\ExpiringExportList;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use App\Imports\ClientImport;
use App\Models\Country;
use App\Http\Requests\StoreClientRequest;

class ClientController extends Controller
{
  public function Dashboard()
  {
    $client = Client::all();
    $plan = Plan::all();
    $service_type = ServiceType::all();

    $get_domain_service_id = $service_type->where('slug', 'domain')->first()->id;
    $get_hosting_service_id = $service_type->where('slug', 'hosting')->first()->id;
    $get_hosting_domain_service_id = $service_type->where('slug', 'hosting-domain')->first()->id;
    $get_amc_service_id = $service_type->where('slug', 'amc')->first()->id;
    $client_count = $client->count();
    $get_domain_client_count = $plan->where('service_id', $get_domain_service_id)->count();
    $get_hosting_client_count =  $plan->where('service_id', $get_hosting_service_id)->count();
    $get_hosting_domain_client_count = $plan->where('service_id', $get_hosting_domain_service_id)->count();
    $get_amc_count = $plan->where('service_id', $get_amc_service_id)->count();

    return view('dashboard', [
      'client_count' => $client_count,
      'get_domain_client_count' => $get_domain_client_count,
      'get_hosting_client_count' => $get_hosting_client_count,
      'get_hosting_domain_client_count' => $get_hosting_domain_client_count,
      '$get_amc_count' => $get_amc_count

    ]);
  }

  public function index(Request $request)
  {
    $countries = Country::where('status', 'active')->get();
    $service_types = ServiceType::where('status', 'active')->get();
    $service_type_id = false;
    if ($request->input('service_type')) {
      $service_slug = $request->input('service_type');
      $service_types_get_id = ServiceType::where('slug', $service_slug)->where('status', 'active')->first();
      $service_type_id = $service_types_get_id->id;
    }

    $data = Client::when($request->filled(['client_start_date', 'client_end_date']), function ($q) use ($request) {
      $q->whereDate('created_at', '>=', $request->client_start_date)
        ->whereDate(
          'created_at',
          '<=',
          $request->client_end_date
        );
    })
      ->when($request->input('service_type'), function ($q) use ($service_type_id) {
        $q->whereHas('plans', function ($query) use ($service_type_id) {
          $query->where('service_id', $service_type_id);
        });
      })


      ->select(['id', 'name', 'email', 'phone', 'country_id'])
      ->orderBy('id', 'DESC')
      ->get();

    if ($request->ajax()) {
      return Datatables::of($data)
        ->addIndexColumn()
        #Plan Service Type
        ->editColumn(
          'service_type',
          function ($data) {
            if ($data->plans()->first()) {
              return $data->plans()->first()->service_type()->first()->name;
            } else {
              return '--';
            }
          }
        )
        ->addColumn('plan_count', function ($data) {
          $count = $data->plans()->count();

          if ($count > 0) {
            // $url = route('plans.client_plans', $data->id);
            $url = route('plans.client', ['client_id' => $data->id]);


            return '<a href="' . $url . '" class="badge bg-primary" style="font-size:13px; padding:6px 10px;">' . $count . '</a>';
          } else {
            return '<span class="badge bg-secondary">--</span>';
          }
        })

        #Plan Start Date
        ->editColumn('start_date', function ($data) {
          if ($data->plans()->first()) {
            $start = Carbon::parse($data->plans()->first()->start_date)->format('d-m-Y');;
            $end   = Carbon::parse($data->plans()->first()->expire_date)->format('d-m-Y');;

            return '
        <div style="font-size:12px;line-height:1.4;">
            <span style="font-weight:700; color:#2563eb;">Start:</span>
            <span style="padding:3px 8px;border-radius:8px;background:#2563eb;color:#fff;margin-left:4px;display:inline-block;">
                ' . $start . '
            </span>
            <br>
            <span style="font-weight:700; color:#dc2626;">End:</span>
            <span style="padding:3px 8px;border-radius:8px;background:#dc2626;color:#fff;margin-left:4px;display:inline-block;">
                ' . $end . '
            </span>
        </div>
        ';

            // return Carbon::parse($data->plans()->first()->start_date)->format('d-m-Y');
          } else {
            return '--';
          }
        })

        #Plan Price  
        ->editColumn('price', function ($data) {
          if ($data->plans()->first()) {
            // return $data->plans()->first()->price . '₹';
            $dummyDuration = $data->plans()->first()->duration . "yr";
            $dummyPrice = $data->plans()->first()->price . '₹';
            return '
  
        <div>
            <span style="font-weight:700;">Duration:</span>
            <span style="padding:3px 8px;background:#059669;color:#fff;border-radius:8px;">
                ' . $dummyDuration . '
            </span>
        </div>

        <div>
            <span style="font-weight:700;">Price:</span>
            <span style="padding:3px 8px;background:#7c3aed;color:#fff;border-radius:8px;">
                ' . $dummyPrice . '
            </span>
        </div>

    </div>
    ';
          } else {
            return '--';
          }
        })

        #Plan Domain Name
        ->editColumn('domain_name', function ($data) {
          if ($data->plans()->first()) {
            return $data->plans()->first()->domain_name;
          } else {
            return '--';
          }
        })


        #Plan Domain Name
        ->editColumn('phone', function ($data) {

          if ($data->phone) {
            $code =  $data->country->country_code ?? false;
            $country_name =  $data->country->name ?? false;
            if ($code) {
              return '(' . $code . ') ' . $data->phone . '</div>' . '<br>' . $country_name;
            }

            return $data->phone; // phone exists but country missing
          }

          return '--'; // no phone
        })


        ->addColumn('action', function ($data) {
          return '
        <div class="dropdown action-settings">
        <a href="javascript:void(0);" 
           class="text-dark fs-5 settings-toggle" 
           data-bs-toggle="dropdown" 
           aria-expanded="false">
            <i class="ri-settings-3-line settings-icon" style="transition: transform 0.3s;"></i>
        </a>

        <ul class="dropdown-menu dropdown-menu-end">
            <!-- View Plan -->
            <li>
                <a class="dropdown-item text-warning" href="' . route('clients.view', ['id' => $data->id]) . '">
                    <i class="ri-eye-line me-2"></i> View User
                </a>
            </li>
            <li>
                <a class="dropdown-item edit_client_btn text-success" href="javascript:void(0);" data-id="' . $data->id . '">
                    <i class="ri-edit-line me-2"></i> Edit
                </a>
            </li>

            <!-- Delete -->
            <li>
                <a class="dropdown-item text-danger delete_client_btn" 
                   href="javascript:void(0);" 
                   data-id="' . $data->id . '">
                    <i class="ri-delete-bin-5-line me-2"></i> Delete
                </a>
            </li>
            <!-- History -->
            <li>
                <a class="dropdown-item text-primary" 
                   href="' . route('clients.history', ['id' => $data->id]) . '">
                    <i class="ri-history-line me-2"></i> History
                </a>
            </li>
           
        </ul>
    </div>';
        })
        ->rawColumns(['plan_count', 'phone', 'price', 'start_date', 'action'])
        ->make(true);
    }
    return view('clients.list')->with('service_types', $service_types)->with('countries', $countries);
  }

  public function store(StoreClientRequest $request)
  {
    $expireDate = getPlanExpireDate($request->input('start_date'), $request->input('plan_duration'));
    $client = new Client();
    $client->name = $request->input('name');
    $client->email = $request->input('email');
    $client->phone = $request->input('phone');
    $client->country_id = $request->input('country_id');
    $client->save();

    $plan = new Plan();
    $plan->client_id = $client->id;
    $plan->website_type_id = $request->input('website_type_id');
    $plan->platform_id = $request->input('platform_id');
    $plan->service_id = $request->input('service_id');
    $plan->category_id = $request->input('category_id');
    $plan->domain_name = $request->input('domain_name');
    $plan->start_date = $request->input('start_date');
    $plan->expire_date = $expireDate;
    $plan->duration = $request->input('duration');
    $plan->is_plan_active = 1;
    $plan->price = $request->price;
    $plan->status = 'active';
    $plan->save();
    if($plan){
      MessageFlashHelper('success','Clients stored successfully!!');
      return redirect()->route('clients.index');
    }
    else{
      MessageFlashHelper('error','Something went wrong!!');
      return redirect()->route('clients.index');
    }
   }


  public function destroy($id)
  {
    $client = Client::find($id);
    if (!$client) {
      return response()->json(['message' => 'Client not found'], 404);
    }
    $client->delete();
    return response()->json(['message' => 'Client deleted successfully'], 200);
  }

  public function get($id)
  {

    $client = Client::with('plans')->with('country')->find($id);

    if (!$client) {
      return response()->json(['message' => 'Client not found'], 404);
    }
    return response()->json(['client' => $client], 200);
  }

  public function update(Request $request)
  {
    $client = Client::find($request->input('client_id'));
    $client->name = $request->input('name');
    $client->email = $request->input('email');
    $client->phone = $request->input('phone');
    $client->country_id = $request->input('country_id');
    $client->save();
    return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
  }

  public function getSearchExpiringData($data)
  {
    $get_service_plan_id = $data['service_type_id'];
    $start_date = $data['start_date'];
    $end_date = $data['end_date'];

    $data = Plan::with('service_type')
      ->with('clients')
      ->where('is_plan_active', 1)
      ->when($get_service_plan_id != false, function ($q) use ($get_service_plan_id) {
        return $q->where('service_id', $get_service_plan_id);
      })
      ->whereDate('expire_date', '>=', $start_date)
      ->whereDate('expire_date', '<=', $end_date)
      ->get();
    return $data;
  }

  // public function expiringList(Request $request)
  // {

  //   $filter_start_date = $request->input('start_date');
  //   $filter_end_date = $request->input('end_date');
  //   $service_plan_slug = $request->input('service_type');
  //   $get_service_plan_id = $this->getIdFromSlug($service_plan_slug);

  //   $data = Plan::with('service_type')
  //     ->with('clients')
  //     ->where('is_plan_active', 1)

  //     ->when($get_service_plan_id != false, function ($q) use ($get_service_plan_id) {
  //       return $q->where('service_id', $get_service_plan_id);
  //     })
  //     ->whereDate('expire_date', '>=', $filter_start_date)
  //     ->whereDate('expire_date', '<=', $filter_end_date)
  //     ->get();


  //   $service_types = ServiceType::where('status', 'active')->get();
  //   // $data = Client::select(['id', 'name', 'email', 'start_date', 'end_date', 'service_type', 'domain_name', 'phone', 'plan_duration'])->get();
  //   // return $data;
  //   if ($request->ajax()) {
  //     return Datatables::of($data)
  //       ->addIndexColumn()
  //       ->editColumn('name', function ($data) {
  //         return $data->clients()->first()->name;
  //       })
  //       ->editColumn('phone', function ($data) {
  //         return $data->clients()->first()->phone;
  //       })
  //       ->editColumn('email', function ($data) {
  //         return $data->clients()->first()->email;
  //       })
  //       ->editColumn('service_type', function ($data) {
  //         return $data->service_type()->first()->name;
  //       })

  //       ->editColumn('start_date', function ($data) {
  //         $start = Carbon::parse($data->start_date)->format('d-m-Y');
  //         $end = Carbon::parse($data->expire_date)->format('d-m-Y');

  //         return '
  //       <div style="font-size:12px;line-height:1.4;">
  //           <span style="font-weight:700; color:#2563eb;">Start:</span>
  //           <span style="padding:3px 8px;border-radius:8px;background:#2563eb;color:#fff;margin-left:4px;display:inline-block;">
  //               ' . $start . '
  //           </span>
  //           <br>
  //           <span style="font-weight:700; color:#dc2626;">End:</span>
  //           <span style="padding:3px 8px;border-radius:8px;background:#dc2626;color:#fff;margin-left:4px;display:inline-block;">
  //               ' . $end . '
  //           </span>
  //       </div>
  //       ';
  //       })
  //       // ->editColumn('expire_date', function ($data) {
  //       //   return Carbon::parse($data->expire_date)->format('d-m-Y');
  //       // })
  //       // ->editColumn('price', function ($data) {
  //       //   return $data->price . '₹';
  //       // })
  //       ->editColumn('duration', function ($data) {

  //         if (isset($data->duration)) {
  //           // return $data->duration . "yr";

  //           $dummyDuration = $data->duration . "yr";
  //           $dummyPrice = $data->price . '₹';
  //           return '
  
  //       <div>
  //           <span style="font-weight:700;">Duration:</span>
  //           <span style="padding:3px 8px;background:#059669;color:#fff;border-radius:8px;">
  //               ' . $dummyDuration . '
  //           </span>
  //       </div>

  //       <div>
  //           <span style="font-weight:700;">Price:</span>
  //           <span style="padding:3px 8px;background:#7c3aed;color:#fff;border-radius:8px;">
  //               ' . $dummyPrice . '
  //           </span>
  //       </div>

  //   </div>
  //   ';
  //         } else {
  //           return "--";
  //         }
  //       })
  //       ->addColumn('action', function ($data) {
  //         return '<div class="hstack gap-2 flex-wrap">
  //               <a href="' . route('clients.renew.plan') . '?id=' . $data->id . '" class="text-info fs-14 lh-1">
  //           <i class="ri-edit-line"></i>
  //            </a>

  //               <a href="javascript:void(0);" class="text-danger delete_client_btn fs-14 lh-1" data-id="' . $data->id . '"><i
  //                       class="ri-delete-bin-5-line"></i>
  //               </a>
  //           </div>';
  //       })
  //       ->rawColumns(['duration', 'start_date', 'action'])
  //       ->make(true);
  //   }
  //   return view('clients.expiring_list')->with('service_types', $service_types);


  //   // return view('clients.expiring_list');
  // }

  public function ReNewPlan(Request $request)
  {
    $service_types = ServiceType::where('status', 'active')->get();
    $plan_id = $request->query('id');
    $notes = Note::where(['plan_id' => $plan_id])->get();
    $plan = Plan::select('client_id')->find($plan_id);
    $client_id = $plan->client_id;
    return view('clients.renew_plan', compact('service_types', 'plan_id', 'notes', 'client_id'));
  }

  public function ReNewPlanStore(Request $request)
  {
    $note = new Note();
    $note->plan_id = $request->plan_id;
    $note->note = $request->note;
    $note->save();
    if ($request->process_plan == "1") {
      $old_plans = Plan::where(['id', $request->$request->plan_id, 'is_plan_active' => 1])->first();
      $old_plans->is_plan_active = 0;
      $old_plans->save();
      ///////////////////////////////////////////////////////////////////////////////////////////////

      //Renew Latest Plan;
      $startDate = Carbon::parse($request->input('start_date'));
      $years = (int) $request->input('plan_duration'); // Convert to integer
      $expireDate = $startDate->copy()->addYears($years);

      $plan = new Plan();
      $plan->client_id = $request->client_id;
      $plan->service_id = $request->service_type;
      $plan->domain_name = $request->domain_name;
      $plan->start_date = $request->start_date;
      $plan->expire_date = $expireDate;
      $plan->duration = $request->plan_duration;
      $plan->price = $request->price;
      $plan->status = "active";
      $plan->is_plan_active = 1;
      $plan->save();
      //------------------------------------------------------------------------------------------------------------//
    }
    return redirect()->back();
  }


  public function getSearchClientData($data)
  {
    $data = Client::when($data['start_date'] && $data['end_date'], function ($q) use ($data) {
      $q->whereDate('created_at', '>=', $data['start_date'])
        ->whereDate(
          'created_at',
          '<=',
          $data['end_date']
        );
    })

      ->when($data['service_type_id'], function ($q) use ($data) {
        $q->whereHas('plans', function ($query) use ($data) {
          $query->where('service_id', $data['service_type_id']);
        });
      })


      ->select(['id', 'name', 'email', 'phone'])
      ->orderBy('id', 'DESC')
      ->get();

    return $data;
  }

  public function getIdFromSlug($slug)
  {
    $service_type_id = false;
    if ($slug) {
      $service_types_get_id = ServiceType::where('slug', $slug)->where('status', 'active')->first();
      $service_type_id = $service_types_get_id->id;
    }
    return $service_type_id;
  }

  public function ClientExport(Request $request)
  {
    $service_type_slug = $request->input('service_type');
    $service_type_id = $this->getIdFromSlug($service_type_slug); ///find service type id
    $start_date = $request->input('start_date') ?? false;
    $end_date = $request->input('end_date') ?? false;
    $search_array = ['start_date' => $start_date, 'end_date' => $end_date, 'service_type_id' => $service_type_id];
    $data = $this->getSearchClientData($search_array); //get convert excel data by filter;
    return Excel::download(new ClientListExport($data), 'filter.xlsx');
  }

  public function ExpiringListExport(Request $request)
  {
    $service_type_slug = $request->input('service_type') ?? false;
    $service_type_id = $this->getIdFromSlug($service_type_slug); ///find service type id

    $start_date = $request->input('start_date') ?? false;
    $end_date = $request->input('end_date') ?? false;
    $search_array = ['start_date' => $start_date, 'end_date' => $end_date, 'service_type_id' => $service_type_id];
    $data = $this->getSearchExpiringData($search_array); //get convert excel data by filter;

    return Excel::download(new ExpiringExportList($data), 'filter.xlsx');
  }

  public function ImportExcelClientSave(Request $request)
  {
    if ($request->hasFile('file')) {

      $file = $request->file('file');
      $extension = $file->getClientOriginalExtension();

      if (in_array($extension, ['xlsx', 'xls', 'csv'])) {

        $client_import = new ClientImport;
        Excel::import($client_import, $file);

        // dd($client_import);
        // return back()->with('success', 'File imported successfully!');
        return view('clients.import')->with('success', 'File imported successfully!')->with('data', $client_import);
      } else {
        return back()->with('error', 'Invalid file type. Allowed: xlsx, xls, csv');
      }
    } else {
      return back()->with('error', 'Please upload a file.');
    }
  }

  public function ImportExcelClientView()
  {
    return view('clients.import');
  }

  public function downloadExcel()
  {
    // return "hanji";
    $filePath = public_path('excel/demo.xlsx');
    if (file_exists($filePath)) {
      return response()->download($filePath, 'sample.xlsx', [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
      ]);
    } else {
      abort(404);
    }
  }

  public function createClient()
  {
    $where = ['status' => 'active'];
    $tables = ['countries', 'service_types', 'service_types', 'platforms', 'website_types', 'categories'];
    $data = getDataHelper($tables, $where);
    return view('clients.create', ['data' => $data]);
  }

  public function view($id)
  {
    $data = [];
    $client = Client::find($id);
    if (!$client) {
      abort(404, 'Plan not found');
    }

    $data['name'] = $client->name;
    $data['email'] = $client->email;
    $data['phone'] = $client->phone;
    $data['country'] = $client->country->name;
    return view('clients.view', ['data' => $data]);
  }

  public function history(Request $request){
    $where = ['status' => 'active'];
    $tables = ['categories', 'platforms', 'website_types', 'service_types'];
    $data = getDataHelper($tables, $where);
    $client_id = $request->query('id');
    $query= Plan::when($client_id,function($q)use($client_id){
      return $q->where('id',$client_id);
    })->get();
    if($request->ajax()){
      return DataTables::of($query)
      ->make(true);
    }
    return view('clients.history',compact('data'));
  }
}
