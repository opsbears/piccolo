<?php

declare(strict_types=1);

namespace Piccolo\Configuration;

class ConfigurationOptionGroup {
    /**
     * @var string
     */
    private $prefix;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var array<string, ConfigurationOption>
     */
    private $options = [];

    /**
     * ConfigurationOptionGroup constructor.
     * @param $prefix
     * @param $name
     * @param string $description
     * @param array<string, ConfigurationOption> $options
     */
    public function __construct(string $prefix, string $name, string $description, array $options) {
        $this->prefix = $prefix;
        $this->name = $name;
        $this->description = $description;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getPrefix(): string {
        return $this->prefix;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @return array<string, ConfigurationOption>
     */
    public function getOptions(): array {
        return $this->options;
    }
}