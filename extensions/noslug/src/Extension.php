<?php namespace S12g\NoSlug;

use Flarum\Support\Extension as BaseExtension;
use Illuminate\Events\Dispatcher;

class Extension extends BaseExtension
{
    public function listen(Dispatcher $events)
    {
        $events->subscribe('S12g\NoSlug\Listeners\AddClientAssets');
    }
}
