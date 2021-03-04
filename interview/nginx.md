1.负载均衡
负载均衡将工作任务分摊到多个处理单元。提高并发处理能力。
web负载均衡是实现负载均衡集群，横向扩展分担web请求(http,https)得负载均衡技术。
基本原理:建立一对多得映射机制，一个请求得入口映射到多个处理请求节点。常见包括dns轮询，cdn加速，ip负载均衡。
dns轮询就是配置多条记录，对每个查询将dns文件钟文件记录得ip地址按顺序返回不同解析结果，没有健康检查机制，
不能差异化区分服务器状态。
cdn内容分发网络，将内容同步到大量缓存节点，在dns服务器上进行扩展。
ip负载均衡通过F5，主要有lvs四层负载均衡，在第四层传输层，nginx七层负载均衡运用层。


web负载均衡实现
1.反向代理负载均衡
nginx 定制转发策略，分配服务器流量得权重等。
轮询 upstream backserver {
    server 192.168.0.14;
    server 192.168.0.15;
}
weight
upstream backserver {
    server 192.168.0.14 weight=3;
    server 192.168.0.15 weight=7;
}

iphash
upstream backserver {
    ip_hash;
    server 192.168.0.14:88;
    server 192.168.0.15:80;
}

least_conn最少连接数

server {
    location / {
        proxy_pass http://backend;
    }
}

会有问题就是多服务器session不能共享，可以配置session基于内存redis/mem


修改配置需要重启nginx
可以利用consul、实现动态负载均衡

2.dns负载均衡
一个域名配置成多个ip。不能自由定义规则，修改会有延迟

3.cdn
将里用户近得ip返回给用户。

4.ip负载均衡
lvs在负载均衡服务器收到客户端得ip包得时候，修改ip包得目标ip地址或端口

5.http负载均衡
php层。
$domains = array(
	'a.com',
	'b.com',
);
$domain = array_rand($domians);
header('Location:http://'.$domain);
增加网络延时，性能不佳。

2.nginx访问php配置
location ~ \.php$ {

root html;

fastcgi_pass 127.0.0.1:9000;指定了fastcgi进程侦听的端口,nginx就是通过这里与php交互的

fastcgi_index index.php;

include fastcgi_params;

fastcgi_param SCRIPT_FILENAME   /usr/local/nginx/html$fastcgi_script_name;

}

3.正向代理和反向代理
正向代理:也就是代理。类似vpn，客户端<->代理->服务器。
反向代理：就类似负载均衡，你请求负载均衡地址，负载均衡去请求原始服务器。
nginx得正向代理和反向代理:
正向代理
resolver 8.8.8.8;
    location / {
        proxy_pass http://$http_host$request_uri;
    }

 #设置反向代理
    location ~ /test.html$ {
        proxy_pass http://127.0.0.1:8080;
    }

4.php解决跨域
1.header("Access-Control-Allow-Origin:*");
2.header('Access-Control-Allow-Origin:http://www.startphp.cn');
header('Access-Control-Allow-Methods:POST');    //表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type'); //请求头的限制
3.// 设置能访问的域名
static public $originarr = [
   'https://test1.com',
   'https://test2.com',
];

/**
 *  公共方法调用
 */
static public function setheader()
{
   // 获取当前跨域域名
   $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
   if (in_array($origin, self::$originarr)) {
      // 允许 $originarr 数组内的 域名跨域访问
      header('Access-Control-Allow-Origin:' . $origin);
      // 响应类型
      header('Access-Control-Allow-Methods:POST,GET');
      // 带 cookie 的跨域访问
      header('Access-Control-Allow-Credentials: true');
      // 响应头设置
      header('Access-Control-Allow-Headers:x-requested-with,Content-Type,X-CSRF-Token');
   }
}

