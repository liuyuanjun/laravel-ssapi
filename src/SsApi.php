<?php

namespace Liuyuanjun\SsApi;

use Ixudra\Curl\Facades\Curl;

class SsApi
{
    /**
     * @var string
     */
    protected $apiUrl;
    /**
     * @var string
     */
    protected $appKey;
    /**
     * @var string
     */
    protected $appSecret;
    /**
     * 验证请求时间误差
     * @var int
     */
    protected $timeDiff;

    public function __construct(array $config)
    {
        $this->apiUrl = $config['api_url'];
        $this->appKey = $config['api_key'];
        $this->appSecret = $config['app_secret'];
        $this->timeDiff = $config['time_diff'] ?? 300;
    }

    /**
     * 请求接口
     * @param $api
     * @param array $data
     * @param string $method
     * @param array $headers
     * @return array
     */
    public function request($api, $data = [], $method = 'get', $headers = [])
    {
        $this->sign($data);
        // 用法：https://github.com/ixudra/curl
        $response = Curl::to($this->apiUrl . '/' . rtrim($api, '/'))
            ->withData($data)
            ->withHeaders($headers)
            ->asJson()
            ->$method();
        return $response;
    }

    public function get($api, $data = [], $headers = [])
    {
        return $this->request($api, $data, 'get', $headers);
    }

    public function post($api, $data = [], $headers = [])
    {
        return $this->request($api, $data, 'post', $headers);
    }

    public function put($api, $data = [], $headers = [])
    {
        return $this->request($api, $data, 'put', $headers);
    }

    public function patch($api, $data = [], $headers = [])
    {
        return $this->request($api, $data, 'patch', $headers);
    }

    public function delete($api, $data = [], $headers = [])
    {
        return $this->request($api, $data, 'delete', $headers);
    }

    /**
     * 参数签名
     * @param $data
     * @return string
     */
    public function sign(&$data)
    {
        if (isset($data['_sign']))
            unset($data['_sign']);
        $data['app_id'] = $this->appKey;
        $data['_timestamp'] = date('Y-m-d H:i:s');
        $signStr = $this->appSecret;
        ksort($data);
        foreach ($data as $key => $val) {
            $val = strval($val);
            if ($key != '' && strpos($val, '@') !== 0)
                $signStr .= $key . $val;
        }
        $data['_sign'] = strtoupper(md5($signStr . $this->appSecret));
    }

    /**
     * 服务端验证签名
     * @param array $data
     * @param array $config
     * @return bool
     */
    public static function verify($data, $config)
    {
        if (!isset($data['_timestamp']) || !isset($data['_sign']))
            return false; //Arguments missing
        $timestamp = strtotime($data['_timestamp']);
        if ($timestamp < (time() - $config['time_diff']) || $timestamp > (time() + $config['time_diff']))
            return false; //Invalid timestamp
        $originSign = $data['_sign'];
        unset($data['_sign']);
        ksort($data);
        $signStr = $config['app_secret'];
        foreach ($data as $key => $val) {
            $val = strval($val);
            if ($key != '' && strpos($val, '@') !== 0)
                $signStr .= $key . $val;
        }
        $sign = strtoupper(md5($signStr . $config['app_secret']));
        if ($sign !== $originSign)
            return false; //Signature verification failed
        return true;
    }

}