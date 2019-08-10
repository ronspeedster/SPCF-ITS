<?php
	include 'dbh.php';
	$date = date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d H:i:s');
	$current_username = $_SESSION['username'];
	$update_equipment = false;
	$equipment_description = '';
	$getURI=$_SESSION['getURI'];

	if(isset($_POST['save'])){
		//$peripheral_condition  = 'Working';
		#Monitor
		$peripheral_type = $_POST['equipment-type'];
		$peripheral_brand = strtoupper($_POST['brand']);
		$peripheral_description  = $_POST['equipment-description'];
		$peripheral_serial_no  = strtoupper($_POST['serial-id']);
		$peripheral_date_purchased = $_POST['date-of-purchased'];
		$peripheral_amount  = $_POST['amount'];
		$peripheral_date_issued = $_POST['date-issued'];
		$peripheral_condition = $_POST['condition'];
		$peripheral_remarks = $_POST['forRepair'];
		$unit_id = "StockRoom";
		$mysqli->query("INSERT INTO peripherals (peripheral_type, peripheral_brand, peripheral_description, peripheral_serial_no, peripheral_date_purchased , peripheral_amount, peripheral_date_issued, peripheral_condition, remarks, unit_id, added_by) VALUES('$peripheral_type','$peripheral_brand','$peripheral_description','$peripheral_serial_no','$peripheral_date_purchased','$peripheral_amount','$peripheral_date_issued','$peripheral_condition','$peripheral_remarks','$unit_id','$current_username')") or die($mysqli->error());

		$collatedLogs = "PERIPHERAL with TYPE: ". $peripheral_type.", BRAND: ". $peripheral_brand."CONDITION: ". $peripheral_condition;
		$logs = "Added: ".$collatedLogs;
		//Insert Logs
		$mysqli->query("INSERT INTO context_logs (username, description,date_added, type) VALUES('$current_username','$logs','$date','addition')");

		$_SESSION['message'] = "Record has been saved!";
		$_SESSION['msg_type'] = "success";

		header("location:".$getURI);
	}

	if(isset($_GET['delete'])){
		$peripheral_id = $_GET['delete'];
		
		//Delete Unit
		$mysqli->query("DELETE FROM peripherals WHERE peripheral_id=$peripheral_id") or die($mysqli->error());

		$_SESSION['message'] = "Record has been deleted!";
		$_SESSION['msg_type'] = "danger";
		
		header('location:'.$getURI);
	}
	if(isset($_GET['edit'])){
		$update_equipment = true;
		$peripheral_id = $_GET['edit'];
		$getPeripherals = $mysqli->query("SELECT * FROM peripherals WHERE peripheral_id=$peripheral_id") or die ($mysqli->error());
		//if(count($result)==1){
		$newPeripherals = $getPeripherals->fetch_array();
		$peripheral_id = $newPeripherals['peripheral_id'];
		$peripheral_type  = $newPeripherals['peripheral_type'];
		$peripheral_brand = $newPeripherals['peripheral_brand'];
		$peripheral_description = $newPeripherals['peripheral_description'];
		$peripheral_serial_no = $newPeripherals['peripheral_serial_no'];
		$peripheral_date_purchased = $newPeripherals['peripheral_date_purchased'];
		$peripheral_amount = $newPeripherals['peripheral_amount'];
		$peripheral_date_issued = $newPeripherals['peripheral_date_issued'];
		$peripheral_condition = $newPeripherals['peripheral_condition'];
		$remarks  = $newPeripherals['remarks'];
		$_SESSION['setEquipmentID'] = $peripheral_id;
	}

	if(isset($_POST['update'])){
		$peripheral_id = $_SESSION['setEquipmentID'];
		$peripheral_type = $_POST['equipment-type'];
		$peripheral_brand = strtoupper($_POST['brand']);
		$peripheral_description  = $_POST['equipment-description'];
		$peripheral_serial_no  = strtoupper($_POST['serial-id']);
		$peripheral_date_purchased = $_POST['date-of-purchased'];
		$peripheral_amount  = $_POST['amount'];
		$peripheral_date_issued = $_POST['date-issued'];
		$peripheral_condition = $_POST['condition'];
		$peripheral_remarks = $_POST['forRepair'];
		$unit_id = "StockRoom";

		$mysqli->query("UPDATE peripherals SET peripheral_type='$peripheral_type', peripheral_brand='$peripheral_brand', peripheral_description='$peripheral_description', peripheral_serial_no='$peripheral_serial_no', peripheral_date_purchased='$peripheral_date_purchased', peripheral_amount='$peripheral_amount', peripheral_date_issued='$peripheral_date_issued', peripheral_condition='$peripheral_condition', remarks='$peripheral_remarks' WHERE peripheral_id='$peripheral_id'") or die ($mysqli->error());

		$_SESSION['message'] = $peripheral_type ." information has been changed / updated!";
		$_SESSION['msg_type'] = "warning";

		header('location: misc_things.php');
	}
?>