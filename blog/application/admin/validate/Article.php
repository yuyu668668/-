<?php
namespace app\admin\validate;

use think\Validate;

class Article extends Validate{
	
	protected $rule=[
		'arc_title'	=>'require',
		//'arc_author'=>'require',
		'arc_sort'=>'require',
		'cate_id'=>'notIn:0',
		'arc_content'=>'require',
		'arc_digest'=>'require',
		//'pic'=>'require',
		
	];
	
	protected $message=[
		'arc_title.require'	=>'请输入文章标题',
		//'arc_author.require'=>'请输入文章作者',
		'arc_sort.require' =>'请输入文章排序',
		'cate_id.notIn'=>'请选择文章分类',
		'arc_content.require'=>'请输入文章内容',
		'arc_digest.require'=>'请输入文章摘要',
		//'pic.require'=>'文章缩略图不能为空',
		
	];
}
