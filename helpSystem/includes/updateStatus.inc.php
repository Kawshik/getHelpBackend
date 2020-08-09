<?php 

require 'dbh.inc.php';


function getStatus($assignedTasksId,$conn)
{
	$sql = "SELECT status FROM assignedtasks WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return 0;
	} else {
		mysqli_stmt_bind_param($stmt,"i",$assignedTasksId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = mysqli_fetch_assoc($result);
		mysqli_stmt_close($stmt);
		return $row['status'];
	}
}


function getStatusUser($assignedTasksId,$conn)
{
	$sql = "SELECT statusUser FROM assignedtasks WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return 0;
	} else {
		mysqli_stmt_bind_param($stmt,"i",$assignedTasksId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = mysqli_fetch_assoc($result);
		mysqli_stmt_close($stmt);
		return $row['statusUser'];
	}
}

function getStatusHelper($assignedTasksId,$conn)
{
	$sql = "SELECT statusHelper FROM assignedtasks WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return 0;
	} else {
		mysqli_stmt_bind_param($stmt,"i",$assignedTasksId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		
		$row = mysqli_fetch_assoc($result);
		mysqli_stmt_close($stmt);
		return $row['statusHelper'];
	}
}

function getHelperId($assignedTasksId,$conn)
{
	$sql = "SELECT helperId FROM assignedtasks WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return 0;
	} else {
		mysqli_stmt_bind_param($stmt,"i",$assignedTasksId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		
		$row = mysqli_fetch_assoc($result);
		mysqli_stmt_close($stmt);
		return $row['helperId'];
	}
}

function setStatusOnline($assignedTasksId,$conn)
{
	$sql = "UPDATE assignedtasks SET statusUser='online',statusHelper='online',status='online' WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return 0;
	} else {
		mysqli_stmt_bind_param($stmt,"i",$assignedTasksId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		// mysqli_close($conn);
		return 1;
	}
}

function setStatusCompleted($assignedTasksId,$conn)
{
	$sql = "UPDATE assignedtasks SET status='completed' WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return 0;
	} else {
		mysqli_stmt_bind_param($stmt,"i",$assignedTasksId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		// mysqli_close($conn);
		return 1;
	}
}

function setStatusCancelled($assignedTasksId,$conn)
{
	$sql = "UPDATE assignedtasks SET statusUser='cancelled',statusHelper='cancelled',status='cancelled' WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return 0;
	} else {
		mysqli_stmt_bind_param($stmt,"i",$assignedTasksId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		// mysqli_close($conn);
		return 1;
	}
}

function updateStatus($assignedTasksId,$conn)
{
	if(!getStatusUser($assignedTasksId,$conn) || !getStatusHelper($assignedTasksId,$conn)){
		mysqli_close($conn);
		return 700;
	} else {

		if (strcmp(getStatusUser($assignedTasksId,$conn),"cancelled")==0 || strcmp(getStatusHelper($assignedTasksId,$conn),"cancelled")==0) {
			return setStatusCancelled($assignedTasksId,$conn)?200:700;
			//TODO: delete task form request queue
		}

		if(getHelperId($assignedTasksId,$conn)==0){
			mysqli_close($conn);
			return 501;
		} else {

			if(strcmp(getStatusUser($assignedTasksId,$conn),"processing")==0 && strcmp(getStatusHelper($assignedTasksId,$conn),"processing")==0){
				return setStatusOnline($assignedTasksId,$conn)?200:700;
			} else if (strcmp(getStatusUser($assignedTasksId,$conn),"completed")==0 && strcmp(getStatusHelper($assignedTasksId,$conn),"completed")==0) {
				return setStatusCompleted($assignedTasksId,$conn)?200:700;
				//TODO: delete task form request queue
			} else {
				return 502;
			}
			// return 200;
		}
	}
}