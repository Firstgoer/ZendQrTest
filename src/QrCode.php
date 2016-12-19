<?php
/**
 * Краткое описание.
 *
 * Длинное описание.
 *
 * @author: Firstgoer
 */

namespace ZendQrTest;


use ZendQrTest\Renderer\RendererInterface;
use src\QrCodeException;

/**
 * Class QrCode
 * @package firstgoer\ZendQrTest
 */
class QrCode
{
	/**
	 * @var RendererInterface $renderer
	 */
	private $renderer;

	/**
	 * @var string $text
	 */
	private $text;

	/**
	 * @var int $width
	 */
	private $width;

	/**
	 * @var int $height
	 */
	private $height;

	/**
	 * QrCode constructor.
	 * @param $text string text to decode in qrcode
	 * @param $width int width of qrcode
	 * @param $height int height of qrcode
	 * @throws QrCodeException
	 */
	public function __construct($text, $width, $height)
	{
		if (!is_string($text) || $text == '') {
			throw new QrCodeException('Text must be string and not empty');
		}
		if (!is_int($width)) {
			throw new QrCodeException('Width must be integer');
		}
		if (!is_int($height)) {
			throw new QrCodeException('Height must be integer');
		}
		$this->text = $text;
		$this->width = $width;
		$this->height = $height;
	}

	/**
	 * @param RendererInterface $renderer qrcode renderer
	 */
	public function setRenderer(RendererInterface $renderer)
	{
		$this->renderer = $renderer;
	}

	/**
	 * @return string encoded result
	 * @throws QrCodeException
	 */
	public function generate()
	{
		if ($this->renderer === null) {
			throw new QrCodeException('Renderer must be set');
		}
		return $this->renderer->generateQrCode($this->text, $this->width, $this->height);
	}
}