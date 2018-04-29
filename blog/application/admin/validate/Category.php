<?php
namespace app\admin\validate;

use think\Validate;

class Category extends Validate{
	
	//声明验证规则
	protected $rule=[
		'cate_name' =>'require',
		'cate_sort' =>'require|number|between:1,999'
	];
	//对应的提示消息
	protected $message=[
		'cate_name.require' =>'请填写栏目名称',
		'cate_sort.require' =>'请填写排序数字',
		'cate_sort.number'	=>'排序必须为数字',
		'cate_sort.between' =>'排序数字在1到999之间'
	];
}
