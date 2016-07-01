<?php

namespace Piccolo\Module;

use Piccolo\DependencyInjection\DependencyInjectionContainer;

/**
 * Code in Piccolo is organized into modules. (Much like Symfonys bundles.) A module class is needed to declare some
 * basic functionality, like configuration, for each module.
 */
interface Module {
	/**
	 * Returns an alpha-numeric key for this module that can be used for storing configuration, etc.
	 *
	 * @return string
	 */
	public function getModuleKey() : string;

	/**
	 * Load any configuration besides the default files this module may need. The $config array passed will contain data
	 * from the default config files that applies to this module.
	 *
	 * @param array $config
	 */
	public function loadConfiguration(array &$config) : void;

	/**
	 * Apply the configuration for the classes in this module to the dependency injection container. The module
	 * SHOULD only configure classes that it owns. However, at this point there is no verification for that. (May be
	 * added later.)
	 *
	 * @param DependencyInjectionContainer $dic
	 * @param array                        $config
	 */
	public function configureDependencyInjection(DependencyInjectionContainer $dic, array $config) : void;
}
