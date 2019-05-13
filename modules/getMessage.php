<?php
	// 获取留言信息
	// 
	// 
	/* 传值： 
		audit (默认为3)
			0 => 未审核  1 => 审核通过  2 => 审核未通过  3 => 全部

		page (默认为1)
			number 多少页

		limit (默认10)
			number 一页多少条
	*/


	include('../public/main.php');

	$main = new Main();

	//传过来的状态
	$status = $main->getRequest("status");
	$page = $main->getRequest("page");
	$limit = $main->getRequest("limit");

	// 获取的数据
	$data_msg = $main->getJson("message","data");

	//返回数据
	$data = [];

	$curData = [];

	if($status === false || $status == 3){
		$curData = parsePage($data_msg, $page);
		//处理分页数据
		$main->successPage( $curData["data"], $page, $curData["limit"], $curData["count"] );
		exit;
	}else{
		//获取对应审核状态的数据
		foreach( $data_msg as $k => $v ){
			//根据状态返回数据
			if($v["audit"] == $status){
				array_push($data, $v);
			}
		}
		$curData = parsePage($data, $page);
		$main->successPage( $curData["data"], $page, $curData["limit"], $curData["count"] );

	}

	//将数据转换为分页形式
	// $data => 数据
	// $curPage => 当前页数
	function parsePage($data, $curPage){
		global $page;
		global $limit;

		$pagedata = [];

		foreach( $data as $k => $v ){
			if( ($k - 1) % $limit == 0){
				array_push($pagedata, array_slice($data,$k,$limit));
			}
		}

		$curdata = $pagedata[ $curPage - 1 ];

		return [
			"data" => $curdata,
			"limit" => $limit,
			"count" => ( $limit * $page) - $limit + count( end($pagedata) )
		];

	}

	


?>