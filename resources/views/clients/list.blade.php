@extends('layouts.main')
@section('content')
@include('includes.message')
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
            <li class="breadcrumb-item"><a href="javascript:void(0);">Clients</a></li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
          </ol>
         </nav>
      </div>
    </div>

    <div class="btn-list">
      <a class="btn btn-primary" href="{{ route('clients.create') }}">Create Client</a>
    </div>
  </div>
  <!-- Page Header Close -->
  <div class="modal fade" id="EditClient" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel1">Update</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('clients.update') }}" class="row g-3">
            @csrf
            <input type="hidden" name="client_id" id="client_id" class="edit_client_id" value="">
            <input type="hidden" name="plan_id" id="plan_id" class="edit_plan_id" value="">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <label for="input-label" class="form-label">Name:</label>
              <input name="name" placeholder="Enter Client Name" type="text" class="form-control edit_name"
                id="input" required>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <label for="input-label" class="form-label">Email:</label>
              <input name="email" placeholder="Enter Client Email" type="text" class="form-control edit_mail"
                id="input-label" required>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <label for="input-label" class="form-label">Phone:</label>
              <input name="phone" placeholder="Enter Client Phone" type="text" class="form-control edit_phone"
                id="input-label" required>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <label for="service_type" class="form-label">Select Country</label>
              <select class="form-control country_edit_class" {{-- data-trigger --}} name="country_id" id="country_id"
                required>
                <option value="">Choose Country</option>
                @foreach ($countries as $country)
                  <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
              </select>
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
        <div class="row w-100 mr-0 d-flex">
 
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

              <button type="button" class="btn btn-success btn-sm filter_clients_records" id="filter_clients_records"
                style="margin-left:5px;"><i class="fa fa-search"></i><small style="font-weight:900">Filter</small>
              </button>

              <button type="button" class="btn btn-danger btn-sm" id="reset_btn" style="margin-left:5px;"><i
                  class="ik ik-refresh-ccw"></i><small style="font-weight:900">Reset</small>
              </button>


              <button type="button" class="btn btn-primary btn-sm" id="export_excel_sheet"
                style="margin-left:5px;"><i class="fa fa-file-export"></i><small
                  style="font-weight:900">Export</small></button>
            </div>
          </div>


        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table text-nowrap table-bordered clientTable">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Client Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Plan Count</th>
                {{-- <th scope="col">Service Type</th> --}}
                {{-- <th scope="col">Domain Name</th> --}}
                {{-- <th scope="col">Plan Duration</th> --}}
                {{-- <th scope="col">Duration+Price</th> --}}
                {{-- <th scope="col">Validity</th> --}}
                {{-- <th scope="col">Plan End</th> --}}
                <th scope="col">Action</th>
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
            "url": "{{ route('clients.index') }}",
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
              data: 'email',
              name: 'email'
            },
            {
              data: 'phone',
              name: 'phone'
            },
            {
              data: 'plan_count',
              name: 'plan_count'
            },
            // {
            //   data: 'service_type',
            //   name: 'service_type'
            // },
            // {
            //   data: 'domain_name',
            //   name: 'domain_name'
            // },
            // {
            //   data: 'plan_duration',
            //   name: 'plan_duration'
            // },
            // {
            //   data: 'price',
            //   name: 'price'
            // },
            // {
            //   data: 'start_date',
            //   name: 'start_date'
            // },
            // {
            //   data: 'end_date',
            //   name: 'end_date'
            // },
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
          url: "{{ route('clients.export') }}",
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

      $(document).on('click', '.edit_client_btn', function(e) {
        e.preventDefault();
        var clientId = $(this).data('id');
        $.ajax({
          url: '/clients/get/' + clientId,
          type: 'GET',
          success: function(response) {
            // $("#service_type").val("");
            // alert(client.service_type);
            var client = response.client;
            var price = response?.client?.plans[0]['price'];
            var duration = response?.client?.plans[0]['duration'];
            var start_date = response?.client?.plans[0]['start_date'];
            var domain_name = response?.client?.plans[0]['domain_name'];
            var service_plan_id = response?.client?.plans[0]['service_id'];
            var plan_id = response?.client?.plans[0]['id'];
            var get_country_id = response?.client?.country['id'];

            console.log(client);



            // Populate modal fields with client data
            // $('#exampleModalLabel1').text('Edit Client - ' + client.name);
            $('.country_edit_class').val(get_country_id);
            $('.edit_name').val(client.name);
            $('.edit_mail').val(client.email);
            $('.edit_phone').val(client.phone);

            $('.set_edit_service').val(client.service_type);
            $('.edit_plan_duration').val(duration);
            $('.edit_client_id').val(client.id);
            $('.edit_plan_id').val(plan_id);

            $(".set_edit_service").val(service_plan_id).change();
            $('.domain_name').val(domain_name);
            $('.start_date').val(start_date.split(" ")[0]);

            $('.edit_plan_price').val(price);


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

      $(document).on('click', '.delete_client_btn', function(e) {
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
            var clientId = $(this).data('id'); // make sure 'this' is correct in context
            $.ajax({
              url: '/clients/' + clientId,
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

    $(document).on("show.bs.dropdown", ".action-settings", function() {
      $(this).find(".settings-icon").css("transform", "rotate(90deg)");
    });

    $(document).on("hide.bs.dropdown", ".action-settings", function() {
      $(this).find(".settings-icon").css("transform", "rotate(0deg)");
    });
  </script>
@endpush
