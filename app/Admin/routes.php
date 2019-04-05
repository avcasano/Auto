<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
});

  //ebm seguridad, admin, etc
Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => 'App\Apptelmex\admin\Controllers',
    'middleware'    => config('admin.route.middleware'),
  ], function (Router $router) {
  //ebm seguridad
  $router->resource('admin/users',UserController::class);
  $router->get('admin/logout', 'UserController@getLogout');
  $router->get('admin/profiles', 'UserController@getProfile')->name('profile');
  $router->post('admin/profiles', 'UserController@changePassword')->name('changePassword');
  $router->resource('sistemas/modulo',AdminModuloController::class);
  $router->resource('estados', EstadoController::class);
  $router->resource('epinturas', EstadoPinturaController::class);
});

//Route::resource('app/Models/marca','MarcaController');
//Route::resource('prueba','pruebaController');
//Route::resource('app/admin/test',App\Apptelmex\admin\Controllers\testController::class);
//Route::resource('app/admin/helpers/Scaffold',App\Apptelmex\helpers\Scaffold\AppTelmexScaffoldController::class);
