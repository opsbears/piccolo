<?php

namespace Piccolo\Module;

use Piccolo\Mock\CyclicDependingModule1Mock;
use Piccolo\Mock\CyclicDependingModule2Mock;
use Piccolo\Mock\CyclicDependingModule3Mock;
use Piccolo\Mock\DependingModule1Mock;
use Piccolo\Mock\DependingModule2Mock;
use Piccolo\Mock\EmptyModuleMock;
use Piccolo\Mock\EmptyModuleMock2;

class ModuleDependencyGraphTest extends \PHPUnit_Framework_TestCase{
	public function testNoModules() {
		//setup
		/** @noinspection PhpInternalEntityUsedInspection */
		$graph = new ModuleDependencyGraph();
		//act
		$moduleList = $graph->getSortedModuleList();
		//assert
		$this->assertEquals([], $moduleList);
	}

	public function testOneModule() {
		//setup
		/** @noinspection PhpInternalEntityUsedInspection */
		$graph = new ModuleDependencyGraph();
		$module  = new EmptyModuleMock();
		//act
		$graph->addModule($module);
		$moduleList = $graph->getSortedModuleList();
		//assert
		$this->assertEquals([$module], $moduleList);
	}

	public function testTwoEmptyModules() {
		//setup
		/** @noinspection PhpInternalEntityUsedInspection */
		$graph   = new ModuleDependencyGraph();
		$module1 = new EmptyModuleMock();
		$module2 = new EmptyModuleMock2();
		//act
		$graph->addModule($module1);
		$graph->addModule($module2);
		$moduleList = $graph->getSortedModuleList();
		//assert
		$this->assertEquals([$module1, $module2], $moduleList);
	}

	public function testTwoEmptyModulesDepending() {
		//setup
		/** @noinspection PhpInternalEntityUsedInspection */
		$graph   = new ModuleDependencyGraph();
		$module1 = new DependingModule1Mock();
		$module2 = new DependingModule2Mock();
		//act
		$graph->addModule($module1);
		$graph->addModule($module2);
		$moduleList = $graph->getSortedModuleList();
		//assert
		$this->assertEquals([$module2, $module1], $moduleList);
	}

	public function testTwoEmptyModulesDependingReverse() {
		//setup
		/** @noinspection PhpInternalEntityUsedInspection */
		$graph   = new ModuleDependencyGraph();
		$module1 = new DependingModule1Mock();
		$module2 = new DependingModule2Mock();
		//act
		$graph->addModule($module2);
		$graph->addModule($module1);
		$moduleList = $graph->getSortedModuleList();
		//assert
		$this->assertEquals([$module2, $module1], $moduleList);
	}

	public function testCycleDetection() {
		//setup
		/** @noinspection PhpInternalEntityUsedInspection */
		$graph   = new ModuleDependencyGraph();
		$module1 = new CyclicDependingModule1Mock();
		$module2 = new CyclicDependingModule2Mock();
		$module3 = new CyclicDependingModule3Mock();
		$graph->addModule($module3);
		$graph->addModule($module2);
		$graph->addModule($module1);
		//act
		try {
			$graph->getSortedModuleList();
			$this->fail();
		} catch (CircularModuleLoadOrderDetectedException $e) {
			//pass
		}
	}
}
