<?php

namespace App\Admin\Controllers\appTelmex\admin;

use App\Models\appTelmex\TelaImport;
use App\Models\appTelmex\TelaImportField;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

class TelaImportController extends Controller
{
  use ModelForm;

  protected $telaimport;
  protected $telaimportfield;
  protected $dataimport;
  protected $saved;


  public function index()
  {
      return Admin::content(function (Content $content) {

          $content->header('Configuración Carga Másiva');
          $content->description('Alta');
          $dbTypes = [
              'string', 'integer', 'text', 'float', 'double', 'decimal', 'boolean', 'date', 'time',
              'dateTime', 'timestamp', 'char', 'mediumText', 'longText', 'tinyInteger', 'smallInteger',
              'mediumInteger', 'bigInteger', 'unsignedTinyInteger', 'unsignedSmallInteger', 'unsignedMediumInteger',
              'unsignedInteger', 'unsignedBigInteger', 'enum', 'json', 'jsonb', 'dateTimeTz', 'timeTz',
              'timestampTz', 'nullableTimestamps', 'binary', 'ipAddress', 'macAddress',
          ];
          $action = URL::current();
          $content->breadcrumb(
               ['text' => 'Ayudantes'],
               ['text' => 'Herramientas', 'url' => '/configuracion/import'],
               ['text' => 'Configurar Carga' ]
          );
          $content->row(view('apptelmex.tela_import', compact('dbTypes', 'action')));
          $content->body($this->grid());

      });
  }


  /**
   * Make a grid builder.
   *
   * @return Grid
   */
  protected function grid()
  {
      return Admin::grid(Telaimport::class, function (Grid $grid) {
          //$grid->exporter(new ExcelExpoter());
          $grid->disableCreation();
          $grid->tools(function ($tools) {
              $tools->batch(function ($batch) {
                  $batch->disableDelete();
              });
          });
          $grid->proceso('Proceso')->sortable();
          $grid->descripcion('Descripción')->sortable();
          $grid->modelo('Tabla')->sortable();
          $grid->created_at('Alta');
          $grid->updated_at('Modificación');
          $grid->rows(function (Grid\Row $row) {
          if ($row->id % 2) {
              $row->setAttributes(['style' => 'color:blue;']);
            }
          });
          $grid->filter(function (Grid\Filter $filter) {

              $filter->equal('Proceso');
              $filter->equal('created_at')->datetime();
              $filter->between('updated_at')->datetime();

          });
          //$grid->disableFilter();
    //    $grid->exporter(new ExcelExporter());
      });

  }


  public function store(Request $request)
  {
    $message = '';
    $this->telaimport = New Telaimport;
    $this->telaimportfield = New TelaImportField;
    try {
      $this->dataImport=[
        'proceso'      => Input::get('proceso'),
        'descripcion'  => Input::get('descripcion'),
        'modelo'       => Input::get('modelo'),
      ];
      DB::transaction(function () {
        foreach ($this->dataImport as $column => $value) {
            $this->telaimport->setAttribute($column, $value);
        }
        $this->telaimport->save();
        $temporal=[];
        foreach (Input::get('tela_import_fields') as $column => $value) {
          $temporal=[
            'tela_import_id' => $this->telaimport->getOriginal('id'),
            'field'          => $value['field'],
            'tipo'           => $value['tipo'],
            'nulos'          => $value['nulos'],
            'rule'           => $value['rule'],
            'model'          => $value['model'],
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s')
          ];
          DB::table('tela_import_fields')->insert( $temporal );
         }
      });

    } catch (\Exception $exception) {
        return $this->backWithException($exception);
    }
    return $this->backWithSuccess($message);
  }
  /**
   * Edit interface.
   *
   * @param $id
   * @return Content
   */
  public function edit($id)
  {
      return Admin::content(function (Content $content) use ($id) {

        $content->header('Configuración Carga Másiva');
        $content->description('Editar');
        $dbTypes = [
            'string', 'integer', 'text', 'float', 'double', 'decimal', 'boolean', 'date', 'time',
            'dateTime', 'timestamp', 'char', 'mediumText', 'longText', 'tinyInteger', 'smallInteger',
            'mediumInteger', 'bigInteger', 'unsignedTinyInteger', 'unsignedSmallInteger', 'unsignedMediumInteger',
            'unsignedInteger', 'unsignedBigInteger', 'enum', 'json', 'jsonb', 'dateTimeTz', 'timeTz',
            'timestampTz', 'nullableTimestamps', 'binary', 'ipAddress', 'macAddress',
        ];
        $action = URL::previous().'/'.$id;
        $action = URL::current();
        //$content->row($action);
        //$content->row(view('apptelmex.tela_import', compact('dbTypes', 'action')))->edit($id);
        $content->body($this->form()->edit($id));
      });
  }


  /**
   * Make a form builder.
   *
   * @return Form
   */
  protected function form()
  {
      return Admin::form(TelaImport::class, function (Form $form) {


        $form->display('id');
        $form->text('proceso','Proceso');
        $form->text('descripcion','Descripción');
        $form->text('modelo','Tabla');
        $form->display('created_at');
        $form->display('updated_at');

        $form->hasMany('telaimportfield','Detalle de Campos', function (Form\NestedForm $form) {
          $options = [   1 => 'Sansa',
                          2 => 'Brandon',
                          3 => 'Daenerys',
                          4 => 'Jon'
                      ];
          $form->text('field','Campo');
          $form->text('tipo','Tipo');
          $form->text('nulos','Nulos');
          $form->text('rule','Validación');
          //$form->multipleSelect('rule','Validaciones')->options($options)->setWidth(4,2);
          $form->text('model','Tabla');
          $form->display('created_at');
          $form->display('updated_at');
        });


      });
  }

  protected function backWithException(\Exception $exception)
  {
      $error = new MessageBag([
          'title'   => 'Error',
          'message' => $exception->getMessage(),
      ]);

      return back()->withInput()->with(compact('error'));
  }

  protected function backWithSuccess( $message)
  {
      $messages = [];
      $messages[] = "<br />$message";
      $success = new MessageBag([
          'title'   => 'Exito ',
          'message' => implode('<br />', $messages),
      ]);
      return back()->with(compact('success'));
  }

}
