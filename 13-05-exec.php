<?php
/*
 * 模拟减少一台服务器，并请求
 */
require '13-01-config.php';
require '13-02-hash.php';

$mem = new Memcache(); //创建memcache客户端的操作类

$diser = new $_dis(); //实例化分布式算法类

//循环的添加服务器，分布式部署服务器
foreach ($_memserv as $k=>$v){
	$diser->addNode($k);
}

//模拟减少一台服务器
$diser->delNode('D');

//开始请求
for ($i=1; $i<=100000; $i++){
	$i = sprintf('%04d', $i%10000); //让key落在[0-10000]之间
	
	//根据key计算key所属的节点
	$serv = $_memserv[$diser->lookup('key'.$i)];
	$mem->pconnect($serv['host'], $serv['port'], 2);
	
	//如果节点击中，无此缓存，则添加之
	if (!$mem->get('key'.$i)){
		$mem->add('key'.$i, 'value'.$j, 0, 0);
	}
	
	$mem->close(); //注意释放，以为脚本运行时间较长
	usleep(3000);
}

?>