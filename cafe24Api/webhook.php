<?php
date_default_timezone_set('Asia/Seoul');
include_once $_SERVER['DOCUMENT_ROOT']."/inc/cafe24_env.php";
include_once $_SERVER['DOCUMENT_ROOT']."/inc/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/inc/ClassPDO.php";

$jsonData = file_get_contents('php://input', true);
$data = $jsonData;

if($data){

    // DB 저장
    $sql = "
    	INSERT INTO
    	    cafe24_webhook
    	SET
    	    data = '".$data."'
    ";
    $ret = $NDO->prepare($sql);
    $ret->execute();

}
exit;