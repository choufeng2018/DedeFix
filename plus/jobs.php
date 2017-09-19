<?php
require_once(dirname(__FILE__)."/../include/common.inc.php");
require_once(DEDEINC.'/datalistcp.class.php');
$tmpfile =  DEDETEMPLATE.'/plus/jobs_list.htm';
$sql= "select * From `#@__jobs`  order by id desc";
    $dlist = new DataListCP();
    $dlist->pageSize = 10;
    $dlist->SetTemplate(DEDETEMPLATE.'/plus/jobs_list.htm');
    $dlist->SetSource($sql);
    $dlist->Display();
exit();
?>