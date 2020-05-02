<?php

//function getProxy() {
//	$data = json_decode(file_get_contents('http://gimmeproxy.com/api/getProxy'), 1);
//	if(isset($data['error'])) { // there are no proxies left for this user-id and timeout
//		echo $data['error']."\n";
//	} 
//	return isset($data['error']) ? false : $data['curl']; //gimmeproxy returns 'curl' field that is CURLOPT_PROXY-ready string, 
//                                                          // see curl_setopt($curl, CURLOPT_PROXY, $proxy);
//}


$proxies = array(
    "69.120.241.202:53698",
    "72.69.145.195:1080",
    "192.169.154.104:80",
    "208.67.183.240:80",
    "52.167.2.228:3128",
    "96.72.232.90:39785",
    "184.154.24.186:5836",
    "99.17.45.126:40625",
    "50.251.77.187:8080",
    "174.32.124.50:87",
    "35.230.34.45:80",
    "209.190.21.84:3128",
    "34.229.170.135:3128",
    "35.201.199.34:3128",
    "70.91.255.153:57444",
    "142.93.73.56:3128",
    "216.57.170.242:44883",
    "35.237.80.160:80",
    "47.254.22.115:8080",
    "104.139.64.202:16636",
    "67.205.154.3:80",
    "96.70.83.33:57918",
    "74.143.193.83:3128",
    "206.189.81.15:7777",
    "35.225.208.4:80",
    "34.224.60.168:3128",
    "18.218.179.160:3128",
    "40.76.24.31:80",
    "104.155.103.87:80",
    "178.128.64.241:3128"
);

if (isset($proxies)) {  // If the $proxies array contains items, then
    $proxy = $proxies[array_rand($proxies)];    // Select a random proxy from the array and assign to $proxy variable
}

echo "Proxy = " . $proxy . "<br>";


set_time_limit(0);


function curl($url) {
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
//	if($proxy = getProxy()) {
//		echo 'set proxy '.$proxy."\n";
//		curl_setopt($curl, CURLOPT_PROXY, $proxy);
//	}
    curl_setopt($curl, CURLOPT_PROXY, $proxy);
    
	$data = curl_exec($curl);
	curl_close($curl);
	return $data;
}



// Defining the basic cURL function
//set_time_limit(0);
//function curl($url) {
//    // Assigning cURL options to an array
//    $options = Array(
//        CURLOPT_RETURNTRANSFER => TRUE,  // Setting cURL's option to return the webpage data
//        CURLOPT_FOLLOWLOCATION => TRUE,  // Setting cURL to follow 'location' HTTP headers
//        CURLOPT_AUTOREFERER => TRUE, // Automatically set the referer where following 'location' HTTP headers
//        CURLOPT_CONNECTTIMEOUT => 1200,   // Setting the amount of time (in seconds) before the request times out
//        CURLOPT_TIMEOUT => 2000,  // Setting the maximum amount of time for cURL to execute queries
//        CURLOPT_MAXREDIRS => 10, // Setting the maximum number of redirections to follow
//        // CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0",
//        CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0",
//        CURLOPT_URL => $url, // Setting cURL's URL option with the $url variable passed into the function
//        CURLOPT_SSL_VERIFYPEER => false,
//        CURLOPT_SSL_VERIFYHOST => false
//    );
//    $ch = curl_init();  // Initialising cURL
//    curl_setopt_array($ch, $options);   // Setting cURL's options using the previously assigned array data in $options
//    $data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
//    curl_close($ch);    // Closing cURL
//    return $data;   // Returning the data from the function
//}

// Defining the basic scraping function
function scrape_between($data, $start, $end){
    $data = stristr($data, $start); // Stripping all data from before $start
    $data = substr($data, strlen($start));  // Stripping $start
    $stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
    $data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
    return $data;
}
?>