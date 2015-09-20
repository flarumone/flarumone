<?php namespace FlarumOne\SMTP;

use Flarum\Support\Extension as BaseExtension;
use Illuminate\Events\Dispatcher;

class Extension extends BaseExtension
{
    public function listen(Dispatcher $events)
    {
        $events->subscribe('FlarumOne\SMTP\Listeners\AddClientAssets');
        $events->subscribe('FlarumOne\SMTP\Listeners\AddApiAttributes');
    }
}
