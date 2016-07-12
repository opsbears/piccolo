<?php

namespace Piccolo\Module;

use Piccolo\Mock\DependencyInjectionContainerMock;
use Piccolo\Mock\EmptyModuleMock;

/**
 * @coversDefaultClass Piccolo\Module\AbstractModule
 */
class AbstractModuleTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @covers ::getModuleKey
	 */
	public function testGetModuleKey() {
		//setup
		$module = new EmptyModuleMock();
		//act
		$key = $module->getModuleKey();
		//assert
		$this->assertEquals('piccolo_mock_emptymodulemock', $key);
	}

	/**
	 * @covers ::getRequiredModules
	 */
	public function testGetRequiredModules() {
		//setup
		$module = new EmptyModuleMock();
		//act
		$requiredModules = $module->getRequiredModules();
		//assert
		$this->assertEquals([], $requiredModules);
	}

	/**
	 * @covers ::loadConfiguration
	 */
	public function testLoadConfiguration() {
		//setup
		$module = new EmptyModuleMock();
		$globalConfiguration = [];
		$globalConfiguration[$module->getModuleKey()] = [];
		$moduleConfig = &$globalConfiguration[$module->getModuleKey()];
		//act
		$module->loadConfiguration($moduleConfig, $globalConfiguration);
		//assert
		$this->assertEquals([$module->getModuleKey() => []], $globalConfiguration);
	}

	/**
	 * @covers ::configureDependencyInjection
	 */
	public function testConfigureDependencyInjection() {
		//setup
		$module = new EmptyModuleMock();
		$dic = new DependencyInjectionContainerMock();
		$globalConfiguration = [];
		$globalConfiguration[$module->getModuleKey()] = [];
		$moduleConfig = &$globalConfiguration[$module->getModuleKey()];
		//act
		$module->configureDependencyInjection($dic, $moduleConfig, $globalConfiguration);
		//assert
		$this->assertEquals([$module->getModuleKey() => []], $globalConfiguration);
		$this->assertEquals([], $dic->getAliases());
		$this->assertEquals([], $dic->getShared());
	}
}
