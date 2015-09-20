<?php namespace FlarumOne\SMTP\Listeners;

use Flarum\Events\RegisterLocales;
use Flarum\Events\BuildClientView;
use Illuminate\Contracts\Events\Dispatcher;

class AddClientAssets
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(RegisterLocales::class, [$this, 'addLocale']);
        $events->listen(BuildClientView::class, [$this, 'addAssets']);
    }

    public function addLocale(RegisterLocales $event)
    {
        $event->addTranslations('en', __DIR__.'/../../locale/en.yml');
    }

    public function addAssets(BuildClientView $event)
    {
        $event->adminAssets([
            __DIR__.'/../../js/admin/dist/extension.js',
            __DIR__.'/../../less/admin/extension.less'
        ]);

        $event->adminBootstrapper('smtp/main');

        $event->adminTranslations([
            // 'smtp.hello_world'
        ]);
    }
}
