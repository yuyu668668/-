<?php
namespace app\index\controller;

use think\Controller;

class Chat extends Controller{
	
		//模型实例化
	protected $db;
	protected function _initialize(){
		parent::_initialize();
		$this->db=new \app\common\model\Chat();
	}
	//保存评论数据
	public function store(){
		
		if(request()->isPost()){
			$data=input('post.');
			
			$arc_id=$data['arc_id'];
			//halt($arc_id);die;
			//halt($data);die;
			$res=$this->db->store($data);//交给模型处理
			if($res){
				$this->success('评论成功');
			}
		}
	}
}
