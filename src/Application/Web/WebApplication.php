<?php

namespace Piccolo\Application\Web;

use Piccolo\Application\AbstractApplication;
use Piccolo\HTTP\HTTPFactory;
use Piccolo\HTTP\HTTPRequestResponseContainer;
use Piccolo\Routing\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class WebApplication extends AbstractApplication {
	/**
	 * @param array $server
	 * @param array $get
	 * @param array $post
	 * @param array $cookies
	 * @param array $files
	 *
	 * @return array
	 */
	public function execute(array $server, array $get, array $post, array $cookies, array $files, string $inputFile) {
		$httpRequest = $this->createHTTPRequest($server, $get, $post, $cookies, $files, $inputFile);

		try {
			list($controllerResponse, $controllerClass, $controllerMethod) =
				$this->processRoutingToController($httpRequest);

			$this->processView($controllerClass, $controllerMethod, $controllerResponse);
		} catch (\Exception $e) {
			$dic = $this->getDIC();
			$dic->share($e);
			/**
			 * @var Router $router
			 */
			$router = $dic->make(Router::class);
			$errorRoute = $router->getServerErrorRoute();
			$controller       = $dic->make($errorRoute->getControllerClass());
			$controllerResponse = $dic->execute(
				[$controller, $errorRoute->getControllerMethod()],
				[]);
			$this->processView($errorRoute->getControllerClass(), $errorRoute->getControllerMethod(), $controllerResponse);
		}

		return $this->prepareOutput();
	}

	/**
	 * @param array $server
	 * @param array $get
	 * @param array $post
	 * @param array $cookies
	 * @param array $files
	 *
	 * @return \Psr\Http\Message\ServerRequestInterface
	 */
	private function createHTTPRequest(array $server, array $get, array $post, array $cookies, array $files, string $inputFile) {
		$dic = $this->getDIC();
		/**
		 * @var HTTPFactory $httpFactory
		 */
		$httpFactory = $dic->make(HTTPFactory::class);
		$httpRequest = $httpFactory->createServerRequest($server, $get, $post, $cookies, $files, 
			$httpFactory->createReadOnlyFileStream($inputFile));
		$dic->share($httpRequest);
		$dic->share($httpRequest->getUri());
		return $httpRequest;
	}

	private function processRoutingToController(ServerRequestInterface $request) {
		$dic = $this->getDIC();
		/**
		 * @var Router $router
		 */
		$router = $dic->make(Router::class);

		$routingResponse = $router->route($request);

		$controllerMethod = $routingResponse->getControllerMethod();
		$controller       = $dic->make($routingResponse->getControllerClass());

		try {
			$controllerResponse = $dic->execute(
				[$controller, $controllerMethod],
				$routingResponse->getParameters());
		} catch (NotFoundException $e) {
			$routingResponse    = $router->getNotFoundRoute();
			$controllerResponse = $dic->execute(
				[$routingResponse->getControllerClass(), $routingResponse->getControllerMethod()],
				$routingResponse->getParameters());
		}

		return [$controllerResponse,
			$routingResponse->getControllerClass(),
			$routingResponse->getControllerMethod(),
		];
	}

	private function processView($controllerClass, $controllerMethod, $controllerResponse) {
		$dic = $this->getDIC();
		/**
		 * @var HTTPFactory $httpFactory
		 */
		$httpFactory = $dic->make(HTTPFactory::class);
		/**
		 * @var HTTPRequestResponseContainer $requestResponseContainer
		 */
		$requestResponseContainer = $dic->make(HTTPRequestResponseContainer::class);

		if (!$controllerResponse instanceof ResponseInterface) {
			if (is_string($controllerResponse)) {
				//Standard text response, no view rendering
				//PSR-7 bullshit, don't ask
				$responseBody = $controllerResponse;
			} else {
				//Data response, pass to view

				/**
				 * @var ControllerView $view
				 */
				$view = $this->getDIC()->make(ControllerView::class);

				$responseBody = $view->render($controllerClass, $controllerMethod, $controllerResponse);
			}
			$requestResponseContainer->setResponse(
				$requestResponseContainer->getResponse()->withBody(
					$httpFactory->createStringStream($responseBody)));
		} else {
			$requestResponseContainer->setResponse($controllerResponse);
		}
	}

	private function prepareOutput() {
		$dic = $this->getDIC();
		/**
		 * @var HTTPRequestResponseContainer $requestResponseContainer
		 */
		$requestResponseContainer = $dic->make(HTTPRequestResponseContainer::class);
		$httpResponse = $requestResponseContainer->getResponse();

		$result              = [];
		$result['headers']   = [];
		$result['headers'][] = 'HTTP/' . $httpResponse->getProtocolVersion() . ' ' .
			$httpResponse->getStatusCode() . ' ' .
			$httpResponse->getReasonPhrase();
		foreach ($httpResponse->getHeaders() as $name => $values) {
			foreach ($values as $value) {
				$result['headers'] = sprintf('%s: %s', $name, $value);
			}
		}
		$result['body'] = $httpResponse->getBody();

		return $result;
	}
}
