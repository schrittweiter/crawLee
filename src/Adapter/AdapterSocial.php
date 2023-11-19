<?php

declare(strict_types=1);

namespace crawLee\Adapter;

/**
 * Base class for data extraction
 */
final class AdapterSocial extends Adapter {

	public function extract()
	{
		$profiles = [];
		$platforms = ['facebook', 'twitter', 'linkedin', 'instagram'];
		foreach ($platforms as $platform) {
			if (preg_match('/https?:\/\/(www\.)?' . $platform . '.com\/[a-zA-Z0-9._-]+/', $this->html, $matches)) {
				$profiles[$platform] = $matches[0];
			}
		}
		return $profiles;
	}

}