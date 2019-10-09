<?php
	include 'dbh.php';
	$date = date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d H:i:s');

	$serial_no='';

	$vowels = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
	$batchID = date_default_timezone_set('Asia/Manila');
	$batchID = date('ymdHi');

	if(isset($_POST['save'])){
		$building_id =  $_POST['building'];
		$laboratory_id =  $_POST['laboratory'];
		$type =  $_POST['type'];
		$qty =  $_POST['qty'];
		$batchID = strtoupper(str_replace(" ", "", $type).$batchID);
		$startNo = 1;
		while($startNo<=$qty){
			$mysqli->query("INSERT INTO fixture (type, batch_code, building_id, lab_id, date_added, remarks) VALUES('$type','$batchID','$building_id','$laboratory_id','$date','OK')") or die($mysqli->error());
			$startNo++;
		}

		$_SESSION['message'] = "Fixtures has been added!";
		$_SESSION['msg_type'] = "success";
		header('location: fixtures.php');
	}
	//Update Fixture Details
	if(isset($_POST['update'])){
		$building_id =  $_POST['building_id'];
		$laboratory_id =  $_POST['lab_id'];
		$serial_no = strtoupper($_POST['serial_no']);
		$fixture_id = $_POST['fixture_id'];
		$mysqli->query("UPDATE fixture SET /*building_id = '$building_id',*/ serial_no = '$serial_no' /*, lab_id='$laboratory_id' */ WHERE id='$fixture_id' ") or die($mysqli->error());
		$_SESSION['message'] = "Fixture has been updated!";
		$_SESSION['msg_type'] = "success";

		$getURI = $_SESSION['getURI'];
		header('location: '.$getURI);
	}	

	//Submit Report Fixtures
	if(isset($_POST['submit_report'])){
		$fixture_id =  $_POST['fixture_id'];
		$status =  $_POST['status'];
		$condition = $_POST['condition'];

		$mysqli->query("UPDATE fixture SET remarks='$status', fixture_condition='$condition' WHERE id='$fixture_id'") or die($mysqli->error());

		$_SESSION['message'] = "Fixture has been reported!";
		$_SESSION['msg_type'] = "success";

		header('location: fixtures.php');
	}

	if(isset($_POST['submit_fix_report'])){
		$fixture_id =  $_POST['fixture_id'];
		$status =  $_POST['status'];
		$condition = $_POST['condition'];
		$repair_cost = $_POST['repair_cost'];

		$currentDate = date_default_timezone_set('Asia/Manila');
		$currentDate = date('Y-m-d-H-i-s');
		
		$newName = 'ItemID-'.$fixture_id.$status.$repair_cost.$currentDate;

		// get details of the uploaded file
		$fileTmpPath = $_FILES['image_receipt']['tmp_name'];
		$fileName = $_FILES['image_receipt']['name'];
		$fileSize = $_FILES['image_receipt']['size'];
		$fileType = $_FILES['image_receipt']['type'];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));
		//print_r($fileNameCmps);
		$newFileName = $newName . '.' . $fileExtension;
		//print_r($newFileName); 
		// directory in which the uploaded file will be moved
		$uploadFileDir = 'img/assets/';
		$dest_path = $uploadFileDir . $newFileName;
		
		if(move_uploaded_file($fileTmpPath, $dest_path))
		{		
			$_SESSION['message'] = "Fixture new details has been saved!";
			$_SESSION['msg_type'] = "success";
			$mysqli->query("UPDATE fixture SET remarks='$status', fixture_condition='$condition' WHERE id='$fixture_id'") or die($mysqli->error());

			$mysqli->query("INSERT INTO fix_report (type, item_id, repair_cost, date_added, file_name) VALUES ('fixture', '$fixture_id', '$repair_cost', '$currentDate', '$newFileName') ") or die ($mysqli->error());

			// Save Transcation
			$mysqli->query("INSERT INTO transaction_record (type, type_id, cost, date_added) VALUES ('fixed_fixture', '$fixture_id', '$repair_cost', '$currentDate') ") or die ($mysqli->error());
		}
		else{

			$_SESSION['message'] = "There was an error uploading the image receipt!";
			$_SESSION['msg_type'] = "danger";

		}
		
		header('location: for_repair_fixtures.php');
	}	
	
	//Delete Fixture
	if(isset($_GET['delete'])){
		$fixture_id = $_GET['delete'];
		$mysqli->query("DELETE FROM fixture WHERE id='$fixture_id'") or die($mysqli->error());
		$_SESSION['message'] = "Fixture has been deleted!";
		$_SESSION['msg_type'] = "danger";

		$getURI = $_SESSION['getURI'];
		header('location: '.$getURI);
	}

?>