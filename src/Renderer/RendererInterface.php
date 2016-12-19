<?php
/**
 * Краткое описание.
 *
 * Длинное описание.
 *
 * @author: Firstgoer
 */

namespace ZendQrTest\Renderer;


/**
 * Interface RendererInterface
 * @package firstgoer\ZendQrTest\Renderer
 */
interface RendererInterface
{
	/**
	 * @param $text string text to decode in qrcode
	 * @param $width int width of qrcode
	 * @param $height int height of qrcode
	 * @return string
	 */
	public function generateQrCode($text, $width, $height);
}