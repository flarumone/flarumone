<?php
namespace S12g\ImageAttachments\Drivers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Str;

class Upyun implements DriverInterface
{
    const title = 'Upyun';
    
    protected $config;
    protected $http;
    
    public function __construct($config)
    {
        $this->config = $config;
        $this->http = new Client([
            'base_uri' => 'https://v0.api.upyun.com/' . $this->config['bucketName'] . '/',
            'auth' => [$this->config['username'], $this->config['password']]
        ]);
    }
    
    public function saveImage($tmpFile)
    {
        $resp = [];
        $filename = date('Y/m/d/') . Str::quickRandom() . '.jpg';
        try {
            $resp = $this->http->request('PUT', $filename, [
                'header' => [
                    'mkdir' => true
                ],
                'body' => fopen($tmpFile, 'r')
            ]);
        } catch (RequestException $e) {
            $resp = $e->getResponse();
            throw new Exception('HTTP ' . $resp->getStatusCode() . 
                ' ' . $resp->getReasonPhrase() . "\n" .
                $resp->getBody()->getContents()
            );
        }
        return rtrim($this->config['baseUrl'], '/') . '/' . $filename;
    }
    
    public static function getConfigItems()
    {
        return [
            'bucketName' => [
                'hint' => '',
                'title' => 'Bucket Name'
            ],
            'username' => [
                'hint' => 'Username for operator',
                'title' => 'OP Username'
            ],
            'password' => [
                'hint' => 'Password for operator',
                'title' => 'OP Password'
            ],
            'baseUrl' => [
                'hint' => 'e.g: "http://s12g.b0.upaiyun.com/"',
                'title' => 'Base URL'
            ],
        ];
    }
}