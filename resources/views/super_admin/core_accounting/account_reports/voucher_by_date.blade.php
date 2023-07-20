@extends('layout.app')

@section('content')
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <h2 class="mb-4">Voucher By Date</h2>
          <div class="row">
          </div>
          
          @include('layout.footer')
        </div>
      </div>
@endsection