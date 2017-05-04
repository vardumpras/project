<?php

namespace Alcyon\CoreBundle\Service;

class RevCrypt {

	/**
	 * Encodeur de chaîne
	 * @param key $key clé de cryptage
	 * @param string $string Chaîne à coder
	 * @return string Chaîne codée
	 */
	public function code($key, $string) {
		$key = hash("sha256",$key, true);
		$data = '';
		for ($i = 0; $i<strlen($string); $i++) {
			$kc = substr($key, ($i%strlen($key)) - 1, 1);
			$data .= chr(ord($string{$i})+ord($kc));
		}
		$data = base64_encode($data);

		return $data;
	}
 
	/**
	 * Décodeur de Chaîne
	 * @param key $key clé de cryptage
	 * @param string $string Chaîne à décoder
	 * @return string
	 */
	public function decode($key, $string) {
		$key = hash("sha256",$key, true);
		$data = '';
		$string = base64_decode($string);
		for ($i = 0; $i<strlen($string); $i++) {
			$kc = substr($key, ($i%strlen($key)) - 1, 1);
			$data .= chr(ord($string{$i})-ord($kc));
		}

		return $data;
	}
}
