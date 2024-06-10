@extends('layout.app')
  <!-- <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script> -->

@section('content')
    <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
            <h2 class="mb-4">All Party Ledger</h2>
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
            <label for="myDropdown">Choose a Bills Receivables:</label>
            <select id="myDropdown" onchange="hideDiv()">
                <option value="All Bills Receivables">All Bills Receivables</option>
                <option value="Bills Receivables Of Rent & Lease">Bills Receivables Of Rent & Lease</option>
                <option value="Bills Receivables Of Processing">Bills Receivables Of Processing</option>
                <option value="Bills Receivables Of Land and Lease">Bills Receivables Of Land and Lease</option>
                <option value="Bills Receivables Of Multichannel">Bills Receivables Of Multichannel</option>
                <option value="Bills Receivables Of Multichannel Slipway">Bills Receivables Of Multichannel Slipway</option>
                <option value="Bills Receivables Of Multichannel Slipway Dockyard">Bills Receivables Of Multichannel Slipway Dockyard</option>
                <option value="Bills Receivables Of Water">Bills Receivables Of Water</option>
                <option value="Bills Receivables Of T-head Jetty">Bills Receivables Of T-head Jetty</option>
                <option value="Bills Receivables Of Water T-head Jetty">Bills Receivables Of Water T-head Jetty</option>
                <option value="Bills Receivables Of Workshop">Bills Receivables Of Workshop</option>
                <option value="Bills Receivables Of Marine Workshop">Bills Receivables Of Marine Workshop</option>
                <option value="Bills Receivables Of Electric">Bills Receivables Of Electric</option>
                <option value="Other Bills Receivables">Other Bills Receivables</option>
            </select>
            
          <div id="all">
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
                        <h5>All Party Ledger</h5>
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
                          <?php
                            $count = 0;
                          ?>
                          @foreach ($ledgerData as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $count++;
                              if($count === 16 || $count === 34 || $count === 52 || $count === 70 || $count === 88 || $count === 106) {
                            ?>
                        </tbody>
                      </table>
                      <br><br><br><br><br><br>
                      <table class="table table-bordered" style="width: 100%; font-size: 12px; border: 1px solid;">
                        <thead>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                              }
                            ?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @else
            <p>No data available.</p>
          @endif
        
          @if ($bills_Receivables_Of_Rent_and_Lease)
          <div id="rent" style="display: none;">
            <div style="float:right; margin-right:20%; padding-bottom: 20px;">
              <button id="download-Rent-and-Lease" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div id="invoice_Rent_and_Lease" style="width: 100%; margin-left: auto; margin-right: auto;">
                <div style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                  <br><br>
                  <div class="row">
                    <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="60" height="48" /></div>
                    <div class="col-8">
                      <center>
                        <h4>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h5>
                        <h5>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</h5> <br><br>
                        <h5>All Party Ledger</h5>
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
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Rent and Lease </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $count = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Rent_and_Lease as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $count++;
                              if($count === 15 || $count === 32 || $count === 49 || $count === 66 || $count === 83 || $count === 100) {
                            ?>
                        </tbody>
                      </table>
                      <br><br><br><br><br><br>
                      <table class="table table-bordered" style="width: 100%; font-size: 12px; border: 1px solid;">
                        <thead>
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Rent and Lease </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                              }
                            ?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif


        @if ($bills_Receivables_Of_Processing)
          <div id="processing" style="display: none;">
            <div style="float:right; margin-right:20%; padding-bottom: 20px;">
              <button id="download-Processing" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div id="invoice_Processing" style="width: 100%; margin-left: auto; margin-right: auto;">
                <div style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                  <br><br>
                  <div class="row">
                    <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="60" height="48" /></div>
                    <div class="col-8">
                      <center>
                        <h4>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h5>
                        <h5>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</h5> <br><br>
                        <h5>All Party Ledger</h5>
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
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Processing </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $count = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Processing as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $count++;
                              if($count === 15 || $count === 32 || $count === 49 || $count === 66 || $count === 83 || $count === 100) {
                            ?>
                        </tbody>
                      </table>
                      <br><br><br><br><br><br>
                      <table class="table table-bordered" style="width: 100%; font-size: 12px; border: 1px solid;">
                        <thead>
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Processing </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                              }
                            ?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif


        @if ($bills_Receivables_Of_Land_and_Lease)
          <div id="land" style="display: none;">
            <div style="float:right; margin-right:20%; padding-bottom: 20px;">
              <button id="download-Land-and-Lease" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div id="invoice_Land_and_Lease" style="width: 100%; margin-left: auto; margin-right: auto;">
                <div style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                  <br><br>
                  <div class="row">
                    <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="60" height="48" /></div>
                    <div class="col-8">
                      <center>
                        <h4>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h5>
                        <h5>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</h5> <br><br>
                        <h5>All Party Ledger</h5>
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
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Land and Lease </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $count = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Land_and_Lease as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $count++;
                              if($count === 15 || $count === 32 || $count === 49 || $count === 66 || $count === 83 || $count === 100) {
                            ?>
                        </tbody>
                      </table>
                      <br><br><br><br><br><br>
                      <table class="table table-bordered" style="width: 100%; font-size: 12px; border: 1px solid;">
                        <thead>
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Land and Lease </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                              }
                            ?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif


        @if ($bills_Receivables_Of_Multichannel)
          <div id="multichannel" style="display: none;">
            <div style="float:right; margin-right:20%; padding-bottom: 20px;">
              <button id="download-Multichannel" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div id="invoice_Multichannel" style="width: 100%; margin-left: auto; margin-right: auto;">
                <div style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                  <br><br>
                  <div class="row">
                    <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="60" height="48" /></div>
                    <div class="col-8">
                      <center>
                        <h4>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h5>
                        <h5>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</h5> <br><br>
                        <h5>All Party Ledger</h5>
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
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Multichannel </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $count = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Multichannel as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $count++;
                              if($count === 15 || $count === 32 || $count === 49 || $count === 66 || $count === 83 || $count === 100) {
                            ?>
                        </tbody>
                      </table>
                      <br><br><br><br><br><br>
                      <table class="table table-bordered" style="width: 100%; font-size: 12px; border: 1px solid;">
                        <thead>
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Multichannel </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                              }
                            ?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif


        @if ($bills_Receivables_Of_Multichannel_Slipway_Dockyard)
          <div id="multichannel_Slipway_Dockyard" style="display: none;">
            <div style="float:right; margin-right:20%; padding-bottom: 20px;">
              <button id="download-Multichannel-Slipway-Dockyard" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div id="invoice_Multichannel_Slipway_Dockyard" style="width: 100%; margin-left: auto; margin-right: auto;">
                <div style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                  <br><br>
                  <div class="row">
                    <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="60" height="48" /></div>
                    <div class="col-8">
                      <center>
                        <h4>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h5>
                        <h5>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</h5> <br><br>
                        <h5>All Party Ledger</h5>
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
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Multichannel Slipway Dockyard </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $count = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Multichannel_Slipway_Dockyard as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $count++;
                              if($count === 15 || $count === 32 || $count === 49 || $count === 66 || $count === 83 || $count === 100) {
                            ?>
                        </tbody>
                      </table>
                      <br><br><br><br><br><br>
                      <table class="table table-bordered" style="width: 100%; font-size: 12px; border: 1px solid;">
                        <thead>
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Multichannel Slipway Dockyard </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                              }
                            ?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif


        @if ($bills_Receivables_Of_Multichannel_Slipway)
          <div id="multichannel_Slipway" style="display: none;">
            <div style="float:right; margin-right:20%; padding-bottom: 20px;">
              <button id="download-Multichannel-Slipway" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div id="invoice_Multichannel_Slipway" style="width: 100%; margin-left: auto; margin-right: auto;">
                <div style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                  <br><br>
                  <div class="row">
                    <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="60" height="48" /></div>
                    <div class="col-8">
                      <center>
                        <h4>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h5>
                        <h5>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</h5> <br><br>
                        <h5>All Party Ledger</h5>
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
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Multichannel Slipway </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $count = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Multichannel_Slipway as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $count++;
                              if($count === 15 || $count === 32 || $count === 49 || $count === 66 || $count === 83 || $count === 100) {
                            ?>
                        </tbody>
                      </table>
                      <br><br><br><br><br><br>
                      <table class="table table-bordered" style="width: 100%; font-size: 12px; border: 1px solid;">
                        <thead>
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Multichannel Slipway </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                              }
                            ?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif


        @if ($bills_Receivables_Of_Water_T_head_Jetty)
          <div id="water_T_head_Jetty" style="display: none;">
            <div style="float:right; margin-right:20%; padding-bottom: 20px;">
              <button id="download-Water-T-Head-Jetty" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div id="invoice_Water_T_head_Jetty" style="width: 100%; margin-left: auto; margin-right: auto;">
                <div style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                  <br><br>
                  <div class="row">
                    <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="60" height="48" /></div>
                    <div class="col-8">
                      <center>
                        <h4>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h5>
                        <h5>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</h5> <br><br>
                        <h5>All Party Ledger</h5>
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
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Water T-head Jetty </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $count = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Water_T_head_Jetty as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $count++;
                              if($count === 15 || $count === 32 || $count === 49 || $count === 66 || $count === 83 || $count === 100) {
                            ?>
                        </tbody>
                      </table>
                      <br><br><br><br><br><br>
                      <table class="table table-bordered" style="width: 100%; font-size: 12px; border: 1px solid;">
                        <thead>
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Water T-head Jetty </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                              }
                            ?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif


        @if ($bills_Receivables_Of_Water)
          <div id="Water" style="display: none;">
            <div style="float:right; margin-right:20%; padding-bottom: 20px;">
              <button id="download-Water" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div id="invoice_Water" style="width: 100%; margin-left: auto; margin-right: auto;">
                <div style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                  <br><br>
                  <div class="row">
                    <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="60" height="48" /></div>
                    <div class="col-8">
                      <center>
                        <h4>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h5>
                        <h5>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</h5> <br><br>
                        <h5>All Party Ledger</h5>
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
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Water </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $count = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Water as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $count++;
                              if($count === 15 || $count === 32 || $count === 49 || $count === 66 || $count === 83 || $count === 100) {
                            ?>
                        </tbody>
                      </table>
                      <br><br><br><br><br><br>
                      <table class="table table-bordered" style="width: 100%; font-size: 12px; border: 1px solid;">
                        <thead>
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Water </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                              }
                            ?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif


        @if ($bills_Receivables_Of_T_head_Jetty)
          <div id="t_head_Jetty" style="display: none;">
            <div style="float:right; margin-right:20%; padding-bottom: 20px;">
              <button id="download-T-head-Jetty" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div id="invoice_T_head_Jetty" style="width: 100%; margin-left: auto; margin-right: auto;">
                <div style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                  <br><br>
                  <div class="row">
                    <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="60" height="48" /></div>
                    <div class="col-8">
                      <center>
                        <h4>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h5>
                        <h5>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</h5> <br><br>
                        <h5>All Party Ledger</h5>
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
                          <tr><td colspan="2"><center><strong> Bills Receivables Of T-head Jetty </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $count = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_T_head_Jetty as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $count++;
                              if($count === 15 || $count === 32 || $count === 49 || $count === 66 || $count === 83 || $count === 100) {
                            ?>
                        </tbody>
                      </table>
                      <br><br><br><br><br><br>
                      <table class="table table-bordered" style="width: 100%; font-size: 12px; border: 1px solid;">
                        <thead>
                          <tr><td colspan="2"><center><strong> Bills Receivables Of T-head Jetty </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                              }
                            ?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif


        @if ($bills_Receivables_Of_Marine_Workshop)
          <div id="marine_Workshop" style="display: none;">
            <div style="float:right; margin-right:20%; padding-bottom: 20px;">
              <button id="download-Marine-Workshop" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div id="invoice_Marine_Workshop" style="width: 100%; margin-left: auto; margin-right: auto;">
                <div style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                  <br><br>
                  <div class="row">
                    <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="60" height="48" /></div>
                    <div class="col-8">
                      <center>
                        <h4>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h5>
                        <h5>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</h5> <br><br>
                        <h5>All Party Ledger</h5>
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
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Marine Workshop </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $count = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Marine_Workshop as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $count++;
                              if($count === 15 || $count === 32 || $count === 49 || $count === 66 || $count === 83 || $count === 100) {
                            ?>
                        </tbody>
                      </table>
                      <br><br><br><br><br><br>
                      <table class="table table-bordered" style="width: 100%; font-size: 12px; border: 1px solid;">
                        <thead>
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Marine Workshop </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                              }
                            ?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif


        @if ($bills_Receivables_Of_Workshop)
          <div id="workshop" style="display: none;">
            <div style="float:right; margin-right:20%; padding-bottom: 20px;">
              <button id="download-Workshop" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div id="invoice_Workshop" style="width: 100%; margin-left: auto; margin-right: auto;">
                <div style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                  <br><br>
                  <div class="row">
                    <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="60" height="48" /></div>
                    <div class="col-8">
                      <center>
                        <h4>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h5>
                        <h5>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</h5> <br><br>
                        <h5>All Party Ledger</h5>
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
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Workshop </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $count = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Workshop as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $count++;
                              if($count === 15 || $count === 32 || $count === 49 || $count === 66 || $count === 83 || $count === 100) {
                            ?>
                        </tbody>
                      </table>
                      <br><br><br><br><br><br>
                      <table class="table table-bordered" style="width: 100%; font-size: 12px; border: 1px solid;">
                        <thead>
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Workshop </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                              }
                            ?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif


        @if ($bills_Receivables_Of_Electric)
          <div id="electric" style="display: none;">
            <div style="float:right; margin-right:20%; padding-bottom: 20px;">
              <button id="download-Electric" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div id="invoice_Electric" style="width: 100%; margin-left: auto; margin-right: auto;">
                <div style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                  <br><br>
                  <div class="row">
                    <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="60" height="48" /></div>
                    <div class="col-8">
                      <center>
                        <h4>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h5>
                        <h5>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</h5> <br><br>
                        <h5>All Party Ledger</h5>
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
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Electric </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $count = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Electric as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $count++;
                              if($count === 15 || $count === 32 || $count === 49 || $count === 66 || $count === 83 || $count === 100) {
                            ?>
                        </tbody>
                      </table>
                      <br><br><br><br><br><br>
                      <table class="table table-bordered" style="width: 100%; font-size: 12px; border: 1px solid;">
                        <thead>
                          <tr><td colspan="2"><center><strong> Bills Receivables Of Electric </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                              }
                            ?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif

        
        @if ($other_Bills_Receivables)
          <div id="other" style="display: none;">
            <div style="float:right; margin-right:20%; padding-bottom: 20px;">
              <button id="download-Other" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div id="invoice_Other" style="width: 100%; margin-left: auto; margin-right: auto;">
                <div style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                  <br><br>
                  <div class="row">
                    <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="60" height="48" /></div>
                    <div class="col-8">
                      <center>
                        <h4>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h5>
                        <h5>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</h5> <br><br>
                        <h5>All Party Ledger</h5>
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
                          <tr><td colspan="2"><center><strong> Other Bills Receivables </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $count = 0;
                          ?>
                          @foreach ($other_Bills_Receivables as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $count++;
                              if($count === 15 || $count === 32 || $count === 49 || $count === 66 || $count === 83 || $count === 100) {
                            ?>
                        </tbody>
                      </table>
                      <br><br><br><br><br><br>
                      <table class="table table-bordered" style="width: 100%; font-size: 12px; border: 1px solid;">
                        <thead>
                          <tr><td colspan="2"><center><strong> Other Bills Receivables </strong></center></td></tr>
                          <tr style="width: 100%;">
                            <th style="text-align: center; width: 27%;">Party Name</th>
                            <th style="text-align: center; width: 10%;">Balance (TK.)</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                              }
                            ?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
    // function htmlToPDF() {
    //   window.jsPDF = window.jspdf.jsPDF;
      // const doc = new jsPDF();
    //   pdf.html(document.getElementById('invoice'), {
    //     html2canvas: {
    //         scale: 600 / srcwidth
    //         //600 is the width of a4 page. 'a4': [595.28, 841.89]
    //     },
    //     callback: function () {
    //         window.open(pdf.output('All_Party_Ledger'));
    //     }
    // });
    // alert("pdf done");
      // var htmlElement = $('#invoice').html();
      // doc.fromHTML(htmlElement);
      // doc.save('All Party Ledger.pdf');
      // var specialElementHandlers = {
      //   '#editor': function (element, renderer) {
      //     return true;
      //   }
      // };

      // $('#download-button').click(function () {   
      //   doc.fromHTML($('#invoice').html(), 15, 15, {
      //     'width': 170,
      //     'elementHandlers': specialElementHandlers
      //   });
      //   doc.save('All-Party-Ledger.pdfpdf');
      // });
    // }

    // var ledgerData = JSON.parse("{{ json_encode($ledgerData) }}");
    //   console.log(ledgerData);

    document.addEventListener("DOMContentLoaded", function() {
      const button = document.getElementById('download-button');
      function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('invoice');
        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save();
      }
      button.addEventListener('click', generatePDF);

      const button_Rent_and_Lease = document.getElementById('download-Rent-and-Lease');
      function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('invoice_Rent_and_Lease');
        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save();
      }
      button_Rent_and_Lease.addEventListener('click', generatePDF);

      const button_Processing = document.getElementById('download-Processing');
      function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('invoice_Processing');
        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save();
      }
      button_Processing.addEventListener('click', generatePDF);

      const button_Land_and_Lease = document.getElementById('download-Land-and-Lease');
      function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('invoice_Land_and_Lease');
        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save();
      }
      button_Land_and_Lease.addEventListener('click', generatePDF);

      const button_Multichannel = document.getElementById('download-Multichannel');
      function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('invoice_Multichannel');
        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save();
      }
      button_Multichannel.addEventListener('click', generatePDF);

      const button_Multichannel_Slipway_Dockyard = document.getElementById('download-Multichannel-Slipway-Dockyard');
      function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('invoice_Multichannel_Slipway_Dockyard');
        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save();
      }
      button_Multichannel_Slipway_Dockyard.addEventListener('click', generatePDF);

      const button_Multichannel_Slipway = document.getElementById('download-Multichannel-Slipway');
      function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('invoice_Multichannel_Slipway');
        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save();
      }
      button_Multichannel_Slipway.addEventListener('click', generatePDF);_Slipway_Dockyard

      const button_Water_T_Head_Jetty = document.getElementById('download-Water-T-Head-Jetty');
      function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('invoice_Water_T_Head_Jetty');
        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save();
      }
      button_Water_T_Head_Jetty.addEventListener('click', generatePDF);

      const button_Water = document.getElementById('download-Water');
      function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('invoice_Water');
        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save();
      }
      button_Water.addEventListener('click', generatePDF);

      const button_T_head_Jetty = document.getElementById('download-T-head-Jetty');
      function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('invoice_T_head_Jetty');
        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save();
      }
      button_T_head_Jetty.addEventListener('click', generatePDF);

      const button_Workshop = document.getElementById('download-Workshop');
      function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('invoice_Workshop');
        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save();
      }
      button_Workshop.addEventListener('click', generatePDF);

      const button_Marine_Workshop = document.getElementById('download-Marine-Workshop');
      function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('invoice_Marine_Workshop');
        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save();
      }
      button_Marine_Workshop.addEventListener('click', generatePDF);

      const button_Electric = document.getElementById('download-Electric');
      function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('invoice_Electric');
        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save();
      }
      button_Electric.addEventListener('click', generatePDF);

      const button_Other = document.getElementById('download-Other');
      function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('invoice_Other');
        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save();
      }
      button_Other.addEventListener('click', generatePDF);  
    });

    function hideDiv() {
      var dropdown = document.getElementById('myDropdown');
      const allDiv = document.getElementById('all');
      if (allDiv) {
        allDiv.style.display = "none";
      }
      const landDiv = document.getElementById('land');
      if (landDiv) {
        landDiv.style.display = "none";
      }
      const processingDiv = document.getElementById('processing');
      if (processingDiv) {
        processingDiv.style.display = "none";
      }
      const multichannelDiv = document.getElementById('multichannel');
      if (multichannelDiv) {
        multichannelDiv.style.display = "none";
      }
      const multichannel_SlipwayDiv = document.getElementById('multichannel_Slipway');
      if (multichannel_SlipwayDiv) {
        multichannel_SlipwayDiv.style.display = "none";
      }
      const multichannel_Slipway_DockyardDiv = document.getElementById('multichannel_Slipway_Dockyard');
      if (multichannel_Slipway_DockyardDiv) {
        multichannel_Slipway_DockyardDiv.style.display = "none";
      }
      const electricDiv = document.getElementById('electric');
      if (electricDiv) {
        electricDiv.style.display = "none";
      }
      const waterDiv = document.getElementById('water');
      if (waterDiv) {
        waterDiv.style.display = "none";
      }
      const t_head_JettyDiv = document.getElementById('t_head_Jetty');
      if (t_head_JettyDiv) {
        t_head_JettyDiv.style.display = "none";
      }
      const water_T_head_JettyDiv = document.getElementById('water_T_head_Jetty');
      if (water_T_head_JettyDiv) {
        water_T_head_JettyDiv.style.display = "none";
      }
      const marine_WorkshopDiv = document.getElementById('marine_Workshop');
      if (marine_WorkshopDiv) {
        marine_WorkshopDiv.style.display = "none";
      }
      const workshopDiv = document.getElementById('workshop');
      if (workshopDiv) {
        workshopDiv.style.display = "none";
      }
      const otherDiv = document.getElementById('other');
      if (otherDiv) {
        otherDiv.style.display = "none";
      }
      const rentDiv = document.getElementById('rent');
      if (rentDiv) {
        rentDiv.style.display = "none";
      }

      if (dropdown.value === 'Bills Receivables Of Rent & Lease') {
        if (rentDiv) {
          rentDiv.style.display = "block";
        }
      } else if (dropdown.value === 'Bills Receivables Of Processing'){
        if (processingDiv) {
          processingDiv.style.display = "block";
        }
      } else if (dropdown.value === 'Bills Receivables Of Land and Lease'){
        if (landDiv) {
          landDiv.style.display = "block";
        }
      } else if (dropdown.value === 'Bills Receivables Of Multichannel'){
        if (multichannelDiv) {
          multichannelDiv.style.display = "block";
        }
      } else if (dropdown.value === 'Bills Receivables Of Multichannel Slipway'){
        if (multichannel_SlipwayDiv) {
          multichannel_SlipwayDiv.style.display = "block";
        }
      } else if (dropdown.value === 'Bills Receivables Of Multichannel Slipway Dockyard'){
        if (multichannel_Slipway_DockyardDiv) {
          multichannel_Slipway_DockyardDiv.style.display = "block";
        }
      } else if (dropdown.value === 'Bills Receivables Of Water'){
        if (waterDiv) {
          waterDiv.style.display = "block";
        }
      } else if (dropdown.value === 'Bills Receivables Of T-head Jetty'){
        if (t_head_JettyDiv) {
          t_head_JettyDiv.style.display = "block";
        }
      } else if (dropdown.value === 'Bills Receivables Of Water T-head Jetty'){
        if (water_T_head_JettyDiv) {
          water_T_head_JettyDiv.style.display = "block";
        }
      } else if (dropdown.value === 'Bills Receivables Of Workshop'){
        if (workshopDiv) {
          workshopDiv.style.display = "block";
        }
      } else if (dropdown.value === 'Bills Receivables Of Marine Workshop'){
        if (marine_WorkshopDiv) {
          marine_WorkshopDiv.style.display = "block";
        }
      } else if (dropdown.value === 'Bills Receivables Of Electric'){
        if (electricDiv) {
          electricDiv.style.display = "block";
        }
      } else if (dropdown.value === 'Other Bills Receivables'){
        if (otherDiv) {
          otherDiv.style.display = "block";
        }
      } else {
        if (allDiv) {
          allDiv.style.display = "block";
        }
      }
    }
  </script>
@endsection