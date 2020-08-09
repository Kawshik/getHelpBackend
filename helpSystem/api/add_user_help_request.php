<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

	require '../includes/dbh.inc.php';
	require '../includes/addUserHelpRequest.inc.php';
	// require '../includes/addRequestToRequestQueue.inc.php';

	$data = json_decode(file_get_contents("php://input"));

	// $data->username,$data->email,$data->password,$data->passwordRepeat,$conn  

	// Sample Input Data
	// {
	// 	"userId" : "22",
	// 	"task" : "tyre punture, engine blokage",
	// 	"taskType" : "Mechanic",
	// 	"fullAddress" : "Dolaigaon, Bongaigaon, Assam",
	// 	"latitude" : "26.503900",
	// 	"longitude" : "90.537600"
	// }

	$statuscode1 = validateData($data->userId,$data->task,$data->taskType,$data->fullAddress,$data->latitude,$data->longitude,$data->time);

	if($statuscode1==200){
		$statuscode2 = addUserHelpRequest($data->userId,$data->task,$data->taskType,$data->fullAddress,$data->latitude,$data->longitude,$data->time,$conn);

		// $statuscode3 = addRequestToRequestQueue($data->userId,$data->task,$data->taskType,$data->fullAddress,$data->latitude,$data->longitude,$conn);
		
		if($statuscode2['statusCode']==200){
			//success message
			echo json_encode(array(
				'statusCode' => $statuscode2['statusCode'],
				'message' => $statuscode2['message']
			));
		} else {
			//error message
			echo json_encode(array(
				'statusCode' => $statuscode2['statusCode'],
				'message' => $statuscode2['message']
			));
		}
	} else {
		//error message
		echo json_encode(array(
				'statusCode' => $statuscode1['statusCode'],
				'message' => $statuscode1['message']
			));
	} 