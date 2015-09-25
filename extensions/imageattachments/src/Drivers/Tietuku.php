<?php
namespace S12g\ImageAttachments\Drivers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Tietuku implements DriverInterface
{
    const title = 'tietuku.com';
    
    protected $config;
    protected $http;
    
    public function __construct($config)
    {
        $this->config = $config;
        $this->http = new Client([
            'base_uri' => 'http://up.tietuku.com/'
        ]);
    }
    
    public function saveImage($tmpFile)
    {
        // calculate upload token
        $param = [
            'deadline' => time() + 120,
            'aid' => $this->config['albumId'],
            'from' => 'file'
        ];
        $param = strtr(base64_encode(json_encode($param)), '+/', '-_');
        $sign = base64_encode(hash_hmac('sha1', $param, $this->config['secretKey'], true));
        $sign = strtr($sign, '+/', '-_');
        $token = $this->config['accessKey'] . ':' . $sign . ':' . $param;
        // post file
        $resp = [];
        try {
            $resp = $this->http->request('POST', '/', [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen($tmpFile, 'r')
                    ],
                    [
                        'name' => 'Token',
                        'contents' => $token
                    ]
                ]
            ]);
        } catch (RequestException $e) {
            $resp = $e->getResponse();
            throw new Exception('HTTP ' . $resp->getStatusCode() . 
                ' ' . $resp->getReasonPhrase() . "\n" .
                $resp->getBody()->getContents()
            );
        }
        $body = $resp->getBody()->getContents();
        $body = json_decode($body, true);
        return $body['linkurl'];
    }
    
    public static function getConfigItems()
    {
        return [
            'accessKey' => [
                'hint' => 'Get it at http://open.tietuku.com/manager',
                'title' => 'AccessKey'
            ],
            'secretKey' => [
                'hint' => '',
                'title' => 'SecretKey'
            ],
            'albumId' => [
                'hint' => 'Get it at http://open.tietuku.com/album',
                'title' => 'Album ID'
            ]
        ];
    }
}