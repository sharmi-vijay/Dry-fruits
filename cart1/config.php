<?php
	$conn = new mysqli("localhost","root","","shop_inventory");
	if($conn->connect_error){
		die("Connection Failed!".$conn->connect_error);
	}
?>