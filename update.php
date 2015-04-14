<?php
	require_once 'config.php';
	
	$query = array('title' => new MongoRegex('/^'.preg_quote($_POST['title']).'$/i'));	
	$cursor = $collection->find($query)->count();

	if($cursor == 0){
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
	}
	else{
		echo 0;
	}
	
?>
