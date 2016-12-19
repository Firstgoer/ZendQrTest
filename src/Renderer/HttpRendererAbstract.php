<?php
/**
 * Краткое описание.
 *
 * Длинное описание.
 *
 * @author: Firstgoer
 */

namespace firstgoer\ZendQrTest\Renderer;


use Zend\Http\Client;

/**
 * Class HttpRendererAbstract
 * @package firstgoer\ZendQrTest\Renderer
 */
abstract class HttpRendererAbstract implements RendererInterface
{
	/** @var  Client $httpclient */
	protected $httpClient;

	/**
	 * @return Client http client to send requests with
	 */
	public function getHttpClient()
	{
		return $this->httpClient;
	}

	/**
	 * @param mixed $httpClient http client to send requests with
	 */
	public function setHttpclient(Client $httpClient)
	{
		$this->httpClient = $httpClient;
	}
}