<?php

namespace Piccolo\HTTP;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

/**
 * A HTTP factory is a class that abstracts the workings required by PSR-7, by creating a HTTP server request from
 * superglobals and creating a stream from a string.
 */
interface HTTPServerFactory {
	/**
	 * @param array           $server
	 * @param array           $get
	 * @param array           $post
	 * @param array           $cookies
	 * @param array           $files
	 *
	 * @param StreamInterface $inputStream
	 *
	 * @return ServerRequestInterface
	 */
	public function createServerRequest(array $server,
										array $get,
										array $post,
										array $cookies,
										array $files,
										StreamInterface $inputStream);

	/**
	 * @param string $fileName
	 *
	 * @return StreamInterface
	 */
	public function createReadOnlyFileStream(string $fileName) : StreamInterface;

	public function createStringStream(string $string) : StreamInterface;
}
