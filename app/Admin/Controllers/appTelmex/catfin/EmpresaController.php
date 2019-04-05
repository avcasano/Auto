<?php

namespace App\Admin\Controllers\apptelmex\catfin;

use App\Models\appTelmex\catfin\Empresa;
use App\Models\appTelmex\admin\TipoEmpresa;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class EmpresaController extends Controller
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

            $content->header('Catálogo de Empresas');
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

            $content->header('header');
            $content->description('description');

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

          $content->header('Alta');
          $content->description('Catálogo de Empresas');
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
        return Admin::grid(Empresa::class, function (Grid $grid) {
          $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
          });
          $grid->tools->disableRefreshButton();
          $grid->tools(function (Grid\Tools $tools) {
              $tools->batch(function (Grid\Tools\BatchActions $actions) {
                  $actions->disableDelete();
              });
          });
          $grid->empresa('Empresa')->sortable();
          $grid->empresa_larga('Descripción')->sortable();
          $grid->soc_sap('Sociedad Sap')->sortable();
          $grid->created_at('Alta');
          $grid->updated_at('Modificación');
          $grid->filter(function (Grid\Filter $filter) {
              $filter->equal('empresa');
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
    return Admin::form(Empresa::class, function (Form $form) {
      $form->display('id', 'Id')->setWidth(2, 2);
      $form->text('empresa', 'Empresa')->rules(['required'])->setWidth(4, 2);
      $form->text('empresa_larga', 'Descripción')->rules(['required'])->setWidth(4, 2);
      $form->text('soc_sap', 'Sociedad Sap')->setWidth(4, 2);
      $form->select('admin_tipo_empresa_id', 'Tipo Empresa')->options(TipoEmpresa::all()->pluck('tipo_empresa', 'id'))->rules(['required'])->setWidth(4, 2);
      $form->tools(function (Form\Tools $tools) {
        $tools->disableDelete();
        $tools->disableView();
      });
      $form->display('created_at', 'Creado');
      $form->display('updated_at', 'Actualizado');
    });
  }
}
