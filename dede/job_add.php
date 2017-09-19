<?php
require(dirname(__FILE__)."/config.php");
CheckPurview('temp_Other');
if(empty($dopost)) $dopost = '';

if($dopost=='save')
{
	$sendtime = GetMkTime($sendtime);
	$exptime = GetMkTime($exptime);
	
		$query = "Insert into `#@__jobs`(`jobname`,`neednum`,`needpart`,`linkman`,`linktel`,`email`,`address`,`sendtime`,`exptime`,`jobneed`,`msg`) 
				Values('$jobname','$neednum','$needpart','$linkman','$linktel','$email','$address','$sendtime','$exptime','$jobneed','$msg')";
		$dsql->ExecuteNoneQuery($query);
	
	
	ShowMsg('成功增加一条招聘信息！', 'job_main.php');
	exit();
}

$startDay = time();
$endDay = AddDay($startDay,30);
$startDay = GetDateTimeMk($startDay);
$endDay = GetDateTimeMk($endDay);
include DedeInclude('templets/job_add.htm');

?>