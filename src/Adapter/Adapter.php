<?php

/** Strict types */
declare(strict_types=1);

namespace crawLee\Adapter;

/**
 * Interface AdapterInterface
 *
 * This interface defines the required methods that an adapter class must implement.
 */
use crawLee\Interface\AdapterInterface;

/**
 * Adapter class that implements the AdapterInterface.
 *
 * This class implements the AdapterInterface and provides functionality to extract information from HTML content.
 */
class Adapter implements AdapterInterface 
{
	/**
	 * The HTML code for the web page.
	 *
	 * @var string
	 */
	public mixed $html;

	/**
	 * Constructor method for the class.
	 *
	 * @param mixed $html The HTML content to be assigned to the object property.
	 *
	 * @return void
	 */
	public function __construct(mixed $html) {
		$this->html = $html;
	}

	/**
	 * Extracts data from the provided source.
	 *
	 * @return mixed The extracted data.
	 */
	public function extract(): mixed {}
}