<?php
	require_once 'config.php';
	
	$id = new MongoId($_POST['_id']);
	$document = $collection->findone(array('_id' => $id));
	
	//update
 	if((isset($_POST['title']) && $_POST['title'] != null)&&(isset($_POST['author']) && $_POST['author'] != null)){
		$collection->update(
			array( '_id' => new MongoId($_POST['_id'])),
			array( '$set' => array( 'title' => $_POST['title'], 'author' => $_POST['author'] ) )
		);
	}
	echo 1;
?>
