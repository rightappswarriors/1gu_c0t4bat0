<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use FunctionsAccountingControllers;
class HomeController extends Controller
{
    //
    public function home()
    {
        $x08 = FunctionsAccountingControllers::getCol('rssys.x08', [['uid', strtoupper(FunctionsAccountingControllers::getSession('_user', 'id'))]]);
        $grp = ((count($x08) > 0) ? FunctionsAccountingControllers::getCol('rssys.x07', [['grp_id', $x08[0]->grp_id]]) : []);
        $arrRet = [
            'grpid'=>$grp,
            'n_grpid'=>$x08
        ];
        // FunctionsAccountingControllers::x07x05tox06();
    	return view('index', $arrRet);
    }


    // Find the php file on the resource then display it
    public function page($page)
    {
    	try {
           return view($page); 
        } catch (\Exception $e) {
            return view('error.404');
        }
    }

    // Check Sessions
    public function SessionAll()
    {
        dd(Session::all());
    }

    // Files on the temporary folder. This route is separated to avoid
    public function tempPage(Request $r, $page)
    {
        $pageTitle = ($r->pagetitle == null) ? $r->pagetitle : null;
        $printOrientation = ($r->orientation == null) ? $r->pagetitle : null;
        return view('temporary.'.$page, compact(['pageTitle','printOrientation']));
    }

    public function tempPageFunc($select = null)
    {
        switch ($select) {
            case 'budget_entry':
                $returnVal = "OK";
                break;
            
            default:
                $returnVal = "INvALID SELECTION OF FUNCTION";
                break;
        }
        return $returnVal;
    }
}
