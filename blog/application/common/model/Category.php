<?php
namespace app\common\model;

use think\Model;
//栏目管理模型
class Category extends Model{
	
	protected $pk='cate_id';//主键
	protected $table='blog_cate';//操作的数据表
	
	public function store($data){
		//1.执行验证
			//在validate/Category.php
		//2.执行添加
		$result=$this->validate(true)->save($data);
		if(false===$result){
			//验证失败，输出错误信息
			return ['valid'=>0,'msg'=>$this->getError()];
			//dump($this->getError());
		}else{
			return ['valid'=>1,'msg'=>'添加成功'];
		}
		
	}
	
	/*
	 * 处理编辑中所属分类
	 * */
	 public function getCateData($cate_id){
	 	
		//1.首先找到$cate_id子集
		$cate_ids=$this->getSon(db('cate')->select(),$cate_id);
		//2.将自己追加进去
		$cate_ids[]=$cate_id;
		//3.找到除了他们之外的数据
		$field=db('cate')->whereNotIn('cate_id',$cate_ids)->select();
		return $field;
	 }
	 //找子集
	 public function getSon($data,$cate_id){
	 	static $temp=[];
	 	foreach($data as $k=>$v){
	 		if($cate_id==$v['cate_pid']){
		 		$temp[]=$v['cate_id'];
				$this->getSon($data,$v['cate_id']);//递归
			}
	 	}
		return $temp;
	 }
	 
	 /*
	  * 编辑栏目
	  * */
	  public function edit($data){
	  	
	  		$result=$this->validate(true)->save($data,[$this->pk=>$data['cate_id']]);
	  		if($result){
	  			//执行成功
	  			return ['valid'=>1,'msg'=>'编辑成功'];
	  		}else{
	  			return ['valid'=>0,'msg'=>'编辑失败'];
	  		}
	  }
	 
	 /*
	  * 栏目删除
	  * */
	  public function del($cate_id){
	  	//获取当前要删除的cate_pid
	  	$cate_pid=$this->where('cate_id',$cate_id)->value('cate_pid');
		//将当前要删除的$cate_id的子集数据的pid修改成$cate_pid
		$this->where('cate_pid',$cate_id)->update(['cate_pid'=>$cate_pid]);
		//执行当前数据的删除
		if(Category::destroy($cate_id)){
			return ['valid'=>1,'msg'=>'删除成功'];
		}else{
			return ['valid'=>0,'msg'=>'删除失败'];
		}
	  }
	  
	  public function getAll(){
	  	return db('cate')->select();
	  }
}
