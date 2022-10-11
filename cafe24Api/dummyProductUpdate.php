$release_date<?php
include_once $_SERVER['DOCUMENT_ROOT']."/inc/inc.php";
include_once $_SERVER['DOCUMENT_ROOT']."/inc/dummyNavi.php";


/* 변수설정 */
$randomName = random_str_generator(8); // 임시 포토카드ID

/* 플리 제공변수*/
$shop_no = 1;
$custom_product_code = $randomName; // 포토카드 ID
$product_name = "포토카드 -".$randomName; // 포토카드명 - 한국어/영
$detail_image = '/web/product/sample/photo_f_'.rand(1,10).'.png'; // 앞면 이미지 바이너리
$additional_image = "web/product/sample/photo_b.png"; // 뒷면 이미지 바이너리  (현재오류 해결후 추가 작업)

$product_no = $_GET['pno'];

if(!$product_no){
    exit('상품번호를 확인해주세요');
}

$airtist = "아티스트 - ".$randomName; // 아티스트명 - 6개 국어
$airtist_member = "멤버 - ".$randomName; // 멤버명[] - 6개 국어
$release_date = "2000-01-01"; // 출시일
$event = "행사/앨범"; // 행사/앨범
$memo = "기타메모"; // 기타메모
$hash_tag = "해시태그"; // 해시태그-  한국어/영어
$search = $hash_tag;

$data = '{
    "shop_no": '.$shop_no.',
    "request": {
        "custom_product_code": "'.$custom_product_code.'",
        "product_name": "'.$product_name.'",
        "eng_product_name": "Photo Card1 '.$randomName.'",
        "image_upload_type": "A",
        "detail_image": "'.$detail_image.'",
        "additional_image": [
            "'.$additional_image.'"
        ],
        "additional_information" : [
            {
                "key": "custom_option1",
                "value": "'.$airtist_member.'"
            },
            {
                "key": "custom_option4",
                "value": "'.$airtist.'"
            },
            {
                "key": "custom_option6",
                "value": "'.$event.'"
            },
            {
                "key": "custom_option7",
                "value": "'.$memo.'"
            },
            {
                "key": "custom_option8",
                "value": "'.$hash_tag.'"
            }
        ],
        "release_date" : "'.$release_date.'"
    }
}';

$sEndPointUrl = "https://".$_SESSION['mall_id'].".cafe24api.com/api/v2/admin/products/".$product_no;



// 시작
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $sEndPointUrl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_POSTFIELDS => $data,
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer '.$_SESSION['access_token'],
    'Content-Type: application/json',
    'X-Cafe24-Api-Version: 2022-06-01'
  ),
));
$response_org = curl_exec($curl);
$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

debug($http_code);
debug($response_org);

$response = json_decode($response_org,true);
filelog('productUpdate',$http_code." : ".$response['product']['product_no']." - ".$sEndPointUrl); // 파일로그 남기기 #01


$err = curl_error($curl);
if ($err) {
  filelog('productUpdate',$err); // 실패 파일로그 남기기 #02
  echo 'cURL Error #:' . $err;
}

else if($http_code!='201' || !$response['product']['product_no']){
    filelog('productUpdate',$response_org); // 실패 파일로그 남기기 #02
    
    debug($data);
    debug("Response");
    debug($response);
    exit;
}
// 종료





debug($data);
debug("Response");
debug($response);
//echo "<script>location.href='dummyProductList.php';</script>";
echo "
    <a href='dummyProductList.php?limit=1&pno=".$product_no."';>상품보기</a>
";


exit;