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

            // $data = voucher_entry::whereIn('voucher_no', function ($query) {
            //         $query->selectRaw('MAX(voucher_no)')
            //             ->from('voucher_entry')
            //             ->whereRaw('voucher_no LIKE "r_%"')
            //             ->groupBy(DB::raw('SUBSTRING(voucher_no, 1, 2)'));
            //     })
            //     ->orWhereIn('voucher_no', function ($query) {
            //         $query->selectRaw('MAX(voucher_no)')
            //             ->from('voucher_entry')
            //             ->whereRaw('voucher_no LIKE "j_%"')
            //             ->groupBy(DB::raw('SUBSTRING(voucher_no, 1, 2)'));
            //     })
            //     ->orWhereIn('voucher_no', function ($query) {
            //         $query->selectRaw('MAX(voucher_no)')
            //             ->from('voucher_entry')
            //             ->whereRaw('voucher_no LIKE "a_%"')
            //             ->groupBy(DB::raw('SUBSTRING(voucher_no, 1, 2)'));
            //     })
            //     ->get();

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
        $data2 = voucher_entry:: where('voucher_no', 'LIKE', 'r_%')
            ->orderByRaw('CAST(SUBSTRING(voucher_no, 3) AS UNSIGNED) DESC')
            ->first();
        $highestVoucherNo = $data2->voucher_no;
            // return response()->json(['data' => $highestVoucherNo]);
        $number = 0;

        if($highestVoucherNo) {
            $lastVoucherNo = $highestVoucherNo;
        }
        else {
            $lastVoucherNo = "r_0";
        }
        $prefix = substr($lastVoucherNo, 0, 1);
        $number = intval(substr($lastVoucherNo, 2)) + 1;

        $nextVoucherNo1 = $prefix . '_' . $number;
        // $row->next_voucher_no = $number;

        $nextVoucherNo = $number;

        // return response()->json(['data' => $nextVoucherNo]);

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
            
            if ($request->isMethod('post')) {
                // Retrieve form input values
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                $all_contol_names = control_ac::distinct()
                    ->select('accounts_group', 'subsidiary_account_name', 'account_name')
                    ->get()
                    ->toArray();
                // dd($all_contol_names);
            
                    // dd($controlACNames);
                    
                $ledgerData = DB::table('voucher_entry')
                    ->whereBetween('voucher_date', [$startDate, $endDate])
                    ->select('voucher_no', 'description', 'dr_amount', 'cr_amount', 'voucher_date')
                    ->whereIn('status', ['pending', 'Done'])
                    ->get();

                $final_data = [];

                foreach ($all_contol_names as $all_contol_name) {

                    $acHeadNames = account_head::distinct()
                        ->select('ac_head.ac_head_name_eng')
                        ->join('control_ac', 'ac_head.control_ac_id', '=', 'control_ac.account_id')
                        ->join('subsidiary_ac', 'control_ac.subsidiary_account_name', '=', 'subsidiary_ac.account_name')
                        ->where('subsidiary_ac.account_name', '=', $all_contol_name['subsidiary_account_name'])
                        ->get()
                        ->pluck('ac_head_name_eng')
                        ->toArray();

                    $controlACNames = account_head::distinct()
                        ->select('ac_head.ac_head_name_eng', 'control_ac.account_name')
                        ->join('control_ac', 'ac_head.control_ac_id', '=', 'control_ac.account_id')
                        ->join('subsidiary_ac', 'control_ac.subsidiary_account_name', '=', 'subsidiary_ac.account_name')
                        ->where('subsidiary_ac.account_name', '=', $all_contol_name['subsidiary_account_name'])
                        ->get()
                        ->toArray();
                    
                    $filteredLedgerData = $this->ledgerDataManupulation($ledgerData, "", $acHeadNames);

                    $totals = [];
                    foreach ($acHeadNames as $name) {
                        $total = 0;
                    
                        foreach ($filteredLedgerData as $entry) {
                            foreach ($entry->dr_amount as $dr) {
                                if ($dr->name === $name) {
                                    $total += floatval($dr->amount);
                                }
                            }
                    
                            foreach ($entry->cr_amount as $cr) {
                                if ($cr->name === $name) {
                                    $total -= floatval($cr->amount);
                                }
                            }
                        }
                    
                        $totals[] = [
                            "name" => $name,
                            "amount" => $total
                        ];
                    }
                    
                    // Remove entries with zero amounts
                    // $totals = array_filter($totals, function ($item) {
                    //     return floatval($item["amount"]) != 0;
                    // });

                    // dd($totals);

                    $accumulatedAmounts = [];

                    // Loop through data2 to accumulate amounts
                    foreach ($totals as $item2) {
                        $name2 = $item2['name'];
                        $amount2 = $item2['amount'];

                        // Find the corresponding "ac_head_name_eng" in data1
                        $matchingItem1 = null;
                        foreach ($controlACNames as $item1) {
                            if ($item1['ac_head_name_eng'] === $name2) {
                                $matchingItem1 = $item1;
                                break;
                            }
                        }

                        if ($matchingItem1) {
                            $accountName = $matchingItem1['account_name'];
                            // Accumulate the amount based on "account_name"
                            if (!isset($accumulatedAmounts[$accountName])) {
                                $accumulatedAmounts[$accountName] = 0;
                            }
                            $accumulatedAmounts[$accountName] += $amount2;
                        }
                    }

                    // Create the final output array
                    $output = [];
                    foreach ($accumulatedAmounts as $accountName => $amount) {
                        $output[] = [
                            'account_group' => $all_contol_name['accounts_group'],
                            'subsidiary_account_name' => $all_contol_name['subsidiary_account_name'],
                            'name' => $accountName,
                            'amount' => $amount,
                        ];
                    }

                    // Convert the associative array to indexed array
                    $output = array_values($output);
                    $final_data = array_merge($final_data, $output);
                    // dd($output);
                }

                $uniqueData = [];

                foreach ($final_data as $item) {
                    $key = $item['account_group'] . $item['subsidiary_account_name'] . $item['name'] . $item['amount'];
                    
                    if (!isset($uniqueData[$key])) {
                        $uniqueData[$key] = $item;
                    }
                }

                $final_data = array_values($uniqueData);

                // dd($final_data);

                return view('super_admin.core_accounting.account_reports.trial_balance', [
                        'data' => $final_data,
                        'startDate' => $startDate,
                        'endtDate' => $endDate
                ]);
            } else {
                return view('super_admin.core_accounting.account_reports.trial_balance', [
                    'data' => [],
                    'startDate' => $startDate,
                    'endtDate' => $endDate
                ]);
            }
                // dd($output);
            // $records = ($request->isMethod('post'))
            //     ? voucher_entry::whereBetween('voucher_date', [$startDate, $endDate])->get()
            //     : voucher_entry::all();

            // //Control Account and Account Head hable Marged and get data
            // $combine_data = DB::table('control_ac')
            //     ->join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
            //     ->select('control_ac.accounts_group', 'control_ac.subsidiary_account_name', 'control_ac.account_name', 'ac_head.ac_head_name_eng')
            //     ->get();

            // // dd($combine_data);
    
            // $drAmountSum = [];
            // $crAmountSum = [];
            // $totalDrAmount = 0;
            // $totalCrAmount = 0;
            // $result = [];
    
            // foreach ($records as $record) {
            //     $drAmount = json_decode($record->dr_amount, true);
            //     $crAmount = json_decode($record->cr_amount, true);
    
            //     foreach ($drAmount as $item) {
            //         $name = $item['name'];
            //         $amount = intval($item['amount']);
    
            //         if (isset($drAmountSum[$name])) {
            //             $drAmountSum[$name] += $amount;
            //         } else {
            //             $drAmountSum[$name] = $amount;
            //         }
    
            //         $totalDrAmount += $amount;
            //     }
    
            //     foreach ($crAmount as $item) {
            //         $name = $item['name'];
            //         $amount = intval($item['amount']);
    
            //         if (isset($crAmountSum[$name])) {
            //             $crAmountSum[$name] += $amount;
            //         } else {
            //             $crAmountSum[$name] = $amount;
            //         }
    
            //         $totalCrAmount += $amount;
            //     }
            // }
    
            // foreach ($drAmountSum as $name => $drAmount) {
            //     $crAmount = isset($crAmountSum[$name]) ? $crAmountSum[$name] : 0;
            //     $result[] = ['name' => $name, 'drAmount' => $drAmount, 'crAmount' => $crAmount];
            // }
    
            // // Add the remaining crAmount entries that do not have a corresponding drAmount entry
            // foreach ($crAmountSum as $name => $crAmount) {
            //     if (!isset($drAmountSum[$name])) {
            //         $result[] = ['name' => $name, 'drAmount' => 0, 'crAmount' => $crAmount];
            //     }
            // }

            // foreach ($combine_data as &$item) {
            //     $found = false;
            //     foreach ($result as $entry) {
            //         if ($entry['name'] === $item->ac_head_name_eng) {
            //             $item->drAmount = $entry['drAmount'];
            //             $item->crAmount = $entry['crAmount'];
            //             $found = true;
            //             break;
            //         }
            //     }
            //     if (!$found) {
            //         $item->drAmount = 0;
            //         $item->crAmount = 0;
            //     }
            // }

            // // dd($combine_data);            
            
            // $final_data = [];
            
            // foreach ($combine_data as $item) {
            //     $accountName = $item->account_name;
            
            //     if (isset($final_data[$accountName])) {
            //         // If account_name already exists in final_data, add the values
            //         $final_data[$accountName]->drAmount += $item->drAmount;
            //         $final_data[$accountName]->crAmount += $item->crAmount;
            //     } else {
            //         // If account_name doesn't exist, create a new entry
            //         $final_data[$accountName] = (object) [
            //             "accounts_group" => $item->accounts_group,
            //             "subsidiary_account_name" => $item->subsidiary_account_name,
            //             "account_name" => $item->account_name,
            //             "drAmount" => $item->drAmount,
            //             "crAmount" => $item->crAmount
            //         ];
            //     }
            // }
            
            // $combinedItems = array_values($final_data);

            // $sortedData = collect($combinedItems)->sortBy([
            //     ["accounts_group", "asc"],
            //     ["subsidiary_account_name", "asc"],
            // ]);
            // // dd($sortedData);
    
            // return view('super_admin.core_accounting.account_reports.trial_balance', [
            //     'data' => $sortedData,
            //     'startDate' => $startDate,
            //     'endtDate' => $endDate
            // ]);
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

                $acHeadNames = account_head::distinct()
                    ->select('ac_head.ac_head_name_eng')
                    ->join('control_ac', 'ac_head.control_ac_id', '=', 'control_ac.account_id')
                    ->join('subsidiary_ac', 'control_ac.subsidiary_account_name', '=', 'subsidiary_ac.account_name')
                    ->where('subsidiary_ac.account_name', '=', $subsidiaryAcId)
                    ->get()
                    ->pluck('ac_head_name_eng')
                    ->toArray();
                
                $controlACNames = account_head::distinct()
                    ->select('ac_head.ac_head_name_eng', 'control_ac.account_name')
                    ->join('control_ac', 'ac_head.control_ac_id', '=', 'control_ac.account_id')
                    ->join('subsidiary_ac', 'control_ac.subsidiary_account_name', '=', 'subsidiary_ac.account_name')
                    ->where('subsidiary_ac.account_name', '=', $subsidiaryAcId)
                    ->get()
                    ->toArray();
                    // dd($controlACNames);
                    
                $ledgerData = DB::table('voucher_entry')
                    ->whereBetween('voucher_date', [$startDate, $endDate])
                    ->select('voucher_no', 'description', 'dr_amount', 'cr_amount', 'voucher_date')
                    ->whereIn('status', ['pending', 'Done'])
                    ->get();
                
                $filteredLedgerData = $this->ledgerDataManupulation($ledgerData, "", $acHeadNames);

                $totals = [];
                foreach ($acHeadNames as $name) {
                    $total = 0;
                
                    foreach ($filteredLedgerData as $entry) {
                        foreach ($entry->dr_amount as $dr) {
                            if ($dr->name === $name) {
                                $total += floatval($dr->amount);
                            }
                        }
                
                        foreach ($entry->cr_amount as $cr) {
                            if ($cr->name === $name) {
                                $total -= floatval($cr->amount);
                            }
                        }
                    }
                
                    $totals[] = [
                        "name" => $name,
                        "amount" => $total
                    ];
                }
                
                // Remove entries with zero amounts
                $totals = array_filter($totals, function ($item) {
                    return floatval($item["amount"]) != 0;
                });

                // dd($totals);

                $accumulatedAmounts = [];

                // Loop through data2 to accumulate amounts
                foreach ($totals as $item2) {
                    $name2 = $item2['name'];
                    $amount2 = $item2['amount'];

                    // Find the corresponding "ac_head_name_eng" in data1
                    $matchingItem1 = null;
                    foreach ($controlACNames as $item1) {
                        if ($item1['ac_head_name_eng'] === $name2) {
                            $matchingItem1 = $item1;
                            break;
                        }
                    }

                    if ($matchingItem1) {
                        $accountName = $matchingItem1['account_name'];
                        // Accumulate the amount based on "account_name"
                        if (!isset($accumulatedAmounts[$accountName])) {
                            $accumulatedAmounts[$accountName] = 0;
                        }
                        $accumulatedAmounts[$accountName] += $amount2;
                    }
                }

                // Create the final output array
                $output = [];
                foreach ($accumulatedAmounts as $accountName => $amount) {
                    $output[] = [
                        'name' => $accountName,
                        'amount' => $amount,
                    ];
                }

                // Convert the associative array to indexed array
                $output = array_values($output);

                // dd($output);

                // Pass the data to the view
                return view('super_admin.core_accounting.account_reports.sub_ac_ledger', [
                    'subsidiaryAccounts' => $subsidiaryAccounts,
                    'ledgerData' => $output,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'subsidiaryAcId' => $subsidiaryAcId
                ]);
            } else {
                return view('super_admin.core_accounting.account_reports.sub_ac_ledger', [
                    'subsidiaryAccounts' => $subsidiaryAccounts,
                    'ledgerData' => null,
                    'startDate' => null,
                    'endDate' => null,
                ]);
            }
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
                    ->pluck('ac_head.ac_head_name_eng')
                    ->toArray();
                // dd($ac_head_names);
                $ledgerData = DB::table('voucher_entry')
                    ->whereBetween('voucher_date', [$startDate, $endDate])
                    ->select('voucher_no', 'description', 'dr_amount', 'cr_amount', 'voucher_date')
                    ->whereIn('status', ['pending', 'Done'])
                    ->get();
                // dd($ledgerData);
                
                $filteredLedgerData = $this->ledgerDataManupulation($ledgerData, "", $ac_head_names);
                $filteredLedgerData2 = [];

                foreach ($filteredLedgerData as $item) {
                    $voucherNo = $item->voucher_no;
                    $description = $item->description;
                    $voucherDate = $item->voucher_date;

                    // Initialize arrays for DR and CR data
                    $drData = [];
                    $crData = [];

                    foreach ($item->dr_amount as $drItem) {
                        $drId = $drItem->id;
                        $drName = $drItem->name;
                        $drAmount = $drItem->amount;

                        // Add DR data to the DR array
                        $drData[] = [
                            'id' => $drId,
                            'name' => $drName,
                            'amount' => $drAmount,
                        ];
                    }

                    foreach ($item->cr_amount as $crItem) {
                        $crId = $crItem->id;
                        $crName = $crItem->name;
                        $crAmount = $crItem->amount;

                        // Add CR data to the CR array
                        $crData[] = [
                            'id' => $crId,
                            'name' => $crName,
                            'amount' => $crAmount,
                        ];
                    }

                    // Add the extracted data to $filteredLedgerData2
                    $filteredLedgerData2[] = [
                        'voucher_no' => $voucherNo,
                        'description' => $description,
                        'voucher_date' => $voucherDate,
                        'dr_amount' => $drData,
                        'cr_amount' => $crData,
                    ];
                }

                $totals = [];
                foreach ($ac_head_names as $name) {
                    $total = 0;
                
                    foreach ($filteredLedgerData2 as $entry) {
                        foreach ($entry["dr_amount"] as $dr) {
                            if ($dr["name"] === $name) {
                                $total += floatval($dr["amount"]);
                            }
                        }
                
                        foreach ($entry["cr_amount"] as $cr) {
                            if ($cr["name"] === $name) {
                                $total -= floatval($cr["amount"]);
                            }
                        }
                    }
                
                    $totals[] = [
                        "name" => $name,
                        "amount" => $total
                    ];
                }
                
                // Remove entries with zero amounts
                $totals = array_filter($totals, function ($item) {
                    return floatval($item["amount"]) != 0;
                });
                
                // Convert the result into a list of associative arrays
                // $result = array_values($totals);
                // dd($totals);
                // Output the filtered ledger data
                return view('super_admin.core_accounting.account_reports.control_ac_ledger', ['ledgerData' => $totals, 'accounts' => $accounts, 'controlACName' => $selectedAccountName, 'startDate' => $startDate, 'endDate' => $endDate]);
            }

            // Handle GET request
            return view('super_admin.core_accounting.account_reports.control_ac_ledger', ['accounts' => $accounts, 'ledgerData' => null]);
            // return view('super_admin.core_accounting.account_reports.control_ac_ledger');
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function acHeadLedgerView(Request $request)
    {
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
                // dd($ledgerData);
                // dd($selectedAccountName);
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
                $ledgerData = $filteredLedgerData;
                $numbers = [];
                // dd($ledgerData);
                foreach ($ledgerData as $key => $item) {
                    if (strpos($item->voucher_no, 'r_') !== false && strpos($item->description, 'Multiple vouchers added:') !== false) {
                        $item_voucher_no = $item->voucher_no;
                        // Extract numbers using regular expression
                        preg_match_all('/memo-(\d+)/', $item->description, $matches);
                        if (isset($matches[1])) {
                            $numbers = $matches[1];
                        }
                        $numbers = array_unique($numbers);
                        // dd($item);
                        if ($numbers) {
                            $r_data_table = DB::table('collection_entry')
                                ->whereIn('id', $numbers)
                                ->select('id', 'dr_amount', 'cr_amount', 'collection_date')
                                ->get();
                            // dd($r_data_table);
                            $filtered_r_Data = $r_data_table->map(function ($item) use ($selectedAccountName, $item_voucher_no) {
                                // Decode the JSON strings in dr_amount and cr_amount columns
                                $drAmount = json_decode($item->dr_amount);
                                $crAmount = json_decode($item->cr_amount);

                                // Check if any name in $selectedAccountName exists in $drAmount
                                $dr_hasMatch = false;

                                foreach ($drAmount as $item1) {
                                    if ($item1->name === $selectedAccountName) {
                                        $dr_hasMatch = true;
                                        break;
                                    }
                                }

                                if ($dr_hasMatch) {
                                    // Filter $drAmount based on $selectedAccountName
                                    $drAmount = array_filter($drAmount, function ($item1) use ($selectedAccountName) {
                                        return $item1->name === $selectedAccountName;
                                    });
                                } else {
                                    // If there's no match, set $drAmount to an empty array
                                    $drAmount = [];
                                }
                                // $crAmount = $this->filterByName($crAmount, $selectedAccountName);
                                $cr_hasMatch = false;

                                foreach ($crAmount as $item1) {
                                    if ($item1->name === $selectedAccountName) {
                                        $cr_hasMatch = true;
                                        break;
                                    }
                                }

                                if ($cr_hasMatch) {
                                    // Filter $drAmount based on $selectedAccountName
                                    $crAmount = array_filter($crAmount, function ($item1) use ($selectedAccountName) {
                                        return $item1->name === $selectedAccountName;
                                    });
                                } else {
                                    // If there's no match, set $drAmount to an empty array
                                    $crAmount = [];
                                }
                
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
                
                $openningBalance = 0;
                $sortedLedgerData = $ledgerData->sortBy('voucher_date')->values()->all();
                // Output the filtered ledger data
                return view('super_admin.core_accounting.account_reports.ac_head_ledger', ['ledgerData' => $sortedLedgerData, 'accounts' => $accounts, 'selectedAccountName' => $selectedAccountName, 'startDate' => $startDate, 'endDate' => $endDate, 'openningBalance' => $openningBalance]);
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

                // dd($name);

                // $ledgerData = DB::table('voucher_entry')
                //     ->whereBetween('voucher_date', [$startDate, $endDate])
                //     ->select('voucher_no', 'description', 'voucher_date', 'dr_amount', 'cr_amount')
                //     ->whereIn('status', ['pending', 'Done'])
                //     ->whereIn('voucher_type', ['Journal', 'Receipt Voucher', 'Advanced Payment', 'Adjustment'])
                //     ->get();

                // $ledgerData = DB::table('voucher_entry')
                //     ->select('voucher_no', 'description', 'voucher_date', 'dr_amount', 'cr_amount')
                //     ->whereBetween('voucher_date', [$startDate, $endDate])
                //     ->whereIn('status', ['pending', 'Done', 'Pending'])
                //     ->where(function ($query) use ($name) {
                //         $query->where(function ($query) use ($name) {
                //             $query->where('voucher_type', 'Journal')
                //                 ->where('party', $name);
                //         })->orWhereIn('voucher_type', ['Receipt Voucher', 'Advanced Payment', 'Adjustment']);
                //     })
                //     ->get();
                $ledgerData = DB::table('voucher_entry')
                    ->select('voucher_no', 'description', 'voucher_date', 'dr_amount', 'cr_amount')
                    ->whereBetween('voucher_date', [$startDate, $endDate])
                    ->whereIn('status', ['pending', 'Done', 'Pending'])
                    ->where(function ($query) use ($name) {
                        $query->where(function ($query) use ($name) {
                            $query->where('voucher_type', 'Journal')
                                ->where('party', $name);
                        })->orWhere(function ($query) use ($name) {
                            $query->where('voucher_type', 'Receipt Voucher')
                                ->where(function ($query) use ($name) {
                                    $query->where(function ($query) use ($name) {
                                        $query->where(function ($query) use ($name) {
                                            $query->where('description', 'not like', 'Multiple vouchers added:%')
                                                ->where('description', 'not like', 'Voucher ID:%')
                                                ->where('party', $name);
                                        })->orWhere(function ($query) {
                                            $query->where(function ($query) {
                                                $query->where('description', 'like', 'Multiple vouchers added:%')
                                                    ->orWhere('description', 'like', 'Voucher ID:%');
                                            });
                                        });
                                    });
                                });
                        })->orWhere(function ($query) {
                            $query->whereIn('voucher_type', ['Advanced Payment', 'Adjustment']);
                        });
                    })
                    ->get();

                $selectedAccountName = [
                    "Bills Receivable Of Rent & Lease",
                    "Bills Receivable Of Processing",
                    "Bills Receivable Of Marine Workshop",
                    "Bills Receivable Of Electric",
                    "Bills Receivable Of Water",
                    "Bills Receivable Of  T-head Jetty",
                    "Bills Receivable Of Multichannel Slipway",
                    "Bills Receivable Of Water  ( T-head Jetty)"
                ];
                // dd($ledgerData);
                $sortedLedgerData = $this->ledgerDataManupulation($ledgerData, $name, $selectedAccountName);
                // dd($sortedLedgerData);
                return view('super_admin.core_accounting.account_reports.party_ledger')->with('ledgerData', $sortedLedgerData)->with('parties', $parties)->with('partyName', $name)->with('startDate', $startDate)->with('endDate', $endDate);
            } else {
                $parties = party::all();
                return view('super_admin.core_accounting.account_reports.party_ledger')->with('ledgerData', null)->with('data2', null)->with('parties', $parties);
            }
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function ledgerDataManupulation($ledgerData, $name1, $selectedAccountName){
        $filteredData = [];
        foreach ($ledgerData as $key => $item) {
            $numbers = [];
            // dd($ledgerData);
            if (strpos($item->voucher_no, 'r_') !== false && strpos($item->description, 'Multiple vouchers added:') !== false) {
                $item_voucher_no = $item->voucher_no;
                // Extract numbers using regular expression
                // dd($item->description);
                preg_match_all('/memo-(\d+)/', $item->description, $matches);
                $numbers = array_merge($numbers, $matches[1]);
                foreach ($numbers as &$number) {
                    $number = (int)$number;
                }
                // dd($numbers);
                if ($numbers) {
                    if($name1 != "") {
                        $r_data_table = DB::table('collection_entry')
                            ->whereIn('id', $numbers)
                            ->select('id', 'dr_amount', 'cr_amount', 'collection_date')
                            ->where('customer_name', $name1)
                            ->get();
                    } else {
                        $r_data_table = DB::table('collection_entry')
                            ->whereIn('id', $numbers)
                            ->select('id', 'dr_amount', 'cr_amount', 'collection_date')
                            ->get();
                        // dd($name1);
                    }
                    
                    // dd($r_data_table);
                    $filtered_r_Data = $r_data_table->map(function ($item) use ($selectedAccountName, $item_voucher_no) {
                        // Decode the JSON strings in dr_amount and cr_amount columns
                        $drAmount = json_decode($item->dr_amount);
                        $crAmount = json_decode($item->cr_amount);
                        
                        // Check if any name in $selectedAccountName exists in $drAmount
                        $dr_hasMatch = false;
                        // dd($drAmount);
                        foreach ($drAmount as $item1) {
                            if (in_array(strtolower($item1->name), array_map('strtolower', $selectedAccountName))) {
                                $dr_hasMatch = true;
                                break;
                            }
                        }
                        // dd($dr_hasMatch);
                        if ($dr_hasMatch) {
                            // Filter $drAmount based on $selectedAccountName
                            $drAmount = array_filter($drAmount, function ($item1) use ($selectedAccountName) {
                                return in_array($item1->name, $selectedAccountName);
                            });
                        } else {
                            // If there's no match, set $drAmount to an empty array
                            $drAmount = [];
                        }
                        // $crAmount = $this->filterByName($crAmount, $selectedAccountName);
                        $cr_hasMatch = false;
                        
                        foreach ($crAmount as $item1) {
                            if (in_array(strtolower($item1->name), array_map('strtolower', $selectedAccountName))) {
                                // dd($item1);
                                $cr_hasMatch = true;
                                break;
                            }
                        }
                        // dd($cr_hasMatch);
                        // if($item->id == "25") {
                        //     dd($crAmount);
                        // }
                        if ($cr_hasMatch) {
                            // Filter $drAmount based on $selectedAccountName
                            $crAmount = array_filter($crAmount, function ($item) use ($selectedAccountName) {
                                return in_array($item->name, $selectedAccountName);
                            });
                        } else {
                            // If there's no match, set $drAmount to an empty array
                            $crAmount = [];
                        }
                        // if($item->id == "25") {
                        //     dd($crAmount);
                        // }
                        
                        // dd($drAmount);
                        // Convert dr_amount and cr_amount to collections
                        $drAmountCollection = collect($drAmount);
                        $crAmountCollection = collect($crAmount);
                        // if($item->id == "25") {
                        //     dd($crAmountCollection);
                        // }
                        return [
                            'voucher_no' => $item_voucher_no,
                            'description' => "Memo-" . $item->id,
                            'dr_amount' => $drAmountCollection,
                            'cr_amount' => $crAmountCollection,
                            'voucher_date' => $item->collection_date,
                        ];
                    });
                    // dd($filtered_r_Data);

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
                $filteredData = $ledgerData;
            } else if (strpos($item->voucher_no, 'r_') !== false && strpos($item->description, 'Voucher ID: ') !== false) {
                $item_voucher_no = $item->voucher_no;
                $numbers = [];
                // Extract numbers using regular expression
                preg_match_all('/memo-(\d+)/', $item->description, $matches);
                $numbers = array_merge($numbers, $matches[1]);
                if ($numbers) {
                    if($name1 != "") {
                        $r_data_table = DB::table('collection_entry')
                            ->whereIn('id', $numbers)
                            ->select('id', 'dr_amount', 'cr_amount', 'collection_date')
                            ->where('customer_name', $name1)
                            ->get();
                    } else {
                        $r_data_table = DB::table('collection_entry')
                            ->whereIn('id', $numbers)
                            ->select('id', 'dr_amount', 'cr_amount', 'collection_date')
                            ->get();
                    }
                        // $selectedAccountName = ["Bills Receivable of Marine Workshop", "Bills Receivable of Multichannel Slipway", "Bills Receivable of T-Head Jetty", "Bills Receivable of Processing", "Bills Receivable of Rent Lease", "Bills Receivable of Electricity", "Bills Receivable of Water", "Bills Receivable of Water (T-Head Jetty)"];
                    $filtered_r_Data = $r_data_table->map(function ($item) use ($selectedAccountName, $item_voucher_no) {
                        // Decode the JSON strings in dr_amount and cr_amount columns
                        $drAmount = json_decode($item->dr_amount);
                        $crAmount = json_decode($item->cr_amount);
        
                        // Check if the search keyword exists in either dr_amount or cr_amount
                        // $drAmount = $this->filterByName($drAmount, $selectedAccountName);
                        // Check if any name in $selectedAccountName exists in $drAmount
                        $dr_hasMatch = false;

                        foreach ($drAmount as $item1) {
                            if (in_array(strtolower($item1->name), array_map('strtolower', $selectedAccountName))) {
                                $dr_hasMatch = true;
                                break;
                            }
                        }

                        if ($dr_hasMatch) {
                            // Filter $drAmount based on $selectedAccountName
                            $drAmount = array_filter($drAmount, function ($item1) use ($selectedAccountName) {
                                return in_array($item1->name, $selectedAccountName);
                            });
                        } else {
                            // If there's no match, set $drAmount to an empty array
                            $drAmount = [];
                        }
                        // $crAmount = $this->filterByName($crAmount, $selectedAccountName);
                        $cr_hasMatch = false;

                        foreach ($crAmount as $item1) {
                            if (in_array(strtolower($item1->name), array_map('strtolower', $selectedAccountName))) {
                                $cr_hasMatch = true;
                                break;
                            }
                        }

                        if ($cr_hasMatch) {
                            // Filter $drAmount based on $selectedAccountName
                            $crAmount = array_filter($crAmount, function ($item) use ($selectedAccountName) {
                                return in_array($item->name, $selectedAccountName);
                            });
                        } else {
                            // If there's no match, set $drAmount to an empty array
                            $crAmount = [];
                        }
        
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
                $filteredData = $ledgerData;
            } else if (strpos($item->voucher_no, 'a_') !== false || strpos($item->voucher_no, 'p_') !== false) {
                // dd($item->voucher_no);
                $a_data_table = DB::table('voucher_entry')
                    ->where('voucher_no', $item->voucher_no)
                    ->select('voucher_no', 'dr_amount', 'cr_amount', 'description', 'voucher_date')
                    ->get();
                

                // dd($a_data_table);
                $item_voucher_no = $item->voucher_no;

                // dd($a_data_table);
                $filtered_r_Data = $a_data_table->map(function ($item) use ($selectedAccountName, $item_voucher_no) {
                    // Decode the JSON strings in dr_amount and cr_amount columns
                    $drAmount = json_decode($item->dr_amount);
                    $crAmount = json_decode($item->cr_amount);

                    // Check if any name in $selectedAccountName exists in $drAmount
                    $dr_hasMatch = false;

                    foreach ($drAmount as $item1) {
                        if (in_array(strtolower($item1->name), array_map('strtolower', $selectedAccountName))) {
                            $dr_hasMatch = true;
                            break;
                        }
                    }

                    if ($dr_hasMatch) {
                        // Filter $drAmount based on $selectedAccountName
                        $drAmount = array_filter($drAmount, function ($item1) use ($selectedAccountName) {
                            return in_array($item1->name, $selectedAccountName);
                        });
                    } else {
                        // If there's no match, set $drAmount to an empty array
                        $drAmount = [];
                    }
                    
                    $cr_hasMatch = false;

                    foreach ($crAmount as $item1) {
                        if (in_array(strtolower($item1->name), array_map('strtolower', $selectedAccountName))) {
                            $cr_hasMatch = true;
                            break;
                        }
                    }

                    if ($cr_hasMatch) {
                        // Filter $drAmount based on $selectedAccountName
                        $crAmount = array_filter($crAmount, function ($item) use ($selectedAccountName) {
                            return in_array($item->name, $selectedAccountName);
                        });
                    } else {
                        // If there's no match, set $drAmount to an empty array
                        $crAmount = [];
                    }
    
                    // Convert dr_amount and cr_amount to collections
                    $drAmountCollection = json_decode(collect($drAmount));
                    $crAmountCollection = json_decode(collect($crAmount));
                    return [
                        'voucher_no' => $item_voucher_no,
                        'description' => $item->description,
                        'dr_amount' => $drAmountCollection,
                        'cr_amount' => $crAmountCollection,
                        'voucher_date' => $item->voucher_date,
                    ];
                });
                // dd($filtered_r_Data);

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
                $filteredData = $ledgerData;
                // dd($ledgerData);
            } else if (strpos($item->voucher_no, 'j_') !== false) {
                $item_voucher_no = $item->voucher_no;

                // $selectedAccountName = ["Bills Receivable of Marine Workshop", "Bills Receivable of Multichannel Slipway", "Bills Receivable of T-Head Jetty", "Bills Receivable of Processing", "Bills Receivable of Rent Lease", "Bills Receivable of Electricity", "Bills Receivable of Water", "Bills Receivable of Water (T-Head Jetty)"];

                    // Decode the JSON strings in dr_amount and cr_amount columns
                    $drAmount = json_decode($item->dr_amount);
                    $crAmount = json_decode($item->cr_amount);
                    
                    // Check if any name in $selectedAccountName exists in $drAmount
                    $dr_hasMatch = false;

                    foreach ($drAmount as $item1) {
                        if (in_array(strtolower($item1->name), array_map('strtolower', $selectedAccountName))) {
                            $dr_hasMatch = true;
                            break;
                        }
                    }

                    if ($dr_hasMatch) {
                        // Filter $drAmount based on $selectedAccountName
                        $drAmount = array_filter($drAmount, function ($item1) use ($selectedAccountName) {
                            return in_array($item1->name, $selectedAccountName);
                        });
                    } else {
                        // If there's no match, set $drAmount to an empty array
                        $drAmount = [];
                    }
                    // $crAmount = $this->filterByName($crAmount, $selectedAccountName);
                    $cr_hasMatch = false;

                    foreach ($crAmount as $item1) {
                        if (in_array(strtolower($item1->name), array_map('strtolower', $selectedAccountName))) {
                            $cr_hasMatch = true;
                            break;
                        }
                    }

                    if ($cr_hasMatch) {
                        // Filter $drAmount based on $selectedAccountName
                        $crAmount = array_filter($crAmount, function ($item) use ($selectedAccountName) {
                            return in_array($item->name, $selectedAccountName);
                        });
                    } else {
                        // If there's no match, set $drAmount to an empty array
                        $crAmount = [];
                    }
                    
                    // Convert dr_amount and cr_amount to collections
                    $drAmountCollection = collect($drAmount);
                    $crAmountCollection = collect($crAmount);
                    $filtered_r_Data[] = [
                        'voucher_no' => $item_voucher_no,
                        'description' => $item->description,
                        'dr_amount' => $drAmountCollection,
                        'cr_amount' => $crAmountCollection,
                        'voucher_date' => $item->voucher_date,
                    ];
                // dd($filtered_r_Data);

                $filteredCollection = $ledgerData->filter(function ($item) use ($item_voucher_no) {
                    // Check if $item is an object (assuming objects have a 'voucher_no' property)
                    if (is_object($item) && property_exists($item, 'voucher_no')) {
                        return $item->voucher_no !== $item_voucher_no;
                    }
                    
                    // If $item is not an object or does not have a 'voucher_no' property, keep it
                    return true;
                });

                // dd($filteredCollection);
    
                // Add the items from $filtered_r_Data to $ledgerData
                $ledgerData = $filteredCollection->concat($filtered_r_Data);

                foreach ($ledgerData as $key => $element) {
                    if (is_array($element)) {
                        // Convert the array to an object
                        $object = (object) $element;
                        
                        // Replace the old array with the new object
                        $ledgerData[$key] = $object;
                    }
                }
                $filteredData = $ledgerData;
                // dd($ledgerData);
            } else if (strpos($item->voucher_no, 'r_') !== false) {
                if(strpos($item->description, 'Multiple vouchers added:') !== true) {
                    if(strpos($item->description, 'Voucher ID: ') !== true) {
                        $item_voucher_no = $item->voucher_no;
                        // $selectedAccountName = ["Bills Receivable of Marine Workshop", "Bills Receivable of Multichannel Slipway", "Bills Receivable of T-Head Jetty", "Bills Receivable of Processing", "Bills Receivable of Rent Lease", "Bills Receivable of Electricity", "Bills Receivable of Water", "Bills Receivable of Water (T-Head Jetty)"];

                            // Decode the JSON strings in dr_amount and cr_amount columns
                            $drAmount = json_decode($item->dr_amount);
                            $crAmount = json_decode($item->cr_amount);
                            
                            // Check if any name in $selectedAccountName exists in $drAmount
                            $dr_hasMatch = false;

                            foreach ($drAmount as $item1) {
                                if (in_array(strtolower($item1->name), array_map('strtolower', $selectedAccountName))) {
                                    $dr_hasMatch = true;
                                    break;
                                }
                            }

                            if ($dr_hasMatch) {
                                // Filter $drAmount based on $selectedAccountName
                                $drAmount = array_filter($drAmount, function ($item1) use ($selectedAccountName) {
                                    return in_array($item1->name, $selectedAccountName);
                                });
                            } else {
                                // If there's no match, set $drAmount to an empty array
                                $drAmount = [];
                            }
                            // $crAmount = $this->filterByName($crAmount, $selectedAccountName);
                            $cr_hasMatch = false;

                            foreach ($crAmount as $item1) {
                                if (in_array(strtolower($item1->name), array_map('strtolower', $selectedAccountName))) {
                                    $cr_hasMatch = true;
                                    break;
                                }
                            }

                            if ($cr_hasMatch) {
                                // Filter $drAmount based on $selectedAccountName
                                $crAmount = array_filter($crAmount, function ($item) use ($selectedAccountName) {
                                    return in_array($item->name, $selectedAccountName);
                                });
                            } else {
                                // If there's no match, set $drAmount to an empty array
                                $crAmount = [];
                            }
                            
                            // Convert dr_amount and cr_amount to collections
                            $drAmountCollection = collect($drAmount);
                            $crAmountCollection = collect($crAmount);
                            $filtered_r_Data[] = [
                                'voucher_no' => $item_voucher_no,
                                'description' => $item->description,
                                'dr_amount' => $drAmountCollection,
                                'cr_amount' => $crAmountCollection,
                                'voucher_date' => $item->voucher_date,
                            ];
                        // dd($filtered_r_Data);

                        $filteredCollection = $ledgerData->filter(function ($item) use ($item_voucher_no) {
                            // Check if $item is an object (assuming objects have a 'voucher_no' property)
                            if (is_object($item) && property_exists($item, 'voucher_no')) {
                                return $item->voucher_no !== $item_voucher_no;
                            }
                            
                            // If $item is not an object or does not have a 'voucher_no' property, keep it
                            return true;
                        });
            
                        // Add the items from $filtered_r_Data to $ledgerData
                        $ledgerData = $filteredCollection->concat($filtered_r_Data);

                        foreach ($ledgerData as $key => $element) {
                            if (is_array($element)) {
                                // Convert the array to an object
                                $object = (object) $element;
                                
                                // Replace the old array with the new object
                                $ledgerData[$key] = $object;
                            }
                        }
                        $filteredData = $ledgerData;
                        // dd($ledgerData);
                    }
                }
            }
        }
        // dd($filteredData, $ledgerData);
        $uniqueCombinations = []; // To store unique combinations of voucher_no, description, and voucher_date
        $filteredData5 = []; // To store the filtered data without duplicates
        // dd($filteredData);
        foreach ($filteredData as $item) {
            $combination = $item->voucher_no . $item->description . $item->voucher_date;

            if (!isset($uniqueCombinations[$combination])) {
                $uniqueCombinations[$combination] = true;
                $filteredData5[] = $item;
            }
        }

        // dd($filteredData5);

        $dataArray = array_map(function ($item) use ($selectedAccountName) {
            // Filter dr_amount if it exists and is an array
            if (property_exists($item, "dr_amount") && is_array($item->dr_amount)) {
                $item->dr_amount = array_filter($item->dr_amount, function ($drItem) use ($selectedAccountName) {
                    return property_exists($drItem, "name") && in_array($drItem->name, $selectedAccountName);
                });
            }

            // Filter cr_amount if it exists and is an array
            if (property_exists($item, "cr_amount") && is_array($item->cr_amount)) {
                $item->cr_amount = array_filter($item->cr_amount, function ($crItem) use ($selectedAccountName) {
                    return property_exists($crItem, "name") && in_array($crItem->name, $selectedAccountName);
                });
            }

            return $item;
        }, $filteredData5);
        // dd($dataArray);
        $dataCollection = collect($dataArray);
        // dd($dataCollection);
        
        $sortedLedgerData = $dataCollection->sortBy('voucher_date')->values()->all();
        // dd($sortedLedgerData);
        return $sortedLedgerData;
    }

    public function transformElement($element) {
        // Remove "id" and "status"
        unset($element["id"], $element["status"]);
        
        // Rename "collection_date" to "voucher_date"
        $element["voucher_date"] = $element["collection_date"];
        unset($element["collection_date"]);
        
        // Rename "customer_name" to "party"
        $element["party"] = $element["customer_name"];
        unset($element["customer_name"]);
        
        return $element;
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
    
            if ($request->isMethod('post')) {
                // Retrieve form input values
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                $final_data = $this->profitLossCalculation($startDate, $endDate);

                return view('super_admin.core_accounting.account_reports.profit_loss_account', [
                        'data' => $final_data,
                        'startDate' => $startDate,
                        'endtDate' => $endDate
                ]);
            } else {
                return view('super_admin.core_accounting.account_reports.profit_loss_account', [
                    'data' => [],
                    'startDate' => $startDate,
                    'endtDate' => $endDate
                ]);
            }
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function profitLossCalculation($startDate, $endDate) {
        $all_contol_names = control_ac::distinct()
            ->select('accounts_group', 'subsidiary_account_name', 'account_name')
            ->whereIn('subsidiary_account_name', ['Sales and Services', 'Services', 'Operational Expenditure'])
            ->get()
            ->toArray();
        
        $leftover_contol_names = control_ac::distinct()
            ->select('accounts_group', 'subsidiary_account_name', 'account_name')
            ->whereIn('subsidiary_account_name', ['Others Income', 'Non-operating Expenses', 'Administrative Expenditure'])
            ->get()
            ->toArray();
        // dd($all_contol_names);
        $ledgerData = DB::table('voucher_entry')
            ->whereBetween('voucher_date', [$startDate, $endDate])
            ->select('voucher_no', 'description', 'dr_amount', 'cr_amount', 'voucher_date')
            ->whereIn('status', ['pending', 'Done'])
            ->get();

        $tradingProfit[] = [
            'account_group' => 'Income',
            'subsidiary_account_name' => 'Others Income',
            'name' => 'Trading Profit',
            'amount' => $this->tradingAccountReutrnForProfitAndLoss($all_contol_names, $ledgerData)
        ];

        $final_data = [];
        foreach ($leftover_contol_names as $all_contol_name) {
            $acHeadNames = account_head::distinct()
                ->select('ac_head.ac_head_name_eng')
                ->join('control_ac', 'ac_head.control_ac_id', '=', 'control_ac.account_id')
                ->join('subsidiary_ac', 'control_ac.subsidiary_account_name', '=', 'subsidiary_ac.account_name')
                ->where('subsidiary_ac.account_name', '=', $all_contol_name['subsidiary_account_name'])
                ->get()
                ->pluck('ac_head_name_eng')
                ->toArray();

            $controlACNames = account_head::distinct()
                ->select('ac_head.ac_head_name_eng', 'control_ac.account_name')
                ->join('control_ac', 'ac_head.control_ac_id', '=', 'control_ac.account_id')
                ->join('subsidiary_ac', 'control_ac.subsidiary_account_name', '=', 'subsidiary_ac.account_name')
                ->where('subsidiary_ac.account_name', '=', $all_contol_name['subsidiary_account_name'])
                ->get()
                ->toArray();
            
            $filteredLedgerData = $this->ledgerDataManupulation($ledgerData, "", $acHeadNames);

            $totals = [];
            foreach ($acHeadNames as $name) {
                $total = 0;
            
                foreach ($filteredLedgerData as $entry) {
                    foreach ($entry->dr_amount as $dr) {
                        if ($dr->name === $name) {
                            $total += floatval($dr->amount);
                        }
                    }
            
                    foreach ($entry->cr_amount as $cr) {
                        if ($cr->name === $name) {
                            $total -= floatval($cr->amount);
                        }
                    }
                }
            
                $totals[] = [
                    "name" => $name,
                    "amount" => $total
                ];
            }
            
            // Remove entries with zero amounts
            $totals = array_filter($totals, function ($item) {
                return floatval($item["amount"]) != 0;
            });

            $accumulatedAmounts = [];

            // Loop through data2 to accumulate amounts
            foreach ($totals as $item2) {
                $name2 = $item2['name'];
                $amount2 = $item2['amount'];

                // Find the corresponding "ac_head_name_eng" in data1
                $matchingItem1 = null;
                foreach ($controlACNames as $item1) {
                    if ($item1['ac_head_name_eng'] === $name2) {
                        $matchingItem1 = $item1;
                        break;
                    }
                }

                if ($matchingItem1) {
                    $accountName = $matchingItem1['account_name'];
                    // Accumulate the amount based on "account_name"
                    if (!isset($accumulatedAmounts[$accountName])) {
                        $accumulatedAmounts[$accountName] = 0;
                    }
                    $accumulatedAmounts[$accountName] += $amount2;
                }
            }

            // Create the final output array
            $output = [];
            foreach ($accumulatedAmounts as $accountName => $amount) {
                $output[] = [
                    'account_group' => $all_contol_name['accounts_group'],
                    'subsidiary_account_name' => $all_contol_name['subsidiary_account_name'],
                    'name' => $accountName,
                    'amount' => $amount,
                ];
            }

            // Convert the associative array to indexed array
            $output = array_values($output);
            $final_data = array_merge($final_data, $output);
            // dd($output);
        }

        $uniqueData = [];
        foreach ($final_data as $item) {
            $key = $item['account_group'] . $item['subsidiary_account_name'] . $item['name'] . $item['amount'];
            if (!isset($uniqueData[$key])) {
                $uniqueData[$key] = $item;
            }
        }

        $final_data = array_values($uniqueData);
        $consolidatedData = array_merge($tradingProfit, $final_data);
        // dd($consolidatedData);
        return $consolidatedData;
    }

    public function tradingAccountReutrnForProfitAndLoss($all_contol_names, $ledgerData) {
        $final_data = [];

        foreach ($all_contol_names as $all_contol_name) {
            $acHeadNames = account_head::distinct()
                ->select('ac_head.ac_head_name_eng')
                ->join('control_ac', 'ac_head.control_ac_id', '=', 'control_ac.account_id')
                ->join('subsidiary_ac', 'control_ac.subsidiary_account_name', '=', 'subsidiary_ac.account_name')
                ->where('subsidiary_ac.account_name', '=', $all_contol_name['subsidiary_account_name'])
                ->get()
                ->pluck('ac_head_name_eng')
                ->toArray();

            $controlACNames = account_head::distinct()
                ->select('ac_head.ac_head_name_eng', 'control_ac.account_name')
                ->join('control_ac', 'ac_head.control_ac_id', '=', 'control_ac.account_id')
                ->join('subsidiary_ac', 'control_ac.subsidiary_account_name', '=', 'subsidiary_ac.account_name')
                ->where('subsidiary_ac.account_name', '=', $all_contol_name['subsidiary_account_name'])
                ->get()
                ->toArray();
            
            $filteredLedgerData = $this->ledgerDataManupulation($ledgerData, "", $acHeadNames);

            $totals = [];
            foreach ($acHeadNames as $name) {
                $total = 0;
            
                foreach ($filteredLedgerData as $entry) {
                    foreach ($entry->dr_amount as $dr) {
                        if ($dr->name === $name) {
                            $total += floatval($dr->amount);
                        }
                    }
            
                    foreach ($entry->cr_amount as $cr) {
                        if ($cr->name === $name) {
                            $total -= floatval($cr->amount);
                        }
                    }
                }
            
                $totals[] = [
                    "name" => $name,
                    "amount" => $total
                ];
            }
            
            // Remove entries with zero amounts
            $totals = array_filter($totals, function ($item) {
                return floatval($item["amount"]) != 0;
            });

            $accumulatedAmounts = [];

            // Loop through data2 to accumulate amounts
            foreach ($totals as $item2) {
                $name2 = $item2['name'];
                $amount2 = $item2['amount'];

                // Find the corresponding "ac_head_name_eng" in data1
                $matchingItem1 = null;
                foreach ($controlACNames as $item1) {
                    if ($item1['ac_head_name_eng'] === $name2) {
                        $matchingItem1 = $item1;
                        break;
                    }
                }

                if ($matchingItem1) {
                    $accountName = $matchingItem1['account_name'];
                    // Accumulate the amount based on "account_name"
                    if (!isset($accumulatedAmounts[$accountName])) {
                        $accumulatedAmounts[$accountName] = 0;
                    }
                    $accumulatedAmounts[$accountName] += $amount2;
                }
            }

            // Create the final output array
            $output = [];
            foreach ($accumulatedAmounts as $accountName => $amount) {
                $output[] = [
                    'account_group' => $all_contol_name['accounts_group'],
                    'subsidiary_account_name' => $all_contol_name['subsidiary_account_name'],
                    'name' => $accountName,
                    'amount' => $amount,
                ];
            }

            // Convert the associative array to indexed array
            $output = array_values($output);
            $final_data = array_merge($final_data, $output);
            // dd($output);
        }

        $uniqueData = [];
        $total_amount = 0;
        foreach ($final_data as $item) {
            $key = $item['account_group'] . $item['subsidiary_account_name'] . $item['name'] . $item['amount'];
            if (!isset($uniqueData[$key])) {
                $uniqueData[$key] = $item;
            }
        }

        foreach ($uniqueData as $item) {
            $total_amount = $total_amount + $item['amount'];
        }

        return $total_amount;
    }

    public function trandingAccountView(Request $request)
    {
        if (Auth::check()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
    
            if ($request->isMethod('post')) {
                // Retrieve form input values
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                $final_data = $this->tradingAccountCalculation($startDate, $endDate);
                // dd($final_data);
                return view('super_admin.core_accounting.account_reports.tranding_account', [
                        'data' => $final_data,
                        'startDate' => $startDate,
                        'endtDate' => $endDate
                ]);
            } else {
                return view('super_admin.core_accounting.account_reports.tranding_account', [
                    'data' => [],
                    'startDate' => $startDate,
                    'endtDate' => $endDate
                ]);
            }
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function tradingAccountCalculation($startDate, $endDate) {
        $all_contol_names = control_ac::distinct()
            ->select('accounts_group', 'subsidiary_account_name', 'account_name')
            ->whereIn('subsidiary_account_name', ['Sales and Services', 'Services', 'Operational Expenditure'])
            ->get()
            ->toArray();
        // dd($all_contol_names);
        $ledgerData = DB::table('voucher_entry')
            ->whereBetween('voucher_date', [$startDate, $endDate])
            ->select('voucher_no', 'description', 'dr_amount', 'cr_amount', 'voucher_date')
            ->whereIn('status', ['pending', 'Done'])
            ->get();

        $final_data = [];

        foreach ($all_contol_names as $all_contol_name) {

            $acHeadNames = account_head::distinct()
                ->select('ac_head.ac_head_name_eng')
                ->join('control_ac', 'ac_head.control_ac_id', '=', 'control_ac.account_id')
                ->join('subsidiary_ac', 'control_ac.subsidiary_account_name', '=', 'subsidiary_ac.account_name')
                ->where('subsidiary_ac.account_name', '=', $all_contol_name['subsidiary_account_name'])
                ->get()
                ->pluck('ac_head_name_eng')
                ->toArray();

            $controlACNames = account_head::distinct()
                ->select('ac_head.ac_head_name_eng', 'control_ac.account_name')
                ->join('control_ac', 'ac_head.control_ac_id', '=', 'control_ac.account_id')
                ->join('subsidiary_ac', 'control_ac.subsidiary_account_name', '=', 'subsidiary_ac.account_name')
                ->where('subsidiary_ac.account_name', '=', $all_contol_name['subsidiary_account_name'])
                ->get()
                ->toArray();
            
            $filteredLedgerData = $this->ledgerDataManupulation($ledgerData, "", $acHeadNames);

            $totals = [];
            foreach ($acHeadNames as $name) {
                $total = 0;
            
                foreach ($filteredLedgerData as $entry) {
                    foreach ($entry->dr_amount as $dr) {
                        if ($dr->name === $name) {
                            $total += floatval($dr->amount);
                        }
                    }
            
                    foreach ($entry->cr_amount as $cr) {
                        if ($cr->name === $name) {
                            $total -= floatval($cr->amount);
                        }
                    }
                }
            
                $totals[] = [
                    "name" => $name,
                    "amount" => $total
                ];
            }
            
            // Remove entries with zero amounts
            $totals = array_filter($totals, function ($item) {
                return floatval($item["amount"]) != 0;
            });

            // dd($totals);

            $accumulatedAmounts = [];

            // Loop through data2 to accumulate amounts
            foreach ($totals as $item2) {
                $name2 = $item2['name'];
                $amount2 = $item2['amount'];

                // Find the corresponding "ac_head_name_eng" in data1
                $matchingItem1 = null;
                foreach ($controlACNames as $item1) {
                    if ($item1['ac_head_name_eng'] === $name2) {
                        $matchingItem1 = $item1;
                        break;
                    }
                }

                if ($matchingItem1) {
                    $accountName = $matchingItem1['account_name'];
                    // Accumulate the amount based on "account_name"
                    if (!isset($accumulatedAmounts[$accountName])) {
                        $accumulatedAmounts[$accountName] = 0;
                    }
                    $accumulatedAmounts[$accountName] += $amount2;
                }
            }

            // Create the final output array
            $output = [];
            foreach ($accumulatedAmounts as $accountName => $amount) {
                $output[] = [
                    'account_group' => $all_contol_name['accounts_group'],
                    'subsidiary_account_name' => $all_contol_name['subsidiary_account_name'],
                    'name' => $accountName,
                    'amount' => $amount,
                ];
            }

            // Convert the associative array to indexed array
            $output = array_values($output);
            $final_data = array_merge($final_data, $output);
            // dd($output);
        }

        $uniqueData = [];

        foreach ($final_data as $item) {
            $key = $item['account_group'] . $item['subsidiary_account_name'] . $item['name'] . $item['amount'];
            
            if (!isset($uniqueData[$key])) {
                $uniqueData[$key] = $item;
            }
        }

        $final_data = array_values($uniqueData);

        return $final_data;
    }

    public function balanceSheetView(Request $request)
    {
        if(Auth::check()){
            if ($request->isMethod('post')) {
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                // $profit_loss_data = $this->profitLossCalculation($startDate, $endDate);
                $profit_loss_data = $this->profitLossCalculation($startDate, $endDate);

                // Create an array to store the totals
                $profit_loss_totals = 0;

                foreach ($profit_loss_data as $pl_data) {
                    $profit_loss_totals += $pl_data["amount"];
                }

                // Create a single entry for "Profit & Loss" with the total amount
                $profit_loss_formattedData = [
                    [
                        "account_group" => "Provision For Adiustiment",
                        "subsidiary_account_name" => "Profit & Loss",
                        "name" => "Profit & Loss",
                        "totalAmount" => $profit_loss_totals,
                    ],
                ];
        
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
                    'profit_loss_formattedData' => $profit_loss_formattedData,
                    'startDate' => $startDate,
                    'endtDate' => $endDate
                ]);
            } else {
    
                return view('super_admin.core_accounting.account_reports.balancesheet', [
                    'data' => '',
                    'fixed_assets_data' => '',
                    'profit_loss_formattedData' => '',
                    'startDate' => '',
                    'endtDate' => ''
                ]);
            }
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
