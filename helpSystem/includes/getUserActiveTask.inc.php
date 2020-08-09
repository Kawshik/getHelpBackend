<?php 

function getUserActiveTask($userId,$conn){
	$resultArray = array();

	$sql = "SELECT * FROM `assignedtasks` WHERE userId = ? AND (status='processing' OR status = 'online')";
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return array(
			'statusCode' => '700',
			'message' => 'Mysql database connection error'
			);
	} else {
		mysqli_stmt_bind_param($stmt,"i",$userId);
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
				'message' => 'Data found successfully'
			));
		}

		mysqli_stmt_close($stmt);
		return $resultArray;
	}
}