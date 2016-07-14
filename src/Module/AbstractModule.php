<?php

namespace Piccolo\Module;

use Piccolo\DependencyInjection\DependencyInjectionContainer;

/**
 * Default, empty abstract module. The simplest way to write a module is to extend this class which declares the basic
 * functionality. You can then simply implement the `configureDependencyInjection()` function to wire up your classes
 * to their interfaces and send the configuration to the classes that need it.
 *
 * See HACKING.md in this repository for more information.
 * 
 * @package Foundation
 */
abstract class AbstractModule implements Module {
	/**
	 * {@inheritdoc}
	 */
	public function getModuleKey() : string {
		return \strtolower(\str_replace('\\', '_', \get_class($this)));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRequiredModules() : array {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function loadConfiguration(array &$moduleConfig, array &$globalConfig) {
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureDependencyInjection(DependencyInjectionContainer $dic,
												 array $moduleConfig,
												 array $globalConfig) {
	}
}
