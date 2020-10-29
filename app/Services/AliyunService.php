<?php


namespace App\Services;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Illuminate\Support\Facades\Log;

class AliyunService
{
    protected $alibabCloud;

    /**
     * CdnService constructor.
     * @throws ClientException 初始化配置
     */
    public function __construct()
    {
        AlibabaCloud::accessKeyClient(config('aliyun.AccessKeyID'), config('aliyun.AccessKeySecret'))
            ->regionId(config('aliyun.RegionId'))// replace regionId as you need
            ->asDefaultClient();
        $this->alibabCloud = new AlibabaCloud();
    }

    /**
     * @Desc : CDN 刷新
     * @Authority : COJOY_10
     * @FunctionName : cdnRefresh
     * @Date : 2019/7/11
     * @Time : 16:33
     * @param array $option
     */
    public function cdnRefresh(string $ObjectPath, string $ObjectType)
    {
        //初始化配置
        try {
            $result = $this->alibabCloud::rpc()
                ->product('Cdn')
                ->scheme('https')// https | http
                ->version('2018-05-10')
                ->action('RefreshObjectCaches')
                ->method('POST')
                ->options([
                    'query' => [
                        'ObjectPath' => $ObjectPath, //刷新路径
                        'ObjectType' => $ObjectType //刷新类型
                    ],
                ])
                ->request();
            return [true, $result];
        } catch (ClientException $e) {
            Log::error($e->getErrorMessage() . PHP_EOL);
            return [false, $e->getErrorMessage()];
        } catch (ServerException $e) {
            Log::error($e->getErrorMessage() . PHP_EOL);
            return [false, $e->getErrorMessage()];
        }
    }
}
