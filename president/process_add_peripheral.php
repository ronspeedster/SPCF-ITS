<?php
	include 'dbh.php';
	$update_pc_unit = false;
	$date = date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d H:i:s');
	$getURI = $_SESSION['getURI'];
	$current_username = $_SESSION['username'];
	if(isset($_POST['save'])){
		$unit_id = $_POST['unit_id'];
		$peripheral_condition  = 'Working';
		$peripheral_remarks = 'Not For Repair';

		#Monitor
		$peripheral_type = "Monitor";
		$peripheral_brand = strtoupper($_POST['monitor-brand']);
		$peripheral_description  = $_POST['monitor-description'];
		$peripheral_serial_no  = strtoupper($_POST['monitor-serialno']);
		$peripheral_date_purchased = $_POST['monitor-datepurchase'];
		echo $peripheral_amount  = $_POST['monitor-amount'];
		$peripheral_date_issued = $_POST['monitor-dateissue'];
		#$peripheral_remarks = $_POST['monitor-remarks'];

		$mysqli->query("INSERT INTO peripherals (peripheral_type, peripheral_brand, peripheral_description, peripheral_serial_no, peripheral_date_purchased , peripheral_amount, peripheral_date_issued, peripheral_condition, remarks, unit_id, added_by) VALUES('$peripheral_type','$peripheral_brand','$peripheral_description','$peripheral_serial_no','$peripheral_date_purchased','$peripheral_amount','$peripheral_date_issued','$peripheral_condition','$peripheral_remarks','$unit_id','$current_username')") or die($mysqli->error());

		#Keyboard
		$peripheral_type = "Keyboard";
		$peripheral_brand = strtoupper($_POST['keyboard-brand']);
		$peripheral_description  = $_POST['keyboard-description'];
		$peripheral_serial_no  = strtoupper($_POST['keyboard-serialno']);
		$peripheral_date_purchased = $_POST['keyboard-datepurchase'];
		$peripheral_amount  = $_POST['keyboard-amount'];
		$peripheral_date_issued = $_POST['keyboard-dateissue'];
		#$peripheral_remarks = $_POST['keyboard-remarks'];

		$mysqli->query("INSERT INTO peripherals (peripheral_type, peripheral_brand, peripheral_description, peripheral_serial_no, peripheral_date_purchased , peripheral_amount, peripheral_date_issued, peripheral_condition, remarks, unit_id, added_by) VALUES('$peripheral_type','$peripheral_brand','$peripheral_description','$peripheral_serial_no','$peripheral_date_purchased','$peripheral_amount','$peripheral_date_issued','$peripheral_condition','$peripheral_remarks','$unit_id','$current_username')") or die($mysqli->error());

		#Mouse
		$peripheral_type = "Mouse";
		$peripheral_brand = strtoupper($_POST['mouse-brand']);
		$peripheral_description  = $_POST['mouse-description'];
		$peripheral_serial_no  = strtoupper($_POST['mouse-serialno']);
		$peripheral_date_purchased = $_POST['mouse-datepurchase'];
		$peripheral_amount  = $_POST['mouse-amount'];
		$peripheral_date_issued = $_POST['mouse-dateissue'];
		#$peripheral_remarks = $_POST['mouse-remarks'];

		$mysqli->query("INSERT INTO peripherals (peripheral_type, peripheral_brand, peripheral_description, peripheral_serial_no, peripheral_date_purchased , peripheral_amount, peripheral_date_issued, peripheral_condition, remarks, unit_id,added_by) VALUES('$peripheral_type','$peripheral_brand','$peripheral_description','$peripheral_serial_no','$peripheral_date_purchased','$peripheral_amount','$peripheral_date_issued','$peripheral_condition','$peripheral_remarks','$unit_id','$current_username')") or die($mysqli->error());

		#AVR
		$peripheral_type = "AVR";
		$peripheral_brand = strtoupper($_POST['AVR-brand']);
		$peripheral_description  = $_POST['AVR-description'];
		$peripheral_serial_no  = strtoupper($_POST['AVR-serialno']);
		$peripheral_date_purchased = $_POST['AVR-datepurchase'];
		$peripheral_amount  = $_POST['AVR-amount'];
		$peripheral_date_issued = $_POST['AVR-dateissue'];
		#$peripheral_remarks = $_POST['AVR-remarks'];

		$mysqli->query("INSERT INTO peripherals (peripheral_type, peripheral_brand, peripheral_description, peripheral_serial_no, peripheral_date_purchased , peripheral_amount, peripheral_date_issued, peripheral_condition, remarks, unit_id, added_by) VALUES('$peripheral_type','$peripheral_brand','$peripheral_description','$peripheral_serial_no','$peripheral_date_purchased','$peripheral_amount','$peripheral_date_issued','$peripheral_condition','$peripheral_remarks','$unit_id','$current_username')") or die($mysqli->error());

		#Headset
		$peripheral_type = "Headset";
		$peripheral_brand = strtoupper($_POST['headset-brand']);
		$peripheral_description  = $_POST['headset-description'];
		$peripheral_serial_no  = strtoupper($_POST['headset-serialno']);
		$peripheral_date_purchased = $_POST['headset-datepurchase'];
		$peripheral_amount  = $_POST['headset-amount'];
		$peripheral_date_issued = $_POST['headset-dateissue'];
		#$peripheral_remarks = $_POST['headset-remarks'];

		$mysqli->query("INSERT INTO peripherals (peripheral_type, peripheral_brand, peripheral_description, peripheral_serial_no, peripheral_date_purchased , peripheral_amount, peripheral_date_issued, peripheral_condition, remarks, unit_id,added_by) VALUES('$peripheral_type','$peripheral_brand','$peripheral_description','$peripheral_serial_no','$peripheral_date_purchased','$peripheral_amount','$peripheral_date_issued','$peripheral_condition','$peripheral_remarks','$unit_id','$current_username')") or die($mysqli->error());

		#CPU
		$peripheral_type = "CPU";
		$peripheral_brand = strtoupper($_POST['cpu-brand']);
		$peripheral_description  = $_POST['cpu-description'];
		$peripheral_serial_no  = strtoupper($_POST['cpu-serialno']);
		$peripheral_date_purchased = $_POST['cpu-datepurchase'];
		$peripheral_amount  = $_POST['cpu-amount'];
		$peripheral_date_issued = $_POST['cpu-dateissue'];
		#$peripheral_remarks = $_POST['cpu-remarks'];

		$mysqli->query("INSERT INTO peripherals (peripheral_type, peripheral_brand, peripheral_description, peripheral_serial_no, peripheral_date_purchased , peripheral_amount, peripheral_date_issued, peripheral_condition, remarks, unit_id,added_by) VALUES('$peripheral_type','$peripheral_brand','$peripheral_description','$peripheral_serial_no','$peripheral_date_purchased','$peripheral_amount','$peripheral_date_issued','$peripheral_condition','$peripheral_remarks','$unit_id','$current_username')") or die($mysqli->error());

		#Motherboard
		$peripheral_type = "Motherboard";
		$peripheral_brand = strtoupper($_POST['motherboard-brand']);
		$peripheral_description  = $_POST['motherboard-description'];
		$peripheral_serial_no  = strtoupper($_POST['motherboard-serialno']);
		$peripheral_date_purchased = $_POST['motherboard-datepurchase'];
		$peripheral_amount  = $_POST['motherboard-amount'];
		$peripheral_date_issued = $_POST['motherboard-dateissue'];
		#$peripheral_remarks = $_POST['motherboard-remarks'];

		$mysqli->query("INSERT INTO peripherals (peripheral_type, peripheral_brand, peripheral_description, peripheral_serial_no, peripheral_date_purchased , peripheral_amount, peripheral_date_issued, peripheral_condition, remarks, unit_id,added_by) VALUES('$peripheral_type','$peripheral_brand','$peripheral_description','$peripheral_serial_no','$peripheral_date_purchased','$peripheral_amount','$peripheral_date_issued','$peripheral_condition','$peripheral_remarks','$unit_id','$current_username')") or die($mysqli->error());

		#GPU
		$peripheral_type = "GPU";
		$peripheral_brand = strtoupper($_POST['gpu-brand']);
		$peripheral_description  = $_POST['gpu-description'];
		$peripheral_serial_no  = strtoupper($_POST['gpu-serialno']);
		$peripheral_date_purchased = $_POST['gpu-datepurchase'];
		$peripheral_amount  = $_POST['gpu-amount'];
		$peripheral_date_issued = $_POST['gpu-dateissue'];
		#$peripheral_remarks = $_POST['gpu-remarks'];

		$mysqli->query("INSERT INTO peripherals (peripheral_type, peripheral_brand, peripheral_description, peripheral_serial_no, peripheral_date_purchased , peripheral_amount, peripheral_date_issued, peripheral_condition, remarks, unit_id,added_by) VALUES('$peripheral_type','$peripheral_brand','$peripheral_description','$peripheral_serial_no','$peripheral_date_purchased','$peripheral_amount','$peripheral_date_issued','$peripheral_condition','$peripheral_remarks','$unit_id','$current_username')") or die($mysqli->error());
		
		#RAM
		$peripheral_type = "RAM";
		$peripheral_brand = strtoupper($_POST['ram-brand']);
		$peripheral_description  = $_POST['ram-description'];
		$peripheral_serial_no  = strtoupper($_POST['ram-serialno']);
		$peripheral_date_purchased = $_POST['ram-datepurchase'];
		$peripheral_amount  = $_POST['ram-amount'];
		$peripheral_date_issued = $_POST['ram-dateissue'];
		#$peripheral_remarks = $_POST['ram-remarks'];

		$mysqli->query("INSERT INTO peripherals (peripheral_type, peripheral_brand, peripheral_description, peripheral_serial_no, peripheral_date_purchased , peripheral_amount, peripheral_date_issued, peripheral_condition, remarks, unit_id,added_by) VALUES('$peripheral_type','$peripheral_brand','$peripheral_description','$peripheral_serial_no','$peripheral_date_purchased','$peripheral_amount','$peripheral_date_issued','$peripheral_condition','$peripheral_remarks','$unit_id','$current_username')") or die($mysqli->error());


		#HDD
		$peripheral_type = "HDD";
		$peripheral_brand = strtoupper($_POST['hdd-brand']);
		$peripheral_description  = $_POST['hdd-description'];
		$peripheral_serial_no  = strtoupper($_POST['hdd-serialno']);
		$peripheral_date_purchased = $_POST['hdd-datepurchase'];
		$peripheral_amount  = $_POST['hdd-amount'];
		$peripheral_date_issued = $_POST['hdd-dateissue'];
		#s$peripheral_remarks = $_POST['hdd-remarks'];

		$mysqli->query("INSERT INTO peripherals (peripheral_type, peripheral_brand, peripheral_description, peripheral_serial_no, peripheral_date_purchased , peripheral_amount, peripheral_date_issued, peripheral_condition, remarks, unit_id,added_by) VALUES('$peripheral_type','$peripheral_brand','$peripheral_description','$peripheral_serial_no','$peripheral_date_purchased','$peripheral_amount','$peripheral_date_issued','$peripheral_condition','$peripheral_remarks','$unit_id','$current_username')") or die($mysqli->error());
		

		$logs = "Added PERIPHERALS to Unit PC with and ID: ". $unit_id;

		//Insert logs
		$mysqli->query("INSERT INTO context_logs (username, description, date_added,type) VALUES('$current_username','$logs','$date','addition')");


		$_SESSION['message'] = "PC Parts Addition Success!";
		$_SESSION['msg_type'] = "Success";

		
		header('location:'.$getURI);
	}

	if(isset($_GET['delete'])){
		$unit_id = $_GET['delete'];
		$getURI = $_SESSION['getURI'];
		$mysqli->query("DELETE FROM unit_pc WHERE unit_id=$unit_id") or die($mysqli->error());

		$_SESSION['message'] = "Record has been deleted!";
		$_SESSION['msg_type'] = "danger";

		header('location:'.$getURI);
	}

	if(isset($_GET['edit'])){

	}

	if(isset($_POST['update'])){
		// $building_id = $_POST['building_id'];
		// $building_name = strtoupper($_POST['building_name']);
		// $building_description = $_POST['building_description'];
		// $building_name_strip = str_replace(' ', '', $building_name);
		// $building_code = substr($building_name_strip, 0, 5).'00'.$building_id;
		// $mysqli->query("UPDATE building SET building_code='$building_code',building_name='$building_name', building_description='$building_description' WHERE building_id='$building_id'") or die ($mysqli->error());

		// $_SESSION['message'] = $building_name." information has been changed / updated!";
		// $_SESSION['msg_type'] = "warning";

		$unit_id = $_POST['unit_id'];
		$peripheral_condition  = 'Working';
		#Monitor
		$peripheral_type = "Monitor";
		$peripheral_brand = strtoupper($_POST['monitor-brand']);
		$peripheral_description  = $_POST['monitor-description'];
		$peripheral_serial_no  = strtoupper($_POST['monitor-serialno']);
		$peripheral_date_purchased = $_POST['monitor-datepurchase'];
		$peripheral_amount  = $_POST['monitor-amount'];
		$peripheral_date_issued = $_POST['monitor-dateissue'];

		$mysqli->query("UPDATE peripherals SET peripheral_brand='$peripheral_brand',peripheral_description='$peripheral_description', peripheral_serial_no='$peripheral_serial_no', peripheral_date_purchased='$peripheral_date_purchased', peripheral_amount='$peripheral_amount', peripheral_date_issued='$peripheral_date_issued' WHERE peripheral_type='$peripheral_type' AND unit_id='$unit_id'") or die ($mysqli->error());

		#Keyboard
		$peripheral_type = "Keyboard";
		$peripheral_brand = strtoupper($_POST['keyboard-brand']);
		$peripheral_description  = $_POST['keyboard-description'];
		$peripheral_serial_no  = strtoupper($_POST['keyboard-serialno']);
		$peripheral_date_purchased = $_POST['keyboard-datepurchase'];
		$peripheral_amount  = $_POST['keyboard-amount'];
		$peripheral_date_issued = $_POST['keyboard-dateissue'];
		
		$mysqli->query("UPDATE peripherals SET peripheral_brand='$peripheral_brand',peripheral_description='$peripheral_description', peripheral_serial_no='$peripheral_serial_no', peripheral_date_purchased='$peripheral_date_purchased', peripheral_amount='$peripheral_amount', peripheral_date_issued='$peripheral_date_issued' WHERE peripheral_type='$peripheral_type' AND unit_id='$unit_id'") or die ($mysqli->error());
		
		#Mouse
		$peripheral_type = "Mouse";
		$peripheral_brand = strtoupper($_POST['mouse-brand']);
		$peripheral_description  = $_POST['mouse-description'];
		$peripheral_serial_no  = strtoupper($_POST['mouse-serialno']);
		$peripheral_date_purchased = $_POST['mouse-datepurchase'];
		$peripheral_amount  = $_POST['mouse-amount'];
		$peripheral_date_issued = $_POST['mouse-dateissue'];

		$mysqli->query("UPDATE peripherals SET peripheral_brand='$peripheral_brand',peripheral_description='$peripheral_description', peripheral_serial_no='$peripheral_serial_no', peripheral_date_purchased='$peripheral_date_purchased', peripheral_amount='$peripheral_amount', peripheral_date_issued='$peripheral_date_issued' WHERE peripheral_type='$peripheral_type' AND unit_id='$unit_id'") or die ($mysqli->error());

		#AVR
		$peripheral_type = "AVR";
		$peripheral_brand = strtoupper($_POST['AVR-brand']);
		$peripheral_description  = $_POST['AVR-description'];
		$peripheral_serial_no  = strtoupper($_POST['AVR-serialno']);
		$peripheral_date_purchased = $_POST['AVR-datepurchase'];
		$peripheral_amount  = $_POST['AVR-amount'];
		$peripheral_date_issued = $_POST['AVR-dateissue'];

		$mysqli->query("UPDATE peripherals SET peripheral_brand='$peripheral_brand',peripheral_description='$peripheral_description', peripheral_serial_no='$peripheral_serial_no', peripheral_date_purchased='$peripheral_date_purchased', peripheral_amount='$peripheral_amount', peripheral_date_issued='$peripheral_date_issued' WHERE peripheral_type='$peripheral_type' AND unit_id='$unit_id'") or die ($mysqli->error());

		#Headset
		$peripheral_type = "Headset";
		$peripheral_brand = strtoupper($_POST['headset-brand']);
		$peripheral_description  = $_POST['headset-description'];
		$peripheral_serial_no  = strtoupper($_POST['headset-serialno']);
		$peripheral_date_purchased = $_POST['headset-datepurchase'];
		$peripheral_amount  = $_POST['headset-amount'];
		$peripheral_date_issued = $_POST['headset-dateissue'];

		$mysqli->query("UPDATE peripherals SET peripheral_brand='$peripheral_brand',peripheral_description='$peripheral_description', peripheral_serial_no='$peripheral_serial_no', peripheral_date_purchased='$peripheral_date_purchased', peripheral_amount='$peripheral_amount', peripheral_date_issued='$peripheral_date_issued' WHERE peripheral_type='$peripheral_type' AND unit_id='$unit_id'") or die ($mysqli->error());

		#CPU
		$peripheral_type = "CPU";
		$peripheral_brand = strtoupper($_POST['cpu-brand']);
		$peripheral_description  = $_POST['cpu-description'];
		$peripheral_serial_no  = strtoupper($_POST['cpu-serialno']);
		$peripheral_date_purchased = $_POST['cpu-datepurchase'];
		$peripheral_amount  = $_POST['cpu-amount'];
		$peripheral_date_issued = $_POST['cpu-dateissue'];

		$mysqli->query("UPDATE peripherals SET peripheral_brand='$peripheral_brand',peripheral_description='$peripheral_description', peripheral_serial_no='$peripheral_serial_no', peripheral_date_purchased='$peripheral_date_purchased', peripheral_amount='$peripheral_amount', peripheral_date_issued='$peripheral_date_issued' WHERE peripheral_type='$peripheral_type' AND unit_id='$unit_id'") or die ($mysqli->error());

		#Motherboard
		$peripheral_type = "Motherboard";
		$peripheral_brand = strtoupper($_POST['motherboard-brand']);
		$peripheral_description  = $_POST['motherboard-description'];
		$peripheral_serial_no  = strtoupper($_POST['motherboard-serialno']);
		$peripheral_date_purchased = $_POST['motherboard-datepurchase'];
		$peripheral_amount  = $_POST['motherboard-amount'];
		$peripheral_date_issued = $_POST['motherboard-dateissue'];

		$mysqli->query("UPDATE peripherals SET peripheral_brand='$peripheral_brand',peripheral_description='$peripheral_description', peripheral_serial_no='$peripheral_serial_no', peripheral_date_purchased='$peripheral_date_purchased', peripheral_amount='$peripheral_amount', peripheral_date_issued='$peripheral_date_issued' WHERE peripheral_type='$peripheral_type' AND unit_id='$unit_id'") or die ($mysqli->error());

		#GPU
		$peripheral_type = "GPU";
		$peripheral_brand = strtoupper($_POST['gpu-brand']);
		$peripheral_description  = $_POST['gpu-description'];
		$peripheral_serial_no  = strtoupper($_POST['gpu-serialno']);
		$peripheral_date_purchased = $_POST['gpu-datepurchase'];
		$peripheral_amount  = $_POST['gpu-amount'];
		$peripheral_date_issued = $_POST['gpu-dateissue'];

		$mysqli->query("UPDATE peripherals SET peripheral_brand='$peripheral_brand',peripheral_description='$peripheral_description', peripheral_serial_no='$peripheral_serial_no', peripheral_date_purchased='$peripheral_date_purchased', peripheral_amount='$peripheral_amount', peripheral_date_issued='$peripheral_date_issued' WHERE peripheral_type='$peripheral_type' AND unit_id='$unit_id'") or die ($mysqli->error());				

		#RAM
		$peripheral_type = "RAM";
		$peripheral_brand = strtoupper($_POST['ram-brand']);
		$peripheral_description  = $_POST['ram-description'];
		$peripheral_serial_no  = strtoupper($_POST['ram-serialno']);
		$peripheral_date_purchased = $_POST['ram-datepurchase'];
		$peripheral_amount  = $_POST['ram-amount'];
		$peripheral_date_issued = $_POST['ram-dateissue'];


		$mysqli->query("UPDATE peripherals SET peripheral_brand='$peripheral_brand',peripheral_description='$peripheral_description', peripheral_serial_no='$peripheral_serial_no', peripheral_date_purchased='$peripheral_date_purchased', peripheral_amount='$peripheral_amount', peripheral_date_issued='$peripheral_date_issued' WHERE peripheral_type='$peripheral_type' AND unit_id='$unit_id'") or die ($mysqli->error());

		#HDD
		$peripheral_type = "HDD";
		$peripheral_brand = strtoupper($_POST['hdd-brand']);
		$peripheral_description  = $_POST['hdd-description'];
		$peripheral_serial_no  = strtoupper($_POST['hdd-serialno']);
		$peripheral_date_purchased = $_POST['hdd-datepurchase'];
		$peripheral_amount  = $_POST['hdd-amount'];
		$peripheral_date_issued = $_POST['hdd-dateissue'];
		
		$mysqli->query("UPDATE peripherals SET peripheral_brand='$peripheral_brand',peripheral_description='$peripheral_description', peripheral_serial_no='$peripheral_serial_no', peripheral_date_purchased='$peripheral_date_purchased', peripheral_amount='$peripheral_amount', peripheral_date_issued='$peripheral_date_issued' WHERE peripheral_type='$peripheral_type' AND unit_id='$unit_id'") or die ($mysqli->error());


		$_SESSION['message'] = "Update success!";
		$_SESSION['msg_type'] = "success";
		header('location:'.$getURI);
	}

	//Submit Peripheral Report
	if(isset($_POST['submit_report'])){
		echo $newPeripheralID = $_POST['peripheral_id'];
		echo $remarks = $_POST['status'];
		echo $condition = $_POST['condition'];

		$mysqli->query("UPDATE peripherals SET remarks='$remarks', peripheral_condition='$condition' WHERE peripheral_id='$newPeripheralID'") or die ($mysqli->error());

		$_SESSION['message'] = "Problem Reported Successfully!";
		$_SESSION['msg_type'] = "success";
		header('location:'.$getURI);
	}
	//Submit Peripheral Fix Report
	if(isset($_POST['submit_fix_report'])){
		echo $newPeripheralID = $_POST['peripheral_id'];
		echo $remarks = $_POST['status'];
		echo $condition = $_POST['condition'];
		
		$mysqli->query("UPDATE peripherals SET remarks='$remarks', peripheral_condition='$condition' WHERE peripheral_id='$newPeripheralID'") or die ($mysqli->error());

		$_SESSION['message'] = "PC Component's new details has been saved!";
		$_SESSION['msg_type'] = "success";
		header('location: for_repair.php');
	}
?>