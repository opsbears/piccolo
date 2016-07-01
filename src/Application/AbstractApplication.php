<?php

namespace Piccolo\Application;

use Piccolo\Configuration\ConfigurationException;
use Piccolo\DependencyInjection\DependencyInjectionContainer;
use Piccolo\Module\Module;

class AbstractApplication {
	/**
	 * @var DependencyInjectionContainer
	 */
	private $dic;

	/**
	 * @var array
	 */
	private $config;

	public function __construct(DependencyInjectionContainer $dic, array $config) {
		$this->dic    = $dic;
		$this->config = $config;

		$modulesConfig = $this->getConfiguration('modules');
		$modules = [];
		foreach ($modulesConfig as $moduleClass) {
			/**
			 * @var Module $module
			 */
			$module = $this->dic->make($moduleClass);

			$key = $module->getModuleKey();
			if (!isset($this->config[$key])) {
				$this->config[$key] = array();
			}

			$module->loadConfiguration($this->config[$key]);
			$modules[] = $module;
		}
		
		foreach ($modules as $module) {
			$module->configureDependencyInjection($this->dic, $this->config[$module->getModuleKey()]);
		}
	}

	/**
	 * @param string $option
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	protected function getConfiguration($option) {
		$optionElements = \explode('.', $option);

		$configurationOption = &$this->config;
		while (\count($optionElements)) {
			$currentOptionElement = \array_shift($optionElements);
			if (isset($configurationOption[$currentOptionElement])) {
				$configurationOption = &$configurationOption[$currentOptionElement];
			} else {
				throw new ConfigurationException('Missing configuration option: ' . $option);
			}
		}

		return $configurationOption;
	}

	/**
	 * @return DependencyInjectionContainer
	 */
	protected function getDIC() : DependencyInjectionContainer {
		return $this->dic;
	}
}