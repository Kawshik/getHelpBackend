<?php 
require 'updateStatus.inc.php';

function setStatusHelperCancelled($assignedTaskId,$conn)
{
	$sql = "UPDATE assignedtasks SET statusHelper='cancelled' WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return array(
			'statusCode' => '700',
			'message' => 'Mysql database connection error'
			);
	} else {
		mysqli_stmt_bind_param($stmt,"i",$assignedTaskId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		updateStatus($assignedTaskId,$conn);
		// mysqli_close($conn);
		return array(
			'statusCode' => "200",
			'message' => 'Status Helper Updated Successfully'
			);
	}
}