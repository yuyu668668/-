<?php
namespace app\index\controller;
use think\Controller;
use think\Request;

class Common extends Controller{
	
	public function __construct(Request $request = null){
		parent::__construct($request);
		
		//1.获取顶级栏目数据
		$cateData=$this->loadCateData();
		$this->assign('cateData',$cateData);
		
		//2.获取全部栏目数据
		$allCateData=$this->loadAllCateData();
		//halt($allCateData);
		$this->assign('allCateData',$allCateData);
		
		//3.获取标签数据
		$tagData=$this->loadTagData();
		$this->assign('tagData',$tagData);
		
		//4.获取最新文章
		$articleData=$this->loadArticleData();
		//halt($articleData);
		$this->assign('articleData',$articleData);
		
		//5.获取友情链接
		$linkData=$this->loadLinkData();
		$this->assign('linkData',$linkData);
		
		//6.获取热门文章
		$articleHot=$this->loadArticleHot();
		$this->assign('articleHot',$articleHot);
		
		
		
	}
	
	//获取顶级栏目数据
	public function loadCateData(){
		return db('cate')->where('cate_pid',0)->select();
	}
	
	//获取全部栏目数据
	public function loadAllCateData(){
		return db('cate')->order('cate_sort desc')->select();
	}
	
	//获取标签数据
	public function loadTagData(){
		return db('tag')->select();
	}
	
	//获取最新文章
	public function loadArticleData(){
		return db('article')->order('sendtime desc')->limit(5)->field('arc_id,arc_title,sendtime')->select();
	}
	
	//获取友链
	public function loadLinkData(){
		return db('link')->select();
	}
	
	//热门文章
	public function loadArticleHot(){
		return db('article')->order('arc_clicks desc')->limit(5)->field('arc_id,arc_title')->select();
	}
	
}
