<?php

/**
* @package   s9e\mediaembed
* @copyright Copyright (c) 2015 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\Flarum\MediaEmbed;

use Flarum\Events\FormatterConfigurator;
use Flarum\Support\Extension as BaseExtension;
use Illuminate\Events\Dispatcher;
use s9e\TextFormatter\Configurator\Bundles\MediaPack;

class Extension extends BaseExtension
{
	public function listen(Dispatcher $events)
	{
		$events->subscribe(__NAMESPACE__ . '\\Listener');
	}
}

class Listener
{
	public function subscribe(Dispatcher $events)
	{
		$events->listen('Flarum\\Events\\FormatterConfigurator', [$this, 'addMediaSites']);
	}

	public function addMediaSites(FormatterConfigurator $event)
	{
		if (is_callable([$event->configurator->MediaEmbed, 'enableResponsiveEmbeds']))
		{
			$event->configurator->MediaEmbed->enableResponsiveEmbeds();
		}
		(new MediaPack)->configure($event->configurator);
	}
}

return __NAMESPACE__ . '\\Extension';