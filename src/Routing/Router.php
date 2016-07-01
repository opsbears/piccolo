<?php

namespace Piccolo\Routing;

use Psr\Http\Message\ServerRequestInterface;

interface Router {
	/**
	 * @param ServerRequestInterface $request
	 *
	 * @return RoutingResponse
	 */
	public function route(ServerRequestInterface $request);

	/**
	 * @return RoutingResponse
	 */
	public function getNotFoundRoute();

	/**
	 * @return RoutingResponse
	 */
	public function getServerErrorRoute();
}