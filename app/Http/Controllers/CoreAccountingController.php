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
use App\Models\daily_data;
use App\Models\DailyOpeningBalance;
use App\Models\YearlyOpeningBalance;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class CoreAccountingController extends Controller
{
    // Accounting Setups

    /* Subsidiary Accounts CRUD START */
    public function subsidiaryAccountsView()
    {
        if (Auth::check()) {
            $subsidiary_ac = subsidiary_ac::orderBy('created_at', 'desc')->get();

            return view('super_admin.core_accounting.account_setups.subsidiary_account', compact('subsidiary_ac'));
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function subsidiary_ac_post(Request $request)
    {
        // dd($request);
        $request->validate([
            'accounts_group_input' => 'required',
            'subsidiary_ac_id_input' => 'required',
            'subsidiary_ac_name_input' => 'required'
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
            'id_update' => 'required',
            'accounts_group_update' => 'required',
            'subsidiary_ac_id_update' => 'required',
            'subsidiary_ac_name_update' => 'required'
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
        if (Auth::check()) {
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
            'sub_ac_name_input' => 'required',
            'accounts_group_input' => 'required',
            'is_ugc_control_ac' => 'required',
            'is_ugc_priority_input' => 'required',
            'control_ac_name_input' => 'required',
            'control_ac_code_input' => 'required'
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
            'sub_ac_name_update' => 'required',
            'accounts_group_update' => 'required',
            'is_ugc_control_ac_update' => 'required',
            'is_ugc_priority_update' => 'required',
            'control_ac_name_update' => 'required',
            'control_ac_code_update' => 'required'
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
        if (Auth::check()) {
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
        if (Auth::check()) {
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
        if (Auth::check()) {
            return view('super_admin.core_accounting.account_setups.link_heads_setup');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    /* Party CRUD */
    public function partySetupView()
    {
        if (Auth::check()) {
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
        if (Auth::check()) {
            return view('super_admin.core_accounting.budget.budget_entry');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    // Collection
    public function collectionEntryView()
    {
        if (Auth::check()) {
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

    public function collection_entry_delete(Request $request)
    {
        collection_entry::where('id', $request->get('id_delete'))->delete();

        return redirect('collection-entry');
    }

    public function view_details_page($id)
    {
        // dd($id);
        if (Auth::check()) {
            $collection_entry = collection_entry::findOrFail($id);
            // dd($collection_entry);
            return view('super_admin.core_accounting.collections.pdf_collection_entry')->with('collection_entry', $collection_entry);
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    // Vouchers
    public function vouchersEntryView()
    {
        if (Auth::check()) {
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

    public function voucher_details_page($id)
    {
        if (Auth::check()) {
            $voucher_entry = voucher_entry::findOrFail($id);
            return view('super_admin.core_accounting.vouchers.pdf_voucher_entry')->with('voucher_entry', $voucher_entry);
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function voucher_entry_pdf($id)
    {
        if (Auth::check()) {
            $voucher_entry = voucher_entry::findOrFail($id);
            return view('super_admin.core_accounting.vouchers.voucher_entry_pdf_file')->with('voucher_entry', $voucher_entry);
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function vouchers_entry_post(Request $request)
    {
        $request->validate([
            "voucher_type_input" => "required",
            "voucher_no_input" => "required",
            "type_input" => "required",
            "voucher_date_input" => "required",
            "dr_amount_table_ta" => "required",
            "cr_amount_table_ta" => "required",
        ]);
        $voucherDateInput = $request->input('voucher_date_input');

        $accountHeads = control_ac::join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
            ->select('control_ac.accounts_group', 'control_ac.subsidiary_account_name', 'ac_head.ac_head_name_eng')
            ->get();

        $fixed_assets_data = DB::table('control_ac')
            ->join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
            ->select('ac_head.ac_head_name_eng')
            ->whereIn('control_ac.subsidiary_account_name', ['Fixed Assets'])
            ->get();

        $controlACNames = account_head::distinct()
            ->select('ac_head.ac_head_name_eng', 'control_ac.account_name')
            ->join('control_ac', 'ac_head.control_ac_id', '=', 'control_ac.account_id')
            ->join('subsidiary_ac', 'control_ac.subsidiary_account_name', '=', 'subsidiary_ac.account_name')
            ->get()
            ->toArray();

        // $dailyOpening = DailyOpeningBalance::where('date', $voucherDateInput)->pluck('ac_head');
        // $dailyOpeningBalance = json_decode($dailyOpening);

        $dailyOpening = DailyOpeningBalance::where('date', $voucherDateInput)->select('ac_head', 'party')->get();
        $bothOpening = json_decode($dailyOpening);
        $dailyOpeningBalance = (array) $bothOpening[0];

        // dd($a, $dailyOpening, $openingBalance);
        // dd($fixed_assets_data);
        // ::select('ac_head_id', 'ac_head_name_eng')->get();
        $dailyData = daily_data::where('voucher_date', $voucherDateInput)->pluck('ac_head');

        $drAmountJson = $request->input('dr_amount_table_ta');
        $crAmountJson = $request->input('cr_amount_table_ta');

        $drAmountData = json_decode($drAmountJson, true);
        $crAmountData = json_decode($crAmountJson, true);

        $dr_cr_array = [];
        foreach ($drAmountData as $item) {
            $dr_cr_array[] = [
                'name' => $item['name'],
                'amount' => floatval($item['amount']),
            ];
        }

        foreach ($crAmountData as $item) {
            $dr_cr_array[] = [
                'name' => $item['name'],
                'amount' => -floatval($item['amount']), // Make amounts negative
            ];
        }

        $openingBalance = [];
        if ($dailyOpeningBalance['ac_head'] === []) {
            //empty
        } else {
            $a = json_decode($dailyOpeningBalance['ac_head']);
            foreach ($a as $item) {
                $openingBalance[] = (array) $item;
            }
        }
        $dailyOpeningData = $this->matchAndMerge($dr_cr_array, $openingBalance);

        $selectedAccountName = [
            "Bills Receivable Of Rent & Lease",
            "Bills Receivable Of Processing",
            "Bills Receivable of Fish Processing",
            "Bills receivable of Fish Processing",
            "Bills Receivable Of Marine Workshop",
            "Bills Receivable Of Electric",
            "Bills Receivable Of  T-head Jetty",
            "Bills Receivable Of  T-head Jetty",
            "Bills Receivable Of Multichannel Slipway",
            "Bills Receivable Of Water  ( T-head Jetty)",
            "Bills Receivable Of Water T-head jetty",
            "Bills Receivable Of Water  ( T-head Jetty)",
            "Bills receivable of Land and Lease",
            "Bills Receivable Of Water"
        ];

        $totalAmount = 0;
        foreach ($dr_cr_array as $item) {
            if (in_array($item['name'], $selectedAccountName)) {
                $totalAmount += $item['amount'];
            }
        }

        $party_array[] = [
            'name' => $request->input('party_input'),
            'amount' => $totalAmount, // Make amounts negative
        ];
        // dd($party_array);

        $partyOpeningBalance = [];
        if ($dailyOpeningBalance['party'] === [] || $dailyOpeningBalance['party'] === null) {
            //empty
        } else {
            $a = json_decode($dailyOpeningBalance['party']);
            foreach ($a as $item) {
                $partyOpeningBalance[] = (array) $item;
            }
        }
        $partyOpeningData = $this->matchAndMerge($party_array, $partyOpeningBalance);
        // dd($party_array, $partyOpeningBalance, $partyOpeningData);
        // dd($dailyOpeningData, $dr_cr_array, $partyOpeningData);
        if ($dailyOpeningBalance['ac_head'] === [] && $dailyOpeningBalance['party'] === []) {
            $openingDailyData = new DailyOpeningBalance;
            $openingDailyData->date = $voucherDateInput;
            $openingDailyData->ac_head = json_encode(array_values($dailyOpeningData));
            $openingDailyData->party = json_encode(array_values($partyOpeningData));
            $openingDailyData->save();
        } else {
            DailyOpeningBalance::where('date', $voucherDateInput)->update(['ac_head' => json_encode(array_values($dailyOpeningData)), 'party' => json_encode(array_values($partyOpeningData))]);
        }

        // Transform data to final_data format
        $finalDataArray = [];
        $dailyDataArray = [];
        $fixedAsset_DR_amount = 0;
        $fixedAsset_CR_amount = 0;

        if ($drAmountData && !empty($drAmountData)) {
            foreach ($drAmountData as $drItem) {
                $finalDataArray[] = [
                    'name' => $drItem['name'],
                    'amount' => $drItem['amount'],
                    'party_name' => $request->input('party_input'),
                    'type' => 'dr_amount',
                ];
                $desiredAcHead = $accountHeads->Where('ac_head_name_eng', $drItem['name'])->first();
                // dd($desiredAcHead[0]);
                if ($desiredAcHead) {
                    $dailyDataArray[] = [
                        'account_group' => $desiredAcHead->accounts_group,
                        'subsidiary_account_name' => $desiredAcHead->subsidiary_account_name,
                        'name' => $drItem['name'],
                        'amount' => intval($drItem['amount']),
                    ];
                }
                $fixedAssetAcHead = $fixed_assets_data->Where('ac_head_name_eng', $drItem['name'])->first();
                if ($fixedAssetAcHead) {
                    $fixedAsset_DR_amount = intval($fixedAsset_DR_amount) + intval($drItem['amount']);
                }
            }
        }
        // dd($fixedAsset_DR_amount);

        if ($crAmountData && !empty($crAmountData)) {
            foreach ($crAmountData as $crItem) {
                $finalDataArray[] = [
                    'name' => $crItem['name'],
                    'amount' => $crItem['amount'],
                    'party_name' => $request->input('party_input'),
                    'type' => 'cr_amount',
                ];
                $desiredAcHead = $accountHeads->Where('ac_head_name_eng', $crItem['name'])->first();
                // dd($desiredAcHead);
                if ($desiredAcHead) {
                    $dailyDataArray[] = [
                        'account_group' => $desiredAcHead->accounts_group,
                        'subsidiary_account_name' => $desiredAcHead->subsidiary_account_name,
                        'name' => $crItem['name'],
                        'amount' => -intval($crItem['amount']),
                    ];
                }
                $fixedAssetAcHead = $fixed_assets_data->Where('ac_head_name_eng', $crItem['name'])->first();
                if ($fixedAssetAcHead) {
                    $fixedAsset_CR_amount =  intval($fixedAsset_CR_amount) + intval($crItem['amount']);
                }
            }
            // dd($dailyDataArray);
        }
        // dd($fixedAsset_CR_amount);

        $fixedAssetDailyData[] = [
            'dr_amount' => $fixedAsset_DR_amount,
            'cr_amount' => $fixedAsset_CR_amount
        ];
        // dd($fixedAssetDailyData);

        $fixedAssetData = daily_data::where('voucher_date', $voucherDateInput)->pluck('control_ac');
        // dd($fixedAssetData);
        $finalDataJson = json_encode($finalDataArray);
        $dailyDataJson = json_encode($dailyDataArray);
        $accountNameMap = Arr::pluck($controlACNames, 'account_name', 'ac_head_name_eng');
        $data1 = json_decode($dailyDataJson);
        foreach ($data1 as &$item) {
            $item->account_name = $accountNameMap[$item->name] ?? null;
        }
        $groupedData = collect($data1)->groupBy('account_name')->map(function ($items) {
            $firstItem = $items->first();
            return [
                'account_group' => $firstItem->account_group,
                'subsidiary_account_name' => $firstItem->subsidiary_account_name,
                'name' => $items->first()->account_name,
                'amount' => $items->sum('amount'),
            ];
        });

        // Convert the collection to an array if needed
        $dailyDataJsonUpdate = $groupedData->toArray();
        // Extract inner arrays
        $newArray = array_values($dailyDataJsonUpdate);

        // Convert to JSON
        $newJson = json_encode($newArray);

        // dd($dailyData, $newJson);
        if (isset($dailyData[0])) {
            $newJson = $this->dailyDataCalculation($dailyData, $newJson);
            // dd($dailyDataJson);
        }

        $voucher = new voucher_entry;
        $voucher->voucher_type = $request->get('voucher_type_input');
        if ($request->get('voucher_type_input') == "Journal") {
            $voucher->voucher_no = "j_" . $request->get('voucher_no_input');
        } else if ($request->get('voucher_type_input') == "Advanced Payment") {
            $voucher->voucher_no = "a_" . $request->get('voucher_no_input');
        } else if ($request->get('voucher_type_input') == "Payment Voucher") {
            $voucher->voucher_no = "p_" . $request->get('voucher_no_input');
        } else if ($request->get('voucher_type_input') == "Receipt Voucher") {
            $voucher->voucher_no = "r_" . $request->get('voucher_no_input');
        } else if ($request->get('voucher_type_input') == "Adjustment") {
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

        $daily_control = false;

        if (isset($dailyData[0])) {

            if (isset($fixedAssetData[0])) {
                $dailyFixedAssetData = json_decode($fixedAssetData[0], true);
                // dd($dailyFixedAssetData, $fixedAssetDailyData[0]['dr_amount']);
                // dd($dailyFixedAssetData, $fixedAssetDailyData, "Have data");
                $sum = [
                    'dr_amount' => intval($dailyFixedAssetData['dr_amount']) + intval($fixedAssetDailyData[0]['dr_amount']),
                    'cr_amount' => intval($dailyFixedAssetData['cr_amount']) + intval($fixedAssetDailyData[0]['cr_amount']),
                ];
                daily_data::where('voucher_date', $voucherDateInput)->update(['ac_head' => $newJson, 'control_ac' => $sum]);
                $daily_control = true;
            } else {
                // dd($newJson, "Have else data");
                // Update the existing record
                daily_data::where('voucher_date', $voucherDateInput)->update(['ac_head' => $newJson]);
            }
        } else {
            if ($daily_control === false) {
                $newDailyData = new daily_data;
                $newDailyData->voucher_date = $request->get('voucher_date_input');
                $newDailyData->ac_head = $newJson;
                $newDailyData->control_ac = json_encode($fixedAssetDailyData[0]);
                $newDailyData->save();
            } else {
                // Create a new record
                $newDailyData = new daily_data;
                $newDailyData->voucher_date = $request->get('voucher_date_input');
                $newDailyData->ac_head = $newJson;
                $newDailyData->save();
            }
        }

        return redirect('vouchers-entry');
    }

    private function matchAndMerge($array1, $array2)
    {
        $unmatched = [];

        // Combine both arrays for easier iteration
        $combined = array_merge($array1, $array2);
        // dd($combined);
        $result = [];
        foreach ($combined as $item) {
            $name = $item['name'];
            if (isset($result[$name])) {
                $result[$name]['amount'] += $item['amount'];
            } else {
                $result[$name] = $item;
            }
        }

        return $result;
    }

    private function matchAndRemove($array1, $array2)
    {
        $unmatched = [];

        // Combine both arrays for easier iteration
        $combined = array_merge($array1, $array2);
        // dd($combined);
        $result = [];
        foreach ($combined as $item) {
            $name = $item['name'];
            if (isset($result[$name])) {
                $result[$name]['amount'] -= $item['amount'];
            } else {
                $result[$name] = $item;
            }
        }

        return $result;
    }

    private function dailyDataCalculation($dailyData, $dailyDataJson)
    {
        $dailyData = json_decode($dailyData[0], true);
        $dailyDataArray = json_decode($dailyDataJson, true);

        // Combine the two arrays
        $combinedData = array_merge($dailyData, $dailyDataArray);
        // dd($combinedData);
        // Initialize an array to store the final result
        $finalResult = [];

        // Initialize an array to store the seen entries based on the keys
        $seenEntries = [];

        foreach ($combinedData as $entry) {
            $key = $entry['account_group'] . '_' . $entry['subsidiary_account_name'] . '_' . $entry['name'];

            if (isset($seenEntries[$key])) {
                // If the entry is already seen, add the amount to the existing entry
                $seenEntries[$key]['amount'] += $entry['amount'];
            } else {
                // If the entry is not seen, add it to the final result
                $finalResult[] = $entry;
                $seenEntries[$key] = &$finalResult[count($finalResult) - 1]; // Reference to the last added entry
            }
        }

        // Convert to JSON if needed
        return json_encode($finalResult);
    }

    private function findMatchingEntry($id, $type, $data)
    {
        foreach ($data as $entry) {
            if ($entry['id'] === $id && $entry['type'] === $type) {
                return $entry;
            }
        }
        return null;
    }

    public function vouchersSearchingView(Request $request)
    {
        if (Auth::check()) {
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

        // dd($voucher_data[0]['party']);
        $voucher_type = $voucher_data[0]["voucher_type"];

        $drAmountData = json_decode($voucher_data[0]['dr_amount'], true);
        $crAmountData = json_decode($voucher_data[0]['cr_amount'], true);

        // dd($drAmountData, $crAmountData);

        $dailyOpening = DailyOpeningBalance::where('date', $voucher_data[0]['voucher_date'])->select('ac_head', 'party')->get();
        $bothOpening = json_decode($dailyOpening);
        $dailyOpeningBalance = (array) $bothOpening[0];

        $dr_cr_array = [];
        foreach ($drAmountData as $item) {
            $dr_cr_array[] = [
                'name' => $item['name'],
                'amount' => floatval($item['amount']),
            ];
        }

        foreach ($crAmountData as $item) {
            $dr_cr_array[] = [
                'name' => $item['name'],
                'amount' => -floatval($item['amount']), // Make amounts negative
            ];
        }

        $openingBalance = [];
        if ($dailyOpeningBalance['ac_head'] === []) {
            //empty
        } else {
            $a = json_decode($dailyOpeningBalance['ac_head']);
            foreach ($a as $item) {
                $openingBalance[] = (array) $item;
            }
        }

        $dailyOpeningData = $this->matchAndRemove($openingBalance, $dr_cr_array);
        // dd(gettype($voucher_data[0]['party']));
        if ($voucher_data[0]['party'] !== "" && $voucher_data[0]['party'] !== "N/A") {
            $selectedAccountName = [
                "Bills Receivable Of Rent & Lease",
                "Bills Receivable Of Processing",
                "Bills Receivable of Fish Processing",
                "Bills receivable of Fish Processing",
                "Bills Receivable Of Marine Workshop",
                "Bills Receivable Of Electric",
                "Bills Receivable Of  T-head Jetty",
                "Bills Receivable Of  T-head Jetty",
                "Bills Receivable Of Multichannel Slipway",
                "Bills Receivable Of Water  ( T-head Jetty)",
                "Bills Receivable Of Water T-head jetty",
                "Bills Receivable Of Water  ( T-head Jetty)",
                "Bills receivable of Land and Lease",
                "Bills Receivable Of Water"
            ];

            $totalAmount = 0;
            foreach ($dr_cr_array as $item) {
                if (in_array($item['name'], $selectedAccountName)) {
                    $totalAmount += $item['amount'];
                }
            }
            // dd($voucher_data[0]['party']);
            $party_array[] = [
                'name' => $voucher_data[0]['party'],
                'amount' => $totalAmount, // Make amounts negative
            ];
            // dd($party_array);

            $partyOpeningBalance = [];
            if ($dailyOpeningBalance['party'] === [] || $dailyOpeningBalance['party'] === null) {
                //empty
            } else {
                $a = json_decode($dailyOpeningBalance['party']);
                // dd($a, $dailyOpeningBalance);
                foreach ($a as $item) {
                    $partyOpeningBalance[] = (array) $item;
                }
            }
            $partyOpeningData = $this->matchAndRemove($partyOpeningBalance, $party_array);

            DailyOpeningBalance::where('date', $voucher_data[0]['voucher_date'])->update(['ac_head' => json_encode(array_values($dailyOpeningData)), 'party' => json_encode(array_values($partyOpeningData))]);
        }

        // dd($dr_cr_array, $openingBalance, $dailyOpeningData);

        DailyOpeningBalance::where('date', $voucher_data[0]['voucher_date'])->update(['ac_head' => json_encode(array_values($dailyOpeningData))]);

        $accountHeads = control_ac::join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
            ->select('control_ac.accounts_group', 'control_ac.subsidiary_account_name', 'control_ac.account_name', 'ac_head.ac_head_name_eng')
            ->get();

        $fixed_assets_data = DB::table('control_ac')
            ->join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
            ->select('ac_head.ac_head_name_eng')
            ->whereIn('control_ac.subsidiary_account_name', ['Fixed Assets'])
            ->get();

        $dailyData = daily_data::where('voucher_date', $voucher_data[0]['voucher_date'])->pluck('ac_head');
        $dailyControlData = daily_data::where('voucher_date', $voucher_data[0]['voucher_date'])->pluck('control_ac');
        // $desiredAcHead = $accountHeads->Where('ac_head_name_eng', $drAmountData['name'])->first();
        $fixedAsset_DR_amount = 0;
        $fixedAsset_CR_amount = 0;

        if ($drAmountData && !empty($drAmountData)) {
            foreach ($drAmountData as $drItem) {
                $desiredAcHead = $accountHeads->Where('ac_head_name_eng', $drItem['name'])->first();
                // return $desiredAcHead;
                if ($drItem) {
                    $dailyDataArray[] = [
                        'account_group' => $desiredAcHead->accounts_group,
                        'subsidiary_account_name' => $desiredAcHead->subsidiary_account_name,
                        'name' => $desiredAcHead->account_name,
                        'amount' => intval($drItem['amount']),
                    ];
                }
                $fixedAssetAcHead = $fixed_assets_data->Where('ac_head_name_eng', $drItem['name'])->first();
                if ($fixedAssetAcHead) {
                    $fixedAsset_DR_amount += intval($drItem['amount']);
                }
            }
        }

        if ($crAmountData && !empty($crAmountData)) {
            foreach ($crAmountData as $crItem) {
                $desiredAcHead = $accountHeads->Where('ac_head_name_eng', $crItem['name'])->first();
                if ($desiredAcHead) {
                    $dailyDataArray[] = [
                        'account_group' => $desiredAcHead->accounts_group,
                        'subsidiary_account_name' => $desiredAcHead->subsidiary_account_name,
                        'name' => $desiredAcHead->account_name,
                        'amount' => -intval($crItem['amount']),
                    ];
                }
                $fixedAssetAcHead = $fixed_assets_data->Where('ac_head_name_eng', $crItem['name'])->first();
                if ($fixedAssetAcHead) {
                    $fixedAsset_CR_amount -= intval($crItem['amount']);
                }
            }
        }
        $oldDailyData = json_decode($dailyData[0]);
        $oldDailyControlData = json_decode($dailyControlData[0]);
        // dd($oldDailyControlData, $oldDailyData, $dailyDataArray);
        // dd($oldDailyControlData->dr_amount, $fixedAsset_DR_amount);
        $sum = [
            'dr_amount' => $oldDailyControlData->dr_amount - $fixedAsset_DR_amount,
            'cr_amount' => $oldDailyControlData->cr_amount - $fixedAsset_CR_amount,
        ];
        // dd($voucher_data[0]['dr_amount']);

        daily_data::where('voucher_date', $voucher_data[0]['voucher_date'])->update(['control_ac' => json_encode($sum)]);

        // $dataArray = json_decode($oldDailyData, true);
        // Initialize an empty array to store converted data
        $convertedData = [];
        $latestConvertedData = [];

        // Iterate over the array of objects
        foreach ($oldDailyData as $item) {
            // Convert each object into an associative array
            $convertedData[] = [
                "account_group" => $item->account_group,
                "subsidiary_account_name" => $item->subsidiary_account_name,
                "name" => $item->name,
                "amount" => $item->amount
            ];
        }

        $sortedData = $this->consolidateData($dailyDataArray);

        foreach ($convertedData as $item2) {
            // Find corresponding item in data1 based on account_group, subsidiary_account_name, and name
            foreach ($sortedData as $item1) {
                if ($item1["account_group"] === $item2["account_group"] && $item1["subsidiary_account_name"] === $item2["subsidiary_account_name"] && $item1["name"] === $item2["name"]) {
                    if ($item1["amount"] >= 0) {
                        $latestConvertedData[] = [
                            "account_group" => $item2["account_group"],
                            "subsidiary_account_name" => $item2["subsidiary_account_name"],
                            "name" => $item2["name"],
                            "amount" => $item2["amount"] - $item1["amount"]
                        ];
                    } else {
                        $latestConvertedData[] = [
                            "account_group" => $item2["account_group"],
                            "subsidiary_account_name" => $item2["subsidiary_account_name"],
                            "name" => $item2["name"],
                            "amount" => $item2["amount"] + abs($item1["amount"])
                        ];
                    }
                }
            }
        }

        $finalizedData = $this->updateAmounts($convertedData, $latestConvertedData);

        // dd($convertedData, $latestConvertedData, $finalizedData);
        daily_data::where('voucher_date', $voucher_data[0]['voucher_date'])->update(['ac_head' => json_encode($finalizedData)]);
        // dd($voucher_data, $dailyData);
        if ($size > 0) {
            if ($voucher_type == "Receipt Voucher") {
                collection_entry::whereIn('id', $output)->update(['status' => 'visible']);
            } else if ($voucher_type == "Journal") {
                voucher_entry::whereIn('voucher_no', $output)->update(['status' => 'Pending']);
            }
        }
        voucher_entry::where('id', $request->get('id_delete'))->delete();

        return redirect('vouchers-entry');
    }

    function consolidateData(array $data): array
    {
        $groupedData = collect($data)->groupBy(function ($item) {
            return $item['account_group'] . '_' . $item['subsidiary_account_name'] . '_' . $item['name'];
        });

        return $groupedData->map(function ($group) {
            return [
                'account_group' => $group[0]['account_group'],
                'subsidiary_account_name' => $group[0]['subsidiary_account_name'],
                'name' => $group[0]['name'],
                'amount' => $group->sum('amount'),
            ];
        })->values()->toArray();
    }

    public function updateAmounts(array $firstData, array $secondData)
    {
        $secondDataCollection = collect($secondData);

        foreach ($firstData as &$item) {
            $matchingItem = $secondDataCollection->firstWhere(function ($secondItem) use ($item) {
                return $secondItem['account_group'] === $item['account_group']
                    && $secondItem['name'] === $item['name']
                    && $secondItem['subsidiary_account_name'] === $item['subsidiary_account_name'];
            });

            if ($matchingItem) {
                $item['amount'] = $matchingItem['amount'];
            }
        }

        return $firstData;
    }

    public function cashCollectionVoucherView()
    {
        if (Auth::check()) {
            $collection_entry = collection_entry::where('status', 'visible')->get();
            return view('super_admin.core_accounting.vouchers.cash_collection_voucher')->with('collection_entry', $collection_entry);
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function cash_voucher_update(Request $request)
    {
        $checkboxes = $request->input('checkboxes');
        $data = collection_entry::whereIn('id', $checkboxes)->get();
        // dd($checkboxes);

        $oldDataArray = json_decode($data, true);
        // return $oldDataArray;
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
        $finalDataJson1 = $finalDataJson;
        $updatedDrAmount = []; // Initialize as empty array
        $updatedCrAmount = []; // Initialize as empty array

        // $lastVoucherNo = voucher_entry::max('voucher_no');
        // $nextVoucherNo = $lastVoucherNo ? $lastVoucherNo + 1 : 1;
        $data2 = voucher_entry::where('voucher_no', 'LIKE', 'r_%')
            ->orderByRaw('CAST(SUBSTRING(voucher_no, 3) AS UNSIGNED) DESC')
            ->first();
        $highestVoucherNo = $data2->voucher_no;
        // return response()->json(['data' => $highestVoucherNo]);
        $number = 0;

        if ($highestVoucherNo) {
            $lastVoucherNo = $highestVoucherNo;
        } else {
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
        // return $output;
        $totalDrAmount = 0;
        $totalCrAmount = 0;

        if ($data->count() > 1) {
            // Multiple data selected
            $updatedDrAmount = [];
            $updatedCrAmount = [];
            $totalDrAmount = 0;
            $totalCrAmount = 0;
            // return $data[0];
            $accountHeads = control_ac::join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
                ->select('control_ac.accounts_group', 'control_ac.subsidiary_account_name', 'control_ac.account_name', 'ac_head.ac_head_name_eng')
                ->get();
            // dd($accountHeads);

            foreach ($data as &$item) {
                $dailyData = daily_data::where('voucher_date', $item['collection_date'])->pluck('ac_head');
                $item['cr_amount'] = json_decode($item['cr_amount'], true);
                $item['dr_amount'] = json_decode($item['dr_amount'], true);

                $v_date = $item['collection_date'];
                array_push($dr_arr, $item['dr_amount']);
                array_push($cr_arr, $item['cr_amount']);

                $drAmountData = $item['dr_amount'];
                $crAmountData = $item['cr_amount'];

                // $accountHeads = account_head::select('ac_head_id', 'ac_head_name_eng')->get();
                $dailyData = daily_data::where('voucher_date', $v_date)->pluck('ac_head');
                // Transform data to final_data format
                $finalDataArray = [];
                $dailyDataArray = [];

                // return $drAmountData;

                if ($drAmountData && !empty($drAmountData)) {
                    foreach ($drAmountData as $drItem) {
                        $finalDataArray[] = [
                            'name' => $drItem['name'],
                            'amount' => $drItem['amount'],
                            'party_name' => $request->input('party_input'),
                            'type' => 'dr_amount',
                        ];
                        $desiredAcHead = $accountHeads->Where('ac_head_name_eng', $drItem['name'])->first();
                        // return $desiredAcHead;
                        if ($drItem) {
                            $dailyDataArray[] = [
                                'account_group' => $desiredAcHead->accounts_group,
                                'subsidiary_account_name' => $desiredAcHead->subsidiary_account_name,
                                'name' => $desiredAcHead->account_name,
                                'amount' => intval($drItem['amount']),
                            ];
                        }
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
                        $desiredAcHead = $accountHeads->Where('ac_head_name_eng', $crItem['name'])->first();
                        // dd($desiredAcHead);
                        if ($desiredAcHead) {
                            $dailyDataArray[] = [
                                'account_group' => $desiredAcHead->accounts_group,
                                'subsidiary_account_name' => $desiredAcHead->subsidiary_account_name,
                                'name' => $desiredAcHead->account_name,
                                'amount' => -intval($crItem['amount']),
                            ];
                        }
                    }
                }
                // return $dailyDataArray;
                $finalDataJson = json_encode($finalDataArray);
                $dailyDataJson = json_encode($dailyDataArray);
                // dd($dailyData, $dailyDataJson);
                // return $finalDataJson;
                if (isset($dailyData[0])) {
                    $dailyDataJson = $this->dailyDataCalculation($dailyData, $dailyDataJson);
                    // dd($dailyDataJson);
                }
                // return $dailyDataJson;
                if (isset($dailyData[0])) {
                    // Update the existing record
                    daily_data::where('voucher_date', $item['collection_date'])->update(['ac_head' => $dailyDataJson]);
                } else {
                    // Create a new record
                    $newDailyData = new daily_data;
                    $newDailyData->voucher_date = $item['collection_date'];
                    $newDailyData->ac_head = $dailyDataJson;
                    $newDailyData->save();
                }
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
            // return $newDRData;

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

            $description = 'Multiple vouchers added: ' . implode(', ', $data->pluck('id')->map(function ($id) {
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
                'cr_dr' => $finalDataJson1
            ];

            // dd($newDR, $newCR);
            $array_dr = (array) $newDR;
            $array_cr = (array) $newCR;
            $dailyOpening = DailyOpeningBalance::where('date', $v_date)->pluck('ac_head');
            $dailyOpeningBalance = json_decode($dailyOpening);

            $dr_cr_array = [];
            foreach ($array_dr as $item) {
                $each_item = (array) $item;
                $dr_cr_array[] = [
                    'name' => $each_item['name'],
                    'amount' => floatval($each_item['amount']),
                ];
            }

            foreach ($array_cr as $item) {
                $each_item = (array) $item;
                $dr_cr_array[] = [
                    'name' => $each_item['name'],
                    'amount' => -floatval($each_item['amount']), // Make amounts negative
                ];
            }

            $openingBalance = [];
            if ($dailyOpeningBalance === []) {
                //empty
            } else {
                $a = json_decode($dailyOpeningBalance[0]);
                foreach ($a as $item) {
                    $openingBalance[] = (array) $item;
                }
            }
            $dailyOpeningData = $this->matchAndMerge($dr_cr_array, $openingBalance);
            if ($dailyOpeningBalance === []) {
                $openingDailyData = new DailyOpeningBalance;
                $openingDailyData->date = $v_date;
                $openingDailyData->ac_head = json_encode(array_values($dailyOpeningData));
                $openingDailyData->save();
            } else {
                DailyOpeningBalance::where('date', $v_date)->update(['ac_head' => json_encode(array_values($dailyOpeningData))]);
            }

            // return response()->json(['data' => $array_dr]);

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
            $voucher->cr_dr = $finalDataJson1;
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
            $accountHeads = control_ac::join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
                ->select('control_ac.accounts_group', 'control_ac.subsidiary_account_name', 'control_ac.account_name', 'ac_head.ac_head_name_eng')
                ->get();

            $item = $data->first();
            $item['cr_amount'] = json_decode($item['cr_amount'], true);
            $item['dr_amount'] = json_decode($item['dr_amount'], true);

            $v_date = $item['collection_date'];

            $drAmountData = $item['dr_amount'];
            $crAmountData = $item['cr_amount'];

            $drAmountJsonData = json_encode($item['dr_amount']);
            $crAmountJsonData = json_encode($item['cr_amount']);

            // $accountHeads = account_head::select('ac_head_id', 'ac_head_name_eng')->get();
            $dailyData = daily_data::where('voucher_date', $v_date)->pluck('ac_head');
            // Transform data to final_data format
            $finalDataArray = [];
            $dailyDataArray = [];

            // return $drAmountData;

            if ($drAmountData && !empty($drAmountData)) {
                foreach ($drAmountData as $drItem) {
                    $finalDataArray[] = [
                        'name' => $drItem['name'],
                        'amount' => $drItem['amount'],
                        'party_name' => $request->input('party_input'),
                        'type' => 'dr_amount',
                    ];
                    $desiredAcHead = $accountHeads->Where('ac_head_name_eng', $drItem['name'])->first();
                    // return $desiredAcHead;
                    if ($drItem) {
                        $dailyDataArray[] = [
                            'account_group' => $desiredAcHead->accounts_group,
                            'subsidiary_account_name' => $desiredAcHead->subsidiary_account_name,
                            'name' => $desiredAcHead->account_name,
                            'amount' => intval($drItem['amount']),
                        ];
                    }
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
                    $desiredAcHead = $accountHeads->Where('ac_head_name_eng', $crItem['name'])->first();
                    // dd($desiredAcHead);
                    if ($desiredAcHead) {
                        $dailyDataArray[] = [
                            'account_group' => $desiredAcHead->accounts_group,
                            'subsidiary_account_name' => $desiredAcHead->subsidiary_account_name,
                            'name' => $desiredAcHead->account_name,
                            'amount' => -intval($crItem['amount']),
                        ];
                    }
                }
            }
            // return $dailyDataArray;
            $finalDataJson = json_encode($finalDataArray);
            $dailyDataJson = json_encode($dailyDataArray);
            // dd($dailyData, $dailyDataJson);
            $finalDataJson1 = $finalDataJson;
            if (isset($dailyData[0])) {
                $dailyDataJson = $this->dailyDataCalculation($dailyData, $dailyDataJson);
                // dd($dailyDataJson);
            }
            // return $dailyDataJson;
            if (isset($dailyData[0])) {
                // Update the existing record
                daily_data::where('voucher_date', $v_date)->update(['ac_head' => $dailyDataJson]);
            } else {
                // Create a new record
                $newDailyData = new daily_data;
                $newDailyData->voucher_date = $v_date;
                $newDailyData->ac_head = $dailyDataJson;
                $newDailyData->save();
            }

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

            $array_dr = (array) $item['dr_amount'];
            $array_cr = (array) $item['cr_amount'];
            $dailyOpening = DailyOpeningBalance::where('date', $v_date)->pluck('ac_head');
            $dailyOpeningBalance = json_decode($dailyOpening);

            $dr_cr_array = [];
            foreach ($array_dr as $item) {
                $each_item = (array) $item;
                $dr_cr_array[] = [
                    'name' => $each_item['name'],
                    'amount' => floatval($each_item['amount']),
                ];
            }

            foreach ($array_cr as $item) {
                $each_item = (array) $item;
                $dr_cr_array[] = [
                    'name' => $each_item['name'],
                    'amount' => -floatval($each_item['amount']), // Make amounts negative
                ];
            }

            $openingBalance = [];
            if ($dailyOpeningBalance === []) {
                //empty
            } else {
                $a = json_decode($dailyOpeningBalance[0]);
                foreach ($a as $item) {
                    $openingBalance[] = (array) $item;
                }
            }
            $dailyOpeningData = $this->matchAndMerge($dr_cr_array, $openingBalance);
            if ($dailyOpeningBalance === []) {
                $openingDailyData = new DailyOpeningBalance;
                $openingDailyData->date = $v_date;
                $openingDailyData->ac_head = json_encode(array_values($dailyOpeningData));
                $openingDailyData->save();
            } else {
                DailyOpeningBalance::where('date', $v_date)->update(['ac_head' => json_encode(array_values($dailyOpeningData))]);
            }
            // return response()->json(['data' => $v_date]);

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
            $voucher->dr_amount = $drAmountJsonData; // Convert to JSON string
            $voucher->cr_amount = $crAmountJsonData; // Convert to JSON string
            $voucher->cr_dr = $finalDataJson1;
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
        if (Auth::check()) {
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

        $description = 'Multiple Journal vouchers added: ' . implode(', ', $data->pluck('voucher_no')->map(function ($id) {
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

    public function journal_voucher_delete(Request $request)
    {
        $voucher_data = voucher_entry::where('voucher_no', $request->get('id_delete'))->get();

        preg_match_all('/\bmemo-([a-zA-Z0-9._-]+)\b/', $voucher_data[0]["description"], $matches);
        $numbers = $matches[1];

        $output = $numbers;
        $size = count($output);

        // dd($output);
        $voucher_type = $voucher_data[0]["voucher_type"];

        if ($size > 0) {
            if ($voucher_type == "Receipt Voucher") {
                collection_entry::whereIn('id', $output)->update(['status' => 'visible']);
            } else if ($voucher_type == "Journal") {
                voucher_entry::whereIn('voucher_no', $output)->update(['status' => 'Pending']);
            }
        }
        voucher_entry::where('voucher_no', $request->get('id_delete'))->delete();

        return redirect('journal-voucher');
    }

    public function chequeApprovedView()
    {
        if (Auth::check()) {
            return view('super_admin.core_accounting.vouchers.cheque_approved');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    // Account Reports
    public function chartOfAccountsView()
    {
        if (Auth::check()) {
            return view('super_admin.core_accounting.account_reports.chart_of_accounts');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }


    public function trialBalanceView(Request $request)
    {
        ini_set('max_execution_time', 3600);
        if (Auth::check()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            if ($request->isMethod('post')) {
                $startDateTime = new DateTime($startDate);
                $endDateTime = new DateTime($endDate);

                //  --------------- Iterate through each date in the range
                // while ($startDateTime <= $endDateTime) {
                //     $currentDate = $startDateTime->format('Y-m-d'); // Format the date as needed

                //     // Fetch and process data for the current date
                //     $trailBalanceSavedata = $this->trialBalanceSaveInDailyData($currentDate, $currentDate);
                //     $trailBalanceSavedataJson = json_encode($trailBalanceSavedata["final_data"]);
                //     $trailBalanceSaveControl_AC = $trailBalanceSavedata["fixedAssetDailyData"];
                //     // dd();
                //     // Create a new daily_data entry for the current date
                //     $newDailyData = new daily_data;
                //     $newDailyData->voucher_date = $currentDate;
                //     $newDailyData->ac_head = $trailBalanceSavedataJson;
                //     $newDailyData->control_ac = json_encode($trailBalanceSaveControl_AC[0]);
                //     $newDailyData->save();

                //     // Fetch voucher entries for the current date
                //     $voucher_entries = DB::table('voucher_entry')
                //         ->where('voucher_date', $currentDate)
                //         ->whereIn('status', ['pending', 'Pending', 'Done'])
                //         ->select('dr_amount', 'cr_amount', 'voucher_date')
                //         ->orderBy('voucher_date')
                //         ->get();

                //     // Process or store the fetched voucher entries as needed

                //     // Move to the next date
                //     $startDateTime->modify('+1 day');
                // }

                // --------------- Trial Fix End ---------------- //

                // while ($startDateTime <= $endDateTime) {
                //     $currentDate = $startDateTime->format('Y-m-d'); // Format the date as needed

                //     // Fetch voucher entries for the current date
                //     $voucher_entries = DB::table('voucher_entry')
                //         ->where('voucher_date', $currentDate)
                //         ->whereIn('status', ['pending', 'Pending', 'Done'])
                //         ->select('dr_amount', 'cr_amount', 'voucher_date')
                //         ->orderBy('voucher_date')
                //         ->get();

                //     $dr_cr_array = [];

                //     foreach ($voucher_entries as $items) {
                //         $array_items = (array) $items;
                //         $item_dr_amount = $array_items["dr_amount"];
                //         $dr_amount = json_decode($item_dr_amount);
                //         $item_cr_amount = $array_items["cr_amount"];
                //         $cr_amount = json_decode($item_cr_amount);

                //         foreach ($dr_amount as $item) {
                //             $array_item = (array) $item;
                //             $dr_cr_array[] = [
                //                 'name' => $array_item['name'],
                //                 'amount' => floatval($array_item['amount']),
                //             ];
                //         }

                //         foreach ($cr_amount as $item) {
                //             $array_item = (array) $item;
                //             $dr_cr_array[] = [
                //                 'name' => $array_item['name'],
                //                 'amount' => -floatval($array_item['amount']), // Make amounts negative
                //             ];
                //         }
                //     }
                //     $dailyOpeningData = $this->matchAndMerge($dr_cr_array, []);
                //     $final_data_for_Daily_Opening_Data =  json_encode(array_values($dailyOpeningData));

                //     // Move to the next date
                //     $final_date = $startDateTime->modify('+1 day');

                //     $openingDailyData = new DailyOpeningBalance;
                //     $openingDailyData->date = $final_date;
                //     $openingDailyData->ac_head = $final_data_for_Daily_Opening_Data;
                //     $openingDailyData->save();
                //     // Process or store the fetched voucher entries as needed

                // }

                //  -------------------- Daily Opening Banalnce End ----------------- //

                // $startDateTime->modify('+1 day');
                // $endDateTime->modify('+1 day');

                // $voucher_entries = DB::table('daily_opening_balance')
                //     ->whereBetween('date', [$startDateTime, $endDateTime])
                //     ->where('ac_head', '!=', '[]')
                //     ->select('ac_head')
                //     ->get();

                // $all_data_array = [];
                // foreach ($voucher_entries as $items) {
                //     $array_items = (array) $items;
                //     $eachItemsData = json_decode($array_items["ac_head"]);
                //     foreach ($eachItemsData as $item) {
                //         $array_item = (array) $item;
                //         $all_data_array[] = [
                //             'name' => $array_item['name'],
                //             'amount' => floatval($array_item['amount']),
                //         ];
                //     }
                // }

                // $yearlyOpeningData = $this->matchAndMerge($all_data_array, []);
                // $final_data_for_Yearly_Opening_Data =  json_encode(array_values($yearlyOpeningData));
                // // dd($final_data_for_Yearly_Opening_Data);

                // $lastDate = $endDateTime->format('Y-m-d');
                // // dd($lastDate);
                // $openingYearlyData = new YearlyOpeningBalance;
                // $openingYearlyData->date = $lastDate;
                // $openingYearlyData->ac_head = $final_data_for_Yearly_Opening_Data;
                // $openingYearlyData->save();

                // ----------------------- Yearly Opening Banalce End --------------------------- //

                // $parties = DB::table('party')
                //     ->where('name', 'like', "%Bills Receivable%")
                //     ->orWhere('name', 'like', "%Bill receivable")
                //     ->select('name')
                //     ->orderBy('name')
                //     ->get();

                // $selectedAccountName = [
                //         "Bills Receivable Of Rent & Lease",
                //         "Bills Receivable Of Processing",
                //         "Bills Receivable Of Marine Workshop",
                //         "Bills Receivable Of Electric",
                //         "Bills Receivable Of Water",
                //         "Bills Receivable Of  T-head Jetty",
                //         "Bills Receivable Of  T-head Jetty",
                //         "Bills Receivable Of Multichannel Slipway",
                //         "Bills Receivable Of Water  ( T-head Jetty)",
                //         "Bills Receivable Of Water T-head jetty",
                //         "Bills Receivable Of Water  ( T-head Jetty)",
                //         "Bills receivable of Land and Lease"
                //     ];

                // while ($startDateTime <= $endDateTime) {
                //     $currentDate = $startDateTime->format('Y-m-d'); // Format the date as needed
                //     $finalData = [];
                //     foreach ($parties as $party) {
                //         $name = $party->name;
                //         // dd($name);

                //         $ledgerData = DB::table('voucher_entry')
                //         ->select('voucher_no', 'description', 'voucher_date', 'dr_amount', 'cr_amount')
                //         ->where('voucher_date', $currentDate)
                //         ->whereIn('status', ['pending', 'Done', 'Pending'])
                //         ->where(function ($query) use ($name) {
                //             $query->where(function ($query) use ($name) {
                //                 $query->where('voucher_type', 'Journal')
                //                     ->where('party', $name);
                //             })->orWhere(function ($query) use ($name) {
                //                 $query->where('voucher_type', 'Receipt Voucher')
                //                     ->where(function ($query) use ($name) {
                //                         $query->where(function ($query) use ($name) {
                //                             $query->where(function ($query) use ($name) {
                //                                 $query->where('description', 'not like', 'Multiple vouchers added:%')
                //                                     ->where('description', 'not like', 'Voucher ID:%')
                //                                     ->where('party', $name);
                //                             })->orWhere(function ($query) {
                //                                 $query->where(function ($query) {
                //                                     $query->where('description', 'like', 'Multiple vouchers added:%')
                //                                         ->orWhere('description', 'like', 'Voucher ID:%');
                //                                 });
                //                             });
                //                         });
                //                     });
                //             })->orWhere(function ($query) {
                //                 $query->whereIn('voucher_type', ['Advanced Payment', 'Adjustment']);
                //             });
                //         })
                //         ->get();

                //         $sortedLedgerData = $this->ledgerDataManupulation($ledgerData, $name, $selectedAccountName); // Add Date range
                //         $thisPratyTotal = 0;
                //         if($sortedLedgerData !== []) {
                //             // dd($sortedLedgerData);
                //             foreach ($sortedLedgerData as $singleLedgerData) {
                //                 $singleLedgerDataArray = (array) $singleLedgerData;
                //                 // dd($singleLedgerDataArray, $singleLedgerData);
                //                 foreach ($singleLedgerDataArray['dr_amount'] as $singleDrAmount) {
                //                     $thisPratyTotal += $singleDrAmount->amount;
                //                 }
                //                 foreach ($singleLedgerDataArray['cr_amount'] as $singleCrAmount) {
                //                     $thisPratyTotal -= $singleCrAmount->amount;
                //                 }
                //             }
                //             // dd($thisPratyTotal);
                //         }
                //         // dd($thisPratyTotal);
                //         if($thisPratyTotal !== 0) {
                //             $finalData[] = [
                //                 'name' => $name,
                //                 'amount' => $thisPratyTotal,
                //             ];
                //         }
                //     }
                //     $final_date = $startDateTime->modify('+1 day');
                //     DailyOpeningBalance::where('date', $final_date)->update(['party' => json_encode($finalData)]);
                // }

                // ---------------------------- Party Daily Opening Balance End ---------------------- //

                // $startDateTime->modify('+1 day');
                // $endDateTime->modify('+1 day');

                // $voucher_entries = DB::table('daily_opening_balance')
                //     ->whereBetween('date', [$startDateTime, $endDateTime])
                //     ->where('party', '!=', '[]')
                //     ->select('party')
                //     ->get();

                // $all_data_array = [];
                // foreach ($voucher_entries as $items) {
                //     $array_items = (array) $items;
                //     $eachItemsData = json_decode($array_items["party"]);
                //     foreach ($eachItemsData as $item) {
                //         $array_item = (array) $item;
                //         $all_data_array[] = [
                //             'name' => $array_item['name'],
                //             'amount' => floatval($array_item['amount']),
                //         ];
                //     }
                // }

                // $yearlyOpeningData = $this->matchAndMerge($all_data_array, []);
                // $final_data_for_Yearly_Opening_Data =  json_encode(array_values($yearlyOpeningData));
                // // dd($final_data_for_Yearly_Opening_Data);

                // $lastDate = $endDateTime->format('Y-m-d');

                // YearlyOpeningBalance::where('date', $lastDate)->update(['party' => $final_data_for_Yearly_Opening_Data]);

                // ---------------------------- Party Yearly Opening Balance End ---------------------- //

                // // // // // $finalResult = $this->dailyDataDispatch($ledgerData, $all_ac_head_names);

                $ledgerData = DB::table('daily_data')
                    ->whereBetween('voucher_date', [$startDate, $endDate])
                    ->select('ac_head')
                    ->get();

                // Use Laravel's collection methods to merge and sum amounts
                if ($ledgerData->count() === 1) {
                    // If there is only one set of data, you can use it directly
                    // $mergedData = $ledgerData;
                    // $acHeadData = $dataArray['ac_head'];
                    foreach ($ledgerData as $data) {
                        $decodedData = json_decode($data->ac_head, true);
                        $dailyData[] = $decodedData;
                        // $dailyData = array_merge($previous_data, $decodedData); 
                    }
                    // Initialize an empty array to store formatted data
                    $mergedData = [];
                    $mergedData = $dailyData[0];
                } else {
                    // $previous_data = [];
                    $dailyData = [];
                    foreach ($ledgerData as $data) {
                        $decodedData = json_decode($data->ac_head, true);
                        $dailyData[] = $decodedData;
                        // $dailyData = array_merge($previous_data, $decodedData); 
                    }
                    $mergedArray = [];
                    foreach ($dailyData as $currentArray) {
                        // Iterate through each item in the current array
                        foreach ($currentArray as $item) {
                            // Check if the item with similar criteria already exists in the merged array
                            $existingKey = array_search($item, $mergedArray);

                            if ($existingKey !== false) {
                                // If exists, add the 'amount' values
                                $mergedArray[$existingKey]['amount'] += $item['amount'];
                            } else {
                                // If not exists, add the current item to the merged array
                                $mergedArray[] = $item;
                            }
                        }
                    }

                    $newArray = [];
                    $yourArray = $mergedArray;
                    // Loop through the given array
                    $totals = [];

                    foreach ($yourArray as $item) {
                        $key = $item['account_group'] . '-_-' . $item['subsidiary_account_name'] . '-_-' . $item['name'];

                        // If the key exists in the totals array, update the amount
                        if (isset($totals[$key])) {
                            $totals[$key] += $item['amount'];
                        } else {
                            // Otherwise, add the key to the totals array with the current amount
                            $totals[$key] = $item['amount'];
                        }
                    }

                    // Create the new array using the totals
                    foreach ($totals as $key => $amount) {
                        list($account_group, $subsidiary_account_name, $name) = explode('-_-', $key);
                        $newArray[] = [
                            'account_group' => $account_group,
                            'subsidiary_account_name' => $subsidiary_account_name,
                            'name' => $name,
                            'amount' => $amount,
                        ];
                    }

                    // Sort the new array based on account_group and subsidiary_account_name
                    usort($newArray, function ($a, $b) {
                        if ($a['account_group'] == $b['account_group']) {
                            return strcmp($a['subsidiary_account_name'], $b['subsidiary_account_name']);
                        }
                        return strcmp($a['account_group'], $b['account_group']);
                    });

                    // dd($newArray);
                    $mergedData = $newArray;
                }

                // $finalResult = json_decode($mergedData[0]->ac_head, true);
                return view('super_admin.core_accounting.account_reports.trial_balance', [
                    'data' => $mergedData,
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
        }
    }

    private function dailyDataDispatch($ledgerData, $all_ac_head_names)
    {
        $mergedData = [];
        $dailyData = [];
        foreach ($ledgerData as $data) {
            $decodedData = json_decode($data->ac_head, true);
            $dailyData = array_merge($dailyData, $decodedData);
        }
        $sums = [];
        foreach ($dailyData as $item) {
            $id = $item['id'];
            $type = $item['type'];
            $amount = intval($item['amount']);

            if ($type === 'cr_amount') {
                $amount = -$amount;
            }

            $sums[$id] = ($sums[$id] ?? 0) + $amount;
        }

        $result = [];
        foreach ($sums as $id => $sum) {
            $result[] = [
                'id' => $id,
                'amount' => $sum,
            ];
        }

        foreach ($all_ac_head_names as $firstItem) {
            foreach ($result as $secondItem) {
                if ($firstItem['ac_head_id'] === $secondItem['id']) {
                    $mergedData[] = array_merge($firstItem, $secondItem);
                    break;
                }
            }
        }

        $combinedData = [];
        foreach ($mergedData as $item) {
            $key = $item['accounts_group'] . '-' . $item['subsidiary_account_name'] . '-' . $item['account_name'];

            if (isset($combinedData[$key])) {
                $combinedData[$key]['amount'] += $item['amount'];
            } else {
                $combinedData[$key] = [
                    'account_group' => $item['accounts_group'],
                    'subsidiary_account_name' => $item['subsidiary_account_name'],
                    'name' => $item['account_name'],
                    'amount' => $item['amount'],
                ];
            }
        }

        // Transform the associative array to a simple indexed array
        return array_values($combinedData);
    }




    public function trialBalanceSaveInDailyData($startDate, $endDate)
    {

        $all_contol_names = control_ac::distinct()
            ->select('accounts_group', 'subsidiary_account_name', 'account_name')
            ->get()
            ->toArray();

        $ledgerData = DB::table('voucher_entry')
            ->whereBetween('voucher_date', [$startDate, $endDate])
            ->select('voucher_no', 'description', 'dr_amount', 'cr_amount', 'voucher_date')
            ->whereIn('status', ['pending', 'Done'])
            ->get();
        // dd($ledgerData, $startDate, $endDate);

        $final_data = [];

        $fixed_assets_data = DB::table('control_ac')
            ->join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
            ->select('ac_head.ac_head_name_eng')
            ->whereIn('control_ac.subsidiary_account_name', ['Fixed Assets'])
            ->get();

        $fixedAsset_DR_amount = 0;
        $fixedAsset_CR_amount = 0;
        foreach ($ledgerData as $items) {
            $drAmount = json_decode($items->dr_amount);
            $crAmount = json_decode($items->cr_amount);
            foreach ($drAmount as $individualDR) {
                $fixedAssetAcHead = $fixed_assets_data->Where('ac_head_name_eng', $individualDR->name)->first();
                if ($fixedAssetAcHead) {
                    $fixedAsset_DR_amount = intval($fixedAsset_DR_amount) + intval($individualDR->amount);
                }
            }
            foreach ($crAmount as $individualCR) {
                $fixedAssetAcHead = $fixed_assets_data->Where('ac_head_name_eng', $individualCR->name)->first();
                if ($fixedAssetAcHead) {
                    $fixedAsset_DR_amount = intval($fixedAsset_DR_amount) + intval($individualCR->amount);
                }
            }
        }

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

            $filteredLedgerData = $this->ledgerDataManupulation($ledgerData, "", $acHeadNames, $startDate, $endDate);
            // if($filteredLedgerData !== []) {
            //     dd($filteredLedgerData);
            // }
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

        $fixedAssetDailyData[] = [
            'dr_amount' => $fixedAsset_DR_amount,
            'cr_amount' => $fixedAsset_CR_amount
        ];
        // dd($fixedAssetDailyData);

        $final_data = array_values($uniqueData);

        // dd($final_data, $fixedAssetDailyData);

        return  ['final_data' => $final_data, 'fixedAssetDailyData' => $fixedAssetDailyData];
    }

    public function bankBookView()
    {
        if (Auth::check()) {
            return view('super_admin.core_accounting.account_reports.bank_book');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function subACLedgerView(Request $request)
    {
        ini_set('max_execution_time', 3600);
        if (Auth::check()) {
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

                $filteredLedgerData = $this->ledgerDataManupulation($ledgerData, "", $acHeadNames, $startDate, $endDate);

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
        ini_set('max_execution_time', 3600);
        if (Auth::check()) {
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

                $filteredLedgerData = $this->ledgerDataManupulation($ledgerData, "", $ac_head_names, $startDate, $endDate);
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
                //dd($filteredLedgerData2);

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
        ini_set('max_execution_time', 3600);
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
                    ->whereIn('status', ['pending', 'Pending', 'Done'])
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

                $dailyOpeningBalanceData = $this->getOpeningBalanceData($startDate, $endDate);
                foreach ($dailyOpeningBalanceData as $dailyOpeningBalance) {
                    $dailyOpeningBalanceArray = (array) $dailyOpeningBalance;
                    $allOpeningBalance = json_decode($dailyOpeningBalanceArray['ac_head']);
                    foreach ($allOpeningBalance as $balance) {
                        if ($balance->name === $selectedAccountName) {
                            $openningBalance += $balance->amount;
                        }
                    }
                }


                $sortedLedgerData = $ledgerData->sortBy('voucher_date')->values()->all();
                // Output the filtered ledger data
                return view('super_admin.core_accounting.account_reports.ac_head_ledger', ['ledgerData' => $sortedLedgerData, 'accounts' => $accounts, 'selectedAccountName' => $selectedAccountName, 'startDate' => $startDate, 'endDate' => $endDate, 'openingBalance' => $openningBalance]);
            }

            return view('super_admin.core_accounting.account_reports.ac_head_ledger', ['accounts' => $accounts, 'ledgerData' => null, 'startDate' => null, 'endDate' => null]);
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    function getOpeningBalanceData($startDate, $endDate)
    {
        // Convert the start and end date strings to DateTime objects
        $startDateObj = new DateTime($startDate);
        $endDateObj = new DateTime($endDate);

        // Calculate the start of the financial year (July 1st) for the start date year
        $yearStart = (new DateTime($startDateObj->format('Y') . '-07-01'));

        // If the start date is not July 1st, adjust year start to previous July 1st
        if ($startDateObj < $yearStart) {
            $yearStart->modify('-1 year');
        }

        // Prepare the previous year’s start and end dates for `daily_opening_balance`
        $previousYearStart = (clone $yearStart)->modify('-1 year');
        $previousYearEnd = (clone $yearStart)->modify('-1 day');  // One day before the current year start

        // Check if the start date is exactly July 1st of any year
        if ($startDateObj == $yearStart) {
            // Fetch data from `yearly_opening_balance` table for the entire date range
            $data = DB::table('yearly_opening_balance')
                ->whereBetween('date', [$yearStart->format('Y-m-d'), $endDateObj->format('Y-m-d')])
                ->where('ac_head', '!=', '[]')
                ->select('ac_head')
                ->get();
        } else {
            // Fetch data from `daily_opening_balance` for the previous year and up to the day before the start date
            $dailyData = DB::table('daily_opening_balance')
                ->whereBetween('date', [$yearStart->format('Y-m-d'), $startDateObj->format('Y-m-d')])
                ->where('ac_head', '!=', '[]')
                ->select('ac_head')
                ->get();

            // Fetch all yearly data up to the end of the previous year from `yearly_opening_balance`
            $yearlyData = DB::table('yearly_opening_balance')
                ->whereBetween('date', [$previousYearStart->format('Y-m-d'), $previousYearEnd->format('Y-m-d')])
                ->where('ac_head', '!=', '[]')
                ->select('ac_head')
                ->get();

            // Merge the results
            $data = $dailyData->merge($yearlyData);
        }

        return $data;
    }

    // function getOpeningBalanceData($startdate, $endDate) {
    //     // Convert the start date string to a DateTime object
    //     $startDate = new DateTime($startdate);

    //     $yearStart = $startDate->format('Y') . '-07-01';

    //     // Check if the start date is a year start and adjust accordingly
    //     if ($startDate >= new DateTime($yearStart)) {
    //         $yearStart = $startDate->modify('-1 year')->format('Y') . '-07-01';
    //     }

    //     // If the start date is a year start, fetch data from yearly_opening_balance
    //     if ($startDate == new DateTime($yearStart)) {
    //         $data = DB::table('yearly_opening_balance')
    //             ->whereBetween('date', [$yearStart, $endDate])
    //             ->select('ac_head')
    //             ->get();
    //     } else {
    //         // Fetch data from daily_opening_balance for the previous year
    //         $previousYearStart = (new DateTime($yearStart))->modify('-1 year')->format('Y') . '-07-01';
    //         $previousYearEnd = (new DateTime($yearStart))->format('Y') . '-06-30';

    //         $data = DB::table('daily_opening_balance')
    //             ->whereBetween('date', [$previousYearStart, $previousYearEnd])
    //             ->select('ac_head')  // Ensure all selects have the same columns
    //             ->unionAll(
    //                 DB::table('daily_opening_balance')
    //                     ->whereBetween('date', [$yearStart, $endDate])
    //                     ->select('ac_head')  // Ensure all selects have the same columns
    //             )
    //             ->get();
    //     }

    //     return $data;
    // }

    function filterByName($array, $keyword)
    {
        if (!is_array($array)) {
            return [];
        }

        return array_filter($array, function ($item) use ($keyword) {
            return isset($item->name) && $item->name === $keyword;
        });
    }
    public function allPartyLedgerView(Request $request)
    {
        ini_set('max_execution_time', 3600);
        if (Auth::check()) {
            if ($request->isMethod('post')) {
                $start_date = $request->start_date;
                $end_date = $request->end_date;


                $parties = DB::table('party')
                    ->whereRaw("LOWER(name) like '%bills receivable%'")
                    ->orWhereRaw("LOWER(name) like '%bill receivable%'")
                    ->orWhereRaw("LOWER(name) like '%bills receivales%'")
                    ->orWhereRaw("LOWER(name) like '%bills receivabe%'")
                    ->orWhereRaw("LOWER(name) like '%(Processing)%'")
                    ->select('name')
                    ->orderBy('name')
                    ->get();
                // dd($parties);Bills Receivales Rent & Lease

                $selectedAccountName = [
                    "Bills Receivable Of Rent & Lease",
                    "Bills Receivable Of Processing",
                    "Bills Receivable of Fish Processing",
                    "Bills receivable of Fish Processing",
                    "Bills Receivable Of Marine Workshop",
                    "Bills Receivable Of Electric",
                    "Bills Receivable Of  T-head Jetty",
                    "Bills Receivable Of  T-head Jetty",
                    "Bills Receivable Of Multichannel Slipway",
                    "Bills Receivable Of Water  ( T-head Jetty)",
                    "Bills Receivable Of Water T-head jetty",
                    "Bills Receivable Of Water  ( T-head Jetty)",
                    "Bills receivable of Land and Lease",
                    "Bills Receivable Of Water"
                ];

                $allResults = [];
                $count = 0;
                foreach ($parties as $eachParty) {
                    $name = $eachParty->name;

                    $ledgerData = DB::table('voucher_entry')
                        ->select('voucher_no', 'description', 'voucher_date', 'dr_amount', 'cr_amount')
                        ->whereBetween('voucher_date', [$start_date, $end_date])
                        ->whereIn('status', ['pending', 'Done', 'Pending'])
                        ->where(function ($query) use ($name) {
                            $query->where(function ($query) use ($name) {
                                $query->whereIn('voucher_type', ['Journal', 'Payment Voucher'])
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

                    // if ($name === 'Hello There (Bills receivable of marine workshop)') {
                    //     dd($ledgerData);
                    // }
                    $sortedLedgerData = $this->ledgerDataManupulation($ledgerData, $name, $selectedAccountName, $start_date, $end_date);
                    foreach ($sortedLedgerData as $item) {
                        $convertedItem = (object) $item; // Convert array to object

                        if (is_array($convertedItem->dr_amount)) {
                            $convertedItem->dr_amount = new Collection($convertedItem->dr_amount);
                        }

                        if (is_array($convertedItem->cr_amount)) {
                            $convertedItem->cr_amount = new Collection($convertedItem->cr_amount);
                        }

                        $convertedData[] = $convertedItem;
                    }
                    if ($sortedLedgerData) {
                        // dd(gettype($sortedLedgerData[0]));
                        $totalAmount = 0;

                        foreach ($sortedLedgerData as $item) {
                            // dd(count($item->cr_amount));

                            // Check if cr_amount has items (credit)
                            if (count($item->cr_amount) > 0) {
                                // dd(empty($item->cr_amount));
                                $crAmountArray = $item->cr_amount->toArray();
                                if (array_key_exists(0, $crAmountArray)) {
                                    $totalAmount -= intval($item->cr_amount[0]->amount); // Add credit amount from index 0
                                } else if (array_key_exists(1, $crAmountArray)) { // Check for key existence
                                    $totalAmount -= intval($item->cr_amount[1]->amount); // Add credit amount from index 1
                                }
                            }

                            // Check if dr_amount has items (debit)
                            if (count($item->dr_amount) > 0) {
                                $drAmountArray = $item->dr_amount->toArray();
                                if (array_key_exists(0, $drAmountArray)) {
                                    $totalAmount += intval($item->dr_amount[0]->amount); // Subtract debit amount (negate)
                                } else if (array_key_exists(1, $drAmountArray)) {
                                    $totalAmount += intval($item->dr_amount[1]->amount); // Add debit amount
                                }
                            }
                        }
                        $result = [
                            "name" => $name,
                            "amount" => $totalAmount,
                        ];
                        $allResults[] = $result;
                    }
                }

                $bills_Receivables_Of_Processing = [];
                $bills_Receivables_Of_Rent_and_Lease = [];
                $bills_Receivables_Of_Land_and_Lease = [];
                $bills_Receivables_Of_Multichannel = [];
                $bills_Receivables_Of_Multichannel_Slipway = [];
                $bills_Receivables_Of_Multichannel_Slipway_Dockyard = [];
                $bills_Receivables_Of_T_head_Jetty = [];
                $bills_Receivables_Of_Water = [];
                $bills_Receivables_Of_Water_T_head_Jetty = [];
                $bills_Receivables_Of_Electric = [];
                $bills_Receivables_Of_Workshop = [];
                $bills_Receivables_Of_Marine_Workshop = [];
                $other_Bills_Receivables = [];

                foreach ($allResults as &$entry) {
                    $group = preg_replace('/[\[\]()]/', '', $entry["name"]);
                    $standard_group = $this->standardize_group_name($group); //Group Checks are done in this function 
                    $entry["group"] = $standard_group;

                    if ($standard_group === "Bills Receivables Of Processing") {
                        $bills_Receivables_Of_Processing[] = $entry;
                    } else if ($entry["group"] === "Bills Receivables of Processing") {
                        $bills_Receivables_Of_Processing[] = $entry;
                    } else if ($standard_group === "Bills Receivables Rent & Lease") {
                        $bills_Receivables_Of_Rent_and_Lease[] = $entry;
                    } else if ($standard_group === "Bills Receivables of Land and Lease") {
                        $bills_Receivables_Of_Land_and_Lease[] = $entry;
                    } else if ($standard_group === "Bills Receivables Of Multichannel") {
                        $bills_Receivables_Of_Multichannel[] = $entry;
                    } else if ($standard_group === "Bills Receivables Of Multichannel Slipway") {
                        $bills_Receivables_Of_Multichannel[] = $entry;
                    } else if ($standard_group === "Bills Receivables Of Multichannel Slipway Dockyard") {
                        $bills_Receivables_Of_Multichannel[] = $entry;
                    } else if ($standard_group === "Bills Receivables Of T-head Jetty") {
                        $bills_Receivables_Of_T_head_Jetty[] = $entry;
                    } else if ($standard_group === "Bills Receivables Of Water") {
                        $bills_Receivables_Of_Water[] = $entry;
                    } else if ($standard_group === "Bills Receivables Of Water T-head Jetty") {
                        $bills_Receivables_Of_Water_T_head_Jetty[] = $entry;
                    } else if ($standard_group === "Bills Receivables Of Electric") {
                        $bills_Receivables_Of_Electric[] = $entry;
                    } else if ($standard_group === "Bills Receivables Of Workshop") {
                        $bills_Receivables_Of_Marine_Workshop[] = $entry;
                    } else if ($standard_group === "Bills Receivables Of Marine Workshop") {
                        $bills_Receivables_Of_Marine_Workshop[] = $entry;
                    } else {
                        $other_Bills_Receivables[] = $entry;
                    }
                }
                // dd($bills_Receivables_Of_Processing, $bills_Receivables_Of_Rent_and_Lease, $bills_Receivables_Of_Land_and_Lease, $bills_Receivables_Of_Multichannel, $bills_Receivables_Of_Multichannel_Slipway, $bills_Receivables_Of_Multichannel_Slipway_Dockyard, $bills_Receivables_Of_T_head_Jetty, $bills_Receivables_Of_Water, $bills_Receivables_Of_Water_T_head_Jetty, $bills_Receivables_Of_Electric, $bills_Receivables_Of_Workshop, $bills_Receivables_Of_Marine_Workshop, $other_Bills_Receivables);

                // Sort array by standardized group names
                usort($allResults, function ($a, $b) {
                    return strcmp($a["group"], $b["group"]);
                });
                // dd($bills_Receivables_Of_Water);

                return view('super_admin.core_accounting.account_reports.all_party_ledger')->with('ledgerData', $allResults)->with('parties', $parties)->with('partyName', 'All Parties')->with('startDate', $start_date)->with('endDate', $end_date)->with('bills_Receivables_Of_Processing', $bills_Receivables_Of_Processing)->with('bills_Receivables_Of_Rent_and_Lease', $bills_Receivables_Of_Rent_and_Lease)->with('bills_Receivables_Of_Land_and_Lease', $bills_Receivables_Of_Land_and_Lease)->with('bills_Receivables_Of_Multichannel', $bills_Receivables_Of_Multichannel)->with('bills_Receivables_Of_Multichannel_Slipway_Dockyard', $bills_Receivables_Of_Multichannel_Slipway_Dockyard)->with('bills_Receivables_Of_Multichannel_Slipway', $bills_Receivables_Of_Multichannel_Slipway)->with('bills_Receivables_Of_Water_T_head_Jetty', $bills_Receivables_Of_Water_T_head_Jetty)->with('bills_Receivables_Of_Water', $bills_Receivables_Of_Water)->with('bills_Receivables_Of_T_head_Jetty', $bills_Receivables_Of_T_head_Jetty)->with('bills_Receivables_Of_Marine_Workshop', $bills_Receivables_Of_Marine_Workshop)->with('bills_Receivables_Of_Workshop', $bills_Receivables_Of_Workshop)->with('bills_Receivables_Of_Electric', $bills_Receivables_Of_Electric)->with('other_Bills_Receivables', $other_Bills_Receivables);
            } else {
                $parties = party::all();
                return view('super_admin.core_accounting.account_reports.all_party_ledger')->with('ledgerData', null)->with('data2', null)->with('parties', $parties)->with('bills_Receivables_Of_Processing', null)->with('bills_Receivables_Of_Rent_and_Lease', null)->with('bills_Receivables_Of_Land_and_Lease', null)->with('bills_Receivables_Of_Multichannel', null)->with('bills_Receivables_Of_Multichannel_Slipway_Dockyard', null)->with('bills_Receivables_Of_Multichannel_Slipway', null)->with('bills_Receivables_Of_Water_T_head_Jetty', null)->with('bills_Receivables_Of_Water', null)->with('bills_Receivables_Of_T_head_Jetty', null)->with('bills_Receivables_Of_Marine_Workshop', null)->with('bills_Receivables_Of_Workshop', null)->with('bills_Receivables_Of_Electric', null)->with('other_Bills_Receivables', null);
            }
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    function standardize_group_name($name)
    {
        $name = strtolower($name);
        $group_names = [
            "Processing" => "Bills Receivables Of Processing",
            "Bill receivable of Processing" => "Bills Receivables Of Processing",
            "Bill Receivable Of Processing" => "Bills Receivables Of Processing",
            "Bill Receivables Of Processing" => "Bills Receivables Of Processing",
            "Bills Receivable Of Processing" => "Bills Receivables Of Processing",
            "Bills Receivables Of Processing" => "Bills Receivables Of Processing",
            "Bill Receivable of Fish Processing" => "Bills Receivables of Processing",
            "Bill Receivables of Fish Processing" => "Bills Receivables of Processing",
            "Bill Receivables of Fish Processing" => "Bills Receivables of Processing,",
            "Bill receivable of Fish Processing" => "Bills Receivables of Processing",
            "Bills Receivable of Fish Processing" => "Bills Receivables of Processing",
            "Bills Receivables of Fish Processing" => "Bills Receivables of Processing",
            "Bills Receivables of Fish Processing" => "Bills Receivables of Processing,",
            "Bills receivable of Fish Processing" => "Bills Receivables of Processing",
            "Bill receivable of Rent and Lease" => "Bills Receivables Rent & Lease",
            "Bill Receivable Of Rent & Lease" => "Bills Receivables Rent & Lease",
            "Bill Receivable of Rent and Lease" => "Bills Receivables Rent & Lease",
            "Bill Receivabe of Rent & Lease" => "Bills Receivables Rent & Lease",
            "Bill Receivable of  Rent & Lease" => "Bills Receivables Rent & Lease",
            "Bill Receivables Rent & Lease" => "Bills Receivables Rent & Lease",
            "Bill Receivales Rent & Lease" => "Bills Receivables Rent & Lease",
            "Bill receivable of Rent and Lease" => "Bills Receivables Rent & Lease",
            "Bills Receivable Of Rent & Lease" => "Bills Receivables Rent & Lease",
            "Bills Receivable of Rent and Lease" => "Bills Receivables Rent & Lease",
            "Bills Receivabe of Rent & Lease" => "Bills Receivables Rent & Lease",
            "Bills Receivable of  Rent & Lease" => "Bills Receivables Rent & Lease",
            "Bills Receivables Rent & Lease" => "Bills Receivables Rent & Lease",
            "Bills Receivales Rent & Lease" => "Bills Receivables Rent & Lease",
            "Bill receivable of Land and Lease" => "Bills Receivables of Land and Lease",
            "Bill Receivables of Land and Lease" => "Bills Receivables of Land and Lease",
            "Bills receivable of Land and Lease" => "Bills Receivables of Land and Lease",
            "Bills Receivables of Land and Lease" => "Bills Receivables of Land and Lease",
            "Bill Receivable of Multichannel" => "Bills Receivables Of Multichannel",
            "Bill Receivables Of Multichannel" => "Bills Receivables Of Multichannel",
            "Bills Receivable of Multichannel" => "Bills Receivables Of Multichannel",
            "Bills Receivables Of Multichannel" => "Bills Receivables Of Multichannel",
            "Bill Receivable Of Multichannel Slipway" => "Bills Receivables Of Multichannel Slipway",
            "Bill Receivables Of Multichannel Slipway" => "Bills Receivables Of Multichannel Slipway",
            "Bills Receivable Of Multichannel Slipway" => "Bills Receivables Of Multichannel Slipway",
            "Bills Receivables Of Multichannel Slipway" => "Bills Receivables Of Multichannel Slipway",
            "Bill Receivable of Multichannel Slipway Dockyard" => "Bills Receivables Of Multichannel Slipway Dockyard",
            "Bill Receivables Of Multichannel Slipway Dockyard" => "Bills Receivables Of Multichannel Slipway Dockyard",
            "Bills Receivable of Multichannel Slipway Dockyard" => "Bills Receivables Of Multichannel Slipway Dockyard",
            "Bills Receivables Of Multichannel Slipway Dockyard" => "Bills Receivables Of Multichannel Slipway Dockyard",
            "bill receivable of T head Jetty" => "Bills Receivables Of T-head Jetty",
            "Bill Receivable Of T-head Jetty" => "Bills Receivables Of T-head Jetty",
            "Bill receivable of T-head Jetty " => "Bills Receivables Of T-head Jetty",
            "Bill Receivables of T - head Jetty" => "Bills Receivables Of T-head Jetty",
            "Bill receivable Of  T-head Jetty" => "Bills Receivables Of T-head Jetty",
            "Bill Receivables Of T-head Jetty" => "Bills Receivables Of T-head Jetty",
            "bills receivable of T head Jetty" => "Bills Receivables Of T-head Jetty",
            "Bills Receivable Of T-head Jetty" => "Bills Receivables Of T-head Jetty",
            "Bills receivable of T-head Jetty " => "Bills Receivables Of T-head Jetty",
            "Bills Receivables of T - head Jetty" => "Bills Receivables Of T-head Jetty",
            "Bills receivable Of  T-head Jetty" => "Bills Receivables Of T-head Jetty",
            "Bill receivable of T-head Jetty" => "Bills Receivables Of T-head Jetty",
            "Bills Receivables Of T-head Jetty" => "Bills Receivables Of T-head Jetty",
            "Bill Receivable of Water T-head Jetty" => "Bills Receivables Of Water T-head Jetty",
            "Bill Receivables of Water T - head Jetty" => "Bills Receivables Of Water T-head Jetty",
            "Bill Receivables Water T-head Jetty" => "Bills Receivables Of Water T-head Jetty",
            "Bill Receivables Of Water T-head Jetty" => "Bills Receivables Of Water T-head Jetty",
            "Bills Receivable of Water T-head Jetty" => "Bills Receivables Of Water T-head Jetty",
            "Bill receivable of Water T-head Jetty" => "Bills Receivables Of Water T-head Jetty",
            "Bills Receivables of Water T - head Jetty" => "Bills Receivables Of Water T-head Jetty",
            "Bills Receivables Water T-head Jetty" => "Bills Receivables Of Water T-head Jetty",
            "Bills Receivables Of Water T-head Jetty" => "Bills Receivables Of Water T-head Jetty",
            "Bill receivable of Water" => "Bills Receivables Of Water",
            "Bill Receivable Of Water " => "Bills Receivables Of Water",
            "Bills receivable of Water" => "Bills Receivables Of Water",
            "Bills Receivable Of Water " => "Bills Receivables Of Water",
            "Bill Receivables Electric" => "Bills Receivables Of Electric",
            "Bill Receivables Of Electric" => "Bills Receivables Of Electric",
            "Bill Receivable Of Electric" => "Bills Receivables Of Electric",
            "Bills Receivables Electric" => "Bills Receivables Of Electric",
            "Bills Receivables Of Electric" => "Bills Receivables Of Electric",
            "Bills Receivable Of Electric" => "Bills Receivables Of Electric",
            "Bill Receivables Of workshop" => "Bills Receivables Of Marine Workshop",
            "Bill Receivables of workshop" => "Bills Receivables Of Marine Workshop",
            "Bill receivables of workshop" => "Bills Receivables Of Marine Workshop",
            "Bill receivable of workshop" => "Bills Receivables Of Marine Workshop",
            "bill receivable of workshop" => "Bills Receivables Of Marine Workshop",
            "Bills Receivables Of workshop" => "Bills Receivables Of Marine Workshop",
            "Bills Receivables of workshop" => "Bills Receivables Of Marine Workshop",
            "Bills receivables of workshop" => "Bills Receivables Of Marine Workshop",
            "Bills receivable of workshop" => "Bills Receivables Of Marine Workshop",
            "bills receivable of workshop" => "Bills Receivables Of Marine Workshop",
            "Bill Receivables Marine Workshop" => "Bills Receivables Of Marine Workshop",
            "Bill Receivables Of Marine Workshop" => "Bills Receivables Of Marine Workshop",
            "Bill Receivable Of Marine Workshop" => "Bills Receivables Of Marine Workshop",
            "Bills Receivables Marine Workshop" => "Bills Receivables Of Marine Workshop",
            "Bills Receivables Of Marine Workshop" => "Bills Receivables Of Marine Workshop",
            "Bill receivable of Marine Workshop" => "Bills Receivables Of Marine Workshop",
            "Bills Receivable Of Marine Workshop" => "Bills Receivables Of Marine Workshop"
        ];

        foreach ($group_names as $key => $standard) {
            if (strpos($name, strtolower($key)) !== false) {
                return $standard;
            }
        }
        // dd($name);
        return "Unknown Group";
    }
    public function partyLedgerView(Request $request)
    {
        if (Auth::check()) {
            if ($request->isMethod('post')) {
                $parties = party::all();
                $name = $request->name1;
                $start_date = $request->start_date;
                $end_date = $request->end_date;
                $name1 = $request->name1;

                $ledgerData = DB::table('voucher_entry')
                    ->select('voucher_no', 'description', 'voucher_date', 'dr_amount', 'cr_amount')
                    ->whereBetween('voucher_date', [$start_date, $end_date])
                    ->whereIn('status', ['pending', 'Done', 'Pending'])
                    ->where(function ($query) use ($name) {
                        $query->where(function ($query) use ($name) {
                            $query->whereIn('voucher_type', ['Journal', 'Payment Voucher'])
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
                    "Bills Receivable Of  T-head Jetty",
                    "Bills Receivable Of Multichannel Slipway",
                    "Bills Receivable Of Water  ( T-head Jetty)",
                    "Bills Receivable Of Water T-head jetty",
                    "Bills Receivable Of Water  ( T-head Jetty)",
                    "Bills receivable of Land and Lease"
                ];
                // dd($ledgerData);
                $sortedLedgerData = $this->ledgerDataManupulation($ledgerData, $name, $selectedAccountName, $start_date, $end_date);
                $openingBalance = 0;
                $dailyOpeningBalanceData = $this->getPartyOpeningBalanceData($start_date, $end_date);
                foreach ($dailyOpeningBalanceData as $dailyOpeningBalance) {
                    $dailyOpeningBalanceArray = (array) $dailyOpeningBalance;
                    $allOpeningBalance = json_decode($dailyOpeningBalanceArray['party']);
                    // dd($dailyOpeningBalanceData, $allOpeningBalance);
                    foreach ($allOpeningBalance as $balance) {
                        if ($balance->name === $selectedAccountName) {
                            $openingBalance += $balance->amount;
                        }
                    }
                }
                // if($openingBalance !== 0) {
                //     dd($openingBalance);
                // }
                // dd($sortedLedgerData);
                return view('super_admin.core_accounting.account_reports.party_ledger')->with('ledgerData', $sortedLedgerData)->with('parties', $parties)->with('partyName', $name)->with('startDate', $start_date)->with('endDate', $end_date)->with('openingBalance', $openingBalance);
            } else {
                $parties = party::all();
                return view('super_admin.core_accounting.account_reports.party_ledger')->with('ledgerData', null)->with('data2', null)->with('parties', $parties)->with('openingBalance', null);
            }
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    function getPartyOpeningBalanceData($startDate, $endDate)
    {
        // Convert the start and end date strings to DateTime objects
        $startDateObj = new DateTime($startDate);
        $endDateObj = new DateTime($endDate);

        // Calculate the start of the financial year (July 1st) for the start date year
        $yearStart = (new DateTime($startDateObj->format('Y') . '-07-01'));

        // If the start date is not July 1st, adjust year start to previous July 1st
        if ($startDateObj < $yearStart) {
            $yearStart->modify('-1 year');
        }

        // Prepare the previous year’s start and end dates for `daily_opening_balance`
        $previousYearStart = (clone $yearStart)->modify('-1 year');
        $previousYearEnd = (clone $yearStart)->modify('-1 day');  // One day before the current year start

        // Check if the start date is exactly July 1st of any year
        if ($startDateObj == $yearStart) {
            // Fetch data from `yearly_opening_balance` table for the entire date range
            $data = DB::table('yearly_opening_balance')
                ->whereBetween('date', [$yearStart->format('Y-m-d'), $endDateObj->format('Y-m-d')])
                ->where('party', '!=', '[]')
                ->select('party')
                ->get();
        } else {
            // Fetch data from `daily_opening_balance` for the previous year and up to the day before the start date
            $dailyData = DB::table('daily_opening_balance')
                ->whereBetween('date', [$yearStart->format('Y-m-d'), $startDateObj->format('Y-m-d')])
                ->where('party', '!=', '[]')
                ->select('party')
                ->get();

            // Fetch all yearly data up to the end of the previous year from `yearly_opening_balance`
            $yearlyData = DB::table('yearly_opening_balance')
                ->whereBetween('date', [$previousYearStart->format('Y-m-d'), $previousYearEnd->format('Y-m-d')])
                ->where('party', '!=', '[]')
                ->select('party')
                ->get();

            // Merge the results
            $data = $dailyData->merge($yearlyData);
        }

        return $data;
    }

    public function ledgerDataManupulation($ledgerData, $name1, $selectedAccountName, $startDate, $endDate)
    {
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
                    if ($name1 != "") {
                        $r_data_table = DB::table('collection_entry')
                            ->whereIn('id', $numbers)
                            ->whereBetween('collection_date', [$startDate, $endDate])
                            ->select('id', 'dr_amount', 'cr_amount', 'collection_date')
                            ->where('customer_name', $name1)
                            ->get();
                    } else {
                        $r_data_table = DB::table('collection_entry')
                            ->whereIn('id', $numbers)
                            ->whereBetween('collection_date', [$startDate, $endDate])
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
                    if ($name1 != "") {
                        $r_data_table = DB::table('collection_entry')
                            ->whereIn('id', $numbers)
                            ->whereBetween('collection_date', [$startDate, $endDate])
                            ->select('id', 'dr_amount', 'cr_amount', 'collection_date')
                            ->where('customer_name', $name1)
                            ->get();
                    } else {
                        $r_data_table = DB::table('collection_entry')
                            ->whereIn('id', $numbers)
                            ->whereBetween('collection_date', [$startDate, $endDate])
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
                    ->whereBetween('voucher_date', [$startDate, $endDate])
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
                if (strpos($item->description, 'Multiple vouchers added:') !== true) {
                    if (strpos($item->description, 'Voucher ID: ') !== true) {
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

    public function transformElement($element)
    {
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
        if (Auth::check()) {
            return view('super_admin.core_accounting.account_reports.control_ac_summary');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function controlACBalanceView()
    {
        if (Auth::check()) {
            return view('super_admin.core_accounting.account_reports.control_ac_balance');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function bankReconciliationStatementView()
    {
        if (Auth::check()) {
            return view('super_admin.core_accounting.account_reports.bank_reconciliation_statement');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function ugcMonthlyStatementView()
    {
        if (Auth::check()) {
            return view('super_admin.core_accounting.account_reports.ugc_monthly_statement');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function cancelledVoucherView()
    {
        if (Auth::check()) {
            return view('super_admin.core_accounting.account_reports.cancelled_voucher');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function voucherByDateView()
    {
        if (Auth::check()) {
            return view('super_admin.core_accounting.account_reports.voucher_by_date');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function advanceRegisterView()
    {
        if (Auth::check()) {
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
                // dd($final_data);
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

    public function profitLossCalculation($startDate, $endDate)
    {
        $sub_ac = ['Others Income', 'Non-operating Expenses', 'Administrative Expenditure'];
        $sub_ac_trading = ['Sales and Services', 'Services', 'Operational Expenditure'];

        $final_data = $this->tradingAccountCalculation($startDate, $endDate, $sub_ac);
        $final_trading_data = $this->tradingAccountCalculation($startDate, $endDate, $sub_ac_trading);
        $final_trading_amount = 0;
        foreach ($final_trading_data as $key => $value) {
            $final_trading_amount = $final_trading_amount + $value->amount;
        }

        $tradingProfit = (object)[
            'account_group' => 'Income',
            'subsidiary_account_name' => 'Others Income',
            'control_account' => 'Trading Profit',
            'amount' => $final_trading_amount
        ];

        $consolidatedData = array_merge([$tradingProfit], $final_data);

        return $consolidatedData;
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

                $sub_ac = ['Sales and Services', 'Services', 'Operational Expenditure'];

                $final_data = $this->tradingAccountCalculation($startDate, $endDate, $sub_ac);
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

    public function tradingAccountCalculation($startDate, $endDate, $sub_ac)
    {
        $all_contol_names = control_ac::distinct()
            ->select('accounts_group', 'subsidiary_account_name', 'account_name')
            ->whereIn('subsidiary_account_name', $sub_ac)
            ->get()
            ->toArray();

        // dd($all_contol_names, $sub_ac);

        $ledgerData = DB::table('daily_data')
            ->whereBetween('voucher_date', [$startDate, $endDate])
            ->select('ac_head')
            ->get();

        $acHeadNames = DB::table('ac_head')
            ->select('ac_head.ac_head_name_eng', 'control_ac.accounts_group', 'control_ac.subsidiary_account_name', 'control_ac.account_name')
            ->join('control_ac', 'ac_head.control_ac_id', '=', 'control_ac.account_id')
            ->whereIn('control_ac.subsidiary_account_name', $sub_ac)
            ->get()
            ->toArray();

        $filteredLedgerData = $this->tredingAccountCalculation($ledgerData, $all_contol_names, $acHeadNames);
        // dd($filteredLedgerData, $acHeadNames);

        return $filteredLedgerData;
    }

    public function tredingAccountCalculation($ledgerData, $contol_name, $acHeadNames)
    {
        $dailyData = [];
        foreach ($ledgerData as $data) {
            $decodedData = json_decode($data->ac_head, true);
            $dailyData[] = $decodedData;
            // dd($decodedData);
            // $dailyData = array_merge($previous_data, $decodedData); 
        }
        $mergedArray = [];
        foreach ($dailyData as $currentArray) {
            // Iterate through each item in the current array
            foreach ($currentArray as $item) {
                // Check if the item with similar criteria already exists in the merged array
                $existingKey = array_search($item, $mergedArray);

                if ($existingKey !== false) {
                    // If exists, add the 'amount' values
                    $mergedArray[$existingKey]['amount'] += $item['amount'];
                } else {
                    // If not exists, add the current item to the merged array
                    $mergedArray[] = $item;
                }
            }
        }

        $newArray = [];
        $yourArray = $mergedArray;
        // Loop through the given array
        $totals = [];

        foreach ($yourArray as $item) {
            $key = $item['account_group'] . '-_-' . $item['subsidiary_account_name'] . '-_-' . $item['name'];

            // If the key exists in the totals array, update the amount
            if (isset($totals[$key])) {
                $totals[$key] += $item['amount'];
            } else {
                // Otherwise, add the key to the totals array with the current amount
                $totals[$key] = $item['amount'];
            }
        }

        // Create the new array using the totals
        foreach ($totals as $key => $amount) {
            list($account_group, $subsidiary_account_name, $name) = explode('-_-', $key);

            $newArray[] = [
                'account_group' => $account_group,
                'subsidiary_account_name' => $subsidiary_account_name,
                'control_account' => $name,
                'amount' => $amount,
            ];
        }

        // Sort the new array based on account_group and subsidiary_account_name
        usort($newArray, function ($a, $b) {
            if ($a['account_group'] == $b['account_group']) {
                return strcmp($a['subsidiary_account_name'], $b['subsidiary_account_name']);
            }
            return strcmp($a['account_group'], $b['account_group']);
        });

        $mergedData = [];
        foreach ($newArray as $individualNewArray) {
            foreach ($contol_name as $individualControlName) {
                if ($individualControlName['account_name'] === $individualNewArray['control_account']) {
                    // dd($individualControlName['account_name'], $individualNewArray['name']);
                    // $mergedData[] = $individualNewArray;
                    $mergedData[] = (object) [
                        'account_group' => $individualNewArray['account_group'],
                        'subsidiary_account_name' => $individualNewArray['subsidiary_account_name'],
                        'amount' => $individualNewArray['amount'],
                        'control_account' => $individualNewArray['control_account'],
                    ];
                }
            }
        }
        // dd($mergedData);
        return $mergedData;
    }

    public function balanceSheetView(Request $request)
    {
        if (Auth::check()) {
            if ($request->isMethod('post')) {
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                $profit_loss_data = $this->profitLossCalculation($startDate, $endDate);

                // Create an array to store the totals
                // $profit_loss_totals = 0;

                // foreach ($profit_loss_data as $pl_data) {
                //     $profit_loss_totals += abs($pl_data["amount"]);
                // }

                $incomeTotal = 0;
                $expensesTotal = 0;

                foreach ($profit_loss_data as $item) {
                    if ($item->account_group === 'Income') {
                        $incomeTotal += $item->amount;
                    } elseif ($item->account_group === 'Expenses') {
                        $expensesTotal += $item->amount;
                    }
                }

                // Calculate the final result
                $profit_loss_totals = $incomeTotal - $expensesTotal;

                // Create a single entry for "Profit & Loss" with the total amount
                $profit_loss_formattedData = [
                    [
                        "account_group" => "Provision For Adiustiment",
                        "subsidiary_account_name" => "Profit & Loss",
                        "name" => "Profit & Loss",
                        "totalAmount" => $profit_loss_totals,
                    ],
                ];
                // dd($profit_loss_data, $profit_loss_formattedData);

                $records = ($request->isMethod('post'))
                    ? voucher_entry::whereBetween('voucher_date', [$startDate, $endDate])->get()
                    : voucher_entry::all();

                //Control Account and Account Head hable Marged and get data
                $combine_data = DB::table('control_ac')
                    ->join('ac_head', 'control_ac.account_id', '=', 'ac_head.control_ac_id')
                    ->select('control_ac.accounts_group', 'control_ac.subsidiary_account_name', 'control_ac.account_name', 'ac_head.ac_head_name_eng')
                    ->whereIn('control_ac.subsidiary_account_name', ['Current Assets', 'Other Investments', 'Capital & Liabilities', 'Grant in Aid', 'Current Libilities', 'Provision For Adjustment'])
                    ->get();

                $sub_ac = ['Current Assets', 'Other Investments', 'Capital & Liabilities', 'Grant in Aid', 'Current Libilities', 'Provision For Adjustment'];

                $final_main_data = $this->tradingAccountCalculation($startDate, $endDate, $sub_ac);

                $fixed_assets_data = DB::table('daily_data')
                    ->whereBetween('voucher_date', [$startDate, $endDate])
                    ->whereNotNull('control_ac')
                    ->select('control_ac')
                    ->get();
                $final_fixed_assets_data = [];
                $final_fixed_assets_dr = 0;
                $final_fixed_assets_cr = 0;
                foreach ($fixed_assets_data as $dada) {
                    if ($dada->control_ac != null) {
                        $final_fixed_assets = json_decode($dada->control_ac);

                        // dd("Done");
                    }
                }
                // dd($fixed_assets_data);

                $drAmountSum = [];
                $crAmountSum = [];
                $totalDrAmount = 0;
                $totalCrAmount = 0;
                $result = [];

                foreach ($records as $record) {
                    $drAmount = json_decode($record->dr_amount, true);
                    $crAmount = json_decode($record->cr_amount, true);
                    // dd($drAmount, $crAmount);
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
                // dd($totalCrAmount);
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
                // dd($result);
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

                // dd($fixed_assets_data);
                $totalDrAmount2 = 0;
                $totalCrAmount2 = 0;
                $idextcount = 0;
                foreach ($fixed_assets_data as $item2) {
                    if ($item2->control_ac === null) {
                        break;
                    } else if ($item2->control_ac === 0) {
                        break;
                    } else {
                        $item3 = json_decode($item2->control_ac);
                        // if($idextcount > 0){
                        //     dd($item3);
                        // }

                        $totalDrAmount2 += $item3->dr_amount;
                        $totalCrAmount2 += $item3->cr_amount;
                        $idextcount++;
                    }
                }
                // dd($totalDrAmount2, $totalCrAmount2);

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

                // dd($sortedData, $final_main_data, $fixed_assets_output, $profit_loss_formattedData);

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
        if (Auth::check()) {
            return view('super_admin.core_accounting.account_reports.advance_summary');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function profitMarginView()
    {
        if (Auth::check()) {
            return view('super_admin.core_accounting.account_reports.profit_margin');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }
}
