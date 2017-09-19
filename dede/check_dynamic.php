<?php

require_once (dirname(__FILE__).'/../include/common.inc.php');
require_once(DEDEINC.'/userlogin.class.php');
require_once(DEDEINC.'/cloud.class.php');
$dynamic_code = $_POST["dynamic_code"];
$username = preg_replace("/[^0-9a-zA-Z_@!\.-]/", '', $_POST["username"]);
$is_ycuid = $dsql->GetOne("select * from `#@__admin` where userid='{$username}'");
// 创建一个实例
$secken_api = new secken();
if(is_array($is_ycuid) && !empty($is_ycuid['auth_id']) && !empty($dynamic_code)){
	$uid = $is_ycuid['auth_id'];
	$ret  = $secken_api->offlineAuth($uid,$dynamic_code);
	if ($ret['status'] == 200){//请求成功
		$admindirs = explode('/',str_replace("\\",'/',dirname(__FILE__)));
		$admindir = $admindirs[count($admindirs)-1];
		$cuserLogin = new userLogin($admindir);
		$res = $cuserLogin->checkQrUser($username);
		if($res==1){
			$cuserLogin->keepUser();
			echo "{\"flag\":\"0\",\"description\":\"".$ret['description']."\"}";
			exit();
		}else{
			echo "{\"flag\":\"2\",\"description\":\"usererror\"}";
			exit();
		}
	} else if ($ret['status'] == 604){//账号未绑定
		echo "{\"flag\":\"2\",\"description\":\"usererror\"}";
		exit();
	}else{//验证码错误
		echo "{\"flag\":\"1\",\"description\":\"".$ret['status']."\"}";
		exit();
	}
}else{//参数错误或账号未绑定
	echo "{\"flag\":\"2\",\"description\":\"usererror\"}";
	exit();
}
?>���