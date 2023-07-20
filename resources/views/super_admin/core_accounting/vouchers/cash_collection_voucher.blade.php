@extends('layout.app')

@section('content')
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <h2 class="mb-4">Cash Collection Voucher</h2>
          <form>
          <div class="row">
            <div class="col-xl-12">
              <div class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 28px;border-radius: 10px;">
                <div class="col-sm-12 col-md-12">
                    <h4>Cash Collection Voucher</h4>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="flatpickr-input-container">
                    <div class="form-floating"><input class="form-control datetimepicker" id="collection_date_from_input" name="collection_date_from_input" type="text" placeholder="end date" data-options='{"disableMobile":true}' /><label class="ps-6" for="collection_date_from_input">Collection Date From</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="flatpickr-input-container">
                    <div class="form-floating"><input class="form-control datetimepicker" id="collection_date_to_input" name="collection_date_to_input" type="text" placeholder="end date" data-options='{"disableMobile":true}' /><label class="ps-6" for="collection_date_to_input">Collection Date To</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
                  </div>
                </div>

                <div class="col-12 gy-6">
                  <div class="row g-3 justify-content-end">
                    <div class="col-auto"><button class="btn btn-phoenix-primary px-5">Cancel</button></div>
                    <div class="col-auto"><button id="save_voucher_btn" class="btn btn-primary px-5 px-sm-13" disabled>Save Voucher</button></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-12">
              <div class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 5px;border-radius: 10px;">
                <div class="col-sm-12 col-md-12">
                  <h4>Cash Collection Voucher List</h4>
                </div>
                <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;head_id&quot;,&quot;group_name&quot;,&quot;accounts_name&quot;],&quot;page&quot;:5,&quot;pagination&quot;:true}">
                  <div class="table-responsive">
                      <table class="table table-striped table-sm fs--1 mb-0">
                      <thead>
                          <tr>
                              <th class="border-top" data-sort="select" style="width:10%"></th>
                              <th class="sort border-top" data-sort="serial">Serial</th>
                              <th class="sort border-top" data-sort="voucher_type">Voucher Type</th>
                              <th class="sort border-top" data-sort="voucher_date">Voucher Date</th>
                              <th class="sort border-top" data-sort="amount">Amount</th>
                              <th class="sort text-end align-middle pe-0 border-top" scope="col">ACTION</th>
                          </tr>
                      </thead>
                      <tbody class="list"> 
                        @foreach($collection_entry as $cash_voucher)
                          <tr>
                            <td class="align-middle ps-3 select" style="width:10%">
                              <div class="form-check form-check-inline" style="padding-top: 0.5rem;">
                                <input class="form-check-input" name="selector[]" id="inlineCheckbox{{ $cash_voucher->id }}" type="checkbox" value="{{ $cash_voucher->id }}" />
                              </div>
                            </td>
                            <td class="align-middle ps-3 serial">{{ $cash_voucher->id }}</td>
                            <td class="align-middle voucher_type">{{ $cash_voucher->collection_type }}</td>
                            <td class="align-middle voucher_date">{{ $cash_voucher->collection_date }}</td>
                            <td class="align-middle amount">{{ $cash_voucher->collection_amount }}</td>
                            <td class="align-middle white-space-nowrap text-end pe-0">
                              <div class="font-sans-serif btn-reveal-trigger position-static"><button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><svg class="svg-inline--fa fa-ellipsis fs--2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z"></path></svg><!-- <span class="fas fa-ellipsis-h fs--2"></span> Font Awesome fontawesome.com --></button>
                                <div class="dropdown-menu dropdown-menu-end py-2">
                                  <a class="dropdown-item" href="#!">Edit</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item text-danger" href="#!">Remove</a>
                                </div>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                  </div>
                  <div class="d-flex justify-content-center mt-3"><button class="page-link disabled" data-list-pagination="prev" disabled=""><svg class="svg-inline--fa fa-chevron-left" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"></path></svg><!-- <span class="fas fa-chevron-left"></span> Font Awesome fontawesome.com --></button>
                      <ul class="mb-0 pagination"><li class="active"><button class="page" type="button" data-i="1" data-page="5">1</button></li><li><button class="page" type="button" data-i="2" data-page="5">2</button></li><li><button class="page" type="button" data-i="3" data-page="5">3</button></li></ul><button class="page-link" data-list-pagination="next"><svg class="svg-inline--fa fa-chevron-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path></svg><!-- <span class="fas fa-chevron-right"></span> Font Awesome fontawesome.com --></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </form>
          <script>
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('input[type="checkbox"]').change(function() {
              // Check if any checkbox is selected
              if ($('input[type="checkbox"]:checked').length > 0) {
                // Enable the submit button
                $('#save_voucher_btn').prop('disabled', false);
              } else {
                // Disable the submit button
                $('#save_voucher_btn').prop('disabled', true);
              }
            });

            $('#save_voucher_btn').click(function(e) {
                e.preventDefault();

                var checkboxes = []; // Array to store the checkbox values

                $('input[type=checkbox]:checked').each(function() {
                    checkboxes.push($(this).val()); // Add the checked checkbox value to the array
                });

                // console.log(checkboxes);

                // Send the AJAX request
                $.ajax({
                    type: 'POST',
                    url: '{{ route("cash_voucher_update") }}',
                    data: {
                        checkboxes: checkboxes // Send the array as data to the controller
                    },
                    success: function(response) {
                        // Handle the response from the controller
                        console.log(response);
                        location.reload(true);
                    },
                    error: function(xhr) {
                        // Handle any errors
                        console.log(xhr);
                    }
                });
            });
          </script>
          @include('layout.footer')
        </div>
      </div>
@endsection