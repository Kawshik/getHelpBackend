<?php 

function getHelperHistory($helperId,$conn){
	$resultArray = array();

	$sql = "SELECT * FROM `assignedtasks` WHERE helperId = ? AND (status='cancelled' OR status = 'completed')";
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return array(
			'statusCode' => '700',
			'message' => 'Mysql database connection error'
			);
	} else {
		mysqli_stmt_bind_param($stmt,"i",$helperId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
			
		while($row = mysqli_fetch_assoc($result)){
			// var_dump($row);
			// taskType
			// task
			// helper id
			// requestTime
			// task start time (time)
			// status
			// echo $row['taskType'] . " " . $row['task'] . " " . $row['helperId'] . " " . $row['requestTime'] . " " . $row['time'] . " " . $row['status'] . " "; 
			// echo "<br>";
			array_push($resultArray, array(
				"taskId"=>$row['assignedTaskId'],
				"category"=>$row['taskType'],
				"description"=>$row['task'],
				"helperId"=>$row['helperId'],
				"requestTime"=>$row['requestTime'],
				"startTime"=>$row['time'],
				"status"=>$row['status'],
				"statusCode"=>'200',
				'message' => 'Data found successfully'
			));
		}

		mysqli_stmt_close($stmt);
		return $resultArray;
	}
}

// var_dump(getUserHistory(22,$conn));