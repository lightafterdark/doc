1.redis数据结构
string 动态字符串
list 双向链表和压缩列表
hash ziplist压缩列表和hashtable哈希表
set 数组 压缩列表
sorted set 数组 哈希表
bitmap
geo
streams
栈 Lpush+Lpop先进先出filo
队列 先进先出 队列 lpush+rpop
阻塞队列 lpush+brpop
2.redis速度快数据类型丰富
3.redis是单线程 运用队列技术将并发访问变成串行访问消除数据库
串行控制的开销
4.删除策略
不删除 lru最近最少使用 lfu最不经常使用 先进先出
5.持久化
rdb
用快照的方式记录redis的所有健值对，在某个时间点将数据写入一个临时文件
aof所有的命令行记录以命令请求协议的格式保存为aof文件
rdb优点:rdb文件紧凑体积小网络传输快，适合全量复制，恢复速度比
aof快很多，对性能影响较小，缺点 不能实时 所以会造成数据大量丢失，
另外rdb文件要满足特定格式兼容性差
aof优点支持秒级持久化兼容性好 缺点文件大恢复速度慢
当aof和rdb同时存在时优先加载aof关闭aof加载rdb

6.redis主从复制读写分离

7.缓存击穿 缓存穿透 缓存雪崩

8.redis分布式锁实现
先拿setnx来争抢锁，抢到之后用expire给锁加过期时间避免忘记释放
可以把sexnx和expire合成一条指令
set name zcc ex 100 nx

9.redis做异步任务
list rpush生产消息 lpop 消费消息 没有消息的时候要sleep
一会在重试


10.redis海量数据用scan

11.redis 集群有16384个哈希槽每个key通过crc16校验后取模
决定方哪个槽每个节点负责一部分hash槽


12.
