<?php
/*** * * * * * * * * * * * * * * * * * * * * * * * * * ***\
 * 定义路由的请求方式                  *
 *                            *
 * $url_model=0                     *
 * 采用传统的URL参数模式                 *
 * http://serverName/appName/?m=module&a=action&id=1   *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * PATHINFO模式（默认模式）               *
 * 设置url_model 为1                   *
 * http://serverName/appName/module/action/id/1/     *
 ** * * * * * * * * * * * * * * * * * * * * * * * * * * **
*/
class restClient
{
  //请求的token
  const token='yangyulong';
  
  //请求url
  private $url;
    
  //请求的类型
  private $requestType;
    
  //请求的数据
  private $data;
    
  //curl实例
  private $curl;
  
  public $status;
  
  private $headers = array();
  /**
   * [__construct 构造方法, 初始化数据]
   * @param [type] $url     请求的服务器地址
   * @param [type] $requestType 发送请求的方法
   * @param [type] $data    发送的数据
   * @param integer $url_model  路由请求方式
   */
  public function __construct($url, $data = array(), $requestType = 'get') {
      
    //url是必须要传的,并且是符合PATHINFO模式的路径
    if (!$url) {
      return false;
    }
    $this->requestType = strtolower($requestType);
    $paramUrl = '';
    // PATHINFO模式
    if (!empty($data)) {
      foreach ($data as $key => $value) {
        $paramUrl.= $key . '=' . $value.'&';
      }
      $url = $url .'?'. $paramUrl;
    }
      
    //初始化类中的数据
    $this->url = $url;
      
    $this->data = $data;
    try{
      if(!$this->curl = curl_init()){
        throw new Exception('curl初始化错误：');
      };
    }catch (Exception $e){
      echo '<pre>';
      print_r($e->getMessage());
      echo '</pre>';
    }
  
    curl_setopt($this->curl, CURLOPT_URL, $this->url);
    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($this->curl, CURLOPT_HEADER, 1);
  }
    
  /**
   * [_post 设置get请求的参数]
   * @return [type] [description]
   */
  public function _get() {
  
  }
    
  /**
   * [_post 设置post请求的参数]
   * post 新增资源
   * @return [type] [description]
   */
  public function _post() {
  
    curl_setopt($this->curl, CURLOPT_POST, 1);
  
    curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->data);
      
  }
    
  /**
   * [_put 设置put请求]
   * put 更新资源
   * @return [type] [description]
   */
  public function _put() {
      
    curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PUT');
  }
    
  /**
   * [_delete 删除资源]
   * delete 删除资源
   * @return [type] [description]
   */
  public function _delete() {
    curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
  
  }
    
  /**
   * [doRequest 执行发送请求]
   * @return [type] [description]
   */
  public function doRequest() {
    //发送给服务端验证信息
    if((null !== self::token) && self::token){
      $this->headers = array(
        'Client-Token:'.self::token,//此处不能用下划线
        'Client-Code:'.$this->setAuthorization()
      );
    }
	
    //发送头部信息
    $this->setHeader();
  
    //发送请求方式
    switch ($this->requestType) {
      case 'post':
        $this->_post();
        break;
  
      case 'put':
        $this->_put();
        break;
  
      case 'delete':
        $this->_delete();
        break;
  
      default:
        curl_setopt($this->curl, CURLOPT_HTTPGET, TRUE);
        break;
    }
    //执行curl请求
    $info = curl_exec($this->curl);
  
    //获取curl执行状态信息
    $this->status = $this->getInfo();
    return $info;
  }
  
  /**
   * 设置发送的头部信息
   */
  private function setHeader(){
    curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
  }
  
  /**
   * 生成授权码
   * @return string 授权码
   */
  private function setAuthorization(){
    $authorization = md5(substr(md5(self::token), 8, 24).self::token);
    return $authorization;
  }
  /**
   * 获取curl中的状态信息
   */
  public function getInfo(){
    return curl_getinfo($this->curl);
  }
  
  /**
   * 关闭curl连接
   */
  public function __destruct(){
    curl_close($this->curl);
  }
}