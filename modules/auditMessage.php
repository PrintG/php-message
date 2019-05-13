<?php
	// 审核留言
	/*	传值：
			id => 留言id
			status => 审核状态
				0 => 未通过
				1 => 通过
	*/


	include('../public/main.php');

	$main = new Main();

	//传过来的状态
	$id = $main->getRequest("id");
	$status = intval( $main->getRequest("status") );

	// 获取的数据
	$data_msg = $main->getJson("message","data");


	if($id === false || $status === false){
		$main->error("必须传id和status字段！");
	}else{
		if($status > 1){
			$main->error("审核状态只能为0或1");
		}
		$isaudit = false;
		foreach( $data_msg as $k => $v ){
			//根据状态返回数据
			if($v["id"] == $id){
				if($v["audit"] !== "0"){
					$main->error("该条数据已审核，无法再次审核！");
				}
				$isaudit = true;
				$data_msg[$k]["audit"] = $status===0?"2":"1";
			} 
		}
		if(!$isaudit){
			$main->error("审核失败！不存在该id的数据");
			exit;
		}else{
			$main->setJson("message","data",$data_msg);
			$main->success([],"审核成功！");
		}
		
	}

	
		


	


?>