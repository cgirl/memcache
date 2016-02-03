<?php
/*
 * 一致性hash的php实现
 */
header("Content-type:text/html;charset=utf-8");
//需要一个把字符串转成整数的函数（0~2^32）
interface hash{
	public function _hash($str);
}

interface distribution{
	//public function addNote($node);
	public function lookup($key);
}

class Consistent implements hash, distribution{
	//protected $_nodes = array();
	protected $mul = 64;
	protected $_position = array();
	
	public function _hash($str){
		return sprintf("%u", crc32($str)); //将字符串转成无符号整数
	}
	
	//核心
	public function lookup($key){
		$point = $this->_hash($key);
		//先取圆环上最小的一个节点，当成结果
		/* $node = current($this->_nodes);
		foreach ($this->_nodes as $k=>$v){
			if ($point <= $k){
				$node = $v;
				break;
			}
		}
		return $node;
		 */
		$position = current($this->_position);
		foreach ($this->_position as $k=>$v){
			if ($point <= $k){
				$position = $v;
				break;
			}
		}
		return $position;
	}
	
	public function addNode($newNode){
		for ($i=0; $i<$this->mul; $i++){
			$this->_position[$this->_hash($newNode.'-'.$i)] = $newNode;
		}
		//增加服务器：12亿=>true
		//$this->_nodes[$this->_hash($newNode)] = $newNode;
		$this->_sortPosition();
	}
	
	//循环所有的虚节点的位置，谁的值等于指定的真实节点，就把他删掉
	public function delNode($delNode){
		foreach ($this->_position as $k=>$v){
			if ($v == $delNode){
				unset($this->_position[$k]);
			}
		}
	}
	
	protected function _sortPosition(){
		ksort($this->_position, SORT_REGULAR);
	}
	
	//调试用的函数
	public function getNodes(){
		print_r($this->_nodes);
	}
	
	public function printPosition(){
		print_r($this->_position);
	}
}

$con = new Consistent();
$con->addNode('a');
$con->addNode('b');
$con->addNode('c');
echo '所有的服务器如下：<br />';
$con->printPosition();
echo '<br />当前的键计算的hash落点是：'.$con->_hash('name').'<br />';

echo '应该落在'.$con->lookup('name').'号服务器';
?>