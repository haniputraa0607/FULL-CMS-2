<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
class Marcomm implements FromView
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
        return view('project::project.excel.marcomm',$data);
    }
    public function title(): string
    {
        return "Form Marcomm";
    }
}
