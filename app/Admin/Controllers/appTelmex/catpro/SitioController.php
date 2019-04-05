<?php

namespace App\Admin\Controllers\appTelmex\catpro;

use App\Models\appTelmex\catpro\Sitio;
use App\Models\appTelmex\admin\TipoSitio;
use App\Models\appTelmex\admin\SitioSap;
use App\Models\appTelmex\admin\LibPisa;
use App\Models\appTelmex\admin\SitioPisa;
use App\Models\appTelmex\catfin\Area;
use App\Models\appTelmex\catfin\Division;
use App\Models\appTelmex\catpro\Proveedor;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SitioController extends Controller
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

            $content->header('Catálogo de Sitios');
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
        $content->description('Catálogo de Sitios');
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
          $content->description('Catálogo de Sitios');

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
        return Admin::grid(Sitio::class, function (Grid $grid) {
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
          $grid->id('Id')->sortable();
          $grid->column('division.division','División')->sortable();
          $grid->column('area.area','Area')->sortable();
          $grid->column('sitiosap.sitio_sap','Clave Sap')->sortable();
          $grid->sitio('Sitio')->sortable();
          $grid->column('libpisa.lib_pisa','Lib Pisa')->sortable();
          $grid->created_at('Creado');
          $grid->updated_at('Actualizado');
          $grid->filter(function (Grid\Filter $filter) {
              $filter->like('division.division','División');
              $filter->like('area.area','Area');
              $filter->like('sitio');
              $filter->equal('sitiosap.sitio_sap','Clave Sap');
              $filter->equal('libpisa.lib_pisa','Lib Pisa');
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
      return Admin::form(Sitio::class, function (Form $form) {
        $states = [
            'on'  => ['value' => 1, 'text' => 'Activo', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => 'Inactivo', 'color' => 'danger'],
        ];
        //dump(config('tipo_sitio_prov_log'));
        $form->display('id', 'ID');
        $form->display('created_at', 'Creado');
        $form->display('updated_at', 'Actualizado');

        $form->text('sitio', 'Sitio (Descripción)')->rules(['required','max:50','unique:catpro_sitios']);

        $form->select('admin_sitio_sap_id', 'Sitio Sap')
          ->options(SitioSap::all()
          ->pluck('sitio_sap', 'id'))
          ->rules(['required','unique:catpro_sitios']);

        $form->select('admin_tipo_sitio_id', 'Tipo de Sitio')
          ->options(TipoSitio::all()
          ->pluck('tipo_sitio', 'id'))
          ->rules(['required'])
          ->load('catpro_proveedor_id', '/app/admin/api/proveedor');
        $form->select('catpro_proveedor_id','Proveedor  Logístico')->options(Proveedor::all()->pluck('proveedor', 'id'));

        $form->select('catfin_division_id', 'División')
          ->options(Division::all()
          ->pluck('division', 'id'))
          ->rules(['required'])
          ->load('catfin_area_id', '/app/admin/api/division');
        $form->select('catfin_area_id','Area')->options( Area::all()->pluck('area', 'id'));

        $form->switch('envia_pisa','Envía Pisa')->states($states);

        $form->select('admin_lib_pisa_id', 'Libreria Pisa')
          ->options(LibPisa::all()
          ->pluck('lib_pisa', 'id'))
          ->rules(['required'])
          ->load('admin_sitio_pisa_id', '/app/admin/api/libpisa');
        $form->select('admin_sitio_pisa_id','Sitio Pisa')->options(SitioPisa::all()->pluck('sitio_pisa', 'id'));

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });
        $form->setWidth(5, 2);
      });
    }

    public function division(Request $request)
    {
      $catfin_division_id = $request->get('q');
      return Area::select(DB::raw('area as text,id'))->where('catfin_division_id',$catfin_division_id)->get();
    }

    public function libpisa(Request $request)
    {
      $admin_lib_pisa_id = $request->get('q');
      return SitioPisa::select(DB::raw('sitio_pisa as text,id'))->where('admin_lib_pisa_id',$admin_lib_pisa_id)->get();
    }

    public function proveedor(Request $request)
    {
      $tipo_sitio = $request->get('q');
      if (config('tipo_sitio_prov_log')==$tipo_sitio) {
        return Proveedor::select(DB::raw('proveedor as text,id'))->get();
      }
      return '';



    }

}
