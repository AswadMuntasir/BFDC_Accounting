@extends('layout.app')

@section('content')
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <div class="pb-5">
            <div class="row g-4">
              <div class="col-12 col-xxl-6">
                <div class="mb-8">
                  <h2 class="mb-2">BFDC Accounce Dashboard</h2>
                </div>
              </div>
            </div>
          </div>
          
          @include('layout.footer')
        </div>
      </div>
@endsection