<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Fitout;
use App\Exports\Marcomm;
use App\Exports\SPKExport;
use App\Exports\Operasional;
use Maatwebsite\Excel\Concerns\WithTitle;
class Handover implements WithMultipleSheets
{
    use Exportable;
    protected $request;
    function __construct(array $request) {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $sheets['SPK - D1'] = new SPKExport($this->request);
        $sheets['FORM FIT OUT'] = new Fitout($this->request);
        $sheets['FORM OPERASIONAL'] = new Operasional($this->request);
        $sheets['FORM MARCOMM'] = new Marcomm($this->request);
        return $sheets;
    }
}