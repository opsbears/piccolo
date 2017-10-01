<?php

declare(strict_types=1);

namespace Piccolo\Module;

use Symfony\Component\Config\Definition\Exception\Exception;

class ClassIsNotAModuleException extends Exception {
    public function __construct($class) {
        parent::__construct("This class is not a module (does not implement Piccolo\\Module\\Module: " . $class);
    }
}