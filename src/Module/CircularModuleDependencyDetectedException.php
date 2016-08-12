<?php

namespace Piccolo\Module;

class CircularModuleDependencyDetectedException extends \Exception {
	/**
	 * CircularModuleDependencyDetectedException constructor.
	 *
	 * @param string $dotGraph
	 */
	public function __construct(string $dotGraph) {
		parent::__construct('Circular module dependency detected. See the following DOT graph: ' .
			\str_replace(PHP_EOL, ' ', $dotGraph));
	}
}