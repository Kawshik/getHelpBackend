<?php 
function updateHelperInRequestQueue($requestedTasksId,$helperId,$conn)
{
	$sql = "UPDATE requestedtasks SET helperId=? WHERE requestedTasksId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return array(
			'statusCode' => '700',
			'message' => 'Mysql database connection error'
			);
	} else {
		mysqli_stmt_bind_param($stmt,"ii",$helperId,$requestedTasksId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		// updateStatus($assignedTaskId,$conn);
		mysqli_close($conn);
		return array(
			'statusCode' => success(),
			'message' => 'Helper Successfully Added'
			);
	}
}
