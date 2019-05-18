<?php

	include('../public/main.php');

	$main = new Main();
	
	//限制名称和内容长度
	$maxNameLength = 50;	//最大50个字符
	$maxContentLength = 300;	//最大300个字符


	if(isset($_COOKIE["user"])){
		$main->error("半个小时内只能提交一次！");
	}else{

		$name = $main->getRequest("name");
		$content = $main->getRequest("msg");
		
		if($name && $content){
			//把内容填入至审核列表的json中
			$data_msg = $main->getJson("message","data");

			array_push($data_msg, [
				"id" => end($data_msg)?strval( end($data_msg)["id"]+1 ):"1",
				"name" => substr($name,0,$maxNameLength),
				"content" => substr($content,0,$maxContentLength),
				"audit" => "0",
				"ctime" => time(),
			]);
			
			$main->setJson("message","data",$data_msg);

		}

		setcookie("user", "yes", time()+1*60*60);
	}




?>