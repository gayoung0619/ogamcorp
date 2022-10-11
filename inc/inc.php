<?php
session_start();
date_default_timezone_set('Asia/Seoul');
include_once $_SERVER['DOCUMENT_ROOT']."/inc/cafe24_env.php";
include_once $_SERVER['DOCUMENT_ROOT']."/inc/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/inc/ClassPDO.php";


/* DB에서 최신 mall_id 불러오기 */
if(!$_SESSION['access_token']){
    
    $sql = "select * from cafe24_token order by id desc limit 1 ";
    $ret = $NDO->prepare($sql);
    $ret->execute();
    $token = $ret->fetch(PDO::FETCH_ASSOC);

    $_SESSION['mall_id']=$token['mall_id'];
    $_SESSION['access_token']=$token['access_token'];
    $_SESSION['expires_at']=$token['expires_at'];
    $_SESSION['refresh_token']=$token['refresh_token'];
    $_SESSION['refresh_token_expires_at']=$token['refresh_token_expires_at'];
}


/* token 유효성 체크 (만료 10초전) */
$expires_at = date('YmdHis',strtotime($_SESSION['expires_at']));
$today_at = date('YmdHis',time()+10);

if($expires_at < $today_at){

    /* refresh token 유효성 체크 (만료 10초전) */
    if($_SESSION['refresh_token_expires_at'] < date('YmdHis',time()+10)){
        $token_data = "grant_type=refresh_token&refresh_token={$_SESSION['refresh_token']}";
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://{$_SESSION['mall_id']}.cafe24api.com/api/v2/oauth/token",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $token_data,
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic {$authorization_basic}",
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response,ture);
        debug($response);
        
        if($response['access_token']){

            $_SESSION['mall_id']=$response['mall_id'];
            $_SESSION['access_token']=$response['access_token'];
            $_SESSION['expires_at']=$response['expires_at'];
            $_SESSION['refresh_token']=$response['refresh_token'];
            $_SESSION['refresh_token_expires_at']=$response['refresh_token_expires_at'];
            
            // DB 저장
            $scopes = implode("|",$response['scopes']);
            $sql = "
        		INSERT INTO
        		    cafe24_token
        		SET
        		    access_token = '".$response['access_token']."'
                    ,expires_at = '".$response['expires_at']."'
                    ,refresh_token = '".$response['refresh_token']."'
                    ,refresh_token_expires_at = '".$response['refresh_token_expires_at']."'
                    ,client_id = '".$response['client_id']."'
                    ,mall_id = '".$response['mall_id']."'
                    ,user_id = '".$response['user_id']."'
                    ,scopes = '".$scopes."'
                    ,shop_no = '".$response['shop_no']."'
                    ,issued_at = '".$response['issued_at']."'
        	";
        	$ret = $NDO->prepare($sql);
        	$ret->execute();            
        }

    }

    else{
        exit('토큰이 만료되었습니다. 재인증 받아주시기 바랍니다.');
    }
}