<?php
include_once "../inc/function.php";
include_once "../inc/cafe24_env.php";

$sMallID = $_GET['mallid'];
$type = $_GET['type'] ? $_GET['type'] : 'Ogam';
$sClientID = $client_id;
$sAuthCodeReceiveUrl = $redirect_uri[$type];   // 개발자 센터 Redirect URL(s)에 등록된, 응답받을 인증코드를 처리할 url
$sScope = 'mall.read_personal,mall.read_category,mall.read_product,mall.write_product,mall.read_customer,mall.write_customer,mall.read_order,mall.write_order,mall.read_category'; // 예시) 상품분류 (읽기권한), 상품 (읽기+쓰기권한)
$aState = array(
    'mall_id' => $sMallID,         // 고정
    'type' => $type  //'{임의값a}'  => '{임의값b}'       // 코드발급 이후 처리에 필요한 값 필요시 추가
);
// 이하 공통
$sAuthCodeRequestUrl = sprintf("https://%s.cafe24api.com/api/v2/oauth/authorize?", $sMallID);

$aRequestData = array(
    'response_type' => 'code',
    'client_id'     => $sClientID,
    'state'         => base64_encode(json_encode($aState)),
    'redirect_uri'  => $sAuthCodeReceiveUrl,
    'scope'         => $sScope,
);
$sUrl = $sAuthCodeRequestUrl . http_build_query($aRequestData);

header('Location: ' . $sUrl);