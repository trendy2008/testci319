<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Lopen {

	private $key;

	public function __construct()
	{
		// parent::__construct();
		$this->ci =& get_instance();
		$this->key = "Trendy2008".$this->ci->config->item('encryption_Key');
	}


	function alert($msg='')
	{
		$this->ci->session->set_flashdata('fmessage', $msg);
	}


	public function encode($x)
	{
		$plaintext 				= $x;
		$ivlen 					= openssl_cipher_iv_length($cipher="AES-128-CBC");
		$iv 					= openssl_random_pseudo_bytes($ivlen);
		$ciphertext_raw 		= openssl_encrypt($plaintext, $cipher, $this->key, $options=OPENSSL_RAW_DATA, $iv);
		$hmac 					= hash_hmac('sha256', $ciphertext_raw, $this->key, $as_binary=true);
		$ciphertext 			= rtrim(strtr(base64_encode($iv.$hmac.$ciphertext_raw), '+/', '-_'), '=');
		return $ciphertext;
	}


	public function decode($x)
	{
		$c 						= base64_decode(str_pad(strtr($x, '-_', '+/'), strlen($x) % 4, '=', STR_PAD_RIGHT));
		$ivlen 					= openssl_cipher_iv_length($cipher="AES-128-CBC");
		$iv 					= substr($c, 0, $ivlen);
		$hmac 					= substr($c, $ivlen, $sha2len=32);
		$ciphertext_raw 		= substr($c, $ivlen+$sha2len);
		$original_plaintext 	= openssl_decrypt($ciphertext_raw, $cipher, $this->key, $options=OPENSSL_RAW_DATA, $iv);
		$calcmac 				= hash_hmac('sha256', $ciphertext_raw, $this->key, $as_binary=true);
		if (hash_equals($hmac, $calcmac))//PHP 5.6+ timing attack safe comparison
		{
		    return $original_plaintext;
		}else{
			return "";
		}
	}



}