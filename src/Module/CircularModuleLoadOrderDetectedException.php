<?php

namespace Piccolo\Module;

class CircularModuleLoadOrderDetectedException extends \Exception {
	/**
	 * @var string
	 */
	private $dotGraph;

	/**
	 * @param string $dotGraph
	 */
	public function __construct(string $dotGraph) {
		parent::__construct('Cannot resolve correct module loading order, circular dependency detected: ' .
			\preg_replace('/ [ ]+/', ' ', \str_replace(PHP_EOL, ' ', $dotGraph)));
		$this->dotGraph = $dotGraph;
	}

	/**
	 * Returns a GraphViz DOT graph to represent the circular dependency found. A PNG image can be generated using
	 * this command: `dot -Tpng input.dot output.png`
	 *
	 * @see http://www.graphviz.org/
	 *
	 * @return string
	 */
	public function getDotGraph(): string {
		return $this->dotGraph;
	}
}
