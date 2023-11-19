<?php

/** Strict types */
declare(strict_types=1);

/** Namespace */
namespace crawLee\Adapter;

/** Interfaces */
use crawLee\Interface\AdapterInterface;

/** Class */
class Adapter implements AdapterInterface 
{
	/**
     * @var mixed Holds the HTML content to be processed.
     */
	public mixed $html;

	/** 
	 * @method __construct(mixed $html) Initializes a new instance of the Adapter class with the provided HTML content.
	 * 
	 * @param mixed $html The HTML content to be used by the Adapter.
	 */
	public function __construct(mixed $html) {
		$this->html = $html;
	}

	/**
	 * @method mixed extract() extract information from the stored HTML content.
     *
     * @return mixed The result of the extraction process
	 */
	public function extract(): mixed {}
}