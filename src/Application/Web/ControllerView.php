<?php


namespace Piccolo\Application\Web;

/**
 * Describes how template engines should work.
 */
interface ControllerView {
	/**
	 * Render the template.
	 *
	 * @param string $controller
	 * @param string $method
	 * @param array  $parameters
	 *
	 * @return string
	 */
	public function render($controller, $method, $parameters);
}
