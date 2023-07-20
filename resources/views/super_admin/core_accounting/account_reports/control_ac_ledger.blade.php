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
                    @php
                        $totalSum = 0;
                    @endphp
                    @foreach ($ledgerData as $ledger)
                        @foreach ($ledger->dr_amount as $dr_amount)
                            @php
                                $cr_amount = $ledger->cr_amount->firstWhere('name', $dr_amount->name);
                                $cr_amount_value = $cr_amount ? $cr_amount->amount : 0;
                                $total = $dr_amount->amount - $cr_amount_value;
                                $totalSum += $total;
                            @endphp
                            <tr>
                                <td>{{ $ledger->voucher_date }}</td>
                                <td>{{ $dr_amount->name }}</td>
                                <td>{{ $dr_amount->amount }}</td>
                                <td>{{ $cr_amount_value }}</td>
                                <td>{{ $total }}</td>
                            </tr>
                        @endforeach
                        @foreach ($ledger->cr_amount as $cr_amount)
                            @if (!$ledger->dr_amount->contains('name', $cr_amount->name))
                                @php
                                    $total = -$cr_amount->amount;
                                    $totalSum += $total;
                                @endphp
                                <tr>
                                    <td>{{ $ledger->voucher_date }}</td>
                                    <td>{{ $cr_amount->name }}</td>
                                    <td>0</td>
                                    <td>{{ $cr_amount->amount }}</td>
                                    <td>{{ $total }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $totalSum }}</td>
                    </tr>
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