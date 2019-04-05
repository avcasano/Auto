<?php

namespace App\Admin\Controllers\appTelmexDemo;


use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Alert;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Callout;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;

class WidgetsController extends Controller
{
    public function form1()
    {
        return Admin::content(function (Content $content) {
            $content->header('Ejemplo 1 ');
            $content->description('App\Admin\Controllers\appTelmexDemo\WidgetsController');
            $content->appTelmexText('<pre>
  public function form1(){
      return Admin::content(function (Content $content) {
          $content->header(\'Ejemplo 1 \');
          // Titulo
          $content->description(\'App\Admin\Controllers\appTelmexDemo\WidgetsController\');
          // Descripción
          $this->showFormParameters($content);
          // Funcion para mostrar la captura
          $form = new Form();
          // Crea objeto Form() -> use Encore\Admin\Widgets\Form;
          $options = [
                          1 => \'Sansa\',
                          2 => \'Brandon\',
                          3 => \'Daenerys\',
                          4 => \'Jon\'
                      ];
          $form->method(\'get\');
          $form->text(\'text\')->setWidth(4,2)->rules([\'required\']);;
          $form->email(\'email\')->setWidth(2,2)->rules([\'required\']);;
          $form->mobile(\'mobile\', \'Celuar\',22);
          $form->url(\'url\');
          $form->ip(\'ip\');
          $form->color(\'color\', \'Color\');
          $form->number(\'number\', \'Númmero\');
          $form->switch(\'switch\', \'switch\');
          $form->textarea(\'text_area\');
          $form->currency(\'currency\');
          $form->rate(\'rate\');
          $form->select(\'select_sencillo\')->options($options)->setWidth(2,2);
          $form->multipleSelect(\'select_multiple\')->options($options)->setWidth(4,2);
          $form->slider(\'slider\')->setWidth(4,2);
          $form->html(\'<br><h3>Tag\'s para manejo de Archivos</h3>\')->setWidth(10,1);
          $form->divide();
          $form->file(\'file\',\'Carga Archivo\')->setWidth(4,2);
          $form->image(\'image\',\'Carga Imagen\')->setWidth(4,2);

          $form->html(\'<br><h3>Tag\'s para manejo de Fechas</h3>\')->setWidth(10,1);
          $form->divide();
          $form->date(\'date\',\'Fecha Simple\');
          $form->time(\'time\',\'Hora Simple\');
          $form->datetime(\'datetime\',\'Fecha y Hora\');
          $form->dateRange(\'date_start\', \'date_end\', \'Date range\',\'Rango de Fechas\');
          $form->timeRange(\'time_start\', \'time_end\', \'Time range\',\'Rango de Horas\');
          $form->dateTimeRange(\'date_time_start\', \'date_time_end\', \'Rango de fechas y horas\');

          $content->body(new Box(\'Forma con Campos Comunes\', $form));
          $this->showFormParameters($content);
      });
  }
              </pre>');



            $form = new Form();
            $options = [
                            1 => 'Sansa',
                            2 => 'Brandon',
                            3 => 'Daenerys',
                            4 => 'Jon'
                        ];
            $form->method('get');
            $form->text('text')->setWidth(4,2)->rules(['required']);;
            $form->email('email')->setWidth(2,2)->rules(['required']);;
            $form->mobile('mobile', 'Celuar',22);
            $form->url('url');
            $form->ip('ip');
            $form->color('color', 'Color');
            $form->number('number', 'Númmero');
            $form->switch('switch', 'switch');
            $form->textarea('text_area');
            $form->currency('currency');
            $form->rate('rate');
            $form->select('select_sencillo')->options($options)->setWidth(2,2);
            $form->multipleSelect('select_multiple')->options($options)->setWidth(4,2);
            $form->slider('slider')->setWidth(4,2);
            $form->html('<br><h3>Tag\'s para manejo de Archivos</h3>')->setWidth(10,1);
            $form->divide();
            $form->file('file','Carga Archivo')->setWidth(4,2);
            $form->image('image','Carga Imagen')->setWidth(4,2);

            $form->html('<br><h3>Tag\'s para manejo de Fechas</h3>')->setWidth(10,1);
            $form->divide();
            $form->date('date','Fecha Simple');
            $form->time('time','Hora Simple');
            $form->datetime('datetime','Fecha y Hora');
            $form->dateRange('date_start', 'date_end', 'Date range','Rango de Fechas');
            $form->timeRange('time_start', 'time_end', 'Time range','Rango de Horas');
            $form->dateTimeRange('date_time_start', 'date_time_end', 'Rango de fechas y horas');

            $content->body(new Box('Forma con Campos Comunes', $form));
            $this->showFormParameters($content);
        });
    }



    public function table()
    {
        return Admin::content(function (Content $content) {
            $content->header('Tablas');
            $content->description('App\Admin\Controllers\appTelmexDemo\WidgetsController');
            $content->appTelmexText('<pre>
public function table()
{
  return Admin::content(function (Content $content) {
    $content->header(\'Tablas\');
    $content->description(\'App\Admin\Controllers\appTelmexDemo\WidgetsController\');
    // table 1
    $headers = [\'Id\', \'Email\', \'Name\', \'age\', \'Company\'];
    $rows = [
        [1, \'labore21@yahoo.com\', \'Ms. Clotilde Gibson\', 25, \'Goodwin-Watsica\'],
        [2, \'omnis.in@hotmail.com\', \'Allie Kuhic\', 28, \'Murphy, Koepp and Morar\'],
        [3, \'quia65@hotmail.com\', \'Prof. Drew Heller\', 35, \'Kihn LLC\'],
        [4, \'xet@yahoo.com\', \'William Koss\', 20, \'Becker-Raynor\'],
        [5, \'ipsa.aut@gmail.com\', \'Ms. Antonietta Kozey Jr.\', 41, \'MicroBist\'],
    ];
    $table1 = new Table($headers, $rows);
    $content->row((new Box(\'Table-1\', $table1))->style(\'info\')->solid());
    $headers = [\'Keys\', \'Values\'];
    $rows = [
        \'name\'   => \'Joe\',
        \'age\'    => 25,
        \'gender\' => \'Male\',
        \'birth\'  => \'1989-12-05\',
    ];
    $table2 = new Table($headers, $rows);
    $content->body((new Box(\'Table-2\', $table2))->style(\'danger\')->solid());
  });
}
            </pre>');
            // table 1
            $headers = ['Id', 'Email', 'Name', 'age', 'Company'];
            $rows = [
                [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 25, 'Goodwin-Watsica'],
                [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 28, 'Murphy, Koepp and Morar'],
                [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 35, 'Kihn LLC'],
                [4, 'xet@yahoo.com', 'William Koss', 20, 'Becker-Raynor'],
                [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.', 41, 'MicroBist'],
            ];

            $table1 = new Table($headers, $rows);

            $content->row((new Box('Table-1', $table1))->style('info')->solid());

            $headers = ['Keys', 'Values'];
            $rows = [
                'name'   => 'Joe',
                'age'    => 25,
                'gender' => 'Male',
                'birth'  => '1989-12-05',
            ];

            $table2 = new Table($headers, $rows);

            $content->body((new Box('Table-2', $table2))->style('danger')->solid());
        });
    }

    public function box()
    {
        return Admin::content(function (Content $content) {
            $content->header('Contenedores : Box container');
            $content->description('App\Admin\Controllers\appTelmexDemo\WidgetsController');

            $box1 = new Box('Caja 1', '<pre>Lorem ipsum dolor sit amet  <br>algo</pre>');
            $box2 = new Box('Caja 2', '<p>Lorem ipsum dolor sit amet</p><p>consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>');
            $box3 = new Box('Caja 3');

            $headers = ['Id', 'Email', 'Name', 'age', 'Company'];
            $rows = [
                [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 25, 'Goodwin-Watsica'],
                [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 28, 'Murphy, Koepp and Morar'],
                [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 35, 'Kihn LLC'],
                [4, 'xet@yahoo.com', 'William Koss', 20, 'Becker-Raynor'],
                [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.', 41, 'MicroBist'],
            ];
            $table = new Table($headers, $rows);
            $box4 = new Box('Forth Box', $table);

            $content->row($box1->collapsable());
            $content->row($box2->style('danger'));
            $content->row($box3->removable()->style('warning'));
            $content->row($box4->solid()->style('primary'));
        });
    }

    public function infoBox()
    {
        return Admin::content(function (Content $content) {
            $content->header('Caja de información');
            $content->description('App\Admin\Controllers\appTelmexDemo\WidgetsController');

            $content->row(function ($row) {
                $row->column(2, new InfoBox('Nuevos Usuarios', 'users', 'aqua', '/home/auth/users', '1024'));
                $row->column(2, new InfoBox('Permisos', 'shopping-cart', 'green', '/home/auth/permissions', '15'));
                $row->column(2, new InfoBox('Articles', 'book', 'yellow', '/demo/articles', '2786'));
                $row->column(2, new InfoBox('Documents', 'file', 'red', '/demo/files', '698726'));
                $row->column(2, new InfoBox('Articles', 'book', 'light-blue', '/demo/articles', '2786'));
                $row->column(2, new InfoBox('Documents', 'file', 'gray', '/demo/files', '698726'));
                $row->column(2, new InfoBox('Nuevos Usuarios', 'users', 'navy', '/home/auth/users', '1024'));
                $row->column(2, new InfoBox('Permisos', 'shopping-cart', 'teal', '/home/auth/permissions', '15'));
                $row->column(2, new InfoBox('Articles', 'book', 'olive', '/demo/articles', '2786'));
                $row->column(2, new InfoBox('Documents', 'file', 'lime', '/demo/files', '698726'));
                $row->column(2, new InfoBox('Articles', 'book', 'orange', '/demo/articles', '2786'));
                $row->column(2, new InfoBox('Documents', 'file', 'fuchsia', '/demo/files', '698726'));
                $row->column(2, new InfoBox('Documents', 'file', 'purple', '/demo/files', '698726'));
                $row->column(2, new InfoBox('Articles', 'book', 'maroon', '/demo/articles', '2786'));
                $row->column(2, new InfoBox('Documents', 'file', 'black', '/demo/files', '698726'));

                $row->column(2, new InfoBox('Nuevos Usuarios', 'users', 'aqua-active', '/home/auth/users', '1024'));
                $row->column(2, new InfoBox('Permisos', 'shopping-cart', 'green-active','/home/auth/permissions', '15'));
                $row->column(2, new InfoBox('Articles', 'book', 'yellow-active','/demo/articles', '2786'));
                $row->column(2, new InfoBox('Documents', 'file', 'red-active','/demo/files', '698726'));
                $row->column(2, new InfoBox('Articles', 'book', 'light-blue-active','/demo/articles', '2786'));
                $row->column(2, new InfoBox('Documents', 'file', 'gray-active','/demo/files', '698726'));
                $row->column(2, new InfoBox('Nuevos Usuarios', 'users', 'navy-active','/home/auth/users', '1024'));
                $row->column(2, new InfoBox('Permisos', 'shopping-cart', 'teal-active','/home/auth/permissions', '15'));
                $row->column(2, new InfoBox('Articles', 'book', 'olive-active','/demo/articles', '2786'));
                $row->column(2, new InfoBox('Documents', 'file', 'lime-active','/demo/files', '698726'));
                $row->column(2, new InfoBox('Articles', 'book', 'orange-active','/demo/articles', '2786'));
                $row->column(2, new InfoBox('Documents', 'file', 'fuchsia-active','/demo/files', '698726'));
                $row->column(2, new InfoBox('Documents', 'file', 'purple-active','/demo/files', '698726'));
                $row->column(2, new InfoBox('Articles', 'book', 'maroon-active','/demo/articles', '2786'));
                $row->column(2, new InfoBox('Documents', 'file', 'black-active','/demo/files', '698726'));

            });
            $content->appTelmexText('<pre>
Colores validos:

ejemplo: red o red-active, el bg-red se puede usar para aplicar el estilo

bg-red,
bg-yellow
bg-aqua
bg-blue
bg-light-blue
bg-green
bg-navy
bg-teal
bg-olive
bg-lime
bg-orange
bg-fuchsia
bg-purple
bg-maroon
bg-black
</pre>');
        });
    }

    public function tab()
    {
        return Admin::content(function (Content $content) {
            $content->header('Tabs');
            $content->description('App\Admin\Controllers\appTelmexDemo\WidgetsController');
            $content->appTelmexText('<pre>
  public function tab()
  {
      return Admin::content(function (Content $content) {
          $content->header(\'Tabs\');
          $content->description(\'App\Admin\Controllers\appTelmexDemo\WidgetsController\');
          $this->showFormParameters($content);
          $tab = new Tab();
          $form = new Form();
          $form->method(\'get\');
          $form->date(\'date\');
          $form->time(\'time\');
          $form->datetime(\'datetime\');
          $form->divide();
          $form->dateRange(\'date_start\', \'date_end\', \'Date range\');
          $form->timeRange(\'time_start\', \'time_end\', \'Time Range\');
          $form->dateTimeRange(\'date_time_start\', \'date_time_end\', \'Datetime range\');
          $tab->add(\'Form\', $form);
          $box = new Box(\'Second box\', \'<p>Lorem ipsum dolor sit amet</p><p>consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>\');
          $tab->add(\'Box\', $box);

          $headers = [\'Id\', \'Email\', \'Name\', \'age\', \'Company\'];
          $rows = [
              [1, \'labore21@yahoo.com\', \'Ms. Clotilde Gibson\', 25, \'Goodwin-Watsica\'],
              [2, \'omnis.in@hotmail.com\', \'Allie Kuhic\', 28, \'Murphy, Koepp and Morar\'],
              [3, \'quia65@hotmail.com\', \'Prof. Drew Heller\', 35, \'Kihn LLC\'],
              [4, \'xet@yahoo.com\', \'William Koss\', 20, \'Becker-Raynor\'],
              [5, \'ipsa.aut@gmail.com\', \'Ms. Antonietta Kozey Jr.\', 41, \'MicroBist\'],
          ];
          $table = new Table($headers, $rows);
          $tab->add(\'Table\', $table);

          $content->row($tab);
      });
  }
            </pre');

            $this->showFormParameters($content);
            $tab = new Tab();
            $form = new Form();
            $form->method('get');
            $form->date('date');
            $form->time('time');
            $form->datetime('datetime');
            $form->divide();
            $form->dateRange('date_start', 'date_end', 'Date range');
            $form->timeRange('time_start', 'time_end', 'Time Range');
            $form->dateTimeRange('date_time_start', 'date_time_end', 'Datetime range');

            $tab->add('Ejemplo con una forma', $form);
            $box = new Box('Second box', '<p>Lorem ipsum dolor sit amet</p><p>consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>');
            $tab->add('Cajas', $box);
            $headers = ['Id', 'Email', 'Name', 'age', 'Company'];
            $rows = [
                [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 25, 'Goodwin-Watsica'],
                [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 28, 'Murphy, Koepp and Morar'],
                [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 35, 'Kihn LLC'],
                [4, 'xet@yahoo.com', 'William Koss', 20, 'Becker-Raynor'],
                [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.', 41, 'MicroBist'],
            ];

            $table = new Table($headers, $rows);
            $tab->add('Tablas', $table);

            $content->row($tab);
        });
    }

    public function notice()
    {
        return Admin::content(function (Content $content) {
            $content->header('Alertas y llamadas');
            $content->description('App\Admin\Controllers\appTelmexDemo\WidgetsController');
            $content->appTelmexText('<pre></pre>');

            $content->row(function (Row $row) {

                $words = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                    Maecenas feugiat consequat diam. Maecenas metus. Vivamus diam purus, cursus a, commodo non,
                    facilisis vitae, nulla. Aenean dictum lacinia tortor. Nunc iaculis, nibh non iaculis aliquam,
                    orci felis euismod neque, sed ornare massa mauris sed velit. Nulla pretium mi et risus.';

                $row->column(6, function (Column $column) use ($words) {
                    $column->append(new Alert($words));
                    $column->append((new Alert($words, 'Alert!!'))->style('success')->icon('user'));
                    $column->append((new Alert($words))->style('warning')->icon('book'));
                    $column->append((new Alert($words))->style('info')->icon('info'));
                });

                $row->column(6, function (Column $column) use ($words) {
                    $column->append(new Callout($words));
                    $column->append((new Callout($words))->style('warning'));
                    $column->append((new Callout($words))->style('info'));
                    $column->append((new Callout($words, 'Warning!!'))->style('success'));
                });
            });
        });
    }

    public function editors()
    {
        return Admin::content(function (Content $content) {
            $content->header('Editors');

            $this->showFormParameters($content);

            $form1 = new Form();
            $form1->method('get');
            $form1->editor('text', 'Text');

//            $form2 = new Form();
//            $form2->method('get');
//            $form2->php('text3', 'PHP')->default(file_get_contents(public_path('index.php')));
//
//            $form3 = new Form();
//            $form3->method('get');
//            $form3->markdown('text4', 'Markdown')->default(file_get_contents(base_path('readme.md')));

            $content->body((new Box('WangEditor', $form1)));
//            $content->body((new Box('PHP Editor', $form2)));
//            $content->body((new Box('Markdown Editor', $form3)));

        });
    }

    protected function showFormParameters($content)
    {
        $parameters = request()->except(['_pjax', '_token']);

        if (!empty($parameters)) {

            ob_start();

            dump($parameters);

            $contents = ob_get_contents();

            ob_end_clean();

            $content->row(new Box('Parámetros recibidos por la Forma', $contents));
        }
    }
}
