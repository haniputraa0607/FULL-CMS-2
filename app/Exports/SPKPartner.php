<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Fitout;
use App\Exports\Marcomm;
use App\Exports\SPKExport;
use App\Exports\Operasional;
use Maatwebsite\Excel\Concerns\WithTitle;
class SPKPartner implements WithMultipleSheets
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
        return $sheets;
    }
}