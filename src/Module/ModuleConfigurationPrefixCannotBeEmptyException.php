<?php

declare(strict_types=1);

namespace Piccolo\Module;

use Symfony\Component\Config\Definition\Exception\Exception;

class ModuleConfigurationPrefixCannotBeEmptyException extends Exception {
    public function __construct($className) {
        parent::__construct($className . " returned a non-null option set that has an empty option prefix.");
    }
}