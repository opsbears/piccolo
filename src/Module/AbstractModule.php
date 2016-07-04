<?php

namespace Piccolo\Module;

use Piccolo\DependencyInjection\DependencyInjectionContainer;

/**
 * Default, empty abstract module.
 */
abstract class AbstractModule implements Module {
	/**
	 * Returns an alpha-numeric key for this module that can be used for storing configuration, etc.
	 *
	 * @return string
	 */
	public function getModuleKey() : string {
		return \strtolower(\str_replace('\\', '_', get_class($this)));
	}

	/**
	 * Returns a list of modules this module requires. These will be automatically loaded as a dependency.
	 *
	 * @return array
	 */
	public function getRequiredModules() : array {
		return [];
	}

	/**
	 * Load any configuration besides the default files this module may need. The $config array passed will contain data
	 * from the default config files that applies to this module.
	 *
	 * @param array $moduleConfig
	 * @param array $globalConfig
	 */
	public function loadConfiguration(array &$moduleConfig, array &$globalConfig) {
	}

	/**
	 * Apply the configuration for the classes in this module to the dependency injection container. The module
	 * SHOULD only configure classes that it owns. However, at this point there is no verification for that. (May be
	 * added later.)
	 *
	 * This function is also responsible for piping the configuration into the dependency injection container, as
	 * required by the module.
	 *
	 * @param DependencyInjectionContainer $dic
	 * @param array                        $moduleConfig
	 * @param array                        $globalConfig
	 */
	public function configureDependencyInjection(DependencyInjectionContainer $dic,
												 array $moduleConfig,
												 array $globalConfig) {
	}
}
