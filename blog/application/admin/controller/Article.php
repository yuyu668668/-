<?php
namespace app\admin\controller;

use think\Controller;

class Article extends Controller{
	
	protected $db;
	protected function _initialize(){
		parent::_initialize();
		$this->db=new \app\common\model\Article();
	}
	
	//文章首页
	public function index(){
		//获取文章数据			
		$field=$this->db->getAll();//交给模型处理
		//halt($field);die;
		$this->assign('field',$field);//分配到页面
		return $this->fetch();
	}
	
	/*
	 * 文章添加
	 * */
	 public function store(){
	 	
		//1.获取分类数据
		$cateData=(new \app\common\model\Category())->getAll();
		//halt($cateData);
		$this->assign('cateData',$cateData);
		
		//2.获取标签数据
		$tagData=db('tag')->select();
		//halt($tagData);
		$this->assign('tagData',$tagData);
		
		if(request()->isPost()){
		
		$data=input('post.');
/*		$data=[
			'arc_title'=>input('arc_title'),
			//'arc_author'=>input('arc_author'),
			'arc_sort'	=>input('arc_sort'),
			'cate_id'	=>input('cate_id'),
			//'tag_id'	=>input('tag_id'),
			'arc_content'=>input('arc_content'),
			'arc_digest'=>input('arc_digest'),
			'tag'=>input('tag'),
		];*/
		//halt($data);
		//3.上传图片处理
		// 获取表单上传文件 例如上传了001.jpg
		$file = request()->file('pic');
		//halt($_FILES);
		// 移动到框架应用根目录/public/uploads/ 目录下
		if($_FILES['pic']['tmp_name']){
			
		$info = $file->move(ROOT_PATH . 'public' . DS . '/static/uploads');
		
		if($info){
			
		$data['pic']='/static/uploads/'.date('Ymd').'/'.$info->getFilename();
		
		}else{
		// 上传失败获取错误信息
		echo $file->getError();
			}
		}
		
		$res=$this->db->store($data);//交给模型处理
		if($res['valid']){
			//执行成功
			$this->success($res['msg'],'index');
			exit;
		}else{
			$this->error($res['msg']);
			exit;
		}
	}	
		return $this->fetch();
	}

	/*
	 * 文章修改
	 * */
	 public function edit(){

		//1.获取分类数据
		$cateData=(new \app\common\model\Category())->getAll();
		//halt($cateData);
		$this->assign('cateData',$cateData);
		
		//2.获取标签数据
		$tagData=db('tag')->select();
		//halt($tagData);
		$this->assign('tagData',$tagData);
		
		if(request()->isPost()){
		
		$data=input('post.');
		//3.上传图片处理
		// 获取表单上传文件 例如上传了001.jpg
		$file = request()->file('pic');
		//halt($_FILES);
		// 移动到框架应用根目录/public/uploads/ 目录下
		if($_FILES['pic']['tmp_name']){
			
		$info = $file->move(ROOT_PATH . 'public' . DS . '/static/uploads');
		
		if($info){
			
		$data['pic']='/static/uploads/'.date('Ymd').'/'.$info->getFilename();
		
		}else{
		// 上传失败获取错误信息
		echo $file->getError();
			}
		}
		
		$res=$this->db->edit($data);//交给模型处理
		if($res['valid']){
			//执行成功
			$this->success($res['msg'],'index');
			exit;
		}else{
			$this->error($res['msg']);
			exit;
		}
	}	
		//获取旧数据
	 	$arc_id=input('param.arc_id');
		//halt($arc_id);
		$oldData=$this->db->find($arc_id);
		//halt($oldData);die;
		//分配旧数据到页面(edit.html)
	  	 $this->assign('oldData',$oldData);
		
		return $this->fetch();
		
	 }

	/*
	 * 文章删除到回收站
	 * */
	public function trash(){
		$arc_id=input('param.arc_id');
		//halt($arc_id);
		$res=$this->db->trash($arc_id);//请求模型del方法处理
		if($res['valid']){
			//执行成功
			$this->success($res['msg'],'index');
			exit;
		}else{
			$this->error($res['msg']);
			exit;
		}
	}
	
	/*
	 * 文章回收站首页
	 * */
	 public function recycle(){
	 	
		$field=$this->db->getRecycle();//交给模型处理
		//halt($field);die;
		$this->assign('field',$field);//分配到页面
		
		return $this->fetch();
	 }
	 
	 /*
	  * 文章从回收站还原
	  * */
	  public function restore(){
	  	$arc_id=input('param.arc_id');
		//halt($arc_id);
		$res=$this->db->restore($arc_id);//请求模型del方法处理
		if($res['valid']){
			//执行成功
			$this->success($res['msg'],'index');
			exit;
		}else{
			$this->error($res['msg']);
			exit;
		}
	  }
	  
	  /*
	   * 文章从回收站彻底删除
	   * */
	   public function del(){
	   	
	   	$arc_id=input('param.arc_id');
	   	
		$res=$this->db->del($arc_id);
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
