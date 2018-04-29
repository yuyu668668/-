<?php
namespace app\admin\controller;
use think\Controller;
use app\common\model\Admin;

class Login extends Controller{
	public function login(){
	
		//加载登录页面
		//测试数据库连接
		//$data=db('admin')->find(1);
		//dump($data);
		//接受前台传过来的用户名，密码，验证码
		if(request()->isPost()){
			$res=(new Admin())->login(input('post.'));//将传过来的数据交给模型处理
			
			if($res['valid']){
				//说明登录成功
				$this->success($res['msg'],'admin/entry/index');  //登录成功，跳转到页面admin/entry/index
				exit;
			}else{
				//说明登录失败
				$this->error($res['msg']);
				exit;
			}
		}
		return $this->fetch();
	}
	
	/*
	 * 退出功能
	 * */
	 public function loginout(){
	 	session(null);//清除session
		$this->success('退出成功!','Entry/index');
	 }
}
