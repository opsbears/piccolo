<?php

declare(strict_types=1);

namespace Piccolo\Module;

use Piccolo\Configuration\ConfigurationOptionGroup;
use Piccolo\DependencyInjection\DependencyInjectionContainer;

/**
 * Code in Piccolo is organized into modules. (Much like Symfonys bundles.) A module class is needed to declare some
 * basic functionality, like configuration, for each module.
 *
 * The simplest way to write a module is to extend the `AbstractModule` class which declares the basic functionality.
 * You can then simply implement the `configureDependencyInjection()` function to wire up your classes to their
 * interfaces and send the configuration to the classes that need it.
 *
 * See HACKING.md in this repository for more information.
 * 
 * @package Foundation
 */
interface Module {
    /**
     * Returns a list of configuration options this module accepts.
     *
     * @return null|ConfigurationOptionGroup
     */
    public function getConfigurationOptions() : ?ConfigurationOptionGroup;

    /**
     * Apply the configuration for the classes in this module to the dependency injection container. The module
     * SHOULD only configure classes that it owns. However, at this point there is no verification for that. (May be
     * added later.)
     *
     * @param DependencyInjectionContainer $dic
     * @param ModuleConfiguration          $configuration
     * @return void
     */
    public function configureDependencyInjection(
        DependencyInjectionContainer $dic,
        ?ModuleConfiguration $configuration
    ) : void;
}
