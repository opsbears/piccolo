<?php

namespace Piccolo\Application;

use Piccolo\Configuration\ConfigurationException;
use Piccolo\DependencyInjection\DependencyInjectionContainer;
use Piccolo\Module\Module;
use Piccolo\Module\ModuleLoader;

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

		$loader = new ModuleLoader();
		$loader->loadModules($dic, $this->config);
	}

	/**
	 * @return DependencyInjectionContainer
	 */
	protected function getDIC() : DependencyInjectionContainer {
		return $this->dic;
	}
}