<?php
namespace S12g\ImageAttachments\Drivers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Imgur implements DriverInterface
{
    const title = 'Imgur';
    
    protected $config;
    protected $http;
    
    public function __construct($config)
    {
        $this->config = $config;
        $this->http = new Client([
            'base_uri' => 'https://api.imgur.com/3/',
            'headers' => [
                'Authorization' => 'Client-ID '.$this->config['clientId']
            ]
        ]);
    }
    
    public function saveImage($tmpFile)
    {
        // post file
        $resp = [];
        try {
            $resp = $this->http->request('POST', 'image', [
                'multipart' => [
                    [
                        'name' => 'image',
                        'contents' => fopen($tmpFile, 'r')
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
        $link = $body['data']['link'];
        if ($this->config['https'] == 'yes') {
            $link = str_ireplace('http://', 'https://', $link);
        }
        return $link;
    }
    
    public static function getConfigItems()
    {
        return [
            'clientId' => [
                'hint' => 'Get it at https://api.imgur.com/oauth2/addclient',
                'title' => 'Cliet ID'
            ],
            'https' => [
                'hint' => '"yes" for https, "no" or blank for http',
                'title' => 'Enable https'
            ],
        ];
    }
}