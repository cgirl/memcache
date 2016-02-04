<?php
/*
 * 为各memcached节点，各充入1000条书数据
 * 步骤：引入配置文件，循环各节点，连接并填入数据
 */
require '13-01-config.php';
require '13-02-hash.php';

set_time_limit(0);
$mem = new Memcache();
$diser = new $_dis(); //分布式算法

//循环的添加服务器，分布式部署服务器
foreach ($_memserv as $k=>$v){
	$diser->addNode($k);
}

for ($i=0; $i<10000; $i++){
	$key = 'key'.sprintf("%04d", $i);
	$value = 'value'.$i;
	$serv = $_memserv[$diser->lookup($key)];
	$mem->pconnect($serv['host'], $serv['port'], 2);
	$mem->add($key, $value, 0, 0);
	
	$mem->close(); //注意释放，以为脚本运行时间较长
}

usleep(3000);
echo '服务器初始化完毕<br />';

?>