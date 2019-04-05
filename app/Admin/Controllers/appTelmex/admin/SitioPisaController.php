<?php

namespace App\Admin\Controllers\appTelmex\admin;

use App\Models\appTelmex\admin\SitioPisa;
use App\Models\appTelmex\admin\LibPisa;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class SitioPisaController extends Controller
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

            $content->header('Sitio Pisa');
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
        $content->description('Sitio Pisa');
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
            $content->description('Sitio Pisa');

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
        return Admin::grid(SitioPisa::class, function (Grid $grid) {
          $grid->paginate(10);
          $grid->perPages([10, 20, 30, 40, 50]);
          $grid->model('SitioPisa')->orderBy('admin_lib_pisa_id');
          $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
          });
          $grid->tools->disableRefreshButton();
          $grid->tools(function (Grid\Tools $tools) {
              $tools->batch(function (Grid\Tools\BatchActions $actions) {
                  $actions->disableDelete();
              });
          });
          $grid->LibPisa()->descripcion('Libreria PISA')->sortable();
          $grid->sitio_pisa('Sitio PISA')->sortable();
          $grid->created_at('Creado');
          $grid->updated_at('Actualizado');
          $grid->filter(function (Grid\Filter $filter) {
              $filter->equal('sitio_pisa');
              $filter->equal('libpisa.descripcion','Libreria PISA');
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
      return Admin::form(SitioPisa::class, function (Form $form) {

        $form->display('id', 'ID');
        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');
        $form->select('admin_lib_pisa_id', 'Librería PISA')->options(LibPisa::all()->pluck('descripcion', 'id'))->rules(['required'])->setWidth(4, 2);
        $form->text('sitio_pisa', 'Sitio')->rules(['required']);
        $form->tools(function (Form\Tools $tools) {
          $tools->disableView();
        });
        $form->setWidth(4, 2);
      });
    }
}
