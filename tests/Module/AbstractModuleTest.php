<?php

namespace Piccolo\Module;

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
}