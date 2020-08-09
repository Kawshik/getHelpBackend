<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

	require '../includes/dbh.inc.php';
	require '../includes/setStatusUserCompleted.inc.php';

	$data = json_decode(file_get_contents("php://input")); 

	// Sample Input Data
	// {
	// 	"assignedTaskId" : "1"
	// }

	$statuscode = setStatusUserCompleted($data->assignedTaskId,$conn);
	
	if($statuscode['statusCode']==200){
		//success message
		echo json_encode(array(
			'statusCode' => $statuscode['statusCode'],
			'message' => $statuscode['message']
		));
	} else {
		//error message
		echo json_encode(array(
				'statusCode' => $statuscode['statusCode'],
				'message' => $statuscode['message']
			));
	} 