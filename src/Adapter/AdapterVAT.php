<?php

/** Strict types */
declare(strict_types=1);

namespace crawLee\Adapter;

/**
 * Class AdapterVAT
 *
 *  This class extends the Adapter abstract class and provides functionality
 *  for extracting VAT numbers from HTML content.
 *
 * @package crawLee\Adapter
 */
final class AdapterVAT extends Adapter {

	/**
	 * Extracts a specific value from the HTML content.
	 *
	 * This method applies a regular expression pattern to the HTML content and extracts a specific value
	 * based on the pattern match. The extracted value is then returned after removing any spaces.
	 *
	 * @return mixed The extracted value from the HTML content, or null if no match is found.
	 */
	public function extract(): mixed
	{
		$pattern = '/([A-Z]{2}\s*)\d+(\s*\d*)*/';
		if (preg_match($pattern, $this->html, $matches)) {
			return str_replace(' ', '', $matches[0]);
		}
		return null;
	}

}