@extends('layouts.main')
@section('content')
@php
  $folder_name = "Country";
  $blade_file_name = "List";
@endphp
  <style>
    /* Center the processing loader */
    .dataTables_processing {
      position: absolute !important;
      top: 50% !important;
      left: 50% !important;
      transform: translate(-50%, -50%) !important;
      background: transparent !important;
      border: none !important;
      z-index: 1000;
      text-align: center;
    }

    .custom-alert {
      padding: 12px 18px;
      border-radius: 10px;
      font-size: 15px;
      font-weight: 600;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 8px;
      color: #fff;
      animation: fadeIn 0.4s ease-in-out;
    }

    .success-alert {
      background: linear-gradient(135deg, #28a745, #34ce57);
      box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3);
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-5px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>

  <!-- Page Header -->
  <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
      <h1 class="page-title fw-medium fs-18 mb-2">Tables</h1>
      <div class="">
        <nav>
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{$folder_name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$blade_file_name}}</li>
          </ol>

          @if (Session::has('success'))
            <div class="custom-alert success-alert alert-timeout">
              <i class="fa fa-check-circle"></i> {{ Session::get('success') }}
            </div>
          @endif


        </nav>
      </div>
    </div>


    <div class="btn-list">


      {{-- <button class="btn btn-primary-light btn-wave me-2">
        <i class="bx bx-crown align-middle"></i> Create 
      </button> --}}

      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        Create
      </button>

      {{-- <button class="btn btn-secondary-light btn-wave me-0">
        <i class="ri-upload-cloud-line align-middle"></i> Export Report
      </button> --}}
    </div>
  </div>
  <!-- Page Header Close -->

  <div class="row">
    {{-- Create Modal Code Start --}}
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title" id="addModalLabel1">Add Country</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">


            <form method="POST" action="{{ route('country.store') }}" class="row g-3">
              @csrf


              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="input-label" class="form-label">Name:</label>
                <input name="name" placeholder="Enter Country Name" type="text" class="form-control" id="input"
                  required>
              </div>

              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="input-label" class="form-label">Code:</label>
                <input name="code" placeholder="Enter Code Like +91,+44,+1" type="text" class="form-control"
                  id="input-label" required>
              </div>




          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save
              changes</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    {{-- Create Modal Code End --}}


    <div class="modal fade" id="EditClient" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel1">Update</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('country.update') }}" class="row g-3">
              @csrf
              @method('PUT')

              <input type="hidden" name="country_id" class="country_id">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="input-label" class="form-label">Name:</label>
                <input name="name"  type="text" class="form-control edit_name"
                  id="input" required>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="input-label" class="form-label">Code:</label>
                <input name="code"  type="text" class="form-control edit_code"
                  id="input" required>
              </div>
              


              

              

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save
              changes</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12">
      <div class="card custom-card">
        <div class="card-header justify-content-between">
          {{-- <div class="row w-100 mr-0 d-flex">
           

            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2 p-0 column">
              <div class="report_reference_filter_wrapper" style="margin-top:3px;margin-left:10px;">
                <div class="">
                  <div class="filter_dropdown">
                    <label class="from_date_label" for="from_date" style="margin-right:10px;">From:</label>
                    <input type="date" name="start_date" id="start_date"
                      class="form-control focus_class client_start_date" />
                  </div>
                </div>
              </div>
            </div>

            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2">
              <div class="report_reference_filter_wrapper" style="margin-top:3px;margin-left:10px;">
                <div class="">
                  <div class="filter_dropdown">
                    <label class="from_date_label" for="from_date" style="margin-right:10px;">To:</label>
                    <input value="{{ request()->end_date }}" type="date" name="end_date" id="end_date"
                      class="form-control focus_class client_end_date" />
                  </div>
                </div>
              </div>
            </div>

            <div style="margin-left:-27px; margin-top:11px;"
              class="col-12 col-sm-2 col-md-2 col-lg-1 col-xl-1 p-0 column">
              <div class="report_filter_btns d-flex justify-content-start align-items-end"
                style="margin-top:21px; margin-left:33px;">

                <button type="button" class="btn btn-success btn-sm filter_clients_records"
                  id="filter_clients_records" style="margin-left:5px;"><i class="fa fa-search"></i><small
                    style="font-weight:900">Filter</small>
                </button>

                <button type="button" class="btn btn-danger btn-sm" id="reset_btn" style="margin-left:5px;"><i
                    class="ik ik-refresh-ccw"></i><small style="font-weight:900">Reset</small>
                </button>


                <button type="button" class="btn btn-primary btn-sm" id="export_excel_sheet"
                  style="margin-left:5px;"><i class="fa fa-file-export"></i><small
                    style="font-weight:900">Export</small></button>
              </div>
            </div>


          </div> --}}
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-nowrap table-bordered clientTable">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Country Name</th>
                  <th scope="col">County Code</th>
                   <th scope="col">Slug</th>
                   <th scope="col">Status</th>
                   <th scope="col">Action</th>

                  {{-- <th scope="col"></th> --}}

                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>


      </div>
    </div>
  </div>
@endsection


