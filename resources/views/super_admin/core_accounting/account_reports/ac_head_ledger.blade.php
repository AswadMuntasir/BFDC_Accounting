@extends('layout.app')

@section('content')
<div class="container-fluid px-0" data-layout="container">
    @include('layout.navbar.navbar')
    <!-- Content Starts Here -->
    <div class="content">
        <h2 class="mb-4">AC Head Ledger</h2>
        <div class="row">
            <form action="{{ route('acHeadLedgerView') }}" method="POST">
                @csrf
                <div class="row">
                  <div class="col-4">
                    <div class="form-group">
                      <label for="ac_head_name_eng">Select AC Head:</label>
                      <select class="form-control" name="ac_head_name_eng" id="ac_head_name_eng">
                          <option value="">Select AC Head</option>
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
                  <div class="col-2">
                    <button type="submit" class="btn btn-primary" style="margin-top: 23px;">Search</button>
                  </div>
                </div>
            </form>

            <hr style="margin-top: 10px;">

            @if ($ledgerData)
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>DR Amount</th>
                        <th>CR Amount</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ledgerData as $ledger)
                    <tr>
                        <td>{{ $ledger->voucher_date }}</td>
                        <td>{{ $selectedAccountName }}</td>
                        <td>
                            @if ($ledger->dr_amount->isNotEmpty())
                            @foreach ($ledger->dr_amount as $amount)
                            {{ $amount->amount }}<br>
                            @endforeach
                            @else
                            0
                            @endif
                        </td>
                        <td>
                            @if ($ledger->cr_amount->isNotEmpty())
                            @foreach ($ledger->cr_amount as $amount)
                            {{ $amount->amount }}<br>
                            @endforeach
                            @else
                            0
                            @endif
                        </td>
                        <td>
                            @php
                            $total = 0;
                            foreach ($ledger->dr_amount as $amount) {
                            $total += $amount->amount;
                            }
                            foreach ($ledger->cr_amount as $amount) {
                            $total -= $amount->amount;
                            }
                            @endphp
                            {{ $total }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>No data available.</p>
            @endif
        </div>

        @include('layout.footer')
    </div>
</div>
@endsection