@extends('layout.app')

@section('content')
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <h2 class="mb-4">Subsidiary Accounts</h2>
          <div class="row">
            <div class="col-xl-7">
              <form class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 28px;border-radius: 10px;" method="post" action="{{ route('subsidiary_ac_post') }}">
                @csrf
                <div class="col-sm-12 col-md-12">
                    <h4>Create New Subsidiary Accounts</h4>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="form-floating">
                    <select class="form-select" id="accounts_group_input" name="accounts_group_input">
                      <option selected="selected" disabled>Select</option>
                      <option value="Assets">Assets</option>
                      <option value="Expenses">Expenses</option>
                      <option value="Liabilities">Liabilities</option>
                      <option value="Income">Income</option>
                    </select><label for="accounts_group_input">Accounts Group</label></div>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="form-floating"><input class="form-control" id="subsidiary_ac_id_input" name="subsidiary_ac_id_input" type="text" placeholder="Subsidiary A/C ID" /><label for="subsidiary_ac_id_input">Subsidiary A/C ID</label></div>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="form-floating"><input class="form-control" id="subsidiary_ac_name_input" name="subsidiary_ac_name_input" type="text" placeholder="Subsidiary A/C Name" /><label for="subsidiary_ac_name_input">Subsidiary A/C Name</label></div>
                </div>

                <div class="col-12 gy-6">
                  <div class="row g-3 justify-content-end">
                    <div class="col-auto"><button class="btn btn-phoenix-primary px-5">Cancel</button></div>
                    <div class="col-auto"><button type="submit" class="btn btn-primary px-5 px-sm-15">Create Sub-Account</button></div>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-xl-5">
                <div class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 5px;border-radius: 10px;">
                    <div class="col-sm-12 col-md-12">
                        <h4>Subsidiary Accounts List</h4>
                    </div>
                    <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;head_id&quot;,&quot;group_name&quot;,&quot;accounts_name&quot;],&quot;page&quot;:5,&quot;pagination&quot;:true}">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort border-top ps-3" style="display: none;" data-sort="id">ID</th>
                                    <th class="sort border-top ps-3" data-sort="head_id">Head ID</th>
                                    <th class="sort border-top" data-sort="group_name">Group Name</th>
                                    <th class="sort border-top" data-sort="accounts_name">Accounts Name</th>
                                    <th class="sort text-end align-middle pe-0 border-top" scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach($subsidiary_ac as $subsidiaryAC)  
                                <tr>
                                    <td class="align-middle ps-3 id" style="display: none;">{{$subsidiaryAC->id}}</td>
                                    <td class="align-middle ps-3 head_id">{{$subsidiaryAC->account_id}}</td>
                                    <td class="align-middle group_name">{{$subsidiaryAC->accounts_group}}</td>
                                    <td class="align-middle accounts_name">{{$subsidiaryAC->account_name}}</td>
                                    <td class="align-middle white-space-nowrap text-end pe-0">
                                        <div class="font-sans-serif btn-reveal-trigger position-static">
                                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                <svg class="svg-inline--fa fa-ellipsis fs--2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z"></path>
                                                </svg><!-- <span class="fas fa-ellipsis-h fs--2"></span> Font Awesome fontawesome.com -->
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" data-bs-toggle="modal"role="button" href="#edit_subsidiary_account_modal" onclick="editfunction('{{$subsidiaryAC->id}}','{{$subsidiaryAC->accounts_group}}','{{$subsidiaryAC->account_id}}','{{$subsidiaryAC->account_name}}')">Edit</a>
                                            <div class="dropdown-divider"></div><a class="dropdown-item text-danger" data-bs-toggle="modal"role="button" href="#delete_subsidiary_account_modal" onclick="deletefunction('{{$subsidiaryAC->id}}','{{$subsidiaryAC->accounts_group}}','{{$subsidiaryAC->account_id}}','{{$subsidiaryAC->account_name}}')">Remove</a>
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
          <div class="modal fade" id="edit_subsidiary_account_modal" aria-hidden="true" aria-labelledby="edit_subsidiary_account_label" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-2" id="edit_subsidiary_account_label">Edit Subsidiary Account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 mb-6" action="{{ route('subsidiary_ac_update') }}" method="POST" enctype="multipart/form-data" id="ModalForm">
                        {{csrf_field()}}

                        <input type="hidden" id="id_update" name="id_update" value="">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-floating">
                            <select class="form-select" id="accounts_group_update" name="accounts_group_update">
                                <option selected="selected" value="Assets">Assets</option>
                                <option value="Libility">Libility</option>
                                <option value="Income">Income</option>
                            </select><label for="accounts_group_input">Accounts Group</label></div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-floating"><input class="form-control" id="subsidiary_ac_id_update" name="subsidiary_ac_id_update" type="text" placeholder="Subsidiary A/C ID" /><label for="subsidiary_ac_id_input">Subsidiary A/C ID</label></div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-floating"><input class="form-control" id="subsidiary_ac_name_update" name="subsidiary_ac_name_update" type="text" placeholder="Subsidiary A/C Name" /><label for="subsidiary_ac_name_input">Subsidiary A/C Name</label></div>
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
          <div class="modal fade" id="delete_subsidiary_account_modal" aria-hidden="true" aria-labelledby="delete_subsidiary_account_label" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-2" id="delete_subsidiary_account_label">Delete Subsidiary Account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h1 class="modal-title fs-2" id="delete_subsidiary_account_label">Are you sure?</h1>
                    <form class="row g-3 mb-6" action="{{ route('subsidiary_ac_delete') }}" method="POST" enctype="multipart/form-data" id="ModalForm">
                        {{csrf_field()}}

                        <input type="hidden" id="id_delete" name="id_delete" value="" readonly>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-floating">
                            <select class="form-select" id="accounts_group_delete" name="accounts_group_delete" disabled="true">
                                <option selected="selected" value="Assets">Assets</option>
                                <option value="Libility">Libility</option>
                                <option value="Income">Income</option>
                            </select><label for="accounts_group_delete">Accounts Group</label></div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-floating"><input class="form-control" id="subsidiary_ac_id_delete" name="subsidiary_ac_id_delete" type="text" placeholder="Subsidiary A/C ID" readonly /><label for="subsidiary_ac_id_delete">Subsidiary A/C ID</label></div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-floating"><input class="form-control" id="subsidiary_ac_name_delete" name="subsidiary_ac_name_delete" type="text" placeholder="Subsidiary A/C Name" readonly /><label for="subsidiary_ac_name_delete">Subsidiary A/C Name</label></div>
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
            function editfunction(id_update,accounts_group_update,subsidiary_ac_id_update,subsidiary_ac_name_update) {
                $('#id_update').val(id_update);
                $('#accounts_group_update option').filter(function(){
                    return this.value === accounts_group_update
                }).prop('selected', true);
                $('#subsidiary_ac_id_update').val(subsidiary_ac_id_update);
                $('#subsidiary_ac_name_update').val(subsidiary_ac_name_update);
            }

            function deletefunction(id_delete,accounts_group_delete,subsidiary_ac_id_delete,subsidiary_ac_name_delete) {
                $('#id_delete').val(id_delete);
                $('#accounts_group_delete option').filter(function(){
                    return this.value === accounts_group_delete
                }).prop('selected', true);
                $('#subsidiary_ac_id_delete').val(subsidiary_ac_id_delete);
                $('#subsidiary_ac_name_delete').val(subsidiary_ac_name_delete);
            }
          </script>

          <script>
            $(document).ready(function() {
                // Function to filter table data
                function filterTable() {
                    var selectedGroup = $('#accounts_group_input').val().toLowerCase();
                    var searchTextId = $('#subsidiary_ac_id_input').val().toLowerCase();
                    var searchTextName = $('#subsidiary_ac_name_input').val().toLowerCase();

                    $('.list tr').each(function() {
                        var group = $(this).find('.group_name').text().toLowerCase();
                        var accountId = $(this).find('.head_id').text().toLowerCase();
                        var accountName = $(this).find('.accounts_name').text().toLowerCase();
                        var row = $(this);

                        if ((selectedGroup === 'all' || group === selectedGroup) &&
                            (searchTextId === '' || accountId.includes(searchTextId)) &&
                            (searchTextName === '' || accountName.includes(searchTextName))) {
                            row.show();
                        } else {
                            row.hide();
                        }
                    });
                }

                // Event listeners for input changes
                $('#accounts_group_input, #subsidiary_ac_id_input, #subsidiary_ac_name_input').on('input', function() {
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