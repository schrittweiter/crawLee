<?php

namespace crawLee\Adapters;

/**
 * Base class for data extraction
 */
class AdapterSocial extends Base {

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