<?php
header('Location: ./dummyProductList.php');
exit;
include_once $_SERVER['DOCUMENT_ROOT']."/inc/inc.php";

$n1=0;
$n2=0;
$loop = 1;
for($i=0;$i<$loop;$i++){
    
    $n1++;
    
    #변수설정
    $category = rand(24,25);
    $product_condition = ($category==24) ? "U" : "N";
    $product_used_month = ($product_condition=="U") ? 2 : "";
    $randomName = random_str_generator(8);
    $price = rand(10,500) * 100;
    $endDate = date('Y-m-d', strtotime( '+'.mt_rand(0,30).' days'));
    $buy_limit_type = "M"; // 회원만 구매하기 (구매버튼 보이기)
    
    $data = '{
        "shop_no": 1,
        "request": {
            "display": "T",
            "selling": "T",
            "product_condition": "'.$product_condition.'",
            "product_used_month": '.$product_used_month.',
            "add_category_no": [
                {
                    "category_no": '.$category.',
                    "recommend": "F",
                    "new": "F"
                }
            ],
            "custom_product_code": "'.$randomName.'",
            "product_name": "Photo Card '.$randomName.'",
            "eng_product_name": "Photo Card1 '.$randomName.'",
            "supply_product_name": "Photo Card2 '.$randomName.'",
            "internal_product_name": "Photo Card3 '.$randomName.'",
            "model_name": "A1865",
            "price": "'.$price.'.00",
            "retail_price": "0.00",
            "supply_price": "'.$price.'.00",
            "has_option": "F",
            "image_upload_type": "A",
            "detail_image": "/web/product/sample/photo_f_'.rand(1,10).'.png",
            "additional_image": [
                "/web/product/sample/photo_b.png"
            ],
            "manufacturer_code": "M0000000",
            "supplier_code": "S0000000",
            "brand_code": "B0000000",
            "trend_code": "T0000000",
            "product_weight": "1.00",
            "expiration_date": {
                "start_date": "2017-09-08",
                "end_date": "'.$endDate.'"
            },
    
            "price_content": "Sample Content",
            "buy_limit_by_product": "T",
            "buy_limit_type": "M",
            "buy_group_list": [
                1
            ],
            "repurchase_restriction": "F",
            "single_purchase_restriction": "F",
            "buy_unit_type": "O",
            "buy_unit": 1,
            "order_quantity_limit_type": "O",
            "minimum_quantity": 1,
            "maximum_quantity": 0,
            "points_by_product": "T",
            "points_setting_by_payment": "C",
            "points_amount": [
                {
                    "payment_method": "cash",
                    "points_rate": "100.00",
                    "points_unit_by_payment": "W"
                },
                {
                    "payment_method": "mileage",
                    "points_rate": "10.00",
                    "points_unit_by_payment": "P"
                }
            ],
            "except_member_points": "F",
            "product_volume": {
                "use_product_volume": "T",
                "product_width": 3,
                "product_height": 5.5,
                "product_length": 7
            },
            "description": "Sample Description.",
            "mobile_description": "Sample Mobile Description.",
            "translated_description": "",
            "summary_description": "This is Product Summary.",
            "simple_description": "This is Product Description.",
            "edibot_code": "N190805_1501_1B3B6973_5603E1CA",
            "payment_info": "Sample payment info. You have to Pay.",
            "shipping_info": "Sample shipping info. You have to ship.",
            "exchange_info": "Sample exchange info. You have to exchange.",
            "service_info": "Sample service info. You have to service.",
            "hscode": "4303101990",
            "relational_product": [
                {
                    "product_no": 9,
                    "interrelated": "T"
                },
                {
                    "product_no": 10,
                    "interrelated": "F"
                }
            ],
            "shipping_scope": "A",
            "shipping_fee_by_product": "T",
            "shipping_method": "01",
            "shipping_period": {
                "minimum": 4,
                "maximum": 10
            },
            "shipping_area": "All around world",
            "shipping_fee_type": "D",
            "clearance_category_code": "ACAB0000",
            "shipping_rates": [
                {
                    "shipping_rates_min": "2000.00",
                    "shipping_rates_max": "4000.00",
                    "shipping_fee": "5000.00"
                },
                {
                    "shipping_rates_min": "4000.00",
                    "shipping_rates_max": "6000.00",
                    "shipping_fee": "2500.00"
                }
            ],
            "product_material": "Aluminum",
            "english_product_material": "Aluminum",
            "cloth_fabric": "knit",
            "classification_code": "C000000A",
            "additional_price": "1100.00",
            "margin_rate": "10.00",
            "tax_type": "A",
            "tax_rate": 10,
            "prepaid_shipping_fee": "P",
            "origin_classification": "F",
            "origin_place_no": 1798,
            "made_in_code": "KR",
            "exposure_limit_type": "A"
    
        }
    }';
    $method = 'POST';
    $sEndPointUrl = "https://".$_SESSION['mall_id'].".cafe24api.com/api/v2/admin/products";
    
    //debug($data);
    
    // 시작
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $sEndPointUrl,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $data,
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$_SESSION['access_token'],
        'Content-Type: application/json',
        'X-Cafe24-Api-Version: 2022-06-01'
      ),
    ));
    $response = curl_exec($curl);
    $response = json_decode($response,true);
    $err = curl_error($curl);
    if ($err) {
      echo 'cURL Error #:' . $err;
    } 
    // 종료
    
    if($response['error']){
        $n2++;
        $i--;
    }
    
    if($n1 > 50) break;

}

debug("loop : ".$n1);
debug("실패 : ".$n2);
debug("성공 : ".$i);

//debug($method);
//debug($sEndPointUrl);


/* products */
$method = 'GET';
$sEndPointUrl = "https://{$_SESSION['mall_id']}.cafe24api.com/api/v2/admin/products?fields=product_no,custom_product_code,product_name,price,list_image&limit=40";
$result2 = curl_call($sEndPointUrl, $method);
debug($result2);

exit;