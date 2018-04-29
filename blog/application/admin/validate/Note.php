<?php
namespace app\admin\validate;

use think\Validate;

class Note extends Validate{
	
	protected $rule=[
		'note_content'	=>'require',
	];
	
	protected $message=[
		'note_content.require'	=>'请输入日志内容',
	];
}
