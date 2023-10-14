<?php

namespace crawLee\Adapters;

/**
 * Base class for data extraction
 */
class AdapterAddress extends Base {

	public function extract()
	{
		// This is just a simple representation. Actual address extraction can be much more complex.
		if (preg_match('/\d{1,5} [\w\s]+, [\w\s]+, \w{2} \d{5}/', $this->html, $matches)) {
			return $matches[0];
		}
		return null;
	}

}