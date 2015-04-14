<?php
	require_once 'config.php';

	$search_string = $_GET['search_string'];
	$query = array('title' => new MongoRegex("/^$search_string/i"));	
	$cursor = $collection->find($query);

	$result = array();	
	foreach($cursor as $k => $row){
    	array_push($result, $row);
	}
	echo json_encode($result);
?>

