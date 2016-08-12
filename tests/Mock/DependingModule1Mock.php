<?php

namespace Piccolo\Mock;

use Piccolo\Module\AbstractModule;

class DependingModule1Mock extends AbstractModule {
	public function getModulesBefore() : array {
		return [
			DependingModule2Mock::class
		];
	}
}