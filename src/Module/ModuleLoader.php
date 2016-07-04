<?php

namespace Piccolo\Module;

use Piccolo\Configuration\ConfigurationException;
use Piccolo\DependencyInjection\DependencyInjectionContainer;

/**
 * The module loader is responsible for loading all modules, including dependencies, in order.
 */
class ModuleLoader {
	public function loadModules(DependencyInjectionContainer $dic, array &$config) {
		$modulesConfig = (isset($config['modules'])?$config['modules']:[]);

		/**
		 * @var Module[] $modules
		 */
		$modules = [];

		$loadModule = function($moduleClass) use (&$loadModule, &$modules, &$modulesConfig, $dic) {
			/**
			 * @var Module $module
			 */
			$module = $dic->make($moduleClass);

			if (!$module instanceof Module) {
				throw new ConfigurationException(get_class($module) .
					' was configured as a module, but doesn\'t implement ' . Module::class);
			}

			if (!in_array($module, $modules)) {
				$dic->share($module);

				foreach ($module->getRequiredModules() as $requiredModule) {
					if (!in_array($requiredModule, $modulesConfig)) {
						$loadModule($requiredModule);
					}
				}

				$modules[] = $module;
			}
		};

		foreach ($modulesConfig as $moduleClass) {
			$loadModule($moduleClass);
		}

		foreach ($modules as $module) {
			$key = $module->getModuleKey();
			if (!isset($config[$key])) {
				$config[$key] = array();
			}
			$module->loadConfiguration($config[$key], $config);
		}

		foreach ($modules as $module) {
			$module->configureDependencyInjection($dic, $config[$module->getModuleKey()], $config);
		}
	}
}
