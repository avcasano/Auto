<?php

namespace App\Admin\Controllers\apptelmex;

use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\Dashboard;

/*
ebm manejo personalizado redirect errores

 */

class ErrorHandlerController extends Controller

{

  public function errorCode404()
  {
    return Admin::content(function (Content $content) {
      $content->row(Dashboard::title('<strong>404</strong> <br>La página solicitada no fue encontrada...',admin_base_path('/')
      ));
    });
  }

  public function errorCode405()
  {
    return Admin::content(function (Content $content) {
      $content->row(Dashboard::title('<strong>405</strong> <br>La página solicitada no fue encontrada...',admin_base_path('/')
      ));
    });
  }
}
