<?php
namespace Shopifyapi;

use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Shopifyapi\Common\Helper;

/**
 * Author Andy
 * Date 2022-04-07
 * Time: 16:40
 */

abstract class BaseShopifyApi
{
    /**
     * 获取接口配置文件
     * @var array
     */
    protected $config;

    public function __construct(Repository $config)
    {
        $this->config = $config->get('shopifyapi');
    }

    /**
     * 请求接口获取信息
     * Author: Andy
     * @param string $url
     * @param array $params
     * @param string $method
     * @return mixed
     */
    protected function curlApi( string $url, array $params = [], string $method = 'GET')
    {
        $ch = curl_init();
        $header = array('Content-Type: application/json;',sprintf('X-Shopify-Access-Token: %s', $this->config['api_token']));

        curl_setopt($ch, CURLOPT_URL, $this->config['api_url'] . $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        // 是否返回数据，0否，1是
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if($method == 'POST'){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        if($method == 'PUT'){
            curl_setopt($ch, CURLOPT_PUT, 1);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $output = curl_exec($ch);

        $errMsg = curl_errno($ch);

        curl_close($ch);

        if($errMsg){
            return Helper::error($errMsg);
        }
        $output = json_decode($output,true);

        return Helper::success($output);
    }

    /**
     * 下载资源信息
     * Author: Andy
     * @param string $url
     * @return bool|string
     */
    protected function download(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $file = curl_exec($ch);
        curl_close($ch);

        return $file;
    }

    /**
     * 保存文件
     * Author: Andy
     * @param $file
     * @return bool
     */
    protected function saveFile($file, $ext = 'jpg')
    {
        try {
            $path = sprintf('/shopify/%s/%s.%s', date('Y-m-d'), Str::uuid(), $ext);
            Storage::disk('local')->put($path, $file);
        } catch (\Throwable $e) {
            Log::error($e->getMessage() . "\n" . $e->getLine() . "\n" . $e->getTraceAsString());
            return false;
        }
        return true;
    }

}
