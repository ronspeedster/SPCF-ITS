<?php
	include 'dbh.php';
	$getURI = $_SESSION['getURI'];

	$currentDate = date_default_timezone_set('Asia/Manila');
	$currentDate = date('Y-m-d');

	$mysqli->query("CREATE TABLE IF NOT EXISTS ppfo_inventory.equipment_transfer ( id INT NULL AUTO_INCREMENT , equipment_id VARCHAR(12) NULL , type VARCHAR(128) NULL , from_building VARCHAR(12) NULL , from_lab VARCHAR(12) NULL , to_building VARCHAR(12) NULL , to_laboratory VARCHAR(12) NULL , date_added DATE NULL , status VARCHAR(32) NULL , PRIMARY KEY (id))") or die($mysqli->error());

	if(isset($_GET['pull_out'])){

		$unit_id = $_GET['unit_id'];
		$building = $_GET['building'];
		$laboratory = $_GET['laboratory'];

		$mysqli->query("UPDATE unit_pc SET lab_id='stock_room' WHERE unit_id='$unit_id'") or die ($mysqli->error());

		$mysqli->query("INSERT INTO equipment_transfer (equipment_id, type, from_building, from_lab, date_added, status) VALUES ('$unit_id','PC','$building','$laboratory','$currentDate','pending')") or die ($mysqli->error());

		$_SESSION['message'] = "PC has been pulled out!";
		$_SESSION['msg_type'] = "warning";

		header("location: ".$getURI);
	}

	if(isset($_GET['pull_out_fixture'])){
		echo $unit_id = $_GET['unit_id'];
		echo $building = $_GET['building'];
		echo $laboratory = $_GET['laboratory'];
		echo $type = $_GET['type'];

		$mysqli->query("UPDATE fixture SET lab_id='stock_room' WHERE id='$unit_id' ") or die ($mysqli->error());
		
		$mysqli->query("INSERT INTO equipment_transfer (equipment_id, type, from_building, from_lab, date_added, status) VALUES ('$unit_id','$type','$building','$laboratory','$currentDate','pending') ") or die ($mysqli->error());

		$_SESSION['message'] = "Fixture has been pulled out!";
		$_SESSION['msg_type'] = "warning";

		header("location: ".$getURI);
	}

	//Update PC Location
	if(isset($_POST['transfer_PC'])){
		$building_id = $_POST['building_id'];
		$lab_id =  $_POST['lab_id'];
		$equipment_id = $_POST['equipment_id'];
		$transfer_id = $_POST['transfer_id'];
		$mysqli->query("UPDATE unit_pc SET lab_id='$lab_id', building_id='$building_id' WHERE unit_id='$equipment_id'") or die ($mysqli->error());

		$mysqli->query("UPDATE equipment_transfer SET to_building ='$building_id', to_laboratory='$lab_id', status='completed' WHERE id='$transfer_id' ") or die ($mysqli->error());

		$_SESSION['message'] = "PC has been transferred successfully!";
		$_SESSION['msg_type'] = "success";

		header("location: pulled_out.php");
	}

	//Update Fixture Location
	if(isset($_POST['transfer_fixture'])){
		$building_id = $_POST['building_id'];
		$lab_id =  $_POST['lab_id'];
		$equipment_id = $_POST['equipment_id'];
		$transfer_id = $_POST['transfer_id'];

		$mysqli->query("UPDATE fixture SET lab_id='$lab_id', building_id='$building_id' WHERE id='$equipment_id'") or die ($mysqli->error());

		$mysqli->query("UPDATE equipment_transfer SET to_building ='$building_id', to_laboratory='$lab_id', status='completed' WHERE id='$transfer_id' ") or die ($mysqli->error());

		$_SESSION['message'] = "Fixture has been transferred successfully!";
		$_SESSION['msg_type'] = "success";

		header("location: pulled_out.php");
	}
?>