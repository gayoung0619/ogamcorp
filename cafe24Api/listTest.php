<?php
include_once $_SERVER['DOCUMENT_ROOT']."/inc/inc.php";
include_once $_SERVER['DOCUMENT_ROOT']."/inc/dummyNavi.php";

/* category */
$method = 'GET';
$sEndPointUrl = "https://{$_SESSION['mall_id']}.cafe24api.com/api/v2/admin/categories?fields=shop_no,category_no,category_name";
$responseCate = curl_call($sEndPointUrl, $method);
debug($responseCate);


/* products */
$limit=4;
$method = 'GET';

$fields = "&fields=product_no,product_code,custom_product_code,product_name,list_image,category_no,display,selling";
$where = "&display=F&selling=F";

$sEndPointUrl = "https://{$_SESSION['mall_id']}.cafe24api.com/api/v2/admin/products?limit={$limit}{$fields}{$where}";

echo $sEndPointUrl;

$response = curl_call($sEndPointUrl, $method);


if($limit==1) debug($response);
?>
<br>
<div>
    <?foreach($response['products'] as $product){?>
    <div style="display:inline-block;width:300px;">
        <div><img src="<?=$product['list_image']?>"></div>
        <div>
            product_no : <?=$product['product_no']?> 
            <span>CA:<?=$product['category_no']?> </span>
            <a href="dummyProductList.php?limit=1&pno=<?=$product['product_no']?>">보기</a>
            <a href="dummyProductDel.php?pno=<?=$product['product_no']?>">삭제</a>
            </div>
        <div>product_code : <?=$product['product_code']?></div>
        <div>custom_product_code : <?=$product['custom_product_code']?></div>
        <div>product_name : <?=$product['product_name']?></div>
        <div>display : <?=$product['display']?></div>
        <div>selling : <?=$product['selling']?></div>
    </div>
    <?}?>
</div>