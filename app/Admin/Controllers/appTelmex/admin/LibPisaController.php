<?php

namespace App\Admin\Controllers\appTelmex\admin;

use App\Models\appTelmex\admin\LibPisa;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class LibPisaController extends Controller
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

            $content->header('Librería PISA');
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
            $content->description('Librería PISA');

            $content->body($this->form()->edit($id));
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
            $content->description('Librería PISA');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(LibPisa::class, function (Grid $grid) {
          $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
          });
          $grid->tools->disableRefreshButton();
          $grid->tools(function (Grid\Tools $tools) {
              $tools->batch(function (Grid\Tools\BatchActions $actions) {
                  $actions->disableDelete();
              });
          });
          $grid->id('ID')->sortable();
          $grid->lib_pisa('Librería PISA')->sortable();
          $grid->descripcion('Nombre')->sortable();
          $grid->created_at('Creado');
          $grid->updated_at('Actualizado');
          $grid->filter(function (Grid\Filter $filter) {
              $filter->equal('lib_pisa');
              $filter->equal('descripcion');
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
        return Admin::form(LibPisa::class, function (Form $form) {
          $form->display('id', 'Id')->setWidth(2, 2);
          $form->text('lib_pisa', 'Librería PISA')->rules(['required','unique:admin_lib_pisa,lib_pisa'])->setWidth(4, 2);
          $form->text('descripcion', 'Nombre')->rules(['required'])->setWidth(4, 2);
          $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
          });
          $form->display('created_at', 'Creado');
          $form->display('updated_at', 'Actualizado');
        });
    }
}
