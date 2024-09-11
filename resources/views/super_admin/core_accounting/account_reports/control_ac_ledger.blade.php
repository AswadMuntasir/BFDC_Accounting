@extends('layout.app')

@section('content')
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
    <script src="{{ asset('vendors/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/ecommerce-dashboard.js') }}"></script>
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <h2 class="mb-4">Control A/C Ledger</h2>
          <div class="row">
            <!-- <form method="POST" action="{{ route('controlACLedgerView') }}"> -->
            <form action="{{ route('controlACLedgerView') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- <div class="col-4">
                        <div class="form-group">
                            <label for="account_name">Select Account Name:</label>
                            <select class="form-control" name="account_name" id="account_name">
                                <option value="">Select Account</option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account }}">{{ $account }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> -->
                    <div class="col-sm-12 col-md-4">
                      <div class="form-floating">
                        <select class="select2 form-select" id="account_name" name="account_name">
                          <option value="">Select Control Account</option>
                          @foreach ($accounts as $account)
                            <option value="{{ $account }}">{{ $account }}</option>
                          @endforeach
                        </select><label for="account_name">Select Account Name:</label></div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="form-floating">
                        <input class="form-control datetimepicker" id="start_date" name="start_date" type="text" placeholder="Start Date:" />
                        <label for="type_date_input">Start Date:</label>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="form-floating">
                        <input class="form-control datetimepicker" id="end_date" name="end_date" type="text" placeholder="End Date:" />
                        <label for="type_date_input">End Date:</label>
                      </div>
                    </div>
                    <!-- <div class="col-3">
                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>
                    </div> -->
                    <div class="col-2" style="margin-top: 4px;">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
            <hr style="margin-top: 10px;">

            @if ($ledgerData)
        <div style="float:right; margin-right:20%; padding-bottom: 20px;">
          <button id="download-button" onclick="pdf_download()" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
        </div>
        <br> <br>
        <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
          <div style="width: 100%; margin-left: auto; margin-right: auto;">
            <div id="invoice" style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
              <br><br>
              <div class="row">
                <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="60" height="48" /></div>
                <div class="col-8">
                  <center>
                    <h4>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h5>
                    <h5>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</h5> <br><br>
                    <h5>Control Account Ledger</h5>
                    <h6>Control A/C: {{ $controlACName }}</h6>
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
                        <th style="text-align: center; width: 40%;">Head Name</th>
                        <th style="text-align: center; width: 20%;">DR (TK.)</th>
                        <th style="text-align: center; width: 20%;">CR (TK.)</th>
                        <th style="text-align: center; width: 20%;">Balance (TK.)</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($ledgerData as $ledger)
                        @php
                          if($ledger['amount'] != 0) {
                        @endphp
                            <tr>
                                <td>&nbsp;{{ $ledger['name'] }}</td>
                                @php
                                if($ledger['amount'] > 0) {
                                  $totalDr = $totalDr + $ledger['amount'];
                                  $total = $total + $ledger['amount'];
                                @endphp
                                <td>{{ $ledger['amount'] }}</td>
                                <td>0</td>
                                @php
                                } else if($ledger['amount'] < 0) {
                                  $totalCr = $totalCr + abs($ledger['amount']);
                                  $total = $total + $ledger['amount'];
                                @endphp
                                <td>0</td>
                                <td>{{ abs($ledger['amount']) }}</td>
                                @php
                                }
                                @endphp
                                <td>
                                    &nbsp;{{ $total }}
                                </td>
                            </tr>
                        @php
                          }
                        @endphp
                      @endforeach
                      <tr style="border: 1px solid #ffffff;">
                        <th>Total </th>
                        <th>{{ $totalDr }}</th>
                        <th>{{ $totalCr }}</th>
                        <th>{{ $total }}</th>
                      </tr>
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
          </div>
          <script>
            $('.select2').select2();
          </script>
          <script>
            const calculatePDF = function(pdf_document) {
              const html_code = `
                  <link rel="preconnect" href="https://fonts.googleapis.com/">
                  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
                  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
                  <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
                  <div style="width: 100%; margin-left: auto; margin-right: auto;">
                      <div id="invoice" style="width: 98%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                          ${pdf_document.innerHTML}
                      </div>
                  </div>
              `;
              const new_window = window.open('', '', 'width=600', 'height=800', 'top=0');
              new_window.document.write(html_code);

              setTimeout(() => {
                  new_window.print();
                  new_window.close();
              }, 200);
            }
            function pdf_download() {
              const pdf_document = document.querySelector("#invoice");
              calculatePDF(pdf_document);
            };
          </script>
          @include('layout.footer')
        </div>
      </div>
@endsection