<?php

namespace Piccolo\Module;

use Piccolo\Configuration\ConfigurationException;
use Piccolo\DependencyInjection\DependencyInjectionContainer;

/**
 * The module loader is responsible for loading all modules, including dependencies, in order.
 *
 * @internal
 * @package Foundation
 */
class ModuleLoader {
	/**
	 * Load all configured modules from the 'modules' configuration key. It calls the modules in this order:
	 *
	 * 1. query the required modules and load them if needed.
	 * 2. call loadConfiguration to load the configuration
	 * 3. call configureDependencyInjection to set up the dependency injection container.
	 *
	 * @param DependencyInjectionContainer $dic
	 * @param array                        $config
	 *
	 * @return void
	 */
	public function loadModules(DependencyInjectionContainer $dic, array &$config) {
		$moduleList = (isset($config['modules']) ? $config['modules'] : []);

		/**
		 * @var Module[] $modules
		 */
		$modules = [];

		foreach ($moduleList as $moduleClass) {
			$this->loadModule($moduleClass, $modules, $moduleList, $dic);
		}

		$this->processModules($dic, $modules, $config);
	}

	/**
	 * Process modules after initial loading.
	 *
	 * @param DependencyInjectionContainer $dic
	 * @param array                        $modules
	 * @param array                        $config
	 */
	private function processModules(DependencyInjectionContainer $dic, array $modules, array &$config) {
		/** @noinspection PhpInternalEntityUsedInspection */
		$dependencyGraph = new ModuleDependencyGraph();
		$dependencyGraph->addModules($modules);
		$modules = $dependencyGraph->getSortedModuleList();

		foreach ($modules as $module) {
			$this->loadModuleConfiguration($module, $config);
		}

		foreach ($modules as $module) {
			$module->configureDependencyInjection($dic, $config[$module->getModuleKey()], $config);
		}
	}

	/**
	 * Load a module by class name.
	 *
	 * @param string                       $moduleClass The module class to load.
	 * @param Module[]                     $modules     The list of already loaded modules.
	 * @param array                        $moduleList  The complete module list.
	 * @param DependencyInjectionContainer $dic         The dependency injection container to use for the module.
	 *
	 * @return void
	 *
	 * @throws ConfigurationException
	 */
	private function loadModule(
		$moduleClass,
		array &$modules,
		array $moduleList,
		DependencyInjectionContainer $dic) {
		/**
		 * @var Module $module
		 */
		$module = $dic->make($moduleClass);

		if (!$module instanceof Module) {
			throw new ConfigurationException(get_class($module) .
				' was configured as a module, but doesn\'t implement ' . Module::class);
		}

		if (!\in_array($module, $modules)) {
			$dic->share($module);

			$this->loadRequiredModules($module, $modules, $moduleList, $dic);

			$modules[] = $module;
		}
	}

	/**
	 * Load the modules a certain module requires.
	 *
	 * @param Module                       $module
	 * @param Module[]                     $modules
	 * @param array                        $moduleList
	 * @param DependencyInjectionContainer $dic
	 */
	private function loadRequiredModules(
		Module $module,
		&$modules,
		array $moduleList,
		DependencyInjectionContainer $dic) {
		foreach ($module->getRequiredModules() as $requiredModule) {
			if (!\in_array($requiredModule, $moduleList)) {
				$this->loadModule($requiredModule, $modules, $moduleList, $dic);
				if ($module instanceof RequiredModuleAwareModule) {
					$module->addRequiredModule($dic->make($requiredModule));
				}
			}
		}
	}

	/**
	 * Load the configuration for a specific module.
	 *
	 * @param Module $module
	 * @param array  $config
	 *
	 * @return void
	 */
	private function loadModuleConfiguration(Module $module, array &$config) {
		$key = $module->getModuleKey();
		if (!isset($config[$key])) {
			$config[$key] = array();
		}
		$module->loadConfiguration($config[$key], $config);
	}
}
