<?php 
// require 'validator.inc.php';

// function validateData($userId,$task,$taskType,$fullAddress,$latitude,$longitude){
// 	if(emptyFieldCheck($userId,$task,$taskType,$fullAddress,$latitude,$longitude)!==1){
// 		return array(
// 			'statusCode' => emptyFieldCheck($userId,$task,$taskType,$fullAddress,$latitude,$longitude),
// 			'message' => 'Fill in the Empty Fields'
// 			);
// 	} 

// 	else {
// 		return success();	
// 	}
// }

function addRequestToRequestQueue($userId,$task,$taskType,$fullAddress,$latitude,$longitude,$conn)
{
	$sql = "INSERT INTO requestedtasks (userId,task,taskType,fullAddress,latitude,longitude) VALUES (?,?,?,?,?,?)";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return array(
			'statusCode' => '700',
			'message' => 'Mysql database connection error'
			);
	} else {
		mysqli_stmt_bind_param($stmt,"isssss",$userId,$task,$taskType,$fullAddress,$latitude,$longitude);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		return array(
			'statusCode' => success(),
			'message' => 'Sign up Successfull'
			);
	}
}