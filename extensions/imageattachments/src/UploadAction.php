<?php namespace S12g\ImageAttachments;

use Flarum\Api\Actions\Action;
use Flarum\Api\Request;
use Illuminate\Contracts\Bus\Dispatcher;
use Zend\Diactoros\Response\JsonResponse;
use Flarum\Core\Settings\SettingsRepository;
use Tobscure\JsonApi\Document;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\MountManager;
use Illuminate\Support\Str;
use Flarum\Core;
use Exception;

class UploadAction implements Action {
    /**
     * @var Dispatcher $bus
     */
    protected $bus;
    
    /**
     * @var SettingsRepository $settings
     */
    protected $settings;
    
    /**
     * Upload image attachments
     * @param Dispatcher $bus
     * @param FilesystemInterface $uploadDir This will set in extention bootstrap class
     */
    public function __construct(Dispatcher $bus, SettingsRepository $settings)
    {
        $this->bus = $bus;
        $this->settings = $settings;
    }
    
    /**
     * Handle upload requests
     * @param Request $request
     * @todo Add upload event
     * @todo Add upload permissions
     */
    public function handle(Request $request)
    {
        $images = $request->http->getUploadedFiles()['images'];
        $results = [];
        // get driver name
        $driver_list = [
            'local' => '\S12g\ImageAttachments\Drivers\Local',
            'qiniu' => '\S12g\ImageAttachments\Drivers\Qiniu'
        ];
        // return driver name if in admin and no images
        if ($request->actor->isAdmin() && !is_array($images)) {
            foreach ($driver_list as $name => $driver) {
                $results[$name] = [
                    'config' => $driver::getConfigItems() ?: null,
                    'title' => $driver::title
                ];
            }
            return new JsonResponse($results);
        }
        $driver_name = $this->settings->get('imageattachments.driver') ?: 'local';
        $driver = $driver_list[$driver_name];
        if (!$driver) {
            $driver_name = 'local';
            $driver = $driver_list['local'];
        }
        // get config
        $config = $this->settings->get('imageattachments.'.$driver_name.'.config');
        $config = json_decode($config, true) ?: [];
        // get driver
        $fs = new $driver($config);
        // save images
        try {
            foreach($images as $image_key => $image) {
                $tmpFile = tempnam(sys_get_temp_dir(), 'image');
                $image->moveTo($tmpFile);
                $results['img_'.$image_key] = $fs->saveImage($tmpFile);
                @unlink($tmpFile);
            }
        } catch (Exception $e) {
            throw $e;
        }
        return new JsonResponse($results);
    }
}