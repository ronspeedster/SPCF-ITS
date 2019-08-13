<?php
	include 'dbh.php';
	$date = date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d H:i:s');

	$serial_no='';

	$vowels = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
	$batchID = date_default_timezone_set('Asia/Manila');
	$batchID = date('ymdHi');	
	if(isset($_POST['save'])){
		echo $building_id =  $_POST['building'];
		echo $laboratory_id =  $_POST['laboratory'];
		echo $type =  $_POST['type'];
		echo $qty =  $_POST['qty'];
		echo $batchID = strtoupper(str_replace(" ", "", $type).$batchID);
		$startNo = 1;
		while($startNo<=$qty){
		$mysqli->query("INSERT INTO fixture (type, batch_code, building_id, lab_id, date_added, remarks) VALUES('$type','$batchID','$building_id','$laboratory_id','$date','OK')") or die($mysqli->error());
			$startNo++;
		}

		$_SESSION['message'] = "Fixtures has been added!";
		$_SESSION['msg_type'] = "success";
		header('location: fixtures.php');
	}
	//Update Ficture Details
	if(isset($_POST['update'])){
		echo $building_id =  $_POST['building_id'];
		echo $laboratory_id =  $_POST['lab_id'];
		echo $serial_no = strtoupper($_POST['serial_no']);
		echo $fixture_id = $_POST['fixture_id'];
		$mysqli->query("UPDATE fixture SET building_id = '$building_id', serial_no = '$serial_no', lab_id='$laboratory_id' WHERE id='$fixture_id' ") or die($mysqli->error());
		$_SESSION['message'] = "Fixture has been updated!";
		$_SESSION['msg_type'] = "success";

		header('location: fixtures.php');
	}
	
	//Delete Fixture
	if(isset($_GET['delete'])){
		$fixture_id = $_GET['delete'];
		$mysqli->query("DELETE FROM fixture WHERE id='$fixture_id'") or die($mysqli->error());
		$_SESSION['message'] = "Fixture has been deleted!";
		$_SESSION['msg_type'] = "danger";

		header('location: fixtures.php');
	}

?>