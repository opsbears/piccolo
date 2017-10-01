<?php

declare(strict_types=1);

namespace Piccolo\Configuration;

class ConfigurationOption {
    /**
     * @var string
     */
    private $option;
    /**
     * @var bool
     */
    private $flag;
    /**
     * @var string
     */
    private $description;
    /**
     * @var ?mixed
     */
    private $defaultValue;

    public function __construct(string $option, boolean $flag = false, string $description = "", ?mixed $defaultValue = null) {
        $this->option = $option;
        $this->flag = $flag;
        $this->description = $description;
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return string
     */
    public function getOption(): string {
        return $this->option;
    }

    /**
     * @return bool
     */
    public function isFlag(): bool {
        return $this->flag;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue(): ?mixed {
        return $this->defaultValue;
    }
}