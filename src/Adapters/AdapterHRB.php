<?php

namespace crawLee\Adapters;

/**
 * Base class for data extraction
 */
class AdapterHRB extends Base {

	public function extract()
	{
		if (preg_match('/HRB\s*(\d+(\s*\d*)*)/', $this->html, $matches)) {
			return 'HRB'.str_replace(' ', '', $matches[1]);
		}
		return null;
	}

}