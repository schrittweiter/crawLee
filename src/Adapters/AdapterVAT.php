<?php

namespace crawLee\Adapters;

/**
 * Base class for data extraction
 */
class AdapterVAT extends Base {

	public function extract()
	{
		$pattern = '/([A-Z]{2}\s*)\d+(\s*\d*)*/';
		if (preg_match($pattern, $this->html, $matches)) {
			return str_replace(' ', '', $matches[0]);
		}
		return null;
	}

}