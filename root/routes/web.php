<?php

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

/* AUTHENTICATION --------------------------*/
	Route::get('/login', 'AuthController@view')->name('login');
	Route::post('/login', 'AuthController@login');
	Route::get('/logout', 'AuthController@logout')->name('login');
/* AUTHENTICATION --------------------------*/

Route::group(['middleware'=>['checkauth']], function () {
	// Route::group(['middleware'=>['group_rights']], function () {
		// Index Route
		Route::get('/', 'HomeController@home')->name('home');
		// $test = "GAGO";
		// Route::get('/', function() use ($test){
		// 	return dd($test); //'HomeController@home'
		// })->name('home');
		/* MASTER FILE --------------------------*/
		Route::prefix('master-file')->group(function(){
			/* --- ACCOUNTING ----------*/

			Route::prefix('accounting')->group(function(){ 
				/* --- FUND ----------*/
				Route::prefix('fund')->group(function(){ // DONE -m
					Route::get('', 'MFile\Accounting\c_fund@view');
					Route::post('', 'MFile\Accounting\c_fund@add');
					Route::post('update', 'MFile\Accounting\c_fund@update');
					Route::post('delete', 'MFile\Accounting\c_fund@delete');
				});
				/* --- FUND ----------*/

				/* --- MAIN ACCOUNT ----------*/
				Route::prefix('main-account')->group(function(){ // DONE -m
					Route::get('/', 'MFile\Accounting\c_main_account@view');
					Route::post('', 'MFile\Accounting\c_main_account@add');
					Route::post('update', 'MFile\Accounting\c_main_account@update');
					Route::post('delete', 'MFile\Accounting\c_main_account@delete');
				});
				/* --- MAIN ACCOUNT ----------*/

				/* --- SUB ACCOUNT ----------*/
				Route::prefix('sub-account')->group(function(){ // DONE -m
					Route::get('', 'MFile\Accounting\c_sub_account@view');
					Route::post('', 'MFile\Accounting\c_sub_account@add');
					Route::post('update', 'MFile\Accounting\c_sub_account@update');
					Route::post('delete', 'MFile\Accounting\c_sub_account@delete');
				});
				/* --- SUB ACCOUNT ----------*/

				/* --- ACCOUNT GROUP ----------*/
				Route::prefix('account-group')->group(function(){ // DONE -m
					Route::get('', 'MFile\Accounting\c_account_group@view');
					Route::post('', 'MFile\Accounting\c_account_group@add');
					Route::post('update', 'MFile\Accounting\c_account_group@update');
					Route::post('delete', 'MFile\Accounting\c_account_group@delete');
				});
				/* --- ACCOUNT GROUP ----------*/

				/* --- ACCOUNT TITLE ----------*/
				Route::prefix('account-title')->group(function(){ // DONE -m
					Route::get('', 'MFile\Accounting\c_account_title@view');
					Route::post('', 'MFile\Accounting\c_account_title@add');
					Route::post('update', 'MFile\Accounting\c_account_title@update');
					Route::post('delete', 'MFile\Accounting\c_account_title@delete');
				});
				/* --- ACCOUNT TITLE ----------*/

				/* --- JOURNAL ----------*/
				Route::prefix('journal')->group(function(){ // DONE -m
					Route::get('', 'MFile\Accounting\c_journal@view');
					Route::post('', 'MFile\Accounting\c_journal@add');
					Route::post('update', 'MFile\Accounting\c_journal@update');
					Route::post('delete', 'MFile\Accounting\c_journal@delete');
				});
				/* --- JOURNAL ----------*/

				/* --- DEBTORS ----------*/
				Route::prefix('debtors')->group(function(){ // DONE -m
					Route::get('', 'MFile\Accounting\c_debtor@view');
					Route::post('', 'MFile\Accounting\c_debtor@add');
					Route::post('update', 'MFile\Accounting\c_debtor@update');
					Route::post('delete', 'MFile\Accounting\c_debtor@delete');
				});
				/* --- DEBTORS ----------*/

				/* --- CREDITORS ----------*/
				Route::prefix('creditors')->group(function(){ // DONE -m
					Route::get('', 'MFile\Accounting\c_creditor@view');
					Route::post('', 'MFile\Accounting\c_creditor@add');
					Route::post('update', 'MFile\Accounting\c_creditor@update');
					Route::post('delete', 'MFile\Accounting\c_creditor@delete');
				});
				/* --- CREDITORS ----------*/

				/* --- COST CENTER ----------*/
				Route::prefix('cost-center')->group(function(){ // DONE -m
					Route::get('', 'MFile\Accounting\c_cost_center@view');
					Route::post('', 'MFile\Accounting\c_cost_center@add');
					Route::post('update', 'MFile\Accounting\c_cost_center@update');
					Route::post('delete', 'MFile\Accounting\c_cost_center@delete');
					Route::get('getupdatedetails/{code}', 'MFile\Accounting\c_cost_center@getupdate');
				});
				/* --- COST CENTER ----------*/

				/* --- SUB COST CENTER ----------*/
				Route::prefix('sub-cost-center')->group(function(){ // DONE -m
					Route::get('', 'MFile\Accounting\c_sub_cost_center@view');
					Route::post('', 'MFile\Accounting\c_sub_cost_center@add');
					Route::post('update', 'MFile\Accounting\c_sub_cost_center@update');
					Route::post('delete', 'MFile\Accounting\c_sub_cost_center@delete');
				});
				/* --- SUB COST CENTER ----------*/

				/* --- ACCOUNTING PERIOD ----------*/
				// Route::prefix('accounting-periods')->group(function(){
				// 	Route::get('', 'MFile\Accounting\c_account_period@view');
				// 	Route::post('', 'MFile\Accounting\c_account_period@add');
				// });
				/* --- ACCOUNTING PERIOD ----------*/

				/* --- BUDGET PERIOD ----------*/
				Route::prefix('budget-period')->group(function(){ // DONE -m
					Route::get('', 'MFile\Accounting\c_budget_period@view');
					Route::post('', 'MFile\Accounting\c_budget_period@add');
				});
				/* --- BUDGET PERIOD ----------*/

				/* --- CHARGES ----------*/
				Route::prefix('charges')->group(function(){ // DONE -m
					Route::get('', 'MFile\Accounting\c_charge@view');
					Route::get('getSubCostCenter', 'MFile\Accounting\c_charge@getSubCosts');
					Route::post('', 'MFile\Accounting\c_charge@add');
					Route::post('update', 'MFile\Accounting\c_charge@update');
					Route::post('delete', 'MFile\Accounting\c_charge@delete');
				});
				/* --- CHARGES ----------*/

				/* --- OR TYPES ----------*/
				Route::prefix('or_types')->group(function(){ // DONE -m
					Route::get('', 'MFile\Accounting\c_or_type@view');
					Route::post('', 'MFile\Accounting\c_or_type@add');
					Route::post('update', 'MFile\Accounting\c_or_type@update');
					Route::post('delete', 'MFile\Accounting\c_or_type@delete');
				});
				/* --- OR TYPES ----------*/

				/* --- SECTOR ----------*/
				Route::prefix('sector')->group(function(){ // DONE -m
					Route::get('', 'MFile\Accounting\c_sector@view');
					Route::post('', 'MFile\Accounting\c_sector@add');
					Route::post('update', 'MFile\Accounting\c_sector@update');
					Route::post('delete', 'MFile\Accounting\c_sector@delete');
				});
				/* --- SECTOR ----------*/

				/* --- FUNCTION ----------*/
				Route::prefix('function')->group(function(){ // DONE -m
					Route::get('', 'MFile\Accounting\c_function@view');
					Route::post('', 'MFile\Accounting\c_function@add');
					Route::post('update', 'MFile\Accounting\c_function@update');
					Route::post('delete', 'MFile\Accounting\c_function@delete');
				});
				/* --- FUNCTION ----------*/
				/* --- FPP ----------*/
				Route::prefix('fpp')->group(function(){ // DONE -m
					Route::get('', 'MFile\Accounting\c_fpp@view');
					Route::post('', 'MFile\Accounting\c_fpp@add');
					Route::post('update', 'MFile\Accounting\c_fpp@update');
					Route::post('delete', 'MFile\Accounting\c_fpp@delete');
				});
				/* --- FPP ----------*/
			});
			/* --- ACCOUNTING ----------*/


			/* --- INVENTORY ----------*/
			Route::prefix('inventory')->group(function(){

				/* --- BRAND NAME ----------*/
				Route::prefix('brand_name')->group(function(){ // DONE -m
					Route::get('/', 'MFile\Inventory\c_brandname@view');
					Route::post('/', 'MFile\Inventory\c_brandname@add');
					Route::post('/update', 'MFile\Inventory\c_brandname@update');
					Route::post('/delete', 'MFile\Inventory\c_brandname@delete');
				});
				/* --- BRAND NAME ----------*/

				/* --- GENERIC NAME ----------*/
				Route::prefix('generic_name')->group(function(){ // DONE -m
					Route::get('/', 'MFile\Inventory\c_genericname@view');
					Route::post('/', 'MFile\Inventory\c_genericname@add');
					Route::post('/update', 'MFile\Inventory\c_genericname@update');
					Route::post('/delete', 'MFile\Inventory\c_genericname@delete');
				});
				/* --- GENERIC NAME ----------*/

				/* --- ITEM CATEGORY ----------*/
				Route::prefix('item_category')->group(function(){ // DONE -m
					Route::get('/', 'MFile\Inventory\c_itemcategory@view');
					Route::post('/', 'MFile\Inventory\c_itemcategory@add');
					Route::post('/update', 'MFile\Inventory\c_itemcategory@update');
					Route::post('/delete', 'MFile\Inventory\c_itemcategory@delete');
				});
				/* --- ITEM CATEGORY ----------*/

				/* --- ITEM UNIT ----------*/
				Route::prefix('unit_measure')->group(function(){ // DONE -m
					Route::get('/', 'MFile\Inventory\c_itemunit@view');
					Route::post('/', 'MFile\Inventory\c_itemunit@add');
					Route::post('/update', 'MFile\Inventory\c_itemunit@update');
					Route::post('/delete', 'MFile\Inventory\c_itemunit@delete');
				});

				Route::prefix('item_measurement')->group(function(){ // DONE -m
					Route::get('/', 'MFile\Inventory\c_itemunit@view');
					Route::post('/', 'MFile\Inventory\c_itemunit@add');
					Route::post('/update', 'MFile\Inventory\c_itemunit@update');
					Route::post('/delete', 'MFile\Inventory\c_itemunit@delete');
				});
				/* --- ITEM UNIT ----------*/

				/* --- ITEM ----------*/
				Route::prefix('item')->group(function(){ // DONE -m
					Route::get('/', 'MFile\Inventory\c_item@view');
					Route::post('/', 'MFile\Inventory\c_item@add');
					Route::post('/update', 'MFile\Inventory\c_item@update');
					Route::post('/delete', 'MFile\Inventory\c_item@delete');
				});
				/* --- ITEM ----------*/

				/* --- STOCK LOCATION ----------*/
				Route::prefix('stock_location')->group(function(){ // DONE -m
					Route::get('/', 'MFile\Inventory\c_stocklocation@view');
					Route::post('/', 'MFile\Inventory\c_stocklocation@add');
					Route::post('/update', 'MFile\Inventory\c_stocklocation@update');
					Route::post('/delete', 'MFile\Inventory\c_stocklocation@delete');
				});
				/* --- STOCK LOCATION ----------*/

				/* --- MODE OF PAYMENT ----------*/
				Route::prefix('mode_of_payment')->group(function(){ // DONE -m
					Route::get('/', 'MFile\Inventory\c_modeofpayment@view');
					Route::post('/', 'MFile\Inventory\c_modeofpayment@add');
					Route::post('/update', 'MFile\Inventory\c_modeofpayment@update');
					Route::post('/delete', 'MFile\Inventory\c_modeofpayment@delete');
				});
				/* --- MODE OF PAYMENT ----------*/

				/* --- SUPPLIER ----------*/
				Route::prefix('supplier')->group(function(){ // DONE -m
					Route::get('', 'MFile\Inventory\c_supplier@view');
					Route::post('', 'MFile\Inventory\c_supplier@add');
					Route::post('update', 'MFile\Inventory\c_supplier@update');
					Route::post('delete', 'MFile\Inventory\c_supplier@delete');
				});
				/* --- SUPPLIER ----------*/

				/* --- COST CENTER ----------*/
				Route::prefix('cost-center')->group(function(){ // DONE -m
					Route::get('', 'MFile\Inventory\c_cost_centers@view');
					Route::post('', 'MFile\Inventory\c_cost_centers@add');
					Route::post('update', 'MFile\Inventory\c_cost_centers@update');
					Route::post('delete', 'MFile\Inventory\c_cost_centers@delete');
				});
				/* --- COST CENTER ----------*/

				/* --- SUB COST CENTER ----------*/
				Route::prefix('sub-cost-center')->group(function(){ // DONE -m
					Route::get('', 'MFile\Inventory\c_sub_cost_centers@view');
					Route::post('', 'MFile\Inventory\c_sub_cost_centers@add');
					Route::post('update', 'MFile\Inventory\c_sub_cost_centers@update');
					Route::post('delete', 'MFile\Inventory\c_sub_cost_centers@delete');
				});
				/* --- SUB COST CENTER ----------*/

				/* --- VAT ----------*/
				Route::prefix('vat')->group(function(){ // DONE -m
					Route::get('/', 'MFile\Inventory\c_vat@view');
					Route::post('/', 'MFile\Inventory\c_vat@add');
					Route::post('/update', 'MFile\Inventory\c_vat@update');
					Route::post('/delete', 'MFile\Inventory\c_vat@delete');
				});
				/* --- VAT ----------*/

			});
			/* --- INVENTORY ----------*/


			/* --- COLLECTION ----------*/
			Route::prefix('tax')->group(function(){
				/* --- TAX GROUP ----------*/
				Route::prefix('group')->group(function(){ // DONE -m
					Route::get('/', 'Collection\c_tax_group@view');
					Route::post('/', 'Collection\c_tax_group@add');
					Route::post('/update', 'Collection\c_tax_group@update');
					Route::post('/delete', 'Collection\c_tax_group@delete');
				});
				/* --- TAX GROUP ----------*/

				/* --- TAX TYPE ----------*/
				Route::prefix('type')->group(function(){ // DONE -m
					Route::get('/', 'Collection\c_tax_type@view');
					Route::post('/', 'Collection\c_tax_type@add');
					Route::post('/update', 'Collection\c_tax_type@update');
					Route::post('/delete', 'Collection\c_tax_type@delete');
				});
				/* --- TAX TYPE ----------*/
			});


			

			Route::prefix('real-property-classification')->group(function(){
				Route::get('/', 'Collection\c_real_class@view');
				Route::post('/', 'Collection\c_real_class@add');
				Route::post('/update', 'Collection\c_real_class@update');
				Route::post('/delete', 'Collection\c_real_class@delete');
			});
			/* --- COLLECTION ----------*/



			/* --- GENERAL ----------*/
			Route::prefix('general')->group(function(){ // DONE -m
				Route::prefix('barangay')->group(function(){
					Route::get('/', 'MFile\General\c_barangay@view');
					Route::post('/', 'MFile\General\c_barangay@add');
					Route::post('/update', 'MFile\General\c_barangay@update');
					Route::post('/delete', 'MFile\General\c_barangay@delete');
				});
			});
			/* --- GENERAL ----------*/


			// Miscellenioiqweqtqwrqasdasqweksqwe
			Route::prefix('Miscellaneous')->group(function(){
				Route::prefix('bank')->group(function(){
					Route::get('/', 'MFile\Miscellaneous\bankController@view');
					Route::post('/', 'MFile\Miscellaneous\bankController@add');
					Route::post('/update', 'MFile\Miscellaneous\bankController@update');
					Route::post('/delete', 'MFile\Miscellaneous\bankController@delete');
				});
			});

		});
	/* MASTER FILE --------------------------*/

	/* ACCOUNTING ---------------------------*/
		Route::prefix('accounting')->group(function(){
			Route::prefix('collection')->group(function(){
				Route::prefix('entry')->group(function(){ // DONE -m
					Route::get('/', 'Collection\c_collection_entry@view');
					Route::get('/new', 'Collection\c_collection_entry@new');
					Route::post('/save', 'Collection\c_collection_entry@save');
					Route::get('/new/getOrIssuance', 'Collection\c_collection_entry@getOrIssuance');
					Route::get('/new/getOrIssuance2', 'Collection\c_collection_entry@getOrIssuance2');
					Route::get('/new/getORType', 'Collection\c_collection_entry@getORTypes');
					Route::get('{b_num}', 'Collection\c_collection_entry@edit');
					Route::post('/update', 'Collection\c_collection_entry@update');

					Route::post('/new/import', 'Collection\c_collection_entry@import');
				});
				Route::prefix('import')->group(function(){
					Route::get('/', 'Collection\c_collection_entry@import_view');
				});
				Route::prefix('saveimport')->group(function(){
					Route::post('/', 'Collection\c_collection_entry@saveImport');
				});

				Route::prefix('bank_deposit')->group(function(){
					Route::get('/', 'Collection\c_bank_deposit@view');
				});
			});
		});
	/* ACCOUNTING ---------------------------*/

	/* BUDGET -------------------------------*/

		/* ----- BUDGET PROPOSAL ENTRY */ // DONE -m
			// Proposal bgtprop01
			Route::get('budget/budget-proposal-entry-new', 'Budget\c_budget_proposal_entry_new@view');
			Route::get('budget/budget-proposal-entry-new/get', 'Budget\c_budget_proposal_entry_new@getEntries');
			Route::get('budget/budget-proposal-entry-new/new/{fy}/{fid}', 'Budget\c_budget_proposal_entry_new@new');
			Route::post('budget/budget-proposal-entry-new/save', 'Budget\c_budget_proposal_entry_new@save');
			Route::get('budget/budget-proposal-entry-new/{b_num}', 'Budget\c_budget_proposal_entry_new@edit');
			Route::post('budget/budget-proposal-entry-new/update', 'Budget\c_budget_proposal_entry_new@update');
		/* ----- BUDGET PROPOSAL ENTRY */

		/* ----- BUDGET APPROPRIATION */ // DONE -m
			// Apro bgtps01
			Route::get('budget/budget-proposal-entry', 'Budget\c_budget_proposal_entry@view');
			Route::get('budget/budget-proposal-entry/get', 'Budget\c_budget_proposal_entry@getEntries');
			Route::get('budget/budget-proposal-entry/getFunctions', 'Budget\c_budget_proposal_entry@getFunctions');
			Route::get('budget/budget-proposal-entry/new/{fy}', 'Budget\c_budget_proposal_entry@new'); ///{mo}
			Route::post('budget/budget-proposal-entry/save', 'Budget\c_budget_proposal_entry@save');
			Route::get('budget/budget-proposal-entry/{b_num}', 'Budget\c_budget_proposal_entry@edit');
			Route::post('budget/budget-proposal-entry/update', 'Budget\c_budget_proposal_entry@update');
			Route::post('budget/budget-proposal-entry/saveaddmore', 'Budget\c_budget_proposal_entry@saveaddmore');
			Route::get('budget/get_acctdesc/{at_code}', 'Budget\c_budget_proposal_entry@getAcctDesc');
			Route::post('budget/get_acctcode', 'Budget\c_budget_proposal_entry@getAcctCode');
			Route::get('budget/budget-proposal-entry/getOffices/{funcid}', 'Budget\c_budget_proposal_entry@getOffice');
			Route::get('budget/budget-proposal-entry/print/{code}', 'Budget\c_budget_proposal_entry@print');
			Route::get('budget/budget-appro/print-entry/{data}', 'Budget\c_budget_proposal_entry@print_entry');
			Route::get('budget/printallappro/{data}', 'Budget\c_budget_proposal_entry@printall');

		/* ----- BUDGET APPROPRIATION */

		/* ----- BUDGET ALLOTMENT */
			// Allot bgt
			Route::get('budget/budget-approved-entry', 'Budget\c_budget_approved_entry@view');
			Route::get('budget/budget-approved-entry/get', 'Budget\c_budget_approved_entry@getEntries');
			Route::get('budget/budget-approved-entry/get2', 'Budget\c_budget_approved_entry@getEntries2');
			Route::get('budget/budget-approved-entry/approve/{fy}/{frm}/{to}', 'Budget\c_budget_approved_entry@approve');
			Route::get('budget/budget-approved-entry/getAllProposals', 'Budget\c_budget_approved_entry@getAllProposals');
			Route::post('budget/budget-approved-entry/getProposalEntries', 'Budget\c_budget_approved_entry@getAllProposalEntries');
			Route::post('budget/budget-approved-entry/getProposalEntries2', 'Budget\c_budget_approved_entry@getAllProposalEntries2');
			Route::post('budget/budget-approved-entry/getProposal', 'Budget\c_budget_approved_entry@getProposal');
			Route::post('budget/budget-approved-entry/save', 'Budget\c_budget_approved_entry@save');
			Route::post('budget/budget-approved-entry/save2', 'Budget\c_budget_approved_entry@save2');
			Route::post('budget/budget-approved-entry/getRemainingBalance', 'Budget\c_budget_approved_entry@getRemainingBalance');
			Route::get('budget/budget-approved-entry/{b_num}', 'Budget\c_budget_approved_entry@edit');

			// New Allotment
			Route::prefix('budget')->group(function() {
				Route::prefix('allotment')->group(function() {
					Route::get('/', 'Budget\B_AllotmentController@view')->name('budget.allotment');
					Route::post('loaddatafromappro', 'Budget\B_AllotmentController@loaddatafromappro')->name('budget.loaddatafromappro');
					Route::get('loaddatafromoblig', 'Budget\B_AllotmentController@loaddatafromoblig')->name('budget.loaddatafromoblig');
					Route::post('getdatafromappro', 'Budget\B_AllotmentController@getdatafromappro')->name('budget.getdatafromappro');
					Route::post('savemanual', 'Budget\B_AllotmentController@savemanual')->name('budget.savemanual');
					Route::get('print-allot/{data}', 'Budget\B_AllotmentController@print');
				});
			});
		/* ----- BUDGET ALLOTMENT */

		/* ----- BUDGET OBLIGATION */
			// Obli tr01/tr02 debit
			Route::get('budget/budget-obligation-entry', 'Budget\c_budget_obligation_entry@view');
			Route::get('budget/budget-obligation-entry/get', 'Budget\c_budget_obligation_entry@getEntries');
			Route::get('budget/budget-obligation-entry/new', 'Budget\c_budget_obligation_entry@new');
			Route::get('budget/budget-obligation-entry/getAllApprove', 'Budget\c_budget_obligation_entry@getAllApprove');
			Route::post('budget/budget-obligation-entry/getApproveEntries', 'Budget\c_budget_obligation_entry@getApproveEntries');
			Route::post('budget/budget-obligation-entry/getApprove', 'Budget\c_budget_obligation_entry@getApprove');
			Route::post('budget/budget-obligation-entry/save', 'Budget\c_budget_obligation_entry@save');
			Route::get('budget/budget-obligation-entry/{b_num}', 'Budget\c_budget_obligation_entry@edit');
			
			Route::match(['get', 'post'], '/budget/lbp/{form_no}', 'Budget\LBP\bl_lbp@__redirect')->name('budget.lbp');
			Route::match(['get', 'post'], '/budget/lbp/{form_no}/new', 'Budget\LBP\bl_lbp@__entry')->name('budget.lbpnew');
			Route::match(['get', 'post'], '/budget/lbp/{form_no}/{b_num}/edit', 'Budget\LBP\bl_lbp@__edit')->name('budget.lbpedit');
			Route::match(['get', 'post'], '/budget/lbp/{form_no}/request', 'Budget\LBP\bl_lbp@__extra')->name('budget.lbprequest');
		/* ----- BUDGET OBLIGATION */

	/* BUDGET -------------------------------*/

	/* INVENTORY -------------------------------*/
	    /* ----- STOCK IN */
			Route::prefix('inventory')->group(function() {
				Route::prefix('stockin')->group(function() {
					Route::get('/', 'Inventory\I_StockInController@view')->name('inventory.stockin');
					Route::match(['get', 'post'], '/stockin_add', 'Inventory\I_StockInController@add')->name('inventory.stockin_add');
					Route::match(['get', 'post'], '/stockin_edit/{code}', 'Inventory\I_StockInController@edit')->name('inventory.stockin_edit');
					Route::get('/stockin_cancel/{code}', 'Inventory\I_StockInController@cancel')->name('inventory.stockin_cancel');
					Route::get('/stockin_print/{code}', 'Inventory\I_StockInController@print')->name('inventory.stockin_print');
					Route::get('/stockin_getitemdetails/{code}', 'Inventory\I_StockInController@getitemdetails')->name('inventory.stockin_getitemdetails');
				});
			});
		/* ----- STOCK IN */

		/* ----- WASTE MATERIAL */
		    Route::prefix('inventory')->group(function() {
		    	Route::prefix('wastematerial')->group(function() {
		    		Route::get('/', 'Inventory\I_WasteMaterialController@view')->name('inventory.wastematerial');
		    		Route::match(['get', 'post'], '/wastematerial_add', 'Inventory\I_WasteMaterialController@add')->name('inventory.wastematerial_add');
		    		Route::match(['get', 'post'], '/wastematerial_edit/{code}', 'Inventory\I_WasteMaterialController@edit')->name('inventory.wastematerial_edit');
		    		Route::get('/wastematerial_cancel/{code}', 'Inventory\I_WasteMaterialController@cancel')->name('inventory.wastematerial_cancel');
		    		Route::get('/print/{code}', 'Inventory\I_WasteMaterialController@print')->name('inventory.wastematerial_print');
		    	});
		    });
		/* ----- WASTE MATERIAL */

		/* ----- STOCK RELEASE */
			Route::prefix('inventory')->group(function() {
				Route::prefix('stockrelease')->group(function() {
					Route::get('/', 'Inventory\I_StockReleaseController@view')->name('inventory.stockrelease');
					Route::match(['get', 'post'], '/stockrelease_add', 'Inventory\I_StockReleaseController@add')->name('inventory.stockrelease_add');
					Route::match(['get', 'post'], '/stockrelease_edit/{code}', 'Inventory\I_StockReleaseController@edit')->name('inventory.stockrelease_edit');
				});
			});
		/* ----- STOCK RELEASE */

		/* ----- Requisition Issuance Slip */
			Route::prefix('inventory')->group(function() {
				Route::prefix('ris')->group(function() {
					Route::get('/', 'Inventory\I_RISController@view')->name('inventory.ris');
					Route::match(['get', 'post'], '/ris_add', 'Inventory\I_RISController@add')->name('inventory.ris_add');
					Route::match(['get', 'post'], '/ris_edit/{code}', 'Inventory\I_RISController@edit')->name('inventory.ris_edit');
					Route::get('/ris_cancel/{code}', 'Inventory\I_RISController@cancel')->name('inventory.ris_cancel');
					Route::get('/ris_print/{code}', 'Inventory\I_RISController@print')->name('inventory.ris_print');
				});
			});
		/* ----- Requisition Issuance Slip */

		/* ----- Acknowledgement Receipt Equipment */
			Route::prefix('inventory')->group(function() {
				Route::prefix('are')->group(function() {
					Route::get('/', 'Inventory\I_AREController@view')->name('inventory.are');
					Route::get('/are_approve/{code}', 'Inventory\I_AREController@approve')->name('inventory.are_approve');
					Route::get('/are_print/{code}', 'Inventory\I_AREController@print')->name('inventory.are_print');
					Route::match(['get', 'post'], '/are_add', 'Inventory\I_AREController@add')->name('inventory.are_add');
					Route::match(['get', 'post'], '/are_edit/{code}', 'Inventory\I_AREController@edit')->name('inventory.are_edit');
					Route::get('/are_cancel/{code}', 'Inventory\I_AREController@cancel')->name('inventory.are_cancel');
					// Route::get('/ris_print/{code}', 'Inventory\I_RISController@print')->name('inventory.ris_print');
				});
			});
		/* ----- Acknowledgement Receipt Equipment */

		/* ----- Inventory Custodian Slip */
			Route::prefix('inventory')->group(function() {
				Route::prefix('ics')->group(function() {
					Route::get('/', 'Inventory\I_ICSController@view')->name('inventory.ics');
					Route::match(['get', 'post'], '/ics_add', 'Inventory\I_ICSController@add')->name('inventory.ics_add');
					Route::match(['get', 'post'], '/ics_edit/{code}', 'Inventory\I_ICSController@edit')->name('inventory.ics_edit');
					Route::get('/ics_cancel/{code}', 'Inventory\I_ICSController@cancel')->name('inventory.ics_cancel');
					Route::get('/ics_print/{code}', 'Inventory\I_ICSController@print')->name('inventory.ics_print');
					Route::get('/getDataFromRIS/{code}', 'Inventory\I_ICSController@getDataFromRIS')->name('inventory.ics_getDataFromRIS');
				});
			});
		/* ----- Requisition Issuance Slip */

		/* ----- Item Search */
			Route::prefix('inventory')->group(function() {
				Route::prefix('itemsearch')->group(function() {
					Route::get('/', 'Inventory\I_ItemSearchController@view')->name('inventory.itemsearch');
				});
			});
		/* ----- Item Search */

		/* ----- Item Repair */
			Route::prefix('inventory')->group(function() {
				Route::prefix('itemrepair')->group(function() {
					Route::get('/', 'Inventory\I_ItemRepairController@view')->name('inventory.itemrepair');
					Route::get('/itemrepair_approve/{code}', 'Inventory\I_ItemRepairController@approve')->name('inventory.itemrepair_approve');
					Route::get('/itemrepair_print/{code}', 'Inventory\I_ItemRepairController@print')->name('inventory.itemrepair_print');
					Route::match(['get', 'post'], '/itemrepair_entry', 'Inventory\I_ItemRepairController@add')->name('inventory.itemrepair_entry');
					Route::match(['get', 'post'], '/itemrepair_edit/{code}', 'Inventory\I_ItemRepairController@edit')->name('inventory.itemrepair_edit');
					Route::get('/itemrepair_cancel/{code}', 'Inventory\I_ItemRepairController@cancel')->name('inventory.itemrepair_cancel');
					// Route::get('/ris_print/{code}', 'Inventory\I_RISController@print')->name('inventory.ris_print');
				});
			});
		/* ----- Item Repair */

		/* ----- Turn Over */
			Route::prefix('inventory')->group(function() {
				Route::prefix('turnover')->group(function() {
					Route::get('/', 'Inventory\I_TurnOverController@view')->name('inventory.turnover');
					// Route::get('/itemrepair_approve/{code}', 'Inventory\I_ItemRepairController@approve')->name('inventory.itemrepair_approve');
					Route::get('/turnover_print/{code}', 'Inventory\I_TurnOverController@print')->name('inventory.turnover_print');
					Route::match(['get', 'post'], '/turnover_entry', 'Inventory\I_TurnOverController@add')->name('inventory.turnover_entry');
					Route::match(['get', 'post'], '/turnover_edit/{code}', 'Inventory\I_TurnOverController@edit')->name('inventory.turnover_edit');
					Route::get('/turnover_cancel/{code}', 'Inventory\I_TurnOverController@cancel')->name('inventory.turnover_cancel');
				});
			});
		/* ----- Turn Over */


		/* ----- Biology*/
			Route::prefix('inventory')->group(function() {
				Route::prefix('biology')->group(function() {

					//REDIRECT TO BIOLOGY TABLES

					Route::get('/biologyacqusitiontbl', 'Inventory\I_BiologyController@acq_table')->name('inventory.biology.bio_acq_table');
					Route::get('/biologybirthtbl', 'Inventory\I_BiologyController@boo_table')->name('inventory.biology.bio_boo_table');
					Route::get('/biologydispotbl', 'Inventory\I_BiologyController@dispo_table')->name('inventory.biology.bio_dispo_table');

					//GET POST TO CREATE LIST
					
					//BIOLOGY ACQUISITION
					
					Route::match(['get', 'post'], '/biologyacqusition_add', 'Inventory\I_BiologyController@acq_add')->name('inventory.biologyacqusition_add');
					Route::match(['get', 'post'], '/biologyacqusition_edit/{code}', 'Inventory\I_BiologyController@acq_edit')->name('inventory.biologyacqusition_edit');
					Route::post('/bioAcq_cancel', 'Inventory\I_BiologyController@acq_cancel')->name('inventory.bioAcq_cancel');

					//END BIOLOGY ACQUISITION

					//BIOLOGY OF OFFSPRING
					
					Route::match(['get', 'post'], '/biologyoffspring_add', 'Inventory\I_BiologyController@boo_add')->name('inventory.biologyoffspring_add');
					Route::match(['get', 'post'], '/biologyoffspring_edit/{code}', 'Inventory\I_BiologyController@boo_edit')->name('inventory.biologyoffspring_edit');
					Route::post('/bioBoo_cancel', 'Inventory\I_BiologyController@boo_cancel')->name('inventory.bioBoo_cancel');
					
					//END BIOLOGY OF OFFSPRING
					
					//BIOLOGY DISPOSITION

					Route::match(['get', 'post'], '/biologydisposition_add', 'Inventory\I_BiologyController@dispo_add')->name('inventory.biologydisposition_add');
					Route::match(['get', 'post'], '/biologydisposition_edit/{code}', 'Inventory\I_BiologyController@dispo_edit')->name('inventory.biologydisposition_edit');
					Route::post('/bioDispo_cancel', 'Inventory\I_BiologyController@dispo_cancel')->name('inventory.bioDispo_cancel');

					//END BIOLOGY DISPOSITION
					

					//GET TABLE LINE DETAILS
					Route::get('/stockin_getitemdetails/{code}', 'Inventory\I_StockInController@getitemdetails')->name('inventory.stockin_getitemdetails');

					Route::get('/', 'Inventory\I_BiologyController@view')->name('inventory.biology');
					// Route::get('/itemrepair_approve/{code}', 'Inventory\I_ItemRepairController@approve')->name('inventory.itemrepair_approve');
					// Route::get('/turnover_print/{code}', 'Inventory\I_TurnOverControllerx@print')->name('inventory.turnover_print');
					Route::match(['get', 'post'], '/biologyacqusition', 'Inventory\I_BiologyController@add')->name('inventory.biologyacqusition');
					Route::get('/bio_getacqdetails/{code}', 'Inventory\I_BiologyController@acqItemDetails')->name('inventory.biology_getacqdetails');
					Route::get('/bio_getinventorydetails/{itemcode}', 'Inventory\I_BiologyController@acqInventoryDetails')->name('inventory.biology_getinventorydetails');
					// Route::match(['get', 'post'], '/turnover_edit/{code}', 'Inventory\I_TurnOverController@edit')->name('inventory.turnover_edit');
					// Route::get('/turnover_cancel/{code}', 'Inventory\I_TurnOverController@cancel')->name('inventory.turnover_cancel');
				});
			});
		/* ----- Biology*/

        /* ----- Stock Transaction Card */
		Route::prefix('inventory')->group(function() {
			Route::prefix('stocktransactcard')->group(function() {
				Route::match(['post','get'],'/', 'Inventory\I_StockTransactCardController@view')->name('inventory.stocktransactcard');
			});
		});
        /* ----- Stock Transaction Card */

		/* ----- RECEIVING PURCHASE ORDER */
			Route::prefix('inventory')->group(function() {
				Route::prefix('receiving_po')->group(function() {
					Route::get('/', 'Inventory\I_ReceivingPOController@view')->name('inventory.rpo');
					Route::match(['get', 'post'], '/rpo_add', 'Inventory\I_ReceivingPOController@add')->name('inventory.rpo_add');
					Route::match(['get', 'post'], '/rpo_edit/{code}', 'Inventory\I_ReceivingPOController@edit')->name('inventory.rpo_edit');
					Route::get('/rpo_cancel/{code}', 'Inventory\I_ReceivingPOController@cancel')->name('inventory.rpo_cancel');
					Route::get('/rpo_print/{code}', 'Inventory\I_ReceivingPOController@print')->name('inventory.rpo_print');
				});
			});
		/* ----- RECEIVING PURCHASE ORDER */

		/* ----- PURCHASE RETURN */
			Route::prefix('inventory')->group(function() {
				Route::prefix('purchasereturn')->group(function() {
					Route::get('/', 'Inventory\I_PurchaseReturnController@view')->name('inventory.pr');
					Route::match(['get', 'post'], '/add', 'Inventory\I_PurchaseReturnController@add')->name('inventory.pr_add');
					Route::match(['get', 'post'], '/edit/{code}', 'Inventory\I_PurchaseReturnController@edit')->name('inventory.pr_edit');
					Route::get('/cancel/{code}', 'Inventory\I_PurchaseReturnController@cancel')->name('inventory.pr_cancel');
				});
			});
		/* ----- PURCHASE RETURN */

		/* ----- STOCK ISSUANCE */
			Route::prefix('inventory')->group(function() {
				Route::prefix('stockissuance')->group(function() {
					Route::get('/', 'Inventory\I_StockIssuanceController@view')->name('inventory.stockissuance');
					Route::match(['get', 'post'], '/add', 'Inventory\I_StockIssuanceController@add')->name('inventory.si_add');
					Route::match(['get', 'post'], '/edit/{code}', 'Inventory\I_StockIssuanceController@edit')->name('inventory.si_edit');
					Route::get('/cancel/{code}', 'Inventory\I_StockIssuanceController@cancel')->name('inventory.si_cancel');
				});
			});
		/* ----- STOCK ISSUANCE */

		/* ----- STOCK TRANSFER */
			Route::prefix('inventory')->group(function() {
				Route::prefix('stocktransfer')->group(function() {
					Route::get('/', 'Inventory\I_StockTransferController@view')->name('inventory.stocktransfer');
					Route::match(['get', 'post'], '/add', 'Inventory\I_StockTransferController@add')->name('inventory.st_add');
					Route::match(['get', 'post'], '/edit/{code}', 'Inventory\I_StockTransferController@edit')->name('inventory.st_edit');
					Route::get('/cancel/{code}', 'Inventory\I_StockTransferController@cancel')->name('inventory.st_cancel');
				});
			});
		/* ----- STOCK TRANSFER */

		/* ----- RECEIVING STOCK TRANSFER */
			Route::prefix('inventory')->group(function() {
				Route::prefix('recvstocktransfer')->group(function() {
					Route::get('/', 'Inventory\I_RecvStockTransferController@view')->name('inventory.recvstocktransfer');
					Route::match(['get', 'post'], '/edit/{code}', 'Inventory\I_RecvStockTransferController@edit')->name('inventory.rst_edit');
				});
			});
		/* ----- RECEIVING STOCK TRANSFER */

		/* ----- STOCK ADJUSTMENT */
			Route::prefix('inventory')->group(function() {
				Route::prefix('stockadjustment')->group(function() {
					Route::get('/', 'Inventory\I_StockAdjustmentController@view')->name('inventory.stockadjustment');
					Route::match(['get', 'post'], '/add', 'Inventory\I_StockAdjustmentController@add')->name('inventory.sa_add');
					Route::match(['get', 'post'], '/edit/{code}', 'Inventory\I_StockAdjustmentController@edit')->name('inventory.sa_edit');
					Route::get('/cancel/{code}', 'Inventory\I_StockAdjustmentController@cancel')->name('inventory.sa_cancel');
				});
			});
		/* ----- STOCK ADJUSTMENT */

	/* INVENTORY -------------------------------*/

	/* REPORT -------------------------------*/
		/* ----- BUDGET */
			/* ----- Budget Proposal */
				Route::get('reports/budget/proposal', 'Report\Budget\c_saob@proposal_view');
			/* ----- Budget Proposal */

			/* ----- SAOB */
				Route::get('report/budget/saaob', 'Report\Budget\c_saob@view');
				Route::get('report/budget/saaob/generate/{fy}/{mo}/{fid}', 'Report\Budget\c_saob@GenerateSaob');
			/* ----- SAOB */

			//BIOLOGY REPORT
			
			Route::get('/report/biology/biologyreport', 'Report\InventoryReports@view')->name('inventory.bioreports');
			
			Route::get('/report/biology/bioreportsview', 'Report\InventoryReports@index')->name('inventory.bioreportsview');

			Route::post('report/biology/bioreportsview', 'Report\InventoryReports@generate')->name('report.generatebioreport');

			Route::post('report/biology/bioreportsprint', 'Report\InventoryReports@generate')->name('report.biology.bioreportsprint');

		/* ----- BUDGET */
		/* ----- INVENTORY */
		   /* ----- SSMI */
				Route::get('reports/inventory/ssmi', 'Report\Inventory\SSMI@view')->name('inventoryreports.ssmi');
				Route::post('reports/inventory/ssmiprint', 'Report\Inventory\SSMI@print')->name('inventoryreports.ssmiprint');
			/* ----- SSMI */
			/* ----- IAC */
				Route::get('reports/inventory/iac', 'Report\Inventory\IAC@view')->name('inventoryreports.iac');
				Route::post('reports/inventory/iacprint', 'Report\Inventory\IAC@print')->name('inventoryreports.iacprint');
			/* ----- IAC */
		/* ----- INVENTORY */
	/* REPORT -------------------------------*/

	/* SETTING -------------------------------*/
		Route::prefix('settings')->group(function(){

			/* ----- GROUP RIGHTS */
			Route::prefix('group-rights')->group(function() {
				Route::get('', 'Settings\c_group_rights@view');
				// Route::post('', 'Settings\c_group_rights@add');
				Route::get('edit/{mod_id}', 'Settings\c_group_rights@edit');
				Route::post('edit/{mod_id}', 'Settings\c_group_rights@update');

				/* ----- MODULES */
				Route::prefix('modules')->group(function(){
					Route::get('', 'Settings\c_modules@view');
					Route::get('getAll', 'Settings\c_modules@getAll');
					Route::post('', 'Settings\c_modules@add');
					Route::post('update', 'Settings\c_modules@update');
				});
				/* ----- MODULES */

				/* ----- GROUP */
				Route::prefix('groups')->group(function(){
					Route::get('','Settings\c_groups@view');
					Route::post('','Settings\c_groups@add');
					Route::post('update','Settings\c_groups@update');
				});
				/* ----- GROUP */
			});
			/* ----- GROUP RIGHTS */

			/* ----- USERS */
			Route::prefix('users')->group(function(){
				Route::get('', 'Settings\c_users@view');
				Route::post('', 'Settings\c_users@add');
				Route::post('update', 'Settings\c_users@update');
			});
			/* ----- USERS */
		});



		// collection area

		Route::prefix('collection')->group(function(){
			Route::prefix('ROCAD')->group(function(){ // DONE -m
				Route::get('/', 'Collection\ROCADController@view');
				Route::match(['get','post'],'/{uid}', 'Collection\ROCADController@viewOR');
			});
			Route::prefix('Liquidating-officer')->group(function(){ // DONE -m
				Route::get('/', 'Collection\ROCADController@viewLiquidate');
				Route::match(['get','post'],'/{uid}', 'Collection\ROCADController@liquidate');
			});
			// Route::prefix('Bank-Deposit')->group(function(){ // DONE -m
			// 	Route::get('/', 'Collection\ROCADController@viewToDiposit');
			// 	Route::match(['get','post'],'/{liquidateid}', 'Collection\ROCADController@deposittobank');
			// });
			Route::prefix('Bank-Deposit')->group(function(){ // DONE -m
				Route::get('/', 'Collection\ROCADController@viewToDiposit');
				Route::match(['get','post'],'/{liquidateid}', 'Collection\ROCADController@deposittobank');
			});
			
		});
		// collection area



		// Reancy
		Route::prefix('accounting')->group(function() {
			Route::prefix('disbursement')->group(function() {
				Route::get('/', 'Accounting\AccountingControllers@__disbursement')->name('accounting.disbursement');
				Route::get('/edit/{j_code}/{j_num}', 'Accounting\AccountingControllers@__disbursementedit')->name('accounting.disbursementedit');
				Route::match(['get', 'post'], '/disbursement_new/{j_code}', 'Accounting\AccountingControllers@__disbursementnew')->name('accounting.disbursementnew');

				Route::prefix('check_issuance')->group(function() {
					Route::get('/', 'Accounting\AccountingControllers@__check_issuance')->name('accounting.check_issuance');
					Route::get('/new', 'Accounting\AccountingControllers@__check_issuance_new')->name('accounting.check_issuance_new');

				});
				Route::get('/check_release', 'Accounting\AccountingControllers@__check_release')->name('accounting.check_release');
			});

			Route::prefix('obr')->group(function() {
				Route::get('/', 'Budget\bl_budget@__entry')->name('budget.obr_entry');
				Route::get('/view/{obr_code}', 'Budget\bl_budget@__view')->name('budget.obr_view');
				Route::match(['post', 'get'], '/new', 'Budget\bl_budget@__new')->name('budget.obr_new');
				Route::match(['post', 'get'], '/edit/{obr_code}', 'Budget\bl_budget@__edit')->name('budget.obr_edit');
			});
			Route::prefix('collection')->group(function() {
				Route::prefix('obligation_request')->group(function() {
					Route::get('/{obr_code}', 'Accounting\AccountingControllers@__obr_view')->name('accounting.obr_view');
					Route::get('/edit/{obr_code}', 'Accounting\AccountingControllers@__obr_edit')->name('accounting.obr_edit');
					Route::get('/', 'Accounting\AccountingControllers@__obligation_request')->name('accounting.obligation_request');
					Route::match(['post','get'],'/Entry/Admin', 'Accounting\AccountingControllers@_obligation_admin');
					Route::match(['post','get'],'/Entry/Admin/{action}/{operationOpt?}/', 'Accounting\AccountingControllers@_obligation_admin_operation');
				});
				Route::prefix('or_issuance')->group(function() {
					Route::get('/', 'Accounting\AccountingControllers@__obr_issuance')->name('accounting.obr_issuance');
					Route::match(['get', 'post'], 'new', 'Accounting\AccountingControllers@__obr_issuancenew')->name('accounting.obr_issuancenew');


					Route::prefix('Update-History')->group(function() {
						Route::match(['get', 'post'], '/', 'Accounting\AccountingControllers@__obr_issuanceupdate');
						Route::match(['get', 'post'], '{id}', 'Accounting\AccountingControllers@__or_issuanceupdate');
					});

					
					Route::match(['get', 'post'], '{transid}', 'Accounting\AccountingControllers@__obr_issuanceedit')->name('accounting.obr_issuanceedit');
				});
				Route::match(['get', 'post'], '/obr_new', 'Accounting\AccountingControllers@__obr_new')->name('accounting.obr_new');
			});
			Route::match(['get', 'post'], '/request/{customQuery}', 'Accounting\AccountingControllers@__customQuery')->name('accounting.customquery');
		});

		Route::prefix('reports')->group(function() {
			Route::prefix('budget')->group(function() {
				Route::get('saaob/{all}', 'Accounting\AccountingControllers@__saob')->name('accounting.saob');
				Route::get('rao/{fpp?}/{cc_code?}/{date?}', 'Accounting\AccountingControllers@generateRaoReport');
				Route::match(['get', 'post'], 'lbp/{formNumber}/{extraDetails?}', 'Report\Budget\c_lbp@__lbp')->name('report.lbp');
				Route::get('saaob', 'Report\Budget\SaaobReportController@view')->name('report.saaob');
				Route::post('saaob/generate', 'Report\Budget\SaaobReportController@generate')->name('report.generatesaaob');
			});
			Route::prefix('collection')->group(function() {

				Route::prefix('RocadDailyUser')->group(function(){ // DONE -m
					Route::get('/', 'Collection\ROCADController@rocardDailyUser');
					Route::match(['get','post'],'/{uid}/{date}', 'Collection\ROCADController@rocardDailyUserProcess');
				});

				Route::prefix('abstract')->group(function(){ // DONE -m
					Route::get('/', 'Collection\ROCADController@abstractView');
					Route::match(['get','post'],'/{from}/{to}', 'Collection\ROCADController@abstractProcess');
				});

				Route::prefix('Daily-Collection')->group(function(){ // DONE -m
					Route::get('/', 'Collection\ROCADController@dailycollectionView');
					Route::match(['get','post'],'/{date}', 'Collection\ROCADController@dailycollectionProcess');
				});

				Route::prefix('Real-Property-Tax')->group(function(){ // DONE -m
					Route::get('/', 'Collection\ROCADController@RPTView');
					Route::match(['get','post'],'/{date}', 'Collection\ROCADController@RPTProcess');
				});

				Route::prefix('Statement-Of-Collection')->group(function(){ // DONE -m
					Route::get('/', 'Collection\ROCADController@SOCView');
					Route::match(['get','post'],'/{from}/{to}', 'Collection\ROCADController@SOCProcess');
				});

			});
		});
		/* SETTING -------------------------------*/
	// });
});

/* OTHERS -------------------------------*/
// Link for the temporary report page
Route::get('temporary/{page}', 'HomeController@tempPage');
// Link to get all session
Route::get('session-all', 'HomeController@SessionAll');
Route::get('/test', function(){
	return view('report.collection.test');
});
// Link to pages with no controller (Must be at the bottom)
Route::get('{page}', 'HomeController@page');
/* OTHERS -------------------------------*/