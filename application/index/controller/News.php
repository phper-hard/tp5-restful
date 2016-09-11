<?php
namespace app\index\controller;
use think\Request;
use think\controller\Rest;

class News extends Rest{
	public function rest(){
        switch ($this->method){
			case 'get': 	//查询
				$this->read($id);
				break;
			case 'post':	//新增
				$this->add();
				break;
			case 'put':		//修改
				$this->update($id);
				break;
			case 'delete':	//删除
				$this->delete($id);
				break;
			
        }
    }
    public function read($id){
		$model = model('News');
		//$data = $model::get($id)->getData();
		//$model = new NewsModel();
		$data=$model->where('id', $id)->find();// 查询单个数据
		return json($data);
    }
	
	public function add(){
		$model = model('News');
		$param=Request::instance()->param();//获取当前请求的所有变量（经过过滤）
		if($model->save($param)){
			return json(["status"=>1]);
		}else{
			return json(["status"=>0]);
		}
    }
	public function update($id){
		$model = model('News');
		$param=Request::instance()->param();
		if($model->where("id",$id)->update($param)){
			return json(["status"=>1]);
		}else{
			return json(["status"=>0]);
		}
    }
	public function delete($id){
		
		$model = model('News');
		$rs=$model::get($id)->delete();
		if($rs){
			return json(["status"=>1]);
		}else{
			return json(["status"=>0]);
		}
    }
}
