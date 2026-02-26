<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PlatformController extends Controller
{

    public $table_name = 'platforms';
    public $success_message =  'Platform';
    private $folder_prefix = "platform";

    public function index(Request $request)
    {
        $data = Platform::get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<div class="hstack gap-2 flex-wrap">
                <a href="javascript:void(0);" class="text-info fs-14 lh-1 edit_btn" data-id="' . $data->id . '"><i
                        class="ri-edit-line"></i>
                </a>
                <a href="javascript:void(0);" class="text-danger delete_btn fs-14 lh-1" data-id="' . $data->id . '"><i
                        class="ri-delete-bin-5-line"></i>
                </a>
            </div>';
                })
                ->make(true);
        }

        return view($this->folder_prefix . '.' . 'list');
    }

    public function update(Request $request)
    {
        $response = updateHelper($this->table_name, $request->update_id, $request, $this->success_message);
        if ($request) {
            return redirect()->back();
        } else {
            return response()->json(['success' => true]);
        }
    }

    public function getById($id)
    {
        $data = SearchByIdHelper($this->table_name, $id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data], 200);
        } else {
            return response()->json(['success' => true, 'data' => $data], 200);
        }
    }

    public function delete($id)
    {
        deleteHelper($this->table_name, $id, $this->success_message);
    }


    public function store(Request $request)
    {
        $store = storeHelper($this->table_name, $request, $this->success_message);
        if ($store) {
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
