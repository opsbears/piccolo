<?php

namespace Piccolo\Mock;

use Piccolo\Application\AbstractApplication;
use Piccolo\DependencyInjection\DependencyInjectionContainer;

/**
 * Mock application to make testing easier.
 */
class ApplicationMock extends AbstractApplication {
	/**
	 * @return DependencyInjectionContainer
	 */
	public function getDIC() : DependencyInjectionContainer {
		return parent::getDIC();
	}
}
