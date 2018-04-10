<?php

namespace Liuyuanjun\SsApi;

class SsApiService
{
    /**
     * @var array
     */
    protected $_services;

    /**
     * @param $serverName
     * @return SsApi
     * @throws \Exception
     */
    public function server($serverName)
    {
        if (!isset($this->_services[$serverName])) {
            $config = config('ssapi.' . $serverName);
            if (empty($config))
                throw new \Exception('Api server config is not exist.');
            $this->_services[$serverName] = new SsApi($config);
        }
        return $this->_services[$serverName];
    }

    /**
     * 服务端验证签名
     * @param array $data
     * @param array $config [app_secret, time_diff]
     * @return bool
     */
    public function verify($data, $config)
    {
        return SsApi::verify($data, $config);
    }

}