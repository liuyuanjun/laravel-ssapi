<?php

namespace Liuyuanjun\SsApi\Facades;


use Illuminate\Support\Facades\Facade;

class SsApi extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'SsApi';
    }

}