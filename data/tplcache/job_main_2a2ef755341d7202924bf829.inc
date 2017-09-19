<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>招聘信息管理</title>
<link type="text/css" rel="stylesheet" href="css/base.css"/>

<script language='javascript'>
function Sel(stype)
{
	  for(var i=0;i < document.getElementsByName('aids').length;i++)
	  {
		  if(stype=='all') document.getElementsByName('aids')[i].checked=true;
		  else document.getElementsByName('aids')[i].checked=false;
	  }
}
function checkSubmit()
{
	var str = '';
	for(var i=0;i < document.getElementsByName('aids').length;i++)
	{
		  if(document.getElementsByName('aids')[i].checked){
		  	if(str=='') str += document.getElementsByName('aids')[i].value;
		  	else str += ',' + document.getElementsByName('aids')[i].value;
		  }
	}
	if(str=='')
	{
		alert('你没选择任何内容！');
		return false;
	}
	else
	{
		location="job_edit.php?aids="+str+"&dopost=delall";
	}
}
</script>

</head>
<body>

<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="28" background="images/tbg.gif" colspan="8" style="padding-left:10px;">
  <div style="float:left">
  	<b>招聘信息管理</b>&nbsp;[<a href="job_add.php"><u>增加新招聘信息</u></a>]
	</div>
	
  </td>
</tr>
</table >



<form name='form1' method='post' action='job_edit.php' onSubmit='return checkSubmit();'>
  <input type='hidden' name='dopost' value='delall'/>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
    
   <tr align="center" bgcolor="#FBFCE2" height="26">
       <td  align="center">选择</td>
        <td  align="center">职位名称</td>
        <td  align="center">部门</td>
   
        <td  align="center">发布时间</td>
        <td  align="center">过期时间</td>
        <td  align="center">管理</td>
      </tr>
    <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?>
     <tr  align="center" bgcolor="#FFFFFF" height="26" onMouseMove="javascript:this.bgColor='#FCFDEE';"
        	 onMouseOut="javascript:this.bgColor='#FFFFFF';">
      <td><input type='checkbox' name='aids' value='<?php echo $fields['id']; ?>' class='np' /></td>
      <td><a href='job_edit.php?id=<?php echo $fields['id']; ?>&dopost=getedit'><?php echo $fields['jobname']; ?></a></td>
      <td><?php echo $fields['needpart']; ?></td>
      <td class="fs_11"><?php echo GetDateTimeMk( $fields['sendtime']); ?></td>
      <td class="fs_11"> <?php echo GetDateTimeMk($fields['exptime']); ?></td>
      <td class="ta_r"><a href='job_edit.php?id=<?php echo $fields['id']; ?>&dopost=getedit'>[更改]</a> <a href='job_edit.php?id=<?php echo $fields['id']; ?>&dopost=delete'>[删除]</a></td>
    </tr>
    <?php
}
}?>
    <tr bgcolor="#ffffff" height="28">
      <td colspan="7">
 <button type="button" class="btn1s" _click="allSelect">全选</button>
          <button type="button" class="btn1s" _click="unSelect">反选</button>
          <button class="btn1s" type="button" onclick='checkSubmit()'>批量删除</button>
      </tr>
    
   
	<tr align="center" bgcolor="#F9FCEF" height="28">
      <td colspan="6"><?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listsize'] = '6';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
     </tr>
  </table>
</form>
</body>
</html>