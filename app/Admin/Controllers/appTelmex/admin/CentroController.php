<?php


namespace App\Admin\Controllers\appTelmex\admin;


use App\Models\appTelmex\admin\Centro;
use App\Models\appTelmex\admin\Empresa;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class CentroController extends Controller
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

            $content->header('Centro Sap');
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
            $content->description('Centro Sap');
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
            $content->description('Centro Sap');

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
        return Admin::grid(Centro::class, function (Grid $grid) {
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
          $grid->Empresa()->empresa('Empresa')->sortable();
          $grid->centro('Centro Sap')->sortable();
          $grid->descripcion('Descripción')->sortable();
          $grid->estatus('Estatus')->sortable();
          $grid->created_at('Creado');
          $grid->updated_at('Actualizado');
          $grid->filter(function (Grid\Filter $filter) {
              $filter->equal('centro','Centro Sap');
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
        return Admin::form(Centro::class, function (Form $form) {
          $estatus = [1  => 'Activo',2=>'Inactivo' ];
          $form->display('id', 'ID')->setWidth(2, 2);
          $form->display('created_at', 'Created At')->setWidth(2, 2);
          $form->display('updated_at', 'Updated At')->setWidth(2, 2);
          $form->select('catfin_empresa_id', 'Empresa')->options(Empresa::all()->pluck('empresa', 'id'))->rules(['required'])->setWidth(2, 2);
          $form->text('centro', 'Centro Sap')->rules(['required'])->setWidth(2, 2);
          $form->text('descripcion', 'Descripción')->rules(['required'])->setWidth(4, 2);
          $form->select('estatus', 'Estatus')->options($estatus)->setWidth(2, 2);

          $form->tools(function (Form\Tools $tools) {
              $tools->disableView();
          });

        });
    }
}
