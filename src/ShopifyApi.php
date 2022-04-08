<?php
/**
 * Author Andy
 * Date 2022-04-07
 * Time: 17:03
 */

namespace Shopifyapi;

class ShopifyApi extends BaseShopifyApi
{
    /**
     * 调用接口获取信息
     * Author: Andy
     * @return mixed
     */
    public function handler(array $params = [], string $method = 'GET')
    {
        return $this->curlApi($this->config['api_admin_url']['product'], $params, $method);
    }

    /**
     * 下载文件
     * Author: Andy
     * @param string $url
     * @return bool|string
     */
    public function downloadFile(string $url)
    {
        $file = $this->download($url);
        $ext = $this->fileExt($url);
        return $this->saveFile($file, $ext);
    }

    /**
     * 获取文件后缀
     * Author: Andy
     * @param string $url
     * @return mixed|string
     */
    protected function fileExt(string $url)
    {
        $pathInfo = pathinfo($url, PATHINFO_EXTENSION);
        $pathInfo = explode('?', $pathInfo);
        return $pathInfo[0] ?? 'jpg';
    }
}
