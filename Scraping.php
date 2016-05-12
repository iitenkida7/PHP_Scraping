<?php

/**
* It's for scraping
*
* @version	1.0
*/
class Scraping{
	// timeout of connection
	private $connect_timeout = 60;
	// timeout of requesting
	private $timeout = 60;
	// default user agent
	private $ua = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ja; rv:1.9.1.7) Gecko/20091221 Firefox/3.5.7';

	function __construct(){
	}

	/**
	* curl
	*
	* @param str $url
	* @param str $header
	* @param boolean $proxy //true => use, false => not use
	* @param int $proxy_port
	* @param str $proxy_url
	* @return json|xml|text
	*/
	public function getContentsByCurl($url, $header = '', $post_data=array(), $proxy=false, $proxy_port='', $proxy_url=''){
		$ch = curl_init($url);

		// set return data of curl_exec()
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		
		// post
		if(!empty($post_data)){
			// TRUE => sending HTTP POST
			curl_setopt($ch, CURLOPT_POST, TRUE);
                        curl_setopt($ch, CURLOPT_POSTFIELDS , $post_data);
                }

		// set default user agent
		if(empty($header)){
			$header = array('Content-Type: text/html', 'User-Agent: '.$this->ua);	
		}
		// HTTP HEADER ex) array('Content-type: text/plain', 'Content-length: 100')
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

		// timeout of connection
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connect_timeout);
		// timeout of response
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);

		// use proxy
		if($proxy==true){
			// "Off" is better.
			//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
			// port
			curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
			// proxy url
			curl_setopt($ch, CURLOPT_PROXY, $proxy_url);
		}

		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}

	/**
	* changing xml to array
	*
	* @param str $xml //xml data
	* @return array
	*/
	public function xmlToArray($xml){
		return json_decode(json_encode(simplexml_load_string($xml)), true);
	}

	/**
	* extracting the ragne text from $start to $end
	*
	* @param str $start //start
	* @param str $end //end
	* @param str $target_text //extracted text
	* @param boolean $preg_match_all //true => preg_match_all, false => preg_match
	* @param array $not_escape 
	*		$not_escape['start']==true => $start is not applied preg_quote()
	*		$not_escape['end']==true => $end is not applied preg_quote()
	* @param boolean $strip_tags_flg => //true  result text is applied strip_tags(), false is not applied it.
	*
	* @return str|array
	*/
	public function extractSpecifiedTextRange($start, $end, $target_text, $preg_match_all=false, $not_escape=array('start'=>false,'end'=>false), $strip_tags_flg=false){
		$target_text = preg_replace("/\n/", "", $target_text);

		// escape
		if($not_escape['start']==false){
			$start = preg_quote($start, '/');
		}
		if($not_escape['end']==false){
			$end = preg_quote($end, '/');
		}

		// preg_match
		if($preg_match_all==true){
			if(preg_match_all('/'.$start.'(.*?)'.$end.'/', $target_text, $matches)){
				foreach($matches[1] as $key => $val){
					$res[$key] = trim($val);
				}
			}
		}else{
			if(preg_match('/'.$start.'(.*?)'.$end.'/', $target_text, $matches)){
				$res = trim($matches[1]);
			}
		}

		// strip_tags
		if($strip_tags_flg==true){
			$res = trim(strip_tags($res));
		}

                if(empty($res)){
                        return false;
                }else{
                        return $res;
                }
	}



}
