<?php

namespace App\Admin\Controllers\appTelmex\catfin;

use App\Models\appTelmex\catfin\Area;
use App\Models\appTelmex\catfin\Division;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class AreaController extends Controller
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

            $content->header('Areas');
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
            $content->description('Areas');

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
            $content->description('Areas');

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
        return Admin::grid(Area::class, function (Grid $grid) {
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
          $grid->area('Area')->sortable();
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
        return Admin::form(Area::class, function (Form $form) {
          $form->display('id', 'Id')->setWidth(2, 2);
          $form->select('catfin_division_id', 'División')->options(Division::all()->pluck('division', 'id'))->rules(['required'])->setWidth(4, 2);
          $form->text('area', 'Area')->rules(['required'])->setWidth(4, 2);
          $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
          });
          $form->display('created_at', 'Creado');
          $form->display('updated_at', 'Actualizado');
        });
    }
}
