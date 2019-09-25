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
		
		$mysqli->query("UPDATE fixture SET serial_no = '$serial_no', date_last_clean='$date_last_clean' WHERE id='$fixture_id' ") or die($mysqli->error());

		//Updated 2019-09-17
		//Updated 2019-09-25
		$checkType = $mysqli->query("SELECT * FROM aircon WHERE aircon_id= '$fixture_id' ") or die($mysqli->error());

		if(mysqli_num_rows($checkType)==0){
			$mysqli->query("INSERT INTO aircon (aircon_id, brand, type) VALUES('$fixture_id','$brand','$ac_type') ") or die($mysqli->error());
		}
		else{
			$mysqli->query("UPDATE aircon SET brand = '$brand', type = '$ac_type' WHERE aircon_id = '$fixture_id' ") or die($mysqli->error());
		}


		$_SESSION['message'] = "Fixture has been updated!";
		$_SESSION['msg_type'] = "success";

		header('location: aircon.php');
	}
?>