<?php
namespace app\admin\controller;

use think\Controller;

class Link extends Controller{
	
	protected $db;
	protected function _initialize(){
		parent::_initialize();
		$this->db=new \app\common\model\Link();
	}
	
	//友链首页
	public function index(){
		
		//获取首页数据
		$field=db('link')->paginate(3);//分页
		$this->assign('field',$field);
		return $this->fetch();
	}
	
	/*
	 * 友链添加
	 * */
	 public function store(){
	 	
		$link_id=input('param.link_id');//通过id判断是编辑还是添加操作
		
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
			
		if($link_id){
			//说明是编辑请求
			$oldData=$this->db->find($link_id);
		}else{
			//添加请求
			$oldData=['link_name'=>'','link_url'=>''];//如果是添加操作，则value值为空
		}
		$this->assign('oldData',$oldData);
		
		return $this->fetch();
	 }
	 
	 /*
	  * 友链删除
	  * */
	    public function del(){
	  	$link_id=input('param.link_id');//接收id
	  	//执行删除
	  	if(\app\common\model\Link::destroy($link_id)){
	  		//删除成功
	  		$this->success('删除成功','index');
	  		exit;
	  	}else{
	  		$this->error('删除失败');
	  		exit;
	  	}
	  }
	
}
