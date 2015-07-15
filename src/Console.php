<?php

namespace Naf\Console;

use Naf\App;
use Infiltrate\FilterableStaticTrait;

class Console {

	use FilterableStaticTrait;

	public static $classes = [
		'input' => 'Naf\Console\Input',
		'output' => 'Naf\Console\Output'
	];

	public static function bootstrap() {
		$namespace = 'Naf\\Console';
		$provides = [
			'command' => ['Command', 'Console']
		];
		$params = compact('namespace', 'provides');
		return static::_filter(__FUNCTION__, $params, function($self, $params){
			extract($params);
			App::provide($namespace, $provides);
		});
	}

	public static function dispatch() {
		global $argv;
		$args = array_slice($argv, 1);
		if (empty($args)) {
			$message = 'No command specified';
			throw new \Exception($message);
		}
		$command = str_replace(' ', '', ucwords(str_replace('_', ' ', array_shift($args))));
		$console = App::locate($command . 'Command', 'command');
		$invoke = new $console(static::input(), static::output(), $command);
		$invoke();
	}

	public static function input() {
		$class = static::$classes['input'];
		$params = compact('class');
		return static::_filter(__FUNCTION__, $params, function($self, $params){
			extract($params);
			return new $class();
		});
	}

	public static function output() {
		$class = static::$classes['output'];
		$params = compact('class');
		return static::_filter(__FUNCTION__, $params, function($self, $params){
			extract($params);
			return new $class();
		});
	}
}

?>