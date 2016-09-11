<?php
require_once './ApiClient.php';

$param = array(
  'title' => '房价又涨了',
  'content' => '据新华社消息：上海均价环比上涨5%'
);
$api_url = 'http://www.tp5-restful.com/news/4'; 
$rest = new restClient($api_url, $param, 'get');
$info = $rest->doRequest();
//$status = $rest->status;//获取curl中的状态信息


$api_url = 'http://www.tp5-restful.com/news'; 
$rest = new restClient($api_url, $param, 'post');
$info = $rest->doRequest();

$api_url = 'http://www.tp5-restful.com/news/4'; 
$rest = new restClient($api_url, $param, 'put');
$info = $rest->doRequest();

echo '<pre/>';
print_r($info);exit;

$api_url = 'http://www.tp5-restful.com/news/4'; 
$rest = new restClient($api_url, $param, 'delete');
$info = $rest->doRequest();


