@extends('layout.app')

@section('content')
    <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
            <h2 class="mb-4">Party Ledger</h2>
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('allPartyLedgerView') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                              <div class="form-floating">
                                <input class="form-control datetimepicker" id="start_date" name="start_date" type="text" placeholder="Start Date:" />
                                <label for="type_date_input">Start Date:</label>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-5">
                              <div class="form-floating">
                                <input class="form-control datetimepicker" id="end_date" name="end_date" type="text" placeholder="End Date:" />
                                <label for="type_date_input">End Date:</label>
                              </div>
                            </div>
                            <div class="col-2">
                              <button type="submit" class="btn btn-primary" style="margin-top: 4px;">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <hr style="margin-top: 10ox;">
            
            @if ($ledgerData)
        <div style="float:right; margin-right:20%; padding-bottom: 20px;">
          <button id="download-button" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
        </div>
        <br> <br>
        <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
          <div id="invoice" style="width: 100%; margin-left: auto; margin-right: auto;">
            <div style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
              <br><br>
              <div class="row">
                <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="60" height="48" /></div>
                <div class="col-8">
                  <center>
                    <h4>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h5>
                    <h5>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</h5> <br><br>
                    <h5>Party Ledger</h5>
                    <h6>Party: {{ $partyName }}</h6>
                    <h6>From {{ $startDate }} To {{ $endDate }}</h6>
                  </center>
                </div>
                <div class="col-2"></div>
              </div>
              <div class="row">
                <div class="col-12">
                  @php
                    $totalDr = 0;
                    $totalCr = 0;
                    $total = 0;
                  @endphp
                  <table class="table table-bordered" style="width: 100%; font-size: 12px; border: 1px solid;">
                    <thead>
                      <tr style="width: 100%;">
                        <th style="text-align: center; width: 27%;">Party Name</th>
                        <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($ledgerData as $ledger)
                        <tr>
                          <td>{{ $ledger["name"] }}</td>
                          <td><center>{{ $ledger["amount"] }}</center></td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        @else
        <p>No data available.</p>
        @endif
        <script>
          $('.select2').select2();
        </script>
      @include('layout.footer')
    </div>
  </div>
  <script src="{{ asset('assets/js/moment.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
		<!-- <script src="{{ asset('assets/js/html2pdf.bundle.min.js') }}"></script> -->
		<script src="{{ asset('assets/js/html2pdf.bundle.min.js') }}"></script>
		<script src="{{ asset('assets/js/html2pdf.bundle.js') }}"></script>
		<script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
		<script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
		<script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
		<script src="{{ asset('vendors/is/is.min.js') }}"></script>
		<script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
		<script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
		<script src="https://polyfill.io/v3/polyfill.min.js"></script>
		<script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
		<script src="{{ asset('vendors/feather-icons/feather.min.js') }}"></script>
		<script src="{{ asset('vendors/dayjs/dayjs.min.js') }}"></script>
		<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
		<script src="{{ asset('assets/js/phoenix.js') }}"></script>
  <script>
    const button = document.getElementById('download-button');
    function generatePDF() {
      // Choose the element that your content will be rendered to.
      const element = document.getElementById('invoice');
      // Choose the element and save the PDF for your user.
      html2pdf().from(element).save();
    }
    button.addEventListener('click', generatePDF);
  </script>
@endsection