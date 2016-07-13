<?php


namespace Piccolo\Application;
use Piccolo\Dev\DependencyInjectionContainerMock;
use Piccolo\Mock\ApplicationMock;
use Piccolo\Mock\EmptyModuleMock;

/**
 * @coversDefaultClass Piccolo\Application\AbstractApplication
 */
class ApplicationTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @covers ::__construct
	 * @covers ::getDIC
	 */
	public function testDICPassing() {
		//setup
		$dic = new DependencyInjectionContainerMock();
		//act
		$application = new ApplicationMock($dic, []);
		//assert
		$this->assertEquals($dic, $application->getDIC());
	}

	/**
	 * @covers ::__construct
	 */
	public function testModuleLoading() {
		//setup
		$dic = new DependencyInjectionContainerMock();
		$module = new EmptyModuleMock();
		$globalConfiguration = [
			'modules' => [
				EmptyModuleMock::class,
			],
		];
		//act
		new ApplicationMock($dic, $globalConfiguration);
		//assert
		$this->assertEquals([], $dic->getAliases());
		$this->assertEquals([$module], $dic->getShared());

	}
}