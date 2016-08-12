<?php

namespace Piccolo\Mock;

use Piccolo\Module\AbstractModule;

class CyclicDependingModule2Mock extends AbstractModule {
	public function getModulesBefore() : array {
		return [
			CyclicDependingModule3Mock::class
		];
	}
}