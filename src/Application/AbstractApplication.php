<?php

declare(strict_types=1);

namespace Piccolo\Application;

use Piccolo\DependencyInjection\DependencyInjectionContainer;
use Piccolo\Module\ModuleLoader;

/**
 * A class that is intended to simplify the construction of an application. While you don't have to use it, it is
 * recommended.
 *
 * The `AbstractApplication` class takes the configuration in an array and loads the modules from it. The
 * `ModuleLoader` class uses this configuration to call each module with their respective configuration and the
 * dependency injection container that was passed to it in order to configure the modules appropriately.
 * 
 * Example:
 * 
 * ```
 * class MyApplication extends AbstractApplication {
 *     public function execute() {
 *         $dic = $this->getDIC();
 *         // Do something here
 *     }
 * }
 * ```
 * 
 * @package Foundation
 */
class AbstractApplication {
	/**
	 * @var DependencyInjectionContainer
	 */
	private $dic;

    /**
     * @var array<string, string>
     */
    private $config;

    /**
     * @var array<Module>
     */
    private $modules = [];

    /**
	 * Initialize the application, load the modules.
	 *
	 * @param DependencyInjectionContainer $dic
	 * @param array<string, string>        $config
	 */
	public function __construct(DependencyInjectionContainer $dic, array $config) {
		$this->dic = $dic;
		$this->config = $config;
	}

    /**
     * Load modules and let them configure the dependency injection container. This can only be done once.
     *
     * @param array<string> $moduleClasses
     *
     * @throws ModulesAlreadyLoadedException
     */
	protected function loadModules(array $moduleClasses) {
	    if (!empty($this->modules)) {
	        throw new ModulesAlreadyLoadedException();
        }
        /** @noinspection PhpInternalEntityUsedInspection */
        $loader = new ModuleLoader();
        $this->modules = $loader->loadModules($moduleClasses, $this->dic, $this->config);
    }

    /**
     * Return a list of loaded modules.
     *
     * @return array<Module>
     */
    protected function getModules() {
	    return $this->modules;
    }

	/**
	 * Return the dependency injection container for internal use. Great care must be taken that the dependency
	 * injection container is not turned into a Service Locator by passing it into the container itself.
	 *
	 * @return DependencyInjectionContainer
	 */
	protected function getDIC() : DependencyInjectionContainer {
		return $this->dic;
	}
}
