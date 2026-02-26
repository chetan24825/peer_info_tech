<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Plan;
use App\Models\ServiceType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class PlanController extends Controller
{
  public function index(Request $request)
  {
    $where = ['status' => 'active'];
    $tables = ['categories', 'platforms', 'website_types', 'service_types'];
    $data = getDataHelper($tables, $where);

    $category_id     = getIdFromSlug($tables[0], $request->input('category'));
    $platform_id     = getIdFromSlug($tables[1], $request->input('platform'));
    $website_type_id = getIdFromSlug($tables[2], $request->input('website_type'));
    $service_type_id      = getIdFromSlug($tables[3], $request->input('service_type'));

    if ($request->ajax()) {
      $query = Plan::when($category_id, function ($q) use ($category_id) {
        return $q->where('category_id', $category_id);
      })
        ->when($platform_id, function ($q) use ($platform_id) {
          return $q->where('platform_id', $platform_id);
        })
        ->when($website_type_id, function ($q) use ($website_type_id) {
          return $q->where('website_type_id', $website_type_id);
        })
        ->when($service_type_id, function ($q) use ($service_type_id) {
          return $q->where('service_id', $service_type_id);
        })
        ->get();
      return DataTables::of($query)
        ->addIndexColumn()
        ->editColumn('name', function ($data) {
          return $data->clients->name;
        })
        ->editColumn('phone', function ($data) {
          if ($data->clients->phone) {
            $code =  $data->clients->country->country_code ?? false;
            $country_name =  $data->clients->country->name ?? false;
            if ($code) {
              return '(' . $code . ') ' . $data->clients->phone . '</div>' . '<br>' . $country_name;
            }
            return $data->phone; // phone exists but country missing
          }
          return '--'; // no phone
        })
        ->editColumn('email', function ($data) {
          return $data->clients->email;
        })
        ->editColumn('service_type', function ($data) {
          return $data->service_type->name;
        })
        ->editColumn('other_information', function ($data) {
          $platform = $data->platforms->name ?? '-';
          $website  = $data->websites->name ?? '-';
          $category = $data->categories->name ?? '-';
          $service = $data->service_type->name ?? '-';
          return '
              <div class="info-list" style="font-size:12px; line-height:1.2; padding:4px; ">
                  <div style="margin-bottom:2px;">
                      <strong style="font-weight:600;">Platform:</strong> ' . $platform . '
                  </div>
                  <div style="margin-bottom:2px;">
                      <strong style="font-weight:600;">Website:</strong> ' . $website . '
                  </div>
                  <div style="margin-bottom:2px;">
                      <strong style="font-weight:600;">Category:</strong> ' . $category . '
                  </div>
                  <div style="margin-bottom:2px;">
                      <strong style="font-weight:600;">Service:</strong> ' . $service . '
                  </div>
              </div>
              ';
        })
        ->editColumn('start_date', function ($data) {
          $start = Carbon::parse($data->start_date)->format('d-m-Y');
          $end = Carbon::parse($data->expire_date)->format('d-m-Y');
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
        })
        ->editColumn('duration', function ($data) {
          if (isset($data->duration)) {
            $dummyDuration = $data->duration . "yr";
            $dummyPrice = $data->price . '₹';
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
            return "--";
          }
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
                <a class="dropdown-item" href="' . route('plan.view', ['id' => $data->id]) . '">
                    <i class="ri-eye-line me-2"></i> View Plan
                </a>
            </li>

            <!-- Renew Plan -->
            <li>
                <a class="dropdown-item" href="' . route('clients.renew.plan', ['id' => $data->id]) . '">
                    <i class="ri-edit-line me-2"></i> Renew Plan
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
        </ul>
    </div>';
        })


        ->rawColumns(['phone', 'other_information', 'duration', 'start_date', 'action'])
        ->make(true);
    }
    return view('plans.list', ['data' => $data]);
  }
  public function singleClientListPlan(Request $request)
  {
    $client_id = $request->query('client_id');   // returns 15 
    $where = ['status' => 'active'];
    $getDataTables = ['categories', 'platforms', 'website_types', 'service_type'];
    $data['categories'] = getDataHelper('categories', $where);
    $data['platforms'] = getDataHelper('platforms', $where);
    $data['website_types'] = getDataHelper('website_types', $where);
    $data['service_types'] = getDataHelper('service_types', $where);

    // $service_types = ServiceType::where('status', 'active')->get();
    $plan_condition = ['client_id'=>$client_id,'is_plan_active'=>1];
    $plan = Plan::where($plan_condition)->get();
    // $data = Plan::get();
    if ($request->ajax()) {
      return DataTables::of($plan)
        ->addIndexColumn()
        ->editColumn('service_type', function ($data) {
          return $data->service_type->name;
        })

        ->editColumn('other_information', function ($data) {
          $platform = $data->platforms->name ?? '-';
          $website  = $data->websites->name ?? '-';
          $category = $data->categories->name ?? '-';

          return '
        <div class="info-list">
            <div><strong>Platform:</strong> ' . $platform . '</div>
            <div><strong>Website:</strong> ' . $website . '</div>
            <div><strong>Category:</strong> ' . $category . '</div>
        </div>
    ';
        })
        ->addColumn('upgrate_plan', function ($data) {

          return '
        <a href="javascript:void(0)"
           class="upgrade-btn"
           data-id="' . $data->id . '"
           style="
             display:inline-block;
             padding:4px 10px;
             background:#4f46e5;
             color:#ffffff;
             text-decoration:none;
             border-radius:14px;
             font-size:11px;
             font-weight:500;
             line-height:1.4;
             box-shadow:0 2px 5px rgba(79,70,229,0.25);
             transition:all 0.2s ease;
           "
           onmouseover="this.style.background=\'#4338ca\'"
           onmouseout="this.style.background=\'#4f46e5\'"
        >
            Re-new
        </a>
    ';
        })

        ->editColumn('start_date', function ($data) {
          $start = Carbon::parse($data->start_date)->format('d-m-Y');
          $end = Carbon::parse($data->expire_date)->format('d-m-Y');
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
        })

        ->editColumn('duration', function ($data) {
          if (isset($data->duration)) {
            $dummyDuration = $data->duration . "yr";
            $dummyPrice = $data->price . '₹';
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
            return "--";
          }
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
                <a class="dropdown-item edit_client_btn text-success" href="javascript:void(0);" data-id="' . $data->id . '">
                    <i class="ri-edit-line me-2"></i> Edit
                </a>
            </li>        
        </ul>
    </div>';
        })
        ->rawColumns(['upgrate_plan', 'other_information', 'duration', 'start_date', 'action'])
        ->make(true);
    }


    return view('plans.client_plans', compact('data'));
  }

  public function view($id)
  {
    $plan = Plan::find($id);
    if (!$plan) {
      abort(404, 'Plan not found');
    }
    $data['name'] = $plan->clients->name;
    $data['email'] = $plan->clients->email;
    $data['phone'] = $plan->clients->phone;
    $data['country'] = $plan->clients->country->name;
    $data['service_type'] = $plan->service_type->name;
    $data['platform'] = $plan->platforms->name;
    $data['website_type'] = $plan->websites->name;
    $data['category'] = $plan->categories->name;
    $data['start_date'] = dmyHelper($plan->start_date);
    $data['expire_plan'] = dmyHelper($plan->expire_date);
    $data['duration'] = $plan->duration;
    $data['price'] = $plan->price;
    $data['status'] = ($plan->status == 'active') ? "Active" : "Deactivate";
    // return $data;
    return view('plans.view', ['data' => $data]);

    // return $data;
  }

  public function test()
  {
    $where = ['status' => 'active'];
    $data1 = getDataHelper(['categories'], $where);
    return $data1['categories'];
  }

  public function storeSubPlan(Request $request)
  {

    // return $request->all();
    $start_date = $request->start_date;
    $duration = $request->plan_duration;
    $expire_date = getPlanExpireDate($start_date, $duration);

    $save = new Plan();
    $save->client_id = $request->client_id;
    $save->service_id = $request->service_id;
    $save->domain_name = $request->domain_name;
    $save->platform_id = $request->platform_id;
    $save->website_type_id = $request->website_type_id;
    $save->category_id = $request->category_id;
    $save->start_date = $start_date;
    $save->expire_date = $expire_date;
    $save->duration = $duration;
    $save->price = $request->price;
    $save->is_plan_active = 1;
    $save->status = "active";
    $save->save();
    if ($save) {
      MessageFlashHelper('success', 'Plan Stored Successfully!!');
      return redirect()->back();
    } else {
      MessageFlashHelper('error', 'something went wrong!!');
      return redirect()->back();
    }
  }

  public function upgratePlan(Request $request)
  {
    try {

      DB::beginTransaction();
      // ✅ Validate request
      $request->validate([
        'upgrate_plan_id' => 'required|exists:plans,id',
        'duration'        => 'required|integer|min:1',
        'start_date'      => 'required|date',
      ]);

      // ✅ Inputs
      $upgrate_plan_duration   = $request->duration;
      $upgrate_plan_price      = $request->price ?? 0; // FIX: price ≠ duration
      $upgrate_plan_start_date = $request->start_date;

      // ✅ Calculate expire date
      $upgrate_plan_expire_date = getPlanExpireDate(
        $upgrate_plan_start_date,
        $upgrate_plan_duration
      );

      // ✅ Fetch old plan
      $oldPlan = Plan::findOrFail($request->upgrate_plan_id);

      // ✅ Create new upgraded plan
      $upgrate = new Plan();
      $upgrate->client_id        = $oldPlan->client_id;
      $upgrate->service_id       = $oldPlan->service_id;
      $upgrate->domain_name      = $oldPlan->domain_name;
      $upgrate->platform_id      = $oldPlan->platform_id;
      $upgrate->website_type_id  = $oldPlan->website_type_id;
      $upgrate->category_id      = $oldPlan->category_id;
      $upgrate->start_date       = $upgrate_plan_start_date;
      $upgrate->expire_date      = $upgrate_plan_expire_date;
      $upgrate->duration         = $upgrate_plan_duration;
      $upgrate->price            = $upgrate_plan_price;
      $upgrate->is_plan_active   = 1;
      $upgrate->status           = 'active';
      $upgrate->save();

      // ✅ Deactivate old plan
      $oldPlan->update([
        'status' => 'deactive',
        'is_plan_active' => 0,
      ]);
      DB::commit();
      MessageFlashHelper('success','Plan Upgrate Successfully!!');
      return redirect()->back();
    } catch (\Exception $e) {

      DB::rollBack();

      // 🔴 Log error (important in production)
      Log::error('Plan Upgrade Failed', [
        'error' => $e->getMessage(),
        'request' => $request->all(),
      ]);
      MessageFlashHelper('error', 'Something went wrong while upgrading the plan.!!');

      return redirect()->back();
    }
  }
}
