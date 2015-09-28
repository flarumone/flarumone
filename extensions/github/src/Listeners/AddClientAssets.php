<?php namespace Flarum\Github\Listeners;

use Flarum\Events\RegisterLocales;
use Flarum\Events\BuildClientView;
use Flarum\Events\RegisterForumRoutes;
use Illuminate\Contracts\Events\Dispatcher;

class AddClientAssets
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(RegisterLocales::class, [$this, 'addLocale']);
        $events->listen(BuildClientView::class, [$this, 'addAssets']);
        $events->listen(RegisterForumRoutes::class, [$this, 'addLoginRoute']);
    }

    public function addLocale(RegisterLocales $event)
    {
        $event->addTranslations('en', __DIR__.'/../../locale/en.yml');
    }

    public function addAssets(BuildClientView $event)
    {
        $event->forumAssets([
            __DIR__.'/../../js/forum/dist/extension.js',
            __DIR__.'/../../less/forum/extension.less'
        ]);

        $event->forumBootstrapper('github/main');

        $event->forumTranslations([
            // 'github.hello_world'
        ]);

        $event->adminAssets([
            __DIR__.'/../../js/admin/dist/extension.js'
        ]);

        $event->adminBootstrapper('github/main');

        $event->adminTranslations([
            // 'github.hello_world'
        ]);
    }

    public function addLoginRoute(RegisterForumRoutes $event)
    {
        $event->get('/login/github', 'github.login', 'Flarum\Github\LoginAction');
    }
}
