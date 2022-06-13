<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductLogExport implements WithMultipleSheets
{
    use Exportable;
    protected $request;
    function __construct(array $request, array $post) {
        $this->request = $request;
        $this->post = $post;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        // $sheets[] = new ProductLogs($this->request['GOOD OB NEUTALIZER STEP 1 450ML']['PCS']);

        foreach ($this->request as $key => $value) {
            // sheet title maksimal 31 caracter
            $sheets[] = new ProductLogs($value, $key, $this->post, substr($key,0,30));
        }

        return $sheets;
    }
}
