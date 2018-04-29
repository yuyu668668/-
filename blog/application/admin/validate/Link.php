<?php
namespace app\admin\validate;

use think\Validate;

class Link extends Validate{
	
	protected $rule=[
		'link_name'	=>'require',
		'link_url'=>'require',
	];
	
	protected $message=[
		'link_name.require'	=>'请输入链接名称',
		'link_url.require'	=>'请输入链接地址',
	];
}
