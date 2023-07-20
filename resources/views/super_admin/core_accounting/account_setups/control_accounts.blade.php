@extends('layout.app')

@section('content')
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <h2 class="mb-4">Control Accounts</h2>
          <div class="row">
            <div class="col-xl-7">
              <form class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 28px;border-radius: 10px;" method="post" action="{{ route('control_ac_post') }}">
                @csrf
                <div class="col-sm-12 col-md-12">
                    <h4>Create New Control Accounts</h4>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="accounts_group_input" name="accounts_group_input">
                    </select><label for="accounts_group_input">Accounts Group</label></div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="sub_ac_name_input" name="sub_ac_name_input">
                    </select><label for="sub_ac_name_input">Subsidiary A/C Name</label></div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating"><input class="form-control" id="control_ac_code_input" name="control_ac_code_input" type="text" placeholder="Contorl A/C code" /><label for="control_ac_code_input">Control A/C Code</label></div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-floating"><input class="form-control" id="control_ac_name_input" name="control_ac_name_input" type="text" placeholder="Control A/C name" /><label for="control_ac_name_input">Control A/C Name</label></div>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="form-floating"><input class="form-control" id="is_ugc_priority_input" name="is_ugc_priority_input" type="text" placeholder="Is UGC Priority" /><label for="is_ugc_priority_input">Is UGC Priority</label></div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <!-- <div class="form-check">
                        <input class="form-check-input" id="is_ugc_control_ac" name="is_ugc_control_ac" type="checkbox" value="active" required="">
                        <label class="form-check-label mb-0" for="invalidCheck">Is UGC Control A/C?</label>
                    </div> -->
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="is_ugc_control_ac_true" type="radio" name="is_ugc_control_ac" value="active" />
                        <label class="form-check-label" for="is_ugc_control_ac_true">Active - Is UGC Control A/C?</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="is_ugc_control_ac_false" type="radio" name="is_ugc_control_ac" value="deactive" checked />
                        <label class="form-check-label" for="is_ugc_control_ac_false">Deactive - Is UGC Control A/C?</label>
                    </div>
                </div>

                <div class="col-12 gy-2">
                  <div class="row g-3 justify-content-end">
                    <div class="col-auto"><button class="btn btn-phoenix-primary px-5">Cancel</button></div>
                    <div class="col-auto"><button class="btn btn-primary px-5 px-sm-15" type="submit">Create Control Head Account</button></div>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-xl-5">
                <form class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 5px;border-radius: 10px;" action="#">
                    <div class="col-sm-12 col-md-12">
                        <h4>Control Accounts List</h4>
                    </div>
                    <div data-list="{&quot;valueNames&quot;:[&quot;head_id&quot;,&quot;group_name&quot;,&quot;accounts_name&quot;],&quot;page&quot;:5,&quot;pagination&quot;:true}">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort border-top ps-3"  data-sort="id" style="display: none;">ID</th>
                                    <th class="sort border-top ps-3" data-sort="control_ac_id">Control A/C ID</th>
                                    <th class="sort border-top" data-sort="accounts_name">Accounts Name</th>
                                    <th class="sort border-top" data-sort="control_ac_name">Control A/C Name</th>
                                    <th class="sort text-end align-middle pe-0 border-top" scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach($control_acs as $control_ac)  
                                <tr>
                                    <td class="align-middle ps-3 id" style="display: none;">{{$control_ac->id}}</td>
                                    <td class="align-middle ps-3 control_ac_id">{{$control_ac->account_id}}</td>
                                    <td class="align-middle accounts_name">{{$control_ac->subsidiary_account_name}}</td>
                                    <td class="align-middle control_ac_name">{{$control_ac->account_name}}</td>
                                    <td class="align-middle white-space-nowrap text-end pe-0">
                                        <div class="font-sans-serif btn-reveal-trigger position-static">
                                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                <svg class="svg-inline--fa fa-ellipsis fs--2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z"></path>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" data-bs-toggle="modal"role="button" href="#edit_control_account_modal" onclick="editfunction('{{$control_ac->id}}','{{$control_ac->accounts_group}}','{{$control_ac->subsidiary_account_name}}','{{$control_ac->account_id}}','{{$control_ac->account_name}}','{{$control_ac->ugc_priority}}','{{$control_ac->is_ugc_control_ac}}')">Edit</a>
                                            <div class="dropdown-divider"></div><a class="dropdown-item text-danger"  data-bs-toggle="modal"role="button" href="#delete_control_account_modal" onclick="deletefunction('{{$control_ac->id}}','{{$control_ac->accounts_group}}','{{$control_ac->subsidiary_account_name}}','{{$control_ac->account_id}}','{{$control_ac->account_name}}','{{$control_ac->ugc_priority}}','{{$control_ac->is_ugc_control_ac}}')">Remove</a>
                                        </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach 
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3"><button class="page-link disabled" data-list-pagination="prev" disabled=""><svg class="svg-inline--fa fa-chevron-left" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"></path></svg><!-- <span class="fas fa-chevron-left"></span> Font Awesome fontawesome.com --></button>
                            <ul class="mb-0 pagination"><li class="active"><button class="page" type="button" data-i="1" data-page="5">1</button></li></ul><button class="page-link" data-list-pagination="next"><svg class="svg-inline--fa fa-chevron-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path></svg><!-- <span class="fas fa-chevron-right"></span> Font Awesome fontawesome.com --></button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
          <div class="modal fade" id="edit_control_account_modal" aria-hidden="true" aria-labelledby="edit_control_account_label" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-2" id="edit_control_account_label">Edit Control Account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 mb-6" action="{{ route('control_ac_update') }}" method="POST" enctype="multipart/form-data" id="ModalForm">
                        {{csrf_field()}}

                        <input type="hidden" id="id_update" name="id_update" value="">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="accounts_group_update" name="accounts_group_update">
                                </select><label for="accounts_group_update">Accounts Group</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="sub_ac_name_update" name="sub_ac_name_update">
                                </select><label for="sub_ac_name_update">Subsidiary A/C Name</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-floating">
                                <input class="form-control" id="control_ac_code_update" name="control_ac_code_update" type="text" placeholder="Contorl A/C code" /><label for="control_ac_code_update">Control A/C Code</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-floating">
                                <input class="form-control" id="control_ac_name_update" name="control_ac_name_update" type="text" placeholder="Control A/C name" /><label for="control_ac_name_update">Control A/C Name</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-floating">
                                <input class="form-control" id="is_ugc_priority_update" name="is_ugc_priority_update" type="text" placeholder="Is UGC Priority" /><label for="is_ugc_priority_update">Is UGC Priority</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="is_ugc_control_ac_true_update" type="radio" name="is_ugc_control_ac_update" value="active" />
                                <label class="form-check-label" for="is_ugc_control_ac_true_update">Active - Is UGC Control A/C?</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="is_ugc_control_ac_false_update" type="radio" name="is_ugc_control_ac_update" value="deactive" />
                                <label class="form-check-label" for="is_ugc_control_ac_false_update">Deactive - Is UGC Control A/C?</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a  class="btn btn-secondary" data-dismiss="modal">Close</a>
                            <button type="submit" id="saveModalButton" class="btn btn-primary" data-dismiss="modal">Save changes</button>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="delete_control_account_modal" aria-hidden="true" aria-labelledby="delete_control_account_label" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-2" id="delete_control_account_label">Delete Control Account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h1 class="modal-title fs-2" id="delete_control_account_label">Are you sure?</h1>
                    <form class="row g-3 mb-6" action="{{ route('control_ac_delete') }}" method="POST" enctype="multipart/form-data" id="ModalForm">
                        {{csrf_field()}}

                        <input type="hidden" id="id_delete" name="id_delete" value="" readonly>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="accounts_group_delete" name="accounts_group_delete" disabled="true">
                                </select><label for="accounts_group_delete">Accounts Group</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="sub_ac_name_delete" name="sub_ac_name_delete" disabled="true">
                                </select><label for="sub_ac_name_delete">Subsidiary A/C Name</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-floating">
                                <input class="form-control" id="control_ac_code_delete" name="control_ac_code_delete" type="text" placeholder="Contorl A/C code" readonly /><label for="control_ac_code_delete">Control A/C Code</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-floating">
                                <input class="form-control" id="control_ac_name_delete" name="control_ac_name_delete" type="text" placeholder="Control A/C name" readonly /><label for="control_ac_name_delete">Control A/C Name</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-floating">
                                <input class="form-control" id="is_ugc_priority_delete" name="is_ugc_priority_delete" type="text" placeholder="Is UGC Priority" readonly /><label for="is_ugc_priority_delete">Is UGC Priority</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="is_ugc_control_ac_true_delete" type="radio" name="is_ugc_control_ac_delete" value="active" disabled />
                                <label class="form-check-label" for="is_ugc_control_ac_true_delete">Active - Is UGC Control A/C?</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="is_ugc_control_ac_false_delete" type="radio" name="is_ugc_control_ac_delete" value="deactive" disabled />
                                <label class="form-check-label" for="is_ugc_control_ac_false_delete">Deactive - Is UGC Control A/C?</label>
                            </div>
                        </div>
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
            var subsidiary_acs = '{{$subsidiary_acs}}';
            var subsidiary_ac = JSON.parse(JSON.stringify(JSON.parse(subsidiary_acs.replace(/(&quot\;)/g,"\""))));
            let account_group_list = [];
            for (let index = 0; index < subsidiary_ac.length; index++) {
                account_group_list[index] = subsidiary_ac[index]['accounts_group'];
            }
            let account_group_list_unique = [...new Set(account_group_list)];
            
            var account_group_list_html = ""
            for (let index = 0; index < account_group_list_unique.length; index++) {
                account_group_list_html = account_group_list_html + '<option value="' + account_group_list_unique[index] + '">' + account_group_list_unique[index] + '</option>'
            }
            document.getElementById("accounts_group_input").innerHTML = account_group_list_html;
            document.getElementById("accounts_group_update").innerHTML = account_group_list_html;

            let account_name_list = [];
            var account_name_list_html = ""
            for (let index = 0; index < subsidiary_ac.length; index++) {
                if(account_group_list_unique[0] === subsidiary_ac[index]['accounts_group']) {
                    account_name_list[index] = subsidiary_ac[index]['account_name'];
                    account_name_list_html = account_name_list_html + '<option value="' + account_name_list[index] + '">' + account_name_list[index] + '</option>';
                }
            }
            document.getElementById("sub_ac_name_input").innerHTML = account_name_list_html;

            $('#accounts_group_input').change(function(){
                account_name_list = [];
                account_name_list_html = ""
                for (let index = 0; index < subsidiary_ac.length; index++) {
                    if(this.value === subsidiary_ac[index]['accounts_group']) {
                        account_name_list[index] = subsidiary_ac[index]['account_name'];
                        account_name_list_html = account_name_list_html + '<option value="' + account_name_list[index] + '">' + account_name_list[index] + '</option>';
                    }
                }
                document.getElementById("sub_ac_name_input").innerHTML = account_name_list_html;
            });
            $('#accounts_group_update').change(function(){
                account_name_list = [];
                account_name_list_html = ""
                for (let index = 0; index < subsidiary_ac.length; index++) {
                    if(this.value === subsidiary_ac[index]['accounts_group']) {
                        account_name_list[index] = subsidiary_ac[index]['account_name'];
                        account_name_list_html = account_name_list_html + '<option value="' + account_name_list[index] + '">' + account_name_list[index] + '</option>';
                    }
                }
                document.getElementById("sub_ac_name_update").innerHTML = account_name_list_html;
            });

            function editfunction(id_update,accounts_group_update,sub_ac_name_update,control_ac_code_update,control_ac_name_update,is_ugc_priority_update,is_ugc_control_ac_update) {
                $('#id_update').val(id_update);
                $('#accounts_group_update option').filter(function(){
                    return this.value === accounts_group_update
                }).prop('selected', true);
                $('#control_ac_code_update').val(control_ac_code_update);
                $('#control_ac_name_update').val(control_ac_name_update);
                $('#is_ugc_priority_update').val(is_ugc_priority_update);
                if(is_ugc_control_ac_update === 'active') {
                    document.getElementById("is_ugc_control_ac_true_update").checked = true;
                    document.getElementById("is_ugc_control_ac_false_update").checked = false;
                } else {
                    document.getElementById("is_ugc_control_ac_true_update").checked = false;
                    document.getElementById("is_ugc_control_ac_false_update").checked = true;
                }
                account_name_list = [];
                account_name_list_html = ""
                for (let index = 0; index < subsidiary_ac.length; index++) {
                    // console.log(sub_ac_name_update + ' , ' + subsidiary_ac[index]['accounts_group'])
                    if( accounts_group_update === subsidiary_ac[index]['accounts_group']) {
                        account_name_list[index] = subsidiary_ac[index]['account_name'];
                        account_name_list_html = account_name_list_html + '<option value="' + account_name_list[index] + '">' + account_name_list[index] + '</option>';
                    }
                }
                document.getElementById("sub_ac_name_update").innerHTML = account_name_list_html;
                $('#sub_ac_name_update option').filter(function(){
                    return this.value === sub_ac_name_update
                }).prop('selected', true);
            }

            function deletefunction(id_delete,accounts_group_delete,sub_ac_name_delete,control_ac_code_delete, control_ac_name_delete, is_ugc_priority_delete, is_ugc_control_ac_delete) {
                $('#id_delete').val(id_delete);
                var account_group_html = '<option value="' + accounts_group_delete + '">' + accounts_group_delete + '</option>';
                var sub_ac_name_html = '<option value="' + sub_ac_name_delete + '">' + sub_ac_name_delete + '</option>';
                document.getElementById("accounts_group_delete").innerHTML = account_group_html;
                document.getElementById("sub_ac_name_delete").innerHTML = sub_ac_name_html;
                $('#control_ac_code_delete').val(control_ac_code_delete);
                $('#control_ac_name_delete').val(control_ac_name_delete);
                $('#is_ugc_priority_delete').val(is_ugc_priority_delete);
                if(is_ugc_control_ac_delete === 'active') {
                    document.getElementById("is_ugc_control_ac_true_delete").checked = true;
                    document.getElementById("is_ugc_control_ac_false_delete").checked = false;
                } else {
                    document.getElementById("is_ugc_control_ac_true_delete").checked = false;
                    document.getElementById("is_ugc_control_ac_false_delete").checked = true;
                }
            }
          </script>
          
          @include('layout.footer')
        </div>
      </div>
@endsection