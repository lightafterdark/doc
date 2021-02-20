1. 50道常见题

1.HTTP协议中几个状态码的含义:1xx（临时响应） 
200请求成功
301永久重定向
302临时重定向
400请求失败
401身份认证
404找不到资源
403没有权限
405请求方法错误
500服务器内部错误
502无效响应
504请求超时


2、写出一些php魔术方法;
__construct__ 类得构造方法
__destruct__类得析构方法
__call__调用不存在方法时调用
__get__获得成员变量
__set__设置成员变量
__toString__类被转化为字符串调用

3、一些编译php时的configure 参数
–prefix=/usr/local/php7                          php 安装目录
–with-config-file-path=/usr/local/php/etc      指定php.ini位置
–enable-ftp                                     打开ftp的支持
–with-curl                                  打开curl浏览工具的支持
 
4、向php传入参数的两种方法。
$argv $argv[0]是文件名 $argv[1]是第一个参数
$p = getpot('m:n:');$one = $p['m'];$two = $p['n'];在命令行下运行的方式是：php test.php -m one -n two

5、(mysql)请写出数据类型(int char varchar datetime text)的意思; 请问varchar和char有什么区别;
int 整形 char字符串 varchar字符串 datetime日期 YYYY-MM-DD HH:MM:SS text文本
char固定长度，varchar长度可变。char处理速度比varchar快 ，但是浪费空间。检索char值时，尾部得空格会被删除。varchar保存
检索空格都保留。


6、posix和perl标准的正则表达式区别;
1、定界符
2、修正符
posix没有定界符，函数相应的参数会被认为是正则
perl有定界符，定界符只要不是数字、字母、反斜杠（\）就可以作为perl的定界符，如果定界符需要作为字符串被用在正则体中那么需要用\进行转义
posix没有修正符
perl有修正符

7、Safe_mode 打开后哪些地方受限.
和系统相关得文件打开，命令执行等函数。
shell_exec不可使用 exec,system等只能在safe_mode_exec_dir 设置得目录下执行操作。copy,mkdir,chmod会检查被操作文件和目录
是否有相同得所有者。

8、写代码来解决多进程/线程同时读写一个文件的问题。 

<?php
	function T_write($filename, $string) {
		$fp = fopen($filename, 'a');  // 追加方式打开
		if (flock($fp, LOCK_EX)) {   // 加写锁：独占锁
			fputs($fp, $string);   // 写文件
			flock($fp, LOCK_UN);   // 解锁
		}
		fclose($fp);
	}
?>


<?php
	function T_read($filename, $length) {
		$fp = fopen($filename, 'r');        // 只读方式打开
		if (flock($fp, LOCK_SH)) {          // 加读锁：共享锁
			$result = fgets($fp, $length);  // 读取文件一行或length字节长度
			flock($fp, LOCK_UN);  //解锁
		}
		fclose($fp);
		return $result;
	}
?>



9、介绍xdebug,apc,eAccelerator,Xcache,Zend opt的使用经验。

10、使用mod_rewrite,在服务器上没有/archivers/567.html这个物理文件时，重定向到index.php?id=567 ,请先打开mod_rewrite.

11、MySQL数据库作发布系统的存储，一天五万条以上的增量，预计运维三年,怎么优化？
12、写出一种排序算法（原理），并说出优化它的方法。
13、请简单阐述您最得意的开发之作
14、对于大流量的网站,您采用什么样的方法来解决各页面访问量统计问题
15、您是否用过模板引擎? 如果有您用的模板引擎的名字是?
smarty

16、请介绍Session的原理,大型网站中Session方面应注意什么?
17、测试php性能和mysql数据库性能的工具,和找出瓶颈的方法。
18、正则提出一个网页中的所有链接.
19、介绍一下常见的SSO(单点登陆)方案(比如dedecms整合discuz的passport)的原理。
20、您写过的PHP框架的特点，主要解决什么问题，与其他框架的不同点。
21、大型的论坛/新闻文章系统/SNS网站在性能优化上有什么区别?
22、相册类应用:要求在浏览器中能同时选中并上传多个文件，图片要求能剪裁，压缩包在服务器端解压。能上传单个达50M的文件。上传过程中有进度条显示。每个图片能生成四种大小缩略图，视频文件要转成flv供flash播放。叙述要涉及的各类开源软件和简单用途。
23、 群猴子排成一圈，按1，2，…，n依次编号。然后从第1只开始数，数到第m只,把它踢出圈，从它后面再开始数，再数到第m只，在把它踢出去…，如此不停的 进行下去，直到最后只剩下一只猴子为止，那只猴子就叫做大王。要求编程模拟此过程，输入m、n, 输出最后那个大王的编号。用程序模拟该过程。
24、Inmp支持高并发?为什么?与lamp的核心区别,运行原理有什么区别?
25、nginx的优化如何配置
26、mysql具体如何优化
27、网站调优怎么做？
28、PHP的运行原理
29、什么是ORM？
30、你为什么离开上一家公司，你以后想怎么发展？
31、Mysql 索引为什么使用b+树
32、thinkphp配置模式三种配置方式:
33、php安全问题解决
34、分布式API怎么调用
35、php的fastcgi，cgi php-cgi什么区别？
36、项目中遇到什么最难的问题是什么，最后如何解决
37、有没有做过商品秒杀，如果保证不超卖，秒杀活动，高并发 如何处理
38、如何做缓存优化
39、一百万的数组，如何快速找到 某个数
40、数据库怎么随机2条效率最高
41、Linux 系统 ，一个大文件中，怎么找到 某个 字符
42、websocket/tcp等协议的应用及实现原理
43、es在数据量很大的情况下（10亿级别），如何提高查询效率？
44、缓存如何使用，使用不当会有什么后果？
45、redis的hash如何实现的？
46、tcp怎么保证有序传输的，讲下快速重传和拥塞机制
47、udp是不可靠的传输，如何设计基于udp可靠的算法，怎么设计？
48、raft算法的基本流程，raft出现脑裂如何处理？
49、tcp粘包问题怎么处理？
50、go协程与swoole协程的区别？

2. unix/linux 基本使用
1.linux下查看当前系统负载信息的一些方法。
top free -m
2.vim的基本快捷键。
/ 查找 n 向后查询下一个 N向前查找下一个
:set nu 显示行号
: 数字 跳到指定行。
:M 跳到结尾
yy复制一行
d 1 删除一行
G 最后一行

3.ssh 安全增强方法;密码方式和rsa key 方式的配置。

4.rpm/apt/yum/ports 装包，查询，删除的基本命令。
install remove

5.Makefile的基本格式，gcc 编译，连接的命令,-O0 和-O3区别。
6.gdb,strace,valgrind的基本使用.
 
3. 前端,HTML,JS
1.css盒模型。
2.javascript中的prototype。
3.javascript中this对象的作用域。
4.IE和firefox事件冒泡的不同。
5.什么是怪异模式,标准模式，近标准模式。
6.DTD的定义
7.IE/firefox常用hack.
8.firefox,IE下的前端js/css调试工具。


