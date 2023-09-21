@extends('layout.app')

@section('content')
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
                    <div class="col-4">
                        <div class="form-group">
                            <label for="account_name">Select Account Name:</label>
                            <select class="form-control" name="account_name" id="account_name">
                                <option value="">Select Account</option>
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
                    </div>
                    <div class="col-2" style="margin-top: 23px;">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
            <hr style="margin-top: 10px;">

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
          
          @include('layout.footer')
        </div>
      </div>
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