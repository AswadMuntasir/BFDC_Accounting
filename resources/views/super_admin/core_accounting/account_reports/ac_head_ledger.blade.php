@extends('layout.app')

@section('content')
  <script src="{{ asset('vendors/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('vendors/simplebar/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/config.js') }}"></script>

  <!-- ===============================================-->
  <!--    Stylesheets-->
  <!-- ===============================================-->
  <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
  <link href="{{ asset('vendors/simplebar/simplebar.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
  <link href="{{ asset('assets/css/theme.min.css') }}" type="text/css" rel="stylesheet" id="style-default">
  <link href="{{ asset('assets/css/user-rtl.min.css') }}" type="text/css" rel="stylesheet" id="user-style-rtl">
  <link href="{{ asset('assets/css/user.min.css') }}" type="text/css" rel="stylesheet" id="user-style-default">
  <script src="{{ asset('assets/js/jquery-3.6.4.min.js') }}"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <!-- jsPDF library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>

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
    <!-- Content Starts Here -->
    <div class="content">
      <h2 class="mb-4">AC Head Ledger</h2>
      <div class="row">
        <form action="{{ route('acHeadLedgerView') }}" method="POST">
          @csrf
          <div class="row">
            <!-- <div class="col-4">
              <div class="form-group">
                <label for="ac_head_name_eng">Select AC Head:</label>
                <select class="form-control" name="ac_head_name_eng" id="ac_head_name_eng">
                    <option value="">Select AC Head</option>
                    @foreach ($accounts as $account)
                    <option value="{{ $account }}">{{ $account }}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="col-3">
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
            <div class="col-sm-12 col-md-4">
              <div class="form-floating">
                <select class="select2 form-select" id="ac_head_name_eng" name="ac_head_name_eng">
                  <option value="">Select Account Head</option>
                  @foreach ($accounts as $account)
                    <option value="{{ $account }}">{{ $account }}</option>
                  @endforeach
                </select><label for="ac_head_name_eng">Select Account Head:</label></div>
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
            <div class="col-2">
              <button type="submit" class="btn btn-primary" style="margin-top: 4px;">Search</button>
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
                    <h6>{{ $selectedAccountName }}</h6>
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
                      <tr>
                        <th style="text-align: center;">Date</th>
                        <th style="text-align: center;">Voucher No</th>
                        <th style="text-align: center;">Description</th>
                        <th style="text-align: center;">DR (TK.)</th>
                        <th style="text-align: center;">CR (TK.)</th>
                        <th style="text-align: center;">Balance (TK.)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                        <td></td>
                        <td>Opening Balance</td>
                        <td>
                          <?php echo ($openingBalance > 0) ? number_format($openingBalance, 2) : '0'; ?>
                        </td>
                        <td>
                            <?php echo ($openingBalance < 0) ? number_format(abs($openingBalance), 2) : '0'; ?>
                        </td>
                        <td> <?php if($openingBalance > 0) {
                          $totalDr = $totalDr + (int) $openingBalance;
                          $total += (int)$openingBalance;
                        } else {
                          $totalCr = $totalCr + (int)$openingBalance;
                          $total -= (int)$openingBalance;
                        }
                         ?>
                          &nbsp; {{ $openingBalance }}</td>
                      </tr>
                      @foreach ($ledgerData as $ledger)
                        @if ($ledger->dr_amount->isNotEmpty() || $ledger->cr_amount->isNotEmpty())
                        <tr>
                          <td>&nbsp;{{ $ledger->voucher_date }}</td>
                          <td>{{ $ledger->voucher_no }}</td>
                          <td>{{ $ledger->description }}</td>
                          <td>
                            @if ($ledger->dr_amount->isNotEmpty())
                              @foreach ($ledger->dr_amount as $amount)
                                {{ $amount->amount }}<br>
                                @php
                                  $totalDr = $totalDr + (int)$amount->amount;
                                @endphp
                              @endforeach
                            @else
                              0
                            @endif
                          </td>
                          <td>
                            @if ($ledger->cr_amount->isNotEmpty())
                              @foreach ($ledger->cr_amount as $amount)
                                {{ $amount->amount }}<br>
                                @php
                                  $totalCr = $totalCr + (int)$amount->amount;
                                @endphp
                              @endforeach
                            @else
                              0
                            @endif
                          </td>
                          <td>
                            @php
                              foreach ($ledger->dr_amount as $amount) {
                                $total += (int)$amount->amount;
                              }
                              foreach ($ledger->cr_amount as $amount) {
                                $total -= (int)$amount->amount;
                              }
                            @endphp
                            &nbsp;{{ $total }}
                          </td>
                        </tr>
                        @endif
                      @endforeach
                      <tr style="border: 1px solid #ffffff;">
                        <th></th>
                        <th></th>
                        <th>Total </th>
                        <th>{{ $totalDr }}</th>
                        <th>{{ $totalCr }}</th>
                        <th></th>
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
      @include('layout.footer')
    </div>
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
@endsection