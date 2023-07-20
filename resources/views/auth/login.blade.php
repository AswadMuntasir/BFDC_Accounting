@extends('layout.app')
@section('content')
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <div class="container-fluid px-0" data-layout="container">
        <div class="container">
          <div class="row flex-center min-vh-100 py-5">
            <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a class="d-flex flex-center text-decoration-none mb-4" href="#">
                <div class="d-flex align-items-center fw-bolder fs-5 d-inline-block"><img src="{{ asset('assets/img/BFDC_logo.png') }}" alt="BFDC" width="150" /></div>
              </a>
              <div class="text-center mb-7">
                <h3 class="text-1000">Sign In</h3>
                <p class="text-700">Get access to your account</p>
              </div>
              <form method="POST" action="{{ route('login.custom') }}">
                @csrf
                <div class="mb-3 text-start"><label class="form-label" for="email">Email address</label>
                    <div class="form-icon-container">
                        <input class="form-control form-icon-input" id="email" name="email" type="email" placeholder="name@example.com" required autofocus />
                        <span class="fas fa-user text-900 fs--1 form-icon"></span>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
                <div class="mb-3 text-start"><label class="form-label" for="password">Password</label>
                    <div class="form-icon-container">
                        <input class="form-control form-icon-input" id="password" name="password" type="password" placeholder="Password" />
                        <span class="fas fa-key text-900 fs--1 form-icon"></span>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">Sign In</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main><!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->
@endsection