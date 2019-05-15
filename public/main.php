<?php
	//公用模块

	header('Content-Type:application/json');
	//可以设定指定域名，默认：所有域均可访问
	header('Access-Control-Allow-Origin:*');

	class Main{

		//返回正确信息，并附带数据
		// $data => 返回的json数据, 默认空json
		// $msg => 返回的提示信息(默认：获取成功)
		public function success($data = [], $msg = "获取成功"){
			exit( json_encode([
				"msg" => $msg,
				"code" => 200,
				"data" => $data
			]) );
		}

		//返回分页数据
		// $data => 返回的json数据, 默认空json
		// $page => 当前页
		// $limit => 当前条目数
		public function successPage($data = [], $page, $limit, $count){
			exit( json_encode([
				"msg" => "获取成功！",
				"code" => 200,
				"data" => $data,
				"page" => intval( $page ),
				"limit" => intval( $limit ),
				"all_count" => intval( $count )
			]) );
		}
		
		
		//返回错误信息
		// $msg 可以传一个字符串,表示错误信息(code则默认为500)
		// 不传则code = 500，msg = 请求失败....
		public function error($msg = null){
			$errMsg = [
				"data" => array()
			];

			if(isset($msg)){
				$errMsg = array_merge(["code" => 500, "msg" => $msg], $errMsg);
			}else{
				$errMsg = ["code" => 500, "msg" => "请求失败，请稍后重试！"];
			}

			exit( json_encode($errMsg) );
		}
		
		
		// 获取JSON文件数据
		// $module => 文件夹名(会自动获取该文件夹下的data.json)
		// $name => json文件名,默认 data (可选参数)
		public function getJson($module,$name = "data"){
			$json_string = file_get_contents("../data/{$module}/{$name}.json");
	        $data = json_decode($json_string,true);
	        if(is_null($data)){
	           $data = [];
	        }
	        return $data;
		}
		// 重新设置json文件数据
		// $module => 文件夹名(会自动获取该文件夹下的data.json)
		// $name => json文件名,默认 data (可选参数)
		// $data => json数据
		public function setJson($module,$name,$data = []){
	        $json_strings = json_encode($data, JSON_UNESCAPED_UNICODE);
	        file_put_contents("../data/{$module}/{$name}.json",$json_strings); //写入

	        return true;
	    }
	
		// 获取表单传值, 当没有值时,会返回 false
		// $field => 字段名
		public function getRequest($field){
			if(isset($_REQUEST[$field])){
				return $_REQUEST[$field];
			}else{
				return false;
			}
		}
	}

?>
