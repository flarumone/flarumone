<?php namespace S12g\ImageAttachments;

use Flarum\Api\Actions\JsonApiAction;
use Flarum\Api\Request;
use Illuminate\Contracts\Bus\Dispatcher;
use Zend\Diactoros\Response\JsonResponse;
use Tobscure\JsonApi\Document;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\MountManager;
use Illuminate\Support\Str;
use Flarum\Core;

class UploadAction extends JsonApiAction {
    protected $bus;
    
    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }
    
    protected function respond(Request $request)
    {
        $images = $request->http->getUploadedFiles()['images'];
        $results = [];
        foreach($images as $image_key => $image) {
            $tmpFile = tempnam(sys_get_temp_dir(), 'image');
            $image->moveTo($tmpFile);
            $urlGenerator = app('Flarum\Http\UrlGeneratorInterface');
            $dir = 'uploads/'.date('Ym/d');
            $path = './assets/'.$dir;
            $mount = new MountManager([
                'source' => new Filesystem(new Local(pathinfo($tmpFile, PATHINFO_DIRNAME))),
                'target' => new Filesystem(new Local($path)),
            ]);
            $uploadName = Str::lower(Str::quickRandom()) . '.jpg';
            $mount->move("source://".pathinfo($tmpFile, PATHINFO_BASENAME), "target://$uploadName");
            $results['img_'.$image_key] = Core::url().'/assets/'.$dir.'/'.$uploadName;
        }
        return new JsonResponse($results);
    }
}