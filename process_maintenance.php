<?php
	include 'dbh.php';
	$currentDate = date_default_timezone_set('Asia/Manila');
	$currentDate = date('Y-m-d H:i:s');
	$userName = $_SESSION['username'];
	echo $editMaintenance = false;
	$id='';
	$requested_by='';
	if(isset($_POST['save'])){
		echo $department = $_POST['department'];
		echo $electrical = $_POST['electrical'];
		echo $mechanical = $_POST['mechanical'];
		echo $carpentry = $_POST['carpentry'];
		echo $janitorial = $_POST['janitorial'];
		echo $others = $_POST['others'];
		echo $others_text = $_POST['others_text'];
		echo $request = $_POST['request'];
		echo $action_taken = $_POST['action_taken'];

		$mysqli->query("INSERT INTO maintenance (department, date_requested, electrical, mechanical, carpentry, janitorial, others, others_text, request, action_taken, requested_by) VALUES('$department','$currentDate','$electrical','$mechanical','$carpentry','$janitorial','$others','$others_text','$request','$action_taken','$userName')") or die($mysqli->error());

		$_SESSION['message'] = "Request has been submitted! ";
		$_SESSION['msg_type'] = "success";

		$newURL = "maintenance.php?department=".$department."&electrical=".$electrical."&mechanical=".$mechanical."&carpentry=".$carpentry."&janitorial=".$janitorial."&others=".$others."&others_text=".$others_text."&request=".$request."&action_taken=".$action_taken."&date=".$currentDate."&userName=".$userName;
		header('location: '.$newURL);

	}

	if(isset($_POST['update'])){
		echo $department = $_POST['department'];
		echo $electrical = $_POST['electrical'];
		echo $mechanical = $_POST['mechanical'];
		echo $carpentry = $_POST['carpentry'];
		echo $janitorial = $_POST['janitorial'];
		echo $others = $_POST['others'];
		echo $others_text = $_POST['others_text'];
		echo $request = $_POST['request'];
		echo $action_taken = $_POST['action_taken'];
		echo $id = $_POST['id'];
		echo $username = $_POST['username'];
		
		$mysqli->query("UPDATE maintenance SET action_taken='$action_taken' WHERE id='$id'") or die($mysqli->error());

		$_SESSION['message'] = "Request has been updated! ";
		$_SESSION['msg_type'] = "success";

		$newURL = "maintenance.php?department=".$department."&electrical=".$electrical."&mechanical=".$mechanical."&carpentry=".$carpentry."&janitorial=".$janitorial."&others=".$others."&others_text=".$others_text."&request=".$request."&action_taken=".$action_taken."&date=".$currentDate."&userName=".$userName;
		header('location: '.$newURL);
	}

	if(isset($_GET['edit'])){
		$editMaintenance = true;
		$maintenanceID = $_GET['edit'];
		$getMaintenance = $mysqli->query("SELECT * FROM maintenance WHERE id=$maintenanceID") or die ($mysqli->error());
		$newMaintenance = $getMaintenance->fetch_array();
		$id = $newMaintenance['id'];
		$department = $newMaintenance['department'];
		$date = $newMaintenance['date_requested'];
		$request = $newMaintenance['request'];
		$requested_by = $newMaintenance['requested_by'];
	}

	if(isset($_GET['delete'])){
		$id = $_GET['delete'];
		$maintenanceID = $_GET['edit'];
		$mysqli->query("DELETE FROM maintenance WHERE id='$id'") or die($mysqli->error());

		$_SESSION['message'] = "Request has been deleted! ";
		$_SESSION['msg_type'] = "danger";
		header('location: view_maintenance.php');
	}

?>