<?php 
require 'validator.inc.php';
require 'updateStatus.inc.php';


function validateData($userId,$task,$taskType,$fullAddress,$latitude,$longitude){
	if(emptyFieldCheck($userId,$task,$taskType,$fullAddress,$latitude,$longitude)!==1){
		return array(
			'statusCode' => emptyFieldCheck($userId,$task,$taskType,$fullAddress,$latitude,$longitude),
			'message' => 'Fill in the Empty Fields'
			);
	} 

	else {
		return success();	
	}
}

function addHelperToRequest($assignedTaskId,$helperId,$time,$conn)
{
	$sql = "UPDATE assignedtasks SET helperId=?,time=? WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return array(
			'statusCode' => '700',
			'message' => 'Mysql database connection error'
			);
	} else {
		mysqli_stmt_bind_param($stmt,"isi",$helperId,$time,$assignedTaskId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		updateStatus($assignedTaskId,$conn);
		// mysqli_close($conn);
		return array(
			'statusCode' => success(),
			'message' => 'Helper Successfully Added'
			);
	}
}