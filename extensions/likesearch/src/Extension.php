<?php namespace S12g\LikeSearch;

use Flarum\Support\Extension as BaseExtension;
use Illuminate\Events\Dispatcher;

class Extension extends BaseExtension
{
    public function listen(Dispatcher $events)
    {
        $this->app->when('Flarum\Core\Discussions\Search\Gambits\FulltextGambit')
        ->needs('Flarum\Core\Discussions\Search\Fulltext\Driver')
        ->give('S12g\LikeSearch\Driver\MySqlFulltextDriver');
    }
}