<?php namespace S12g\ImageAttachments;

use Flarum\Support\Extension as BaseExtension;
use Illuminate\Events\Dispatcher;
use Flarum\Events\RegisterApiRoutes;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

class Extension extends BaseExtension
{
    public function listen(Dispatcher $events)
    {
        // add client assets
        $events->subscribe('S12g\ImageAttachments\Listeners\AddClientAssets');
        // register upload api
        $events->listen(RegisterApiRoutes::class, function (RegisterApiRoutes $event) {
            $event->post(
                '/s12g/image_attachments',
                's12g.imageattachments.upload',
                'S12g\ImageAttachments\UploadAction'
            );
            $event->get(
                '/s12g/image_attachments',
                's12g.imageattachments.upload',
                'S12g\ImageAttachments\UploadAction'
            );
        });
    }
}
