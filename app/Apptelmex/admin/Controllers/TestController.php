<?php
namespace App\Apptelmex\admin\Controllers;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class TestController extends Controller 
{

    public function index()
    {
      return Excel::download(new UsersExport, 'users.xlsx');
    }	

}