<?php

namespace App\Admin\Controllers\appTelmex\admin;

use App\Models\appTelmex\admin\TipoUser;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class TipoUserController extends Controller
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

            $content->header('Tipo de Usuario');
            $content->description('Lista');

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
            $content->description('Tipo de Usuario');

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
            $content->description('Tipo de Usuario');

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
        return Admin::grid(TipoUser::class, function (Grid $grid) {
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
          $grid->tipo_user('Tipo de Usuario')->sortable();
          $grid->created_at('Creado');
          $grid->updated_at('Actualizado');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(TipoUser::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('tipo_user', 'Tipo Usuario')->rules(['required','unique:admin_tipo_users,tipo_user']);
            $form->display('created_at', 'Creado');
            $form->display('updated_at', 'Actualizado');
            //$form->disableReset();
            $form->tools(function (Form\Tools $tools) {
                $tools->disableView();
            });
            $form->setWidth(4, 2);
        });
    }
}
