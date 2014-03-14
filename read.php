<?php
	require_once 'config.php';

	$cursor = $collection->find();
	$result = array();
	
	foreach($cursor as $k => $row){
    	array_push($result, $row);
	}
	echo json_encode($result);
?>
