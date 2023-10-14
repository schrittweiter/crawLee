<?php

namespace crawLee\Adapters;

/**
 * Base class for data extraction
 */
class Base {
	public mixed $html;

	public function __construct($html) {
		$this->html = $html;
	}

	public function extract() {
	}
}