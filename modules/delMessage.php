<?php

	include('../public/main.php');

	$main = new Main();

	//传过来的状态
	$id = $main->getRequest("id");
	$status = intval( $main->getRequest("status") );

	// 获取的数据
	$data_msg = $main->getJson("message","data");


	if($id === false){
		$main->error("必须传需要删除的数据id");
	}else{
		$id = explode(",",$id);
		$isaudit = false;
		foreach( $id as $v ){
			foreach( $data_msg as $key => $val ){
				//根据状态返回数据
				if($val["id"] == $v){
					$isaudit = true;
					unset($data_msg[$key]);
				} 
			}
		}

		if(!$isaudit){
			$main->error("删除失败！不存在该id的数据");
			exit;
		}else{
			$main->setJson("message","data",$data_msg);
			$main->success([],"删除成功！");
		}
	}

	
		


	


?>