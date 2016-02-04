<?php
/*
 * 统计各节点的平均命中率
 */
require './13-01-config.php';

$mem = new Memcache();
$gets = 0;
$hits = 0;
foreach ($_memserv as $k=>$v){
	$mem->connect($v['host'], $v['port'], 2);
	$res = $mem->getstats();
	$gets += $res['cmd_get'];
	$hits += $res['get_hits'];
}

$rate = 1;
if ($gets > 0){
	$rate = $hits/$gets;
}
echo $rate*100,'%';
?>