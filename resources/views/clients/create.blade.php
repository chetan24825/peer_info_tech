@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="my-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h1 class="fw-semibold fs-18 mb-1">Create Client</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Clients</a>
                    </li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
            {!! successAlert() !!}
        </div>
    </div>

    {{-- Main Card --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="{{ route('clients.store') }}">
                @csrf

                {{-- ================= BASIC INFORMATION ================= --}}
                <h6 class="fw-semibold mb-3 border-bottom pb-2">Basic Information</h6>
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Enter Client Name"
                               value="{{ old('name', $client->name ?? '') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="Enter Client Email"
                               value="{{ old('email', $client->email ?? '') }}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text"
                               name="phone"
                               class="form-control"
                               placeholder="Enter Phone Number"
                               value="{{ old('phone', $client->phone ?? '') }}">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Country</label>
                        <select name="country_id"  data-trigger class="form-control">
                            <option value="">Select Country</option>
                            @foreach ($data['countries']->unique('name') as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country_id', $client->country_id ?? '') == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                {{-- ================= SERVICE DETAILS ================= --}}
                <h6 class="fw-semibold mt-4 mb-3 border-bottom pb-2">Service Details</h6>
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Service Type</label>
                        <select name="service_id"  data-trigger class="form-control">
                            <option value="">Select Service</option>
                            @foreach ($data['service_types'] as $service)
                                <option value="{{ $service->id }}"
                                    {{ old('service_id', $client->service_id ?? '') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Domain Name <span class="text-danger">*</span></label>
                        <input type="text"
                               name="domain_name"
                               class="form-control"
                               placeholder="example.com"
                               value="{{ old('domain_name', $client->domain_name ?? '') }}">
                        @error('domain_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                {{-- ================= PLAN INFORMATION ================= --}}
                <h6 class="fw-semibold mt-4 mb-3 border-bottom pb-2">Plan Information</h6>
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Start Date</label>
                        <input type="date"
                               name="start_date"
                               class="form-control"
                               value="{{ old('start_date', date('Y-m-d')) }}">
                        @error('start_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Price <span class="text-danger">*</span></label>
                        <input type="number"
                               name="price"
                               class="form-control"
                               placeholder="Enter Price"
                               value="{{ old('price', $client->price ?? '') }}">
                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Duration</label>
                        <select name="duration" class="form-control">
                            <option value="">Select Duration</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}"
                                    {{ old('duration', $client->duration ?? '') == $i ? 'selected' : '' }}>
                                    {{ $i }} Year{{ $i > 1 ? 's' : '' }}
                                </option>
                            @endfor
                        </select>
                        @error('duration')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                {{-- ================= WEBSITE DETAILS ================= --}}
                <h6 class="fw-semibold mt-4 mb-3 border-bottom pb-2">Website Details</h6>
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Website Type</label>
                        <select name="website_type_id"  data-trigger class="form-control">
                            <option value="">Select Website Type</option>
                            @foreach ($data['website_types'] as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('website_type_id', $client->website_type_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('website_type_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Platform</label>
                        <select name="platform_id"  data-trigger class="form-control">
                            <option value="">Select Platform</option>
                            @foreach ($data['platforms'] as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('platform_id', $client->platform_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('platform_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Category</label>
                        <select name="category_id"  data-trigger class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($data['categories'] as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('category_id', $client->category_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                {{-- ================= ACTIONS ================= --}}
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        Save Client
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
