<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Admin;
use Encore\Admin\Layout\Content;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        Admin::script('window.clearTimeout(window.time)');
        return $content
            ->title('Dashboard')
            ->description('Description...')
            ->row(view('admin.dashboard'));
    }
}
