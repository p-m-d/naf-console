<?php

namespace Naf\Console;

abstract class Command {

	public $input;

	public $output;

	public $name;

	public function __construct($input = null, $output = null, $name = null) {
		$this->input = $input ?: Console::input();
		$this->output = $output ?: Console::output();
		if (!isset($this->name)) {
			if (empty($name)) {
				$classPath = explode('\\', get_class($this));
				$name = preg_replace('/Command$/', '', end($classPath));
			}
			$this->name = $name;
		}
	}

	abstract public function __invoke();
}

?>