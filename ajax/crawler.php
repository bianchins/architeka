<?php

$target_url = $_REQUEST['url'];
$userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';

// make the cURL request to $target_url
$ch = curl_init();
curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
curl_setopt($ch, CURLOPT_URL,$target_url);
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$html= curl_exec($ch);
if (!$html) {
	echo "<br />cURL error number:" .curl_errno($ch);
	echo "<br />cURL error:" . curl_error($ch);
	exit;
}

// parse the html into a DOMDocument
$dom = new DOMDocument();
@$dom->loadHTML($html);

// grab all the on the page
$xpath = new DOMXPath($dom);
$metas = $xpath->evaluate("/html/head//meta");

for ($i = 0; $i < $metas->length; $i++) {
	$meta = $metas->item($i);
	$name = $meta->getAttribute('name');
	$content = $meta->getAttribute('content');
	echo "<br />Meta Tag: $name = $content";
}

// Ottengo la image_src
$images = $xpath->evaluate("/html/head//link");

for ($i = 0; $i < $images->length; $i++) {
	$link = $images->item($i);
	$rel = $link->getAttribute('rel');
	$href = $link->getAttribute('href');
	if($rel=='image_src') 
		echo "<br /><img src='$href'/>";
}

?>