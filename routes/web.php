<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CoreAccountingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [CustomAuthController::class, 'firstpage']);

Route::get('dashboard', [CustomAuthController::class, 'dashboard']);
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

/* --------------------------------------------------------------------------
                Core Accounting - Account Setup
-------------------------------------------------------------------------- */

//Subcidiary Account Route
Route::get('subsidiary-accounts', [CoreAccountingController::class, 'subsidiaryAccountsView']);
Route::post('subsidiary_ac_post', [CoreAccountingController::class, 'subsidiary_ac_post'])->name('subsidiary_ac_post');
Route::post('subsidiary_ac_update', [CoreAccountingController::class, 'subsidiary_ac_update'])->name('subsidiary_ac_update');
Route::post('subsidiary_ac_delete', [CoreAccountingController::class, 'subsidiary_ac_delete'])->name('subsidiary_ac_delete');

//Control Account Route
Route::get('control-accounts', [CoreAccountingController::class, 'controlAccountsView']);
Route::post('control_ac_post', [CoreAccountingController::class, 'control_ac_post'])->name('control_ac_post');
Route::post('control_ac_update', [CoreAccountingController::class, 'control_ac_update'])->name('control_ac_update');
Route::post('control_ac_delete', [CoreAccountingController::class, 'control_ac_delete'])->name('control_ac_delete');

//Control Account Route
Route::get('accounts-head-setup', [CoreAccountingController::class, 'accountsHeadSetupView']);
Route::post('account_head_post', [CoreAccountingController::class, 'account_head_post'])->name('account_head_post');
Route::post('account_head_update', [CoreAccountingController::class, 'account_head_update'])->name('account_head_update');
Route::post('account_head_delete', [CoreAccountingController::class, 'account_head_delete'])->name('account_head_delete');

//Office Chief Route
Route::get('office-chief-setup', [CoreAccountingController::class, 'officeChiefSetupView']);
Route::post('office_chief_post', [CoreAccountingController::class, 'office_chief_post'])->name('office_chief_post');
Route::post('office_chief_update', [CoreAccountingController::class, 'office_chief_update'])->name('office_chief_update');
Route::post('office_chief_delete', [CoreAccountingController::class, 'office_chief_delete'])->name('office_chief_delete');


Route::get('link-heads-setup', [CoreAccountingController::class, 'linkHeadsSetupView']);

//Party Route
Route::get('party-setup', [CoreAccountingController::class, 'partySetupView']);
Route::post('party_post', [CoreAccountingController::class, 'party_post'])->name('party_post');
Route::post('party_update', [CoreAccountingController::class, 'party_update'])->name('party_update');
Route::post('party_delete', [CoreAccountingController::class, 'party_delete'])->name('party_delete');

// Core Accounting - Budget
Route::get('budget-entry', [CoreAccountingController::class, 'budgetEntryView']);

// CoreAccounting - Collection
Route::get('collection-entry', [CoreAccountingController::class, 'collectionEntryView']);
Route::post('collection_entry_post', [CoreAccountingController::class, 'collection_entry_post'])->name('collection_entry_post');
Route::post('collection_entry_update', [CoreAccountingController::class, 'collection_entry_update'])->name('collection_entry_update');
Route::post('collection_entry_delete', [CoreAccountingController::class, 'collection_entry_delete'])->name('collection_entry_delete');

Route::get('view-details-page/{id}', [CoreAccountingController::class, 'view_details_page'])->name('view_details_page');

// Core Accounting - Vouchers
Route::get('vouchers-entry', [CoreAccountingController::class, 'vouchersEntryView'])->name('vouchers-entry');;
Route::post('vouchers_entry_post', [CoreAccountingController::class, 'vouchers_entry_post'])->name('vouchers_entry_post');
Route::post('vouchers_entry_update', [CoreAccountingController::class, 'vouchers_entry_update'])->name('vouchers_entry_update');
Route::post('vouchers_entry_delete', [CoreAccountingController::class, 'vouchers_entry_delete'])->name('vouchers_entry_delete');

