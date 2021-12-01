<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
class Operasional implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;
    function __construct($request) {
        $this->request = $request;
    }
    public function view(): View
    {
        $data=$this->request;
        return view('project::project.excel.operasional',$data);
    }
    public function title(): string
    {
        return "Form Operasional";
    }
}
