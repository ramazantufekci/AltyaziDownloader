<?php


function getir($url)
{
	$headers = [
		'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
		'Accept-Language: tr-TR,tr;q=0.8,en-US;q=0.5,en;q=0.3'
	];
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0');
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION,TRUE);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
	curl_setopt($ch,CURLOPT_VERBOSE,TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch,CURLOPT_AUTOREFERER,TRUE);
	curl_setopt($ch,CURLOPT_REFERER,TRUE);
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION,TRUE);
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
$url5 = array();
$durum = 2;
pushAr(parse(getir("http://www.turkcealtyazi.org/filtre.php?yil=2018&sira=3")));
while($durum<10)
{
	pushAr(parse(getir("http://www.turkcealtyazi.org/filtre.php?yil=2018&sira=3&p=".$durum)));
	sleep(5);
	$durum++;
}
foreach($url5 as $url4)
{
	file_put_contents("url.txt","http://www.turkcealtyazi.org".$url4.PHP_EOL,FILE_APPEND);
}
function parse($ptr)
{
	preg_match_all("#<a href=\"/mov/.*\.html\" title=\"[a-zA-Zöçşiğüı\s-\?:]+\"><span style=\"font-size:15px\">.*</span></a>#",$ptr,$data3);
	return $data3;
}

function pushAr($push)
{
	global $url5;
	foreach($push[0] as $value)
	{
		preg_match("#/mov/.*\.html#",$value,$data4);
		array_push($url5,$data4[0]);
		
	}
}


