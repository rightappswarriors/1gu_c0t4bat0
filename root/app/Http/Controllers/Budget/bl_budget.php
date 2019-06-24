<?php

namespace App\Http\Controllers\Budget;


use Mail;
use Session;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Storage;
use FunctionsAccountingControllers;

class bl_budget extends Controller {

	public function __entry(Request $request) { // function for new entries in Budget Obligation
		dd($request->all());
	}

	public function __new(Request $request) { // function for new entries in Budget Obligation
		if($request->isMethod('post')) {
			dd($request->all());
		}

		$arrRet = [
			'appDet' => NULL,
			'years' => DB::select("SELECT DISTINCT rssys.x03.fy FROM rssys.x03 ORDER BY rssys.x03.fy ASC"),
			'funds' => DB::table(DB::raw('rssys.fund'))->get(),
			'sector' => DB::table(DB::raw('rssys.sector'))->get(),
			'office' => DB::table(DB::raw('rssys.m08'))->get(),
			'function' => DB::table(DB::raw('rssys.function'))->where([['active', true]])->get(),
			'ppa' => DB::select("SELECT * FROM rssys.ppasubgrp ORDER BY seq"),
			'employee' => DB::table(DB::raw('hris.hr_employee'))->get(),
			'getData' => DB::select("SELECT *, fund.fdesc, (COALESCE(lbp0802.appro_amnt, 0.00) - COALESCE(_all.appro_amnt1, 0.00)) AS appro_amnt FROM rssys.lbp0801 LEFT JOIN rssys.fund ON lbp0801.fid = fund.fid LEFT JOIN (SELECT b_num, SUM(appro_amnt) AS appro_amnt FROM rssys.lbp0802 GROUP BY b_num) lbp0802 ON lbp0802.b_num = lbp0801.b_num LEFT JOIN (SELECT lbp0801.lbp08_b_num::integer AS b_num, SUM(_all.appro_amnt1) AS appro_amnt1 FROM rssys.lbp0801 LEFT JOIN (SELECT b_num, SUM(appro_amnt) AS appro_amnt1 FROM rssys.lbp0903 GROUP BY b_num) _all ON lbp0801.b_num = _all.b_num GROUP BY lbp0801.lbp08_b_num) _all ON lbp0801.b_num = _all.b_num WHERE form_no = '8'"),
			'account' => DB::table(DB::raw('rssys.m04'))->get(),
		];

		return view('budget.budget_obr_new', $arrRet);
	}

}
