<?php

namespace App\Admin\Controllers\appTelmexDemo;

use App\Http\Controllers\Controller;
use App\Models\appTelmexDemo\Category;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Tree;

class CategoryController extends Controller
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
            $content->header('Ejemplo de una Catálogo para manejo de Padre Hijo ...');
            $content->description('App\Admin\Controllers\appTelmexDemo\CategoryController');
            $content->body($this->tree());
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
            $content->header('Editar Padre Hijo ...');
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
            $content->header('Crear una nueva categoría');
            $content->body($this->form());
        });
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function tree()
    {
        return Category::tree(function (Tree $tree) {

            $tree->branch(function ($branch) {
                // ebm
                //$src = config('admin.upload.host') . '/' . $branch['logo'] ;
                //$logo = "<img src='$src' style='max-width:30px;max-height:30px' class='img'/>";

                $logo = "<i class='fa fa-tasks'></i>";

                return "{$branch['id']} - {$branch['title']} $logo";

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
        return Category::form(function (Form $form) {

            $form->display('id', 'ID');

            $form->select('parent_id','Padre')->options(Category::selectOptions());

            $form->text('title','Nombre')->rules('required');
            $form->textarea('desc','Descripción')->rules('required');
          //  $form->image('logo');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
