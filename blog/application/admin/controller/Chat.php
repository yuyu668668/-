<?php
namespace app\admin\controller;

use think\Controller;

class Chat extends Controller{
	
	public function index(){
		
		//获取评论数据
		$chatData=db('chat')->alias('ch')
		->join('__ARTICLE__ a','ch.arc_id=a.arc_id')->paginate(3);
		$this->assign('chatData',$chatData);
		
		return $this->fetch();
	}
	
	//评论删除
	 public function del(){
	  	$chat_id=input('param.chat_id');//接收id
	  	//halt($chat_id);die;
	  	//执行删除
		$res=db('chat')->where('chat_id',$chat_id)->delete();
		
		if($res){
			return $this->success('删除成功','index');
		}else{
			return $this->error('删除失败');
		}
			
	  }
}
