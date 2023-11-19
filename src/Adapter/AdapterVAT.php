<?php

declare(strict_types=1);

namespace crawLee\Adapter;

/**
 * Base class for data extraction
 */
final class AdapterVAT extends Adapter {

	public function extract(): mixed
	{
		$pattern = '/([A-Z]{2}\s*)\d+(\s*\d*)*/';
		if (preg_match($pattern, $this->html, $matches)) {
			return str_replace(' ', '', $matches[0]);
		}
		return null;
	}

}