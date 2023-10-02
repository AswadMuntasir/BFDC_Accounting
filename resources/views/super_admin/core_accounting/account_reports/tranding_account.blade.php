@extends('layout.app')

@section('content')
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <h2 class="mb-4">Trading Account</h2>
          <form method="post" action="{{ route('trandingAccountView') }}">
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
                      <button id="submit_date" type="submit" class="btn btn-primary" style="width: 100%; height:100%;">Show Trading Account</button>
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
                                  <div class="row">
                                      <div class="col-2">
                                          <img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="100" height="80" />
                                      </div>
                                      <div class="col-8">
                                          <center>
                                              <span style="font-size: 12pt; font-weight:500;">Chattogram Fish Harbor</span>
                                              <span style="font-size: 12pt; font-weight:500;">Ichanagar, Chattogram, Bangladesh</span>
                                          </center>
                                      </div>
                                      <div class="col-2"></div>
                                  </div>
                                  <div class="row">
                                      <div class="col-12">
                                          <div class="row">
                                              <div class="col-12">
                                                  <center>
                                                      <h6>Trading Account</h6>
                                                      @if($startDate)
                                                      <span style="font-size: 8pt; font-weight:500;">As on: {{ $startDate?? ''  }} to {{ $endtDate?? ''  }}</span>
                                                      @endif
                                                      <br><br>
                                                  </center>
                                              </div>
                                              <div class="col-12" style="border: 1px solid #000000; font-size: 8pt;">
                                                <table style="width: 100%;">
                                                    <thead>
                                                        <tr style="border-bottom: 1px solid #000000;">
                                                            <th style="width: 40%;">Particulars</th>
                                                            <th style="width: 30%;"></th>
                                                            <th style="width: 30%; text-align: right;">Balance</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $incomeData = collect($data)->where('account_group', 'Income');
                                                            $servicesData = $incomeData->where('subsidiary_account_name', 'Services');
                                                            $salesAndServicesData = $incomeData->where('subsidiary_account_name', 'Sales and Services');
                                                        @endphp
                                                        <tr>
                                                            <td style="font-size: 14px;"><b>Services</b></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        @foreach ($servicesData as $item)
                                                        <tr>
                                                            <td>{{ $item['name'] }}</td>
                                                            <td></td>
                                                            <td style="text-align: right;">{{ number_format(abs($item['amount']), 2) }}</td>
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td style="text-align: right; padding-top: 10px; border-top: 1px solid #000000;">{{ number_format(abs($servicesData->sum('amount')), 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 14px;"><b>Sales and Services</b></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        @foreach ($salesAndServicesData as $item)
                                                        <tr>
                                                            <td>{{ $item['name'] }}</td>
                                                            <td></td>
                                                            <td style="text-align: right;">{{ number_format(abs($item['amount']), 2) }}</td>
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td style="text-align: right; padding-top: 10px; border-top: 1px solid #000000;">{{ number_format(abs($salesAndServicesData->sum('amount')), 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td style="text-align: right; padding-top: 10px;"><b>Total</b></td>
                                                            <td style="text-align: right; padding-top: 10px; border-top: 2px solid #000000;">{{ number_format(abs($incomeData->sum('amount')), 2) }}</td>
                                                        </tr>

                                                        @php
                                                            $expensesData = collect($data)->where('account_group', 'Expenses');
                                                            $operationalExpenditureData = $expensesData->where('subsidiary_account_name', 'Operational Expenditure');
                                                        @endphp
                                                        <tr>
                                                            <td style="font-size: 14px;"><b>Less: Expenditure</b></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        @foreach ($operationalExpenditureData as $item)
                                                        <tr>
                                                            <td>{{ $item['name'] }}</td>
                                                            <td></td>
                                                            <td style="text-align: right;">{{ number_format($item['amount'], 2) }}</td>
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td></td>
                                                            <td style="text-align: right; padding-top: 10px; padding-bottom: 10px;"><b>Total</b></td>
                                                            <td style="text-align: right; padding-top: 10px; padding-bottom: 10px; border-top: 2px solid #000000;">{{ number_format($expensesData->sum('amount'), 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 50%; font-size: 9pt; padding-top: 18px;"><b>Trading ProfiUloss(Transferred to P/L-A/C)</b></td>
                                                            <td style="width: 20%; font-size: 9pt;"></td>
                                                            <td style="width: 30%; font-size: 9pt; text-align: right; padding-top: 3px; border-top: 1px solid #000000;"><hr style="color: #000000; margin-top: 0px;"><b>{{ number_format(-(abs($incomeData->sum('amount')) - $expensesData->sum('amount')), 2) }}</b></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <br>
                                              </div>
                                              <div class="col-12">
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
      <script>
          // Initialize datetimepicker
          $(document).ready(function() {
              $('.datetimepicker').datetimepicker({
                  format: 'YYYY-MM-DD',
                  ignoreReadonly: true
              });
          });

          // Download as PDF
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('download_button').addEventListener('click', function() {
                    const invoice = document.getElementById('invoice');
                    const options = {
                        margin: 0.5,
                        filename: 'Trading_Account.pdf',
                        image: { type: 'jpeg', quality: 1 },
                        html2canvas: { scale: 2 },
                        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                    };

                    html2pdf().set(options).from(invoice).save();
                });
            });
      </script>
      </div>
@endsection