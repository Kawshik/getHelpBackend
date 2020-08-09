<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

	require '../includes/dbh.inc.php';
	require '../includes/updateStatus.inc.php';

	$data = json_decode(file_get_contents("php://input"));

	// Sample Input Data
	// {
	// 	"assignedTaskId" : "1"
	// }

	$statuscode = updateStatus($data->assignedTaskId,$conn);
	// 200 700 501 502
	if($statuscode==200){
		//success message
		echo json_encode(array(
			'statusCode' => $statuscode,
			'message' => "Update Successsful"
		));
	} elseif ($statuscode==700) {
		echo json_encode(array(
			'statusCode' => $statuscode,
			'message' => "Update Unsuccesssful"
		));	
	}elseif ($statuscode==501) {
		echo json_encode(array(
			'statusCode' => $statuscode,
			'message' => "Update Unsuccesssful"
		));
	}elseif ($statuscode==502) {
		echo json_encode(array(
			'statusCode' => $statuscode,
			'message' => "Update Unsuccesssful"
		));
	} else {
		
	}