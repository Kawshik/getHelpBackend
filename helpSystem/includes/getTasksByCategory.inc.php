<?php

function getTasksByCategory($category,$conn){
	$resultArray = array();

	$sql = "SELECT * FROM `assignedtasks` WHERE taskType = ? AND status='processing'";
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return array(
			'statusCode' => '700',
			'message' => 'Mysql database connection error'
			);
	} else {
		mysqli_stmt_bind_param($stmt,"s",$category);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
			
		while($row = mysqli_fetch_assoc($result)){
			array_push($resultArray, array(
				"taskId"=>$row['assignedTaskId'],
				"category"=>$row['taskType'],
				"description"=>$row['task'],
				"helperId"=>$row['helperId'],
				"requestTime"=>$row['requestTime'],
				"startTime"=>$row['scheduledTime'],
				"status"=>$row['status'],
				"statusCode"=>200,
				"message"=>"Data found successfully",
				"userAddress"=>$row['fullAddress'],
				"latitude"=>$row['latitude'],
				"longitude"=>$row['longitude']
			));
		}
	}

	mysqli_stmt_close($stmt);
	return $resultArray;
}