<?php

namespace App\Apptelmex\helpers\ExcelExporter;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;
use App\Apptelmex\helpers\ExcelExporter\DataExport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ExcelExpoter extends AbstractExporter 
{


	public function export()
	{     
		$filename = $this->getTable().' '.now().'.xlsx';
    $titles =	$this->getHeaderRowFromRecords($this->getData());
    $data   = $this->getFormattedRecord($this->getData());
		Excel::download(new DataExport($titles,$data), $filename)->send();
		exit;
	}


	public function getFormattedRecord(array $record)
	{
		return $record ;
	}
	public function getHeaderRowFromRecords(array $records)
	{
		$records = collect($records);
		$titles = collect(array_dot($records->first() ))->keys()->map(
			function ($key) {
				$key = str_replace('.', ' ', $key);
				return Str::ucfirst($key);
			}
		);
		return $titles->toArray();
	}

}


