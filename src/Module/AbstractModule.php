<?php

declare(strict_types=1);

namespace Piccolo\Module;

use Piccolo\Configuration\ConfigurationOptionGroup;
use Piccolo\DependencyInjection\DependencyInjectionContainer;

/**
 * Default, empty abstract module. The simplest way to write a module is to extend this class which declares the basic
 * functionality. You can then simply implement the `configureDependencyInjection()` function to wire up your classes
 * to their interfaces and send the configuration to the classes that need it.
 *
 * See HACKING.md in this repository for more information.
 * 
 * @package Foundation
 */
abstract class AbstractModule implements Module {
    /**
     * {@inheritdoc}
     */
    public function getConfigurationOptions() : ?ConfigurationOptionGroup {
        return null;
    }

	/**
	 * {@inheritdoc}
	 */
    public function configureDependencyInjection(
        DependencyInjectionContainer $dic,
        ?ModuleConfiguration $configuration
    ) : void {
	}
}
