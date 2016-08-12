<?php

namespace Piccolo\Mock;

use Piccolo\Module\AbstractModule;

class DependingModule2Mock extends AbstractModule {
	public function getModulesBefore() : array {
		return [

		];
	}
}