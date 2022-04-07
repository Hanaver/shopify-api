<?php
/**
 * Author Andy
 * Date 2022-04-07
 * Time: 19:11
 */

namespace Shopifyapi\Common;


class Helper
{
    public static function success($data = [], string $msg = 'Success')
    {
        return ['code' => 200, 'msg' => $msg, 'data' => $data];
    }

    public static function error(string $msg = 'Failed')
    {
        return ['code' => 400, 'msg' => $msg];
    }
}
