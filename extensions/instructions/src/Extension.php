<?php namespace Flarum\Instructions;

use Flarum\Support\Extension as BaseExtension;
use Illuminate\Events\Dispatcher;

class Extension extends BaseExtension
{
    public function listen(Dispatcher $events)
    {
        $events->subscribe('Flarum\Instructions\Listeners\AddClientAssets');
        $events->subscribe('Flarum\Instructions\Listeners\AddApiAttributes');
    }
}
