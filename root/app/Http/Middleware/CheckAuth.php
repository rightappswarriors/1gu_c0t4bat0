<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\DB;
use FunctionsAccountingControllers;
use Illuminate\Support\Facades\Route;

class CheckAuth
{
	// Check authentication session.
    public function handle($request, Closure $next)
    {
        // dd(Session::all());
        if (!Session::exists('_user') && !Session::exists('grp_ri')) {
            // user value cannot be found in session
            if(url()->current()!=url('/login')) {
            	return redirect('/login');
            }
        }
        $this->RefreshSession(Session::get('_user'));
        $this->RefreshGrpRights(Session::get('grp_ri'));
        // return $next($request);
        return $this->getRights($request, $next);
    }

    public function RefreshSession($session)
    {
        Session::put('_user', $session);
    }
    public function RefreshGrpRights($session)
    {
        Session::put('grp_ri', $session);
    }
    public function getRights($request, Closure $next, $schema = "rssys") {
        $n_route = $request->route(); $nN_route = Route::getFacadeRoot()->current()->uri(); $user = strtoupper(FunctionsAccountingControllers::getSession('_user', 'id'));
        $t_user = DB::table(DB::raw("$schema.x08"))->where([['uid', $user]])->first(); $n_user = $t_user->uid; $n_cc_code = $t_user->cc_code;

        ////////////////////////////
        // return dd($t_user->grp_id);
        $Grp_Rights = DB::table(DB::raw("$schema.x06"))->where('grp_id', $t_user->grp_id)->get();
        $Grp_Rights2 = array();
        if(count($Grp_Rights) > 0) {
            for ($i=0; $i < count($Grp_Rights); $i++) { 
               $Grp_Rights2[$Grp_Rights[$i]->mod_id]["restrict"] = $Grp_Rights[$i]->restrict;
               $Grp_Rights2[$Grp_Rights[$i]->mod_id]["add"] = $Grp_Rights[$i]->add;
               $Grp_Rights2[$Grp_Rights[$i]->mod_id]["upd"] = $Grp_Rights[$i]->upd;
               $Grp_Rights2[$Grp_Rights[$i]->mod_id]["cancel"] = $Grp_Rights[$i]->cancel;
               $Grp_Rights2[$Grp_Rights[$i]->mod_id]["print"] = $Grp_Rights[$i]->print;
            }
            // $Grp_Rights2[$Grp_Rights]
        }
        Session::put('grp_ri',  $Grp_Rights2);
        ////////////////////////////
        // return dd(Session::get('grp_ri'));

        $path = DB::select(DB::raw("SELECT * FROM $schema.x05 WHERE x05.path = '$nN_route'")); $isReturn = false; $isReturn1 = false;
        // return dd($path);
        if(count($path) > 0) { foreach($path AS $pathEach) {
            $cc_code = json_decode($pathEach->cc_code); $uid = json_decode($pathEach->uid);
            if(isset($n_cc_code)) {
                if(isset($cc_code)) { foreach($cc_code AS $cEach) { if($cEach == $n_cc_code) { $isReturn = true; } } } else { $isReturn = true; }
                if(isset($uid)) { foreach($uid AS $uEach) { if($uEach == $n_user) { $isReturn1 = true; } } } else { $isReturn1 = true; }
            } else { $isReturn = true; $isReturn1 = true; }
        } } else { $isReturn = true; $isReturn1 = true; }

        if($isReturn && $isReturn1) {
            return $next($request);
        }
        return back()->with('alert', ["Error", "error", "You don't have permission to access this page."]);
    }
}