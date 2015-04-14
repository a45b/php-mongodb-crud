<?php
	require_once 'config.php';	
	
	$query = array('title' => new MongoRegex('/^'.preg_quote($_POST['title']).'$/i'));	
	$cursor = $collection->find($query)->count();
	if($cursor == 0){
		$document = array(
		"title" => $_POST['title'],
		"author" => $_POST['author']
		);
		$collection->insert($document);
		$document['_id'] = $document['_id'];
		echo json_encode($document);
	}
	else{
		echo 0;	
	}
	
?>