4.add_header 'Access-Control-Allow-Origin' $http_origin;
        add_header 'Access-Control-Allow-Credentials' 'true';
        add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';
        add_header 'Access-Control-Allow-Headers'
        'DNT,web-token,app-token,Authorization,Accept,Origin,Keep-Alive,User-Agent,X-Mx-ReqToken,
        X-Data-Type,X-Auth-Token,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Range';
        add_header 'Access-Control-Expose-Headers' 'Content-Length,Content-Range';
        if ($request_method = 'OPTIONS') {
                add_header 'Access-Control-Max-Age' 1728000;
                add_header 'Content-Type' 'text/plain; charset=utf-8';
                add_header 'Content-Length' 0;
                return 204;
        }


5.php返回数据被nginx截断
fastcgi_buffers 4 64k;//此处值代表nginx 设置 4个 32k 的块进行缓存，总共大小为4*64k
fastcgi_buffer_size 64k;//磁珠值代表每块大小
fastcgi_temp没有写入权限
sudo chown -R www:root fastcgi_temp
chmod -R 764 /usr/local/nginx/fastcgi_temp/


6.nginx查用模块
ngx_http_limit_conn_moudle限制用户并发连接数和请求数模块

ngx_http_limit_req_moudle根据定义得key限制nginx请求过程得速率
limit_req_zone $variable zone=name:size rate=rate;
例子limit_req_zone $binary_remote_addr zone=one:10m rate=1r/s;
采用漏桶算法
请求从上方倒入水桶，从下方流出（被处理）
来不及流出得水存在水桶中，以固定速率流出
水满后水溢出
核心是缓存请求匀速处理多余得请求直接丢弃

令牌桶算法:
令牌以固定速率产生，并缓存到令牌桶中
令牌桶放满时多余得令牌被丢弃
请求要消耗等比例得令牌才能被处理
令牌不够时请求被缓存

令牌桶不仅有一只桶还有队列，桶存放令牌，队列存放请求

/*** 漏桶的大小是固定的，处理速度也是固定的，但是请求的速率的不固定的。在突发的情况下，会丢弃很多请。** */
    function LeackBucket()
{   $redis = new \Redis();
    $redis->connect('127.0.0.1', 6379);
     //桶的容量
     $maxCount = 1000;
     //时间
     $interval = 10;
     //每分钟流出的数量
     $speed = 20;
     //用户
     $time = $redis->time();
     $key = $time[0].$time[1];
     //时间判断
     $check = $redis->exists('outCount');
     if ($check){
     //出桶的速率的请求数量
        $outCount = $redis->incr('outCount');
        if ($outCount<=$speed){
        //业务处理
            echo "规定的时间内只能访问20次 $outCount";
         } else {
            echo "你已经超过每分钟的访问 $outCount";
         }
        } else {
            $outCount = $redis->incr('outCount');
            $redis->Expire('outCount',$interval);
            echo "时间过了";exit;
        }
    }
?>

ngx_http_upstream_moudle负载均衡模块
ngx_http_fastcgi_module动态应用相关得模块如php

ngx_http_access_moudle访问控制模块
location / {
    deny 192.168.1.1;
    allow 192.168.1.0/24;
    allow 47.98.147.49;
    deny all;
}
location ~.*\.(sql|log|txt|jar|war|sh|py|php) {
    deny all;
}

ngx_http_proxy_moudle代理模块
ngx_http_rewrite_moudle地址重写模块
ngx_http_log_moudle日志模块

防盗链
location ~* ^.+\.(jpg|gif|png|swf|flv|wma|wmv|asf|mp3|mmf|zip|rar)$ {
    valid_referers none blocked www.23673.com 23673.com;
    if ($invalid_referer) {
        #return 302 http://nginx.23673.com/img/nolink.jpg;
        return 404; break;
    }

nginx缓存机制
减少冗余得数据传输节约网络费用
nginx仅仅默认缓存get和head客户端请求

location /img {
    alias /export/img/;
    expires 10s;
}




