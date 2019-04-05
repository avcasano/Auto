<?php

namespace App\Admin\Controllers\appTelmex\admin;

use App\Models\appTelmex\admin\Modulo;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ModuloController extends Controller
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
            $content->description('Módulos Slug');

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
        return Admin::grid(Modulo::class, function (Grid $grid) {
          $grid->paginate(10);
          $grid->perPages([10, 20, 30, 40, 50]);

          $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
          });
          $grid->tools->disableRefreshButton();
          $grid->tools(function (Grid\Tools $tools) {
              $tools->batch(function (Grid\Tools\BatchActions $actions) {
                  $actions->disableDelete();
              });
          });
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
      return Admin::form(Modulo::class, function (Form $form) {
        $form->display('id', 'Id');
        $form->display('created_at', 'Creado');
        $form->display('updated_at', 'Actualizado');
        $form->text('slug', 'Módulo')->rules(['required','min:5','max:6']);
        $form->text('descripcion', 'Descripción')->rules(['required','max:50']);
        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });
        $form->setWidth(4, 2);
      });
    }
}
