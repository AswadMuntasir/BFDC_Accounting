@extends('layout.app')

@section('content')
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <h2 class="mb-4">Collection Entry</h2>
          <div class="row">
            <div class="col-xl-12">
              <form class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 28px;border-radius: 10px;" method="post" action="{{ route('collection_entry_post') }}">
                @csrf
                <div class="col-sm-12 col-md-12">
                    <h4>Create New Collection Entry</h4>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="flatpickr-input-container">
                    <div class="form-floating"><input class="form-control datetimepicker" id="collection_date_input" name="collection_date_input" type="text" placeholder="end date" data-options='{"disableMobile":true}' required/><label class="ps-6" for="collection_date_input">Collection Date</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="bill_section_input" name="bill_section_input">
                      <option selected="selected" value="Assets">Assets</option>
                      <option value="Libility">Libility</option>
                      <option value="Income">Income</option>
                    </select><label for="bill_section_input">Bill Receivable Section</label></div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="customer_name_input" name="customer_name_input">
                      @foreach($parties as $party)
                      <option value="{{ $party->name }}">{{ $party->name }}</option>
                      @endforeach
                    </select><label for="customer_name_input">Customer Name</label></div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="collection_type_input" name="collection_type_input">
                      <option selected="selected" value="Cash">Cash</option>
                      <option value="Cheque">Cheque</option>
                      <option value="Bank Draft">Bank Draft</option>
                    </select><label for="collection_type_input">Collection Type</label></div>
                </div>
                <div class="col-sm-12 col-md-6" id="type_name_input_div" style="display: none;">
                  <div class="form-floating"><input class="form-control" id="type_name_input" name="type_name_input" type="text" placeholder="Bank Name" /><label for="type_name_input">Bank Name</label></div>
                </div>
                <div class="col-sm-12 col-md-6" id="type_cheque_input_div" style="display: none;">
                  <div class="form-floating"><input class="form-control" id="type_cheque_input" name="type_cheque_input" type="text" placeholder="Account / Cheque Number" /><label for="type_cheque_input">Account / Cheque Number</label></div>
                </div>
                <div class="col-sm-12 col-md-6" id="type_date_input_div" style="display: none;">
                  <div class="form-floating"><input class="form-control" id="type_date_input" name="type_date_input" type="text" placeholder="Cheque Issue Date" /><label for="type_date_input">Cheque Issue Date</label></div>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="form-floating"><textarea class="form-control" id="description_input" name="description_input" placeholder="Description" style="height: 50px"></textarea><label for="description_input">Description</label></div>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="form-floating">
                    <select class="form-select" id="dr_head_name_input">
                      @foreach($account_heads as $account_head)
                      <option value="{{ $account_head->ac_head_name_eng }}">{{ $account_head->ac_head_name_eng }}</option>
                      @endforeach
                    </select><label for="dr_head_name_input">Dr. Head Name</label></div>
                </div>
                <div class="col-sm-8 col-md-8">
                  <div class="form-floating"><input class="form-control" id="dr_amount_input" type="number" min="0" value="0.00" placeholder="Dr. Amount" /><label for="dr_amount_input">Dr. Amount</label></div>
                </div>
                <div class="col-sm-4 col-md-4">
                  <button class="btn btn-primary me-1 mb-1" id="add_dr_list" type="button" style="margin-top: 6px;">Add to DR. List</button>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="card border border-secondary">
                    <div class="card-body">
                      <p class="card-text" id="dr_amount_table">DR. Amount is empty</p>
                    </div>
                  </div>
                  <textarea id="dr_amount_table_ta" name="dr_amount_table_ta" style="display: none;">
                    
                  </textarea>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="form-floating">
                    <select class="form-select" id="cr_head_name_input">
                      @foreach($account_heads as $account_head)
                        <option value="{{ $account_head->ac_head_name_eng }}">{{ $account_head->ac_head_name_eng }}</option>
                      @endforeach
                    </select><label for="cr_head_name_input">Cr. Head Name</label></div>
                </div>
                <div class="col-sm-8 col-md-8">
                  <div class="form-floating"><input class="form-control" id="cr_amount_input" type="number" min="0" value="0.00" placeholder="Cr. Amount" /><label for="cr_amount_input">Cr. Amount</label></div>
                </div>
                <div class="col-sm-4 col-md-4">
                  <button class="btn btn-primary me-1 mb-1" type="button" id="add_cr_list" style="margin-top: 6px;">Add to CR. List</button>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="card border border-secondary">
                    <div class="card-body">
                      <p class="card-text" id="cr_amount_table">CR. Amount is empty</p>
                    </div>
                  </div>
                  <textarea id="cr_amount_table_ta" name="cr_amount_table_ta" style="display: none;">
                    
                  </textarea>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="form-floating"><input class="form-control" id="collection_amount_input" name="collection_amount_input" type="text" placeholder="Collection Amount" /><label for="collection_amount_input">Collection Amount</label></div>
                </div>

                <div class="col-12 gy-6">
                  <div class="row g-3 justify-content-end">
                    <div class="col-auto"><button class="btn btn-phoenix-primary px-5">Cancel</button></div>
                    <div class="col-auto"><button type="submit" id="create_collection_btn" class="btn btn-primary px-5 px-sm-15">Create Collection Entry</button></div>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-xl-12">
                <div class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 5px;border-radius: 10px;">
                    <div class="col-sm-12 col-md-12">
                        <h4>Collection Entry List</h4>
                    </div>
                    <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;head_id&quot;,&quot;group_name&quot;,&quot;accounts_name&quot;],&quot;page&quot;:25,&quot;pagination&quot;:true}">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm fs--1 mb-0">
                            <thead>
                                <tr align="center">
                                    <th class="sort border-top ps-3" style="display: none;" data-sort="id">ID</th>
                                    <th class="sort border-top ps-3" data-sort="date">Collection Date</th>
                                    <th class="sort border-top ps-3" data-sort="pdf">PDF</th>
                                    <th class="sort border-top" data-sort="bill_receivable_section">Bill Receivable<br>Section</th>
                                    <th class="sort border-top" data-sort="customer_name">Customer<br>Name</th>
                                    <th class="sort border-top ps-3" data-sort="type">Collection<br>Type</th>
                                    <th class="sort border-top" data-sort="amount">Collection<br>Amount</th>
                                    <th class="sort text-end align-middle pe-0 border-top" scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                              @foreach($collection_entries as $coll_entry)
                              <tr align="center">
                                <td class="align-middle ps-3 id" style="display: none;">{{$coll_entry->id}}</td>
                                <td class="align-middle ps-3 date">{{$coll_entry->collection_date}}</td>
                                <td class="align-middle pdf"><a href="{{ route('view_details_page', ['id' => $coll_entry->id]) }}" target="_blank">Show</a></td>
                                <td class="align-middle bill_receivable_section">{{$coll_entry->bill_section}}</td>
                                <td class="align-middle ps-3 customer_name">{{$coll_entry->customer_name}}</td>
                                <td class="align-middle type">{{$coll_entry->collection_type}}</td>
                                <td class="align-middle amount">{{$coll_entry->collection_amount}}</td>
                                <td class="align-middle white-space-nowrap text-end pe-0">
                                  <div class="font-sans-serif btn-reveal-trigger position-static">
                                    <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                        <svg class="svg-inline--fa fa-ellipsis fs--2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z"></path>
                                        </svg><!-- <span class="fas fa-ellipsis-h fs--2"></span> Font Awesome fontawesome.com -->
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" data-bs-toggle="modal"role="button" href="#edit_collection_entry_modal">Edit</a>
                                      <div class="dropdown-divider"></div><a class="dropdown-item text-danger" onclick="delete_voucher_function('{{ $coll_entry->id }}', '{{ $coll_entry->description }}')">Remove</a>
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
                </div>
            </div>
          </div>
          <div class="modal fade" id="edit_collection_entry_modal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="updateModalLabel">Update</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-12 col-md-12">
                      <div class="form-floating"><input style="display: none;" class="form-control" id="list_type" name="list_type" type="text" placeholder="id" /><label for="list_type">Type</label></div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                      <div class="form-floating"><input style="display: none;" class="form-control" id="list_id" name="list_id" type="text" placeholder="id" /><label for="list_id">Id</label></div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                      <div class="form-floating"><input class="form-control" id="list_name" name="list_name" type="text" placeholder="Name" /><label for="list_name">Name</label></div><br>
                    </div>
                    <div class="col-sm-12 col-md-12">
                      <div class="form-floating"><input class="form-control" id="list_amount" name="list_amount" type="number" placeholder="Amount" /><label for="list_amount">Amount</label></div><br>
                    </div>
                    <div class="col-sm-12 col-md-12">
                      <center>
                        <button class="btn btn-primary px-5 px-sm-15" onclick="update_list_value()">Update</button>
                      </center>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="delete_collection_modal" aria-hidden="true" aria-labelledby="delete_collection_modal_label" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-2" id="delete_collection_modal_label">Delete This Collection Voucher</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <span id="voucher_no_delete"></span>
                  <!-- <h1 class="modal-title fs-2" id="delete_collection_modal_label">Are you sure?</h1> -->
                  <form class="row g-3" action="{{ route('collection_entry_delete') }}" method="POST" enctype="multipart/form-data" id="ModalForm">
                    {{csrf_field()}}

                    <input type="hidden" id="id_delete" name="id_delete" readonly>
                    <input type="hidden" id="description_delete" name="description_delete" readonly>
                    <div class="modal-footer">
                        <a  class="btn btn-secondary" data-dismiss="modal">Close</a>
                        <button type="submit" id="deleteModalButton" class="btn btn-primary" data-dismiss="modal">Delete Account</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <script>
            $("#create_collection_btn").prop("disabled", true);
            $("#collection_type_input").on("change", function(){
              if($("#collection_type_input").val() !== "Cash") {
                $("#type_date_input_div").show();
                $("#type_cheque_input_div").show();
                $("#type_name_input_div").show();
                $("#type_date_input").prop("disabled", false);
                $("#type_cheque_input").prop("disabled", false);
                $("#type_name_input").prop("disabled", false);
              }
              else {
                $("#type_date_input_div").hide();
                $("#type_cheque_input_div").hide();
                $("#type_name_input_div").hide();
                $("#type_date_input").prop("disabled", true);
                $("#type_cheque_input").prop("disabled", true);
                $("#type_name_input").prop("disabled", true);
              }
            })

            var dr_head_name_val = "";
            var dr_amount_val = "";
            var dr_list_val = [];
            var dr_list_index = 0;
            var dr_amount_table_data = "";
            var dr_amount_total = 0;
            var cr_amount_total = 0;
            $("#add_dr_list").click(function(){
              dr_list_index = dr_list_index + 1;
              dr_amount_val = $("#dr_amount_input").val();
              dr_head_name_val = $('#dr_head_name_input').val();
              dr_amount_table_ta = "";
              dr_amount_total = 0;
              dr_list_val.push( {"id": dr_list_index, "name": dr_head_name_val, "amount": dr_amount_val} );
              console.log(dr_list_val);
              dr_amount_table_data = "<style>table{font-family: arial, sans-serif;font-size: 12px; border-collapse: collapse;width: 100%;}td, th{border: 1px solid #dddddd;text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #dddddd;}</style><table><tr><th>No</th><th>Name</th><th>Amount</th><th>Actions</th></tr>";
              for (let index = 0; index < dr_list_val.length; index++) {
                dr_amount_table_data = dr_amount_table_data + "<tr><td>"+ dr_list_val[index].id +"</td><td>"+ dr_list_val[index].name +"</td><td>"+ dr_list_val[index].amount +"</td><td><div class='font-sans-serif btn-reveal-trigger position-static'><button class='btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2' type='button' data-bs-toggle='dropdown' data-boundary='window' aria-haspopup='true' aria-expanded='false' data-bs-reference='parent'><svg class='svg-inline--fa fa-ellipsis fs--2' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='ellipsis' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' data-fa-i2svg=''><path fill='currentColor' d='M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z'></path></svg></button><div class='dropdown-menu dropdown-menu-end py-2'><a class='dropdown-item' data-bs-toggle='modal' role='button' href='#update_list_val' onclick='editfunction(0," + dr_list_val[index].id + ")'>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item text-danger'  data-bs-toggle='modal' role='button' href='#delete_list_val' onclick='deletefunction(0," + dr_list_val[index].id + ")'>Remove</a></div></div></td></tr>"
                dr_amount_total = dr_amount_total + parseInt(dr_list_val[index].amount);
              }
              dr_amount_table_data = dr_amount_table_data + "</table>";
              $('#dr_amount_table').html(dr_amount_table_data);
              $('#dr_amount_table_ta').val(JSON.stringify(dr_list_val));
              $('#collection_amount_input').val(dr_amount_total);
              if(dr_amount_total == cr_amount_total) {
                $("#create_collection_btn").prop("disabled", false);
              }
              else {
                $("#create_collection_btn").prop("disabled", true);
              }
            });

            var cr_head_name_val = "";
            var cr_amount_val = "";
            var cr_list_val = [];
            var cr_list_index = 0;
            var cr_amount_table_data = "";
            $("#add_cr_list").click(function(){
              cr_list_index = cr_list_index + 1;
              cr_amount_val = $("#cr_amount_input").val();
              cr_head_name_val = $('#cr_head_name_input').val();
              cr_list_val.push( {"id": cr_list_index, "name": cr_head_name_val, "amount": cr_amount_val} );
              console.log(cr_list_val);
              cr_amount_total = 0;
              cr_amount_table_data = "<style>table{font-family: arial, sans-serif;font-size: 12px; border-collapse: collapse;width: 100%;}td, th{border: 1px solid #dddddd;text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #dddddd;}</style><table><tr><th>No</th><th>Name</th><th>Amount</th><th>Actions</th></tr>";
              for (let index = 0; index < cr_list_val.length; index++) {
                cr_amount_table_data = cr_amount_table_data + "<tr><td>"+ cr_list_val[index].id +"</td><td>"+ cr_list_val[index].name +"</td><td>"+ cr_list_val[index].amount +"</td><td><div class='font-sans-serif btn-reveal-trigger position-static'><button class='btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2' type='button' data-bs-toggle='dropdown' data-boundary='window' aria-haspopup='true' aria-expanded='false' data-bs-reference='parent'><svg class='svg-inline--fa fa-ellipsis fs--2' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='ellipsis' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' data-fa-i2svg=''><path fill='currentColor' d='M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z'></path></svg></button><div class='dropdown-menu dropdown-menu-end py-2'><a class='dropdown-item' data-bs-toggle='modal' role='button' href='#update_list_val' onclick='editfunction(1,"+ cr_list_val[index].id + ")'>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item text-danger'  data-bs-toggle='modal' role='button' href='#delete_list_val' onclick='deletefunction(1," + cr_list_val[index].id + ")'>Remove</a></div></div></td></tr>"
                cr_amount_total = cr_amount_total + parseInt(cr_list_val[index].amount);
              }
              cr_amount_table_data = cr_amount_table_data + "</table>";
              $('#cr_amount_table').html(cr_amount_table_data);
              $('#cr_amount_table_ta').val(JSON.stringify(cr_list_val));
              if(dr_amount_total == cr_amount_total) {
                $("#create_collection_btn").prop("disabled", false);
              }
              else {
                $("#create_collection_btn").prop("disabled", true);
              }
            });

            function editfunction(list_num, id) {
              if(list_num == 0) {
                $('#list_type').val("Dr");
                $('#list_id').val(id);
                $('#list_name').val(dr_list_val[id-1].name);
                $('#list_amount').val(dr_list_val[id-1].amount);
              } else if(list_num == 1) {
                $('#list_type').val("Cr");
                $('#list_id').val(id);
                $('#list_name').val(cr_list_val[id-1].name);
                $('#list_amount').val(cr_list_val[id-1].amount);
              }
            }
            function update_list_value() {
              var list_type_val = $('#list_type').val();
              var list_id_val = $('#list_id').val();
              var list_name_val = $('#list_name').val();
              var list_amount_val = $('#list_amount').val();

              if(list_type_val == "Dr") {
                dr_list_val[list_id_val-1].name = list_name_val;
                dr_list_val[list_id_val-1].amount = list_amount_val;
                dr_amount_total = 0;
                dr_amount_table_data = "<style>table{font-family: arial, sans-serif;font-size: 12px; border-collapse: collapse;width: 100%;}td, th{border: 1px solid #dddddd;text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #dddddd;}</style><table><tr><th>No</th><th>Name</th><th>Amount</th><th>Actions</th></tr>";
                for (let index = 0; index < dr_list_val.length; index++) {
                  dr_amount_table_data = dr_amount_table_data + "<tr><td>"+ dr_list_val[index].id +"</td><td>"+ dr_list_val[index].name +"</td><td>"+ dr_list_val[index].amount +"</td><td><div class='font-sans-serif btn-reveal-trigger position-static'><button class='btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2' type='button' data-bs-toggle='dropdown' data-boundary='window' aria-haspopup='true' aria-expanded='false' data-bs-reference='parent'><svg class='svg-inline--fa fa-ellipsis fs--2' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='ellipsis' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' data-fa-i2svg=''><path fill='currentColor' d='M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z'></path></svg></button><div class='dropdown-menu dropdown-menu-end py-2'><a class='dropdown-item' data-bs-toggle='modal' role='button' href='#update_list_val' onclick='editfunction(0," + dr_list_val[index].id + ")'>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item text-danger'  data-bs-toggle='modal' role='button' href='#delete_list_val' onclick='deletefunction(0," + dr_list_val[index].id + ")'>Remove</a></div></div></td></tr>"
                  dr_amount_total = dr_amount_total + parseInt(dr_list_val[index].amount);
                }
                dr_amount_table_data = dr_amount_table_data + "</table>";
                $('#dr_amount_table').html(dr_amount_table_data);
                $('#update_list_val').modal('toggle');
                $('#collection_amount_input').val(dr_amount_total);
              } else {
                cr_list_val[list_id_val-1].name = list_name_val;
                cr_list_val[list_id_val-1].amount = list_amount_val;
                cr_amount_total = 0;
                cr_amount_table_data = "<style>table{font-family: arial, sans-serif;font-size: 12px; border-collapse: collapse;width: 100%;}td, th{border: 1px solid #dddddd;text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #dddddd;}</style><table><tr><th>No</th><th>Name</th><th>Amount</th><th>Actions</th></tr>";
                for (let index = 0; index < cr_list_val.length; index++) {
                  cr_amount_table_data = cr_amount_table_data + "<tr><td>"+ cr_list_val[index].id +"</td><td>"+ cr_list_val[index].name +"</td><td>"+ cr_list_val[index].amount +"</td><td><div class='font-sans-serif btn-reveal-trigger position-static'><button class='btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2' type='button' data-bs-toggle='dropdown' data-boundary='window' aria-haspopup='true' aria-expanded='false' data-bs-reference='parent'><svg class='svg-inline--fa fa-ellipsis fs--2' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='ellipsis' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' data-fa-i2svg=''><path fill='currentColor' d='M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z'></path></svg></button><div class='dropdown-menu dropdown-menu-end py-2'><a class='dropdown-item' data-bs-toggle='modal' role='button' href='#update_list_val' onclick='editfunction(1,"+ cr_list_val[index].id + ")'>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item text-danger'  data-bs-toggle='modal' role='button' href='#delete_list_val' onclick='deletefunction(1," + cr_list_val[index].id + ")'>Remove</a></div></div></td></tr>"
                  cr_amount_total = cr_amount_total + parseInt(cr_list_val[index].amount);
                }
                cr_amount_table_data = cr_amount_table_data + "</table>";
                $('#cr_amount_table').html(cr_amount_table_data);
                $('#update_list_val').modal('toggle');
              }
              if(dr_amount_total == cr_amount_total) {
                $("#create_collection_btn").prop("disabled", false);
              }
              else {
                $("#create_collection_btn").prop("disabled", true);
              }
            }

            function delete_voucher_function(vouchers_id, description_delete) {
              console.log(vouchers_id);
              document.getElementById("id_delete").value = vouchers_id;
              document.getElementById("description_delete").value = description_delete;
              $("#voucher_no_delete").html("<h2 class='modal-title fs-1'>Are you sure you want to delete " + vouchers_id + " ?</h2>");
              $('#delete_collection_modal').modal('show');
            }

            function deletefunction(list_num, id) {
              console.log(list_num, id);
              if(list_num == 0) {
                var index_dr = -1;
                var val = id
                var filteredObj = dr_list_val.find(function(item, i){
                  if(item.id === val){
                    index_dr = i;
                    return i;
                  }
                });
                dr_list_val.splice(index_dr,1);
                dr_amount_total = 0;
                dr_amount_table_data = "<style>table{font-family: arial, sans-serif;font-size: 12px; border-collapse: collapse;width: 100%;}td, th{border: 1px solid #dddddd;text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #dddddd;}</style><table><tr><th>No</th><th>Name</th><th>Amount</th><th>Actions</th></tr>";
                for (let index = 0; index < dr_list_val.length; index++) {
                  dr_amount_table_data = dr_amount_table_data + "<tr><td>"+ dr_list_val[index].id +"</td><td>"+ dr_list_val[index].name +"</td><td>"+ dr_list_val[index].amount +"</td><td><div class='font-sans-serif btn-reveal-trigger position-static'><button class='btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2' type='button' data-bs-toggle='dropdown' data-boundary='window' aria-haspopup='true' aria-expanded='false' data-bs-reference='parent'><svg class='svg-inline--fa fa-ellipsis fs--2' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='ellipsis' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' data-fa-i2svg=''><path fill='currentColor' d='M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z'></path></svg></button><div class='dropdown-menu dropdown-menu-end py-2'><a class='dropdown-item' data-bs-toggle='modal' role='button' href='#update_list_val' onclick='editfunction(0," + dr_list_val[index].id + ")'>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item text-danger'  data-bs-toggle='modal' role='button' href='#delete_list_val' onclick='deletefunction(0," + dr_list_val[index].id + ")'>Remove</a></div></div></td></tr>"
                  dr_amount_total = dr_amount_total + parseInt(dr_list_val[index].amount);
                }
                dr_amount_table_data = dr_amount_table_data + "</table>";
                $('#dr_amount_table').html(dr_amount_table_data);
                $('#collection_amount_input').val(dr_amount_total);
              } else if(list_num == 1) {
                var index_cr = -1;
                var val = id
                var filteredObj = cr_list_val.find(function(item, i){
                  if(item.id === val){
                    index_cr = i;
                    return i;
                  }
                });
                cr_list_val.splice(index_cr,1);
                console.log(cr_list_val);
                cr_amount_total = 0;
                cr_amount_table_data = "<style>table{font-family: arial, sans-serif;font-size: 12px; border-collapse: collapse;width: 100%;}td, th{border: 1px solid #dddddd;text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #dddddd;}</style><table><tr><th>No</th><th>Name</th><th>Amount</th><th>Actions</th></tr>";
                for (let index = 0; index < cr_list_val.length; index++) {
                  cr_amount_table_data = cr_amount_table_data + "<tr><td>"+ cr_list_val[index].id +"</td><td>"+ cr_list_val[index].name +"</td><td>"+ cr_list_val[index].amount +"</td><td><div class='font-sans-serif btn-reveal-trigger position-static'><button class='btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2' type='button' data-bs-toggle='dropdown' data-boundary='window' aria-haspopup='true' aria-expanded='false' data-bs-reference='parent'><svg class='svg-inline--fa fa-ellipsis fs--2' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='ellipsis' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' data-fa-i2svg=''><path fill='currentColor' d='M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z'></path></svg></button><div class='dropdown-menu dropdown-menu-end py-2'><a class='dropdown-item' data-bs-toggle='modal' role='button' href='#update_list_val' onclick='editfunction(1,"+ cr_list_val[index].id + ")'>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item text-danger'  data-bs-toggle='modal' role='button' href='#delete_list_val' onclick='deletefunction(1," + cr_list_val[index].id + ")'>Remove</a></div></div></td></tr>"
                  cr_amount_total = cr_amount_total + parseInt(cr_list_val[index].amount);
                }
                cr_amount_table_data = cr_amount_table_data + "</table>";
                $('#cr_amount_table').html(cr_amount_table_data);
              }
              if(dr_amount_total == cr_amount_total) {
                $("#create_collection_btn").prop("disabled", false);
              }
              else {
                $("#create_collection_btn").prop("disabled", true);
              }
            }
          </script>
          @include('layout.footer')
        </div>
      </div>
@endsection