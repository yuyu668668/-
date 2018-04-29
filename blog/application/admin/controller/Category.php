<?php
namespace app\admin\controller;

use think\Controller;

//栏目管理控制器
class Category extends Controller{
	
	//模型实例化
	protected $db;
	protected function _initialize(){
		parent::_initialize();
		$this->db=new \app\common\model\Category();
	}
	
	//栏目首页
	public function index(){
		
		//获取栏目数据
		$field=db('cate')->select();
		//halt($field);
		//将数据分配到页面上
		$this->assign('field',$field);
		
		return $this->fetch();	// view/category/index.html
	}
	//栏目添加
	public function store(){
		
		if(request()->isPost()){
			//将请求交给模型处理
			//halt(input('post.'));
			$res=$this->db->store(input('post.'));//调用模型中的store方法
			
			if($res['valid']){
				//添加操作成功
				$this->success($res['msg'],'index');//跳转到index方法
				exit;
			}else{
				//添加操作失败
				$this->error($res['msg']);
				exit;
			}
		}
		
		return $this->fetch();
	}
	
	/*
	 * 添加子集栏目
	 * */
	 public function addSon(){
	 	
		if(request()->isPost()){
			$res=$this->db->store(input('post.'));
			if($res['valid']){
				//操作成功
				$this->success($res['msg'],'index');
			}else{
				$this->error($res['msg']);
				exit;
			}
		}
	 	$cate_id=input('param.cate_id');
		//halt($cate_id);
		//获取父级栏目名称
		$data=$this->db->where('cate_id',$cate_id)->find();
		//将数据分配到页面上(addSon页面)
		$this->assign('data',$data);
	 	return $this->fetch();
	 }
	 
	 /*
	  * 编辑栏目
	  * */
	  public function edit(){
	  	
		if(request()->isPost()){
			//halt($_POST);
			$res=$this->db->edit(input('post.'));
			if($res['valid']){
				//执行成功
				$this->success($res['msg'],'index');
				exit;
			}else{
				$this->error($res['msg']);
				exit;
			}
		}
		
	 	//接收所编辑的id
	  	$cate_id=input('param.cate_id');
	  	//获取旧的数据
	  	$oldData=$this->db->find($cate_id);	
	  	 //分配到页面(edit.html)
	  	 $this->assign('oldData',$oldData);
		 
		 //处理所属分类(不能包含自己和自己的子集数据)
		 $cateData=$this->db->getCateData($cate_id);//交给模型处理
		 $this->assign('cateData',$cateData);
	  	return $this->fetch();
	  }
	  
	  /*
	   * 删除栏目
	   * */
	 public function del(){
	 	
		$cate_id=input('param.cate_id');
		//halt($cate_id);
		$res=$this->db->del($cate_id);//请求模型del方法处理
		if($res['valid']){
			//执行成功
			$this->success($res['msg'],'index');
			exit;
		}else{
			$this->error($res['msg']);
			exit;
		}
	 }
}
