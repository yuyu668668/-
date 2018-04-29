<?php
namespace app\index\controller;


class Index extends Common
{
    public function index()
    {
		//获取文章数据
			
		$arts=db('article')->alias('a')->join('__CATE__ c','a.cate_id=c.cate_id')
		->order('arc_sort desc')->where('a.is_recycle',0)->limit(5)->select();

		//halt($arts);
		//文章标签中间表关联
		foreach($arts as $k=>$v){
			
			$arts[$k]['tags']=db('arc_tag')->alias('at')
			->join('__TAG__ t','at.tag_id=t.tag_id')
			->where('at.arc_id',$v['arc_id'])->field('t.tag_id,t.tag_name')->select();
		}
		//halt($arts);
		//$pages=db('article')->where('is_recycle',0)->paginate(5);
		//$page=$pages->render();
		
		$this->assign('arts',$arts);
		//$this->assign('page',$page);	
			
		return $this->fetch();
    }
	
	
	//获取日志信息
	public function note(){
		
		$noteData=db('note')->order('note_time desc')->paginate(5);
		$this->assign('noteData',$noteData);
		return $this->fetch();
	}
	
}
