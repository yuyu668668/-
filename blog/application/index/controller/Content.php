<?php
namespace app\index\controller;

class Content extends Common{
	
	public function index(){
		
		//获取一篇文章详情
		$arc_id=input('param.arc_id');
		//文章点击次数加1
		db('article')->where('arc_id',$arc_id)->setInc('arc_clicks',1);
			
		$arcContent=db('article')->field('arc_id,arc_title,arc_content,sendtime,cate_id')->find($arc_id);
		//halt($arcContent);
		//处理当前文章的标签数据
		$arcContent['tags']=db('arc_tag')->alias('at')
		->join('__TAG__ t','at.tag_id=t.tag_id')
		->where('at.arc_id',$arcContent['arc_id'])->field('t.tag_id,t.tag_name')->select();
		//halt($arcContent);
		//上一篇和下一篇
		$pre=db('article')->where('arc_id','<',$arc_id)->where('cate_id',$arcContent['cate_id'])->order('arc_id desc')->limit(1)->value('arc_id');
		$next=db('article')->where('arc_id','>',$arc_id)->where('cate_id',$arcContent['cate_id'])->order('arc_id asc')->limit(1)->value('arc_id');
		
		//获取评论内容
		$chatData=db('chat')->alias('ch')
		->join('__ARTICLE__ a','ch.arc_id=a.arc_id')->where('a.arc_id',$arc_id)->paginate(3);
		//halt($chatData);
		
		$this->assign('arcContent',$arcContent);
		
		$this->assign('pre',$pre);
		$this->assign('next',$next);
		
		$this->assign('chatData',$chatData);
		
		return $this->fetch();
	}
}