@push('scripts')
  {{-- <script src="{{ asset('js/form-components.js') }}"></script> --}}
  <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      load_datatable(service_type = "", start_date = "", end_date = "");

      function load_datatable(service_type = "", start_date = "", end_date = "") {
        $(".clientTable").DataTable({
          order: [],
          lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
          ],
          processing: true,
          responsive: false,
          serverSide: true,
          processing: true,
          "dom": "<'row'<'col-sm-6'><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'li><'col-sm-7'p>>",
          // "buttons": ["pageLength"],
          language: {
            processing: `
              <div>
                  <i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;"></i>
                  <p style="margin-top:10px; font-size:16px; color:#555;">Loading, please wait...</p>
              </div>
          `,
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries"
          },
          scroller: {
            loadingIndicator: false
          },
          pagingType: "full_numbers",
          // dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
          order: [
            [0, "asc"]
          ],
          "ajax": {
            "url": "{{ route('country') }}",
            "data": {
              "service_type": service_type,
              "client_start_date": start_date,
              "client_end_date": end_date
            },
          },


          "columns": [{
              data: 'DT_RowIndex',
              name: 'DT_RowIndex'
            },
            {
              data: 'name',
              name: 'name'
            },
            {
              data: 'country_code',
              name: 'country_code'
            },
            {
              data: 'slug',
              name: 'slug'
            },
            {
              data: 'status',
              name: 'status'
            },
             { 
              data: 'action',
              name: 'action',
              orderable: false,
              searchable: false
            }
          ],

        });
      }


      function exportExcel(service_type = '', start_date = '', end_date = '') {
        // alert('calling function!');
        // $('#spinner').show();
        let object = {
          'service_type': service_type,
          'start_date': start_date,
          'end_date': end_date,
        }

        $.ajax({
          url: "{{ route('country') }}",
          method: 'GET',
          data: object,

          xhrFields: {
            responseType: 'blob'
          },
          success: function(data) {
            var today = new Date();
            var day = today.getDate();
            var month = today.getMonth() + 1;
            var year = today.getFullYear() % 100;

            day = day < 10 ? '0' + day : day;
            month = month < 10 ? '0' + month : month;
            year = year < 10 ? '0' + year : year;
            var todayString = day + '-' + month + '-' + year;


            var blob = new Blob([data], {
              type: 'application/octet-stream'
            });
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'clients' + " " + (todayString) + '.xlsx';
            a.style.display = 'none';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            // $('#spinner').hide();
          },
          error: function() {
            // $('#spinner').hide();
          }
        });
      }

      $(document).on('click', '.edit_country_btn', function(e) {
         e.preventDefault();
          var countryId = $(this).data('id');
           let url = "{{ route('get.country', ':id') }}";
          url = url.replace(':id', countryId);
         $.ajax({
          url: url,
           type: 'GET',
          success: function(response){
            var data = response.country;
            $('.edit_name').val(data.name);
            $('.edit_code').val(data.country_code);
            $('.country_id').val(data.id)
            $('#EditClient').modal('show');
          },
          error: function(xhr) {
            Swal.fire(
              "Error!",
              "An error occurred while fetching the client data.",
              "error"
            );
          }
        });
      });

      $(document).on('click', '.delete_country_btn', function(e) {
        e.preventDefault();
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        }).then((result) => {
          if (result.isConfirmed) {
             var country_id = $(this).data('id'); // make sure 'this' is correct in context
             let url = "{{ route('country.delete', ':id') }}";
             url = url.replace(':id', country_id);
             $.ajax({
              url: url,
              type: 'DELETE',
              data: {
                _token: '{{ csrf_token() }}'
              },
              success: function(response) {
                Swal.fire(
                  "Deleted!",
                  "Your file has been deleted.",
                  "success"
                );
                $('.clientTable').DataTable().ajax.reload();
              },
              error: function(xhr) {
                Swal.fire(
                  "Error!",
                  "An error occurred while deleting the client.",
                  "error"
                );
              }
            });

          }
        });

      });

      $('#filter_clients_records').click(function() {
        $(".clientTable").DataTable().destroy(); // Fix here
        var plan_slug = $('.plan_status_filter').val();
        // alert(plan_slug);
        var start_date = $('.client_start_date').val();
        var end_date = $('.client_end_date').val();
        var url = window.location.href;
        var urlParams = new URLSearchParams(window.location.search);
        var encodedPlanSlug = encodeURIComponent(plan_slug);
        var encodedStartDate = encodeURIComponent(start_date);
        var encodedEndDate = encodeURIComponent(end_date);
        if (urlParams.has('service_type')) {
          urlParams.set('service_type', encodedPlanSlug);
        } else {
          urlParams.append('service_type', encodedPlanSlug);
        }
        if (urlParams.has('start_date')) {
          urlParams.set('start_date', encodedStartDate);
        } else {
          urlParams.append('start_date', encodedStartDate);
        }

        if (urlParams.has('end_date')) {
          urlParams.set('end_date', encodedEndDate);
        } else {
          urlParams.append('end_date', encodedEndDate);
        }
        var newUrl = url.split('?')[0] + '?' + urlParams.toString();
        window.history.replaceState({}, document.title, newUrl);
        load_datatable(plan_slug, start_date, end_date);
      })


      $('#export_excel_sheet').click(function() {
        $(".clientTable").DataTable().destroy(); // Fix here
        var plan_slug = $('.plan_status_filter').val();
        var start_date = $('.client_start_date').val();
        var end_date = $('.client_end_date').val();
        load_datatable(plan_slug, start_date, end_date);
        exportExcel(plan_slug, start_date, end_date);
      })
      $('#reset_btn').click(function() {
        alert('reset working!!');
      })

    });



    setTimeout(function() {
      $('.alert-timeout').fadeOut('slow');
    }, 3000); // 3 seconds
  </script>
@endpush
