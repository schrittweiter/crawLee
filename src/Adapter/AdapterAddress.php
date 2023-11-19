<?php

declare(strict_types=1);

namespace crawLee\Adapter;

/**
 * Base class for data extraction
 */
final class AdapterAddress extends Adapter {

	public function extract()
	{
		// This is just a simple representation. Actual address extraction can be much more complex.
		if (preg_match('/\d{1,5} [\w\s]+, [\w\s]+, \w{2} \d{5}/', $this->html, $matches)) {
			return $matches[0];
		}
		return null;
	}

}