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

    public function view()
    {
        return view('inventory.stocktransactcard.stocktransactcard');
    }
}