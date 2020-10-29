<?php

namespace App\Admin\Controllers;

use App\Services\AliyunService;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function AlibabaCloud\Client\json;

class CdnRefresh extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = 'Cdn刷新工具';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        $requestData = $request->only(['ObjectType', 'ObjectPath']);
        if ($requestData['ObjectType'] == 1) {
            $ObjectType = 'File';
        } else {
            $ObjectType = 'Directory';
        }
        $aliyunService = new AliyunService();
        list($status, $result) = $aliyunService->cdnRefresh($requestData['ObjectPath'], $ObjectType);
        //执行刷新
        if ($status) {
            admin_toastr('Refresh succeeded.', 'success');
        } else {
            admin_toastr($result, 'error');
        }
        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->select('ObjectType', '刷新类型')->options([1 => 'File', 2 => 'Directory'])->default(1);
        $this->textarea('ObjectPath', '路径')->rules('required')->help('<span style="color:red;">每行输入一个 Url 请遵守规则：<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;File 类型：https://digitas.yijiuplus.com/1.jpg<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Directory 类型：https://digitas.yijiuplus.com/visa/</span>');

    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'name' => 'John Doe',
            'email' => 'John.Doe@gmail.com',
            'created_at' => now(),
        ];
    }
}
