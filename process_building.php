<?php
	/*
	session_start();
	$host = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'ppfo_inventory';

	$mysqli = new mysqli($host,$username,$password,$database) or die(mysql_error($mysqli));
	*/
	include 'dbh.php';
	$update_building = false;
	$building_name = '';
	$building_description='';

	if(isset($_POST['save'])){
		$building_id= $_POST['building_id'];
		$building_name = strtoupper($_POST['building_name']);
		$building_description = $_POST['building_description'];
		$building_name_strip = str_replace(' ', '', $building_name);
		$building_code = substr($building_name_strip, 0, 5).'00'.$building_id;

		$mysqli->query("INSERT INTO building (building_id,building_code,building_name,building_description) VALUES('$building_id','$building_code','$building_name','$building_description')");
		$_SESSION['message'] = "Record has been saved!";
		$_SESSION['msg_type'] = "success";

		header("location: building.php");
	}

	if(isset($_GET['delete'])){
		$building_id = $_GET['delete'];
		$mysqli->query("DELETE FROM building WHERE building_id=$building_id") or die($mysqli->error());

		$_SESSION['message'] = "Record has been deleted!";
		$_SESSION['msg_type'] = "danger";
		header("location: building.php");
	}

	if(isset($_GET['edit'])){
		$update_building = true;
		$building_id = $_GET['edit'];
		$result = $mysqli->query("SELECT * FROM building WHERE building_id=$building_id") or die ($mysqli->error());
		//if(count($result)==1){
			$row = $result->fetch_array();
			$building_name = $row['building_name'];
			$building_description = $row['building_description'];
			//$building_id = $row['building_id'];
		//}
	}

	if(isset($_POST['update'])){
		$building_id = $_POST['building_id'];
		$building_name = strtoupper($_POST['building_name']);
		$building_description = $_POST['building_description'];
		$building_name_strip = str_replace(' ', '', $building_name);
		$building_code = substr($building_name_strip, 0, 5).'00'.$building_id;
		$mysqli->query("UPDATE building SET building_code='$building_code',building_name='$building_name', building_description='$building_description' WHERE building_id='$building_id'") or die ($mysqli->error());

		$_SESSION['message'] = $building_name." information has been changed / updated!";
		$_SESSION['msg_type'] = "warning";

		header("location: building.php");
	}
?>