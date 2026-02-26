@extends('layouts.main')
@section('content')

<div class="container my-4">
    <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
      <h1 class="page-title fw-medium fs-18 mb-2">View</h1>
      <div class="">
        <nav>
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Plan</a></li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="btn-list">


      {{-- <button class="btn btn-primary-light btn-wave me-2">
        <i class="bx bx-crown align-middle"></i> Create 
      </button> --}}


      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Create
      </button>

      {{-- <button class="btn btn-secondary-light btn-wave me-0">
        <i class="ri-upload-cloud-line align-middle"></i> Export Report
      </button> --}}
    </div>
  </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <tbody>
                <tr>
                    <th>Client Name</th>
                    <td>{{$data['name']}}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{$data['email']}}</td>
                </tr>
                <tr>
                    <th>Platform</th>
                    <td>{{$data['platform']}}</td>
                </tr>
                <tr>
                    <th>Website Type</th>
                    <td>{{$data['website_type']}}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{$data['category']}}</td>
                </tr>
                <tr>
                    <th>Service Type</th>
                    <td>{{$data['service_type']}}</td>
                </tr>
                
                <tr>
                    <th>Status</th>
                    <td>{{$data['status']}}</td>
                </tr>
                <tr>
                    <th>Plan Duration</th>
                    <td>
                        <span class="badge bg-secondary">{{$data['start_date']}} - {{$data['expire_plan']}}</span>
                    </td>
                </tr>
                <tr>
                    <th>Notes</th>
                    <td>This plan includes website design, SEO optimization, and 24/7 support.</td>
                </tr>
                <tr>
                    <th>Actions</th>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                            <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

@endsection
