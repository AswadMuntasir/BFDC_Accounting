@extends('layout.app')

@section('content')
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <h2 class="mb-4">Link Head Setup</h2>
          <div class="row">
            <div class="col-xl-12">
              <form class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 28px;border-radius: 10px;" action="#">
                <div class="col-sm-12 col-md-12">
                    <h4>Fixed / Auto Accounts Head For Vouchers Entry</h4>
                </div>
                <div class="col-sm-2 col-md-2">
                  <h5 style="padding-top: 15px;">Link Account Head (Dr.)</h5>
                </div>
                <div class="col-sm-5 col-md-5">
                  <div class="form-floating">
                    <select class="form-select" id="accounts_group_input" name="accounts_group_input">
                      <option selected="selected" value="Assets">Assets</option>
                      <option value="Libility">Libility</option>
                      <option value="Income">Income</option>
                    </select><label for="accounts_group_input">Cash Collection</label></div>
                </div>
                <div class="col-sm-5 col-md-5">
                  <div class="form-floating">
                    <select class="form-select" id="sub_ac_name_input" name="sub_ac_name_input">
                      <option selected="selected" value="Current Assets">Current Assets</option>
                      <option value="Fixed Assets">Fixed Assets</option>
                      <option value="Other Investments">Other Investments</option>
                    </select><label for="sub_ac_name_input">Bank Deposit</label></div>
                </div>
                <div class="col-sm-2 col-md-2">
                  <h5 style="padding-top: 15px;">Link Account Head (cr.)</h5>
                </div>
                <div class="col-sm-5 col-md-5">
                  <div class="form-floating">
                    <select class="form-select" id="sub_ac_name_input" name="control_ac_name_input">
                      <option selected="selected" value="Current Assets">Current Assets</option>
                      <option value="Fixed Assets">Fixed Assets</option>
                      <option value="Other Investments">Other Investments</option>
                    </select><label for="sub_ac_name_input">Cash Collection</label></div>
                </div>
                <div class="col-sm-5 col-md-5">
                  <div class="form-floating">
                    <select class="form-select" id="sub_ac_name_input" name="control_ac_name_input">
                      <option selected="selected" value="Current Assets">Current Assets</option>
                      <option value="Fixed Assets">Fixed Assets</option>
                      <option value="Other Investments">Other Investments</option>
                    </select><label for="sub_ac_name_input">Bank Deposit</label></div>
                </div>
                <div class="col-sm-2 col-md-2">
                  <h5 style="padding-top: 15px;">Description</h5>
                </div>
                <div class="col-sm-5 col-md-5">
                  <div class="form-floating"><textarea class="form-control" id="floatingProjectOverview" placeholder="Description" style="height: 50px"></textarea><label for="floatingProjectOverview">Cash Collection Description</label></div>
                </div>
                <div class="col-sm-5 col-md-5">
                  <div class="form-floating"><textarea class="form-control" id="floatingProjectOverview" placeholder="Description" style="height: 50px"></textarea><label for="floatingProjectOverview">Bank Deposit Description</label></div>
                </div>

                <div class="col-12 gy-6">
                  <div class="row g-3 justify-content-end">
                    <center>
                      <button class="btn btn-primary px-5 px-sm-15">Save Account Setup</button>
                    </center>
                  </div>
                </div>
              </form>
            </div>

            <div class="col-xl-12">
              <form class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 28px;border-radius: 10px;" action="#">
                <div class="col-sm-12 col-md-12">
                  <h4>Head For Vouchers Entry</h4>
                </div>
                <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:10,&quot;pagination&quot;:true}">
                  <div class="table-responsive">
                    <table class="table table-striped table-sm fs--1 mb-0">
                      <thead>
                        <tr align="center">
                          <th class="sort border-top ps-3" data-sort="name"></th>
                          <th class="sort border-top ps-3" data-sort="asset">Asset</th>
                          <th class="sort border-top ps-3" data-sort="libility">Libility</th>
                          <th class="sort border-top ps-3" data-sort="revenue">Revenue</th>
                          <th class="sort border-top ps-3" data-sort="expenses">Expenses</th>
                          <th class="sort border-top ps-3" data-sort="equety">Equety</th>
                        </tr>
                      </thead>
                      <tbody class="list">
                        <tr>
                          <td class="align-middle ps-3 name">
                            <center>
                              Journal (Dr.)
                            </center>
                          </td>
                          <td class="align-middle ps-3 asset">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 name">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 email">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                        </tr>
                        <tr>
                          <td class="align-middle ps-3 name">
                            <center>
                              Journal (Cr.)
                            </center>
                          </td>
                          <td class="align-middle ps-3 asset">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 name">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 email">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                        </tr>
                        <tr>
                          <td class="align-middle ps-3 name">
                            <center>
                              Advanced (Dr.)
                            </center>
                          </td>
                          <td class="align-middle ps-3 asset">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 name">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 email">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                        </tr>
                        <tr>
                          <td class="align-middle ps-3 name">
                            <center>
                              Advanced (Cr.)
                            </center>
                          </td>
                          <td class="align-middle ps-3 asset">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 name">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 email">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                        </tr>
                        <tr>
                          <td class="align-middle ps-3 name">
                            <center>
                              Payment (Dr.)
                            </center>
                          </td>
                          <td class="align-middle ps-3 asset">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 name">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 email">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                        </tr>
                        <tr>
                          <td class="align-middle ps-3 name">
                            <center>
                              Payment (Cr.)
                            </center>
                          </td>
                          <td class="align-middle ps-3 asset">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 name">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 email">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                        </tr>
                        <tr>
                          <td class="align-middle ps-3 name">
                            <center>
                              Receipt (Dr.)
                            </center>
                          </td>
                          <td class="align-middle ps-3 asset">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 name">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 email">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                        </tr>
                        <tr>
                          <td class="align-middle ps-3 name">
                            <center>
                              Receipt (Cr.)
                            </center>
                          </td>
                          <td class="align-middle ps-3 asset">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 name">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 email">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                          <td class="align-middle ps-3 age">
                            <center>
                              <div class="form-check form-check-inline" style="padding-top: 7px;">
                                <input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">
                              </div>
                            </center>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-12 gy-6">
                    <div class="row g-3 justify-content-end">
                      <div class="col-12">
                        <br>
                        <center>
                          <button class="btn btn-primary px-5 px-sm-15">Save Settings</button>
                        </center>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>

          @include('layout.footer')
        </div>
      </div>
@endsection