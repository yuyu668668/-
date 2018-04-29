<?php
namespace app\index\controller;

use app\common\model\Category;

class Lists extends Common{
	
	public function index(){
		
		//获取左侧第一部分数据
		$cate_id=input('param.cate_id');
		$tag_id=input('param.tag_id');
		
		//1.点击分类栏目查看文章
		if($cate_id){
			//获取当前所有子集分类id
			$cids=(new Category())->getSon(db('cate')->select(),$cate_id);
			$cids[]=$cate_id;//把自己追加进去
			
			$headData=[
				'title'=>'分类',
				'name'=>db('cate')->where('cate_id',$cate_id)->value('cate_name'),
				'total'=>db('article')->whereIn('cate_id',$cids)->count(),
			];
			//halt($headData);
			//获取文章数据
			$articleData=db('article')->alias('a')
			->join('__CATE__ c','a.cate_id=c.cate_id')->where('a.is_recycle',0)
			->whereIn('a.cate_id',$cids)->select();
			//halt($articleData);
		}
		
		//2.点击标签查看文章
		if($tag_id){
			$headData=[
				'title'=>'标签',
				'name'=>db('tag')->where('tag_id',$tag_id)->value('tag_name'),
				'total'=>db('arc_tag')->where('tag_id',$tag_id)->count(),
			];
		//halt($headData);
		//获取文章数据
		$articleData=db('article')->alias('a')
		->join('__ARC_TAG__ at','a.arc_id=at.arc_id')
		->join('__CATE__ c','a.cate_id=c.cate_id')
		->where('a.is_recycle',0)->where('at.tag_id',$tag_id)->select();
		//halt($articleData);
		}
		
		foreach($articleData as $k=>$v){			
		$articleData[$k]['tags']=db('arc_tag')->alias('at')
		->join('__TAG__ t','at.tag_id=t.tag_id')
		->where('at.arc_id',$v['arc_id'])->field('t.tag_id,t.tag_name')->select();
		}
			//halt($articleData);
		$this->assign('articleData',$articleData);
		
		$this->assign('headData',$headData);
		
		return $this->fetch();
	}
}
