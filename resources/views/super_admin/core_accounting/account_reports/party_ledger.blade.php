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
                    <form action="{{ route('partyLedgerView') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="name">Name:</label>
                                    <select class="form-select" id="name1" name="name1">
                                        @foreach($parties as $party)
                                            <option value="{{ $party->name }}">{{ $party->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="startDate">Start Date:</label>
                                    <input type="date" class="form-control" id="startDate" name="startDate">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="endDate">End Date:</label>
                                    <input type="date" class="form-control" id="endDate" name="endDate">
                                </div>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary" style="margin-top: 23px;">Search</button>
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
                        <th style="text-align: center; width: 12%;">Date</th>
                        <th style="text-align: center; width: 10%;">Voucher No</th>
                        <th style="text-align: center; width: 21%;">Description</th>
                        <th style="text-align: center; width: 27%;">Head Name</th>
                        <th style="text-align: center; width: 10%;">DR (TK.)</th>
                        <th style="text-align: center; width: 10%;">CR (TK.)</th>
                        <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>&nbsp;2023-07-01</td>
                        <td></td>
                        <td>Openning Balance</td>
                        <td></td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                      </tr>
                      @foreach ($ledgerData as $ledger)
                        @if (count($ledger->dr_amount) > 0 || count($ledger->cr_amount) > 0)
                            @foreach ($ledger->dr_amount as $drItem)
                            <tr>
                                <td>&nbsp;{{ $ledger->voucher_date }}</td>
                                <td>{{ $ledger->voucher_no }}</td>
                                <td>{{ $ledger->description }}</td>
                                <td>{{ $drItem->name }}</td>
                                <td>{{ $drItem->amount }}</td>
                                <td>0</td>
                                <td>
                                    @php
                                    $total = $total + $drItem->amount;
                                    $totalDr = $totalDr + $drItem->amount;
                                    @endphp
                                    &nbsp;{{ $total }}
                                </td>
                            </tr>
                            @endforeach
                            @foreach ($ledger->cr_amount as $crItem)
                            <tr>
                                <td>&nbsp;{{ $ledger->voucher_date }}</td>
                                <td>{{ $ledger->voucher_no }}</td>
                                <td>{{ $ledger->description }}</td>
                                <td>{{ $crItem->name }}</td>
                                <td>
                                    0
                                </td>
                                <td>
                                    {{ $crItem->amount }}
                                </td>
                                <td>
                                    @php
                                        $total = $total - $crItem->amount;
                                        $totalCr = $totalCr + $crItem->amount;
                                    @endphp
                                    &nbsp;{{ $total }}
                                </td>
                            </tr>
                            @endforeach
                        @endif
                      @endforeach
                      <tr>
                        <td>2023-07-31</td>
                        <td></td>
                        <td>Closing Balance</td>
                        <td></td>
                        <td>0</td>
                        <td>0</td>
                        <td>{{ $total }}</td>
                      </tr>
                      <tr style="border: 1px solid #ffffff;">
                        <th></th>
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