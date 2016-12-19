<?php
/**
 * Краткое описание.
 *
 * Длинное описание.
 *
 * @author: Firstgoer
 */

namespace ZendQrTest\Renderer;


use ZendQrTest\QrCodeException;
use Zend\Http\Client;
use Zend\Http\Client\Adapter\Curl;
use Zend\Http\Exception\RuntimeException;

/**
 * Class GoogleChartsRenderer
 * @package firstgoer\ZendQrTest\Renderer
 * @see https://developers.google.com/chart/infographics/docs/qr_codes
 */
class GoogleChartsRenderer extends HttpRendererAbstract
{
	//Url params
	const GOOGLE_CHARTS_URL = 'https://chart.googleapis.com/chart';
	const GOOGLE_CHARTS_TYPE = 'qr';

	//Output encoding params
	const GOOGLE_OUTPUT_ENCODING_UTF8 = 'UTF-8';
	const GOOGLE_OUTPUT_ENCODING_JIS = 'Shift_JIS';
	const GOOGLE_OUTPUT_ENCODING_ISO = 'ISO-8859-1';

	//Size params
	const GOOGLE_MIN_DEMENSION = 21;
	const GOOGLE_MAX_DEMENSION = 177;

	//Error correction params
	const GOOGLE_ERROR_CORRECTION_LOW = 'L';
	const GOOGLE_ERROR_CORRECTION_MEDIUM = 'M';
	const GOOGLE_ERROR_CORRECTION_QUANTITIES = 'Q';
	const GOOGLE_ERROR_CORRECTION_HIGH = 'H';

	/**
	 * @var string encoding sended to google
	 */
	private $encoding = self::GOOGLE_OUTPUT_ENCODING_UTF8;

	/**
	 * @var string google error correction level
	 */
	private $errorCorrection = self::GOOGLE_ERROR_CORRECTION_LOW;

	/**
	 * GoogleChartsRenderer constructor.
	 * @param Client|null $httpClient you can provide manually configured Http Client
	 */
	public function __construct(Client $httpClient = null)
	{
		if ($httpClient === null) {
			$config = [
				'adapter'     => Curl::class,
				'curloptions' => [
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_SSL_VERIFYHOST => false,
					CURLOPT_SSL_VERIFYPEER => false,
				],
			];
			$httpClient = new Client(self::GOOGLE_CHARTS_URL, $config);
		}
		$this->setHttpclient($httpClient);
	}

	/**
	 * @param string $text
	 * @param int $width
	 * @param int $height
	 * @return string
	 */
	public function generateQrCode($text, $width, $height)
	{
		if ($this->httpClient === null) {
			throw new QrCodeException('No http client provided');
		}

		if ($width < self::GOOGLE_MIN_DEMENSION || $width > self::GOOGLE_MAX_DEMENSION) {
			throw new QrCodeException(sprintf('Invalid width size, must be between %d and %d, got %d', self::GOOGLE_MIN_DEMENSION, self::GOOGLE_MAX_DEMENSION, $width));
		}

		if ($height < self::GOOGLE_MIN_DEMENSION || $width > self::GOOGLE_MAX_DEMENSION) {
			throw new QrCodeException(sprintf('Invalid height size, must be between %d and %d, got %d', self::GOOGLE_MIN_DEMENSION, self::GOOGLE_MAX_DEMENSION, $width));
		}

		if ($width != $height) {
			throw new QrCodeException('Width must equal to height');
		}

		$this->httpClient->setParameterGet(
			[
				'cht'  => self::GOOGLE_CHARTS_TYPE, //chart type is qr
				'chl'  => $text, //qr text
				'chs'  => sprintf('%dx%d', $width, $height), //qr size,
				'choe' => $this->encoding, //outpit encoding
				'chld' => $this->errorCorrection, //error_correction
			]
		);
		try {
			$response = $this->httpClient->send();
		} catch (RuntimeException $e) {
			throw new QrCodeException('Runtime exception: ' . $e->getMessage(), $e->getCode(), $e);
		}
		if (!$response->isOk()) {
			throw new QrCodeException('Google response error');
		}
		return $response->getBody();
	}

	/**
	 * @param string $encoding encoding sended to google
	 */
	public function setEncoding($encoding)
	{
		$this->encoding = $encoding;
	}

	/**
	 * @param string $errorCorrection google error correction level
	 */
	public function setErrorCorrection($errorCorrection)
	{
		$this->errorCorrection = $errorCorrection;
	}
}