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
            
            <h3>Receipt Voucher</h3>
            @if(!is_null($data))
              <table style="width: 100%;">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Name</th>
                      <th>Dr Amount</th>
                      <th>Cr Amount</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $item)
                      <tr>
                          <td>{{ $item['date'] }}</td>
                          <td>
                              @foreach ($item['dr_amount'] as $drAmount)
                                  {{ $drAmount['name'] }}<br>
                              @endforeach
                          </td>
                          <td>
                              @foreach ($item['dr_amount'] as $drAmount)
                                  {{ $drAmount['amount'] }}<br>
                              @endforeach
                          </td>
                          <td>
                              @foreach ($item['cr_amount'] as $crAmount)
                                  {{ $crAmount['amount'] }}<br>
                              @endforeach
                          </td>
                          <td>
                            @php
                              $drTotal = array_sum(array_column($item['dr_amount'], 'amount'));
                              $crTotal = array_sum(array_column($item['cr_amount'], 'amount'));
                              $total = $drTotal - $crTotal;
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

            @include('layout.footer')
        </div>
    </div>
@endsection