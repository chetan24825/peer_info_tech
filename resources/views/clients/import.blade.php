@extends('layouts.main')
@section('content')
  <style>
    .custom - alert {
      padding: 12 px 18 px;
      border - radius: 10 px;
      font - size: 15 px;
      font - weight: 600;
      margin - bottom: 10 px;
      display: flex;
      align - items: center;
      gap: 8 px;
      color: #fff;
      animation: fadeIn 0.4 s ease - in - out;
    }
  </style>

{{-- @if($data??"")
{{print_r($data['duplicate_data'])}}
  
@endif --}}


  <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
      <h1 class="page-title fw-medium fs-18 mb-2">Import Excel Sheet Here</h1>
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
          <a href="javascript:void(0);">
            Excel
          </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Import</li>
      </ol>
    </div>
    <div>
      <a href="{{ route('download.excel') }}" class="btn btn-primary-light btn-wave me-2 waves-effect waves-light">
        <i class="bx bx-crown align-middle"></i> Download Demo Excel
      </a>
      {{-- <button class="btn btn-secondary-light btn-wave me-0 waves-effect waves-light">
        <i class="ri-upload-cloud-line align-middle"></i> Export Report
      </button> --}}
    </div>
  </div>

  @if (Session::has('success'))
    <div class="custom-alert success-alert alert-timeout">
      <i class="fa fa-check-circle"></i> {{ Session::get('success') }}
    </div>
  @endif


  <form method="POST" action="{{ route('import.excel.client.save') }}" enctype="multipart/form-data"
    class="p-4 shadow rounded bg-white">
    @csrf
    <h4 class="mb-3 fw-bold text-primary">Import Client Excel File</h4>
    <div class="mb-3">
      <label class="form-label fw-semibold">Choose Excel File</label>
      <input type="file" name="file" class="form-control @error('file') is-invalid @enderror"
        accept=".xlsx, .xls, .csv" required>

      @error('file')
        <small class="text-danger">{{ $message }}</small>
      @enderror

      <div class="form-text">Upload .xlsx, .xls or .csv file only.</div>
    </div>

    <button type="submit" class="btn btn-success w-100 py-2 fw-bold">
      <i class="fa fa-upload me-2"></i> Upload File
    </button>
  </form>




  @if(isset($data->duplicate_data) && count($data->duplicate_data) > 0)

    <h4 class="text-danger">Duplicate Records Found:</h4>
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>

        @foreach($data->duplicate_data as $row)
            <tr>
                <td>{{ $row['name'] ?? '' }}</td>
                <td>{{ $row['email'] ?? '' }}</td>
                <td>{{ $row['phone'] ?? '' }}</td>
            </tr>
        @endforeach
    </table>

@else
    <h4 class="text-success">No duplicate records</h4>
@endif


@endsection



@push('scripts')
  <script>
    setTimeout(function() {
      $('.alert-timeout').fadeOut('slow');
    }, 3000); // 3 seconds
  </script>
@endpush
