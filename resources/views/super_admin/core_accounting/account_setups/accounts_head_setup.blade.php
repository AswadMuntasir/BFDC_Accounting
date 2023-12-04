@extends('layout.app')

@section('content')
<div class="container-fluid px-0" data-layout="container">
    @include('layout.navbar.navbar')
    <!-- 
          Content Starts Here
        -->
    <div class="content">
        <h2 class="mb-4">Accounts Head Setup</h2>
        <div class="row">
            <div class="col-xl-7">
                <form class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 28px;border-radius: 10px;" method="post" action="{{ route('account_head_post') }}">
                    @csrf
                    <div class="col-sm-12 col-md-12">
                        <h4>Create New Account Head</h4>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating">
                            <select class="form-select" id="accounts_group_input" name="accounts_group_input">
                            </select><label for="accounts_group_input">Accounts Group</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating">
                            <select class="form-select" id="sub_ac_name_input" name="sub_ac_name_input">
                            </select><label for="sub_ac_name_input">Sub A/C Name</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating">
                            <select class="form-select" id="control_ac_name_input" name="control_ac_name_input">
                            </select><label for="control_ac_name_input">Control A/C Name</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating"><input class="form-control" id="ac_head_id_input" name="ac_head_id_input" type="text" placeholder="A/C Head code" /><label for="ac_head_id_input">A/C Head ID</label></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating"><input class="form-control" id="ac_head_name_english_input" name="ac_head_name_english_input" type="text" placeholder="A/C head Name English" /><label for="ac_head_name_english_input">A/C head Name English</label></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating"><input class="form-control" id="ac_head_name_bengali_input" name="ac_head_name_bengali_input" type="text" placeholder="A/C head Name Bengali" /><label for="ac_head_name_bengali_input">A/C head Name Bengali</label></div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-floating"><input class="form-control" id="opening_balance_input" name="opening_balance_input" type="number" placeholder="Opening Balance" value="0" min="0" /><label for="opening_balance_input">Opening Balance</label></div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="dr_radio_input" type="radio" name="opening_balance_type_input" value="on" checked="">
                            <label class="form-check-label" for="dr_radio_input">Dr.</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="cr_radio_input" type="radio" name="opening_balance_type_input" value="off">
                            <label class="form-check-label" for="cr_radio_input">Cr.</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="flatpickr-input-container">
                            <div class="form-floating"><input class="form-control datetimepicker" id="date_of_initialization_input" name="date_of_initialization_input" type="text" placeholder="end date" data-options='{"disableMobile":true}' /><label class="ps-6" for="date_of_initialization_input">Date of Initialization</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="is_ugc_ac_head_true" type="radio" name="is_ugc_ac_head" value="active" />
                            <label class="form-check-label" for="is_ugc_ac_head_true">Active - Is UGC A/C Head?</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="is_ugc_ac_head_false" type="radio" name="is_ugc_ac_head" value="deactive" checked />
                            <label class="form-check-label" for="is_ugc_ac_head_false">Deactive - Is UGC A/C Head?</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="is_status_true" type="radio" name="is_status" value="active" checked />
                            <label class="form-check-label" for="is_status_true">Active - Status</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="is_status_false" type="radio" name="is_status" value="deactive" />
                            <label class="form-check-label" for="is_status_false">Deactive - Status</label>
                        </div>
                    </div>

                    <div class="col-12 gy-6">
                        <div class="row g-3 justify-content-end">
                            <div class="col-auto"><button class="btn btn-phoenix-primary px-5">Cancel</button></div>
                            <div class="col-auto"><button class="btn btn-primary px-5 px-sm-15" type="submit">Create Head</button></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-5">
                <div class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 5px;border-radius: 10px;">
                    <div class="col-sm-12 col-md-12">
                        <h4>Account Head List</h4>
                    </div>
                    <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;id&quot;,&quot;control_ac_id&quot;,&quot;head_id&quot;,&quot;accounts_head&quot;,&quot;budget_account&quot;,&quot;dr_balance&quot;,&quot;cr_balance&quot;],&quot;page&quot;:25,&quot;pagination&quot;:true}">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm fs--1 mb-0">
                                <thead>
                                    <tr>
                                        <th class="sort border-top ps-3" data-sort="id" style="display: none;">ID</th>
                                        <th class="sort border-top ps-3" data-sort="head_id">Head ID</th>
                                        <th class="sort border-top ps-3" data-sort="control_ac_id">Control AC</th>
                                        <th class="sort border-top" data-sort="accounts_head">Accounts<br>Head</th>
                                        <th class="sort border-top" data-sort="budget_account">Budget<br>Account</th>
                                        <th class="sort border-top" data-sort="dr_balance">Opening<br>Balance<br>(Dr.)</th>
                                        <th class="sort border-top" data-sort="cr_balance">Opening<br>Balance<br>(Cr.)</th>
                                        <th class="sort text-end align-middle pe-0 border-top" scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach($control_ac_join as $control_join)
                                    <tr>
                                        <td class="align-middle ps-3 id" style="display: none;">{{$control_join->id}}</td>
                                        <td class="align-middle ps-3 head_id">{{$control_join->ac_head_id}}</td>
                                        <td class="align-middle accounts_head">{{$control_join->ac_head_name_eng}}</td>
                                        <td class="align-middle budget_account">{{$control_join->opening_balance}}</td>
                                        @if($control_join->opening_balance_type =='on')
                                        <td class="align-middle dr_balance">{{$control_join->opening_balance}}</td>
                                        <td class="align-middle cr_balance">0.00</td>
                                        @else
                                        <td class="align-middle dr_balance">0.00</td>
                                        <td class="align-middle cr_balance">{{$control_join->opening_balance}}</td>
                                        @endif
                                        <td class="align-middle white-space-nowrap text-end pe-0">
                                            <div class="font-sans-serif btn-reveal-trigger position-static"><button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><svg class="svg-inline--fa fa-ellipsis fs--2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                        <path fill="currentColor" d="M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z"></path>
                                                    </svg></button>
                                                <div class="dropdown-menu dropdown-menu-end py-2">
                                                    <a class="dropdown-item" data-bs-toggle="modal" role="button" href="#edit_accounts_head_modal" onclick="editfunction('{{$control_join->id}}', '{{$control_join->ac_head_id}}', '{{$control_join->ac_head_name_eng}}', '{{$control_join->ac_head_name_ban}}', '{{$control_join->opening_balance}}', '{{$control_join->opening_balance}}', '{{$control_join->opening_balance_type}}')">Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger" data-bs-toggle="modal" role="button" href="#delete_accounts_head_modal" onclick="deletefunction('{{$control_join->id}}', '{{$control_join->ac_head_id}}', '{{$control_join->ac_head_name_eng}}', '{{$control_join->ac_head_name_ban}}', '{{$control_join->opening_balance}}', '{{$control_join->opening_balance}}', '{{$control_join->opening_balance_type}}')">Remove</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3"><button class="page-link disabled" data-list-pagination="prev" disabled=""><svg class="svg-inline--fa fa-chevron-left" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"></path>
                                </svg><!-- <span class="fas fa-chevron-left"></span> Font Awesome fontawesome.com --></button>
                            <ul class="mb-0 pagination">
                                <li class="active"><button class="page" type="button" data-i="1" data-page="5">1</button></li>
                                <li><button class="page" type="button" data-i="2" data-page="5">2</button></li>
                                <li><button class="page" type="button" data-i="3" data-page="5">3</button></li>
                            </ul><button class="page-link" data-list-pagination="next"><svg class="svg-inline--fa fa-chevron-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path>
                                </svg></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit_accounts_head_modal" aria-hidden="true" aria-labelledby="edit_accounts_head_label" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-2" id="edit_accounts_head_label">Edit Subsidiary Account</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3 mb-6" action="{{ route('account_head_update') }}" method="POST" enctype="multipart/form-data" id="ModalForm">
                            {{csrf_field()}}

                            <input type="hidden" id="id_update" name="id_update" value="">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="update_accounts_group_input" name="update_accounts_group_input">
                                    </select><label for="update_accounts_group_input">Accounts Group</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="update_sub_ac_name_input" name="update_sub_ac_name_input">
                                    </select><label for="update_sub_ac_name_input">Sub A/C Name</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="update_control_ac_name_input" name="update_control_ac_name_input">
                                    </select><label for="update_control_ac_name_input">Control A/C Name</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="update_ac_head_id_input" name="update_ac_head_id_input" type="text" placeholder="A/C Head code" /><label for="update_ac_head_id_input">A/C Head ID</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="update_ac_head_name_english_input" name="update_ac_head_name_english_input" type="text" placeholder="A/C head Name English" /><label for="update_ac_head_name_english_input">A/C head Name English</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="update_ac_head_name_bengali_input" name="update_ac_head_name_bengali_input" type="text" placeholder="A/C head Name Bengali" /><label for="update_ac_head_name_bengali_input">A/C head Name Bengali</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-floating">
                                    <input class="form-control" id="update_opening_balance_input" name="update_opening_balance_input" type="number" placeholder="Opening Balance" value="0" min="0" /><label for="update_opening_balance_input">Opening Balance</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="update_dr_radio_input" type="radio" name="update_opening_balance_type_input" value="on" checked="">
                                    <label class="form-check-label" for="update_dr_radio_input">Dr.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="update_cr_radio_input" type="radio" name="update_opening_balance_type_input" value="off">
                                    <label class="form-check-label" for="update_cr_radio_input">Cr.</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="flatpickr-input-container">
                                    <div class="form-floating"><input class="form-control datetimepicker" type="text" placeholder="end date" data-options='{"disableMobile":true}' id="update_date_of_initialization_input" name="update_date_of_initialization_input" /><label class="ps-6" for="update_date_of_initialization_input">Date of Initialization</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="update_is_ugc_ac_head_true" type="radio" name="update_is_ugc_ac_head" value="active" />
                                    <label class="form-check-label" for="update_is_ugc_ac_head_true">Active - Is UGC A/C Head?</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="update_is_ugc_ac_head_false" type="radio" name="update_is_ugc_ac_head" value="deactive" checked />
                                    <label class="form-check-label" for="update_is_ugc_ac_head_false">Deactive - Is UGC A/C Head?</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="update_is_status_true" type="radio" name="update_is_status" value="active" checked />
                                    <label class="form-check-label" for="update_is_status_true">Active - Status</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="update_is_status_false" type="radio" name="update_is_status" value="deactive" />
                                    <label class="form-check-label" for="update_is_status_false">Deactive - Status</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-secondary" data-dismiss="modal">Close</a>
                                <button type="submit" id="saveModalButton" class="btn btn-primary" data-dismiss="modal">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="delete_accounts_head_modal" aria-hidden="true" aria-labelledby="delete_accounts_head_label" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-2" id="delete_accounts_head_label">Delete Account Head</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4 style="margin-bottom: 20px;">Are you sure?</h4>
                        <form class="row g-3 mb-6" action="{{ route('account_head_delete') }}" method="POST" enctype="multipart/form-data" id="ModalForm">
                            {{csrf_field()}}

                            <input type="hidden" id="id_delete" name="id_delete" value="" readonly>

                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="update_accounts_group_input" name="update_accounts_group_input" type="text" placeholder="Accounts Group" readonly /><label for="update_accounts_group_input">Accounts Group</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="update_sub_ac_name_input" name="update_sub_ac_name_input" type="text" placeholder="Sub A/C Name" readonly /><label for="update_sub_ac_name_input">Sub A/C Name</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="update_control_ac_name_input" name="update_control_ac_name_input" type="text" placeholder="Control A/C Name" readonly /><label for="update_control_ac_name_input">Control A/C Name</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="update_ac_head_id_input" name="update_ac_head_id_input" type="text" placeholder="A/C Head code" readonly /><label for="update_ac_head_id_input">A/C Head ID</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="update_ac_head_name_english_input" name="update_ac_head_name_english_input" type="text" placeholder="A/C head Name English" readonly /><label for="update_ac_head_name_english_input">A/C head Name English</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="update_ac_head_name_bengali_input" name="update_ac_head_name_bengali_input" type="text" placeholder="A/C head Name Bengali" readonly /><label for="update_ac_head_name_bengali_input">A/C head Name Bengali</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-floating">
                                    <input class="form-control" id="update_opening_balance_input" name="update_opening_balance_input" type="number" placeholder="Opening Balance" value="0" min="0" readonly /><label for="update_opening_balance_input">Opening Balance</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="update_dr_radio_input" type="radio" name="update_opening_balance_type_input" value="on" checked="" disabled="true">
                                    <label class="form-check-label" for="update_dr_radio_input">Dr.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="update_cr_radio_input" type="radio" name="update_opening_balance_type_input" value="off" disabled="true">
                                    <label class="form-check-label" for="update_cr_radio_input">Cr.</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="flatpickr-input-container">
                                    <div class="form-floating"><input class="form-control" id="update_date_of_initialization_input" name="update_date_of_initialization_input" type="text" placeholder="end date" readonly /><label for="update_date_of_initialization_input">Date of Initialization</label></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="update_is_ugc_ac_head_true" type="radio" name="update_is_ugc_ac_head" value="active" disabled="true" />
                                    <label class="form-check-label" for="update_is_ugc_ac_head_true">Active - Is UGC A/C Head?</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="update_is_ugc_ac_head_false" type="radio" name="update_is_ugc_ac_head" value="deactive" checked disabled="true" />
                                    <label class="form-check-label" for="update_is_ugc_ac_head_false">Deactive - Is UGC A/C Head?</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="update_is_status_true" type="radio" name="update_is_status" value="active" checked disabled="true" />
                                    <label class="form-check-label" for="update_is_status_true">Active - Status</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="update_is_status_false" type="radio" name="update_is_status" value="deactive" disabled="true" />
                                    <label class="form-check-label" for="update_is_status_false">Deactive - Status</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-secondary" data-dismiss="modal">Close</a>
                                <button type="submit" id="deleteModalButton" class="btn btn-primary" data-dismiss="modal">Delete Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var control_acs = '{{$control_acs}}';
            var control_ac_joins = '{{$control_ac_join}}';
            var control_ac = JSON.parse(JSON.stringify(JSON.parse(control_acs.replace(/(&quot\;)/g, "\""))));
            var control_ac_join = JSON.parse(JSON.stringify(JSON.parse(control_ac_joins.replace(/(&quot\;)/g, "\""))));
            console.log(control_ac_join);
            let account_group_list = [];
            for (let index = 0; index < control_ac.length; index++) {
                account_group_list[index] = control_ac[index]['accounts_group'];
            }
            let account_group_list_unique = [...new Set(account_group_list)];

            var account_group_list_html = ""
            for (let index = 0; index < account_group_list_unique.length; index++) {
                account_group_list_html = account_group_list_html + '<option value="' + account_group_list_unique[index] + '">' + account_group_list_unique[index] + '</option>'
            }
            document.getElementById("accounts_group_input").innerHTML = account_group_list_html;
            document.getElementById("update_accounts_group_input").innerHTML = account_group_list_html;
            // document.getElementById("delete_accounts_group_input").innerHTML = account_group_list_html;

            let account_name_list = [];
            var account_name_list_html = ""
            for (let index = 0; index < control_ac.length; index++) {
                if (account_group_list_unique[0] === control_ac[index]['accounts_group']) {
                    account_name_list[index] = control_ac[index]['subsidiary_account_name'];
                    account_name_list_html = account_name_list_html + '<option value="' + account_name_list[index] + '">' + account_name_list[index] + '</option>';
                }
            }
            document.getElementById("sub_ac_name_input").innerHTML = account_name_list_html;

            let control_ac_name_list = [];
            var control_ac_name_list_html = "";
            var account_id_list = [];
            for (let index = 0; index < control_ac.length; index++) {
                if (account_group_list_unique[0] === control_ac[index]['accounts_group']) {
                    if (account_name_list[0] === control_ac[index]['subsidiary_account_name']) {
                        control_ac_name_list[index] = control_ac[index]['account_name'];
                        account_id_list[index] = control_ac[index]['account_id'];
                        control_ac_name_list_html = control_ac_name_list_html + '<option value="' + account_id_list[index] + '">' + control_ac_name_list[index] + '</option>';
                    }
                }
            }
            document.getElementById("control_ac_name_input").innerHTML = control_ac_name_list_html;

            $('#accounts_group_input').change(function() {
                account_name_list = [];
                account_name_list_html = "";
                control_ac_name_list = [];
                control_ac_name_list_html = "";
                for (let index = 0; index < control_ac.length; index++) {
                    if (this.value === control_ac[index]['accounts_group']) {
                        account_name_list[index] = control_ac[index]['subsidiary_account_name'];
                        account_name_list_html = account_name_list_html + '<option value="' + account_name_list[index] + '">' + account_name_list[index] + '</option>';
                        control_ac_name_list[index] = control_ac[index]['account_name'];
                        account_id_list[index] = control_ac[index]['account_id'];
                        control_ac_name_list_html = control_ac_name_list_html + '<option value="' + account_id_list[index] + '">' + control_ac_name_list[index] + '</option>';
                    }
                }
                document.getElementById("sub_ac_name_input").innerHTML = account_name_list_html;
                document.getElementById("control_ac_name_input").innerHTML = control_ac_name_list_html;
            });
            // $('#accounts_group_update').change(function(){
            //     account_name_list = [];
            //     account_name_list_html = ""
            //     for (let index = 0; index < control_ac.length; index++) {
            //         if(this.value === control_ac[index]['accounts_group']) {
            //             account_name_list[index] = control_ac[index]['account_name'];
            //             account_name_list_html = account_name_list_html + '<option value="' + account_name_list[index] + '">' + account_name_list[index] + '</option>';
            //         }
            //     }
            //     document.getElementById("sub_ac_name_update").innerHTML = account_name_list_html;
            // });

            $('#sub_ac_name_input').change(function() {
                var ac_group_input_cng = document.getElementById("accounts_group_input").value;
                account_name_list = [];
                account_name_list_html = ""
                for (let index = 0; index < control_ac.length; index++) {
                    if (ac_group_input_cng === control_ac[index]['accounts_group']) {
                        if (this.value === control_ac[index]['subsidiary_account_name']) {
                            account_name_list[index] = control_ac[index]['account_name'];
                            account_id_list[index] = control_ac[index]['account_id'];
                            account_name_list_html = account_name_list_html + '<option value="' + account_id_list[index] + '">' + account_name_list[index] + '</option>';
                        }
                    }
                }
                document.getElementById("control_ac_name_input").innerHTML = account_name_list_html;
            });
            // $('#update_accounts_group_input').change(function(){
            //     account_name_list = [];
            //     account_name_list_html = ""
            //     for (let index = 0; index < control_ac.length; index++) {
            //         if(this.value === control_ac[index]['accounts_group']) {
            //             account_name_list[index] = control_ac[index]['account_name'];
            //             account_name_list_html = account_name_list_html + '<option value="' + account_name_list[index] + '">' + account_name_list[index] + '</option>';
            //         }
            //     }
            //     document.getElementById("control_ac_name_update").innerHTML = account_name_list_html;
            // });

            function editfunction(id_update, update_accounts_group_input, update_sub_ac_name_input, update_control_ac_name_input, update_ac_head_id_input, update_ac_head_name_english_input, update_ac_head_name_bengali_input, update_opening_balance_input, update_opening_balance_type_input, update_date_of_initialization_input, update_is_ugc_ac_head, update_is_status) {
                $('#id_update').val(id_update);
                $('#update_accounts_group_input option').filter(function() {
                    return this.value === update_accounts_group_input
                }).prop('selected', true);
                $('#update_sub_ac_name_input option').filter(function() {
                    return this.value === update_sub_ac_name_input
                }).prop('selected', true);
                $('#update_control_ac_name_input option').filter(function() {
                    return this.value === update_control_ac_name_input
                }).prop('selected', true);
                $('#update_ac_head_id_input').val(update_ac_head_id_input);
                $('#update_ac_head_name_english_input').val(update_ac_head_name_english_input);
                $('#update_ac_head_name_bengali_input').val(update_ac_head_name_bengali_input);
                $('#update_opening_balance_input').val(update_opening_balance_input);
                if (update_opening_balance_type_input === 'on') {
                    document.getElementById("update_dr_radio_input").checked = true;
                    document.getElementById("update_cr_radio_input").checked = false;
                } else {
                    document.getElementById("update_dr_radio_input").checked = false;
                    document.getElementById("update_cr_radio_input").checked = true;
                }
                $('#update_date_of_initialization_input').val(update_date_of_initialization_input);
                if (update_is_ugc_ac_head === 'activate') {
                    document.getElementById("update_is_ugc_ac_head_true").checked = true;
                    document.getElementById("update_is_ugc_ac_head_flase").checked = false;
                } else {
                    document.getElementById("update_is_ugc_ac_head_true").checked = false;
                    document.getElementById("update_is_ugc_ac_head_false").checked = true;
                }
                if (update_is_status === 'activate') {
                    document.getElementById("update_is_status_true").checked = true;
                    document.getElementById("update_is_status_false").checked = false;
                } else {
                    document.getElementById("update_is_status_true").checked = false;
                    document.getElementById("update_is_status_false").checked = true;
                }

                // account_name_list = [];
                // account_name_list_html = ""
                // for (let index = 0; index < subsidiary_ac.length; index++) {
                //     // console.log(sub_ac_name_update + ' , ' + subsidiary_ac[index]['accounts_group'])
                //     if( accounts_group_update === subsidiary_ac[index]['accounts_group']) {
                //         account_name_list[index] = subsidiary_ac[index]['account_name'];
                //         account_name_list_html = account_name_list_html + '<option value="' + account_name_list[index] + '">' + account_name_list[index] + '</option>';
                //     }
                // }
                // document.getElementById("sub_ac_name_update").innerHTML = account_name_list_html;
                // $('#sub_ac_name_update option').filter(function(){
                //     return this.value === sub_ac_name_update
                // }).prop('selected', true);
            }

            // function deletefunction(id_delete,accounts_group_delete,sub_ac_name_delete,control_ac_code_delete, control_ac_name_delete, is_ugc_priority_delete, is_ugc_control_ac_delete) {
            //     $('#id_delete').val(id_delete);
            //     var account_group_html = '<option value="' + accounts_group_delete + '">' + accounts_group_delete + '</option>';
            //     var sub_ac_name_html = '<option value="' + sub_ac_name_delete + '">' + sub_ac_name_delete + '</option>';
            //     document.getElementById("accounts_group_delete").innerHTML = account_group_html;
            //     document.getElementById("sub_ac_name_delete").innerHTML = sub_ac_name_html;
            //     $('#control_ac_code_delete').val(control_ac_code_delete);
            //     $('#control_ac_name_delete').val(control_ac_name_delete);
            //     $('#is_ugc_priority_delete').val(is_ugc_priority_delete);
            //     if(is_ugc_control_ac_delete === 'active') {
            //         document.getElementById("is_ugc_control_ac_true_delete").checked = true;
            //         document.getElementById("is_ugc_control_ac_false_delete").checked = false;
            //     } else {
            //         document.getElementById("is_ugc_control_ac_true_delete").checked = false;
            //         document.getElementById("is_ugc_control_ac_false_delete").checked = true;
            //     }
            // }
        </script>

        <script>
            $(document).ready(function() {
                // Function to filter table data
                function filterTable() {
                    var searchTextACHeadID = $('#ac_head_id_input').val().toLowerCase();
                    var searchTextACHeadName = $('#ac_head_name_english_input').val().toLowerCase();

                    $('.list tr').each(function() {
                        var acHeadID = $(this).find('.head_id').text().toLowerCase();
                        var acHeadName = $(this).find('.accounts_head').text().toLowerCase();
                        var row = $(this);

                        if ((searchTextACHeadID === '' || acHeadID.includes(searchTextACHeadID)) &&
                            (searchTextACHeadName === '' || acHeadName.includes(searchTextACHeadName))) {
                            row.show();
                        } else {
                            row.hide();
                        }
                    });
                }

                // Event listeners for input changes
                $('#ac_head_id_input, #ac_head_name_english_input').on('input', function() {
                    filterTable();
                });

                // Initial filtering on page load
                filterTable();
            });
          </script>

        @include('layout.footer')
    </div>
</div>
@endsection