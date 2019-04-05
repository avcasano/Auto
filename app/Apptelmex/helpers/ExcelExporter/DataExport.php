<?php

namespace App\Apptelmex\helpers\ExcelExporter;


use Maatwebsite\Excel\Concerns\FromCollection;
//use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Apptelmex\helpers\ExcelExporter\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DataExport extends ExcelExpoter implements FromCollection, WithHeadings , ShouldAutoSize, WithEvents 
{
  //use Exportable;

  protected  $titles;
  protected  $data;

  public function __construct( $titles , $data)
  {
    $this->titles = $titles;
    $this->data = $data;
  }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return User::get();
    //  dd($this->data);
      return collect($this->data);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
      return $this->titles;
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);

            },
        ];
    }    
  }
