<?php

namespace App\Admin\Controllers\appTelmexDemo;

use App\Contact;
use App\CsvData;
use App\Http\Requests\CsvImportRequest;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;

use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Alert;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Callout;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;


class ImportDataController extends Controller
{
  public $csv_header_fields;
  public $csv_data;
  public $csv_data_file;
  public $data;



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getImport()
    {
        return Admin::content(function (Content $content) {
        $content->header('Ejemplo 1 ');
        $content->row(view('apptelmex.import',['sTipoArchivo'=>'Nombre del proceso ...']));
      });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function parseImport(CsvImportRequest $request)
     {
       $path = $request->file('csv_file')->getRealPath();
       if ($request->has('header')) {
           $data = Excel::load($path, function($reader) {})->get()->toArray();
       } else {
           $data = array_map('str_getcsv', file($path));
       }
       if (count($data) > 0) {
           if ($request->has('header')) {
               $this->csv_header_fields = [];
               foreach ($data[0] as $key => $value) {
                   $this->csv_header_fields[] = $key;
               }
           }
           $this->csv_data = array_slice($data, 0, 2);
           $this->csv_data_file = CsvData::create([
               'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
               'csv_header' => $request->has('header'),
               'csv_data' => json_encode($data)
           ]);
       } else {
           return redirect()->back();
       }
       return Admin::content(function (Content $content) {
       $content->header('Valida campos a cargar Vs layout');
       $content->row(view('apptelmex.import_fields',['csv_header_field'=>$this->csv_header_fields,'csv_data'=>$this->csv_data,'csv_data_file'=>$this->csv_data_file]));
     });
    }
    public function processImport(Request $request)
    {
        $data = CsvData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        foreach ($csv_data as $row) {
            $contact = new Contact();
            foreach (config('app.db_fields') as $index => $field) {
                if ($data->csv_header) {
                    $contact->$field = $row[$request->fields[$field]];
                } else {
                    $contact->$field = $row[$request->fields[$index]];
                }
            }
            $contact->save();
        }
        return Admin::content(function (Content $content) {
        $content->header('Valida campos a cargar Vs layout');
        $content->row(view('apptelmex.import_success'));
      });

    }


}
