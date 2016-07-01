<?php

namespace Piccolo\HTTP;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * This class contains the current HTTP request and response when processing a single web request.
 */
class HTTPRequestResponseContainer {
	/**
	 * @var ServerRequestInterface
	 */
	private $request;
	/**
	 * @var ResponseInterface
	 */
	private $response;

	public function __construct(ServerRequestInterface $request, ResponseInterface $response) {
		$this->setRequest($request);
		$this->setResponse($response);
	}

	/**
	 * @return ServerRequestInterface
	 */
	public function getRequest() {
		return $this->request;
	}

	/**
	 * @param ServerRequestInterface $request
	 */
	public function setRequest($request) {
		$this->request = $request;
	}

	/**
	 * @return ResponseInterface
	 */
	public function getResponse() {
		return $this->response;
	}

	/**
	 * @param ResponseInterface $response
	 */
	public function setResponse($response) {
		$this->response = $response;
	}
}