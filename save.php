<?php
	require_once 'config.php';	
	$document = array(
		"title" => $_POST['title'],
		"author" => $_POST['author']
	);
	$collection->insert($document);
	$document['_id'] = $document['_id'];
	echo json_encode($document);
?>