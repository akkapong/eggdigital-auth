<?php

namespace EggDigital\Auth\Provider;

/**
 * API CDN
 *
 * @category Libraries
 * @package  Eggdigital/Auth
 * @author   Akkapong Kajornwongwattana <akk.ohm@gmail.com>
 * @license  CDN Generate key version 1.0
 */
class CDNApiKeyProvider
{
    protected $alphabet  = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    protected $url = "";
    protected $config;

    public function __construct()
    {
        $this->config = \Config::get('auth::'.$_SERVER['LARAVEL_ENV'].'/config');
    }

    private function callApi($service)
    {
    	// create curl resource
		$curl = curl_init();

		//get url
		$url_public_key = $this->config["URL_PUB_KEY"];

		// set url
		curl_setopt($curl, CURLOPT_URL, $url_public_key.'?service_id=' . $service);

		//return the transfer as a string
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string
		$result     = curl_exec($curl);

		// close curl resource to free up system resources
		curl_close($curl);

		return $result;
    }

    private function getPublicKey($service_id)
    {
    	$public_key = "";
    	$res = $this->callApi($service_id);
    	
        //convert to array
        $res = json_decode($res, true);

    	if ((isset($res["status"]))&&($res["status"]["code"] == 200)) {
			$public_key = $res["data"]["key"];
    	}

    	return $public_key;
    }

    public function encode($input, $length = 8)
    {
        $key      = '';
        $input    = md5($input).$length;
        $input    = substr($input, 0, $length);
        $alphabet = $this->alphabet.$this->alphabet;

        foreach (str_split($input) as $s) {
            $alphabet  .= $this->alphabet;
            $int_alpha  = ord($s);
            $alphabet   = substr($alphabet, $int_alpha);
            $key       .= substr($alphabet, 0, 1);
        }

        return $key;
    }

    public function genCdnApiKey($service_id, $private_key)
    {
    	$apikey = "";
    	//get public key
    	$public_key = $this->getPublicKey($service_id);

        if (!empty($public_key)) {
    		//get key
    		$server_encode = $this->getKey($service_id);
    		//gen api key
    		$apikey = $this->encode($server_encode . $public_key, 8);


    	}

    	return $apikey;
    }

    public function getKey($service_id)
    {
        return $this->encode(date("Y-m-d").$service_id);
    }

    
}