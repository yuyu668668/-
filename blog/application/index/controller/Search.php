<?php
namespace app\index\controller;

class Search extends Common{
	
	public function index(){
		
		$seo=input('search');
		//halt($seo);
		$artSeo=db('article')->where('arc_title','like','%'.$seo.'%')->where('is_recycle',0)->paginate(5);
		
		//halt($artSeo);die;
		$this->assign('artSeo',$artSeo);
		
		return $this->fetch();
	}
}
