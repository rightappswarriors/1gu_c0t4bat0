<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class OfficeExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($view,$arrayData){
    	$this->view = $view;
    	$this->data = $arrayData;
    }

    public function view(): View
    {
        return view($this->view, $this->data);
    }
}
