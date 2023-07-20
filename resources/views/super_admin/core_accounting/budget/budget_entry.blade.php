@extends('layout.app')

@section('content')
      <div class="container-fluid px-0" data-layout="container">
        @include('layout.navbar.navbar')
        <!-- 
          Content Starts Here
        -->
        <div class="content">
          <h2 class="mb-4">Yearly Budget Entry</h2>
          <div class="row">
            <div class="col-xl-12">
              <div class="row g-3 mb-6" style="border: 1px solid black;padding-bottom: 5px;border-radius: 10px; background: #ffffff;">
                <div class="col-sm-12 col-md-12">
                    <h4>Budget Entry Information</h4>
                    <div class="form-floating">
                      <select class="form-select" id="cr_head_name_input" name="cr_head_name_input">
                        <option selected="selected" value="Assets">2023 - 2024</option>
                        <option value="Libility">2022 - 2023</option>
                        <option value="Income">2021 - 2022</option>
                      </select><label for="cr_head_name_input">Select Financial Year</label>
                    </div>
                </div>
                <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;head_id&quot;,&quot;group_name&quot;,&quot;accounts_name&quot;],&quot;page&quot;:5,&quot;pagination&quot;:true}">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm fs--1 mb-0">
                        <thead>
                          <tr>
                            <th class="sort border-top ps-3" data-sort="id">Serial</th>
                            <th class="sort border-top ps-3" data-sort="head_id">Financial Head Name</th>
                            <th class="sort border-top" data-sort="group_name">Amount (BDT)</th>
                          </tr>
                        </thead>
                        <tbody class="list"> 
                          <tr>
                            <td class="align-middle ps-3 id"> 1 </td>
                            <td class="align-middle ps-3 head_id">00110011 - Land & Land Deplopment</td>
                            <td class="align-middle group_name"><div class="form-floating"><input class="form-control" id="cr_amount_input" name="cr_amount_input" type="number" min="0" value="0.00" placeholder="Land & Land Deplopment" /><label for="cr_amount_input">Land & Land Deplopment</label></div></td>
                          </tr>
                        </tbody>
                      </table>
                      <div class="col-12 gy-6" style="margin-top: 3px;">
                        <center>
                          <button class="btn btn-phoenix-primary px-5">Cancel</button>
                          <button type="submit" class="btn btn-primary px-5 px-sm-15">Save</button>
                        </center>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
          
          @include('layout.footer')
        </div>
      </div>
@endsection