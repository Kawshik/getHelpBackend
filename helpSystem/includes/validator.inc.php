<?php

$statusCode = 1;
function emptyFieldCheck($userId,$task,$taskType,$fullAddress,$latitude,$longitude,$time){
	if(empty($userId) || empty($task) || empty($taskType) || empty($fullAddress) || empty($latitude) || empty($longitude) || empty($time)){
		$statusCode = 106;
	} else {
		$statusCode = 1;
	}
	return $statusCode;
}


//Login Validators
function emptyFieldsCheck($mailuid,$password){
	if(empty($mailuid) || empty($password)){
		$statusCode = 106;
	} else {
		$statusCode = 1;
	}
	return $statusCode;
}

function passwordCheck($mailuid,$password,$conn) {

	$sql = "SELECT * FROM helpers WHERE uidHelpers=? OR emailHelpers=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		$statusCode = 700;
	} else {
		mysqli_stmt_bind_param($stmt,"ss",$mailuid,$mailuid);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if ($row = mysqli_fetch_assoc($result)) {
			$pwdCheck = password_verify($password,$row['pwdHelpers']);
				if($pwdCheck==false){
					$statusCode = 111;
			 	}  
				else {
					$statusCode = 1;
				}
			}else {
				$statusCode = 112;
			} 			
		}
		return $statusCode;
}

function success(){
	return 200;
}
