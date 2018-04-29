<?php
namespace app\common\model;
use think\Model;

class Chat extends Model{
	
	protected $pk='chat_id';//主键
	protected $table='blog_chat';//操作的数据表
	
	protected $insert=['chat_time'];
	protected function setChatTimeAttr($value){
		return time();
	}
	
	public function store($data){

		//2.执行添加
		return $this->allowField(true)->save($data);

	}
}
