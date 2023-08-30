@extends('layout.app')

@section('content')
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <h2 class="mb-4">Voucher Entry</h2>
          <div class="row">
            <div class="col-xl-12">
              <form class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 28px;border-radius: 10px;" method="post" action="{{ route('vouchers_entry_post') }}">
                @csrf
                <div class="col-sm-12 col-md-12">
                    <h4>Create Voucher Entry</h4>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="voucher_type_input" name="voucher_type_input">
                      <option selected="selected" value="Journal">Journal</option>
                      <option value="Advanced Payment">Advanced Payment</option>
                      <option value="Payment Voucher">Payment Voucher</option>
                      <option value="Receipt Voucher">Receipt Voucher</option>
                      <option value="Adjustment">Adjustment</option>
                    </select><label for="voucher_type_input">Voucher Type</label></div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating"><input class="form-control" id="voucher_no_input" name="voucher_no_input" type="text" placeholder="Voucher No" /><label for="voucher_no_input">Voucher No</label></div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="type_input" name="type_input">
                      <option selected="selected" value="Cash">Cash</option>
                      <option value="Cheque">Cheque</option>
                      <option value="Bank Draft">Bank Draft</option>
                    </select><label for="type_input">Collection Type</label></div>
                </div>
                <div class="col-sm-12 col-md-6" id="type_name_input_div" style="display: none;">
                  <div class="form-floating"><input class="form-control" id="type_name_input" name="type_name_input" type="text" placeholder="Bank Name" /><label for="type_name_input">Bank Name</label></div>
                </div>
                <div class="col-sm-12 col-md-6" id="type_cheque_input_div" style="display: none;">
                  <div class="form-floating"><input class="form-control" id="type_cheque_input" name="type_cheque_input" type="text" placeholder="Account / Cheque Number" /><label for="type_cheque_input">Account / Cheque Number</label></div>
                </div>
                <div class="col-sm-12 col-md-6" id="type_date_input_div" style="display: none;">
                  <div class="form-floating"><input class="form-control datetimepicker" id="type_date_input" name="type_date_input" type="text" placeholder="Cheque Issue Date" /><label for="type_date_input">Cheque Issue Date</label></div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="flatpickr-input-container">
                    <div class="form-floating"><input class="form-control datetimepicker" id="voucher_date_input" name="voucher_date_input" type="text" placeholder="Voucher date" data-options='{"disableMobile":true}' /><label class="ps-6" for="voucher_date_input">Voucher Date</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6" id="party_input_div">
                  <div class="form-floating">
                    <select class="form-select" id="party_input" name="party_input">
                      @foreach($parties as $party)
                      <option value="{{ $party->name }}">{{ $party->name }}</option>
                      @endforeach
                    </select>
                    <label for="party_input">Party</label>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6" id="receiver_input_div">
                  <div class="form-floating">
                    <select class="form-select" id="receiver_input" name="receiver_input">
                      <option selected="selected" value="Assets">Assets</option>
                      <option value="Libility">Libility</option>
                      <option value="Income">Income</option>
                    </select><label for="receiver_input">Receiver / Payer</label></div>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="form-floating"><textarea class="form-control" id="description_input" name="description_input" placeholder="Description" style="height: 50px"></textarea><label for="description_input">Description</label></div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="dr_head_name_input" name="dr_head_name_input">
                      @foreach($account_heads as $account_head)
                        <option value="{{ $account_head->ac_head_name_eng }}">{{ $account_head->ac_head_name_eng }}</option>
                      @endforeach
                    </select><label for="dr_head_name_input">Dr. Head Name</label></div>
                </div>
                <div class="col-sm-8 col-md-4">
                  <div class="form-floating"><input class="form-control" id="dr_amount_input" name="dr_amount_input" type="number" min="0" value="0.00" placeholder="Dr. Amount" /><label for="dr_amount_input">Dr. Amount</label></div>
                </div>
                <div class="col-sm-4 col-md-2">
                  <button class="btn btn-primary me-1 mb-1" id="add_dr_list" type="button" style="margin-top: 6px;">Add to Debits</button>
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
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="cr_head_name_input" name="cr_head_name_input">
                      @foreach($account_heads as $account_head)
                        <option value="{{ $account_head->ac_head_name_eng }}">{{ $account_head->ac_head_name_eng }}</option>
                      @endforeach
                    </select><label for="cr_head_name_input">Cr. Head Name</label></div>
                </div>
                <div class="col-sm-8 col-md-4">
                  <div class="form-floating"><input class="form-control" id="cr_amount_input" name="cr_amount_input" type="number" min="0" value="0.00" placeholder="Cr. Amount" /><label for="cr_amount_input">Cr. Amount</label></div>
                </div>
                <div class="col-sm-4 col-md-2">
                  <button class="btn btn-primary me-1 mb-1" type="button" id="add_cr_list" style="margin-top: 6px;">Add to Credits</button>
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
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating"><input class="form-control" id="collection_dr_amount_input" name="collection_dr_amount_input" type="text" placeholder="Total Dr." min="0" value="0.00" /><label for="collection_dr_amount_input">Total Dr.</label></div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating"><input class="form-control" id="collection_cr_amount_input" name="collection_cr_amount_input" type="text" placeholder="Total Cr." min="0" value="0.00" /><label for="collection_cr_amount_input">Total Cr.</label></div>
                </div>
                <div class="col-sm-12 col-md-6" id="total_vat_input_div">
                  <div class="form-floating"><input class="form-control" id="total_vat_input" name="total_vat_input" type="text" placeholder="Total VAT" min="0" value="0.00" /><label for="total_vat_input">Total VAT</label></div>
                </div>
                <div class="col-sm-12 col-md-6" id="total_tax_input_div">
                  <div class="form-floating"><input class="form-control" id="total_tax_input" name="total_tax_input" type="text" placeholder="Total Tax" min="0" value="0.00" /><label for="total_tax_input">Total TAX</label></div>
                </div>

                <div class="col-12 gy-6">
                  <div class="row g-3 justify-content-end">
                    <div class="col-auto"><button id="new_voucher_cancel" class="btn btn-phoenix-primary px-5">Cancel</button></div>
                    <div class="col-auto"><button type="submit" id="new_voucher_submit" class="btn btn-primary px-5 px-sm-15">Create New Voucher</button></div>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-xl-12">
                <div class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 5px;border-radius: 10px;">
                    <div class="col-sm-12 col-md-12">
                        <h4>Voucher Entry List</h4>
                    </div>
                    <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;head_id&quot;,&quot;group_name&quot;,&quot;accounts_name&quot;],&quot;page&quot;:10,&quot;pagination&quot;:true}">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm fs--1 mb-0">
                            <thead>
                                <tr align="center">
                                    <th class="sort border-top ps-3" style="display: none;" data-sort="id">ID</th>
                                    <th class="sort border-top ps-3" data-sort="voucher_no">VOUCHER NO</th>
                                    <th class="sort border-top" data-sort="voucher_type">VOUCHER TYPE</th>
                                    <th class="sort border-top" data-sort="voucher_date">VOUCHER DATE</th>
                                    <th class="sort border-top ps-3" data-sort="collection_type">COLLECTION TYPE</th>
                                    <th class="sort border-top ps-3" data-sort="amount">AMOUNT</th>
                                    <th class="sort text-end align-middle pe-0 border-top" scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="list">  
                              @foreach($voucher_entry as $vouchers)
                              <tr>
                                <td class="align-middle ps-3 id" style="display: none;">{{ $vouchers->id }}</td>
                                <td class="align-middle ps-3 voucher_no" style="text-align:center;">{{ $vouchers->voucher_no }}</td>
                                <td class="align-middle voucher_type" style="text-align:center;"><a href="{{ route('voucher_details_page', ['id' => $vouchers->id]) }}" style="color:tomato;" target="_blank" ><b>{{ $vouchers->voucher_type }}</b></a></td>
                                <td class="align-middle voucher_date" style="text-align:center;">{{ $vouchers->voucher_date }}</td>
                                <td class="align-middle ps-3 collection_type" style="text-align:center;">{{ $vouchers->type }}</td>
                                <td class="align-middle amount" style="text-align:center;">{{ $vouchers->total_dr_amount }}</td>
                                <td class="align-middle white-space-nowrap text-end pe-0">
                                  <div class="font-sans-serif btn-reveal-trigger position-static">
                                    <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                      <svg class="svg-inline--fa fa-ellipsis fs--2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z"></path>
                                      </svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                      <a class="dropdown-item" data-bs-toggle="modal"role="button" href="#edit_voucher_modal">Edit</a>
                                      <div class="dropdown-divider"></div>
                                      <a class="dropdown-item text-danger" onclick="delete_voucher_function('{{ $vouchers->id }}', '{{ $vouchers->voucher_no }}', '{{ $vouchers->description }}')">Remove</a>
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
          <div class="modal fade" id="update_list_val" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
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
          <div class="modal fade" id="delete_voucher_modal" aria-hidden="true" aria-labelledby="delete_voucher_modal_label" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-2" id="delete_voucher_modal_label">Delete This Voucher</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <span id="voucher_no_delete"></span>
                  <!-- <h1 class="modal-title fs-2" id="delete_voucher_modal_label">Are you sure?</h1> -->
                  <form class="row g-3" action="{{ route('vouchers_entry_delete') }}" method="POST" enctype="multipart/form-data" id="ModalForm">
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
            var dr_head_name_val = "";
            var dr_amount_val = "";
            var dr_list_val = [];
            var dr_list_index = 0;
            var dr_amount_table_data = "";
            var total_dr_amount = 0.00;
            var total_cr_amount = 0.00;
            $("#new_voucher_submit").prop("disabled", true);
            $("#add_dr_list").click(function(){
              total_dr_amount = 0;
              dr_list_index = dr_list_index + 1;
              dr_amount_val = $("#dr_amount_input").val();
              dr_head_name_val = $('#dr_head_name_input').val();
              dr_amount_table_ta = "";
              dr_list_val.push( {"id": dr_list_index, "name": dr_head_name_val, "amount": dr_amount_val} );
              console.log(dr_list_val);
              total_dr_amount = 0.00;
              dr_amount_table_data = "<style>table{font-family: arial, sans-serif;font-size: 12px; border-collapse: collapse;width: 100%;}td, th{border: 1px solid #dddddd;text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #dddddd;}</style><table><tr><th>No</th><th>Name</th><th>Amount</th><th>Actions</th></tr>";
              for (let index = 0; index < dr_list_val.length; index++) {
                dr_amount_table_data = dr_amount_table_data + "<tr><td>"+ dr_list_val[index].id +"</td><td>"+ dr_list_val[index].name +"</td><td>"+ dr_list_val[index].amount +"</td><td><div class='font-sans-serif btn-reveal-trigger position-static'><button class='btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2' type='button' data-bs-toggle='dropdown' data-boundary='window' aria-haspopup='true' aria-expanded='false' data-bs-reference='parent'><svg class='svg-inline--fa fa-ellipsis fs--2' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='ellipsis' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' data-fa-i2svg=''><path fill='currentColor' d='M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z'></path></svg></button><div class='dropdown-menu dropdown-menu-end py-2'><a class='dropdown-item' data-bs-toggle='modal' role='button' href='#update_list_val' onclick='editfunction(0," + dr_list_val[index].id + ")'>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item text-danger'  data-bs-toggle='modal' role='button' href='#delete_list_val' onclick='deletefunction(0," + dr_list_val[index].id + ")'>Remove</a></div></div></td></tr>"
                total_dr_amount = parseInt(total_dr_amount) + parseInt(dr_list_val[index].amount);
              }
              dr_amount_table_data = dr_amount_table_data + "</table>";
              $('#dr_amount_table').html(dr_amount_table_data);
              $('#dr_amount_table_ta').val(JSON.stringify(dr_list_val));
              $('#collection_dr_amount_input').val(total_dr_amount);
              $("#dr_amount_input").val(0);
              if(parseInt(total_dr_amount) === parseInt(total_cr_amount)) {
                console.log(parseInt(total_dr_amount), parseInt(total_cr_amount));
                $("#new_voucher_submit").prop("disabled", false);
              } else {
                console.log(parseInt(total_dr_amount), parseInt(total_cr_amount));
                $("#new_voucher_submit").prop("disabled", true);
              }
            });

            var cr_head_name_val = "";
            var cr_amount_val = "";
            var cr_list_val = [];
            var cr_list_index = 0;
            var cr_amount_table_data = "";
            $("#add_cr_list").click(function(){
              total_cr_amount = 0;
              cr_list_index = cr_list_index + 1;
              cr_amount_val = $("#cr_amount_input").val();
              cr_head_name_val = $('#cr_head_name_input').val();
              cr_list_val.push( {"id": cr_list_index, "name": cr_head_name_val, "amount": cr_amount_val} );
              console.log(cr_list_val);
              total_cr_amount = 0.00;
              cr_amount_table_data = "<style>table{font-family: arial, sans-serif;font-size: 12px; border-collapse: collapse;width: 100%;}td, th{border: 1px solid #dddddd;text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #dddddd;}</style><table><tr><th>No</th><th>Name</th><th>Amount</th><th>Actions</th></tr>";
              for (let index = 0; index < cr_list_val.length; index++) {
                cr_amount_table_data = cr_amount_table_data + "<tr><td>"+ cr_list_val[index].id +"</td><td>"+ cr_list_val[index].name +"</td><td>"+ cr_list_val[index].amount +"</td><td><div class='font-sans-serif btn-reveal-trigger position-static'><button class='btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2' type='button' data-bs-toggle='dropdown' data-boundary='window' aria-haspopup='true' aria-expanded='false' data-bs-reference='parent'><svg class='svg-inline--fa fa-ellipsis fs--2' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='ellipsis' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' data-fa-i2svg=''><path fill='currentColor' d='M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z'></path></svg></button><div class='dropdown-menu dropdown-menu-end py-2'><a class='dropdown-item' data-bs-toggle='modal' role='button' href='#update_list_val' onclick='editfunction(1,"+ cr_list_val[index].id + ")'>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item text-danger'  data-bs-toggle='modal' role='button' href='#delete_list_val' onclick='deletefunction(1," + cr_list_val[index].id + ")'>Remove</a></div></div></td></tr>"
                total_cr_amount = parseInt(total_cr_amount) + parseInt(cr_list_val[index].amount);
              }
              cr_amount_table_data = cr_amount_table_data + "</table>";
              $('#cr_amount_table').html(cr_amount_table_data);
              $('#cr_amount_table_ta').val(JSON.stringify(cr_list_val));
              $('#collection_cr_amount_input').val(total_cr_amount);
              $("#cr_amount_input").val(0);
              if(parseInt(total_dr_amount) === parseInt(total_cr_amount)) {
                console.log(parseInt(total_dr_amount), parseInt(total_cr_amount));
                $("#new_voucher_submit").prop("disabled", false);
              } else {
                console.log(parseInt(total_dr_amount), parseInt(total_cr_amount));
                $("#new_voucher_submit").prop("disabled", true);
              }
            });
            setTimeout(function() {
              // Decode the HTML encoded string
              var decodedData = decodeEntities("{{ $nextVoucherNo }}");

              // Parse the JSON
              var jsonData = JSON.parse(decodedData);
              if($("#voucher_type_input").val() == "Journal"){
                $("#voucher_no_input").val(getNextVoucherNo(jsonData, "Journal"));
              } else if($("#voucher_type_input").val() == "Advanced Payment"){
                $("#voucher_no_input").val(getNextVoucherNo(jsonData, "Advanced Payment"));
              } else if($("#voucher_type_input").val() == "Payment Voucher"){
                $("#voucher_no_input").val(getNextVoucherNo(jsonData, "Payment Voucher"));
              } else if($("#voucher_type_input").val() == "Receipt Voucher"){
                $("#voucher_no_input").val(getNextVoucherNo(jsonData, "Receipt Voucher"));
              } else if($("#voucher_type_input").val() == "Adjustment"){
                $("#voucher_no_input").val(getNextVoucherNo(jsonData, "Adjustment"));
              } else {
                console.log("Error in voucher_type_input");
              }
            }, 2000);

            $('#voucher_type_input').on('change', function() {
              // Decode the HTML encoded string
              var decodedData = decodeEntities("{{ $nextVoucherNo }}");

              // Parse the JSON
              var jsonData = JSON.parse(decodedData);
              // console.log(jsonData, $("#voucher_type_input").val());
              if($("#voucher_type_input").val() == "Journal"){
                // console.log(getNextVoucherNo(jsonData, "Journal"));
                $("#voucher_no_input").val(getNextVoucherNo(jsonData, "Journal"));
              } else if($("#voucher_type_input").val() == "Advanced Payment"){
                // console.log(getNextVoucherNo(jsonData, "Advanced Payment"));
                $("#voucher_no_input").val(getNextVoucherNo(jsonData, "Advanced Payment"));
              } else if($("#voucher_type_input").val() == "Payment Voucher"){
                // console.log(getNextVoucherNo(jsonData, "Payment Voucher"));
                $("#voucher_no_input").val(getNextVoucherNo(jsonData, "Payment Voucher"));
              } else if($("#voucher_type_input").val() == "Receipt Voucher"){
                // console.log(getNextVoucherNo(jsonData, "Receipt Voucher"));
                $("#voucher_no_input").val(getNextVoucherNo(jsonData, "Receipt Voucher"));
              } else if($("#voucher_type_input").val() == "Adjustment"){
                // console.log(getNextVoucherNo(jsonData, "Adjustment"));
                $("#voucher_no_input").val(getNextVoucherNo(jsonData, "Adjustment"));
              } else {
                console.log("Error in voucher_type_input");
              }
            });

            function delete_voucher_function(vouchers_id, voucher_no, description_delete) {
              console.log(vouchers_id);
              document.getElementById("id_delete").value = vouchers_id;
              document.getElementById("description_delete").value = description_delete;
              $("#voucher_no_delete").html("<h2 class='modal-title fs-1'>Are you sure you want to delete " + voucher_no + " ?</h2>");
              $('#delete_voucher_modal').modal('show');
            }

            function getNextVoucherNo(jsonData, voucherType) {
                var matchingItem = jsonData.find(function(item) {
                    return item.voucher_type === voucherType;
                });

                if (matchingItem) {
                    return matchingItem.next_voucher_no;
                }

                return 1;
            }

            function decodeEntities(encodedString) {
              var textArea = document.createElement('textarea');
              textArea.innerHTML = encodedString;
              return textArea.value;
            }

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
                total_dr_amount = 0;
                dr_list_val[list_id_val-1].name = list_name_val;
                dr_list_val[list_id_val-1].amount = list_amount_val;
                dr_amount_table_data = "<style>table{font-family: arial, sans-serif;font-size: 12px; border-collapse: collapse;width: 100%;}td, th{border: 1px solid #dddddd;text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #dddddd;}</style><table><tr><th>No</th><th>Name</th><th>Amount</th><th>Actions</th></tr>";
                for (let index = 0; index < dr_list_val.length; index++) {
                  dr_amount_table_data = dr_amount_table_data + "<tr><td>"+ dr_list_val[index].id +"</td><td>"+ dr_list_val[index].name +"</td><td>"+ dr_list_val[index].amount +"</td><td><div class='font-sans-serif btn-reveal-trigger position-static'><button class='btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2' type='button' data-bs-toggle='dropdown' data-boundary='window' aria-haspopup='true' aria-expanded='false' data-bs-reference='parent'><svg class='svg-inline--fa fa-ellipsis fs--2' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='ellipsis' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' data-fa-i2svg=''><path fill='currentColor' d='M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z'></path></svg></button><div class='dropdown-menu dropdown-menu-end py-2'><a class='dropdown-item' data-bs-toggle='modal' role='button' href='#update_list_val' onclick='editfunction(0," + dr_list_val[index].id + ")'>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item text-danger'  data-bs-toggle='modal' role='button' href='#delete_list_val' onclick='deletefunction(0," + dr_list_val[index].id + ")'>Remove</a></div></div></td></tr>"
                  total_dr_amount = parseInt(total_dr_amount) + parseInt(dr_list_val[index].amount);
                }
                dr_amount_table_data = dr_amount_table_data + "</table>";
                $('#dr_amount_table').html(dr_amount_table_data);
                $('#update_list_val').modal('toggle');
                $('#collection_dr_amount_input').val(total_dr_amount);
                $("#dr_amount_input").val(0);
              } else {
                total_cr_amount = 0;
                cr_list_val[list_id_val-1].name = list_name_val;
                cr_list_val[list_id_val-1].amount = list_amount_val;
                cr_amount_table_data = "<style>table{font-family: arial, sans-serif;font-size: 12px; border-collapse: collapse;width: 100%;}td, th{border: 1px solid #dddddd;text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #dddddd;}</style><table><tr><th>No</th><th>Name</th><th>Amount</th><th>Actions</th></tr>";
                for (let index = 0; index < cr_list_val.length; index++) {
                  cr_amount_table_data = cr_amount_table_data + "<tr><td>"+ cr_list_val[index].id +"</td><td>"+ cr_list_val[index].name +"</td><td>"+ cr_list_val[index].amount +"</td><td><div class='font-sans-serif btn-reveal-trigger position-static'><button class='btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2' type='button' data-bs-toggle='dropdown' data-boundary='window' aria-haspopup='true' aria-expanded='false' data-bs-reference='parent'><svg class='svg-inline--fa fa-ellipsis fs--2' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='ellipsis' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' data-fa-i2svg=''><path fill='currentColor' d='M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z'></path></svg></button><div class='dropdown-menu dropdown-menu-end py-2'><a class='dropdown-item' data-bs-toggle='modal' role='button' href='#update_list_val' onclick='editfunction(1,"+ cr_list_val[index].id + ")'>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item text-danger'  data-bs-toggle='modal' role='button' href='#delete_list_val' onclick='deletefunction(1," + cr_list_val[index].id + ")'>Remove</a></div></div></td></tr>"
                  total_cr_amount = parseInt(total_cr_amount) + parseInt(cr_list_val[index].amount);
                }
                cr_amount_table_data = cr_amount_table_data + "</table>";
                $('#cr_amount_table').html(cr_amount_table_data);
                $('#update_list_val').modal('toggle');
                $('#collection_cr_amount_input').val(total_cr_amount);
                $("#cr_amount_input").val(0);
              }
              if(parseInt(total_dr_amount) === parseInt(total_cr_amount)) {
                console.log(parseInt(total_dr_amount), parseInt(total_cr_amount));
                $("#new_voucher_submit").prop("disabled", false);
              } else {
                console.log(parseInt(total_dr_amount), parseInt(total_cr_amount));
                $("#new_voucher_submit").prop("disabled", true);
              }
            }

            function deletefunction(list_num, id) {
              console.log(list_num, id);
              if(list_num == 0) {
                total_dr_amount = 0;
                var index_dr = -1;
                var val = id
                var filteredObj = dr_list_val.find(function(item, i){
                  if(item.id === val){
                    index_dr = i;
                    return i;
                  }
                });
                dr_list_val.splice(index_dr,1);
                dr_amount_table_data = "<style>table{font-family: arial, sans-serif;font-size: 12px; border-collapse: collapse;width: 100%;}td, th{border: 1px solid #dddddd;text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #dddddd;}</style><table><tr><th>No</th><th>Name</th><th>Amount</th><th>Actions</th></tr>";
                for (let index = 0; index < dr_list_val.length; index++) {
                  dr_amount_table_data = dr_amount_table_data + "<tr><td>"+ dr_list_val[index].id +"</td><td>"+ dr_list_val[index].name +"</td><td>"+ dr_list_val[index].amount +"</td><td><div class='font-sans-serif btn-reveal-trigger position-static'><button class='btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2' type='button' data-bs-toggle='dropdown' data-boundary='window' aria-haspopup='true' aria-expanded='false' data-bs-reference='parent'><svg class='svg-inline--fa fa-ellipsis fs--2' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='ellipsis' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' data-fa-i2svg=''><path fill='currentColor' d='M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z'></path></svg></button><div class='dropdown-menu dropdown-menu-end py-2'><a class='dropdown-item' data-bs-toggle='modal' role='button' href='#update_list_val' onclick='editfunction(0," + dr_list_val[index].id + ")'>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item text-danger'  data-bs-toggle='modal' role='button' href='#delete_list_val' onclick='deletefunction(0," + dr_list_val[index].id + ")'>Remove</a></div></div></td></tr>"
                  total_dr_amount = parseInt(total_dr_amount) + parseInt(dr_list_val[index].amount);
                }
                dr_amount_table_data = dr_amount_table_data + "</table>";
                $('#dr_amount_table').html(dr_amount_table_data);
                $('#collection_dr_amount_input').val(total_dr_amount);
                $("#dr_amount_input").val(0);
              } else if(list_num == 1) {
                total_cr_amount = 0;
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
                cr_amount_table_data = "<style>table{font-family: arial, sans-serif;font-size: 12px; border-collapse: collapse;width: 100%;}td, th{border: 1px solid #dddddd;text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #dddddd;}</style><table><tr><th>No</th><th>Name</th><th>Amount</th><th>Actions</th></tr>";
                for (let index = 0; index < cr_list_val.length; index++) {
                  cr_amount_table_data = cr_amount_table_data + "<tr><td>"+ cr_list_val[index].id +"</td><td>"+ cr_list_val[index].name +"</td><td>"+ cr_list_val[index].amount +"</td><td><div class='font-sans-serif btn-reveal-trigger position-static'><button class='btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2' type='button' data-bs-toggle='dropdown' data-boundary='window' aria-haspopup='true' aria-expanded='false' data-bs-reference='parent'><svg class='svg-inline--fa fa-ellipsis fs--2' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='ellipsis' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' data-fa-i2svg=''><path fill='currentColor' d='M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z'></path></svg></button><div class='dropdown-menu dropdown-menu-end py-2'><a class='dropdown-item' data-bs-toggle='modal' role='button' href='#update_list_val' onclick='editfunction(1,"+ cr_list_val[index].id + ")'>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item text-danger'  data-bs-toggle='modal' role='button' href='#delete_list_val' onclick='deletefunction(1," + cr_list_val[index].id + ")'>Remove</a></div></div></td></tr>"
                    total_cr_amount = parseInt(total_cr_amount) + parseInt(cr_list_val[index].amount);
                  }
                cr_amount_table_data = cr_amount_table_data + "</table>";
                $('#cr_amount_table').html(cr_amount_table_data);
                $('#collection_cr_amount_input').val(total_cr_amount);
                $("#cr_amount_input").val(0);
              }
              if(parseInt(total_dr_amount) === parseInt(total_cr_amount)) {
                console.log(parseInt(total_dr_amount), parseInt(total_cr_amount));
                $("#new_voucher_submit").prop("disabled", false);
              } else {
                console.log(parseInt(total_dr_amount), parseInt(total_cr_amount));
                $("#new_voucher_submit").prop("disabled", true);
              }
            }
          </script>
          @include('layout.footer')
        </div>
      </div>
      <script>
        $("#bank_input_div" ).hide();
        $( "#voucher_type_input" ).on("change", function() {
          if($( "#voucher_type_input" ).val() === "Receipt Voucher") {
            $("#total_tax_input_div" ).hide();
            $("#total_tax_input").prop("disabled", true);
            $("#total_vat_input_div" ).hide();
            $("#total_vat_input").prop("disabled", true);
            $("#receiver_input_div").hide();
            $("#receiver_input").prop("disabled", true);
            $("#party_input_div").show();
            $("#party_input").prop("disabled", false);
          } else if($( "#voucher_type_input" ).val() === "Payment Voucher"){
            $("#party_input_div").hide();
            $("#party_input").prop("disabled", true);
            $("#total_tax_input_div" ).hide();
            $("#total_tax_input").prop("disabled", true);
            $("#total_vat_input_div" ).hide();
            $("#total_vat_input").prop("disabled", true);
          } else {
            $("#party_input_div").show();
            $("#party_input").prop("disabled", false);
            $("#total_tax_input_div" ).show();
            $("#total_tax_input").prop("disabled", false);
            $("#total_vat_input_div" ).show();
            $("#total_vat_input").prop("disabled", false);
            $("#receiver_input_div").show();
            $("#receiver_input").prop("disabled", false);
          }
        } );
        $("#type_input").on("change", function(){
          if($("#type_input").val() !== "Cash") {
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
        
      </script>
@endsection