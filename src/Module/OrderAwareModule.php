<?php

namespace Piccolo\Module;

/**
 * A module type that specifies the order it should be loaded in.
 *
 * @package Foundation
 */
interface OrderAwareModule extends Module {
	/**
	 * Return the module class names that should be loaded (configuration and dependency injection) BEFORE this module.
	 *
	 * @return string[]
	 */
	public function getModulesBefore() : array;

	/**
	 * Return the module class names that should be loaded (configuration and dependency injection) AFTER this module.
	 *
	 * @return string[]
	 */
	public function getModulesAfter() : array;
}
