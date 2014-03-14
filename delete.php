<?php
	require_once 'config.php';
	$id = new MongoId($_POST['_id']);
	$res = $collection->remove(array('_id'=> $id), array("justOne" => true) );
	echo json_encode($res);
?>
