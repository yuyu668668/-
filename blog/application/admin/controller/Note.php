<?php
namespace app\admin\controller;

use think\Controller;

class Note extends Controller{
	
	protected $db;
	protected function _initialize(){
		parent::_initialize();
		$this->db=new \app\common\model\Note();
	}
	
	//日志列表页
	public function index(){
		
		//获取首页数据
		$field=db('note')->order('note_time desc')->paginate(3);//分页
		$this->assign('field',$field);
		return $this->fetch();
	}
	
	//日志添加
	public function store(){
		
		$note_id=input('param.note_id');//通过id判断是编辑还是添加操作
		
			if(request()->isPost()){
			//halt($_POST);
			$res=$this->db->store(input('post.'));//执行模型中的store方法
			if($res['valid']){
				//执行成功
				$this->success($res['msg'],'index');
				exit;
			}else{
				$this->error($res['msg']);
				exit;
			}
		}
			
		if($note_id){
			//说明是编辑请求
			$oldData=$this->db->find($note_id);
		}else{
			//添加请求
			$oldData=['note_content'=>''];//如果是添加操作，则value值为空
		}
		$this->assign('oldData',$oldData);
		
		return $this->fetch();
	}
	
	//日志删除
	public function del(){
	  	$note_id=input('param.note_id');//接收id
	  	//执行删除
	  	if(\app\common\model\Note::destroy($note_id)){
	  		//删除成功
	  		$this->success('删除成功','index');
	  		exit;
	  	}else{
	  		$this->error('删除失败');
	  		exit;
	  	}
	  }
}
