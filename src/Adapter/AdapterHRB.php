<?php

declare(strict_types=1);

namespace crawLee\Adapter;

/**
 * Base class for data extraction
 */
final class AdapterHRB extends Adapter {

	public function extract(): mixed
	{
		if (preg_match('/HRB\s*(\d+(\s*\d*)*)/', $this->html, $matches)) {
			return 'HRB'.str_replace(' ', '', $matches[1]);
		}
		return null;
	}

}