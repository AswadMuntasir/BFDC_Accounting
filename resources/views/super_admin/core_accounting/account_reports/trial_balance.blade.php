@extends('layout.app')

@section('content')
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <h2 class="mb-4">Trial Balance</h2>
          <form method="post" action="{{ route('trial_balance') }}">
              @csrf
              <div class="row">
                  <div class="col-sm-12 col-md-5" id="start_date_div">
                      <div class="form-floating">
                          <input class="form-control datetimepicker" id="start_date" name="start_date" type="text" placeholder="Start Date" />
                          <label for="start_date">Start Date</label>
                      </div>
                  </div>
                  <div class="col-sm-12 col-md-5" id="end_date_div">
                      <div class="form-floating">
                          <input class="form-control datetimepicker" id="end_date" name="end_date" type="text" placeholder="End Date" />
                          <label for="end_date">End Date</label>
                      </div>
                  </div>
                  <div class="col-sm-12 col-md-2">
                      <button id="submit_date" type="submit" class="btn btn-primary" style="width: 100%; height:100%;">Show Trial Balance</button>
                  </div>
              </div>
          </form>
          <br>
          <div class="row">
             @if($data)
              <div class="col-12">
                  <div id="result-container">
                      <div style="float:right; margin-right:20%;">
                          <button id="download_button" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
                      </div>
                      <br><br>
                      <div style="border: 2px solid #000000; background-color:#ffffff; width: 60%; margin-left: auto; margin-right: auto;">
                          <div id="invoice" style="width: 100%; margin-left: auto; margin-right: auto;">
                              <div style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                                  <br><br>
                                  <div class="row">
                                      <div class="col-2">
                                          <img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="100" height="80" />
                                      </div>
                                      <div class="col-8">
                                          <center>
                                              <span style="font-size:12pt; font-weight:500;">Chattogram Fish Harbor</span>
                                              <span style="font-size:12pt; font-weight:500;">Ichanagar, Chattogram, Bangladesh</span>
                                          </center>
                                      </div>
                                      <div class="col-2"></div>
                                  </div>
                                  <div class="row">
                                      <div class="col-12">
                                          <div class="row">
                                              <div class="col-12">
                                                  <center>
                                                      <h6>Trial Balance</h6>
                                                      @if($startDate)
                                                      <span style="font-size: 8pt; font-weight:500;">As on: {{ $startDate?? ''  }} to {{ $endtDate?? ''  }}</span>
                                                      @endif
                                                      <br><br>
                                                  </center>
                                              </div>
                                              @php
                                                $grandTotaldr = 0;
                                                $grandTotalcr = 0;
                                              @endphp
                                              <div class="col-12" style="border: 1px solid #000000; font-size: 8pt;">
                                                <table style="width: 100%;">
                                                    <thead>
                                                        <tr style="border-bottom: 1px solid #000000;">
                                                            <th style="width: 40%;">Particulars</th>
                                                            <th style="width: 20%;"></th>
                                                            <th style="width: 20%; text-align: right;">Balance (DR)</th>
                                                            <th style="width: 20%; text-align: right;">Balance(CR)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $drTotal = 0;
                                                            $crTotal = 0;
                                                            $previousDrTotal = 0;
                                                            $previousCrTotal = 0;
                                                            $previous_accounts_group = "";
                                                            $previous_subsidiary_account_name = "";
                                                        @endphp
                                                        @foreach ($data as $item)
                                                            @php
                                                                $accounts_group_data = $item['account_group'];
                                                                $subsidiary_account_name_data = $item['subsidiary_account_name'];
                                                            @endphp
                                                            @if ($accounts_group_data != $previous_accounts_group)
                                                                @if($previous_accounts_group != "")
                                                                    <tr>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td><hr></td>
                                                                        <td><hr></td>
                                                                    </tr>
                                                                    <tr style="border-bottom: 1px solid #000000;">
                                                                        <td><br><br></td>
                                                                        <td>Total &nbsp;&nbsp; {{ $previous_accounts_group }}<br><br></td>
                                                                        <td style="text-align: right;">{{ $drTotal }}<br><br></td>
                                                                        <td style="text-align: right;">{{ abs($crTotal) }}<br><br></td>
                                                                    </tr>
                                                                @endif
                                                                @php
                                                                    $drTotal = 0;
                                                                    $crTotal = 0;
                                                                @endphp
                                                                <tr>
                                                                    <td><b>{{ $item['account_group'] }}</b></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                            @endif

                                                            @php
                                                                $previous_accounts_group = $item['account_group'];
                                                            @endphp

                                                            @if ($subsidiary_account_name_data != $previous_subsidiary_account_name)
                                                                <tr>
                                                                    <td><strong>{{ $item['subsidiary_account_name'] }}</strong></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                            @endif

                                                            @php
                                                                $previous_subsidiary_account_name = $item['subsidiary_account_name'];
                                                            @endphp

                                                            <tr>
                                                                <td>{{ $item['name'] }}</td>
                                                                <td></td>
                                                                @php
                                                                    if($item['amount'] > 0) {
                                                                    $drTotal = $drTotal + $item['amount'];
                                                                    $grandTotaldr = $grandTotaldr + $item['amount'];
                                                                @endphp
                                                                <td style="text-align: right;">{{ $item['amount'] }}</td>
                                                                <td style="text-align: right;"> - </td>
                                                                @php
                                                                    } else if($item['amount'] < 0) {
                                                                        $crTotal = $crTotal + $item['amount'];
                                                                        $grandTotalcr = $grandTotalcr + $item['amount'];
                                                                @endphp
                                                                <td style="text-align: right;"> - </td>
                                                                <td style="text-align: right;">{{ abs($item['amount']) }}</td>
                                                                @php
                                                                    }else {
                                                                        $crTotal = $crTotal + $item['amount'];
                                                                        $grandTotalcr = $grandTotalcr + $item['amount'];
                                                                @endphp
                                                                <td style="text-align: right;"> - </td>
                                                                <td style="text-align: right;"> - </td>
                                                                @php
                                                                    }
                                                                @endphp
                                                            </tr>

                                                            
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                              </div>
                                              <div class="col-12">
                                                <table style="width: 100%;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 40%;"></td>
                                                            <td style="width: 20%; font-size: 10pt;"><b>Grand Total</b></td>
                                                            <td style="width: 20%; font-size: 10pt; text-align: right;"><b>{{ $grandTotaldr }}</b></td>
                                                            <td style="width: 20%; font-size: 10pt; text-align: right;"><b>{{ abs($grandTotalcr) }}</b></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <br><br><br>
                                              </div>
                                            <div class="col-3" style="text-align: center; font-size: 8pt;">
                                                Asstt Accountant
                                                <br><br>
                                            </div>
                                            <div class="col-3" style="text-align: center; font-size: 8pt;">
                                                Accountant
                                                <br><br>
                                            </div>
                                            <div class="col-3" style="text-align: center; font-size: 8pt;">
                                                Asstt Chief Accountant
                                                <br><br>
                                            </div>
                                            <div class="col-3" style="text-align: center; font-size: 8pt;">
                                                Chief Accountant
                                                <br><br>
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                                  <br><br>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              @else
                <div class="col-12">
                  <div id="result-container"> Now Data Found</div>
                </div>
              @endif
          </div>
        @include('layout.footer')
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
          // Initialize datetimepicker
          $(document).ready(function() {
              $('.datetimepicker').datetimepicker({
                  format: 'YYYY-MM-DD',
                  ignoreReadonly: true
              });
          });

        //   // Download as PDF
        //   const html2pdf = require('html2pdf');

        //   document.addEventListener('DOMContentLoaded', function() {
        //     document.getElementById('download_button').addEventListener('click', function() {
        //         const invoice = document.getElementById('invoice');
        //         const options = {
        //             margin: 0.5,
        //             filename: 'trial_balance.pdf',
        //             image: { type: 'jpeg', quality: 1 },
        //             html2canvas: { scale: 2 },
        //             jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        //         };

        //         html2pdf().set(options).from(invoice).save();
        //     });
        //   });
      </script>
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
      </div>
@endsection