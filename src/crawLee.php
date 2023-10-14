<?php

namespace crawLee;

require_once dirname(__FILE__) . '/Adapters/Base.php';

use Exception;

class crawLee {

	private mixed $url;
	/**
	 * @var array|mixed
	 */
	private mixed $config;
	private string|false $html;

	public function __construct() {

		$this->config = [
			'sets' => ['HRB','VAR','Mail','Phone','Fax','Address','Social','Company','LegalForm'],
			'url' => '',
			'format' => ''
		];

		return $this;
	}

	/**
	 * set crawLee config
	 *
	 * @param array $config
	 * @return crawLee
	 */
	public function setConfig(array $config = []): crawLee
	{
		try {
			if(is_array($config)) {
				$this->config = array_merge($this->config,$config);
			} else {
				throw new Exception('crawLee - Error: config needs to be array, '. gettype($config) .' given!',500);
			}
		} catch (Exception $e) {
			echo $e->getMessage(), "\n";
		}

		return $this;
	}

	/**
	 * set url to crawl
	 *
	 * @param string $url
	 * @return crawLee
	 */
	public function setUrl(string $url = ''): crawLee
	{
		try {
			if(is_string($url)) {
				$this->url = $url;
			} else {
				throw new Exception('crawLee - Error: url needs to be string, '. gettype($url) .' given!',500);
			}
		} catch (Exception $e) {
			echo $e->getMessage(), "\n";
		}

		return $this;
	}

	/**
	 * extract html from transmitted page
	 *
	 * @return crawLee
	 */
	public function html(): crawLee
	{
		try {
			if(is_string($this->url)) {
				// @TODO: maybe add curl to simulate browser and follow redirects
				$this->html = file_get_contents($this->url);
			} else {
				throw new Exception('crawLee - Error: missing url to crawl!',500);
			}
		} catch (Exception $e) {
			echo $e->getMessage(), "\n";
		}

		return $this;
	}

	/**
	 * return selected extracted data
	 *
	 * @return array
	 * @throws \ReflectionException
	 */
	public function extract(): array
	{

		$data = []; foreach($this->config['sets'] as $set) {
			require_once dirname(__FILE__) . '/Adapters/Adapter'.$set.'.php';
			$instance = (new \ReflectionClass('\\crawLee\\Adapters\\Adapter' . $set))->newInstance($this->html);
			$data[$set] = $instance->extract();
		}

		return $data;
	}

}