<?php

namespace Piccolo\Module;

use Piccolo\DependencyInjection\DependencyInjectionContainer;

/**
 * Code in Piccolo is organized into modules. (Much like Symfonys bundles.) A module class is needed to declare some
 * basic functionality, like configuration, for each module.
 *
 * The simplest way to write a module is to extend the `AbstractModule` class which declares the basic functionality.
 * You can then simply implement the `configureDependencyInjection()` function to wire up your classes to their
 * interfaces and send the configuration to the classes that need it.
 *
 * See HACKING.md in this repository for more information.
 * 
 * @package Foundation
 */
interface Module {
	/**
	 * Returns an alpha-numeric key for this module that can be used for storing configuration, etc.
	 *
	 * @return string
	 */
	public function getModuleKey() : string;

	/**
	 * Returns a list of modules this module requires. These will be automatically loaded as a dependency.
	 *
	 * @return array
	 */
	public function getRequiredModules() : array;

	/**
	 * Load any configuration besides the default files this module may need. The $config array passed will contain data
	 * from the default config files that applies to this module.
	 *
	 * @param array $moduleConfig
	 * @param array $globalConfig
	 *
	 * @return void
	 */
	public function loadConfiguration(array &$moduleConfig, array &$globalConfig);

	/**
	 * Apply the configuration for the classes in this module to the dependency injection container. The module
	 * SHOULD only configure classes that it owns. However, at this point there is no verification for that. (May be
	 * added later.)
	 *
	 * @param DependencyInjectionContainer $dic
	 * @param array                        $moduleConfig
	 * @param array                        $globalConfig
	 *
	 * @return void
	 */
	public function configureDependencyInjection(DependencyInjectionContainer $dic,
												 array $moduleConfig,
												 array $globalConfig);
}
