<?php

namespace Piccolo\Mock;

use Piccolo\Module\AbstractModule;

class CyclicDependingModule1Mock extends AbstractModule {
	public function getModulesBefore() : array {
		return [
			CyclicDependingModule2Mock::class
		];
	}
}