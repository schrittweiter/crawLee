<?php

/** Strict types */
declare(strict_types=1);

namespace crawLee\Adapter;

/**
 * Class AdapterAddress
 *
 * This class extends the Adapter class and is used to extract addresses from HTML content.
 *
 * @package crawLee\Adapter
 */
final class AdapterAddress extends Adapter {

	/**
	 * Extracts an address from the given HTML.
	 *
	 * This method searches for a pattern representing an address in the provided HTML string and returns the first match found.
	 * The pattern used is based on a simple representation and may not cover all possible scenarios.
	 * Actual address extraction can be much more complex, and the pattern may need to be adjusted accordingly.
	 *
	 * @return mixed The extracted address if found, or null if no address is found.
	 */
	public function extract(): mixed
	{
		// This is just a simple representation. Actual address extraction can be much more complex.
		if (preg_match('/\d{1,5} [\w\s]+, [\w\s]+, \w{2} \d{5}/', $this->html, $matches)) {
			return $matches[0];
		}
		return null;
	}

}