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
                    $index = 0;
                    $first = 4;
                    $last = 4;
                    $column = 0;
                    foreach($this->request ?? [] as $key => $val){
                        if($index == 0){
                            $column = MyHelper::getNameFromNumber(count($val[0]??[]));
                        }
                        $last = $last + count($val);
                        $x_coor = $column;
                        $event->sheet->getStyle('A'.($first+1).':'.$x_coor.($last+1))->applyFromArray($styleArray, null, 'E6', true);
                        $headRange = 'A'.($first+1).':'.$x_coor.($first+1);
                        $event->sheet->getStyle($headRange)->applyFromArray($styleHead);
                        $event->sheet->mergeCells('B'.($first+2).':D'.($first+2));
                        $event->sheet->mergeCells('B'.($last+1).':D'.($last+1));
                        $index++;
                        $first = $first + count($val) + 3;
                        $last = $last + 3;
                    }

                },
            ];
        return $register;
    }
}
