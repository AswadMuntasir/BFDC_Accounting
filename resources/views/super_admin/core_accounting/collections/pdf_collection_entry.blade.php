<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>Collection Entry PDF</title>
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1"
		/>
        <!-- ===============================================-->
        <!--    Favicons-->
        <!-- ===============================================-->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/BFDC_logo.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/BFDC_logo.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/BFDC_logo.png') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/BFDC_logo.png') }}">
        <link rel="manifest" href="{{ asset('assets/img/favicons/manifest.json') }}">
        <meta name="msapplication-TileImage" content="{{ asset('assets/img/BFDC_logo.png') }}">
        <meta name="theme-color" content="#ffffff">
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
        <link rel="stylesheet" href="../../../unicons.iconscout.com/release/v4.0.0/css/line.css') }}">
        <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
        <link href="{{ asset('assets/css/theme.min.css') }}" type="text/css" rel="stylesheet" id="style-default">
        <link href="{{ asset('assets/css/user-rtl.min.css') }}" type="text/css" rel="stylesheet" id="user-style-rtl">
        <link href="{{ asset('assets/css/user.min.css') }}" type="text/css" rel="stylesheet" id="user-style-default">
        <script src="{{ asset('assets/js/jquery-3.6.4.min.js') }}"></script>
		
        
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
	</head>
	<body>
        <br>
        <div style="float:right; margin-right:20%;">
    		<button id="download-button" onclick="pdf_download()" class="btn btn-primary px-5 px-sm-15">Download as PDF</button>
        </div>
        <br> <br>
        <div style="border: 2px solid #000000; font-size: 10pt; background-color:#ffffff; width: 60%; margin-left: auto; margin-right: auto;">
            <div style="width: 100%; margin-left: auto; margin-right: auto;">
                <div id="invoice" style="width: 80%; margin-top: 40px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                    <br><br>
                    <div class="row">
                        <div class="col-2"><img src="{{ asset('assets/img/bfdc-logo-2.png') }}" width="100" height="80" /></div>
                        <div class="col-8">
                            <center>
                                <span style="font-size: 12pt; font-weight:900;">বাংলাদেশ ম​ৎস উন্নয়ন কর্পোরেশন​</span><br>
                                <span style="font-size: 12pt; font-weight:500;">চট্টগ্রাম ম​ৎস বন্দর​, চট্টগ্রাম​</span>
                            </center>
                            <br><br>
                        </div>
                        <div class="col-2"></div>
                    </div>    
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <b>ID No:</b> {{$collection_entry->id}}
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <b>Collection Date:</b> {{$collection_entry->collection_date}}
                                </div>
                                <div class="col-12">
                                    <b>Bill Section:</b> {{$collection_entry->bill_section}}
                                    <br>
                                </div>
                                <div class="col-12">
                                    <b>Customer Name:</b> {{$collection_entry->customer_name}}
                                    <br>
                                </div>
                                <div class="col-12">
                                    <b>Collection Type:</b> {{$collection_entry->collection_type}}
                                    <br>
                                </div>
                                <div class="col-12">
                                    <b>Description:</b> {{$collection_entry->description}}
                                    <br><br>
                                </div>
                                <div class="col-12">
                                    <?php 
                                        $dr_table_amount = json_decode($collection_entry->dr_amount); 
                                    ?>
                                    <b>Dr. Amount:</b>
                                    @if($dr_table_amount != "" || $dr_table_amount != null)
                                    <table border="1" style="width: 100%">
                                        <tr>
                                            <th style="width: 10%; border: 1px solid #000000;">ID</th>
                                            <th style="width: 50%; border: 1px solid #000000;">Name</th>
                                            <th style="width: 40%; border: 1px solid #000000;">Amount</th>
                                        </tr>
                                        @foreach($dr_table_amount as $dr_table)
                                        <tr>
                                            <td style="width: 10%; border: 1px solid #000000;">{{$dr_table->id}}</td>
                                            <td style="width: 50%; border: 1px solid #000000;">{{$dr_table->name}}</td>
                                            <td style="width: 40%; border: 1px solid #000000;">{{$dr_table->amount}}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                    @endif
                                    <br><br>
                                </div>
                                <div class="col-12">
                                <?php 
                                        $cr_table_amount = json_decode($collection_entry->cr_amount); 
                                    ?>
                                    <b>Cr. Amount:</b>
                                    @if($cr_table_amount != "" || $cr_table_amount != null)
                                    <table border="1" style="width: 100%">
                                        <tr>
                                            <th style="width: 10%; border: 1px solid #000000;">ID</th>
                                            <th style="width: 50%; border: 1px solid #000000;">Name</th>
                                            <th style="width: 40%; border: 1px solid #000000;">Amount</th>
                                        </tr>
                                        @foreach($cr_table_amount as $cr_table)
                                        <tr>
                                            <td style="width: 10%; border: 1px solid #000000;">{{$cr_table->id}}</td>
                                            <td style="width: 50%; border: 1px solid #000000;">{{$cr_table->name}}</td>
                                            <td style="width: 40%; border: 1px solid #000000;">{{$cr_table->amount}}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                    @endif
                                    <br><br>
                                </div>
                                <div class="col-12">
                                    <b>Collection Amount:</b> {{$collection_entry->collection_amount}} Taka
                                    <br><br><br>
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