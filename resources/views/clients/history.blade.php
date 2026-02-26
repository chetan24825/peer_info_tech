@extends('layouts.main')
@section('content')
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
  </style>
  <!-- Page Header -->
  <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
      <h1 class="page-title fw-medium fs-18 mb-2">Tables</h1>
      <div class="">
        <nav>
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Plan</a></li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="btn-list">


      {{-- <button class="btn btn-primary-light btn-wave me-2">
        <i class="bx bx-crown align-middle"></i> Create
      </button> --}}



      {{-- <button class="btn btn-secondary-light btn-wave me-0">
        <i class="ri-upload-cloud-line align-middle"></i> Export Report
      </button> --}}
    </div>
  </div>
  <!-- Page Header Close -->

  <div class="row">




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
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="input-label" class="form-label">Name:</label>
                <input name="name" placeholder="Enter Client Name" type="text" class="form-control"
                  id="input" required>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="input-label" class="form-label">Email:</label>
                <input name="email" placeholder="Enter Client Email" type="text" class="form-control"
                  id="input-label" required>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="input-label" class="form-label">Phone:</label>
                <input name="phone" placeholder="Enter Client Phone" type="text" class="form-control"
                  id="input-label" required>
              </div>


              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="service_type" class="form-label">Service Type</label>
                <select class="form-control set_edit_service" {{-- data-trigger --}} name="service_type"
                  id="service_type" required>
                  <option value="{{ false }}">Service Type</option>

                  @foreach ($data['service_types'] as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="input-date" class="form-label">Domain Name:</label>
                <input name="domain_name" placeholder="Enter Domain Name" type="text" class="form-control"
                  id="input-date" required>
              </div>

              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="input-date" class="form-label">Plan Start:</label>
                <input name="start_date" placeholder="Enter Start Plan Date" type="date" class="form-control"
                  id="input-date" required>
              </div>

              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="input-date" class="form-label">Price:</label>
                <input name="number" placeholder="Enter Plan Price...." type="number" class="form-control"
                  id="input-date" required>
              </div>

              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="plan_duration" class="form-label">Plan Duration</label>
                <select class="form-control edit_plan_duration" {{-- data-trigger --}} name="plan_duration"
                  id="plan_duration" required>
                  <option value="">Select Plan Duration</option>
                  <option value="1">1 year</option>
                  <option value="2">2 years</option>
                  <option value="3">3 years</option>
                  <option value="4">4 years</option>
                  <option value="5">5 years</option>
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

            {{-- category filter --}}
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2 p-0 column">
              <div class="report_reference_filter_wrapper" style="margin-top:3px;margin-left:10px;">
                <div class="">
                  <div class="filter_dropdown">
                    <label class="from_date_label" style="margin-right:10px;">Categories:</label>
                    <select name="category" id="category"
                      class="form-control focus_class category">
                      {{-- <option @if (request()->service_type == 'all') selected @endif value="">All</option> --}}
                      <option value="{{ false }}">All</option>
                      @foreach ($data['categories'] as $item)
                        <option value="{{ $item->slug }}">
                          {{ $item->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>

            {{-- Platform filter --}}
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2 p-0 column">
              <div class="report_reference_filter_wrapper" style="margin-top:3px;margin-left:10px;">
                <div class="">
                  <div class="filter_dropdown">
                    <label class="from_date_label" style="margin-right:10px;">Platform:</label>
                    <select name="platform" id="platform" class="form-control focus_class platform">
                      {{-- <option @if (request()->service_type == 'all') selected @endif value="">All</option> --}}
                      <option value="{{ false }}">All</option>
                      @foreach ($data['platforms'] as $item)
                        <option value="{{ $item->slug }}">
                          {{ $item->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2 p-0 column">
              <div class="report_reference_filter_wrapper" style="margin-top:3px;margin-left:10px;">
                <div class="">
                  <div class="filter_dropdown">
                    <label class="from_date_label" style="margin-right:10px;">Service Type:</label>
                    <select name="service_type" id="service_type" class="form-control focus_class service_type">
                      {{-- <option @if (request()->service_type == 'all') selected @endif value="">All</option> --}}
                      <option value="{{ false }}">All</option>
                      @foreach ($data['service_types'] as $item)
                        <option value="{{ $item->slug }}">
                          {{ $item->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2 p-0 column">
              <div class="report_reference_filter_wrapper" style="margin-top:3px;margin-left:10px;">
                <div class="">
                  <div class="filter_dropdown">
                    <label class="from_date_label" style="margin-right:10px;">Website Type:</label>
                    <select name="website_type" id="website_type"
                      class="form-control focus_class website_type">
                      {{-- <option @if (request()->service_type == 'all') selected @endif value="">All</option> --}}
                      <option value="{{ false }}">All</option>
                      @foreach ($data['website_types'] as $item)
                        <option  value="{{ $item->slug }}">
                          {{ $item->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2 p-0 column">
              <div class="report_reference_filter_wrapper" style="margin-top:3px;margin-left:10px;">
                <div class="">
                  <div class="filter_dropdown">
                    <label class="from_date_label" for="from_date" style="margin-right:10px;">From:</label>
                    <input type="date" value="{{ request()->start_date }}" name="start_date" id="start_date"
                      class="form-control focus_class start_date" />
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
                      class="form-control focus_class end_date" />
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
                    style="font-weight:900">Export</small>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body m-0 p-0">
          <div class="table-responsive">
            <table class="table text-nowrap table-bordered clientTable">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Client Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Phone</th>
                  <th scope="col">About</th>
                  <th scope="col">Domain Name</th>
                  <th scope="col">Duration <br> Price</th>
                  <th scope="col">Plan Start<br>Plan End</th>
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
      platform = '{{ request()->platform }}'
      website_type = '{{ request()->website_type }}'
      category = '{{ request()->category }}'
      service_type = '{{ request()->service_type }}'
      start_date = '{{ request()->start_date }}'
      end_date = '{{ request()->end_date }}'
      id = '{{ request()->id }}'

      load_datatable(category="",platform="",website_type="",service_type="",start_date, end_date,id);
      function load_datatable(category = "",platform = "",website_type = "",service_type = "", start_date = "", end_date = "") {
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

            "url": "{{ route('clients.history') }}",
            "data": {
              "category":category,
              "website_type":website_type,
              "platform":platform,
              "service_type": service_type,
              "start_date": start_date,
              "end_date": end_date,
              "id":id
             }
          },
          "columns": [

            {
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
            // {
            //   data: 'service_type',
            //   name: 'service_type'
            // },
            // {
            //   data: 'price',
            //   name: 'price'
            // },
            {
              data: 'other_information',
              name: 'other_information'
            },
            {
              data: 'domain_name',
              name: 'domain_name'
            },
            {
              data: 'duration',
              name: 'duration'
            },
            {
              data: 'start_date',
              name: 'start_date'
            },
            // {
            //   data: 'expire_date',
            //   name: 'expire_date'
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

      $('#filter_clients_records').click(function() {
        $(".clientTable").DataTable().destroy(); // Fix here

        //new
        var category = $('.category').val();
        var platform = $('.platform').val();
        var website_type = $('.website_type').val();
        var service_type = $('.service_type').val();

        //------------------------------------------
        var start_date = $('.start_date').val();
        var end_date = $('.end_date').val();

        var url = window.location.href;
        var urlParams = new URLSearchParams(window.location.search);

        //new variable;
        var encodedServiceType = encodeURIComponent(service_type);
        var encodedCategory = encodeURIComponent(category);
        var encodedPlatform = encodeURIComponent(platform);
        var encodedWebsiteType = encodeURIComponent(website_type);

        var encodedStartDate = encodeURIComponent(start_date);
        var encodedEndDate = encodeURIComponent(end_date);


        if (urlParams.has('service_type')) {
          urlParams.set('service_type', encodedServiceType);
        } else {
          urlParams.append('service_type', encodedServiceType);
        }

      // ------------------------------------category,platform,website_type

        if (urlParams.has('category')) {
          urlParams.set('category', encodedCategory);
        } else {
          urlParams.append('category', encodedCategory);
        }

        if (urlParams.has('platform')) {
          urlParams.set('platform', encodedPlatform);
        } else {
          urlParams.append('platform', encodedPlatform);
        }

        if (urlParams.has('website_type')) {
          urlParams.set('website_type', encodedWebsiteType);
        } else {
          urlParams.append('website_type', encodedWebsiteType);
        }
        // ---------------------------------------

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
        load_datatable(category,platform,website_type,service_type,start_date, end_date);
      })

      $('#reset_btn').click(function() {
        alert('reset working!!');
      })

      function exportExcel(service_type = '', start_date = '', end_date = '') {
        let object = {
          'service_type': service_type,
          'start_date': start_date,
          'end_date': end_date,
        }

        $.ajax({
          url: "{{ route('clients.history') }}",
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
            a.download = 'expiring_plan' + " " + (todayString) + '.xlsx';
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


      $('#export_excel_sheet').click(function() {
        $(".clientTable").DataTable().destroy(); // Fix here
        var plan_slug = $('.plan_status_filter').val();
        var start_date = $('.start_date').val();
        var end_date = $('.end_date').val();
        load_datatable(plan_slug, start_date, end_date);
        exportExcel(plan_slug, start_date, end_date);
      })


    });

$(document).on("show.bs.dropdown", ".action-settings", function () {
    $(this).find(".settings-icon").css("transform", "rotate(90deg)");
});

$(document).on("hide.bs.dropdown", ".action-settings", function () {
    $(this).find(".settings-icon").css("transform", "rotate(0deg)");
});


  </script>
@endpush
