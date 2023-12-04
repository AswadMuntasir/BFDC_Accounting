@extends('layout.app')

@section('content')
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <h2 class="mb-4">Office Cheif</h2>
          <div class="row">
          <div class="col-xl-7">
              <form class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 28px;border-radius: 10px;" action="{{ route('office_chief_post') }}" method="POST">
                @csrf
                <div class="col-sm-12 col-md-12">
                    <h4>Create New Office Cheif</h4>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating">
                    <select class="select2 form-select" id="department_input" name="department_input">
                      <option selected="selected" value="BFDC, Chattogram Fish Harbour">BFDC, Chattogram Fish Harbour</option>
                    </select><label for="department_input">Department</label></div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating"><input class="form-control" id="office_chief_code_input" name="office_chief_code_input" type="text" placeholder="Office Chief Code" /><label for="office_chief_code_input">Office Chief Code</label></div>
                </div>
                <div class="col-12 gy-6">
                  <div class="row g-3 justify-content-end">
                    <div class="col-auto"><button class="btn btn-phoenix-primary px-5">Cancel</button></div>
                    <div class="col-auto"><button class="btn btn-primary px-5 px-sm-15" type="submit">Create Office Cheif</button></div>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-xl-5">
                <form class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 5px;border-radius: 10px;" action="#">
                    <div class="col-sm-12 col-md-12">
                        <h4>Account Head List</h4>
                    </div>
                    <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;head_id&quot;,&quot;group_name&quot;,&quot;accounts_name&quot;],&quot;page&quot;:5,&quot;pagination&quot;:true}">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm fs--1 mb-0">
                              <thead>
                                  <tr>
                                      <th class="sort border-top ps-3" data-sort="department">Department</th>
                                      <th class="sort border-top" data-sort="office_chief_code">Accounts<br>Office Cheif Code</th>
                                      <th class="sort text-end align-middle pe-0 border-top" scope="col">ACTION</th>
                                  </tr>
                              </thead>
                              <tbody class="list">
                                @foreach($office_chiefs as $office_chief)  
                                  <tr>
                                    <td class="align-middle ps-3 department">{{$office_chief->department}}</td>
                                    <td class="align-middle office_chief_code">{{$office_chief->office_chief_code}}</td>
                                    <td class="align-middle white-space-nowrap text-end pe-0">
                                        <div class="font-sans-serif btn-reveal-trigger position-static"><button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><svg class="svg-inline--fa fa-ellipsis fs--2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z"></path></svg><!-- <span class="fas fa-ellipsis-h fs--2"></span> Font Awesome fontawesome.com --></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Edit</a>
                                            <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                                        </div>
                                        </div>
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3"><button class="page-link disabled" data-list-pagination="prev" disabled=""><svg class="svg-inline--fa fa-chevron-left" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"></path></svg><!-- <span class="fas fa-chevron-left"></span> Font Awesome fontawesome.com --></button>
                            <ul class="mb-0 pagination"><li class="active"><button class="page" type="button" data-i="1" data-page="5">1</button></li><li><button class="page" type="button" data-i="2" data-page="5">2</button></li><li><button class="page" type="button" data-i="3" data-page="5">3</button></li></ul><button class="page-link" data-list-pagination="next"><svg class="svg-inline--fa fa-chevron-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path></svg><!-- <span class="fas fa-chevron-right"></span> Font Awesome fontawesome.com --></button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
          <script>$('.select2').select2();</script>
          @include('layout.footer')
        </div>
      </div>
@endsection