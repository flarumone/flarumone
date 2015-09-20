<?php namespace FlarumOne\SMTP\Listeners;

use Flarum\Events\ApiAttributes;
use Flarum\Core\Settings\SettingsRepository;
use Flarum\Api\Serializers\ForumSerializer;
use Illuminate\Contracts\Events\Dispatcher;

class AddApiAttributes
{
    private $settings;

    public function __construct(SettingsRepository $settings)
    {
        $this->settings = $settings;
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(ApiAttributes::class, [$this, 'addSMTP']);
    }

    public function addSMTP(ApiAttributes $event)
    {
        if ($event->serializer instanceof ForumSerializer) {
            $event->attributes['mailEncryption'] = $this->settings->get('mail_encryption');
            $event->attributes['mailPort'] = (int) $this->settings->get('mail_port');
            $event->attributes['mailHost'] = $this->settings->get('mail_host');
            $event->attributes['mailUsername'] = $this->settings->get('mail_username');
            $event->attributes['mailPassword'] = $this->settings->get('mail_password');
            $event->attributes['mailFrom'] = $this->settings->get('mail_from');
        }
    }
}
