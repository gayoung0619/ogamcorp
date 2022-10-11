<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/inc/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/inc/cafe24_env.php";
include_once $_SERVER['DOCUMENT_ROOT']."/inc/ClassPDO.php";

foreach($_GET as $key => $get){
    echo "{$key} = {$get}<br>";
}
/*
is_multi_shop = T
lang = ko_KR
mall_id = ogamcorp
nation = KR
shop_no = 1
timestamp = 1658670191
user_id = ogamcorp
user_name = 홍태원
user_type = P
hmac = zECrr/790Kkt+zdPY9my+7At236caYoMxmfPy8jUPjI=
*/

$_mall_id = $_GET['mall_id'] ? $_GET['mall_id'] : 'danalentermarket';
?>

<div>
     <br> - 앱실행 완료 - <br>
    <p> <a href="AuthorizeAccess.php?mallid=<?=$_mall_id?>"> 오감 인증</a> </p>
    <p> <a href="AuthorizeAccess.php?mallid=<?=$_mall_id?>&type=BE"> B/E 인증</a> </p>
    <p> <a href="AuthorizeAccess.php?mallid=<?=$_mall_id?>&type=FE"> F/E 인증</a> </p>
    <?if($_SERVER['REMOTE_ADDR']=='211.109.227.238'){?>
    <p> <a href="AuthorizeAccess.php?mallid=<?=$_mall_id?>&type=TEST"> 테스트</a> </p>
    <?}?>
</div>