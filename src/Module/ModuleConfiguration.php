<?php

declare(strict_types=1);

namespace Piccolo\Module;

use Piccolo\Configuration\ConfigurationOptionGroup;

/**
 * The module configuration contains the actual values of configuration passed to this module, as well as the
 * configuration rules.
 *
 * @package Foundation
 */
class ModuleConfiguration {
    /**
     * @var array<string,mixed>
     */
    private $options;
    /**
     * @var ConfigurationOptionGroup
     */
    private $configurationOptionGroup;

    /**
     * ModuleConfiguration constructor.
     *
     * @param array<string,mixed> $options
     * @param ConfigurationOptionGroup $configurationOptionGroup
     */
    public function __construct(array $options, ConfigurationOptionGroup $configurationOptionGroup) {
        $this->options = $options;
        $this->configurationOptionGroup = $configurationOptionGroup;
    }

    /**
     * @return ConfigurationOptionGroup
     */
    public function getConfigurationOptionGroup(): ConfigurationOptionGroup {
        return $this->configurationOptionGroup;
    }

    /**
     * @return array<string,mixed>
     */
    public function getOptions(): array {
        return $this->options;
    }
}