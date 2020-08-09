<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

	require '../includes/dbh.inc.php';
	require '../includes/getTasksByCategory.inc.php';

	// sample input
	// {
	// 	"category":"mechanic"
	// }

	$data = json_decode(file_get_contents("php://input"));

	$response = getTasksByCategory($data->category,$conn);

	if(count($response)<1){
		echo json_encode(array(
			'statusCode' => 701,
			'message' => "No tasks found" 
		));
	} else {
		echo json_encode($response);
	}