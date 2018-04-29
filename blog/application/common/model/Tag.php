<?php
namespace app\common\model;

use think\Model;

class Tag extends Model{
	
	protected $pk='tag_id';
	protected $table='blog_tag';
	
	/*
	 * 添加标签
	 * */
	public function store($data){
		//1.验证(Tag验证器)
		//2.执行添加
		$result=$this->validate(true)->save($data,$data['tag_id']);
		if($result){
			//执行成功
			return ['valid'=>1,'msg'=>'编辑成功'];
		}else{
			return ['valid'=>0,'msg'=>$this->getError()];
		}
		
	}
}
