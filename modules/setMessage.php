<?php

	include('../public/main.php');

	$main = new Main();

	$maxLength = 300;	//最大300个字符


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
				"name" => $name,
				"content" => substr($content,0,$maxLength),
				"audit" => "0",
				"ctime" => time(),
			]);
			
			$main->setJson("message","data",$data_msg);

		}

		setcookie("user", "yes", time()+1*60*60);
	}




?>