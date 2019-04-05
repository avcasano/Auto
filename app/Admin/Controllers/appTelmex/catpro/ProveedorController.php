<?php

namespace App\Admin\Controllers\appTelmex\catpro;

use App\Models\appTelmex\catpro\Proveedor;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ProveedorController extends Controller
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

            $content->header('Proveedores');
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
            $content->description('Proveedores');

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
            $content->description('Proveedores');

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
        return Admin::grid(Proveedor::class, function (Grid $grid) {
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
          $grid->proveedor('Proveedor');
          $grid->nombre_corto('Nombre Corto');
          $grid->acreedor_sap('Clave Sap (Acreedor)');
          $grid->created_at('Creado');
          $grid->updated_at('Actualizado');
          $grid->filter(function (Grid\Filter $filter) {
              $filter->equal('proveedor','Proveedor');
              $filter->equal('nombre_corto','Nombre Corto');
              $filter->equal('acreedor_sap','Clave Sap');
              $filter->between('created_at','Creado')->datetime();
              $filter->between('updated_at','Actualizado')->datetime();

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
      return Admin::form(Proveedor::class, function (Form $form) {
        $form->setWidth(4, 2);
        $form->display('id', 'Id');
        $form->display('created_at', 'Creado');
        $form->display('updated_at', 'Actualizado');
        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });
        $form->text('proveedor', 'proveedor')->rules(['required']);
        $form->text('nombre_corto', 'Nombre Corto')->rules(['required','max:10'])->setWidth(2, 2);
        $form->text('acreedor_sap', 'Clave Sap (Acreedor)')->rules(['required','max:5','min:5'])->setWidth(2, 2);


      });
    }
}
