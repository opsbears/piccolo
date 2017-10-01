<?php


namespace Piccolo\Application;


use Symfony\Component\Config\Definition\Exception\Exception;

class ModulesAlreadyLoadedException extends Exception {
    public function __construct() {
        parent::__construct("Modules have already been loaded and cannot be re-loaded.");
    }
}