<?php
/**
 * Author Andy
 * Date 2022-04-07
 * Time: 17:29
 */

namespace Shopifyapi\Facades;


use Illuminate\Support\Facades\Facade;

class Shopifyapi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shopifyapi';
    }
}
