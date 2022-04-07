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
     * 获取产品信息
     * Author: Andy
     * @return mixed
     */
    public function products()
    {
        return $this->curlApi($this->config['api_admin_url']['product']);
    }
}
