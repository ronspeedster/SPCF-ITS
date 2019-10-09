<?php
	include 'dbh.php';
	$update_laboratory = false;
	$lab_name = '';
	$lab_description='';

	$userName = $_SESSION['username'];

	if(isset($_POST['save'])){
		$lab_id= $_POST['lab_id'];
		$lab_name = strtoupper($_POST['lab_name']);
		$lab_description = $_POST['lab_description'];
		$building_id = $_POST['building_id'];
		$lab_name_strip = str_replace(' ', '', $lab_name);
		$lab_code = substr($lab_name_strip, 0, 5).'00'.$lab_id;

		$mysqli->query("INSERT INTO laboratory (lab_id,lab_code,lab_name,lab_description,building_id, added_by) VALUES('$lab_id','$lab_code','$lab_name','$lab_description','$building_id','$userName')");
		
		$_SESSION['message'] = "Record has been saved!";
		$_SESSION['msg_type'] = "success";

		header("location: laboratories.php");
	}

	if(isset($_GET['delete'])){
		$lab_id = $_GET['delete'];
		$mysqli->query("DELETE FROM laboratory WHERE lab_id=$lab_id") or die($mysqli->error());

		//2019-10-09 - Cascade Deletion
		$mysqli->query("DELETE FROM unit_pc WHERE lab_id=$lab_id") or die($mysqli->error());

		$_SESSION['message'] = "Record has been deleted!";
		$_SESSION['msg_type'] = "danger";
		header("location: laboratories.php");
	}

	if(isset($_GET['edit'])){
		$update_laboratory = true;
		$lab_id = $_GET['edit'];
		$result = $mysqli->query("SELECT * FROM laboratory WHERE lab_id=$lab_id") or die ($mysqli->error());
		//if(count($result)==1){
		$row = $result->fetch_array();
		$lab_name = $row['lab_name'];
		$lab_description = $row['lab_description'];
		$lab_building_id = $row['building_id'];
			//$building_id = $row['building_id'];
		//}
	}

	if(isset($_POST['update'])){
		$lab_id = $_POST['lab_id'];
		$lab_name = strtoupper($_POST['lab_name']);
		$lab_name_strip = str_replace(' ', '', $lab_name);
		$lab_code = substr($lab_name_strip, 0, 5).'00'.$lab_id;
		$building_id = $_POST['building_id'];
		$lab_description = $_POST['lab_description'];
		$mysqli->query("UPDATE laboratory SET lab_code='$lab_code', lab_name='$lab_name', lab_description='$lab_description', building_id='$building_id' WHERE lab_id='$lab_id'") or die ($mysqli->error());
		$_SESSION['message'] = $lab_name ." information has been changed / updated!";
		$_SESSION['msg_type'] = "warning";

		header("location: laboratories.php");
	}
?>