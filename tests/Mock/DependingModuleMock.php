<?php

namespace Piccolo\Mock;

use Piccolo\Module\AbstractModule;

class DependingModuleMock extends AbstractModule {
	public function getRequiredModules() : array {
		return [
			EmptyModuleMock::class
		];
	}
}
