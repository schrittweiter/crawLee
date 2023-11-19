<?php

/** Strict types */
declare(strict_types=1);

/** Namespace */
namespace crawLee;

/** Includes */
require __DIR__.'/../vendor/autoload.php';

/** Exceptions */
use crawLee\Exception\InvalidTypeException;

/** Class */
class crawLee 
{
	/** @var array Holds the default configuration settings */
	private array $config = [
		'adapter' => ['HRB','VAT','Mail','Phone','Fax','Address','Social','Company','LegalForm'],
		'openai' => [
			'key' => '',
			'model' => 'gpt-3.5-turbo-instruct',
			'proxy' => ''
		]
	];

	/** @var array Stores the original configuration settings */
	private array $configOrigin;

	/**
	 * @method void __construct(array $config = []) Constructor to initialize the crawLee object.
	 * 
     * @param array $config An optional configuration array to override default settings.
	 */
	public function __construct(array $config = []) 
	{
		$this->configOrigin = $this->config = array_merge($this->config,$config);
	}

	/**
	 * @method self setConfig(array $config = []) Set or update the configuration settings.
	 * 
     * @param array $config An array of configuration settings.
     * @return self Returns the instance of the class for chaining.
     * @throws InvalidTypeException If the provided $config is not an array.
	 */
	public function setConfig(array $config = []): self
	{
		if(is_array($config)) {
			$this->config = array_merge($this->config,$config);
		} else {
			throw new InvalidTypeException('Config needs to be array, '. gettype($config) .' given!',500);
		}

		return $this;
	}

	/**
	 * @method self resetConfig() Reset the configuration to its original state.
	 * 
     * @return self Returns the instance of the class for chaining.
	 */
	public function resetConfig(): self
	{
		$this->config = $this->configOrigin;

		return $this;
	}

	/**
	 * @method array parse(string $url) Extract and process HTML from the specified URL.
	 * 
     * @param string $url The URL of the web page to scrape.$_COOKIE
     * @return array Returns an array of extracted data.
     * @throws InvalidTypeException If there's an issue with data extraction.
	 */
	public function parse(string $url): array
	{
		// Initialize cURL session
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 15);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->config['curl']['safemode'] ?? false);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->config['curl']['useragent'] ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36');
		
		// Execute cURL session and close it
		$html = curl_exec($ch);
		curl_close($ch);

		// Process the HTML using defined adapters
		$data = []; foreach($this->config['adapter'] as $adapter) {
			require_once dirname(__FILE__) . '/Adapter/Adapter'.$adapter.'.php';
			$instance = (new \ReflectionClass('\\crawLee\\Adapter\\Adapter' . $adapter))->newInstance($html);
			$data[$adapter] = $instance->extract();
		}

		return $data;
	}
}