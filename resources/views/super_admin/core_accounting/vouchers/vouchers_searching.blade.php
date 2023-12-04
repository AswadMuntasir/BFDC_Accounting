@extends('layout.app')

@section('content')
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <h2 class="mb-4">Voucher Searching</h2>
          <div class="row">
            <div class="col-xl-4">
              <form class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 28px;border-radius: 10px;" method="post" action="{{ route('vouchersSearching') }}">
                @csrf
                <div class="col-sm-12 col-md-12">
                    <h4>Voucher Searching</h4>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="form-floating">
                    <select class="select2 form-select" id="fin_year_input" name="fin_year_input">
                      <option selected="selected" value="2024">2024</option>
                      <option value="2023">2023</option>
                      <option value="2022">2022</option>
                    </select><label for="fin_year_input">Fin Year</label></div>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="form-floating">
                    <select class="select2 form-select" id="fin_month_input" name="fin_month_input">
                      <option selected="selected" value="01">January</option>
                      <option value="02">February</option>
                      <option value="03">March</option>
                      <option value="04">April</option>
                      <option value="05">May</option>
                      <option value="06">June</option>
                      <option value="07">July</option>
                      <option value="08">August</option>
                      <option value="09">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                    </select><label for="fin_month_input">Fin Month</label></div>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="form-floating">
                    <select class="select2 form-select" id="voucher_type_input" name="voucher_type_input">
                      <option selected="selected" value="Journal">Journal</option>
                      <option value="Advanced Payment">Advanced Payment</option>
                      <option value="Payment Voucher">Payment Voucher</option>
                      <option value="Receipt Voucher">Receipt Voucher</option>
                      <option value="Adjustment">Adjustment</option>
                    </select><label for="voucher_type_input">Voucher Type</label></div>
                </div>
                <div class="col-sm-8 col-md-12">
                  <div class="form-floating"><input class="form-control" id="pv_av_no_input" name="pv_av_no_input" type="text" placeholder="PV / AV No" /><label for="pv_av_no_input">PV/AV No</label></div>
                </div>

                <div class="col-12 gy-6">
                  <div class="row g-3 justify-content-end">
                    <div class="col-auto"><button class="btn btn-phoenix-primary px-5">Cancel</button></div>
                    <div class="col-auto"><button type="submit" class="btn btn-primary px-5 px-sm-12">Search</button></div>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-xl-8">
                <div class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 5px;border-radius: 10px;">
                    <div class="col-sm-12 col-md-12">
                        <h4>Voucher List</h4>
                        @if($voucherList)
                        <table class="table">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Voucher No</th>
                                  <th>Total Amount</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($voucherList as $voucher)
                                  <tr>
                                      <td>{{ $voucher->id }}</td>
                                      <td>{{ $voucher->voucher_no }}</td>
                                      <td>{{ $voucher->total_dr_amount }}</td>
                                  </tr>
                              @endforeach
                          </tbody>
                        </table>
                        @else
                        <p>No data available.</p>
                        @endif
                    </div>
                </div>
            </div>
          </div>
          <script>$('.select2').select2();</script>
          @include('layout.footer')
        </div>
      </div>
@endsection