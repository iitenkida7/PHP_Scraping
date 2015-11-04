# PHP_Scraping
php library of web scraping

###Scraping.php
  This is for scraping from html.<br>
  <br>
  _sample) getting html without proxy_<br>
  
     $scraping = new Scraping();
     
     // get html data
     $url = 'http://xxxx.com';
     $header = array('Content-Type: text/html', 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; ja; rv:1.9.1.7) Gecko/20091221 Firefox/3.5.7');
     $html = $scraping->getContentsByCurl($url, $header);
     
     print $html;

  
<br>
  _sample) getting html with proxy_<br>
  
     $scraping = new Scraping();
     
     // get html data
     $url = 'http://xxxx.com';
     $header = array('Content-Type: text/html', 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; ja; rv:1.9.1.7) Gecko/20091221 Firefox/3.5.7');
     $proxy = true;
     $proxy_port = 8080;
     $proxy_url = 'tcp://xxxxx.net';
     // if you have post_data
     $post_data = array('key' => 'value');
     $html = $scraping->getContentsByCurl($url, $header, $post_data, $proxy, $proxy_port, $proxy_url);
     
     print $html;

  
<br>
  _sample) extracting text from $start to $end(preg_match_all)_<br>
  
     $scraping = new Scraping();
     
     $target_text = '<a href="http://aaa.com">aaa</a>';
     $target_text .= '<a href="http://bbb.com">bbb</a>';
     $target_text .= '<a href="http://ccc.com">ccc</a>';
     $target_text .= '<a href="http://ddd.com">ddd</a>';
     
     $start = '<a href="';
     $end = '"';
     $preg_match_all=true;
     $result = $scraping->extractSpecifiedTextRange($start, $end, $target_text, $preg_match_all);
     
     print_r($result);
     /**
     * result
     *
     * Array(
     *		[0] => http://aaa.com
     *		[1] => http://bbb.com
     *		[2] => http://ccc.com
     *		[3] => http://ddd.com
     *	)
     */

