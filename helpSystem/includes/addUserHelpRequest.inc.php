<?php 
require 'validator.inc.php';

function validateData($userId,$task,$taskType,$fullAddress,$latitude,$longitude,$time){
	if(emptyFieldCheck($userId,$task,$taskType,$fullAddress,$latitude,$longitude,$time)!==1){
		return array(
			'statusCode' => emptyFieldCheck($userId,$task,$taskType,$fullAddress,$latitude,$longitude,$time),
			'message' => 'Fill in the Empty Fields'
			);
	} 

	else {
		return success();	
	}
}

function addUserHelpRequest($userId,$task,$taskType,$fullAddress,$latitude,$longitude,$time,$conn)
{
	$sql = "INSERT INTO assignedtasks (userId,task,taskType,fullAddress,latitude,longitude,scheduledTime) VALUES (?,?,?,?,?,?,?)";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return array(
			'statusCode' => '700',
			'message' => 'Mysql database connection error'
			);
	} else {
		mysqli_stmt_bind_param($stmt,"issssss",$userId,$task,$taskType,$fullAddress,$latitude,$longitude,$time);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		// mysqli_close($conn);
		return array(
			'statusCode' => success(),
			'message' => 'Task Added Successfull'
			);
	}
}