<?php
/**
 * Abstract class, created for generating QRCode using http client
 * @author: Firstgoer
 */

namespace ZendQrTest\Renderer;


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