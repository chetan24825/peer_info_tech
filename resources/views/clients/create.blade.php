@extends('layouts.main')
@section('content')
  <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
      <h1 class="page-title fw-medium fs-18 mb-2">Form</h1>
      <div class="">
        <nav>
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Clients</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
          </ol>

          {!!successAlert()!!}



        </nav>
      </div>
    </div>


    <div class="btn-list">


      {{-- <button class="btn btn-primary-light btn-wave me-2">
        <i class="bx bx-crown align-middle"></i> Create 
      </button> --}}

      {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        Create
      </button> --}}
      {{-- <a class="btn btn-primary" href="{{route('clients.create')}}">Create Client</a> --}}


      {{-- <button class="btn btn-secondary-light btn-wave me-0">
        <i class="ri-upload-cloud-line align-middle"></i> Export Report
      </button> --}}
    </div>
  </div>

  <form method="POST" action="{{ route('clients.store') }}" class="row g-3">
    @csrf

    <div class="row">
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <label for="input-label" class="form-label">Name:</label>
        <input  value="{{ old('name', $client->name ?? '') }}" name="name" placeholder="Enter Client Name" type="text" class="form-control" id="input">
      
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
      
      </div>

      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <label for="input-label" class="form-label">Email:</label>
        <input value="{{ old('email', $client->name ?? '') }}" name="email" placeholder="Enter Client Email" type="text" class="form-control" id="input-label"
          >
          @error('email')
            <span class="text-danger">{{ $message }}</span>
          @enderror
      </div>

      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <label for="input-label" class="form-label">Phone:</label>
        <input value="{{ old('phone', $client->name ?? '') }}" name="phone" placeholder="Enter Client Phone" type="text" class="form-control" id="input-label">
      
       @error('phone')
            <span class="text-danger">{{ $message }}</span>
        @enderror

      </div>

      {{-- country --}}
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <label for="service_type" class="form-label">Select Country</label>
        <select {{--data-trigger--}} class="form-control" name="country_id" id="country_id">
          <option  value="">Choose Country</option>
          @foreach ($data['countries'] as $country)
            <option 
           {{ old('country_id', $client->country_id ?? '') == $country->id ? 'selected' : '' }}
            
            value="{{ $country->id }}">{{ $country->name }}</option>
          @endforeach
        </select>
         @error('country_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      {{-- service types --}}
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <label for="service_type" class="form-label">Service Type</label>
        <select class="form-control" data-trigger name="service_id" id="service_type">
          <option value="">Service Type</option>
          @foreach ($data['service_types'] as $service_type)
            <option 
              {{ old('service_id', $client->service_type ?? '') == $service_type->id ? 'selected' : '' }}

            value="{{ $service_type->id }}">{{ $service_type->name }}</option>
          @endforeach
        </select>
        @error('service_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <label for="input-date" class="form-label">Domain Name:</label>
        <input value="{{ old('domain_name', $client->name ?? '') }}" name="domain_name" placeholder="Enter Domain Name" type="text" class="form-control" id="input-date"
          >
          @error('domain_name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <label for="input-date" class="form-label">Plan Start:</label>
        <input value="{{ date('Y-m-d') }}" name="start_date" placeholder="Enter Start Plan Date" type="date"
          class="form-control" id="input-date">

        @error('start_date')
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <label for="input-date" class="form-label">Price:</label>
        <input value="{{ old('price', $client->price ?? '') }}" name="price" placeholder="Enter Plan Price...." type="number" class="form-control" id="input-date">
        @error('price')
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
    <label for="plan_duration" class="form-label">Plan Duration</label>

    <select class="form-control" name="duration" id="duration">
        <option value="">Select Plan Duration</option>

        <option value="1" {{ old('duration', $client->duration ?? '') == 1 ? 'selected' : '' }}>1 year</option>
        <option value="2" {{ old('duration', $client->duration ?? '') == 2 ? 'selected' : '' }}>2 years</option>
        <option value="3" {{ old('duration', $client->duration ?? '') == 3 ? 'selected' : '' }}>3 years</option>
        <option value="4" {{ old('duration', $client->duration ?? '') == 4 ? 'selected' : '' }}>4 years</option>
        <option value="5" {{ old('duration', $client->duration ?? '') == 5 ? 'selected' : '' }}>5 years</option>
    </select>

    @error('duration')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>



      {{-- website type --}}
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <label for="service_type" class="form-label">Website Type</label>
        <select class="form-control" data-trigger name="website_type_id" id="website_type_id">
          <option value="">Choose Website Type</option>
          @foreach ($data['website_types'] as $item)
            <option 
            {{ old('website_type_id', $client->website_type_id ?? '') == $item->id ? 'selected' : '' }}

            value="{{ $item->id }}">{{ $item->name }}</option>
          @endforeach
        </select>
         @error('website_type_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>


      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <label for="service_type" class="form-label">Platforms:</label>
        <select class="form-control" data-trigger name="platform_id" id="platform_id">
          <option value="">Choose Platforms</option>
          @foreach ($data['platforms'] as $item)
            <option 
            {{ old('platform_id', $client->platform_id ?? '') == $item->id ? 'selected' : '' }}
            value="{{ $item->id }}">{{ $item->name }}</option>
          @endforeach
        </select>
       @error('platform_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <label for="service_type" class="form-label">Category:</label>
        <select class="form-control" {{--data-trigger--}} name="category_id" id="category_id">
          <option value="">Choose Category</option>
          @foreach ($data['categories'] as $item)
            <option 
            {{ old('category_id', $client->category_id ?? '') == $item->id ? 'selected' : '' }}
            value="{{ $item->id }}">{{ $item->name }}</option>
          @endforeach
        </select>
        @error('category_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

    </div>
    </div>
    <div class="modal-footer">
      {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
      <button type="submit" class="btn btn-primary">Save
        changes
      </button>
    </div>
  </form>
@endsection
