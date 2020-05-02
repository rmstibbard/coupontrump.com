<?php
function getProxy() {
	$data = json_decode(file_get_contents('http://gimmeproxy.com/api/getProxy'), 1);
	if(isset($data['error'])) { // there are no proxies left for this user-id and timeout
		echo $data['error']."\n";
	} 
	return isset($data['error']) ? false : $data['curl']; //gimmeproxy returns 'curl' field that is CURLOPT_PROXY-ready string, see curl_setopt($curl, CURLOPT_PROXY, $proxy);
}
/**
 * Makes each request with new proxy
 */
function get($url) {
	$curlOptions = array(
		CURLOPT_CONNECTTIMEOUT => 5, // connection timeout, seconds
		CURLOPT_TIMEOUT => 10, // total time allowed for request, second
		CURLOPT_URL => $url,
		CURLOPT_SSL_VERIFYPEER => false, // don't verify ssl certificates, allows https scraping
		CURLOPT_SSL_VERIFYHOST => false, // don't verify ssl host, allows https scraping
		CURLOPT_FOLLOWLOCATION => true, // follow redirects
		CURLOPT_MAXREDIRS => 9, // max number of redirects
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_HEADER => 0,
		CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36",
		CURLINFO_HEADER_OUT  => true,
	);
	$curl = curl_init();
	curl_setopt_array($curl, $curlOptions);
	if($proxy = getProxy()) {
		echo 'set proxy '.$proxy."\n";
		curl_setopt($curl, CURLOPT_PROXY, $proxy);
	}
	$data = curl_exec($curl);
	curl_close($curl);
	return $data;
}
while(true) {
    $data = get('https://news.ycombinator.com/');
    if(trim($data) && stripos($data, 'Hacker News') !== false) {
        echo "hacker news works fine";
        break;
    } else {
        echo "hacker news banned us, try another proxy\n";
    }
}
?>