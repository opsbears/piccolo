<?php

namespace Piccolo\Module;

/**
 * @covers Piccolo\Module\AbstractModule
 */
class AbstractModuleTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @covers Piccolo\Module\AbstractModule::getModuleKey
	 */
	public function testGetModuleKey() {
		//setup
		$module = new ModuleMock();
		//act
		$key = $module->getModuleKey();
		//assert
		$this->assertEquals('piccolo_module_modulemock', $key);
	}

	/**
	 * @covers Piccolo\Module\AbstractModule::getRequiredModules
	 */
	public function testGetRequiredModules() {
		//setup
		$module = new ModuleMock();
		//act
		$requiredModules = $module->getRequiredModules();
		//assert
		$this->assertEquals([], $requiredModules);
	}
}
