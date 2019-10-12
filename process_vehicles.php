<?php
	include 'dbh.php';
	$update_building = false;
	$vehicle_name = '';
	$building_description = '';
	$vehicle_plate_no = '';
	$userName = $_SESSION['username'];
	
	if(isset($_POST['save'])){
		$vehicle_id= $_POST['vehicle_id'];
		$vehicle_name = strtoupper($_POST['vehicle_name']);
		$vehicle_type = strtoupper($_POST['vehicle_type']);
		$vehicle_plate_no = $_POST['vehicle_plate_no'];

		$mysqli->query("INSERT INTO vehicle (id, name, type, plate_no) VALUES('$vehicle_id', '$vehicle_name', '$vehicle_type', '$vehicle_plate_no') ") or die ($mysqli->error());

		$_SESSION['message'] = "Record has been saved!";
		$_SESSION['msg_type'] = "success";

		header("location: vehicle.php");
	}

	if(isset($_GET['delete'])){
		$vehicle_id = $_GET['delete'];
		$mysqli->query("DELETE FROM vehicle WHERE id=$vehicle_id") or die($mysqli->error());

		$_SESSION['message'] = "Vechicle has been deleted!";
		$_SESSION['msg_type'] = "danger";
		header("location: vehicle.php");
	}

	if(isset($_GET['edit'])){
		$update_building = true;
		$vehicle_id = $_GET['edit'];
		$result = $mysqli->query("SELECT * FROM vehicle WHERE id = '$vehicle_id' ") or die ($mysqli->error());
		$row = $result->fetch_array();

		$vehicle_id = $row['id'];
		$vehicle_name = $row['name'];
		$vehicle_plate_no = $row['plate_no'];
	}

	if(isset($_POST['update'])){
		$vehicle_id= $_POST['vehicle_id'];
		$vehicle_name = strtoupper($_POST['vehicle_name']);
		$vehicle_type = strtoupper($_POST['vehicle_type']);
		$vehicle_plate_no = $_POST['vehicle_plate_no'];

		$mysqli->query("UPDATE vehicle SET name = '$vehicle_name', type='$vehicle_type', plate_no = '$vehicle_plate_no' WHERE id = '$vehicle_id' ") or die ($mysqli->error());

		$_SESSION['message'] = $building_name." information has been changed / updated!";
		$_SESSION['msg_type'] = "warning";

		header("location: vehicle.php");
	}

	if(isset($_POST['submit_expense_vehicle'])){
		echo $vehicle_id = $_POST['vehicle_id'];
		echo $expense_type = strtoupper($_POST['expense_type']);
		echo $expense_description = $_POST['expense_description'];
		echo $expense_cost = $_POST['expense_cost'];
		$currentDate = date_default_timezone_set('Asia/Manila');
		$currentDate = date('Y-m-d-H-i-s');
		//$image_receipt = $_FILES['image_receipt']; 
		$newName = 'VehicleID-'.$vehicle_id.$expense_type.$expense_cost.$currentDate;

		// get details of the uploaded file
		$fileTmpPath = $_FILES['expense_receipt']['tmp_name'];
		$fileName = $_FILES['expense_receipt']['name'];
		$fileSize = $_FILES['expense_receipt']['size'];
		$fileType = $_FILES['expense_receipt']['type'];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));
		//print_r($fileNameCmps);

		//$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
		$newFileName = $newName . '.' . $fileExtension;
		//print_r($newFileName); 
		// directory in which the uploaded file will be moved
		$uploadFileDir = 'img/assets/';
		$dest_path = $uploadFileDir . $newFileName;

		if(move_uploaded_file($fileTmpPath, $dest_path))
		{
		 	$_SESSION['message'] = "Information has been saved!";
			$_SESSION['msg_type'] = "success";

			//Insert into Vehicle Expenses
			$mysqli->query("INSERT INTO vehicle_expense (vehicle_id, expense_type, expense_cost, expense_description, date_added, file_name) VALUES ('$vehicle_id', '$expense_type', '$expense_cost', '$expense_description', '$currentDate', '$newFileName' ) ") or die ($mysqli->error());

			// Save Transcation
			$mysqli->query("INSERT INTO transaction_record (type, type_id, cost, date_added) VALUES ('vehicle', '$vehicle_id', '$expense_cost', '$currentDate') ") or die ($mysqli->error());
		}
		else
		{
		 	$_SESSION['message'] = "There was an error uploading the image receipt!";
			$_SESSION['msg_type'] = "warning";
		}

		header('location: vehicle_expense.php');
	}	
?>