<?php
session_start();
include_once "../inc/cafe24_env.php";

$sAcctoken = $_SESSION['access_token'];      //3번에서 발급 받은 access_token 값
$sEndPointUrl = "https://{$mallid}.cafe24api.com/api/v2/admin/products?limit=1";
$sVersion = $version; // 적용할 버전

// 이하 공통
$oCurl = curl_init();
curl_setopt_array($oCurl, array(
    CURLOPT_URL            => $sEndPointUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => array(
        'Authorization: Bearer ' . $sAcctoken,
        'X-Cafe24-Api-Version: ' . $sVersion
    )
));
$sResponse = curl_exec($oCurl);
// API 호출이 정상인지 출력해보기

print_r($sResponse);
exit;
