<?php

function getir($url,$post = null)
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
	if($post!=null)
	{
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
	}
	curl_setopt($ch,CURLOPT_REFERER,TRUE);
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION,TRUE);
	//curl_setopt($ch,CURLOPT_HEADER,TRUE);
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

$file = "url.txt";
if(file_exists($file))
{
	$fp = fopen($file,"r");
	while(!feof($fp))
	{
		$satir = fgets($fp);
		$satir = str_replace(PHP_EOL,"",$satir);
		altGetir($satir);
		sleep(5);
		
	}
}
function altGetir($url)
{
	$data = getir($url);
	preg_match_all("#id=\"([0-9]+)\" href=\"(/sub/.*\.html)\"#",$data,$data2);
	$data = getir("http://www.turkcealtyazi.org".$data2[2][0]);
	preg_match_all("#<input type=\"hidden\" name=\"(idid|altid|sidid)\" value=\"([0-9]+)\"#",$data,$data3);
	preg_match_all("#<input type=\"hidden\" name=\"sidid\" value=\"([0-9a-z]+)\"#",$data,$data4);
	$postData = array("idid"=>$data3[2][0],"altid"=>$data3[2][1],"sidid"=>$data4[1][0]);
	$dosyaIsmi = str_replace(".html",".rar",basename($url));
	file_put_contents($dosyaIsmi,getir("http://www.turkcealtyazi.org/ind",http_build_query($postData)));
}
