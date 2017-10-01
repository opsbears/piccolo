<?php

declare(strict_types=1);

namespace Piccolo\Module;

use Piccolo\DependencyInjection\DependencyInjectionContainer;

/**
 * The module loader is responsible for loading all modules, including dependencies, in order.
 *
 * @internal
 * @package Foundation
 */
class ModuleLoader {
    /**
     *
     * @param array<string> $moduleClasses
     * @param DependencyInjectionContainer $dic
     * @param array<string,string> $configuration
     *
     * @return array<Module>
     *
     * @throws ClassIsNotAModuleException
     * @throws ModuleConfigurationPrefixCannotBeEmptyException
     */
    public function loadModules(array $moduleClasses, DependencyInjectionContainer $dic, array $configuration) : array {
        /**
         * @var array<Module> $modules
         */
        $modules = [];

        foreach ($moduleClasses as $moduleClass) {
            $modules[] = new $moduleClass();
        }

        foreach ($modules as $module) {
            if (!$module instanceof Module) {
                throw new ClassIsNotAModuleException(get_class($module));
            }

            $configurationOptions = $module->getConfigurationOptions();
            $moduleConfiguration = null;
            if ($configurationOptions !== null) {
                if ($configurationOptions->getPrefix() === "") {
                    throw new ModuleConfigurationPrefixCannotBeEmptyException(get_class($module));
                }

                
            }

            $module->configureDependencyInjection($dic, $moduleConfiguration);
        }
    }
}
