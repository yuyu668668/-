<?php

namespace app\admin\controller;
use app\common\model\Admin;

class Entry extends Common{
	//后台首页
	public function index(){
		//加载后台模板文件:view/entry/index.html
		return $this->fetch();
	}
	
	/**
	 * 修改密码
	 */
	 public function pass(){
	 	
		//如果是post请求，则提交的数据转入模型中处理，然后调用其中的pass方法,同时把post数据接收过来并当作参数传递过去
	 	if(request()->isPost()){
	 		
			$res=(new Admin())->pass(input('post.'));
			
			if($res['valid']){
				//执行成功
				session(null);//修改密码后清除原来的session
				$this->success($res['msg'],'admin/entry/index');exit;//跳转到登录页面重新登录
			}else{
				//执行失败
				$this->error($res['msg']); exit;
			}
	 	}
		
	 	//加载模板文件:view/entry/pass.html
	 	return $this->fetch();
	 }
	 
}
?>