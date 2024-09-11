@extends('layout.app')

@section('content')
  <div class="container-fluid px-0" data-layout="container">
    @include('layout.navbar.navbar')
    <!-- 
      Content Starts Here
    -->
    <div class="content">
      <h2 class="mb-4">BalanceSheet</h2>
      <form method="post" action="{{ route('balanceSheetView') }}">
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
            <button id="submit_date" type="submit" class="btn btn-primary" style="width: 100%; height:100%;">Show BalanceSheet</button>
          </div>
        </div>
      </form>
      <br>

      <div class="row">
        @if($data)
        <div class="col-12">
            <div id="result-container">
                <div style="float:right; margin-right:20%;">
                    <button id="download-button" onclick="pdf_download()" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
                </div>
                <br><br>
                <div style="border: 2px solid #000000; background-color:#ffffff; width: 60%; margin-left: auto; margin-right: auto;">
                    <div style="width: 100%; margin-left: auto; margin-right: auto;">
                        <div id="invoice" style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
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
                                                <h6>Balance Sheet</h6>
                                                @if($startDate)
                                                <span style="font-size: 8pt; font-weight:500;">As on: {{ $startDate?? ''  }} to {{ $endtDate?? ''  }}</span>
                                                @endif
                                                <br><br>
                                            </center>
                                        </div>
                                        @php
                                          $grandTotaldr = 0;
                                          $grandTotalcr = 0;
                                          $grandtotal = 0;
                                        @endphp
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
                                                    <tr>
                                                        <td>Fixed Assets at Cost</td>
                                                        <td></td>
                                                        <td style="text-align: right;">{{ $fixed_assets_data['drAmount'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Less: Despreciation</td>
                                                        <td></td>
                                                        <td style="text-align: right;">{{ $fixed_assets_data['crAmount'] }}</td>
                                                    </tr>
                                                    @php
                                                        $grandtotal = $fixed_assets_data['drAmount'] - $fixed_assets_data['crAmount'];
                                                    @endphp
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td style="text-align: right;"><b>{{ $grandtotal }}</b></td>
                                                    </tr>

                                                  @php
                                                      $drTotal = $grandtotal;
                                                      $crTotal = 0;
                                                      $previousDrTotal = 0;
                                                      $previousCrTotal = 0;
                                                      $previous_accounts_group = "";
                                                      $previous_subsidiary_account_name = "";
                                                  @endphp
                                                  @foreach ($data as $item)
                                                      @php
                                                          $accounts_group_data = $item->accounts_group;
                                                          $subsidiary_account_name_data = $item->subsidiary_account_name;
                                                      @endphp
                                                      @if ($accounts_group_data != $previous_accounts_group)
                                                          @if($previous_accounts_group != "")
                                                              <tr>
                                                                  <td></td>
                                                                  <td></td>
                                                                  <td><hr></td>
                                                              </tr>
                                                              <tr style="border-bottom: 1px solid #000000;">
                                                                  <td><br><br></td>
                                                                  <td>Total &nbsp;&nbsp; {{ $previous_accounts_group }}<br><br></td>
                                                                  <td style="text-align: right;">{{ $previousDrTotal }}<br><br></td>
                                                              </tr>
                                                          @endif
                                                          @php
                                                              $drTotal = 0;
                                                              $crTotal = 0;
                                                          @endphp
                                                      @endif

                                                      @php
                                                          $previous_accounts_group = $item->accounts_group;
                                                      @endphp

                                                      @if ($subsidiary_account_name_data != $previous_subsidiary_account_name)
                                                          <tr>
                                                              <td><strong>{{ $item->subsidiary_account_name }}</strong></td>
                                                              <td></td>
                                                              <td></td>
                                                          </tr>
                                                      @endif

                                                      @php
                                                          $previous_subsidiary_account_name = $item->subsidiary_account_name;
                                                          $grandtotal
                                                      @endphp

                                                      <tr>
                                                          <td>{{ $item->account_name }}</td>
                                                          <td></td>
                                                          <td style="text-align: right;">{{ $item->totalAmount }}</td>
                                                      </tr>

                                                      @php
                                                          $drTotal += $item->totalAmount;
                                                          $previousDrTotal = $drTotal;
                                                          $grandTotaldr = $grandTotaldr + $item->totalAmount;
                                                      @endphp

                                                      @if ($loop->last)
                                                          <tr>
                                                              <td></td>
                                                              <td></td>
                                                              <td><hr></td>
                                                          </tr>
                                                          <tr>
                                                              <td><br><br></td>
                                                              <td>Total &nbsp;&nbsp; {{ $previous_accounts_group }}<br><br></td>
                                                              <td style="text-align: right;">{{ $previousDrTotal }}<br><br></td>
                                                          </tr>
                                                      @endif
                                                  @endforeach
                                                  @foreach($profit_loss_formattedData as $profit_loss_Data)
                                                    <tr>
                                                        <td><strong>Provision For Adiustiment</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Profit & Loss</td>
                                                        <td></td>
                                                        <td style="text-align: right;">{{ $profit_loss_Data['totalAmount'] }}<br><br></td>
                                                    </tr>
                                                    @php
                                                        $previousDrTotal = $previousDrTotal + $profit_loss_Data['totalAmount'];
                                                        $grandTotaldr = $grandTotaldr + $profit_loss_Data['totalAmount'];
                                                    @endphp
                                                  @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td><hr></td>
                                                    </tr>
                                                    <tr>
                                                        <td><br><br></td>
                                                        <td>Total<br><br></td>
                                                        <td style="text-align: right;">{{ $previousDrTotal }}<br><br></td>
                                                    </tr>
                                              </tbody>
                                          </table>
                                        </div>
                                        <div class="col-12">
                                          <table style="width: 100%;">
                                              <tbody>
                                                  <tr>
                                                      <td style="width: 40%;"></td>
                                                      <td style="width: 30%; font-size: 10pt;"><b>Grand Total</b></td>
                                                      <td style="width: 30%; font-size: 10pt; text-align: right;"><b>{{ $grandTotaldr }}</b></td>
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