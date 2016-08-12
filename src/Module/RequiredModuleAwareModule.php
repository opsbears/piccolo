<?php


namespace Piccolo\Module;

/**
 *
 *
 * @package Foundation
 */
interface RequiredModuleAwareModule extends Module {
	/**
	 * Feed this module one of the modules it requires. Modules will be fed one at a time.
	 *
	 * @param Module $module
	 */
	public function addRequiredModule(Module $module);
}