<?php

/** Strict types */
declare(strict_types=1);

/** Namespace */
namespace crawLee\Interface;

/** Interface */
interface AdapterInterface 
{    
    /**
     * Constructor for the adapter.
     * 
     * @param mixed $html The HTML content to be processed.
     */
    public function __construct($html);

    /**
     * Extracts data from the provided HTML content.
	 * 
	 * @return mixed
     */
    public function extract(): mixed;
}