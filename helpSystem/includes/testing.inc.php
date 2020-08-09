<?php 

require 'dbh.inc.php';
require 'updateStatus.inc.php';


//TESTING FOR UPDATESTATUS.INC.PHP
//TEST CASES
$assignedTasksId = 1;

// testDataView($assignedTasksId,$conn);
function testDataView($assignedTasksId,$conn)
{
	echo getStatusUser($assignedTasksId,$conn);
	echo "<br>";
	echo getStatusHelper($assignedTasksId,$conn);
	echo "<br>";
	echo gethelperId($assignedTasksId,$conn);
	echo "<br>";
	echo getStatus($assignedTasksId,$conn);
}

// testHelperId($assignedTasksId,$conn);
function testHelperId($assignedTasksId,$conn){
	if(updateStatus($assignedTasksId,$conn)==501)
		echo "successful";
	else 
		echo "failed";
}

// setStatusOnlineTest($assignedTasksId,$conn);
function setStatusOnlineTest($assignedTasksId,$conn)
{
	// SET DEFAULT HELPER ID
	$sql = "UPDATE assignedtasks SET helperId=123 WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		return 0;
	} else {
		mysqli_stmt_bind_param($stmt,"i",$assignedTasksId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}

	if(updateStatus($assignedTasksId,$conn)==200){
		return "successful";
	}
	else {
		return "failed";
	}

}

// setTaskCompletionTest($assignedTasksId,$conn);
function setTaskCompletionTest($assignedTasksId,$conn){
	$count = 0;
	//set user status to completed and helper status to online
	$sql = "UPDATE assignedtasks SET statusUser='completed',statusHelper='online' WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		echo 0;
		return;
	} else {
		mysqli_stmt_bind_param($stmt,"i",$assignedTasksId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}

	if(updateStatus($assignedTasksId,$conn)==200){
		echo "successful";
	}
	else {
		echo "failed";
		$count++;
	}

	echo "<br>";

	//set helper status to completed and user status to online
	$sql = "UPDATE assignedtasks SET statusUser='online',statusHelper='completed' WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		echo 0;
		return;
	} else {
		mysqli_stmt_bind_param($stmt,"i",$assignedTasksId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}

	if(updateStatus($assignedTasksId,$conn)==200){
		echo "successful";
	}
	else {
		echo "failed";
		$count++;
	}

	echo "<br>";

	//set helper status to completed and user status to completed
	$sql = "UPDATE assignedtasks SET statusUser='completed',statusHelper='completed' WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		echo 0;
		return;
	} else {
		mysqli_stmt_bind_param($stmt,"i",$assignedTasksId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}

	if(updateStatus($assignedTasksId,$conn)==200){
		echo "successful";
		$count++;
	}
	else {
		echo "failed";
	}

	echo "<br>";
	return $count;

}

function setTaskCencelletionTest($assignedTasksId,$conn){
	$count = 0;

	//user has cancelled
	//set cancelletion
	$sql = "UPDATE assignedtasks SET statusUser='cancelled',statusHelper='online',status='online' WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		echo 0;
		return;
	} else {
		mysqli_stmt_bind_param($stmt,"i",$assignedTasksId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}

	if(updateStatus($assignedTasksId,$conn)==200){
		echo "successful";
		$count++;
	}
	else {
		echo "failed";
	}

	echo "<br>";

	//helper has cancelled
	//set cancelletion
	$sql = "UPDATE assignedtasks SET statusUser='online',statusHelper='cancelled',status='online' WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		echo 0;
		return;
	} else {
		mysqli_stmt_bind_param($stmt,"i",$assignedTasksId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}

	if(updateStatus($assignedTasksId,$conn)==200){
		echo "successful";
		$count++;
	}
	else {
		echo "failed";
	}
	echo "<br>";

	return $count;
}


function unitTestFor_updateStatus($assignedTasksId,$conn){

	//reset data for test
	resetData($assignedTasksId,$conn);
	echo "data reset successful";
	echo "<br>";
	echo "_______________________________________________________";
	echo "<br>";
	
	//Task has been  recieved
	echo "Initial Data View";
	echo "<br>";
	testDataView($assignedTasksId,$conn);
	echo "<br>";
	echo "_______________________________________________________";
	echo "<br>";

	//helper is assigned to task
	//set status online
	echo "Test: setStatusOnlineTest";
	echo "<br>";
	echo "Result: " ;
	echo setStatusOnlineTest($assignedTasksId,$conn);
	echo "<br>";

	echo "Data View after test";
	echo "<br>";
	testDataView($assignedTasksId,$conn);
	echo "<br>";
	echo "_______________________________________________________";
	echo "<br>";

	//Task has been completed
	//check task completion
	echo "Test: setTaskCompletionTest";
	echo "<br>";
	echo "Result: ";
	echo "<br>"; 
	if(setTaskCompletionTest($assignedTasksId,$conn)==3){
		echo "finally successful";
	} else {
		echo "finally failed";
	}
	echo "<br>";

	echo "Data View after test";
	echo "<br>";
	testDataView($assignedTasksId,$conn);
	echo "<br>";
	echo "_______________________________________________________";
	echo "<br>";

	//Task has been cancelled
	//check task cancelletion
	echo "Test: setTaskCencelletionTest";
	echo "<br>";
	echo "Result: ";
	echo "<br>"; 
	if(setTaskCencelletionTest($assignedTasksId,$conn)==2){
		echo "finally successful";
	} else {
		echo "finally failed";
	}
	echo "<br>";

	echo "Data View after test";
	echo "<br>";
	testDataView($assignedTasksId,$conn);
	echo "<br>";
	echo "_______________________________________________________";
	echo "<br>";
	
	resetData($assignedTasksId,$conn);
	echo "Data View after reset";
	echo "<br>";
	testDataView($assignedTasksId,$conn);
	echo "<br>";
}

// resetData(1,$conn);
function resetData($assignedTasksId,$conn)
{
	$sql = "UPDATE assignedtasks SET helperId=0,statusUser='processing',statusHelper='processing',status='processing' WHERE assignedTaskId=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt,$sql)) {
		echo 0;
	} else {
		mysqli_stmt_bind_param($stmt,"i",$assignedTasksId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		// mysqli_close($conn);
		// return 1;
	}
}


unitTestFor_updateStatus($assignedTasksId,$conn);