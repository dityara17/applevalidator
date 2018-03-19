<?php
date_default_timezone_get();
error_reporting(E_ALL ^ E_DEPRECATED);

function getStr($string,$start,$end){
	$str = explode($start,$string);
	$str = explode($end,$str[1]);
	return $str[0];
}
function inStr($s, $as){
    $s = strtoupper($s);
    if(!is_array($as)) $as=array($as);
    for($i=0;$i<count($as);$i++) if(strpos(($s),strtoupper($as[$i]))!==false) return true;
    return false;
}
function GenerateSessionID($length = 10) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomsessionid = '';
    for ($i = 0; $i < $length; $i++) {
        $randomsessionid .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomsessionid;
}
$date = date('m/d/Y h:i:s a', time());

$session = 'TC-'.GenerateSessionID(4);
$banner = "


  _                  _                           ___      _      
 | |                | |                         / _ \    | |     
 | |_ ___  __ _  ___| |__   ___ _ __ ______ ___| | | | __| | ___ 
 | __/ _ \/ _` |/ __| '_ \ / _ \ '__|______/ __| | | |/ _` |/ _ \
 | ||  __/ (_| | (__| | | |  __/ |        | (__| |_| | (_| |  __/
  \__\___|\__,_|\___|_| |_|\___|_|         \___|\___/ \__,_|\___|
                                                                 
                                                                 
Coded by: FrenZY
Session ID : {$session}
Data and Time : {$date} 
=====================================================================
\n";

print($banner);

$list = $argv[1];
$codelist = file_get_contents($list);
$codeline = preg_split("/\\r\\n|\\r|\\n/", $codelist);
$count = count($codeline);
$i = 0;

while($i < $count){
	$email = $codeline[$i];
	$dataemail = urlencode($email);
	
	// Step 1
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_TIMEOUT, 600);
	$fp = fopen('cookies/'.md5('SGBTeam').'.txt','wb');fclose($fp);
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies/'.md5('SGBTeam').'.txt');
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies/'.md5('SGBTeam').'.txt');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0",
		"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
		"Accept-Language: en-US,en;q=0.5",
	));
	curl_setopt($ch, CURLOPT_URL, "https://ams.apple.com/");
	$getgugi = curl_exec($ch);
	$nulisgugi = @fopen('gugi/'.md5('SGBTeam').'.txt', "wb");
	fwrite($nulisgugi, $getgugi);
	fclose($nulisgugi);
	
	$loadgugi = file_get_contents('gugi/'.md5('SGBTeam').'.txt');
	$jess = getStr($loadgugi, 'JSESSIONID=', ';');
	
	// Step 2
	$data = 'SignUpForm=SignUpForm&SignUpForm%3AemailField='.$dataemail.'&SignUpForm%3AblueCenter=Continue&javax.faces.ViewState=j_id1';
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
		"Accept-Language: en-US,en;q=0.5",
		"Connection: keep-alive",
		"Content-Type: application/x-www-form-urlencoded",
		'Cookie: s_pathLength=access"%"20management"%"3D2"%"2C; s_invisit_n2_us=0; s_vnum_n2_us=0|1; s_vi=[CS]v1|2D430FA8052E0B88-40002C34600008B0[CE]; JSESSIONID='.$jess.'; s_cc=true; s_ria=Flash"%"20Not"%"20Detected"%"7C; s_sq=applewwaccessmanagement"%"3D"%"2526pid"%"253Dams"%"252520-"%"252520signup"%"2526pidt"%"253D1"%"2526oid"%"253DContinue"%"2526oidt"%"253D3"%"2526ot"%"253DSUBMIT',
		"Host: ams.apple.com",
		"Referer: https://ams.apple.com/",
		"Upgrade-Insecure-Requests: 1",
		"User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0"
	));
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_URL, 'https://ams.apple.com/pages/SignUp.jsf;jsessionid='.$jess);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$reso = curl_exec($ch);
	$nulisrez = @fopen('gugi/gugi.txt', "wb");
	fwrite($nulisrez, $reso);
	fclose($nulisrez);
	
	$loadgugis = file_get_contents('gugi/gugi.txt');
	$jessnolimit = getStr($loadgugis, 'JSESSIONID=', ';');
	
	// Step 3
	$data = 'SignUpForm=SignUpForm&SignUpForm%3AemailField='.$dataemail.'&SignUpForm%3AblueCenter=Continue&javax.faces.ViewState=j_id1';
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
		"Accept-Language: en-US,en;q=0.5",
		"Connection: keep-alive",
		"Content-Type: application/x-www-form-urlencoded",
		'Cookie: s_pathLength=access"%"20management"%"3D2"%"2C; s_invisit_n2_us=0; s_vnum_n2_us=0|1; s_vi=[CS]v1|2D430FA8052E0B88-40002C34600008B0[CE]; JSESSIONID='.$jessnolimit.'; s_cc=true; s_ria=Flash"%"20Not"%"20Detected"%"7C; s_sq=applewwaccessmanagement"%"3D"%"2526pid"%"253Dams"%"252520-"%"252520signup"%"2526pidt"%"253D1"%"2526oid"%"253DContinue"%"2526oidt"%"253D3"%"2526ot"%"253DSUBMIT',
		"Host: ams.apple.com",
		"Referer: https://ams.apple.com/",
		"Upgrade-Insecure-Requests: 1",
		"User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0"
	));
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_URL, 'https://ams.apple.com/pages/SignUp.jsf');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$res = curl_exec($ch);
	if(inStr($res, "already registered")){
		print('['.$email.'] => Valid Apple'."\n");
		$nulislive = @fopen('['.$session.'] Live.txt', "a");
		fwrite($nulislive, $email."\n");
		fclose($nulislive);
	} else {
		print('['.$email.'] => Die'."\n");
	}
	/* debug
	print($res);
	$nulisres = @fopen('gugi/r3z.txt', "wb");
	fwrite($nulisres, $res);
	fclose($nulisres);*/
	
	$i++;
}