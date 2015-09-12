<?php namespace S12g\ImageAttachments;

use Flarum\Support\Extension as BaseExtension;
use Illuminate\Events\Dispatcher;
use Flarum\Events\RegisterApiRoutes;

class Extension extends BaseExtension
{
    public function listen(Dispatcher $events)
    {
        $events->subscribe('S12g\ImageAttachments\Listeners\AddClientAssets');
        $events->listen(RegisterApiRoutes::class, function (RegisterApiRoutes $event) {
            $event->post(
                '/s12g/image_attachments',
                's12g.imageattachments.upload',
                'S12g\ImageAttachments\UploadAction'
            );
        });
    }
}
