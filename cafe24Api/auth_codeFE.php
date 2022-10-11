<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/inc/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/inc/cafe24_env.php";
include_once $_SERVER['DOCUMENT_ROOT']."/inc/ClassPDO.php";

if(!$_GET['code']){
    echo "error : {$_GET['error']} <br>";
    echo "error_description : {$_GET['error_description']} <br>";
    echo "state : {$_GET['state']} <br>";
    echo "trace_id : {$_GET['trace_id']} <br>";
    exit;
}



$sClientId = $client_id;
$sClientSecret = $client_secret;
$sThisUrl = $redirect_uri['FE'];   // https:// 사용
$sCode = $_REQUEST['code'];//2번 응답의 'code'
$sStatus = $_REQUEST['state'];//2번 응답의 'state'
// 이하 공통
$aStatue = json_decode(base64_decode($sStatus), true);
debug('FE');
debug($aStatue);
$aFields = array(
    'grant_type'   => 'authorization_code',
    'code'         => $sCode,
    'redirect_uri' => $sThisUrl
);
$oCurl = curl_init();
curl_setopt_array($oCurl, array(
    CURLOPT_URL            => 'https://' . $aStatue['mall_id'] . '.cafe24api.com/api/v2/oauth/token',
    CURLOPT_POSTFIELDS     => http_build_query($aFields),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => array(
        'Authorization: Basic ' . base64_encode($sClientId . ':' . $sClientSecret)
    )
));
$sResponse = curl_exec($oCurl);
// 정상 토큰발급 응답인지 확인용 출력해보기

$arr=json_decode($sResponse,true);
debug($arr);

if($arr['access_token']){
    
    // 액세스 토큰 세션
    $_SESSION['mall_id']=$arr['mall_id'];
    $_SESSION['access_token']=$arr['access_token'];
    $_SESSION['expires_at']=$arr['expires_at'];
    $_SESSION['refresh_token']=$arr['refresh_token'];
    $_SESSION['refresh_token_expires_at']=$arr['refresh_token_expires_at'];
    
    // DB 저장
    $scopes = implode("|",$arr['scopes']);
    $sql = "
		INSERT INTO
		    cafe24_token
		SET
		    access_token = '".$arr['access_token']."'
            ,expires_at = '".$arr['expires_at']."'
            ,refresh_token = '".$arr['refresh_token']."'
            ,refresh_token_expires_at = '".$arr['refresh_token_expires_at']."'
            ,client_id = '".$arr['client_id']."'
            ,mall_id = '".$arr['mall_id']."'
            ,user_id = '".$arr['user_id']."'
            ,scopes = '".$scopes."'
            ,shop_no = '".$arr['shop_no']."'
            ,issued_at = '".$arr['issued_at']."'
	";
	$ret = $NDO->prepare($sql);
	$ret->execute();
}