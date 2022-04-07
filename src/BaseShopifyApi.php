<?php
namespace Shopifyapi;

use Illuminate\Config\Repository;
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
        // 是否直接显示在控制台
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);

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

}
