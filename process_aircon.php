<?php
	include('dbh.php');

		if(isset($_POST['update'])){
		echo $building_id =  $_POST['building_id'];
		echo $serial_no = strtoupper($_POST['serial_no']);
		echo $fixture_id = $_POST['fixture_id'];
		echo $date_last_clean = $_POST['date_last_clean'];

		// Updated 2019-09-17
		echo $brand = $_POST['brand'];
		echo $ac_type = $_POST['ac_type'];
		
		$mysqli->query("UPDATE fixture SET building_id = '$building_id', serial_no = '$serial_no', date_last_clean='$date_last_clean' WHERE id='$fixture_id' ") or die($mysqli->error());

		//Updated 2019-09-17
		$mysqli->query("INSERT INTO aircon (aircon_id, brand, type) VALUES('$fixture_id','$brand','$ac_type') ") or die($mysqli->error());

		$_SESSION['message'] = "Fixture has been updated!";
		$_SESSION['msg_type'] = "success";

		header('location: aircon.php');
	}
?>