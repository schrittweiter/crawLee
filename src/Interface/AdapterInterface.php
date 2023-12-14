<?php

/** Strict types */
declare(strict_types=1);

namespace crawLee\Interface;

/**
 * Interface AdapterInterface
 *
 * This interface defines the methods that must be implemented by an adapter class
 *  for extracting data from HTML content.
 */
interface AdapterInterface 
{
	/**
	 * Constructs a new instance of the class.
	 *
	 * @param string $html The HTML content to be processed.
	 *
	 * @return void
	 */
    public function __construct($html);

	/**
	 * Extracts and returns the desired data.
	 *
	 * @return mixed Returns the extracted data.
	 */
    public function extract(): mixed;
}