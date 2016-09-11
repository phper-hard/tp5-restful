<?php
use think\Route;
Route::get('/',function(){
    return 'Hello,world!';
});
Route::get('news/:id','index/News/read');//查询
Route::post('news','index/News/add'); //新增
Route::put('news/:id','index/News/update'); //修改
Route::delete('news/:id','index/News/delete'); //删除
//Route::any('new/:id','News/read'); // 所有请求都支持的路由规则