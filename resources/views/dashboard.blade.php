@extends('layouts.main')

@section('content')
    <!-- Start::page-header -->
    <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h1 class="page-title fw-medium fs-18 mb-2">Analytics</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">
                        Dashboards
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Analytics</li>
            </ol>
        </div>
        <div>
            <button class="btn btn-primary-light btn-wave me-2 waves-effect waves-light">
                <i class="bx bx-crown align-middle"></i> Plan Upgrade
            </button>
            <button class="btn btn-secondary-light btn-wave me-0 waves-effect waves-light">
                <i class="ri-upload-cloud-line align-middle"></i> Export Report
            </button>
        </div>
    </div>
    <!-- End::page-header -->

    <!-- Start:: row-1 -->
    <div class="row">
        <div class="col-xxl-9">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="">
                                <div class="d-flex justify-content-between">
                                    <span class="avatar avatar-md avatar-rounded bg-primary-transparent svg-primary mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                                            viewBox="0 0 256 256">
                                            <path
                                                d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span class="fw-medium fs-13 text-muted">Client Count</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between">
                                <div>
                                    <h3 class="fw-semibold">{{ $client_count }}</h3>

                                    {{-- <span class="fs-12 text-muted"><span class="text-success fs-12 d-inline-flex align-items-center me-1"><i
                        class="ti ti-trending-up me-1"></i>+0.892 </span>Increased</span> --}}
                                </div>
                                {{-- <div id="total-followers"></div> --}}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-3">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="">
                                <div class="d-flex justify-content-between">
                                    <span class="avatar avatar-md avatar-rounded bg-primary-transparent svg-primary mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                                            viewBox="0 0 256 256">
                                            <path
                                                d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span class="fw-medium fs-13 text-muted">Domain Count</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between">
                                <div>
                                    <h3 class="fw-semibold">{{ $client_count }}</h3>

                                    {{-- <span class="fs-12 text-muted"><span class="text-success fs-12 d-inline-flex align-items-center me-1"><i
                        class="ti ti-trending-up me-1"></i>+0.892 </span>Increased</span> --}}
                                </div>
                                {{-- <div id="total-followers"></div> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="">
                                <div class="d-flex justify-content-between">
                                    <span class="avatar avatar-md avatar-rounded bg-primary-transparent svg-primary mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                                            viewBox="0 0 256 256">
                                            <path
                                                d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span class="fw-medium fs-13 text-muted">Client Count</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between">
                                <div>
                                    <h3 class="fw-semibold">{{ $client_count }}</h3>

                                    {{-- <span class="fs-12 text-muted"><span class="text-success fs-12 d-inline-flex align-items-center me-1"><i
                        class="ti ti-trending-up me-1"></i>+0.892 </span>Increased</span> --}}
                                </div>
                                {{-- <div id="total-followers"></div> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="">
                                <div class="d-flex justify-content-between">
                                    <span class="avatar avatar-md avatar-rounded bg-primary-transparent svg-primary mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                                            viewBox="0 0 256 256">
                                            <path
                                                d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span class="fw-medium fs-13 text-muted">Client Count</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between">
                                <div>
                                    <h3 class="fw-semibold">{{ $client_count }}</h3>

                                    {{-- <span class="fs-12 text-muted"><span class="text-success fs-12 d-inline-flex align-items-center me-1"><i
                        class="ti ti-trending-up me-1"></i>+0.892 </span>Increased</span> --}}
                                </div>
                                {{-- <div id="total-followers"></div> --}}
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>

    </div>
    <!-- End:: row-1 -->

    <!-- Start:: row-2 -->

    <!-- End:: row-2 -->

    <!-- Start:: row-3 -->

    <!-- End:: row-3 -->

    </div>
    </div>
    <!-- End::app-content -->
@endsection








{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
