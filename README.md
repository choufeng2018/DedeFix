##基于dedecms v5.7 最新版本相应的功能开发，SEO优化

> 安装好后，请把data/dede.sql文件导入mysql库
* 后台栏目加入`栏目图片`功能
* 后台表单列表`解决无法显示联动类型`的bug
* 去除后台`系统帮助`菜单
* 保留后台`德得广告模块`,以方便站长投放广告
* 后台加入删除文章同时`删除文章图片`的功能
* 后台加入`人才招聘`模块
* 文章发布加入`密码验证`，可改为付费阅读
* 加入一个`民情调研`模板mq(模板已发行)
* 2018/04/25 去除include/inc/inc_fun_funAdmin.php ` SpGetNewInfo()`获取更新信息的代码
* 2018/04/26 新增`字母列表序列A-Z的文章SEO页面索引`功能，并使用nginx路由重写为静态页面
* 2018/04/16 新增`city页面，用以索引会员资料页面`，形成`seo专题`页面 
* 2018/05/10 修正后台`顶级目录`编辑后，会导致`下级栏目`隐藏栏目自动恢复`未隐藏`状态的bug `最新源码资料尚未传送至github`
* 2018/05/10 修复`搜索页调用文章列表无法使用arclist标签`bug  
* 2018/05/14 给`arclist标签`增加`notypeid`参数，用来排除栏目文章  `最新源码资料未传送至github`
* 2018/06/07 给专题页面增加了伪静态插件，`系统配置-核心设置-开启伪静态`专题详情页面url改为/topic/{aid}.html 修改于文件/include/helpers/channelunit.helper.php   增加一段代码 //start `文章页面完美伪静态化`
* 2018/06/08 文件/include/helpers/channelunit.helper.php   增加一段修正栏目伪静态的url`模拟静态化url`，需要在nginx.conf或者.htaccess文件中加入伪静态规则
* 2018/06/11 /include/arc.archives.class.php中function _highlight函数修复关键词替换的bug
* 2018/06/19 给`arclist标签`if($keyword!='')代码段内调整为 `相关关键词文章提取的语句 ，前台使用方法: {dede:arclist  channelid='1' keyword='[field:keyword']'}`
* 2018/06/20 后台增加一个全站伪静态规则生成的插件，增加生成apache和nginx伪静态生成规则(iis可以使用apache伪静态文件)
* 2018/06/26 include/dedetag.class.php中 `SaveTo函数`增加判断列表页面页码 title加入页码+canonical标签
* 2018/07/04 dede/article_add.php 增加根据cfg_check_title设定参数判定判断重复标题文章的功能。
* 2018/07/28 新增加tag模块，非系统tag功能，tag自带后台批量导入关键词，前台自带生成专题页面功能,目前收录了21000多个页面在Google中，百度为171013个页面，百度相对收录审核比较慢些，google则是先大量收录后，开始清理
* 2018/08/23 修复google search console管理工具中显示旧版的url为软404的问题，在include/helper/extend.helper.php中ParamError下面加入如下代码，让页面返回正确的http 404状态码
* 2018/09/06 为适应MIP网站趋势，在/include/extend.func.php文件中加入个replaceMipImages函数 用于替换img标签为 <mip img
* 2018/09/25 精简掉一些组件，包含guestbook插件等，主要为了降低网站程序被注入的风险
* 2018/10/24 修正后台有个redirecturl功能不能直接显示跳转url问题，更新补丁于/include/helpers/channelunit.helper.php 约160行左右
* 2018/10/31 修正增加一个/dede/article_add.php 109行增加 自动生成随机作者名的功能
* 2019/02/12 之前误删除网站模块，目前调整了/topic/arc-{id}.html 为/topic/{id}-html 并将旧url重定向新url写了301重定向规则
* 2019/02/13 将/tags.php?/关键词/ 调整为/tags.php/id.html形式，便于页面收录和统计
```php
/** 2018/8/23 add 显示一个错误 返回错误信息和404状态码 */
if (!function_exists('RturnFor'))
{
   function RturnFor()
     {
        header("HTTP/1.1 404");
        echo '对不起，你输入的参数有误！';
        exit();
     }
}
```
##Bug

* 目前发现的dedecms伪静态后，文章分页无法使用bug，需要改几处文件，暂时先记在这里

##有问题反馈
在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

* 邮件(inyhow#gmail.com, 把#换成@)

##关于作者

```javascript
  var inyhow = {
    nickName  : "inyhow",
    site : "http://www.inyhow.com [已售]"
  }
