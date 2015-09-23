<?php

/**
* @package   s9e\autoimage
* @copyright Copyright (c) 2015 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\Flarum\Autoimage;

use Exception;
use Flarum\Events\FormatterConfigurator;
use Flarum\Support\Extension as BaseExtension;
use Illuminate\Events\Dispatcher;

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
		$events->listen('Flarum\\Events\\FormatterConfigurator', [$this, 'enableAutoimage']);
	}

	public function enableAutoimage(FormatterConfigurator $event)
	{
		try
		{
			$event->configurator->Autoimage;
		}
		catch (Exception $e)
		{
		}
	}
}

return __NAMESPACE__ . '\\Extension';