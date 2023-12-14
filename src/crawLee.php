<?php

/** Strict types */
declare(strict_types=1);

/**
 * The crawLee class is responsible for extracting and processing data from web pages.
 */
namespace crawLee;

/** Includes */
require __DIR__.'/../vendor/autoload.php';

/** Exceptions */
use /**
 * Exception class for handling invalid type errors.
 *
 * This exception is thrown when trying to perform an operation with an invalid type.
 * It should be used to handle situations where the expected type is not matched.
 *
 * @package crawLee\Exception
 */
	crawLee\Exception\InvalidTypeException;

/**
 * @var array $config Holds the default configuration settings
 */
class crawLee 
{
	/**
	 * Represents the configuration data for the application.
	 *
	 * This variable stores the configuration data for the application, which includes
	 * various settings and options. It is structured as an associative array, where each
	 * key represents a specific setting or option, and its corresponding value represents
	 * the value assigned to that setting or option.
	 *
	 * The 'adapter' key represents the list of available adapters, such as 'HRB', 'VAT',
	 * 'Mail', 'Phone', 'Fax', 'Address', 'Social', 'Company', and 'LegalForm'.
	 *
	 * The 'openai' key represents the OpenAI configuration, which includes sub-keys like
	 * 'key', 'model', and 'proxy'. The 'key' represents the API key for OpenAI. The 'model'
	 * represents the specific model to be used, which is set to 'gpt-3.5-turbo-instruct'
	 * in this case. The 'proxy' represents the proxy configuration, if any.
	 *
	 * @var array
	 */
	private array $config = [
		'adapter' => ['HRB','VAT','Mail','Phone','Fax','Address','Social','Company','LegalForm'],
		'openai' => [
			'key' => '',
			'model' => 'gpt-3.5-turbo-instruct',
			'proxy' => ''
		]
	];

	/**
	 * Represents the original configuration data.
	 *
	 * This variable stores the original configuration data before any modifications
	 * or updates are made. It serves as a reference point to compare the changes made
	 * to the configuration data.
	 *
	 * @var array
	 */
	private array $configOrigin;

	/**
	 * Constructor for the class.
	 *
	 * @param array $config An array containing configuration parameters. Defaults to an empty array.
	 * @return void
	 */
	public function __construct(array $config = []) 
	{
		$this->configOrigin = $this->config = array_merge($this->config,$config);
	}

	/**
	 * Set the configuration for this class.
	 *
	 * @param array $config The configuration options.
	 *
	 * @return self Returns an instance of the class.
	 * @throws InvalidTypeException If the config parameter is not an array.
	 *
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
	 * Resets the configuration to its original state.
	 *
	 * @return self Returns an instance of the current object.
	 */
	public function resetConfig(): self
	{
		$this->config = $this->configOrigin;

		return $this;
	}

	/**
	 * parse
	 *
	 * This method performs a cURL session to retrieve HTML from the given URL and process it using defined adapters.
	 *
	 * @param string $url The URL to retrieve HTML from
	 *
	 * @return array Returns an associative array containing the extracted data by each adapter
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