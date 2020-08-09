<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

	require '../includes/dbh.inc.php';
	require '../includes/getHelperActiveTask.inc.php';

	$data = json_decode(file_get_contents("php://input"));
	
	// sample data
	// {
	// 	"helperId": "5"
	// }
	
	$response = getHelperActiveTask($data->helperId,$conn);

	// TODO: check for empty helperid
	

	if(count($response)<1){
		echo json_encode(array(
			'statusCode' => 701,
			'message' => "You haven't accepted for any help yet" 
		));
	} else {
		echo json_encode($response);
	}