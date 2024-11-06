<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Voucher Entry PDF</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- ===============================================-->
  <!--    Stylesheets-->
  <!-- ===============================================-->
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
  <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
  <script src="{{ asset('assets/js/jspdf.min.js') }}"></script>
  <script src="{{ asset('assets/js/jspdf.autotable.js') }}"></script>
</head>

<body>
  <br> <br>
  <div style="float:right; margin-right:20%;">
    <button id="download-button" onclick="pdf_download()" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
  </div>
  <br><br>
  <div style="border: 2px solid #000000; background-color:#ffffff; width: 60%; margin-left: auto; margin-right: auto; color: #000000;">
    <div style="width: 100%; margin-left: auto; margin-right: auto;">
      <div id="invoice" style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
        <br><br>
        <div class="row">
          <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="100" height="80" /></div>
          <div class="col-8">
            <center>
              <h3>বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</h2>
                <h4>চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​
              </h3>
            </center>
            <br><br>
          </div>
          <div class="col-2"></div>
        </div>
        <?php
        $dr_table_amount = json_decode($voucher_entry->dr_amount);
        ?>
        @php
        $crDrData = json_decode($voucher_entry->cr_dr, true);
        $groupedData = collect($crDrData)->groupBy('party_name');
        $totalDrAmount = 0;
        $totalCrAmount = 0;
        @endphp

        @if ($voucher_entry->voucher_type === 'Journal' || $voucher_entry->voucher_type === 'Payment')
        <div class="row">
          <div class="col-12">
            <div class="row">
              <div class="col-12" style="text-align: center;">
                <span style="font-size: 35px; border: 3px solid; padding: 7px; border-radius: 25px; color: #000000;">{{$voucher_entry->voucher_type}} Voucher</span>
                <br><br>
              </div>
              <div class="col-6">
                <b>ID No:</b> {{$voucher_entry->voucher_no}}
              </div>
              <div class="col-6" style="text-align: right;">
                <b>Voucher Date:</b> {{$voucher_entry->voucher_date}}
              </div>
              <div class="col-12">
                <table border="1" width="100%" id="table1">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th style="text-align: center; border: 1px solid;">Debit</th>
                      <th style="text-align: center; border: 1px solid;">Credit</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($groupedData as $partyName => $partyData)
                    @foreach($partyData as $entry)
                    <tr style="border: 1px solid;">
                      <td>{{ $entry['name'] }}</td>
                      <td style="text-align: center; border: 1px solid;">
                        @if ($entry['type'] === 'dr_amount')
                        {{ $entry['amount'] }}.00
                        @php
                        $totalDrAmount += (int)$entry['amount'];
                        @endphp
                        @else

                        @endif
                      </td>
                      <td style="text-align: center; border: 1px solid;">
                        @if ($entry['type'] === 'cr_amount')
                        {{ $entry['amount'] }}.00
                        @php
                        $totalCrAmount += (int)$entry['amount'];
                        @endphp
                        @else

                        @endif
                      </td>
                    </tr>
                    @endforeach
                    <tr style="border: 1px solid;">
                      <td style="text-align: center;">
                        <b>({{ $partyName }})</b>
                      </td>
                      <td style="text-align: center; border: 1px solid;"></td>
                      <td style="text-align: center; border: 1px solid;"></td>
                    </tr>
                    <tr style="border: 1px solid;">
                      <td><br></td>
                      <td style="text-align: center; border: 1px solid;"> </td>
                      <td style="text-align: center; border: 1px solid;"> </td>
                    </tr>
                    @endforeach
                    <tr style="border: 1px solid;">
                      <td><b>Total</b></td>
                      <td style="text-align: center; border: 1px solid;"><b>{{ $totalDrAmount }}.00</b></td>
                      <td style="text-align: center; border: 1px solid;"><b>{{ $totalCrAmount }}.00</b></td>
                    </tr>
                  </tbody>
                </table>
                @else
                <div class="row">
                  <div class="col-12">
                    <div class="row">
                      <div class="col-12" style="text-align: center;">
                        <span style="font-size: 35px; border: 3px solid; padding: 7px; border-radius: 25px; color: #000000;">{{$voucher_entry->voucher_type}}</span>
                        <br><br>
                      </div>
                      <div class="col-6">
                        <b>ID No:</b> {{$voucher_entry->voucher_no}}
                      </div>
                      <div class="col-6" style="text-align: right;">
                        <b>Voucher Date:</b> {{$voucher_entry->voucher_date}}
                      </div>
                      <div class="col-12">
                        <b>Payment Type:</b> {{$voucher_entry->type}}
                        <br>
                      </div>
                      <div class="col-12">
                        <b>Description:</b> {{$voucher_entry->description}}
                        <br><br>
                      </div>
                      <div class="col-12">
                        <table border="1" width="100%">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th style="text-align: center; border: 1px solid;">Debit</th>
                              <th style="text-align: center; border: 1px solid;">Credit</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($groupedData as $partyName => $partyData)
                            @foreach($partyData as $entry)
                            <tr style="border: 1px solid;">
                              <td>{{ $entry['name'] }}</td>
                              <td style="text-align: center; border: 1px solid;">
                                @if ($entry['type'] === 'dr_amount')
                                {{ $entry['amount'] }}.00
                                @php
                                $totalDrAmount += (int)$entry['amount'];
                                @endphp
                                @else
                                0.00
                                @endif
                              </td>
                              <td style="text-align: center; border: 1px solid;">
                                @if ($entry['type'] === 'cr_amount')
                                {{ $entry['amount'] }}.00
                                @php
                                $totalCrAmount += (int)$entry['amount'];
                                @endphp
                                @else
                                0.00
                                @endif
                              </td>
                            </tr>
                            @endforeach
                            @endforeach
                            <tr style="border: 1px solid;">
                              <td><b>Total</b></td>
                              <td style="text-align: center; border: 1px solid;"><b>{{ $totalDrAmount }}.00</b></td>
                              <td style="text-align: center; border: 1px solid;"><b>{{ $totalCrAmount }}.00</b></td>
                            </tr>
                          </tbody>
                        </table>
                        <br><br><br>
                        <span style="padding: 20px; border: 3px solid;"><b>Stamp</b></span><br>
                        @endif
                        <br><br>
                        Signeture
                        <br><br><br><br>
                      </div>
                      <div class="col-3" style="text-align: center;">
                        Asst Accountant
                        <br><br>
                      </div>
                      <div class="col-3" style="text-align: center;">
                        Accountant
                        <br><br>
                      </div>
                      <div class="col-3" style="text-align: center;">
                        Asst Chief Accountant
                        <br><br>
                      </div>
                      <div class="col-3" style="text-align: center;">
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
    </div>
  </div><br><br>

  <script>
    const calculatePDF = function(pdf_document) {
      const html_code = `
                <link rel="preconnect" href="https://fonts.googleapis.com/">
                <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
                <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
                <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
                <div style="width: 100%; margin-left: auto; margin-right: auto;">
                    <div id="invoice" style="width: 100%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
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
</body>

</html>