<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Core;
use Session;
use isMethod;
use App\Inventory;
use Carbon\Carbon;

class I_StockTransactCardController extends Controller
{
    //private $stk_trns_type = "P";
    private $module = "Stock Transaction Card";

    public function view(Request $request)
    {

    	if($request->isMethod('GET')){

            $supplier = Core::getAll('rssys.m07');
            $stock_loc = Core::getAll('rssys.whouse');
            $branch = Core::getAll('rssys.branch');
            $modeofpayment = Core::getAll('rssys.m10');
            $itemunit = Core::getAll('rssys.itmunit');
            $costcenter = Core::getAll('rssys.m08');
            $subcostcenter = Core::getAll('rssys.subctr');
            $vat = Core::getAll('rssys.vat');
            $isnew = true;
            // $gg = Inventory::getItemSearchLine();


            return view('inventory.stocktransactcard.stocktransactcard', compact('supplier', 'stock_loc', 'branch','modeofpayment', 'itemunit', 'costcenter', 'subcostcenter', 'vat', 'isnew'));
           } 
        else {
           	if($request->has('action')){
	           	switch ($request->action) {
	           		case 'getSearch':
	           			return Inventory::getItemSearchTable($request->stkLoc, $request->branch);
	           			break;
	           		case 'getSearch':
	           			return Inventory::getItemSearchTable($request->stkLoc, $request->branch);
	           			break;
	           		case 'getLine':
	           			return Inventory::getItemSearchLine($request->stkLoc, $request->item_code);
	           			break;
	           		
	           		default:
	           			# code...
	           			break;
	           	}
	        }
        }

    }
}