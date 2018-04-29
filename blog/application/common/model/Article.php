<?php
namespace app\common\model;

use think\Model;

class Article extends Model{
	
	protected $pk='arc_id';
	protected $table='blog_article';
	//自动完成
	protected $auto=['admin_id'];
	protected $insert=['sendtime'];
	protected $update=['updatetime'];
	
	protected function setAdminIdAttr($value){
		return session('admin.admin_id');
	}
	protected function setSendTimeAttr($value){
		return time();
	}
	protected function setUpdateTimeAttr($value){
		return time();
	}
	
	/*
	 * 获取文章首页数据
	 * */
	 public function getAll(){
	 	//将文章表和分类表进行关联
	 	$data=db('article')->alias('a')
		->join('__CATE__ c','a.cate_id=c.cate_id')->where('a.is_recycle',0)
		->field('a.arc_id,a.arc_title,a.pic,a.sendtime,c.cate_name,a.arc_sort')
		->order('a.arc_sort desc')->paginate(3);
		//halt($data);die;
		return $data;//返回给控制器
	 }
	 
	 /*
	  * 获取回收站首页数据
	  * */
	  public function getRecycle(){
	 	//将文章表和分类表进行关联
	 	$data=db('article')->alias('a')
		->join('__CATE__ c','a.cate_id=c.cate_id')->where('a.is_recycle',1)
		->field('a.arc_id,a.arc_title,a.pic,a.sendtime,c.cate_name,a.arc_sort')
		->order('a.arc_sort desc')->paginate(3);
		//halt($data);die;
		return $data;//返回给控制器
	 }
	 
	
	/*
	 * 文章添加
	 * */
	public function store($data){
		
		//halt($data);die;
		if(!isset($data['tag'])){
			//提示添加标签
			return ['valid'=>0,'msg'=>'请选择标签'];
		}
		//添加数据到数据库
		$result=$this->validate(true)->allowField(true)->save($data);
		if($result){
			//执行成功
			//文章标签中间表的添加
			foreach($data['tag'] as $v){
				//组合两个表的数据
				$arcTagData=[
				'arc_id'=>$this->arc_id,
				'tag_id'=>$v,
				];
				(new ArcTag())->save($arcTagData);
			}
				
			return ['valid'=>1,'msg'=>'添加成功'];
		}else{
			return ['valid'=>0,'msg'=>$this->getError()];
		}
	}
	
	/*
	 * 文章编辑
	 * */
	 	public function edit($data){
		
		//halt($data);die;
		if(!isset($data['tag'])){
			//提示添加标签
			return ['valid'=>0,'msg'=>'请选择标签'];
		}
		//添加数据到数据库
		$result=$this->validate(true)->allowField(true)->save($data,[$this->pk=>$data['arc_id']]);
		if($result){
			//执行成功
			//文章标签中间表的添加
			foreach($data['tag'] as $v){
				//组合两个表的数据
				$arcTagData=[
				'arc_id'=>$this->arc_id,
				'tag_id'=>$v,
				];
				(new ArcTag())->save($arcTagData);
			}
				
			return ['valid'=>1,'msg'=>'修改成功'];
		}else{
			return ['valid'=>0,'msg'=>$this->getError()];
		}
	}
		
	/*
	 * 文章删除到回收站
	 * */
	 public function trash($arc_id){
	 	
		//halt($arc_id);die;
		$result=$this->save(['is_recycle'=>1],[$this->pk=>$arc_id]);
	  	
		//halt($result);die;
	  		if($result){
	  			//执行成功
	  			return ['valid'=>1,'msg'=>'删除成功'];
	  		}else{
	  			return ['valid'=>0,'msg'=>'删除失败'];
	  		}
	 }
	 
	 /*
	  * 文章从回收站还原
	  * */
	  	 public function restore($arc_id){
	  	 	
		$result=$this->save(['is_recycle'=>0],[$this->pk=>$arc_id]);
	  
	  		if($result){
	  			//执行成功
	  			return ['valid'=>1,'msg'=>'还原成功'];
	  		}else{
	  			return ['valid'=>0,'msg'=>'还原失败'];
	  		}
	 }
		 
		 /*
		  * 彻底删除
		  * */
		public function del($arc_id){
			
			if(Article::destroy($arc_id)){
				//删除文章中间表的数据
				(new ArcTag())->where('arc_id',$arc_id)->delete();
								
				return ['valid'=>1,'msg'=>'删除成功'];
			}else{
				return ['valid'=>0,'msg'=>'删除失败'];
			}
		}	 
	
}