Route::get('voucher-details-page/{id}', [CoreAccountingController::class, 'voucher_details_page'])->name('voucher_details_page');

// Route::get('vouchers-searching', [CoreAccountingController::class, 'vouchersSearchingView']);
Route::match(['get', 'post'], 'vouchers-searching', [CoreAccountingController::class, 'vouchersSearchingView'])->name('vouchersSearching');

Route::get('cash-collection-voucher', [CoreAccountingController::class, 'cashCollectionVoucherView']);
Route::post('cash_voucher_update', [CoreAccountingController::class, 'cash_voucher_update'])->name('cash_voucher_update');

Route::get('journal-voucher', [CoreAccountingController::class, 'journalVoucherView']);
Route::get('journal-details-page/{id}', [CoreAccountingController::class, 'voucher_details_page'])->name('journal_details_page');
Route::get('journal-voucher-filter', [CoreAccountingController::class, 'journalVoucherFilter'])->name('journalVoucherFilter');
Route::post('journal-voucher-merge', [CoreAccountingController::class, 'journal_voucher_merge'])->name('journal_voucher_merge');
Route::post('journal-voucher-delete', [CoreAccountingController::class, 'journal_voucher_delete'])->name('journal_voucher_delete');
Route::get('cheque-approved', [CoreAccountingController::class, 'chequeApprovedView']);

// Core Accounting - Account Reports
Route::get('chart-of-accounts', [CoreAccountingController::class, 'chartOfAccountsView']);
Route::match(['get', 'post'], 'trial-balance', [CoreAccountingController::class, 'trialBalanceView'])->name('trial_balance');

Route::get('bank-book', [CoreAccountingController::class, 'bankBookView']);
Route::match(['get', 'post'], 'sub-ac-ledger', [CoreAccountingController::class, 'subACLedgerView'])->name('subACLedgerView');
Route::match(['get', 'post'], 'control-ac-ledger', [CoreAccountingController::class, 'controlACLedgerView'])->name('controlACLedgerView');
Route::match(['get', 'post'], 'ac-head-ledger', [CoreAccountingController::class, 'acHeadLedgerView'])->name('acHeadLedgerView');
Route::match(['get', 'post'], 'party-ledger', [CoreAccountingController::class, 'partyLedgerView'])->name('partyLedgerView');
Route::get('control-ac-summary', [CoreAccountingController::class, 'controlACSummaryView']);
Route::get('control-ac-balance', [CoreAccountingController::class, 'controlACBalanceView']);
Route::get('bank-reconciliation-statement', [CoreAccountingController::class, 'bankReconciliationStatementView']);
Route::get('ugc-monthly-statement', [CoreAccountingController::class, 'ugcMonthlyStatementView']);
Route::get('cancelled-voucher', [CoreAccountingController::class, 'cancelledVoucherView']);
Route::get('voucher-by-date', [CoreAccountingController::class, 'voucherByDateView']);
Route::get('advance-register', [CoreAccountingController::class, 'advanceRegisterView']);
// Route::get('profit-loss-account', [CoreAccountingController::class, 'profitLossAccountView']);
Route::match(['get', 'post'], 'profit-loss-account', [CoreAccountingController::class, 'profitLossAccountView'])->name('profitLossAccountView');
// Route::get('tranding-account', [CoreAccountingController::class, 'trandingAccountView']);
Route::match(['get', 'post'], 'tranding-account', [CoreAccountingController::class, 'trandingAccountView'])->name('trandingAccountView');
// Route::get('balancesheet', [CoreAccountingController::class, 'balanceSheetView']);
Route::match(['get', 'post'], 'balancesheet', [CoreAccountingController::class, 'balanceSheetView'])->name('balanceSheetView');
Route::get('advance-summary', [CoreAccountingController::class, 'advanceSummaryView']);
Route::get('profit-margin', [CoreAccountingController::class, 'profitMarginView']);