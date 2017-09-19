<?php
function litimgurls($imgid=0)
{
    global $lit_imglist,$dsql;
    //获取附加表
    $row = $dsql->GetOne("SELECT c.addtable FROM #@__archives AS a LEFT JOIN #@__channeltype AS c 
                                                            ON a.channel=c.id where a.id='$imgid'");
    $addtable = trim($row['addtable']);
    
    //获取图片附加表imgurls字段内容进行处理
    $row = $dsql->GetOne("Select imgurls From `$addtable` where aid='$imgid'");
    
    //调用inc_channel_unit.php中ChannelUnit类
    $ChannelUnit = new ChannelUnit(2,$imgid);
    
    //调用ChannelUnit类中GetlitImgLinks方法处理缩略图
    $lit_imglist = $ChannelUnit->GetlitImgLinks($row['imgurls']);
    
    //返回结果
    return $lit_imglist;
}
//删除文章同时删除图片关键代码段
function GetPicsTruePath($body,$litpic) //解析body数据，获得所有图片的绝对地址 
{ 
  $delfiles = array();//存储图片地址数据 
  if(!empty($litpic)) 
  { 
    $litpicpath = GetTruePath(); 
    $litpicpath .= $litpic; 
    $delfiles[] = $litpicpath;//缩略图地址 
  } 
  preg_match_all("/src=[\"|'|\S|\s]([^ |\/|>]*){0,}(([^>]*)\.(gif|jpg|png))/isU",$body,$tmpdata); 
  $picspath = array_unique($tmpdata[2]);//body中所有图片的地址 
  foreach($picspath as $tmppath) 
  { 
    $path = GetTruePath();//获得绝对路径 
    $picpath = preg_replace("/[a-zA-z]+:\/\/[^ |\/|\s]*/",'',$tmppath);//去掉网址部分 
    $path .=$picpath; 
    $delfiles[] = $path;//保存处理后的数据 
  } 
  return $delfiles; 
} 

function WriteToDelFiles($msg)//删除文章的时候会通过此函数记录日志 
{ 
  if(empty($msg)) $savemsg="未获得消息"; 
  else $savemsg = $msg; 
  $errorFile = dirname(__FILE__).'/../data/del_body_file.txt';//删除记录文件 
  $fp = @fopen($errorFile, 'a'); 
  @fwrite($fp,"\r\n{$savemsg}"); 
  @fclose($fp); 
} 

//获得文章Body数据 
function GetArcBody($aid) 
{ 
  global $dsql; 
  $query = "SELECT #@__addonarticle.body FROM #@__addonarticle WHERE #@__addonarticle.aid = '$aid'"; 
  $row = $dsql->GetOne($query); 
  if(is_array($row)) return $row; 
  else return false; 
}
