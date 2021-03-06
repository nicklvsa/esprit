<?php

class BlobExpiredException extends Exception {}

/**
 * This class provides basic binary blob encryption and decryption, for use with the security token
 * 
 */
class BasicBlobCrypter extends BlobCrypter {
	//FIXME make this compatible with the java's blobcrypter
	

	// Labels for key derivation
	private $CIPHER_KEY_LABEL = 0;
	private $HMAC_KEY_LABEL = 1;
	
	/** Key used for time stamp (in seconds) of data */
	public $TIMESTAMP_KEY = "t";
	
	/** minimum length of master key */
	public $MASTER_KEY_MIN_LEN = 16;
	
	/** allow three minutes for clock skew */
	private $CLOCK_SKEW_ALLOWANCE = 180;
	
	private $UTF8 = "UTF-8";
	
	private $cipherKey;
	private $hmacKey;

    private static $cipherKeyText = "INSECURE_DEFAULT_KEY";
	private static $hmacKeyText = "INSECURE_DEFAULT_KEY";
    private static $allowPlainTextToken = "true";
    
	public function __construct()
	{
		$this->cipherKey = self::$cipherKeyText;
		$this->hmacKey = self::$hmacKeyText;
	}

	/**
	 * {@inheritDoc}
	 */
	public function wrap(Array $in)
	{
		$encoded = $this->serializeAndTimestamp($in);
		if (!function_exists('mcrypt_module_open') && self::$allowPlainTextToken) {
			$cipherText = base64_encode($encoded);
		} else {
			$cipherText = Crypto::aes128cbcEncrypt($this->cipherKey, $encoded);
		}
		$hmac = Crypto::hmacSha1($this->hmacKey, $cipherText);
		$b64 = base64_encode($cipherText . $hmac);
		return $b64;
	}
	
	private function serializeAndTimestamp(Array $in)
	{
		$encoded = "";
		foreach ($in as $key => $val) {
			$encoded .= urlencode($key) . "=" . urlencode($val) . "&";
		}
		$encoded .= $this->TIMESTAMP_KEY . "=" . time();
		return $encoded;
	}

	/**
	 * {@inheritDoc}
	 */
	public function unwrap($in, $maxAgeSec)
	{
		//TODO remove this once we have a better way to generate a fake token
		// in the example files
		if (self::$allowPlainTextToken && count(explode(':', $in)) == 6) {
			$data = explode(":", $in);
			$out = array();
			$out['o'] = $data[0];
			$out['v'] = $data[1];
			$out['a'] = $data[2];
			$out['d'] = $data[3];
			$out['u'] = $data[4];
			$out['m'] = $data[5];
		} else {
			//TODO Exception handling like JAVA
			$bin = base64_decode($in);
			$cipherText = substr($bin, 0, strlen($bin) - Crypto::$HMAC_SHA1_LEN);
			$hmac = substr($bin, strlen($cipherText));
			Crypto::hmacSha1Verify($this->hmacKey, $cipherText, $hmac);
			if (!function_exists('mcrypt_module_open') && self::$allowPlainTextToken) {
				$plain = base64_decode($cipherText);
			} else {
				$plain = Crypto::aes128cbcDecrypt($this->cipherKey, $cipherText);
			}
			$out = $this->deserialize($plain);
			$this->checkTimestamp($out, $maxAgeSec);
		}
		return $out;
	}

	private function deserialize($plain)
	{
		$map = array();
		$items = split("[&=]", $plain);
		/*
		//TODO: See if this can work or isn't necessary.
		if ((count($items) / 2) != 7) {
			// A valid token should decrypt to 14 items, aka 7 pairs.
			// If not, this wasn't valid & untampered data and we abort
			throw new BlobExpiredException("Invalid security token");
		}
		*/
		for ($i = 0; $i < count($items); ) {
			$key = urldecode($items[$i ++]);
			$value = urldecode($items[$i ++]);
			$map[$key] = $value;
		}
		return $map;
	}

	private function checkTimestamp(Array $out, $maxAge)
	{
		$minTime = (int)$out[$this->TIMESTAMP_KEY] - $this->CLOCK_SKEW_ALLOWANCE;
		$maxTime = (int)$out[$this->TIMESTAMP_KEY] + $maxAge + $this->CLOCK_SKEW_ALLOWANCE;
		$now = time();
		if (! ($minTime < $now && $now < $maxTime)) {
			throw new BlobExpiredException("Security token expired");
		}
	}
}
