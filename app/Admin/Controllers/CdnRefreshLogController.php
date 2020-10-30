<?php

namespace App\Admin\Controllers;

use App\Models\CdnRefreshLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Admin;

class CdnRefreshLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'CdnRefreshLog';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CdnRefreshLog());
        $grid->enableHotKeys();
        $grid->disableCreateButton();
        $grid->disableFilter();
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->disableActions();
        $grid->disableColumnSelector();
        $grid->column('Status');
        $grid->column('ObjectType')->display(function($text) {
            return ucfirst($text);
        });;
        $grid->column('ObjectPath');
        $grid->column('TaskId');
        $grid->column('CreationTime');
        $grid->column('Process');
        Admin::script('window.time = window.setTimeout(function(){
//               $(".container-refresh").click();
                $.admin.reload();
        }, 5000);');
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(CdnRefreshLog::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CdnRefreshLog());



        return $form;
    }
}
