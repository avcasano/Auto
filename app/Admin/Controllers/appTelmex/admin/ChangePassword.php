<?php

namespace App\Admin\Controllers\appTelmex\admin;



use Encore\Admin\Admin;

class changePassword
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function title($titulo,$link)
    {
        return view('admin::dashboard.title')->with(['titulo'=>$titulo,'link'=>$link]);
    }


}
