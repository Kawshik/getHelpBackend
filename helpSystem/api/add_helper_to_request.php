<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

	require '../includes/dbh.inc.php';
	require '../includes/addHelperToRequest.inc.php';
	// require '../includes/updateHelperInRequestQueue.inc.php';

	$data = json_decode(file_get_contents("php://input")); 

	// Sample Input Data
	// {
	// 	"assignedTaskId" : "1",
	// 	"helperId" : "123",
	// 	"time" : "2020-01-02 20:09:40"
	// }

	$statuscode = addHelperToRequest($data->assignedTaskId,$data->helperId,$data->time,$conn);
	// $statuscode1 = updateHelperInRequestQueue($data->assignedTaskId,$data->helperId,$conn);

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