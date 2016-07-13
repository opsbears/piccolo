<?php

namespace Piccolo\Module;

use Piccolo\Dev\DependencyInjectionContainerMock;
use Piccolo\Mock\EmptyModuleMock;

/**
 * @coversDefaultClass Piccolo\Module\ModuleLoader
 */
class ModuleLoaderTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @covers Piccolo\Module\ModuleLoader
	 */
	public function testEmpty() {
		//setup
		$moduleLoader = new ModuleLoader();
		$dic = new DependencyInjectionContainerMock();
		$config = [];
		//act
		$moduleLoader->loadModules($dic, $config);
		//assert
		$this->assertEquals([], $config);
		$this->assertEquals([], $dic->getAliases());
		$this->assertEquals([], $dic->getShared());
	}

	/**
	 * @covers Piccolo\Module\ModuleLoader
	 */
	public function testWithOneMock() {
		//setup
		$moduleLoader = new ModuleLoader();
		$dic = new DependencyInjectionContainerMock();
		$config = [
			'modules' => [
				EmptyModuleMock::class,
			],
		];
		$mockModule = new EmptyModuleMock();
		//act
		$moduleLoader->loadModules($dic, $config);
		//assert
		$this->assertEquals([
			'modules' => [
				EmptyModuleMock::class,
			],
			$mockModule->getModuleKey() => [],
		], $config);
		$this->assertEquals([], $dic->getAliases());
		$this->assertEquals([$mockModule], $dic->getShared());
	}
}