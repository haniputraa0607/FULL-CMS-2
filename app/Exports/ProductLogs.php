<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Lib\MyHelper;

class ProductLogs implements FromArray, WithTitle,  ShouldAutoSize, WithEvents
{
    protected $request;

    function __construct($request,$key,$post) {
        $this->request = $request;
        $this->key = $key;
        $this->post = $post;
    }

    public function array(): array
    {
        $body = [
            [
                0 => 'Product Name', 
                1 => $this->key, 
            ],
            [
                0 => 'Periode', 
                1 => date('d F Y',strtotime($this->post['start_date'])).' - '.date('d F Y',strtotime($this->post['end_date'])), 
            ],
        ];
        $index = 0;
        foreach($this->request as $key => $val){
            $body[] = [
                [
                    '' 
                ],
                [
                    0 => 'Unit',
                    1 => $key
                ],
                [
                    'Date' => 'Date', 
                    'Source' => 'Source', 
                    'Stock In' => 'Stock In',
                    'Stock Out' => 'Stock Out',
                    'Current Stock' => 'Current Stock',
                ]
            ];
            $body[] = $val;
        }
    	return $body;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return "Report_Product_".$this->key;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        $register = [
                AfterSheet::class    => function(AfterSheet $event) {
                    $last = count($this->request['PCS']);
                    $styleArray = [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'],
                            ]
                        ],
                        'numberFormat' => [
                            'formatCode' => '#,##0'
                        ],
                    ];
                    $styleHead = [
                        'font' => [
                            'bold' => true,
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'rotation' => 90,
                            'startColor' => [
                                'argb' => 'FFA0A0A0',
                            ],
                            'endColor' => [
                                'argb' => 'FFFFFFFF',
                            ],
                        ],
                    ];
                    $x_coor = MyHelper::getNameFromNumber(count($this->request['PCS'][0]??[]));
                    $event->sheet->getStyle('A1:'.$x_coor.($last+1))->applyFromArray($styleArray);
                    $headRange = 'A1:'.$x_coor.'1';
                    $event->sheet->getStyle($headRange)->applyFromArray($styleHead);
                },
            ];
        $register = [];
        return $register;
    }
}
