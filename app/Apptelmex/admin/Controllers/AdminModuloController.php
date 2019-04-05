<?php

namespace App\Apptelmex\admin\Controllers;

use App\Apptelmex\admin\Models\AdminModulo;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Apptelmex\helpers\ExcelExporter\ExcelExpoter;
use Encore\Admin\Layout\Row;

class AdminModuloController extends Controller
{
  use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
      return Admin::content(function (Content $content) {

        $content->header('Módulos Slug');
        $content->description('Listado');
        $content->body($this->grid());
      });
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
        $content->header('Editar');
        $content->description('Módulos Slug');
        //$content->body($this->form()->edit($id));
          $content->row(function(Row $row) use ($id) {
            //$row->column(1,'' );
            $row->column(6, $this->form()->edit($id));
          });        
      });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
      return Admin::content(function (Content $content) {

        $content->header('Crear');
        $content->description('Módulos Slug');
          $content->row(function(Row $row)  {
            $row->column(6, $this->form());
          });
      });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
      return Admin::grid(AdminModulo::class, function (Grid $grid) {

        $grid->exporter(new ExcelExpoter());
        $grid->paginate(10);
        $grid->perPages([10, 20, 30, 40]);

        $grid->actions(function (Grid\Displayers\Actions $actions) {
          $actions->disableView();
        });
        $grid->tools->disableRefreshButton();
        $grid->tools(function (Grid\Tools $tools) {
          $tools->batch(function (Grid\Tools\BatchActions $actions) {
            $actions->disableDelete();
          });
        });
        $grid->id('Id');
        $grid->slug('Módulo');
        $grid->descripcion('Módulo');
        $grid->created_at('Creado');
        $grid->updated_at('Actualizado');
        $grid->filter(function (Grid\Filter $filter) {
          $filter->equal('slug','Módulo');
          $filter->equal('descripcion','Descripción');
          $filter->between('created_at')->datetime();
          $filter->between('updated_at')->datetime();

        });
      });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
      return Admin::form(AdminModulo::class, function (Form $form) {
        $form->disableViewCheck();  
        $form->disableEditingCheck();  
        $form->disableCreatingCheck();
        $form->disableReset();        
        $form->display('id', 'Id');
        $form->display('created_at', 'Creado');
        $form->display('updated_at', 'Actualizado');
        $form->text('slug', 'Módulo')->rules(['required','min:5','max:6']);
        $form->text('descripcion', 'Descripción')->rules(['required','max:50']);
        $form->tools(function (Form\Tools $tools) {
          $tools->disableView();
        });
        $form->setWidth(9, 3);
      });
    }
  }
