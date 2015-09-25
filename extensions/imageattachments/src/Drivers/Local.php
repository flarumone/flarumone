<?php
namespace S12g\ImageAttachments\Drivers;

use League\Flysystem\Adapter\Local as LocalFS;
use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;
use Illuminate\Support\Str;

class Local implements DriverInterface
{
    const title = 'Local Filesystem';
    protected $config;
    
    public function __construct($config)
    {
        $this->config = $config;
        $this->config['urlPrefix'] = $this->config['urlPrefix'] ?: '/assets/';
    }
    
    public function saveImage($tmpFile)
    {
        $dir = date('Ym/d');
        $mount = new MountManager([
            'source' => new Filesystem(new LocalFS(pathinfo($tmpFile, PATHINFO_DIRNAME))),
            'target' => new Filesystem(new LocalFS(public_path('assets/uploads'))),
        ]);
        $uploadName = Str::lower(Str::quickRandom()) . '.jpg';
        $mount->move("source://".pathinfo($tmpFile, PATHINFO_BASENAME), "target://$dir/$uploadName");
        return $this->config['urlPrefix'] . 'uploads/' . $dir . '/' . $uploadName;
    }
    
    public static function getConfigItems()
    {
        return [
            'urlPrefix' => [
                'hint' => 'Useful when you have CDNs for images, end with "/". default: "/assets/"',
                'title' => 'URL Prefix'
            ]
        ];
    }
}