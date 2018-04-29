<?php

namespace app\admin\validate;
use think\Validate;

class Admin extends Validate{
	
	//声明规则
	protected $rule=[
		'admin_username' =>'require',
		'admin_password' =>'require',
		'code' =>'require|captcha'
	];
	
	//验证器提示信息
	protected $message=[
		'admin_username.require' =>'用户名不能为空',
		'admin_password.require' =>'密码不能为空',
		'code.require' =>'验证码不能为空',
		'code.captcha' =>'验证码不正确'
	];
}
