<?php

require_once (dirname(__FILE__).'/../include/common.inc.php');
require_once(DEDEINC.'/userlogin.class.php');
require_once(DEDEINC.'/cloud.class.php');
$event_id = $_POST["event_id"];

// 创建一个实例
$secken_api = new secken();

if(empty($event_id)){
	// 获取二维码请求身份认证
	$qrret  = $secken_api->getAuth();
	if($qrret['status'] ==200){
		echo "{\"flag\":\"4\",\"event_id\":\"".$qrret['event_id']."\",\"qrcode_url\":\"".$qrret['qrcode_url']."\"}";
		exit;
	}else{//二维码获取失败
		echo "{\"flag\":\"1\",\"event_id\":\"".$event_id."\"}";
		exit;
	}
}else{// 验证身份认证请求
	$ret  = $secken_api->getEventResult($event_id);
	// 返回请求结果
	if ( $ret['status'] == 200 ){//请求成功
		$ret_uid = $ret['uid'];
		//判断绑定
    	$is_ycuid = $dsql->GetOne("select id,userid,usertype from `#@__admin` where auth_id='{$ret_uid}'");
		if(is_array($is_ycuid)){//用户已经绑定则完成登录
			//登录检测
			$admindirs = explode('/',str_replace("\\",'/',dirname(__FILE__)));
			$admindir = $admindirs[count($admindirs)-1];
			$cuserLogin = new userLogin($admindir);
			$res = $cuserLogin->checkQrUser($is_ycuid['userid']);
			if($res==1){
				$cuserLogin->keepUser();
				echo "{\"flag\":\"0\",\"event_id\":\"".$event_id."\"}";
				exit();
			}else{
				echo "{\"flag\":\"2\",\"event_id\":\"".$event_id."\"}";
				exit();
			}
    	}else {//用户未绑定则登录失败
			echo "{\"flag\":\"2\",\"event_id\":\"".$event_id."\"}";
			exit();
		}
	}else if($ret['status'] == 601){//用户拒绝授权
		echo "{\"flag\":\"300055\",\"event_id\":\"".$event_id."\"}";
		exit;
	}else if($ret['status'] == 605){//未授权
		echo "{\"flag\":\"3\",\"event_id\":\"".$event_id."\"}";
		exit();
	}else if($ret['status'] == 602){//等待授权
		echo "{\"flag\":\"4\",\"event_id\":\"".$event_id."\"}";
		exit();
	}else{
		$qrret  = $secken_api->getAuth();
		if($qrret['status'] ==200){
			echo "{\"flag\":\"4\",\"event_id\":\"".$qrret['event_id']."\",\"qrcode_url\":\"".$qrret['qrcode_url']."\"}";
			exit;
		}else{//二维码获取失败
			echo "{\"flag\":\"1\",\"event_id\":\"".$event_id."\"}";
			exit;
		}
	}
}
?>���