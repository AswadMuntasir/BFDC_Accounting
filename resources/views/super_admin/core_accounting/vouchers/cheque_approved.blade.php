@extends('layout.app')

@section('content')
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <h2 class="mb-4">Cheque Approved</h2>
          <div class="row">
          <div class="col-xl-12">
              <form class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 28px;border-radius: 10px;" method="post" action="{{ route('subsidiary_ac_post') }}">
                @csrf
                <div class="col-sm-12 col-md-12">
                    <h4>Cheque Approved</h4>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="flatpickr-input-container">
                    <div class="form-floating"><input class="form-control datetimepicker" id="journal_date_from_input" name="journal_date_from_input" type="text" placeholder="end date" data-options='{"disableMobile":true}' /><label class="ps-6" for="journal_date_from_input">Journal Date From</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="flatpickr-input-container">
                    <div class="form-floating"><input class="form-control datetimepicker" id="journal_date_to_input" name="journal_date_to_input" type="text" placeholder="end date" data-options='{"disableMobile":true}' /><label class="ps-6" for="journal_date_to_input">Journal Date To</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
                  </div>
                </div>

                <div class="col-12 gy-6">
                  <div class="row g-3 justify-content-end">
                    <div class="col-auto"><button class="btn btn-phoenix-primary px-5">Cancel</button></div>
                    <div class="col-auto"><button type="submit" class="btn btn-primary px-5 px-sm-13">Process</button></div>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-xl-12">
              <div class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 5px;border-radius: 10px;">
                <div class="col-sm-12 col-md-12">
                  <h4>Cheque List</h4>
                </div>
              </div>
            </div>
          </div>
          
          @include('layout.footer')
        </div>
      </div>
@endsection