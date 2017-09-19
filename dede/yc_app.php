<?php

require_once(dirname(__FILE__)."/config.php");
require_once DEDEINC."/arc.partview.class.php";
if(empty($dopost)) $dopost = "";

if($dopost=="saveedit")
{
	require_once DEDEINC.'/request.class.php';
	$request = new Request();
	$request->Init();
    $id = preg_replace("#[^0-9]#", "", $request->Item('id', 0));
	$logintype = $request->Item('logintype', '');
    $query = "UPDATE `#@__ycapp` SET logintype='$logintype' WHERE id='1' ";
    $dsql->ExecuteNoneQuery($query);
    ShowMsg("成功更改登录参数！",'yc_app.php');
    exit();
}
$userid = $cuserLogin->getUserID();
$is_bduid = $dsql->GetOne("select auth_id,userid from `#@__admin` where id='{$userid}'");
$myData = $dsql->GetOne("SELECT * FROM `#@__ycapp` WHERE id='1'");
include DedeInclude('templets/yc_app.htm');���