<?php

namespace App\Admin\Controllers\appTelmex\admin;

use App\Models\appTelmex\admin\SitioSap;
use App\Models\appTelmex\admin\Centro;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class SitioSapController extends Controller
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

            $content->header('Sitio Sap');
            $content->description('Listado');
            $content->row(function(Row $row) {
              //$row->column(2, '');
              $row->column(12, $this->grid());
            });

            //$content->body($this->grid());
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
            $content->description('Sitio Sap');

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
            $content->description('Sitio Sap');
            $content->row(function(Row $row) {
              $row->column(1, '');
              $row->column(6, $this->form());
            });
            //$content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(SitioSap::class, function (Grid $grid) {
          $grid->paginate(10);
          $grid->perPages([10, 20, 30, 40, 50]);
          $grid->model('SitioSap')->orderBy('admin_centro_id','sitio_sap');
          $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
          });
          $grid->tools->disableRefreshButton();
          $grid->tools(function (Grid\Tools $tools) {
              $tools->batch(function (Grid\Tools\BatchActions $actions) {
                  $actions->disableDelete();
              });
          });


          $grid->Centro()->centro('Clave')->sortable();
          $grid->Centro()->descripcion('Centro Sap')->sortable();
          $grid->sitio_sap('Sitio SAP')->sortable();
          $grid->descripcion('Descripción')->sortable();
          $grid->created_at('Creado');
          $grid->updated_at('Actualizado');
          $grid->filter(function (Grid\Filter $filter) {
              $filter->equal('sitio_sap');
              $filter->equal('centro.centro','Centro Sap');
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
      return Admin::form(SitioSap::class, function (Form $form) {
        $form->setWidth(4, 2);
        $form->display('id', 'Id');
        $form->display('created_at', 'Creado');
        $form->display('updated_at', 'Actualizado');
        $form->select('admin_centro_id', 'Centro Sap')->options(Centro::all()->pluck('centro', 'id'))->rules(['required']);
        $form->text('sitio_sap', 'Sitio Sap')->rules(['required']);
        $form->text('descripcion', 'Descripción')->rules(['required']);
        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });

      });
    }
}
