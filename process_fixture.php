<?php
	include 'dbh.php';
	$date = date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d H:i:s');

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
		$mysqli->query("INSERT INTO fixture (type, batch_code, building_id, lab_id, date_added, remarks) VALUES('$type','$batchID','$building_id','$laboratory_id','$date','OK')");
			$startNo++;
		}

		$_SESSION['message'] = "Fixtures has been added!";
		$_SESSION['msg_type'] = "success";
		header('location: fixtures.php');
	}
?>