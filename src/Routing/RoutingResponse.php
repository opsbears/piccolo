<?php

namespace Piccolo\Routing;

class RoutingResponse {
	/**
	 * @var int
	 */
	private $statusCode;
	/**
	 * @var string
	 */
	private $controllerClass;
	/**
	 * @var string
	 */
	private $controllerMethod;

	/**
	 * @var array
	 */
	private $parameters = [];

	/**
	 * @param int    $statusCode
	 * @param string $controllerClass
	 * @param string $controllerMethod
	 * @param array  $parameters
	 */
	public function __construct($statusCode, $controllerClass, $controllerMethod, $parameters = []) {
		$this->statusCode       = $statusCode;
		$this->controllerClass  = $controllerClass;
		$this->controllerMethod = $controllerMethod;
		$this->parameters       = $parameters;
	}

	/**
	 * @return int
	 */
	public function getStatusCode() : int {
		return $this->statusCode;
	}

	/**
	 * @return string
	 */
	public function getControllerClass() : string {
		return $this->controllerClass;
	}

	/**
	 * @return string
	 */
	public function getControllerMethod() : string {
		return $this->controllerMethod;
	}

	/**
	 * @return array
	 */
	public function getParameters() : array {
		return $this->parameters;
	}
}