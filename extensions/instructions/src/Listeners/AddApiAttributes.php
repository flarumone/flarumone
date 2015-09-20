<?php namespace Flarum\Instructions\Listeners;

use Flarum\Events\RegisterLocales;
use Flarum\Events\ApiAttributes;
use Flarum\Events\SerializeConfig;
use Flarum\Events\UnserializeConfig;
use Flarum\Core\Settings\SettingsRepository;
use Flarum\Core\Formatter\Formatter;
use Flarum\Api\Serializers\ForumSerializer;
use Illuminate\Contracts\Events\Dispatcher;

class AddApiAttributes
{
    private $settings;

    public function __construct(SettingsRepository $settings, Formatter $formatter)
    {
        $this->settings = $settings;
        $this->formatter = $formatter;
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(ApiAttributes::class, [$this, 'addInstructions']);
        $events->listen(SerializeConfig::class, [$this, 'parseInstructions']);
        $events->listen(UnserializeConfig::class, [$this, 'unparseInstructions']);
    }

    public function addInstructions(ApiAttributes $event)
    {
        if ($event->serializer instanceof ForumSerializer) {
            $event->attributes['startInstructions'] = $this->renderInstructions($this->settings->get('instructions.start_instructions'));
            $event->attributes['startInstructionsMaxDiscussions'] = (int) $this->settings->get('instructions.start_instructions_max_discussions');

            $event->attributes['replyInstructions'] = $this->renderInstructions($this->settings->get('instructions.reply_instructions'));
            $event->attributes['replyInstructionsMaxPosts'] = (int) $this->settings->get('instructions.reply_instructions_max_posts');
        }
    }

    private function renderInstructions($instructions)
    {
        if ($instructions) {
            return $this->formatter->render($instructions, 'instructions');
        }
    }

    public function parseInstructions(SerializeConfig $event)
    {
        if ($event->key === 'instructions.start_instructions' || $event->key === 'instructions.reply_instructions') {
            $event->value = $this->formatter->parse($event->value, 'instructions');
        }
    }

    public function unparseInstructions(UnserializeConfig $event)
    {
        if (! empty($event->config['instructions.start_instructions'])) {
            $event->config['instructions.start_instructions'] = $this->formatter->unparse($event->config['instructions.start_instructions']);
        }

        if (! empty($event->config['instructions.reply_instructions'])) {
            $event->config['instructions.reply_instructions'] = $this->formatter->unparse($event->config['instructions.reply_instructions']);
        }
    }
}
