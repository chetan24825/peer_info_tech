@extends('layouts.main')
@push('style')
<style>
/* upgrate plan style   */
.bg-indigo {
  background: linear-gradient(135deg, #4f46e5, #6366f1);
}
.btn-indigo {
  background: #4f46e5;
  color: #fff;
}
.btn-indigo:hover {
  background: #4338ca;
  color: #fff;
}
/* end upgrate plan style */
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

@endpush

@section('content')
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
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Create Plan
      </button>
    </div>
  </div>

   <!-- Page Header Close -->
  <div class="row">
  <h3>All Active Plan List</h3>

    <!-- Upgrate Model -->
 <div class="modal fade" id="upgradeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content shadow-lg border-0 rounded-4">

      <!-- Header -->
      <div class="modal-header bg-indigo text-white rounded-top-4">
        <h5 class="modal-title fw-semibold">🚀 Upgrade Plan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Form -->
      <form id="upgradeForm" method="POST" action="{{ route('upgrate.plan') }}">
        @csrf

        <div class="modal-body px-4 py-4">

          <input type="hidden" name="upgrate_plan_id" id="upgrate_plan_id">

          <!-- Plan Select -->
          <div class="mb-3">
            <label class="form-label fw-medium">Plan Duration</label>
            <select class="form-select rounded-3" name="duration" required>
              <option value="">Choose plan duration</option>
              <option value="1">1yr</option>
              <option value="2">2yr</option>
              <option value="3">3yr</option>
              <option value="4">4yr</option>
              <option value="5">5yr</option>
            </select>
          </div>

         <div class="mb-3">
            <label class="form-label fw-medium">Start Date</label>
            <input value="{{date('Y-m-d');}}"  type="date" class="form-control rounded-3" name="start_date" required>
          </div>

          <!-- Start Date -->
          <div class="mb-3">
            <label class="form-label fw-medium">Price</label>
            <input placeholder="Enter Upgrate Plan Price" type="number" class="form-control rounded-3" name="price" required>
          </div>

          <!-- Note -->
          {{-- <div class="mb-3">
            <label class="form-label fw-medium">Note (optional)</label>
            <textarea class="form-control rounded-3" rows="3" name="note"
              placeholder="Any additional note..."></textarea>
          </div> --}}

          <!-- Info box -->
          <div class="alert alert-light border rounded-3 small">
            ⚠️ Current plan will be replaced once upgraded.
          </div>

        </div>

        <!-- Footer -->
        <div class="modal-footer border-0 px-4 pb-4">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
            data-bs-dismiss="modal">Cancel</button>

          <button type="submit" class="btn btn-indigo rounded-pill px-4 shadow">
            Upgrade Now
          </button>
        </div>

      </form>

    </div>
  </div>
</div>


<!-- Upgrate Modal End -->
 



    {{--Create Modal Code Start --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel1">Create Plan Modal</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
             <form method="POST" action="{{ route('store.sub.plan') }}" class="row g-3">
              @csrf
             <input name="client_id" type="hidden" value="{{request()->client_id}}">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="service_type" class="form-label">Category</label>
                <select class="form-control" data-trigger name="category_id" id="category_id " required>
                  <option value="">Select Categories</option>
                  @foreach($data['categories'] as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="service_type" class="form-label">Website Type</label>
                <select class="form-control" data-trigger name="website_type_id" id="website_type_id" required>
                  <option value="">Select Website Type</option>
                   @foreach($data['website_types'] as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="service_type" class="form-label">Platform</label>
                <select class="form-control" data-trigger name="platform_id" id="platform_id" required>
                  <option value="">Select Platform</option>
                   @foreach($data['platforms'] as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                </select>
              </div>
 
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="service_type" class="form-label">Service Type</label>
                <select class="form-control" data-trigger name="service_id" id="service_id" required>
                  <option value="">Service Type</option>
                   @foreach($data['service_types'] as $item)
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
                <input name="price" placeholder="Enter Plan Price...." type="number" class="form-control"
                  id="input-date" required>
              </div>

              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="plan_duration" class="form-label">Plan Duration</label>
                <select class="form-control" data-trigger name="plan_duration" id="plan_duration" required>
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
    {{--Create Modal Code End --}}



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
                <input name="name" placeholder="Enter Client Name" type="text" class="form-control" id="input" required>
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
                <select class="form-control set_edit_service" {{--data-trigger--}} name="service_type" id="service_type" required>
                  <option value="{{false}}">Service Type</option>

                  {{-- @foreach($service_types as $service_type)
                    <option value="{{ $service_type->id }}">{{ $service_type->name }}</option>
                  @endforeach --}}
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
                <select class="form-control edit_plan_duration" {{--data-trigger--}} name="plan_duration" id="plan_duration" required>
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

            {{-- <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2 p-0 column">
              <div class="report_reference_filter_wrapper" style="margin-top:3px;margin-left:10px;">
                <div class="">
                  <div class="filter_dropdown">
                    <label class="from_date_label" style="margin-right:10px;">Plan:</label>
                     <select name="plan_status" id="plan_status" class="form-control focus_class">
                      <option value="active" @if (request()->plan_status == 'active') selected @endif>Active Plan</option>
                      <option value="expired" @if (request()->plan_status == 'expired') selected @endif>Expired Plan</option>
                      <option value="active" @if (request()->plan_status == 'all') selected @endif>All</option>
                    </select>
                   </div>
                </div>
              </div>
            </div> --}}


            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2 p-0 column">
              <div class="report_reference_filter_wrapper" style="margin-top:3px;margin-left:10px;">
                <div class="">
                  <div class="filter_dropdown">
                    <label class="from_date_label" style="margin-right:10px;">Service Type:</label>
                     <select name="plan_status" id="plan_status_filter" class="form-control focus_class plan_status_filter">
                      {{-- <option @if(request()->service_type == 'all') selected @endif value="">All</option> --}}
                      <option value="{{false}}">All</option>
                        {{-- @foreach ($service_types as $service_type)
                           <option 
                           @if($service_type->slug == request()->service_type) 
                           selected 
                           @endif 
                           value="{{$service_type->slug}}">{{$service_type->name}}</option>
                      @endforeach --}}
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
                        class="form-control focus_class start_date"/>
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

                  <button type="button" class="btn btn-success btn-sm filter_clients_records" id="filter_clients_records"
                    style="margin-left:5px;"><i class="fa fa-search"></i><small
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
        <div class="card-body">
           <div class="table-responsive">
            <table class="table text-nowrap table-bordered clientTable">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Service Type</th>
                  <th scope="col">About</th>
                  <th scope="col">Domain Name</th>
                  <th scope="col">Duration <br> Price</th>
                  <th scope="col">Plan Start<br>Plan End</th>
                  <th scope="col">Re-New<br>
                    Plan</th>
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

        service_type = '{{ request()->service_type }}'
        start_date = '{{ request()->start_date }}'
        end_date = '{{ request()->end_date }}'
        client_id = '{{ request()->client_id }}'

      load_datatable(service_type,start_date , end_date,client_id);
      function load_datatable(service_type="",start_date = "" , end_date = "",client_id=""){
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

          "url": "{{ route('plans.client') }}",
          "data":{
                    "service_type": service_type,
                    "start_date":start_date,
                    "end_date":end_date,
                    "client_id":client_id
          }
        },
        "columns": [

          {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
          },
          // {
          //   data: 'name',
          //   name: 'name'
          // },
          //   {
          //     data: 'email',
          //     name: 'email'
          //   },
          //   {
          //     data: 'phone',
          //     name: 'phone'
          //   },
          {
            data: 'service_type',
            name: 'service_type'
          },
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
          {
            data: 'upgrate_plan',
            name: 'upgrate_plan'
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








      $('#filter_clients_records').click(function(){
       $(".clientTable").DataTable().destroy(); // Fix here

       var plan_slug = $('.plan_status_filter').val();
       var start_date = $('.start_date').val();
       var end_date = $('.end_date').val();  
       
       
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

      $('#reset_btn').click(function(){
        alert('reset working!!');
      })

      function exportExcel(service_type = '',start_date='',end_date='') {
        let object = {
          'service_type': service_type,
          'start_date': start_date,
          'end_date': end_date,
        }

        $.ajax({
          url: "{{ route('expiring.list.export') }}",
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


      $('#export_excel_sheet').click(function(){
       $(".clientTable").DataTable().destroy(); // Fix here
       var plan_slug = $('.plan_status_filter').val();
       var start_date = $('.start_date').val();
       var end_date = $('.end_date').val();  
       load_datatable(plan_slug,start_date,end_date);
       exportExcel(plan_slug,start_date,end_date);      
      })

        $(document).on("show.bs.dropdown", ".action-settings", function () {
            $(this).find(".settings-icon").css("transform", "rotate(90deg)");
        });

        $(document).on("hide.bs.dropdown", ".action-settings", function () {
            $(this).find(".settings-icon").css("transform", "rotate(0deg)");
        });
    });


    $(document).on('click', '.upgrade-btn', function () {
    let plan_id = $(this).data('id');
    $('#upgrate_plan_id').val(plan_id);
    $('#upgradeModal').modal('show');
    });
  </script>
@endpush
