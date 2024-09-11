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
                <option value="Bills Receivables Of Water">Bills Receivables Of Water</option>
                <option value="Bills Receivables Of T-head Jetty">Bills Receivables Of T-head Jetty</option>
                <option value="Bills Receivables Of Water T-head Jetty">Bills Receivables Of Water T-head Jetty</option>
                <option value="Bills Receivables Of Marine Workshop">Bills Receivables Of Marine Workshop</option>
                <option value="Bills Receivables Of Electric">Bills Receivables Of Electric</option>
                <option value="Other Bills Receivables">Other Bills Receivables</option>
            </select>
            
          <div id="all">
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
                            $totalAmount = 0;
                          ?>
                          @foreach ($ledgerData as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $totalAmount += $ledger["amount"];
                            ?>
                          @endforeach
                          <tr>
                            <td>&nbsp;&nbsp;<strong>Total</strong></td>
                            <td><center>{{ $totalAmount }}</center></td>
                          </tr>
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
              <button id="download-Rent-and-Lease" onclick="pdf_Rent_and_Lease_download()" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div style="width: 100%; margin-left: auto; margin-right: auto;">
                <div id="invoice_Rent_and_Lease" style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
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
                            $totalAmount_Rent_and_Lease = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Rent_and_Lease as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $totalAmount_Rent_and_Lease += $ledger["amount"];
                            ?>
                          @endforeach
                          <tr>
                            <td>&nbsp;&nbsp;<strong>Total</strong></td>
                            <td><center>{{ $totalAmount_Rent_and_Lease }}</center></td>
                          </tr>
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
              <button id="download-Processing" onclick="pdf_Processing_download()" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div style="width: 100%; margin-left: auto; margin-right: auto;">
                <div id="invoice_Processing" style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
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
                            $totalAmount_Processing = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Processing as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $totalAmount_Processing += $ledger["amount"];
                            ?>
                          @endforeach
                          <tr>
                            <td>&nbsp;&nbsp;<strong>Total</strong></td>
                            <td><center>{{ $totalAmount_Processing }}</center></td>
                          </tr>
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
              <button id="download-Land-and-Lease" onclick="pdf_Land_and_Lease_download()" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div style="width: 100%; margin-left: auto; margin-right: auto;">
                <div id="invoice_Land_and_Lease" style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
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
                            $totalAmount_Land_and_Lease = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Land_and_Lease as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $totalAmount_Land_and_Lease += $ledger["amount"];
                            ?>
                          @endforeach
                          <tr>
                            <td>&nbsp;&nbsp;<strong>Total</strong></td>
                            <td><center>{{ $totalAmount_Land_and_Lease }}</center></td>
                          </tr>
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
              <button id="download-Multichannel" onclick="pdf_Multichannel_download()" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div style="width: 100%; margin-left: auto; margin-right: auto;">
                <div id="invoice_Multichannel" style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
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
                            $totalAmount_Multichannel = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Multichannel as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $totalAmount_Multichannel += $ledger["amount"];
                            ?>
                          @endforeach
                          <tr>
                            <td>&nbsp;&nbsp;<strong>Total</strong></td>
                            <td><center>{{ $totalAmount_Multichannel }}</center></td>
                          </tr>
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
              <button id="download-Water-T-Head-Jetty" onclick="pdf_Water_T_head_Jetty_download()" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div style="width: 100%; margin-left: auto; margin-right: auto;">
                <div id="invoice_Water_T_Head_Jetty" style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
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
                            $totalAmount_Water_T_head_Jetty = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Water_T_head_Jetty as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $totalAmount_Water_T_head_Jetty += $ledger["amount"];
                            ?>
                          @endforeach
                          <tr>
                            <td>&nbsp;&nbsp;<strong>Total</strong></td>
                            <td><center>{{ $totalAmount_Water_T_head_Jetty }}</center></td>
                          </tr>
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
          <div id="water" style="display: none;">
            <div style="float:right; margin-right:20%; padding-bottom: 20px;">
              <button id="download-Water" onclick="pdf_Water_download()" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div style="width: 100%; margin-left: auto; margin-right: auto;">
                <div id="invoice_Water" style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
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
                            $totalAmount_Water = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Water as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $totalAmount_Water += $ledger["amount"];
                            ?>
                          @endforeach
                          <tr>
                            <td>&nbsp;&nbsp;<strong>Total</strong></td>
                            <td><center>{{ $totalAmount_Water }}</center></td>
                          </tr>
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
              <button id="download-T-head-Jetty" onclick="pdf_T_head_Jetty_download()" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div style="width: 100%; margin-left: auto; margin-right: auto;">
                <div id="invoice_T_head_Jetty" style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
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
                            $totalAmount_T_head_Jetty = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_T_head_Jetty as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $totalAmount_T_head_Jetty += $ledger["amount"];
                            ?>
                          @endforeach
                          <tr>
                            <td>&nbsp;&nbsp;<strong>Total</strong></td>
                            <td><center>{{ $totalAmount_T_head_Jetty }}</center></td>
                          </tr>
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
              <button id="download-Marine-Workshop" onclick="pdf_Marine_Workshop_download()" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div style="width: 100%; margin-left: auto; margin-right: auto;">
                <div id="invoice_Marine_Workshop" style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
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
                            $totalAmount_Marine_Workshop = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Marine_Workshop as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $totalAmount_Marine_Workshop += $ledger["amount"];
                            ?>
                          @endforeach
                          <tr>
                            <td>&nbsp;&nbsp;<strong>Total</strong></td>
                            <td><center>{{ $totalAmount_Marine_Workshop }}</center></td>
                          </tr>
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
              <button id="download-Electric" onclick="pdf_Electric_download()" style="float:right;" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
            </div>
            <br> <br>
            <div style="border: 2px solid #000000; background-color:#ffffff; width: 70%; margin-left: auto; margin-right: auto; color: #000000;">
              <div style="width: 100%; margin-left: auto; margin-right: auto;">
                <div id="invoice_Electric" style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
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
                            $totalAmount_Electric = 0;
                          ?>
                          @foreach ($bills_Receivables_Of_Electric as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
                              <td><center>{{ $ledger["amount"] }}</center></td>
                            </tr>
                            <?php
                              $totalAmount_Electric += $ledger["amount"];
                            ?>
                          @endforeach
                          <tr>
                            <td>&nbsp;&nbsp;<strong>Total</strong></td>
                            <td><center>{{ $totalAmount_Electric }}</center></td>
                          </tr>
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
                          @foreach ($other_Bills_Receivables as $ledger)
                            <tr>
                              <td>&nbsp;&nbsp;{{ $ledger["name"] }}</td>
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

  <!-- Invoice PDF -->
  <script>
    const calculatePDF = function(pdf_document) {
      const html_code = `
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
        <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
        <div style="width: 100%; margin-left: auto; margin-right: auto;"><div id="invoice" style="width: 98%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">${pdf_document.innerHTML}</div></div>
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

  <!-- Rent_and_Lease PDF -->
  <script>
    const calculatePDF_Rent_and_Lease = function(pdf_document) {
      const html_code = `
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
        <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
        <div style="width: 100%; margin-left: auto; margin-right: auto;"><div id="invoice_Rent_and_Lease" style="width: 98%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">${pdf_document.innerHTML}</div></div>
      `;
      const new_window = window.open('', '', 'width=600', 'height=800', 'top=0');
      new_window.document.write(html_code);

      setTimeout(() => {
        new_window.print();
        new_window.close();
      }, 200);
    }
    function pdf_Rent_and_Lease_download() {
      const pdf_document = document.querySelector("#invoice_Rent_and_Lease");
      calculatePDF_Rent_and_Lease(pdf_document);
    };
  </script>

  <!-- Processing PDF -->
  <script>
    const calculatePDF_Processing = function(pdf_document) {
      const html_code = `
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
        <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
        <div style="width: 100%; margin-left: auto; margin-right: auto;"><div id="invoice_Processing" style="width: 98%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">${pdf_document.innerHTML}</div></div>
      `;
      const new_window = window.open('', '', 'width=600', 'height=800', 'top=0');
      new_window.document.write(html_code);

      setTimeout(() => {
        new_window.print();
        new_window.close();
      }, 200);
    }
    function pdf_Processing_download() {
      const pdf_document = document.querySelector("#invoice_Processing");
      calculatePDF_Processing(pdf_document);
    };
  </script>

 <!-- Land_and_Lease PDF -->
  <script>
    const calculatePDF_Land_and_Lease = function(pdf_document) {
      const html_code = `
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
        <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
        <div style="width: 100%; margin-left: auto; margin-right: auto;"><div id="invoice_Land_and_Lease" style="width: 98%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">${pdf_document.innerHTML}</div></div>
      `;
      const new_window = window.open('', '', 'width=600', 'height=800', 'top=0');
      new_window.document.write(html_code);

      setTimeout(() => {
        new_window.print();
        new_window.close();
      }, 200);
    }
    function pdf_Land_and_Lease_download() {
      const pdf_document = document.querySelector("#invoice_Land_and_Lease");
      calculatePDF_Land_and_Lease(pdf_document);
    };
  </script>

 <!-- Multichannel PDF -->
  <script>
    const calculatePDF_Multichannel = function(pdf_document) {
      const html_code = `
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
        <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
        <div style="width: 100%; margin-left: auto; margin-right: auto;"><div id="invoice_Multichannel" style="width: 98%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">${pdf_document.innerHTML}</div></div>
      `;
      const new_window = window.open('', '', 'width=600', 'height=800', 'top=0');
      new_window.document.write(html_code);

      setTimeout(() => {
        new_window.print();
        new_window.close();
      }, 200);
    }
    function pdf_Multichannel_download() {
      const pdf_document = document.querySelector("#invoice_Multichannel");
      calculatePDF_Multichannel(pdf_document);
    };
  </script>

 <!-- Water_T_Head_Jetty PDF -->
  <script>
    const calculatePDF_Water_T_Head_Jetty = function(pdf_document) {
      const html_code = `
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
        <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
        <div style="width: 100%; margin-left: auto; margin-right: auto;"><div id="invoice_Water_T_Head_Jetty" style="width: 98%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">${pdf_document.innerHTML}</div></div>
      `;
      const new_window = window.open('', '', 'width=600', 'height=800', 'top=0');
      new_window.document.write(html_code);

      setTimeout(() => {
        new_window.print();
        new_window.close();
      }, 200);
    }
    function pdf_Water_T_head_Jetty_download() {
      const pdf_document = document.querySelector("#invoice_Water_T_Head_Jetty");
      calculatePDF_Water_T_Head_Jetty(pdf_document);
    };
  </script>

 <!-- Water PDF -->
  <script>
    const calculatePDF_Water = function(pdf_document) {
      const html_code = `
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
        <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
        <div style="width: 100%; margin-left: auto; margin-right: auto;"><div id="invoice_Water" style="width: 98%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">${pdf_document.innerHTML}</div></div>
      `;
      const new_window = window.open('', '', 'width=600', 'height=800', 'top=0');
      new_window.document.write(html_code);

      setTimeout(() => {
        new_window.print();
        new_window.close();
      }, 200);
    }
    function pdf_Water_download() {
      const pdf_document = document.querySelector("#invoice_Water");
      calculatePDF_Water(pdf_document);
    };
  </script>

 <!-- T_head_Jetty PDF -->
  <script>
    const calculatePDF_T_head_Jetty = function(pdf_document) {
      const html_code = `
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
        <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
        <div style="width: 100%; margin-left: auto; margin-right: auto;"><div id="invoice_T_head_Jetty" style="width: 98%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">${pdf_document.innerHTML}</div></div>
      `;
      const new_window = window.open('', '', 'width=600', 'height=800', 'top=0');
      new_window.document.write(html_code);

      setTimeout(() => {
        new_window.print();
        new_window.close();
      }, 200);
    }
    function pdf_T_head_Jetty_download() {
      const pdf_document = document.querySelector("#invoice_T_head_Jetty");
      calculatePDF_T_head_Jetty(pdf_document);
    };
  </script>

  <!-- Marine_Workshop PDF -->
  <script>
    const calculatePDF_Marine_Workshop = function(pdf_document) {
      const html_code = `
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
        <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
        <div style="width: 100%; margin-left: auto; margin-right: auto;"><div id="invoice_Marine_Workshop" style="width: 98%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">${pdf_document.innerHTML}</div></div>
      `;
      const new_window = window.open('', '', 'width=600', 'height=800', 'top=0');
      new_window.document.write(html_code);

      setTimeout(() => {
        new_window.print();
        new_window.close();
      }, 200);
    }
    function pdf_Marine_Workshop_download() {
      const pdf_document = document.querySelector("#invoice_Marine_Workshop");
      calculatePDF_Marine_Workshop(pdf_document);
    };
  </script>
  
  <!-- Electric PDF -->
  <script>
    const calculatePDF_Electric = function(pdf_document) {
      const html_code = `
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
        <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
        <div style="width: 100%; margin-left: auto; margin-right: auto;"><div id="invoice_Electric" style="width: 98%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">${pdf_document.innerHTML}</div></div>
      `;
      const new_window = window.open('', '', 'width=600', 'height=800', 'top=0');
      new_window.document.write(html_code);

      setTimeout(() => {
        new_window.print();
        new_window.close();
      }, 200);
    }
    function pdf_Electric_download() {
      const pdf_document = document.querySelector("#invoice_Electric");
      calculatePDF_Electric(pdf_document);
    };
  </script>

  <script>
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