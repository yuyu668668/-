<?php

namespace app\common\model;

use think\Loader;
use think\Model;
use think\Validate;

class Admin extends Model{
	
	protected $pk='admin_id';	//主键
	protected $table='blog_admin';	//表名
	
	/**
	 *登录 
	 * @param $data:post数据
	 */
	 public function login($data){  //$data为传过来的post数据
	 	
		//1.执行验证
		$validate = Loader::validate('Admin');  //app\admin\validate\Admin.php
			//如果验证不通过
		if(!$validate->check($data)){
			return ['valid'=>0,'msg'=>$validate->getError()]; //将消息返回调用控制器的地方
		}
		
		//2.比对用户名和密码是否正确
		$userInfo=$this->where('admin_username',$data['admin_username'])->where('admin_password',$data['admin_password'])->find();
		//halt($userInfo);
		if(!$userInfo){
			//说明在数据库中未匹配到相关数据
			return ['valid'=>0,'msg'=>'用户名或密码不正确'];
		}
		
		//3.将用户名信息存入session中
		session('admin.admin_id',$userInfo['admin_id']);
		session('admin.admin_username',$userInfo['admin_username']);
		return ['valid'=>1,'msg'=>'登录成功'];
	 }
	 
	 /** 
	  * 修改密码
	  * @param $data:post数据
	  */
	  public function pass($data){
	  	//1.执行验证
	  	$validate=new Validate([
	  		'admin_password' =>'require',
	  		'new_password'  =>'require',
	  		'confirm_password'	=>'require|confirm:new_password'
	  	],[
	  		'admin_password.require' 	=>'请输入原始密码',
	  		'new_password.require' 		=>'请输入新密码',
	  		'confirm_password.require' 	=>'请输入确认密码',
	  		'confirm_password.confirm'  =>'确认密码和新密码不一致'
	  	]);//第二个参数为提示信息
	  	
	  	if(!$validate->check($data)){
	  		return ['valid'=>0,'msg'=>$validate->getError()];
	  		//dump($validate->getError());
	  	}
	  	
	  	//2.原始密码是否正确
	  		$userinfo=$this->where('admin_id',session('admin.admin_id'))->where('admin_password',$data['admin_password'])->find();
	  		if(!$userinfo){
	  			return ['valid'=>0,'msg'=>'原始密码不正确'];
	  		}
			
	  	//3.执行修改密码功能
	  		//save方法第二个参数为更新条件
	  		$res=$this->save([
	  		'admin_password'	=>$data['new_password'],
	  		],[$this->pk=>session('admin.admin_id')]);	//主键
	  	
	  		if($res){
	  			return ['valid'=>1,'msg'=>'密码修改成功'];
	  		}else{
	  			return ['valid'=>0,'msg'=>'修改密码失败'];
	  		}
	  }
}
