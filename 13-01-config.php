<?php
header("Content-type:text/html;charset=utf-8");

//配置文件，配置memcached节点信息
$_memserv = array();
$_memserv['A'] = array('host'=>'127.0.0.1', 'port'=>'11211');
$_memserv['B'] = array('host'=>'127.0.0.1', 'port'=>'11212');
$_memserv['C'] = array('host'=>'127.0.0.1', 'port'=>'11213');
$_memserv['D'] = array('host'=>'127.0.0.1', 'port'=>'11214');
$_memserv['E'] = array('host'=>'127.0.0.1', 'port'=>'11215');

//$_dis = array('mod', 'con');
?>