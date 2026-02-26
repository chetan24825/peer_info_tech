{{-- Useless File --}}

@extends('layouts.main')
@section('content')
  <div class="d-flex justify-content-center">

    <div class="col-xl-6">
      <div class="card custom-card">
        <div class="card-header justify-content-between">
          <div class="card-title">
            Client Notes
          </div>
          <div class="prism-toggle">
            {{-- <button type="button" class="btn btn-sm btn-primary-light">Renew Plan</button> --}}

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#RenewPlanModal">
              Re-new Plan
            </button>
            <div class="modal fade" id="RenewPlanModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel1">Re-new Plan</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">


                    <form method="POST" action="{{ route('clients.renew.plan.store') }}" class="row g-3">
                      @csrf
                      <input type="hidden" name="plan_id" value="{{ $plan_id }}">
                      <input type="hidden" name="client_id" value="{{ $client_id }}">
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <label for="noteTextarea" class="form-label">Enter Note:</label>
                        <textarea name="note" placeholder="Enter Note...." class="form-control" id="noteTextarea" rows="4"></textarea>
                      </div>

                      <div class="d-flex align-items-center gap-4">
                        <!-- Processed -->
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="radio" name="process_plan" id="processed"
                            value="1">
                          <label class="form-check-label" for="processed">
                            Processed
                          </label>
                        </div>

                        <!-- Not Processed -->
                        <div class="form-check form-switch">
                          <input checked class="form-check-input" type="radio" name="process_plan" id="not_processed"
                            value="0">
                          <label class="form-check-label" for="not_processed">
                            Not Processed
                          </label>
                        </div>
                      </div>

                      <div class="d-none  remove_class_not_proceed">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                          <label for="service_type" class="form-label">Service Type</label>
                          <select class="form-control service_type_renew" {{-- data-trigger --}} name="service_type"
                            id="service_type">
                            <option value="">Service Type</option>
                            @foreach ($service_types as $service_type)
                              <option value="{{ $service_type->id }}">{{ $service_type->name }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                          <label for="input-date" class="form-label">Domain Name:</label>
                          <input name="domain_name" placeholder="Enter Domain Name" type="text"
                            class="form-control doman_name_class" id="input-date">
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                          <label for="input-date" class="form-label">Plan Start:</label>
                          <input name="start_date" placeholder="Enter Start Plan Date" type="date"
                            class="form-control plan_start_date" id="input-date">
                        </div>



                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                          <label for="input-date" class="form-label">Price:</label>
                          <input name="price" placeholder="Enter Plan Price...." type="number"
                            class="form-control price_class" id="input-date">
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                          <label for="plan_duration" class="form-label">Plan Duration</label>
                          <select class="form-control plan_duration" {{-- data-trigger --}} name="plan_duration"
                            id="plan_duration">
                            <option value="">Select Plan Duration</option>
                            <option value="1">1 year</option>
                            <option value="2">2 years</option>
                            <option value="3">3 years</option>
                            <option value="4">4 years</option>
                            <option value="5">5 years</option>
                          </select>
                        </div>
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
          </div>
        </div>
        <div class="card-body">
          <div class="list-group">
            @forelse ($notes as $note)
              <a href="javascript:void(0);" class="list-group-item list-group-item-action active" aria-current="true">
                <div class="d-sm-flex w-100 justify-content-between">
                  <h6 class="mb-1 fw-medium text-fixed-white">Web page editors now use Lorem Ipsum?</h6>
                  <small>3 days ago</small>
                </div>
                <p class="mb-1">{{ $note->note }}</p>
                <small>24,Nov 2024.</small>
              </a>
              <hr>
            @empty
              <h1> Notes are not available!</h1>
            @endforelse

          </div>
        </div>
        <div class="card-footer d-none border-top-0">
        </div>
      </div>
    </div>
  </div>
@endsection


@push('scripts')
  <script>
    $(document).on("change", "input[name='process_plan']", function() {
      // alert('hanji');  

      let value = $(this).val();
      if (value == "1") {
        $('.remove_class_not_proceed').removeClass('d-none');
      }

      if (value == "0") {
        $('.remove_class_not_proceed').addClass('d-none');
        $('.service_type_renew').val("").trigger('change');
        $('.plan_start_date').val("").trigger('change');
        $('.doman_name_class').val("").trigger('change');
        $('.price_class').val("").trigger('change');
        $('.plan_duration').val("").trigger('change');
      }
    });
  </script>
@endpush
