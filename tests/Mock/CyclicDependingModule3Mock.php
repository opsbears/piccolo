<?php

namespace Piccolo\Mock;

use Piccolo\Module\AbstractModule;

class CyclicDependingModule3Mock extends AbstractModule {
	public function getModulesBefore() : array {
		return [
			CyclicDependingModule1Mock::class
		];
	}
}