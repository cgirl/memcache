<?php
/*
 * 为各memcached节点，各充入1000条书数据
 * 步骤：引入配置文件，循环各节点，连接并填入数据
 */
require '13-01-config.php';

$mem = new Memcache();
foreach ($_memserv as $k=>$v){
	$mem->connect($v['host'], $v['port'], 2);
	for ($i=1; $i<1000; $i++){
		$mem->add('key'.$i, 'value'.$i, 0, 0);
	}
	
	echo $k.'号服务器初始化完毕<br />';
}
?>