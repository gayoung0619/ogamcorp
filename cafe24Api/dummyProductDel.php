<?php
include_once $_SERVER['DOCUMENT_ROOT']."/inc/inc.php";
include_once $_SERVER['DOCUMENT_ROOT']."/inc/dummyNavi.php";



if($_GET['pno']){
    $product_no = array($_GET['pno']);
}else{
 
    $limit = $_GET['limit'] ? $_GET['limit'] : 1;
 
   /* products */
    $method = 'GET';
    $sEndPointUrl = "https://{$_SESSION['mall_id']}.cafe24api.com/api/v2/admin/products?fields=product_no&limit={$limit}";
    $result2 = curl_call($sEndPointUrl, $method);
    
    foreach($result2['products'] as $product){
        $product_no[] = $product['product_no'];
    }
}

foreach($product_no as $productNo){
    
    /* Delete Product */
    $method = 'DELETE';
    $sEndPointUrl = "https://{$_SESSION['mall_id']}.cafe24api.com/api/v2/admin/products/{$productNo}";
    $response = curl_call($sEndPointUrl, $method);

    debug($response);
    exit;

    $err = curl_error($curl);
    if ($err) {
      echo 'cURL Error #:' . $err;
    }

}

echo "
<script>location.href='dummyProductList.php';</script>
";

exit;