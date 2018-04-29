<?php
namespace app\admin\controller;

use think\Controller;

class Tag extends Controller{
	
	protected $db;
	protected function _initialize(){
		parent::_initialize();
		$this->db=new \app\common\model\Tag();
	}
	
	public function index(){
		
		//获取首页数据
		$field=db('tag')->paginate(5);//分页
		$this->assign('field',$field);
		//加载标签模板
		return $this->fetch();
	}
	
	/*
	 * 标签添加
	 * */
	 public function store(){
	 	
		//通过tag_id分辨是添加还是编辑操作
		$tag_id=input('param.tag_id');
		
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
		
		if($tag_id){
			//说明是编辑请求
			$oldData=$this->db->find($tag_id);
		}else{
			//添加请求
			$oldData=['tag_name'=>''];//如果是添加操作，则value值为空
		}
		$this->assign('oldData',$oldData);
		
	 	return $this->fetch();
	 }
	 
	 /*
	  * 标签删除
	  * */
	  public function del(){
	  	$tag_id=input('param.tag_id');//接收id
	  	//执行删除
	  	if(\app\common\model\Tag::destroy($tag_id)){
	  		//删除成功
	  		$this->success('删除成功','index');
	  		exit;
	  	}else{
	  		$this->error('删除失败');
	  		exit;
	  	}
	  }
	
}