<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\subsidiary_ac;
use App\Models\control_ac;
use App\Models\account_head;
use App\Models\office_chief;
use App\Models\party;
use App\Models\collection_entry;
use App\Models\voucher_entry;
use Illuminate\Support\Facades\DB;

class CoreAccountingController extends Controller
{
    // Accounting Setups

    /* Subsidiary Accounts CRUD START */
    public function subsidiaryAccountsView()
    {
        if(Auth::check()){
            $subsidiary_ac = subsidiary_ac::orderBy('created_at', 'desc')->get();

            return view('super_admin.core_accounting.account_setups.subsidiary_account', compact('subsidiary_ac'));
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function subsidiary_ac_post(Request $request)
    {
        // dd($request);
        $request->validate([  
            'accounts_group_input'=>'required',  
            'subsidiary_ac_id_input'=>'required',  
            'subsidiary_ac_name_input'=>'required'
        ]);  
        
        $subsidiary_ac = new subsidiary_ac;  
        $subsidiary_ac->accounts_group = $request->get('accounts_group_input');  
        $subsidiary_ac->account_id = $request->get('subsidiary_ac_id_input');  
        $subsidiary_ac->account_name = $request->get('subsidiary_ac_name_input');
        $subsidiary_ac->save();  

        return redirect('subsidiary-accounts');
    }

    public function subsidiary_ac_update(Request $request)
    {
        $request->validate([  
            'id_update'=>'required',
            'accounts_group_update'=>'required',  
            'subsidiary_ac_id_update'=>'required',  
            'subsidiary_ac_name_update'=>'required'
        ]);
        
        $subsidiary_ac = subsidiary_ac::find($request->get('id_update'));
        $subsidiary_ac->accounts_group = $request->get('accounts_group_update');  
        $subsidiary_ac->account_id = $request->get('subsidiary_ac_id_update');  
        $subsidiary_ac->account_name = $request->get('subsidiary_ac_name_update');
        $subsidiary_ac->save();  

        return redirect('subsidiary-accounts');
    }

    public function subsidiary_ac_delete(Request $request)
    {
        subsidiary_ac::where('id', $request->get('id_delete'))->delete();

        return redirect('subsidiary-accounts');
    }

    /* Subsidiary Accounts CRUD ENDS */
    
    /* Control Accounts CRUD */
    public function controlAccountsView()
    {
        if(Auth::check()){
            $subsidiary_ac = subsidiary_ac::select('accounts_group', 'account_name')->get();
            $control_ac = control_ac::orderBy('created_at', 'desc')->get();
            return view('super_admin.core_accounting.account_setups.control_accounts')->with('subsidiary_acs', $subsidiary_ac)->with('control_acs', $control_ac);
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function control_ac_post(Request $request)
    {
        // dd($request);
        $request->validate([  
            'sub_ac_name_input'=>'required',  
            'accounts_group_input'=>'required',  
            'is_ugc_control_ac'=>'required',
            'is_ugc_priority_input'=>'required',  
            'control_ac_name_input'=>'required',  
            'control_ac_code_input'=>'required'
        ]);  
        
        $control_ac = new control_ac;  
        $control_ac->accounts_group = $request->get('accounts_group_input');  
        $control_ac->subsidiary_account_name = $request->get('sub_ac_name_input');  
        $control_ac->account_id = $request->get('control_ac_code_input');
        $control_ac->account_name = $request->get('control_ac_name_input');  
        $control_ac->ugc_priority = $request->get('is_ugc_priority_input');  
        $control_ac->is_ugc_control_ac = $request->get('is_ugc_control_ac');
        $control_ac->save();  

        return redirect('control-accounts');
    }

    public function control_ac_update(Request $request)
    {
        $request->validate([  
            'sub_ac_name_update'=>'required',  
            'accounts_group_update'=>'required',  
            'is_ugc_control_ac_update'=>'required',
            'is_ugc_priority_update'=>'required',  
            'control_ac_name_update'=>'required',  
            'control_ac_code_update'=>'required'
        ]);
        
        $control_ac = control_ac::find($request->get('id_update'));
        $control_ac->accounts_group = $request->get('accounts_group_update');  
        $control_ac->subsidiary_account_name = $request->get('sub_ac_name_update');  
        $control_ac->account_id = $request->get('control_ac_code_update');
        $control_ac->account_name = $request->get('control_ac_name_update');  
        $control_ac->ugc_priority = $request->get('is_ugc_priority_update');  
        $control_ac->is_ugc_control_ac = $request->get('is_ugc_control_ac_update');
        $control_ac->save();  

        return redirect('control-accounts');
    }

    public function control_ac_delete(Request $request)
    {
        control_ac::where('id', $request->get('id_delete'))->delete();

        return redirect('control-accounts');
    }

    /* Control Accounts CRUD ENDS */

    /* Account Head CRUD */
    public function accountsHeadSetupView()
    {
        if(Auth::check()){
            $control_ac = control_ac::all();
            $account_head = account_head::orderBy('created_at', 'desc')->get();
            $control_ac_join = control_ac::select('ac_head.id', 'control_ac.accounts_group', 'control_ac.subsidiary_account_name', 'control_ac.account_name', 'ac_head.ac_head_id', 'ac_head.ac_head_name_eng', 'ac_head.ac_head_name_ben', 'ac_head.opening_balance', 'ac_head.opening_balance_type', 'ac_head.initialization_date', 'ac_head.is_ugc_ac_head', 'ac_head.is_status')
        	->join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
        	->get();
            return view('super_admin.core_accounting.account_setups.accounts_head_setup')->with('account_heads', $account_head)->with('control_acs', $control_ac)->with('control_ac_join', $control_ac_join);
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function account_head_post(Request $request)
    {
        // dd($request);
        $request->validate([
            "control_ac_name_input" => "required",
            "ac_head_id_input" => "required",
            "ac_head_name_english_input" => "required",
            "opening_balance_input" => "required",
            "opening_balance_type_input" => "required",
            "date_of_initialization_input" => "required",
            "is_ugc_ac_head" => "required",
            "is_status" => "required"
        ]);  
        
        $account_head = new account_head;  							
        $account_head->control_ac_id = $request->get('control_ac_name_input');  
        $account_head->ac_head_id = $request->get('ac_head_id_input');  
        $account_head->ac_head_name_eng = $request->get('ac_head_name_english_input');
        $account_head->ac_head_name_ben = $request->get('ac_head_name_bengali_input');  
        $account_head->opening_balance = $request->get('opening_balance_input');  
        $account_head->opening_balance_type = $request->get('opening_balance_type_input');
        $account_head->initialization_date = $request->get('date_of_initialization_input');  
        $account_head->is_ugc_ac_head = $request->get('is_ugc_ac_head');  
        $account_head->is_status = $request->get('is_status');
        $account_head->save();  

        return redirect('accounts-head-setup');
    }

    public function account_head_update(Request $request)
    {
        dd($request);
        $request->validate([  
            "control_ac_name_update" => "required",
            "ac_head_id_update" => "required",
            "ac_head_name_english_update" => "required",
            "opening_balance_update" => "required",
            "opening_balance_type_update" => "required",
            "date_of_initialization_update" => "required",
            "is_ugc_ac_head_update" => "required",
            "is_status_update" => "required"
        ]);
        
        $account_head = account_head::find($request->get('id_update'));
        $account_head->control_ac_id = $request->get('control_ac_name_input');  
        $account_head->ac_head_id = $request->get('ac_head_id_input');  
        $account_head->ac_head_name_eng = $request->get('ac_head_name_english_input');
        $account_head->ac_head_name_ben = $request->get('ac_head_name_bengali_input');  
        $account_head->opening_balance = $request->get('opening_balance_input');  
        $account_head->opening_balance_type = $request->get('opening_balance_type_input');
        $account_head->initialization_date = $request->get('date_of_initialization_input');  
        $account_head->is_ugc_ac_head = $request->get('is_ugc_ac_head');  
        $account_head->is_status = $request->get('is_status');
        $account_head->save();  

        return redirect('accounts-head-setup');
    }

    public function account_head_delete(Request $request)
    {
        control_ac::where('id', $request->get('id_delete'))->delete();

        return redirect('accounts-head-setup');
    }

    /* Account Head CRUD ENDS */

    /* Office Chief CRUD */
    public function officeChiefSetupView()
    {
        if(Auth::check()){
            $office_chief = office_chief::all();
            return view('super_admin.core_accounting.account_setups.office_chief_setup')->with('office_chiefs', $office_chief);
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function office_chief_post(Request $request)
    {
        // dd($request);
        $request->validate([
            "department_input" => "required",
            "office_chief_code_input" => "required"
        ]);  
        
        $office_chief = new office_chief;  							
        $office_chief->department = $request->get('department_input');  
        $office_chief->office_chief_code = $request->get('office_chief_code_input');
        $office_chief->save();  

        return redirect('office-chief-setup');
    }

    public function office_chief_update(Request $request)
    {
        $request->validate([  
            "control_ac_name_update" => "required",
            "ac_head_id_update" => "required"
        ]);
        
        $office_chief = office_chief::find($request->get('id_update'));
        $office_chief->department = $request->get('department_update');  
        $office_chief->office_chief_code = $request->get('office_chief_code_update'); 
        $office_chief->save();  

        return redirect('office-chief-setup');
    }

    public function office_chief_delete(Request $request)
    {
        office_chief::where('id', $request->get('id_delete'))->delete();

        return redirect('office-chief-setup');
    }

    /* Office Chief CRUD ENDS */

    public function linkHeadsSetupView()
    {
        if(Auth::check()){
            return view('super_admin.core_accounting.account_setups.link_heads_setup');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    /* Party CRUD */
    public function partySetupView()
    {
        if(Auth::check()){
            $party = party::all();
            return view('super_admin.core_accounting.account_setups.party_setup')->with('partys', $party);
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function party_post(Request $request)
    {
        // dd($request);
        $request->validate([
            "name_input" => "required",
            "party_type_input" => "required"
        ]);  
        
        $party = new party;  							
        $party->name = $request->get('name_input');  
        $party->email = $request->get('email_input');
        $party->contact_person = $request->get('contact_person_input');  
        $party->contact_number = $request->get('contact_number_input');
        $party->vat_number = $request->get('vat_number_input');  
        $party->party_type = $request->get('party_type_input');
        $party->address = $request->get('address_input');  
        $party->opening_balance_date = $request->get('opening_balance_date_input');
        $party->opening_balance_type = $request->get('opening_balance_type_input');  
        $party->opening_balance = $request->get('opening_balance_input');
        $party->description = $request->get('description_input');
        $party->save();  

        return redirect('party-setup');
    }

    public function party_update(Request $request)
    {
        $request->validate([  
            "name_input" => "required",
            "party_type_input" => "required"
        ]);
        
        $party = party::find($request->get('id_update'));
        $party->name = $request->get('name_input');  
        $party->email = $request->get('email_input');
        $party->contact_person = $request->get('contact_person_input');  
        $party->contact_number = $request->get('contact_number_input');
        $party->vat_number = $request->get('vat_number_input');  
        $party->party_type = $request->get('party_type_input');
        $party->address = $request->get('address_input');  
        $party->opening_balance_date = $request->get('opening_balance_date_input');
        $party->opening_balance_type = $request->get('opening_balance_type_input');  
        $party->opening_balance = $request->get('opening_balance_input');
        $party->description = $request->get('description_input');
        $party->save();  

        return redirect('party-setup');
    }

    public function party_delete(Request $request)
    {
        party::where('id', $request->get('id_delete'))->delete();

        return redirect('office-chief-setup');
    }

    /* Party CRUD ENDS */

    // Budget
    public function budgetEntryView()
    {
        if(Auth::check()){
            return view('super_admin.core_accounting.budget.budget_entry');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    // Collection
    public function collectionEntryView()
    {
        if(Auth::check()){
            $collection_entries = collection_entry::all();
            $account_heads = account_head::all();
            $parties = party::all();
            
            return view('super_admin.core_accounting.collections.collection_entry', [
                'collection_entries' => $collection_entries,
                'parties' => $parties,
                'account_heads' => $account_heads,
            ]);
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function collection_entry_post(Request $request)
    {
        $request->validate([
            "collection_date_input" => "required",
            "bill_section_input" => "required",
            "customer_name_input" => "required",
            "collection_type_input" => "required",
            "collection_amount_input" => "required"
        ]);
        
        $collection_entry = new collection_entry;
        $collection_entry->collection_date = $request->get('collection_date_input');
        $collection_entry->bill_section = $request->get('bill_section_input');  
        $collection_entry->customer_name = $request->get('customer_name_input');
        $collection_entry->collection_type = $request->get('collection_type_input');  
        $collection_entry->type_name = $request->get('type_name_input');
        $collection_entry->type_cheque = $request->get('type_cheque_input');
        $collection_entry->type_date = $request->get('type_date_input');
        $collection_entry->collection_amount = $request->get('collection_amount_input');
        $collection_entry->description = $request->get('description_input');  
        $collection_entry->dr_amount = $request->get('dr_amount_table_ta');
        $collection_entry->cr_amount = $request->get('cr_amount_table_ta');
        $collection_entry->save();  

        return redirect('collection-entry');
    }

    public function collection_entry_delete(Request $request) {
        collection_entry::where('id', $request->get('id_delete'))->delete();

        return redirect('collection-entry');
    }

    public function view_details_page($id) {
        // dd($id);
        if(Auth::check()){
            $collection_entry = collection_entry::findOrFail($id);
            // dd($collection_entry);
            return view('super_admin.core_accounting.collections.pdf_collection_entry')->with('collection_entry', $collection_entry);
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    // Vouchers
    public function vouchersEntryView()
    {
        if(Auth::check()){
            $voucher_entries = voucher_entry::where('status', '!=', 'Multiple')->orderByDesc('id')->get();
            $account_heads = account_head::all();
            $data = DB::table('voucher_entry')
                                ->select('voucher_type', DB::raw('MAX(voucher_no) as last_voucher_no'))
                                ->groupBy('voucher_type')
                                ->get();

            foreach ($data as $row) {
                $lastVoucherNo = $row->last_voucher_no;
                $prefix = substr($lastVoucherNo, 0, 1);
                $number = intval(substr($lastVoucherNo, 2)) + 1;

                $nextVoucherNo = $prefix . '_' . $number;
                $row->next_voucher_no = $number;
            };
            
            // $nextVoucherNo = $lastVoucherNo ? $lastVoucherNo + 1 : 1;
            $parties = party::all();
            return view('super_admin.core_accounting.vouchers.vouchers_entry', [
                'voucher_entry' => $voucher_entries,
                'parties' => $parties,
                'account_heads' => $account_heads,
                'nextVoucherNo' => $data,
            ]);
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function voucher_details_page($id) {
        // dd($id);
        if(Auth::check()){
            $voucher_entry = voucher_entry::findOrFail($id);
            // dd($collection_entry);
            return view('super_admin.core_accounting.vouchers.pdf_voucher_entry')->with('voucher_entry', $voucher_entry);
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function vouchers_entry_post(Request $request)
    {
        // dd($request);
        $request->validate([
            "voucher_type_input" => "required",
            "voucher_no_input" => "required",
            "type_input" => "required",
            "voucher_date_input" => "required",
            "dr_amount_table_ta" => "required",
            "cr_amount_table_ta" => "required",
        ]);

        $drAmountJson = $request->input('dr_amount_table_ta');
        $crAmountJson = $request->input('cr_amount_table_ta');

        $drAmountData = json_decode($drAmountJson, true);
        $crAmountData = json_decode($crAmountJson, true);

        // Transform data to final_data format
        $finalDataArray = [];

        if ($drAmountData && !empty($drAmountData)) {
            foreach ($drAmountData as $drItem) {
                $finalDataArray[] = [
                    'name' => $drItem['name'],
                    'amount' => $drItem['amount'],
                    'party_name' => $request->input('party_input'),
                    'type' => 'dr_amount',
                ];
            }
        }

        if ($crAmountData && !empty($crAmountData)) {
            foreach ($crAmountData as $crItem) {
                $finalDataArray[] = [
                    'name' => $crItem['name'],
                    'amount' => $crItem['amount'],
                    'party_name' => $request->input('party_input'),
                    'type' => 'cr_amount',
                ];
            }
        }

        $finalDataJson = json_encode($finalDataArray);

        // dd($finalDataJson);

        $voucher = new voucher_entry;
        $voucher->voucher_type = $request->get('voucher_type_input');
        if($request->get('voucher_type_input') == "Journal"){
            $voucher->voucher_no = "j_" . $request->get('voucher_no_input');
        } else if($request->get('voucher_type_input') == "Advanced Payment"){
            $voucher->voucher_no = "a_" . $request->get('voucher_no_input');
        } else if($request->get('voucher_type_input') == "Payment Voucher"){
            $voucher->voucher_no = "p_" . $request->get('voucher_no_input');
        } else if($request->get('voucher_type_input') == "Receipt Voucher"){
            $voucher->voucher_no = "r_" . $request->get('voucher_no_input');
        } else if($request->get('voucher_type_input') == "Adjustment"){
            $voucher->voucher_no = "a_" . $request->get('voucher_no_input');
        }
        $voucher->type = $request->get('type_input');
        $voucher->type_name = $request->get('type_name_input');
        $voucher->type_cheque = $request->get('type_cheque_input');
        $voucher->type_date = $request->get('type_date_input');
        $voucher->voucher_date = $request->get('voucher_date_input');
        $voucher->party = $request->get('party_input');
        $voucher->receiver = $request->get('receiver_input');
        $voucher->description = $request->get('description_input');
        $voucher->dr_amount = $request->get('dr_amount_table_ta');
        $voucher->cr_amount = $request->get('cr_amount_table_ta');
        $voucher->cr_dr = $finalDataJson;
        $voucher->total_dr_amount = $request->get('collection_dr_amount_input');
        $voucher->total_cr_amount = $request->get('collection_cr_amount_input');
        $voucher->vat = $request->get('total_vat_input');
        $voucher->tax = $request->get('total_tax_input');
        $voucher->status = "Pending";
        $voucher->save();

        return redirect('vouchers-entry');
    }

    public function vouchersSearchingView(Request $request)
    {
        if(Auth::check()){
            if ($request->isMethod('post')) {
                $finYear = $request->input('fin_year_input');
                $finMonth = $request->input('fin_month_input');
                $voucherType = $request->input('voucher_type_input');
                $pvAvNo = $request->input('pv_av_no_input');

                // Convert month name to month number
                // $monthNumber = date('m', strtotime($finMonth));

                $query = voucher_entry::query();

                // Apply filters
                $query->where('voucher_date', 'LIKE', "%$finYear-$finMonth%")
                    ->where('voucher_type', $voucherType);

                if ($pvAvNo) {
                    $query->where('voucher_no', 'LIKE', "%$pvAvNo%");
                }

                $voucherList = $query->get();

                // dd($voucherList);

                return view('super_admin.core_accounting.vouchers.vouchers_searching', compact('voucherList'));
            } else {
                return view('super_admin.core_accounting.vouchers.vouchers_searching', ['voucherList' => null]);
            }
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function vouchers_entry_delete(Request $request)
    {
        $voucher_data = voucher_entry::where('id', $request->get('id_delete'))->get();

        preg_match_all('/\bmemo-([a-zA-Z0-9._-]+)\b/', $voucher_data[0]["description"], $matches);
        $numbers = $matches[1];

        $output = $numbers;
        $size = count($output);

        // dd($output);
        $voucher_type = $voucher_data[0]["voucher_type"];

        if($size > 0) {
            if($voucher_type == "Receipt Voucher") {
                collection_entry::whereIn('id', $output)->update(['status' => 'visible']);
            } else if($voucher_type == "Journal") {
                voucher_entry::whereIn('voucher_no', $output)->update(['status' => 'Pending']);
            }
        }
        voucher_entry::where('id', $request->get('id_delete'))->delete();
        
        return redirect('vouchers-entry');
    }

    public function cashCollectionVoucherView()
    {
        if(Auth::check()){
            $collection_entry = collection_entry::where('status', 'visible')->get();
            return view('super_admin.core_accounting.vouchers.cash_collection_voucher')->with('collection_entry', $collection_entry);
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function cash_voucher_update(Request $request)
    {
        $checkboxes = $request->input('checkboxes');
        $data = collection_entry::whereIn('id', $checkboxes)->get();


        $oldDataArray = json_decode($data, true);

        // Transform old_data to final_data format
        $finalDataArray = [];
        foreach ($oldDataArray as $item) {
            $drAmountData = json_decode($item['dr_amount'], true);
            $crAmountData = json_decode($item['cr_amount'], true);

            if ($drAmountData && !empty($drAmountData)) {
                foreach ($drAmountData as $drItem) {
                    $finalDataArray[] = [
                        // 'id' => $drItem['id'],
                        'name' => $drItem['name'],
                        'amount' => $drItem['amount'],
                        'party_name' => $item['customer_name'],
                        'type' => 'dr_amount',
                    ];
                }
            }

            if ($crAmountData && !empty($crAmountData)) {
                foreach ($crAmountData as $crItem) {
                    $finalDataArray[] = [
                        // 'id' => $crItem['id'],
                        'name' => $crItem['name'],
                        'amount' => $crItem['amount'],
                        'party_name' => $item['customer_name'],
                        'type' => 'cr_amount',
                    ];
                }
            }
        }

        $finalDataJson = json_encode($finalDataArray); //cr_dr output

        $updatedDrAmount = []; // Initialize as empty array
        $updatedCrAmount = []; // Initialize as empty array

        // $lastVoucherNo = voucher_entry::max('voucher_no');
        // $nextVoucherNo = $lastVoucherNo ? $lastVoucherNo + 1 : 1;
        $data2 = DB::table('voucher_entry')
            ->select(DB::raw('MAX(voucher_no) as last_voucher_no'))
            ->where('voucher_type', 'Receipt Voucher') // Add this line to filter by voucher type
            ->groupBy('voucher_type')
            ->get();

        $number = 0;

        foreach ($data2 as $row) {
            if($row->last_voucher_no) {
                $lastVoucherNo = $row->last_voucher_no;
            }
            else {
                $lastVoucherNo = "r_0";
            }
            $prefix = substr($lastVoucherNo, 0, 1);
            $number = intval(substr($lastVoucherNo, 2)) + 1;

            $nextVoucherNo1 = $prefix . '_' . $number;
            $row->next_voucher_no = $number;

            $nextVoucherNo = $number;
        }

        $dr_arr = [];
        $cr_arr = [];
        $v_date = "";

        // Step 1: Parse the JSON data
        $data2 = json_decode($data, true);

        // return response()->json(['data' => $data2[0]]);
        // Step 2: Transform the data
        $result2 = [];
        foreach ($data2 as $item) {
            // Decode the dr_amount and cr_amount JSON strings
            $drAmounts = json_decode($item['dr_amount'], true);
            $crAmounts = json_decode($item['cr_amount'], true);

            // Append the decoded amounts to the result array
            $result2 = array_merge($result2, $drAmounts, $crAmounts);
            // return response()->json(['data' => $data2]);
        }

        // return response()->json(['data' => $result2, 'data2' => $data2]);

        // Step 3: Group the amounts by name and calculate the dr_amount and cr_amount
        $groupedData = [];
        foreach ($result2 as $item) {
            $name = $item['name'];

            if (!isset($groupedData[$name])) {
                $groupedData[$name] = [
                    'name' => $name,
                    'dr_amount' => 0,
                    'cr_amount' => 0,
                ];
            }

            $groupedData[$name]['dr_amount'] += isset($item['amount']) ? $item['amount'] : 0;
            $groupedData[$name]['cr_amount'] += isset($item['cr_amount']) ? $item['cr_amount'] : 0;
        }
        $output = [
            'data' => [
                [
                    'dr_amount' => json_encode(array_values($groupedData)),
                ],
            ],
        ];

        $totalDrAmount = 0;
        $totalCrAmount = 0;

        if ($data->count() > 1) {
            // Multiple data selected
            $updatedDrAmount = [];
            $updatedCrAmount = [];
            $totalDrAmount = 0;
            $totalCrAmount = 0;

            foreach ($data as &$item) {
                $item['cr_amount'] = json_decode($item['cr_amount'], true);
                $item['dr_amount'] = json_decode($item['dr_amount'], true);

                $v_date = $item['collection_date'];
                array_push($dr_arr, $item['dr_amount']);
                array_push($cr_arr, $item['cr_amount']);
            }

            // Flattening the data
            $newDRData = [];
            foreach ($dr_arr as $innerArray) {
                foreach ($innerArray as $item) {
                    $newDRData[] = $item;
                }
            }
            $newCRData = [];
            foreach ($cr_arr as $innerArray) {
                foreach ($innerArray as $item) {
                    $newCRData[] = $item;
                }
            }

            $newdrId = 1;
            foreach ($newDRData as $item) {
                $item["id"] = $newdrId++;
                $newDR[] = $item;
            }
            $newcrId = 1;
            foreach ($newCRData as $item) {
                $item["id"] = $newcrId++;
                $newCR[] = $item;
            }

            foreach ($dr_arr as $subArray) {
                foreach ($subArray as $item) {
                    $totalDrAmount += (int)$item["amount"];
                }
            }
    
            foreach ($cr_arr as $subArray) {
                foreach ($subArray as $item) {
                    $totalCrAmount += (int)$item["amount"];
                }
            }

            // dd($totalDrAmount, $totalCrAmount);
            // return response()->json(['data' => $totalDrAmount, 'data2' => $totalCrAmount]);

            $description = 'Multiple vouchers added: ' . implode(', ', $data->pluck('id')->map(function($id) {
                return 'memo-' . $id;
            })->toArray());
            // $totalDrAmount = array_sum(array_column($updatedDrAmount, 'collection_amount'));
            // $totalCrAmount = array_sum(array_column($updatedCrAmount, 'collection_amount'));

            $newEntry = [
                'collection_date' => $data[0]['collection_date'],
                'collection_type' => 'Cash',
                'collection_amount' => $totalDrAmount,
                'description' => $description,
                'dr_amount' => json_encode($newDR),
                'cr_amount' => json_encode($newCR),
                'cr_dr' => $finalDataJson
            ];

            // return response()->json(['data' => $newEntry]);

            $voucher = new voucher_entry;
            $voucher->voucher_type = "Receipt Voucher";
            $voucher->voucher_no = "r_" . $nextVoucherNo;
            $voucher->type = "Cash";
            $voucher->type_name = "N/A";
            $voucher->type_cheque = "N/A";
            $voucher->type_date = "N/A";
            $voucher->voucher_date = $v_date;
            $voucher->party = "N/A";
            $voucher->receiver = "N/A";
            $voucher->description = $description;
            $voucher->dr_amount = json_encode($newDR);
            $voucher->cr_amount = json_encode($newCR);
            $voucher->cr_dr = $finalDataJson;
            $voucher->total_dr_amount = $totalDrAmount;
            $voucher->total_cr_amount = $totalCrAmount;
            $voucher->vat = 0;
            $voucher->tax = 0;
            $voucher->status = "Done";
            $voucher->save();

            collection_entry::whereIn('id', $checkboxes)->update(['status' => 'done']);

            return response()->json(['data' => $newEntry]);
        } elseif ($data->count() === 1) {
            // Single data selected
            $item = $data->first();
            $item['cr_amount'] = json_decode($item['cr_amount'], true);
            $item['dr_amount'] = json_decode($item['dr_amount'], true);

            $description = 'Voucher ID: memo-' . $item['id'];
            // dd($item['dr_amount']);
            // return response()->json(['data' => $item['dr_amount']]);

            foreach ($item['dr_amount'] as $items) {
                $totalDrAmount += (int)$items['amount'];
            }

            foreach ($item['cr_amount'] as $items) {
                $totalCrAmount += (int)$items['amount'];
            }

            // return response()->json(['data' => $totalDrAmount]);
            // $totalDrAmount = array_sum(array_column($item['dr_amount'], 'collection_amount'));
            // $totalCrAmount = array_sum(array_column($item['cr_amount'], 'collection_amount'));

            // return response()->json(['data' => json_encode($item['dr_amount'])]);

            $voucher = new voucher_entry;
            $voucher->voucher_type = "Receipt Voucher";
            $voucher->voucher_no = "r_" . $nextVoucherNo;
            $voucher->type = "Cash";
            $voucher->type_name = "N/A";
            $voucher->type_cheque = "N/A";
            $voucher->type_date = "N/A";
            $voucher->voucher_date = $item['collection_date'];
            $voucher->party = "N/A";
            $voucher->receiver = "N/A";
            $voucher->description = $description;
            $voucher->dr_amount = json_encode($item['dr_amount']); // Convert to JSON string
            $voucher->cr_amount = json_encode($item['cr_amount']); // Convert to JSON string
            $voucher->cr_dr = $finalDataJson;
            $voucher->total_dr_amount = $totalDrAmount;
            $voucher->total_cr_amount = $totalCrAmount;
            $voucher->vat = 0;
            $voucher->tax = 0;
            $voucher->status = "Done";
            $voucher->save();

            collection_entry::whereIn('id', $checkboxes)->update(['status' => 'done']);

            return response()->json(['data' => $item]);
        } else {
            // No data selected
            return response()->json(['error' => 'No data selected']);
        }
    }

    public function journalVoucherView()
    {
        if(Auth::check()){
            $status = 'Multiple';
            $voucher_entry = voucher_entry::where('voucher_type', 'Journal')
                                ->where('status', $status)
                                ->get();
            return view('super_admin.core_accounting.vouchers.journal_voucher')->with("voucher_entry", $voucher_entry)->with("status", $status);
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function journalVoucherFilter(Request $request)
    {
        // dd($request);
        $status = 'Pending';
        $startDate = $request->input('journal_date_from_input');
        $endDate = $request->input('journal_date_to_input');

        $voucher_entry = voucher_entry::where('status', $status)
            ->whereDate('voucher_date', '>=', $startDate)
            ->whereDate('voucher_date', '<=', $endDate)
            ->where('voucher_type', 'Journal')
            ->get();

        return view('super_admin.core_accounting.vouchers.journal_voucher', compact('voucher_entry', 'status', 'startDate', 'endDate'));
    }

    public function journal_voucher_merge(Request $request)
    {
        $checkboxes = $request->selector;
        $data = voucher_entry::whereIn('id', $checkboxes)->get();

        $oldDataArray = json_decode($data, true);

        // Transform old_data to final_data format
        $finalDataArray = [];
        foreach ($oldDataArray as $item) {
            $drAmountData = json_decode($item['dr_amount'], true);
            $crAmountData = json_decode($item['cr_amount'], true);

            if ($drAmountData && !empty($drAmountData)) {
                foreach ($drAmountData as $drItem) {
                    $finalDataArray[] = [
                        // 'id' => $drItem['id'],
                        'name' => $drItem['name'],
                        'amount' => $drItem['amount'],
                        'party_name' => $item['party'],
                        'type' => 'dr_amount',
                    ];
                }
            }

            if ($crAmountData && !empty($crAmountData)) {
                foreach ($crAmountData as $crItem) {
                    $finalDataArray[] = [
                        // 'id' => $crItem['id'],
                        'name' => $crItem['name'],
                        'amount' => $crItem['amount'],
                        'party_name' => $item['party'],
                        'type' => 'cr_amount',
                    ];
                }
            }
        }

        $finalDataJson = json_encode($finalDataArray); //cr_dr output

        // Find the position of the underscore character
        $underscorePosition = strpos($data[0]->voucher_no, "_");

        // Extract the substring starting from the underscore position + 1
        $desiredValue = substr($data[0]->voucher_no, $underscorePosition + 1);

        $updatedDrAmount = []; // Initialize as empty array
        $updatedCrAmount = []; // Initialize as empty array

        // dd($data);

        $dr_arr = [];
        $cr_arr = [];
        $v_date = "";
        $totalDrAmount = 0;
        $totalCrAmount = 0;

        foreach ($data as &$item) {
            $item['cr_amount'] = json_decode($item['cr_amount'], true);
            $item['dr_amount'] = json_decode($item['dr_amount'], true);
            $v_date = $item['voucher_date'];
            array_push($dr_arr, $item['dr_amount']);
            array_push($cr_arr, $item['cr_amount']);
            // $totalDrAmount = $totalDrAmount + intval(array_column($dr_arr, 'amount'));
            // $totalCrAmount = $totalCrAmount + intval(array_column($cr_arr, 'amount'));
        }

        foreach ($dr_arr as $subArray) {
            foreach ($subArray as $item) {
                $totalDrAmount += (int)$item["amount"];
            }
        }

        foreach ($cr_arr as $subArray) {
            foreach ($subArray as $item) {
                $totalCrAmount += (int)$item["amount"];
            }
        }

        // dd($totalDrAmount, $totalCrAmount);

        // Flattening the data
        $newDRData = [];
        foreach ($dr_arr as $innerArray) {
            foreach ($innerArray as $item) {
                $newDRData[] = $item;
            }
        }
        $newCRData = [];
        foreach ($cr_arr as $innerArray) {
            foreach ($innerArray as $item) {
                $newCRData[] = $item;
            }
        }

        $newdrId = 1;
        foreach ($newDRData as $item) {
            $item["id"] = $newdrId++;
            $newDR[] = $item;
        }
        $newcrId = 1;
        foreach ($newCRData as $item) {
            $item["id"] = $newcrId++;
            $newCR[] = $item;
        }

        // dd(json_encode($newCR), $newDR);

        $description = 'Multiple Journal vouchers added: ' . implode(', ', $data->pluck('voucher_no')->map(function($id) {
            return 'memo-' . $id;
        })->toArray());
        // $totalDrAmount = array_sum(array_column($updatedDrAmount, 'amount'));
        // $totalCrAmount = array_sum(array_column($updatedCrAmount, 'amount'));

        $voucher = new voucher_entry;
        $voucher->voucher_type = "Journal";
        $voucher->voucher_no = "j_" . (int)floor($desiredValue);
        $voucher->type = "Cash";
        $voucher->type_name = "N/A";
        $voucher->type_cheque = "N/A";
        $voucher->type_date = "N/A";
        $voucher->voucher_date = $v_date;
        $voucher->party = "N/A";
        $voucher->receiver = "N/A";
        $voucher->description = $description;
        $voucher->dr_amount = json_encode($newCR); // Convert to JSON string
        $voucher->cr_amount = json_encode($newDR); // Convert to JSON string
        $voucher->cr_dr = $finalDataJson;
        $voucher->total_dr_amount = $totalDrAmount;
        $voucher->total_cr_amount = $totalCrAmount;
        $voucher->vat = 0;
        $voucher->tax = 0;
        $voucher->status = "Multiple";
        $voucher->save();

        voucher_entry::whereIn('id', $checkboxes)->update(['status' => 'Done']);

        return redirect('journal-voucher');
    }

    public function journal_voucher_delete(Request $request) {
        $voucher_data = voucher_entry::where('voucher_no', $request->get('id_delete'))->get();

        preg_match_all('/\bmemo-([a-zA-Z0-9._-]+)\b/', $voucher_data[0]["description"], $matches);
        $numbers = $matches[1];

        $output = $numbers;
        $size = count($output);

        // dd($output);
        $voucher_type = $voucher_data[0]["voucher_type"];

        if($size > 0) {
            if($voucher_type == "Receipt Voucher") {
                collection_entry::whereIn('id', $output)->update(['status' => 'visible']);
            } else if($voucher_type == "Journal") {
                voucher_entry::whereIn('voucher_no', $output)->update(['status' => 'Pending']);
            }
        }
        voucher_entry::where('voucher_no', $request->get('id_delete'))->delete();
        
        return redirect('journal-voucher');
    } 

    public function chequeApprovedView()
    {
        if(Auth::check()){
            return view('super_admin.core_accounting.vouchers.cheque_approved');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    // Account Reports
    public function chartOfAccountsView()
    {
        if(Auth::check()){
            return view('super_admin.core_accounting.account_reports.chart_of_accounts');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function trialBalanceView(Request $request)
    {
        if (Auth::check()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
    
            $records = ($request->isMethod('post'))
                ? voucher_entry::whereBetween('voucher_date', [$startDate, $endDate])->get()
                : voucher_entry::all();

            //Control Account and Account Head hable Marged and get data
            $combine_data = DB::table('control_ac')
                ->join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
                ->select('control_ac.accounts_group', 'control_ac.subsidiary_account_name', 'control_ac.account_name', 'ac_head.ac_head_name_eng')
                ->get();

            // dd($combine_data);
    
            $drAmountSum = [];
            $crAmountSum = [];
            $totalDrAmount = 0;
            $totalCrAmount = 0;
            $result = [];
    
            foreach ($records as $record) {
                $drAmount = json_decode($record->dr_amount, true);
                $crAmount = json_decode($record->cr_amount, true);
    
                foreach ($drAmount as $item) {
                    $name = $item['name'];
                    $amount = intval($item['amount']);
    
                    if (isset($drAmountSum[$name])) {
                        $drAmountSum[$name] += $amount;
                    } else {
                        $drAmountSum[$name] = $amount;
                    }
    
                    $totalDrAmount += $amount;
                }
    
                foreach ($crAmount as $item) {
                    $name = $item['name'];
                    $amount = intval($item['amount']);
    
                    if (isset($crAmountSum[$name])) {
                        $crAmountSum[$name] += $amount;
                    } else {
                        $crAmountSum[$name] = $amount;
                    }
    
                    $totalCrAmount += $amount;
                }
            }
    
            foreach ($drAmountSum as $name => $drAmount) {
                $crAmount = isset($crAmountSum[$name]) ? $crAmountSum[$name] : 0;
                $result[] = ['name' => $name, 'drAmount' => $drAmount, 'crAmount' => $crAmount];
            }
    
            // Add the remaining crAmount entries that do not have a corresponding drAmount entry
            foreach ($crAmountSum as $name => $crAmount) {
                if (!isset($drAmountSum[$name])) {
                    $result[] = ['name' => $name, 'drAmount' => 0, 'crAmount' => $crAmount];
                }
            }

            foreach ($combine_data as &$item) {
                $found = false;
                foreach ($result as $entry) {
                    if ($entry['name'] === $item->ac_head_name_eng) {
                        $item->drAmount = $entry['drAmount'];
                        $item->crAmount = $entry['crAmount'];
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $item->drAmount = 0;
                    $item->crAmount = 0;
                }
            }

            // dd($combine_data);            
            
            $final_data = [];
            
            foreach ($combine_data as $item) {
                $accountName = $item->account_name;
            
                if (isset($final_data[$accountName])) {
                    // If account_name already exists in final_data, add the values
                    $final_data[$accountName]->drAmount += $item->drAmount;
                    $final_data[$accountName]->crAmount += $item->crAmount;
                } else {
                    // If account_name doesn't exist, create a new entry
                    $final_data[$accountName] = (object) [
                        "accounts_group" => $item->accounts_group,
                        "subsidiary_account_name" => $item->subsidiary_account_name,
                        "account_name" => $item->account_name,
                        "drAmount" => $item->drAmount,
                        "crAmount" => $item->crAmount
                    ];
                }
            }
            
            $combinedItems = array_values($final_data);

            $sortedData = collect($combinedItems)->sortBy([
                ["accounts_group", "asc"],
                ["subsidiary_account_name", "asc"],
            ]);
            // dd($sortedData);
    
            return view('super_admin.core_accounting.account_reports.trial_balance', [
                'data' => $sortedData,
                'startDate' => $startDate,
                'endtDate' => $endDate
            ]);
        }
    
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function bankBookView()
    {
        if(Auth::check()){
            return view('super_admin.core_accounting.account_reports.bank_book');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function subACLedgerView(Request $request)
    {
        if(Auth::check()){
            // Retrieve subsidiary account details for the dropdown
            $subsidiaryAccounts = subsidiary_ac::all();

            if ($request->isMethod('post')) {
                // Retrieve form input values
                $subsidiaryAcId = $request->input('subsidiary_ac_id');
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                // dd("subsidiary_account_name", $subsidiaryAcId);
                // Validate form input values
                $validatedData = $request->validate([
                    'subsidiary_ac_id' => 'required',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after_or_equal:start_date',
                ]);

                // Retrieve subsidiary account details
                $subsidiaryAc = control_ac::where("subsidiary_account_name", "=", $subsidiaryAcId)->pluck('account_id');

                $ac_head = DB::table('ac_head')
                    ->whereIn('control_ac_id', $subsidiaryAc)
                    ->get();
                // dd($ac_head);

                // Retrieve voucher entries based on date range
                $voucherEntries = voucher_entry::whereBetween('voucher_date', [$startDate, $endDate])
                    ->get();

                    dd($voucherEntries);

                // Perform calculations to generate ledger data
                $ledgerData = [];
                $previousTotalAmount = 0;

                // Filter voucher entries by subsidiary account
                $filteredVoucherEntries = [];
                foreach ($voucherEntries as $voucherEntry) {
                    $drAmounts = json_decode($voucherEntry->dr_amount, true);
                    $crAmounts = json_decode($voucherEntry->cr_amount, true);

                    $totalDrAmount = 0;
                    $totalCrAmount = 0;

                    foreach ($drAmounts as $drAmount) {
                        if ($drAmount['id'] == $subsidiaryAcId) {
                            $totalDrAmount += $drAmount['amount'];
                        }
                    }

                    foreach ($crAmounts as $crAmount) {
                        if ($crAmount['id'] == $subsidiaryAcId) {
                            $totalCrAmount += $crAmount['amount'];
                        }
                    }

                    $totalAmount = $totalDrAmount - $totalCrAmount;
                    $balance = $previousTotalAmount + $totalAmount;
                    $name = $drAmounts[0]['name'];

                    $ledgerData[] = [
                        'voucher_date' => $voucherEntry->voucher_date,
                        'name' => $name,
                        'total_dr_amount' => $totalDrAmount,
                        'total_cr_amount' => $totalCrAmount,
                        'total_amount' => $totalAmount,
                        'balance' => $balance,
                    ];

                    $previousTotalAmount = $balance;
                }

                // dd($ledgerData);

                // Pass the data to the view
                return view('super_admin.core_accounting.account_reports.sub_ac_ledger', [
                    'subsidiaryAccounts' => $subsidiaryAccounts,
                    'subsidiaryAc' => $subsidiaryAc,
                    'ledgerData' => $ledgerData,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                ]);
            } else {
                return view('super_admin.core_accounting.account_reports.sub_ac_ledger', [
                    'subsidiaryAccounts' => $subsidiaryAccounts,
                    'ledgerData' => null,
                    'startDate' => null,
                    'endDate' => null,
                ]);
            }

            // return view('super_admin.core_accounting.account_reports.sub_ac_ledger');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function controlACLedgerView(Request $request)
    {
        if(Auth::check()){
            // Retrieve control account details for the dropdown
            $accounts = control_ac::pluck('account_name')->toArray();

            $selectedAccountName = $request->input('account_name');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            if ($request->isMethod('post')) {
                $ac_head_names = DB::table('control_ac')
                    ->join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
                    ->where('control_ac.account_name', '=', $selectedAccountName)
                    ->select('ac_head.ac_head_name_eng')
                    ->get();

                $ledgerData = DB::table('voucher_entry')
                    ->whereBetween('voucher_date', [$startDate, $endDate])
                    ->select('voucher_date', 'dr_amount', 'cr_amount')
                    ->get();

                // Filter the dr_amount and cr_amount based on ac_head_names
                $filteredLedgerData = $ledgerData->map(function ($item) use ($ac_head_names) {
                    $item->dr_amount = collect(json_decode($item->dr_amount))->filter(function ($amount) use ($ac_head_names) {
                        return $ac_head_names->contains('ac_head_name_eng', $amount->name);
                    })->values();

                    $item->cr_amount = collect(json_decode($item->cr_amount))->filter(function ($amount) use ($ac_head_names) {
                        return $ac_head_names->contains('ac_head_name_eng', $amount->name);
                    })->values();

                    return $item;
                });

                // dd($filteredLedgerData  );

                // Output the filtered ledger data
                return view('super_admin.core_accounting.account_reports.control_ac_ledger', ['ledgerData' => $filteredLedgerData, 'accounts' => $accounts]);
            }

            // Handle GET request
            return view('super_admin.core_accounting.account_reports.control_ac_ledger', ['accounts' => $accounts, 'ledgerData' => null]);
            // return view('super_admin.core_accounting.account_reports.control_ac_ledger');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function acHeadLedgerView(Request $request)
    {
        // if(Auth::check()){
        //     return view('super_admin.core_accounting.account_reports.ac_head_ledger');
        // }
        if (Auth::check()) {
            // Retrieve AC Head names for the dropdown
            $accounts = account_head::pluck('ac_head_name_eng')->toArray();
    
            $selectedAccountName = $request->input('ac_head_name_eng');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
    
            if ($request->isMethod('post')) {
                $ledgerData = DB::table('voucher_entry')
                    ->whereBetween('voucher_date', [$startDate, $endDate])
                    ->select('voucher_no', 'description', 'voucher_date', 'dr_amount', 'cr_amount')
                    ->whereIn('status', ['pending', 'Done'])
                    ->get();
    
                $filteredLedgerData = $ledgerData->map(function ($item) use ($selectedAccountName) {
                    $item->dr_amount = collect(json_decode($item->dr_amount))->filter(function ($amount) use ($selectedAccountName) {
                        return $amount->name === $selectedAccountName;
                    })->values();
                
                    $item->cr_amount = collect(json_decode($item->cr_amount))->filter(function ($amount) use ($selectedAccountName) {
                        return $amount->name === $selectedAccountName;
                    })->values();
                
                    // Check if both dr_amount and cr_amount are empty, and exclude the row if they are
                    if (empty($item->dr_amount) && empty($item->cr_amount)) {
                        return null;
                    }
                
                    return $item;
                })->filter(); // Remove null values from the resulting collection

                $numbers = [];

                foreach ($ledgerData as $key => $item) {
                    if (strpos($item->voucher_no, 'r_') !== false && strpos($item->description, 'Multiple vouchers added:') !== false) {
                        $item_voucher_no = $item->voucher_no;
                        // Extract numbers using regular expression
                        preg_match_all('/memo-(\d+)/', $item->description, $matches);
                        $numbers = array_merge($numbers, $matches[1]);
                        if ($numbers) {
                            $r_data_table = DB::table('collection_entry')
                                ->whereIn('id', $numbers)
                                ->select('id', 'dr_amount', 'cr_amount', 'collection_date')
                                ->get();
                
                            $filtered_r_Data = $r_data_table->map(function ($item) use ($selectedAccountName, $item_voucher_no) {
                                // Decode the JSON strings in dr_amount and cr_amount columns
                                $drAmount = json_decode($item->dr_amount);
                                $crAmount = json_decode($item->cr_amount);
                
                                // Check if the search keyword exists in either dr_amount or cr_amount
                                $drAmount = $this->filterByName($drAmount, $selectedAccountName);
                                $crAmount = $this->filterByName($crAmount, $selectedAccountName);
                
                                // Convert dr_amount and cr_amount to collections
                                $drAmountCollection = collect($drAmount);
                                $crAmountCollection = collect($crAmount);
                
                                return [
                                    'voucher_no' => $item_voucher_no,
                                    'description' => "Memo-" . $item->id,
                                    'dr_amount' => $drAmountCollection,
                                    'cr_amount' => $crAmountCollection,
                                    'voucher_date' => $item->collection_date,
                                ];
                            });

                            $filteredCollection = $ledgerData->filter(function ($item) use ($item_voucher_no) {
                                // Check if $item is an object (assuming objects have a 'voucher_no' property)
                                if (is_object($item) && property_exists($item, 'voucher_no')) {
                                    return $item->voucher_no !== $item_voucher_no;
                                }
                                
                                // If $item is not an object or does not have a 'voucher_no' property, keep it
                                return true;
                            });
                
                            // Add the items from $filtered_r_Data to $ledgerData
                            $ledgerData = $filteredCollection->concat($filtered_r_Data->all());

                            foreach ($ledgerData as $key => $element) {
                                if (is_array($element)) {
                                    // Convert the array to an object
                                    $object = (object) $element;
                                    
                                    // Replace the old array with the new object
                                    $ledgerData[$key] = $object;
                                }
                            }
                        }
                    }
                }
                

                // dd($ledgerData);
                $openningBalance = 0;
                
                // Output the filtered ledger data
                // return view('super_admin.core_accounting.account_reports.ac_head_ledger', ['ledgerData' => $filteredLedgerData, 'accounts' => $accounts, 'selectedAccountName']);
                return view('super_admin.core_accounting.account_reports.ac_head_ledger', ['ledgerData' => $ledgerData, 'accounts' => $accounts, 'selectedAccountName' => $selectedAccountName, 'startDate' => $startDate, 'endDate' => $endDate, 'openningBalance' => $openningBalance]);
                // return view('super_admin.core_accounting.account_reports.ac_head_ledger', ['ledgerData' => $filteredLedgerData, 'accounts' => $accounts]);
            }
    
            return view('super_admin.core_accounting.account_reports.ac_head_ledger', ['accounts' => $accounts, 'ledgerData' => null, 'startDate' => null, 'endDate' => null]);
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    function filterByName($array, $keyword)
    {
        if (!is_array($array)) {
            return [];
        }

        return array_filter($array, function ($item) use ($keyword) {
            return isset($item->name) && $item->name === $keyword;
        });
    }

    public function partyLedgerView(Request $request)
    {
        if(Auth::check()){
            if ($request->isMethod('post')) {
                $parties = party::all();
                $name = $request->name1;
                $startDate = $request->startDate;
                $endDate = $request->endDate;
                $name1 = $request->name1;

                $collectionData = collection_entry::where('customer_name', $name)
                    ->whereBetween('collection_date', [$startDate, $endDate])
                    ->where('status', 'Done')->get();
                
                $voucherData = voucher_entry::whereNotIn('voucher_type', ['Receipt Voucher'])
                    ->whereBetween('voucher_date', [$startDate, $endDate])
                    ->where('party', $name1)
                    ->get();

                $collectionData = $collectionData->toArray();
                $voucherData = $voucherData->toArray();
                $mergedArray = array_merge($collectionData, $voucherData);
                // Group the merged array by date
                $groupedArray = [];
                foreach ($mergedArray as $item) {
                    $date = $item['collection_date'] ?? $item['voucher_date'];
                    $groupedArray[$date][] = $item;
                }

                // Sort the grouped array by date
                ksort($groupedArray);

                // Generate the new JSON array with the required elements
                foreach ($groupedArray as $date => $items) {
                    $newItem = [
                        'date' => $date,
                        'dr_amount' => [],
                        'cr_amount' => [],
                    ];

                    foreach ($items as $item) {
                        if (isset($item['dr_amount'])) {
                            $newItem['dr_amount'] = array_merge($newItem['dr_amount'], json_decode($item['dr_amount'], true));
                        }

                        if (isset($item['cr_amount'])) {
                            $newItem['cr_amount'] = array_merge($newItem['cr_amount'], json_decode($item['cr_amount'], true));
                        }
                    }

                    $combinedArray[] = $newItem;
                }

                //dd($combinedArray);
                return view('super_admin.core_accounting.account_reports.party_ledger')->with('data', $combinedArray)->with('parties', $parties);
            } else {
                $parties = party::all();
                return view('super_admin.core_accounting.account_reports.party_ledger')->with('data', null)->with('data2', null)->with('parties', $parties);
            }
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function controlACSummaryView()
    {
        if(Auth::check()){
            return view('super_admin.core_accounting.account_reports.control_ac_summary');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function controlACBalanceView()
    {
        if(Auth::check()){
            return view('super_admin.core_accounting.account_reports.control_ac_balance');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function bankReconciliationStatementView()
    {
        if(Auth::check()){
            return view('super_admin.core_accounting.account_reports.bank_reconciliation_statement');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function ugcMonthlyStatementView()
    {
        if(Auth::check()){
            return view('super_admin.core_accounting.account_reports.ugc_monthly_statement');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function cancelledVoucherView()
    {
        if(Auth::check()){
            return view('super_admin.core_accounting.account_reports.cancelled_voucher');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function voucherByDateView()
    {
        if(Auth::check()){
            return view('super_admin.core_accounting.account_reports.voucher_by_date');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function advanceRegisterView()
    {
        if(Auth::check()){
            return view('super_admin.core_accounting.account_reports.advance_register');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function profitLossAccountView(Request $request)
    {

        if (Auth::check()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
    
            $records = ($request->isMethod('post'))
                ? voucher_entry::whereBetween('voucher_date', [$startDate, $endDate])->get()
                : voucher_entry::all();

            //Control Account and Account Head hable Marged and get data
            $combine_data = DB::table('control_ac')
                ->join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
                ->select('control_ac.accounts_group', 'control_ac.subsidiary_account_name', 'control_ac.account_name', 'ac_head.ac_head_name_eng')
                ->whereIn('control_ac.subsidiary_account_name', ['Administrative Expendeture', 'Operational Expendeture', 'Non-operating Expenses', 'Sales and Services', 'Services'])
                ->get();

            // dd($combine_data);
    
            $drAmountSum = [];
            $crAmountSum = [];
            $totalDrAmount = 0;
            $totalCrAmount = 0;
            $result = [];
    
            foreach ($records as $record) {
                $drAmount = json_decode($record->dr_amount, true);
                $crAmount = json_decode($record->cr_amount, true);
    
                foreach ($drAmount as $item) {
                    $name = $item['name'];
                    $amount = intval($item['amount']);
    
                    if (isset($drAmountSum[$name])) {
                        $drAmountSum[$name] += $amount;
                    } else {
                        $drAmountSum[$name] = $amount;
                    }
    
                    $totalDrAmount += $amount;
                }
    
                foreach ($crAmount as $item) {
                    $name = $item['name'];
                    $amount = intval($item['amount']);
    
                    if (isset($crAmountSum[$name])) {
                        $crAmountSum[$name] += $amount;
                    } else {
                        $crAmountSum[$name] = $amount;
                    }
    
                    $totalCrAmount += $amount;
                }
            }
    
            foreach ($drAmountSum as $name => $drAmount) {
                $crAmount = isset($crAmountSum[$name]) ? $crAmountSum[$name] : 0;
                $result[] = ['name' => $name, 'drAmount' => $drAmount, 'crAmount' => $crAmount];
            }
    
            // Add the remaining crAmount entries that do not have a corresponding drAmount entry
            foreach ($crAmountSum as $name => $crAmount) {
                if (!isset($drAmountSum[$name])) {
                    $result[] = ['name' => $name, 'drAmount' => 0, 'crAmount' => $crAmount];
                }
            }

            foreach ($combine_data as &$item) {
                $found = false;
                foreach ($result as $entry) {
                    if ($entry['name'] === $item->ac_head_name_eng) {
                        $item->drAmount = $entry['drAmount'];
                        $item->crAmount = $entry['crAmount'];
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $item->drAmount = 0;
                    $item->crAmount = 0;
                }
            }
            
            $final_data = [];
            
            foreach ($combine_data as $item) {
                $accountName = $item->account_name;
            
                if (isset($final_data[$accountName])) {
                    // dd($final_data[$accountName], $item->drAmount);
                    // If account_name already exists in final_data, add the values
                    $final_data[$accountName]->totalAmount = $final_data[$accountName]->totalAmount + $item->drAmount - $item->crAmount;
                } else {
                    // If account_name doesn't exist, create a new entry
                    $final_data[$accountName] = (object) [
                        "accounts_group" => $item->accounts_group,
                        "subsidiary_account_name" => $item->subsidiary_account_name,
                        "account_name" => $item->account_name,
                        "totalAmount" => intval($item->drAmount) - intval($item->crAmount)
                    ];
                }
            }
            
            $combinedItems = array_values($final_data);

            // dd($combinedItems);

            $sortedData = collect($combinedItems)->sortBy([
                ["accounts_group", "asc"],
                ["subsidiary_account_name", "asc"],
            ]);
    
            return view('super_admin.core_accounting.account_reports.profit_loss_account', [
                'data' => $sortedData,
                'startDate' => $startDate,
                'endtDate' => $endDate
            ]);
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function trandingAccountView(Request $request)
    {
        if (Auth::check()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
    
            $records = ($request->isMethod('post'))
                ? voucher_entry::whereBetween('voucher_date', [$startDate, $endDate])->get()
                : voucher_entry::all();

            //Control Account and Account Head hable Marged and get data
            $combine_data = DB::table('control_ac')
                ->join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
                ->select('control_ac.accounts_group', 'control_ac.subsidiary_account_name', 'control_ac.account_name', 'ac_head.ac_head_name_eng')
                ->whereIn('control_ac.subsidiary_account_name', ['Sales and Services', 'Others Income','Services', 'Operational Expendeture', 'Administrative Expendeture'])
                ->get();

            // dd($combine_data);
    
            $drAmountSum = [];
            $crAmountSum = [];
            $totalDrAmount = 0;
            $totalCrAmount = 0;
            $result = [];
    
            foreach ($records as $record) {
                $drAmount = json_decode($record->dr_amount, true);
                $crAmount = json_decode($record->cr_amount, true);
    
                foreach ($drAmount as $item) {
                    $name = $item['name'];
                    $amount = intval($item['amount']);
    
                    if (isset($drAmountSum[$name])) {
                        $drAmountSum[$name] += $amount;
                    } else {
                        $drAmountSum[$name] = $amount;
                    }
    
                    $totalDrAmount += $amount;
                }
    
                foreach ($crAmount as $item) {
                    $name = $item['name'];
                    $amount = intval($item['amount']);
    
                    if (isset($crAmountSum[$name])) {
                        $crAmountSum[$name] += $amount;
                    } else {
                        $crAmountSum[$name] = $amount;
                    }
    
                    $totalCrAmount += $amount;
                }
            }
    
            foreach ($drAmountSum as $name => $drAmount) {
                $crAmount = isset($crAmountSum[$name]) ? $crAmountSum[$name] : 0;
                $result[] = ['name' => $name, 'drAmount' => $drAmount, 'crAmount' => $crAmount];
            }
    
            // Add the remaining crAmount entries that do not have a corresponding drAmount entry
            foreach ($crAmountSum as $name => $crAmount) {
                if (!isset($drAmountSum[$name])) {
                    $result[] = ['name' => $name, 'drAmount' => 0, 'crAmount' => $crAmount];
                }
            }

            foreach ($combine_data as &$item) {
                $found = false;
                foreach ($result as $entry) {
                    if ($entry['name'] === $item->ac_head_name_eng) {
                        $item->drAmount = $entry['drAmount'];
                        $item->crAmount = $entry['crAmount'];
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $item->drAmount = 0;
                    $item->crAmount = 0;
                }
            }
            
            $final_data = [];
            
            foreach ($combine_data as $item) {
                $accountName = $item->account_name;
            
                if (isset($final_data[$accountName])) {
                    // dd($final_data[$accountName], $item->drAmount);
                    // If account_name already exists in final_data, add the values
                    $final_data[$accountName]->totalAmount = $final_data[$accountName]->totalAmount + $item->drAmount - $item->crAmount;
                } else {
                    // If account_name doesn't exist, create a new entry
                    $final_data[$accountName] = (object) [
                        "accounts_group" => $item->accounts_group,
                        "subsidiary_account_name" => $item->subsidiary_account_name,
                        "account_name" => $item->account_name,
                        "totalAmount" => intval($item->drAmount) - intval($item->crAmount)
                    ];
                }
            }
            
            $combinedItems = array_values($final_data);

            // dd($combinedItems);

            $sortedData = collect($combinedItems)->sortBy([
                ["accounts_group", "asc"],
                ["subsidiary_account_name", "asc"],
            ]);
    
            return view('super_admin.core_accounting.account_reports.tranding_account', [
                'data' => $sortedData,
                'startDate' => $startDate,
                'endtDate' => $endDate
            ]);
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function balanceSheetView(Request $request)
    {
        if(Auth::check()){
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
    
            $records = ($request->isMethod('post'))
                ? voucher_entry::whereBetween('voucher_date', [$startDate, $endDate])->get()
                : voucher_entry::all();

            //Control Account and Account Head hable Marged and get data
            $combine_data = DB::table('control_ac')
                ->join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
                ->select('control_ac.accounts_group', 'control_ac.subsidiary_account_name', 'control_ac.account_name', 'ac_head.ac_head_name_eng')
                ->whereIn('control_ac.subsidiary_account_name', ['Current Assets', 'Other Investments', 'Capital & Liabilities','Grant in Aid', 'Current Libilities', 'Provision For Adjustment'])
                ->get();

            $fixed_assets_data = DB::table('control_ac')
                ->join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
                ->select('control_ac.accounts_group', 'control_ac.subsidiary_account_name', 'control_ac.account_name', 'ac_head.ac_head_name_eng')
                ->whereIn('control_ac.subsidiary_account_name', ['Fixed Assets'])
                ->get();

            // dd($fixed_assets_data);
    
            $drAmountSum = [];
            $crAmountSum = [];
            $totalDrAmount = 0;
            $totalCrAmount = 0;
            $result = [];
    
            foreach ($records as $record) {
                $drAmount = json_decode($record->dr_amount, true);
                $crAmount = json_decode($record->cr_amount, true);
    
                foreach ($drAmount as $item) {
                    $name = $item['name'];
                    $amount = intval($item['amount']);
    
                    if (isset($drAmountSum[$name])) {
                        $drAmountSum[$name] += $amount;
                    } else {
                        $drAmountSum[$name] = $amount;
                    }
    
                    $totalDrAmount += $amount;
                }
    
                foreach ($crAmount as $item) {
                    $name = $item['name'];
                    $amount = intval($item['amount']);
    
                    if (isset($crAmountSum[$name])) {
                        $crAmountSum[$name] += $amount;
                    } else {
                        $crAmountSum[$name] = $amount;
                    }
    
                    $totalCrAmount += $amount;
                }
            }
    
            foreach ($drAmountSum as $name => $drAmount) {
                $crAmount = isset($crAmountSum[$name]) ? $crAmountSum[$name] : 0;
                $result[] = ['name' => $name, 'drAmount' => $drAmount, 'crAmount' => $crAmount];
            }
    
            // Add the remaining crAmount entries that do not have a corresponding drAmount entry
            foreach ($crAmountSum as $name => $crAmount) {
                if (!isset($drAmountSum[$name])) {
                    $result[] = ['name' => $name, 'drAmount' => 0, 'crAmount' => $crAmount];
                }
            }

            foreach ($combine_data as &$item) {
                $found = false;
                foreach ($result as $entry) {
                    if ($entry['name'] === $item->ac_head_name_eng) {
                        $item->drAmount = $entry['drAmount'];
                        $item->crAmount = $entry['crAmount'];
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $item->drAmount = 0;
                    $item->crAmount = 0;
                }
            }

            foreach ($fixed_assets_data as &$item) {
                $found = false;
                foreach ($result as $entry) {
                    if ($entry['name'] === $item->ac_head_name_eng) {
                        $item->drAmount = $entry['drAmount'];
                        $item->crAmount = $entry['crAmount'];
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $item->drAmount = 0;
                    $item->crAmount = 0;
                }
            }

            // dd($fixed_assets_data);
            $totalDrAmount2 = 0;
            $totalCrAmount2 = 0;

            foreach ($fixed_assets_data as $item2) {
                $totalDrAmount2 += $item2->drAmount;
                $totalCrAmount2 += $item2->crAmount;
            }

            $fixed_assets_output = [
                "drAmount" => $totalDrAmount2,
                "crAmount" => $totalCrAmount2,
            ];

            // dd($fixed_assets_output);
            
            $final_data = [];
            
            foreach ($combine_data as $item) {
                $accountName = $item->account_name;
            
                if (isset($final_data[$accountName])) {
                    // dd($final_data[$accountName], $item->drAmount);
                    // If account_name already exists in final_data, add the values
                    $final_data[$accountName]->totalAmount = $final_data[$accountName]->totalAmount + $item->drAmount - $item->crAmount;
                } else {
                    // If account_name doesn't exist, create a new entry
                    $final_data[$accountName] = (object) [
                        "accounts_group" => $item->accounts_group,
                        "subsidiary_account_name" => $item->subsidiary_account_name,
                        "account_name" => $item->account_name,
                        "totalAmount" => intval($item->drAmount) - intval($item->crAmount)
                    ];
                }
            }
            
            $combinedItems = array_values($final_data);

            // dd($combinedItems);

            $sortedData = collect($combinedItems)->sortBy([
                ["accounts_group", "asc"],
                ["subsidiary_account_name", "asc"],
            ]);
    
            return view('super_admin.core_accounting.account_reports.balancesheet', [
                'data' => $sortedData,
                'fixed_assets_data' => $fixed_assets_output,
                'startDate' => $startDate,
                'endtDate' => $endDate
            ]);
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function advanceSummaryView()
    {
        if(Auth::check()){
            return view('super_admin.core_accounting.account_reports.advance_summary');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function profitMarginView()
    {
        if(Auth::check()){
            return view('super_admin.core_accounting.account_reports.profit_margin');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }
}
