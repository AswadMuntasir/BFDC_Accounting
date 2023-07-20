@extends('layout.app')

@section('content')
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <h2 class="mb-4">Sub A/C Ledger</h2>
          <div class="row">
            <form method="POST" action="{{ route('subACLedgerView') }}">
              @csrf
              <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="subsidiary_ac_id">Subsidiary Account:</label>
                        <select name="subsidiary_ac_id" id="subsidiary_ac_id" class="form-control">
                            <option value="">Select Subsidiary Account</option>
                            @foreach ($subsidiaryAccounts as $subsidiaryAccount)
                                <option value="{{ $subsidiaryAccount->account_name }}">{{ $subsidiaryAccount->account_name }}</option>
                            @endforeach
                        </select>
                        @error('subsidiary_ac_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input name="start_date" id="start_date" class="form-control datetimepicker" type="text" placeholder="Start Date" data-options='{"disableMobile":true}'>
                        @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input name="end_date" id="end_date" class="form-control datetimepicker" type="text" placeholder="End Date" data-options='{"disableMobile":true}'>
                        @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary" style="margin-top: 23px;">Search</button>
                </div>
              </div>
              <br><br>
            </form>
          
            @if (!is_null($ledgerData))
              <h2>Ledger Data</h2>
              <table class="table">
                  <thead>
                      <tr>
                          <th>Voucher Date</th>
                          <th>Name</th>
                          <th>Total DR Amount</th>
                          <th>Total CR Amount</th>
                          <th>Balance</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($ledgerData as $entry)
                          <tr>
                              <td>{{ $entry['voucher_date'] }}</td>
                              <td>{{ $entry['name'] }}</td>
                              <td>{{ $entry['total_dr_amount'] }}</td>
                              <td>{{ $entry['total_cr_amount'] }}</td>
                              <td>{{ $entry['balance'] }}</td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
            @endif
          </div>
          
          @include('layout.footer')
        </div>
      </div>
@endsection