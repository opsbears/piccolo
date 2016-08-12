<?php

namespace Piccolo\Module;

use Piccolo\Configuration\ConfigurationException;
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
abstract class AbstractModule implements Module, OrderAwareModule, RequiredModuleAwareModule {
	/**
	 * @var Module[]
	 */
	private $modules = [];

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
		return \array_merge($this->getModulesBefore(), $this->getModulesAfter());
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

	/**
	 * {@inheritdoc}
	 */
	public function getModulesBefore() : array {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getModulesAfter() : array {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function addRequiredModule(Module $module) {
		$this->modules[\get_class($module)] = $module;
	}

	/**
	 * Returns a module that has been set as required. This is only available after the constructor has finished.
	 *
	 * @param string $className
	 *
	 * @return Module
	 *
	 * @throws ConfigurationException
	 */
	protected function getRequiredModule(string $className) {
		if (\array_key_exists($className, $this->modules)) {
			return $this->modules[$className];
		} else {
			throw new ConfigurationException(__CLASS__ . ' tried to request module ' . $className .
				', but it was not listed as a dependency or has not yet added.');
		}
	}
}
